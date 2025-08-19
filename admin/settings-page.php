<?php
if (!defined('ABSPATH')) {
    exit;
}

// Handle form submission
if (isset($_POST['court_designer_save_settings']) && isset($_POST['court_designer_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['court_designer_nonce'])), 'court_designer_settings')) {
    // Save logo attachment ID
    $logo_id = isset($_POST['court_designer_logo_id']) ? absint($_POST['court_designer_logo_id']) : 0;
    update_option('court_designer_logo_id', $logo_id);
    
    echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('Settings saved.', 'sports-court-designer') . '</p></div>';
}

$logo_id = get_option('court_designer_logo_id', 0);
$logo_url = $logo_id ? wp_get_attachment_url($logo_id) : '';
?>

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    
    <div class="notice notice-info">
        <p><?php echo esc_html__('Sports Court Designer allows you to embed interactive court designers using the shortcode [court_designer type="tennis|basketball|pickleball"] or the Gutenberg block.', 'sports-court-designer'); ?></p>
    </div>
    
    <form method="post" action="">
        <?php wp_nonce_field('court_designer_settings', 'court_designer_nonce'); ?>
        
        <div class="card">
            <h2><?php echo esc_html__('Company Logo', 'sports-court-designer'); ?></h2>
            <p><?php echo esc_html__('Upload your company logo to display on all court designs. This logo will appear at the bottom of the court preview.', 'sports-court-designer'); ?></p>
            
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label><?php echo esc_html__('Logo Image', 'sports-court-designer'); ?></label>
                    </th>
                    <td>
                        <input type="hidden" id="court_designer_logo_id" name="court_designer_logo_id" value="<?php echo esc_attr($logo_id); ?>" />
                        
                        <div id="logo-preview-wrapper">
                            <?php if ($logo_url) : ?>
                                <img id="logo-preview" src="<?php echo esc_url($logo_url); ?>" style="max-width: 200px; height: auto; border: 1px solid #ddd; padding: 5px; background: #fff; margin-bottom: 10px; display: block;" />
                            <?php else : ?>
                                <img id="logo-preview" src="" style="max-width: 200px; height: auto; border: 1px solid #ddd; padding: 5px; background: #fff; margin-bottom: 10px; display: none;" />
                            <?php endif; ?>
                        </div>
                        
                        <button type="button" class="button" id="upload_logo_button"><?php echo esc_html__('Select Logo', 'sports-court-designer'); ?></button>
                        <button type="button" class="button" id="remove_logo_button" <?php echo $logo_id ? '' : 'style="display:none;"'; ?>><?php echo esc_html__('Remove Logo', 'sports-court-designer'); ?></button>
                        
                        <p class="description"><?php echo esc_html__('Recommended size: 200x60px. Transparent PNG works best.', 'sports-court-designer'); ?></p>
                    </td>
                </tr>
            </table>
            
            <p class="submit">
                <input type="submit" name="court_designer_save_settings" class="button-primary" value="<?php echo esc_attr__('Save Settings', 'sports-court-designer'); ?>" />
            </p>
        </div>
    </form>
    
    <div class="card">
        <h2><?php echo esc_html__('Usage', 'sports-court-designer'); ?></h2>
        <h3><?php echo esc_html__('Shortcode', 'sports-court-designer'); ?></h3>
        <p><code>[court_designer type="tennis"]</code> - <?php echo esc_html__('Tennis court designer', 'sports-court-designer'); ?></p>
        <p><code>[court_designer type="basketball"]</code> - <?php echo esc_html__('Basketball court designer', 'sports-court-designer'); ?></p>
        <p><code>[court_designer type="pickleball"]</code> - <?php echo esc_html__('Pickleball court designer', 'sports-court-designer'); ?></p>
        
        <h3><?php echo esc_html__('Gutenberg Block', 'sports-court-designer'); ?></h3>
        <p><?php echo esc_html__('Search for "Sports Court Designer" in the block editor and select your court type.', 'sports-court-designer'); ?></p>
    </div>
    
    <div class="card">
        <h2><?php echo esc_html__('Available Colors', 'sports-court-designer'); ?></h2>
        <p><?php echo esc_html__('The following colors are available for court customization:', 'sports-court-designer'); ?></p>
        <ul>
            <li>Ice Blue, Light Blue, Blue</li>
            <li>Light Green, Forest Green, Dark Green</li>
            <li>Tournament Purple, Black, Maroon</li>
            <li>Red, Brite Red, Orange, Yellow</li>
            <li>Sandstone, Beige, Dove Gray</li>
            <li>Brown (ColorPlus fusion blend)</li>
        </ul>
        <p class="description"><?php echo esc_html__('Colors can be customized by editing the colors.json file in the plugin assets/data directory.', 'sports-court-designer'); ?></p>
    </div>
    
    <div class="card">
        <h2><?php echo esc_html__('Court Areas', 'sports-court-designer'); ?></h2>
        <h3><?php echo esc_html__('Tennis', 'sports-court-designer'); ?></h3>
        <ul>
            <li><?php echo esc_html__('Court (inner play area)', 'sports-court-designer'); ?></li>
            <li><?php echo esc_html__('Border (outer area)', 'sports-court-designer'); ?></li>
        </ul>
        
        <h3><?php echo esc_html__('Basketball', 'sports-court-designer'); ?></h3>
        <ul>
            <li><?php echo esc_html__('Court', 'sports-court-designer'); ?></li>
            <li><?php echo esc_html__('Border', 'sports-court-designer'); ?></li>
            <li><?php echo esc_html__('3-Point Area', 'sports-court-designer'); ?></li>
            <li><?php echo esc_html__('Key', 'sports-court-designer'); ?></li>
            <li><?php echo esc_html__('Top of Key', 'sports-court-designer'); ?></li>
            <li><?php echo esc_html__('Center Court Circle', 'sports-court-designer'); ?></li>
        </ul>
        
        <h3><?php echo esc_html__('Pickleball', 'sports-court-designer'); ?></h3>
        <ul>
            <li><?php echo esc_html__('Court', 'sports-court-designer'); ?></li>
            <li><?php echo esc_html__('Border', 'sports-court-designer'); ?></li>
            <li><?php echo esc_html__('Non-Volley Zone', 'sports-court-designer'); ?></li>
        </ul>
    </div>
</div>