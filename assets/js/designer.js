(function() {
    'use strict';
    
    class CourtDesigner {
        constructor(container) {
            this.container = container;
            this.courtType = container.dataset.courtType || 'tennis';
            this.colors = window.courtDesignerData.colors;
            this.strings = window.courtDesignerData.strings;
            this.pluginUrl = window.courtDesignerData.pluginUrl;
            this.logoUrl = window.courtDesignerData.logoUrl || null;
            
            this.areas = this.getAreasForCourt(this.courtType);
            this.currentArea = this.areas[0];
            this.colorState = {};
            
            this.initializeDefaultColors();
            this.loadSVG();
            this.bindEvents();
        }
        
        getAreasForCourt(courtType) {
            const areaMap = {
                tennis: ['court', 'border'],
                basketball: ['court', 'border', 'threePointArea', 'key', 'topOfKey', 'centerCourtCircle'],
                pickleball: ['court', 'border', 'nonVolleyZone']
            };
            return areaMap[courtType] || areaMap.tennis;
        }
        
        initializeDefaultColors() {
            // Set better default colors for each court type
            const defaultColors = {
                tennis: {
                    court: '#0066CC', // Blue
                    border: '#228B22'  // Forest Green
                },
                basketball: {
                    court: '#D2691E', // Tan/Wood color (Sandstone-like)
                    border: '#228B22', // Forest Green
                    threePointArea: '#CC0000', // Red
                    key: '#0066CC', // Blue
                    topOfKey: '#663399', // Tournament Purple
                    centerCourtCircle: '#800000' // Maroon
                },
                pickleball: {
                    court: '#0066CC', // Blue
                    border: '#228B22', // Forest Green
                    nonVolleyZone: '#FFD700' // Yellow (for kitchen)
                }
            };
            
            const courtDefaults = defaultColors[this.courtType] || {};
            
            this.areas.forEach(area => {
                // Use court-specific default or fall back to first color
                this.colorState[area] = courtDefaults[area] || this.colors[0].hex;
            });
        }
        
        loadSVG() {
            const svgUrl = `${this.pluginUrl}assets/images/courts/${this.courtType}.svg?v=${Date.now()}`;
            const previewContainer = this.container.querySelector('.court-designer-preview');
            
            fetch(svgUrl)
                .then(response => response.text())
                .then(svgText => {
                    previewContainer.innerHTML = svgText;
                    this.svgElement = previewContainer.querySelector('svg');
                    this.applyColors();
                    this.updateLogo();
                    this.updateColorIndicators();
                    this.updateCurrentColorName();
                    this.updateSelectedSwatch();
                })
                .catch(error => {
                    console.error('Error loading SVG:', error);
                    previewContainer.innerHTML = '<p>Error loading court image</p>';
                });
        }
        
        bindEvents() {
            // Area tab selection
            this.container.addEventListener('click', (e) => {
                if (e.target.classList.contains('area-tab')) {
                    this.selectArea(e.target.dataset.area);
                }
                
                if (e.target.classList.contains('color-swatch') || e.target.closest('.color-swatch')) {
                    const swatch = e.target.classList.contains('color-swatch') ? e.target : e.target.closest('.color-swatch');
                    this.selectColor(swatch.dataset.color);
                }
            });
            
            // Court type change
            const courtSelector = this.container.querySelector('#court-type-select');
            if (courtSelector) {
                courtSelector.addEventListener('change', (e) => {
                    this.changeCourtType(e.target.value);
                });
            }
            
            // Reset button
            const resetBtn = this.container.querySelector('.btn-reset');
            if (resetBtn) {
                resetBtn.addEventListener('click', () => {
                    this.reset();
                });
            }
            
            // Download button
            const downloadBtn = this.container.querySelector('.btn-download');
            if (downloadBtn) {
                downloadBtn.addEventListener('click', () => {
                    this.downloadDesign();
                });
            }
            
            // Logo upload removed - now handled in admin settings only
        }
        
        selectArea(area) {
            this.currentArea = area;
            
            // Update UI
            this.container.querySelectorAll('.area-tab').forEach(tab => {
                tab.classList.toggle('active', tab.dataset.area === area);
            });
            
            // Update selected color swatch and current color name
            this.updateSelectedSwatch();
            this.updateCurrentColorName();
        }
        
        selectColor(colorHex) {
            this.colorState[this.currentArea] = colorHex;
            this.applyColors();
            this.updateSelectedSwatch();
            this.updateCurrentColorName();
            this.updateColorIndicators();
        }
        
        updateSelectedSwatch() {
            const currentColor = this.colorState[this.currentArea];
            this.container.querySelectorAll('.color-swatch').forEach(swatch => {
                swatch.classList.toggle('active', swatch.dataset.color === currentColor);
            });
        }
        
        updateCurrentColorName() {
            const currentColor = this.colorState[this.currentArea];
            const colorNameElement = this.container.querySelector('.current-color-name');
            
            if (colorNameElement) {
                // Find the color name from the colors array
                const colorObj = this.colors.find(c => c.hex === currentColor);
                colorNameElement.textContent = colorObj ? colorObj.name : '';
            }
        }
        
        updateColorIndicators() {
            // Update all color indicators to show the current color for each area
            this.container.querySelectorAll('.area-color-indicator').forEach(indicator => {
                const area = indicator.dataset.area;
                if (this.colorState[area]) {
                    indicator.style.backgroundColor = this.colorState[area];
                }
            });
        }
        
        applyColors() {
            if (!this.svgElement) return;
            
            Object.keys(this.colorState).forEach(area => {
                const element = this.svgElement.querySelector(`#${area}`);
                if (element) {
                    if (element.tagName === 'g') {
                        // For grouped elements, apply to all children
                        element.querySelectorAll('*').forEach(child => {
                            if (child.hasAttribute('fill')) {
                                child.setAttribute('fill', this.colorState[area]);
                            }
                        });
                    } else {
                        element.setAttribute('fill', this.colorState[area]);
                    }
                }
            });
            
            // Update logo background to match border color
            const logoBackground = this.svgElement.querySelector('#logoBackground');
            if (logoBackground && this.colorState.border) {
                logoBackground.setAttribute('fill', this.colorState.border);
            }
        }
        
        changeCourtType(newType) {
            this.courtType = newType;
            this.areas = this.getAreasForCourt(newType);
            this.currentArea = this.areas[0];
            this.colorState = {};
            this.initializeDefaultColors();
            this.loadSVG();
            
            // Rebuild area tabs
            this.rebuildAreaTabs();
        }
        
        rebuildAreaTabs() {
            const tabsContainer = this.container.querySelector('.area-tabs');
            if (!tabsContainer) return;
            
            tabsContainer.innerHTML = '';
            this.areas.forEach((area, index) => {
                const tab = document.createElement('button');
                tab.className = 'area-tab';
                if (index === 0) tab.classList.add('active');
                tab.dataset.area = area;
                tab.textContent = this.strings[area] || area;
                tabsContainer.appendChild(tab);
            });
        }
        
        reset() {
            this.initializeDefaultColors();
            this.applyColors();
            this.updateSelectedSwatch();
        }
        
        downloadDesign() {
            if (!this.svgElement) return;
            
            const svgData = new XMLSerializer().serializeToString(this.svgElement);
            const svgBlob = new Blob([svgData], { type: 'image/svg+xml;charset=utf-8' });
            const svgUrl = URL.createObjectURL(svgBlob);
            
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            const img = new Image();
            
            img.onload = () => {
                canvas.width = img.width;
                canvas.height = img.height;
                ctx.drawImage(img, 0, 0);
                
                canvas.toBlob((blob) => {
                    const url = URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.download = `court-design-${this.courtType}-${Date.now()}.png`;
                    link.href = url;
                    link.click();
                    URL.revokeObjectURL(url);
                });
                
                URL.revokeObjectURL(svgUrl);
            };
            
            img.src = svgUrl;
        }
        
        updateLogo() {
            if (!this.svgElement) return;
            
            const logoElement = this.svgElement.querySelector('#courtLogo');
            if (logoElement) {
                if (this.logoUrl) {
                    logoElement.setAttribute('href', this.logoUrl);
                    logoElement.style.display = 'block';
                } else {
                    // Hide logo if none set
                    logoElement.style.display = 'none';
                }
            }
        }
        
    }
    
    // Initialize all court designers on the page
    document.addEventListener('DOMContentLoaded', () => {
        const designers = document.querySelectorAll('.court-designer');
        designers.forEach(container => {
            new CourtDesigner(container);
        });
    });
    
    // For Gutenberg block dynamic loading
    if (window.wp && window.wp.domReady) {
        window.wp.domReady(() => {
            const designers = document.querySelectorAll('.court-designer');
            designers.forEach(container => {
                if (!container.dataset.initialized) {
                    new CourtDesigner(container);
                    container.dataset.initialized = 'true';
                }
            });
        });
    }
})();