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
                tennis: ['court', 'border', 'lines'],
                basketball: ['court', 'border', 'threePointArea', 'key', 'topOfKey', 'centerCourtCircle', 'lines'],
                pickleball: ['court', 'border', 'nonVolleyZone', 'lines'],
                // Combo courts - Tennis + Pickleball
                'tennis-1pb': ['court', 'border', 'primaryLines', 'secondaryLines'],
                'tennis-2pb': ['court', 'border', 'primaryLines', 'secondaryLines'],
                'tennis-4pb': ['court', 'border', 'primaryLines', 'secondaryLines'],
                '2pb-tennis': ['court', 'border', 'primaryLines', 'secondaryLines'],
                '4pb-tennis': ['court', 'border', 'primaryLines', 'secondaryLines'],
                // Pickleball + Half Basketball
                'pb-halfbasketball': ['court', 'border', 'nonVolleyZone', 'primaryLines', 'secondaryLines']
            };
            return areaMap[courtType] || areaMap.tennis;
        }
        
        initializeDefaultColors() {
            // Set better default colors for each court type using client's exact colors
            const defaultColors = {
                tennis: {
                    court: '#2e3c5c', // Blue
                    border: '#465138',  // Forest Green
                    lines: '#ffffff' // White lines (primary sport)
                },
                basketball: {
                    court: '#c1a872', // Sandstone
                    border: '#465138', // Forest Green
                    threePointArea: '#6c3838', // Red
                    key: '#2e3c5c', // Blue
                    topOfKey: '#423d61', // Tournament Purple
                    centerCourtCircle: '#583838', // Maroon
                    lines: '#ffffff' // White lines
                },
                pickleball: {
                    court: '#2e3c5c', // Blue
                    border: '#465138', // Forest Green
                    nonVolleyZone: '#ebc553', // Yellow (for kitchen)
                    lines: '#ffffff' // White lines (primary sport)
                },
                // Tennis primary combo courts
                'tennis-1pb': {
                    court: '#2e3c5c', // Blue
                    border: '#465138', // Forest Green
                    primaryLines: '#ffffff', // White for tennis
                    secondaryLines: '#ebc553' // Yellow for pickleball
                },
                'tennis-2pb': {
                    court: '#2e3c5c', // Blue
                    border: '#465138', // Forest Green
                    primaryLines: '#ffffff', // White for tennis
                    secondaryLines: '#ebc553' // Yellow for pickleball
                },
                'tennis-4pb': {
                    court: '#2e3c5c', // Blue
                    border: '#465138', // Forest Green
                    primaryLines: '#ffffff', // White for tennis
                    secondaryLines: '#ebc553' // Yellow for pickleball
                },
                // Pickleball primary combo courts
                '2pb-tennis': {
                    court: '#2e3c5c', // Blue
                    border: '#465138', // Forest Green
                    primaryLines: '#ffffff', // White for pickleball
                    secondaryLines: '#67a3d9' // Light Blue for tennis
                },
                '4pb-tennis': {
                    court: '#2e3c5c', // Blue
                    border: '#465138', // Forest Green
                    primaryLines: '#ffffff', // White for pickleball
                    secondaryLines: '#67a3d9' // Light Blue for tennis
                },
                // Pickleball + Half Basketball
                'pb-halfbasketball': {
                    court: '#2e3c5c', // Blue
                    border: '#465138', // Forest Green
                    nonVolleyZone: '#C0C0C0', // Gray for kitchen
                    primaryLines: '#ffffff', // White for pickleball
                    secondaryLines: '#00CED1' // Cyan for basketball
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
            
            console.log('Loading SVG from:', svgUrl);
            
            fetch(svgUrl)
                .then(response => {
                    console.log('SVG response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.text();
                })
                .then(svgText => {
                    console.log('SVG loaded, length:', svgText.length);
                    previewContainer.innerHTML = svgText;
                    this.svgElement = previewContainer.querySelector('svg');
                    this.applyColors();
                    this.updateLogo();
                    this.updateColorIndicators();
                    this.updateCurrentColorName();
                    this.rebuildColorPalette();
                    this.updateSelectedSwatch();
                })
                .catch(error => {
                    console.error('Error loading SVG:', error);
                    previewContainer.innerHTML = '<p>Error loading court image: ' + error.message + '</p>';
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
            
            // Rebuild color palette with filtered colors
            this.rebuildColorPalette();
            
            // Update selected color swatch and current color name
            this.updateSelectedSwatch();
            this.updateCurrentColorName();
        }
        
        getFilteredColors() {
            // Define which colors are allowed for lines
            const lineColors = [
                'White', 'Black', 
                'Light Blue', 'Blue', 
                'Light Green', 'Forest Green', 'Dark Green',
                'Red', 'Gray', 'Dove Gray', 'Yellow'
            ];
            
            if (this.currentArea === 'lines' || this.currentArea === 'primaryLines' || this.currentArea === 'secondaryLines') {
                // For any type of lines, only show specific colors
                return this.colors.filter(color => lineColors.includes(color.name));
            } else {
                // For fills, exclude white and black
                return this.colors.filter(color => 
                    color.name !== 'White' && color.name !== 'Black'
                );
            }
        }
        
        rebuildColorPalette() {
            const swatchContainer = this.container.querySelector('.color-swatches');
            if (!swatchContainer) return;
            
            swatchContainer.innerHTML = '';
            const filteredColors = this.getFilteredColors();
            
            filteredColors.forEach(color => {
                const swatch = document.createElement('div');
                swatch.className = 'color-swatch';
                swatch.dataset.color = color.hex;
                swatch.title = color.name;
                
                const inner = document.createElement('div');
                inner.className = 'color-swatch-inner';
                inner.style.backgroundColor = color.hex;
                
                const tooltip = document.createElement('span');
                tooltip.className = 'color-name-tooltip';
                tooltip.textContent = color.name;
                
                swatch.appendChild(inner);
                swatch.appendChild(tooltip);
                swatchContainer.appendChild(swatch);
                
                // Add click handler
                swatch.addEventListener('click', () => {
                    this.selectColor(color.hex);
                });
            });
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
                    if (area === 'lines' || area === 'primaryLines' || area === 'secondaryLines') {
                        // For any type of lines, apply stroke color instead of fill
                        element.setAttribute('stroke', this.colorState[area]);
                        // Also update stroke for all child elements
                        element.querySelectorAll('*').forEach(child => {
                            if (child.hasAttribute('stroke')) {
                                child.setAttribute('stroke', this.colorState[area]);
                            }
                        });
                    } else if (element.tagName === 'g') {
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
            
            // Rebuild color palette for the new court type
            this.rebuildColorPalette();
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
                
                // Add color indicator span
                const indicator = document.createElement('span');
                indicator.className = 'area-color-indicator';
                indicator.dataset.area = area;
                indicator.style.backgroundColor = this.colorState[area] || '#ddd';
                
                tab.appendChild(indicator);
                tab.appendChild(document.createTextNode(this.strings[area] || area));
                tabsContainer.appendChild(tab);
            });
        }
        
        reset() {
            this.initializeDefaultColors();
            this.applyColors();
            this.updateSelectedSwatch();
            this.updateColorIndicators();
            this.updateCurrentColorName();
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
    function initializeDesigners() {
        const designers = document.querySelectorAll('.court-designer');
        console.log('Initializing ' + designers.length + ' court designer(s)');
        designers.forEach(container => {
            new CourtDesigner(container);
        });
    }
    
    // Check if DOM is already loaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeDesigners);
    } else {
        // DOM is already loaded (script loaded dynamically)
        initializeDesigners();
    }
    
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