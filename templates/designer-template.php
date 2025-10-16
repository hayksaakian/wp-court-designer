<?php
if (!defined('ABSPATH')) {
    exit;
}

$court_type = isset($atts['type']) ? esc_attr($atts['type']) : 'tennis';

// Load colors with error handling
$colors_json = @file_get_contents(COURT_DESIGNER_PATH . 'assets/data/colors.json');
$colors = $colors_json ? json_decode($colors_json, true) : array();
if (!is_array($colors)) {
    $colors = array();
}

// Define areas for each court type
$court_areas = array(
    'tennis' => array(
        'court' => __('Court', 'sports-court-designer'),
        'border' => __('Border', 'sports-court-designer')
    ),
    'basketball' => array(
        'court' => __('Court', 'sports-court-designer'),
        'border' => __('Border', 'sports-court-designer'),
        'threePointArea' => __('3-Point Area', 'sports-court-designer'),
        'key' => __('Key', 'sports-court-designer'),
        'topOfKey' => __('Top of Key', 'sports-court-designer'),
        'centerCourtCircle' => __('Center Court Circle', 'sports-court-designer')
    ),
    'pickleball' => array(
        'court' => __('Court', 'sports-court-designer'),
        'border' => __('Border', 'sports-court-designer'),
        'nonVolleyZone' => __('Non-Volley Zone', 'sports-court-designer')
    ),
    // Combo courts
    'tennis-1pb' => array(
        'court' => __('Court', 'sports-court-designer'),
        'border' => __('Border', 'sports-court-designer'),
        'primaryLines' => __('Tennis Lines', 'sports-court-designer'),
        'secondaryLines' => __('Pickleball Lines', 'sports-court-designer')
    ),
    'tennis-2pb' => array(
        'court' => __('Court', 'sports-court-designer'),
        'border' => __('Border', 'sports-court-designer'),
        'primaryLines' => __('Tennis Lines', 'sports-court-designer'),
        'secondaryLines' => __('Pickleball Lines', 'sports-court-designer')
    ),
    'tennis-4pb' => array(
        'court' => __('Court', 'sports-court-designer'),
        'border' => __('Border', 'sports-court-designer'),
        'primaryLines' => __('Tennis Lines', 'sports-court-designer'),
        'secondaryLines' => __('Pickleball Lines', 'sports-court-designer')
    ),
    '2pb-tennis' => array(
        'court' => __('Court', 'sports-court-designer'),
        'border' => __('Border', 'sports-court-designer'),
        'primaryLines' => __('Pickleball Lines', 'sports-court-designer'),
        'secondaryLines' => __('Tennis Lines', 'sports-court-designer')
    ),
    'pb-halfbasketball' => array(
        'court' => __('Court', 'sports-court-designer'),
        'border' => __('Border', 'sports-court-designer'),
        'nonVolleyZone' => __('Non-Volley Zone', 'sports-court-designer'),
        'primaryLines' => __('Pickleball Lines', 'sports-court-designer'),
        'secondaryLines' => __('Basketball Lines', 'sports-court-designer')
    ),
);

$areas = isset($court_areas[$court_type]) ? $court_areas[$court_type] : $court_areas['tennis'];
?>

<div class="court-designer" data-court-type="<?php echo esc_attr($court_type); ?>">
    <div class="court-designer-header">
        <h2 class="court-designer-title"><?php echo esc_html__('Sports Court Designer', 'sports-court-designer'); ?></h2>
        <div class="court-type-selector">
            <select id="court-type-select">
                <option value="tennis" <?php selected($court_type, 'tennis'); ?>><?php echo esc_html__('Tennis', 'sports-court-designer'); ?></option>
                <option value="basketball" <?php selected($court_type, 'basketball'); ?>><?php echo esc_html__('Basketball', 'sports-court-designer'); ?></option>
                <option value="pickleball" <?php selected($court_type, 'pickleball'); ?>><?php echo esc_html__('Pickleball', 'sports-court-designer'); ?></option>
                <optgroup label="<?php echo esc_attr__('Combo Courts', 'sports-court-designer'); ?>">
                    <option value="tennis-1pb" <?php selected($court_type, 'tennis-1pb'); ?>><?php echo esc_html__('Tennis + 1 Pickleball', 'sports-court-designer'); ?></option>
                    <option value="tennis-2pb" <?php selected($court_type, 'tennis-2pb'); ?>><?php echo esc_html__('Tennis + 2 Pickleball', 'sports-court-designer'); ?></option>
                    <option value="tennis-4pb" <?php selected($court_type, 'tennis-4pb'); ?>><?php echo esc_html__('Tennis + 4 Pickleball', 'sports-court-designer'); ?></option>
                    <option value="2pb-tennis" <?php selected($court_type, '2pb-tennis'); ?>><?php echo esc_html__('2 Pickleball + Tennis', 'sports-court-designer'); ?></option>
                    <option value="pb-halfbasketball" <?php selected($court_type, 'pb-halfbasketball'); ?>><?php echo esc_html__('Pickleball + Half Basketball', 'sports-court-designer'); ?></option>
                </optgroup>
            </select>
        </div>
    </div>
    
    <div class="court-designer-container">
        <div class="court-designer-preview">
            <!-- SVG will be loaded here by JavaScript -->
        </div>
        
        <div class="court-designer-controls">
            <div class="area-selector">
                <h3 class="area-selector-title"><?php echo esc_html__('Select Area to Color', 'sports-court-designer'); ?></h3>
                <div class="area-tabs">
                    <?php 
                    $first = true;
                    foreach ($areas as $area_key => $area_label) : 
                    ?>
                        <button class="area-tab <?php echo $first ? 'active' : ''; ?>" data-area="<?php echo esc_attr($area_key); ?>">
                            <span class="area-color-indicator" data-area="<?php echo esc_attr($area_key); ?>"></span>
                            <?php echo esc_html($area_label); ?>
                        </button>
                    <?php 
                        $first = false;
                    endforeach; 
                    ?>
                </div>
            </div>
            
            <div class="color-palette">
                <h3 class="color-palette-title">
                    <?php echo esc_html__('Choose a Color', 'sports-court-designer'); ?>
                    <span class="current-color-name"></span>
                </h3>
                <div class="color-swatches">
                    <?php foreach ($colors as $color) : ?>
                        <div class="color-swatch" data-color="<?php echo esc_attr($color['hex']); ?>" title="<?php echo esc_attr($color['name']); ?>">
                            <div class="color-swatch-inner" style="background-color: <?php echo esc_attr($color['hex']); ?>;">
                            </div>
                            <span class="color-name-tooltip"><?php echo esc_html($color['name']); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="color-note">
                    <?php echo esc_html__('Note: Colors may vary from actual product. Some pigments may have higher cost.', 'sports-court-designer'); ?>
                    <?php if (isset($color['note'])) : ?>
                        <br><small><?php echo esc_html($color['note']); ?></small>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="action-buttons">
                <button class="btn btn-secondary btn-reset"><?php echo esc_html__('Reset Colors', 'sports-court-designer'); ?></button>
                <button class="btn btn-success btn-download"><?php echo esc_html__('Download Design', 'sports-court-designer'); ?></button>
            </div>
        </div>
    </div>
</div>