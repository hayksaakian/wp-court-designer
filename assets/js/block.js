(function(blocks, element, blockEditor, components) {
    var el = element.createElement;
    var SelectControl = components.SelectControl;
    var PanelBody = components.PanelBody;
    var InspectorControls = blockEditor.InspectorControls;
    
    blocks.registerBlockType('court-designer/designer', {
        title: 'Court Designer',
        icon: 'art',
        category: 'widgets',
        attributes: {
            courtType: {
                type: 'string',
                default: 'tennis'
            }
        },
        
        edit: function(props) {
            var courtType = props.attributes.courtType;
            
            function onChangeCourtType(newType) {
                props.setAttributes({ courtType: newType });
            }
            
            return [
                el(InspectorControls, {},
                    el(PanelBody, { title: 'Court Designer Settings' },
                        el(SelectControl, {
                            label: 'Court Type',
                            value: courtType,
                            options: [
                                { label: 'Tennis', value: 'tennis' },
                                { label: 'Basketball', value: 'basketball' },
                                { label: 'Pickleball', value: 'pickleball' }
                            ],
                            onChange: onChangeCourtType
                        })
                    )
                ),
                el('div', { className: 'court-designer-block-preview' },
                    el('div', { className: 'court-designer-block-placeholder' },
                        el('h3', {}, 'Court Designer'),
                        el('p', {}, 'Court Type: ' + courtType.charAt(0).toUpperCase() + courtType.slice(1)),
                        el('p', { style: { fontSize: '12px', color: '#666' } }, 
                            'The interactive court designer will be displayed on the front-end.')
                    )
                )
            ];
        },
        
        save: function() {
            return null;
        }
    });
})(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor,
    window.wp.components
);