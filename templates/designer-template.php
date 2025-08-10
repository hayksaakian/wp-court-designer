<?php
if (!defined('ABSPATH')) {
    exit;
}

$court_type = isset($atts['type']) ? esc_attr($atts['type']) : 'tennis';
$colors = json_decode(file_get_contents(COURT_DESIGNER_PATH . 'assets/data/colors.json'), true);

// Define areas for each court type
$court_areas = array(
    'tennis' => array(
        'court' => __('Court', 'court-designer'),
        'border' => __('Border', 'court-designer')
    ),
    'basketball' => array(
        'court' => __('Court', 'court-designer'),
        'border' => __('Border', 'court-designer'),
        'threePointArea' => __('3-Point Area', 'court-designer'),
        'key' => __('Key', 'court-designer'),
        'topOfKey' => __('Top of Key', 'court-designer'),
        'centerCourtCircle' => __('Center Court Circle', 'court-designer')
    ),
    'pickleball' => array(
        'court' => __('Court', 'court-designer'),
        'border' => __('Border', 'court-designer'),
        'nonVolleyZone' => __('Non-Volley Zone', 'court-designer')
    )
);

$areas = isset($court_areas[$court_type]) ? $court_areas[$court_type] : $court_areas['tennis'];
?>

<div class="court-designer" data-court-type="<?php echo esc_attr($court_type); ?>">
    <div class="court-designer-header">
        <h2 class="court-designer-title"><?php _e('Court Designer', 'court-designer'); ?></h2>
        <div class="court-type-selector">
            <select id="court-type-select">
                <option value="tennis" <?php selected($court_type, 'tennis'); ?>><?php _e('Tennis', 'court-designer'); ?></option>
                <option value="basketball" <?php selected($court_type, 'basketball'); ?>><?php _e('Basketball', 'court-designer'); ?></option>
                <option value="pickleball" <?php selected($court_type, 'pickleball'); ?>><?php _e('Pickleball', 'court-designer'); ?></option>
            </select>
        </div>
    </div>
    
    <div class="court-designer-container">
        <div class="court-designer-preview">
            <!-- SVG will be loaded here by JavaScript -->
        </div>
        
        <div class="court-designer-controls">
            <div class="area-selector">
                <h3 class="area-selector-title"><?php _e('Select Area to Color', 'court-designer'); ?></h3>
                <div class="area-tabs">
                    <?php 
                    $first = true;
                    foreach ($areas as $area_key => $area_label) : 
                    ?>
                        <button class="area-tab <?php echo $first ? 'active' : ''; ?>" data-area="<?php echo esc_attr($area_key); ?>">
                            <?php echo esc_html($area_label); ?>
                        </button>
                    <?php 
                        $first = false;
                    endforeach; 
                    ?>
                </div>
            </div>
            
            <div class="color-palette">
                <h3 class="color-palette-title"><?php _e('Choose Color', 'court-designer'); ?></h3>
                <div class="color-swatches">
                    <?php foreach ($colors as $color) : ?>
                        <div class="color-swatch" data-color="<?php echo esc_attr($color['hex']); ?>" title="<?php echo esc_attr($color['name']); ?>">
                            <div class="color-swatch-inner" style="background-color: <?php echo esc_attr($color['hex']); ?>;">
                                <?php if (!empty($color['leed']) && $color['leed']['credit']) : ?>
                                    <span class="color-swatch-leed">LEED</span>
                                <?php endif; ?>
                            </div>
                            <span class="color-name-tooltip"><?php echo esc_html($color['name']); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="color-note">
                    <?php _e('Note: Colors may vary from actual product. Some pigments may have higher cost.', 'court-designer'); ?>
                    <?php if (isset($color['note'])) : ?>
                        <br><small><?php echo esc_html($color['note']); ?></small>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="action-buttons">
                <button class="btn btn-secondary btn-reset"><?php _e('Reset Colors', 'court-designer'); ?></button>
                <button class="btn btn-success btn-download"><?php _e('Download Design', 'court-designer'); ?></button>
            </div>
        </div>
    </div>
</div>