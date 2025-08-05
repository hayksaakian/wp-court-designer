<?php
if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    
    <div class="notice notice-info">
        <p><?php _e('Court Designer allows you to embed interactive court designers using the shortcode [court_designer type="tennis|basketball|pickleball"] or the Gutenberg block.', 'court-designer'); ?></p>
    </div>
    
    <div class="card">
        <h2><?php _e('Usage', 'court-designer'); ?></h2>
        <h3><?php _e('Shortcode', 'court-designer'); ?></h3>
        <p><code>[court_designer type="tennis"]</code> - <?php _e('Tennis court designer', 'court-designer'); ?></p>
        <p><code>[court_designer type="basketball"]</code> - <?php _e('Basketball court designer', 'court-designer'); ?></p>
        <p><code>[court_designer type="pickleball"]</code> - <?php _e('Pickleball court designer', 'court-designer'); ?></p>
        
        <h3><?php _e('Gutenberg Block', 'court-designer'); ?></h3>
        <p><?php _e('Search for "Court Designer" in the block editor and select your court type.', 'court-designer'); ?></p>
    </div>
    
    <div class="card">
        <h2><?php _e('Available Colors', 'court-designer'); ?></h2>
        <p><?php _e('The following colors are available for court customization:', 'court-designer'); ?></p>
        <ul>
            <li>Ice Blue, Light Blue, Blue</li>
            <li>Light Green, Forest Green, Dark Green</li>
            <li>Tournament Purple, Black, Maroon</li>
            <li>Red, Brite Red, Orange, Yellow</li>
            <li>Sandstone, Beige, Dove Gray</li>
            <li>Brown (ColorPlus fusion blend)</li>
        </ul>
        <p class="description"><?php _e('Colors can be customized by editing the colors.json file in the plugin assets/data directory.', 'court-designer'); ?></p>
    </div>
    
    <div class="card">
        <h2><?php _e('Court Areas', 'court-designer'); ?></h2>
        <h3><?php _e('Tennis', 'court-designer'); ?></h3>
        <ul>
            <li><?php _e('Court (inner play area)', 'court-designer'); ?></li>
            <li><?php _e('Border (outer area)', 'court-designer'); ?></li>
        </ul>
        
        <h3><?php _e('Basketball', 'court-designer'); ?></h3>
        <ul>
            <li><?php _e('Court', 'court-designer'); ?></li>
            <li><?php _e('Border', 'court-designer'); ?></li>
            <li><?php _e('3-Point Area', 'court-designer'); ?></li>
            <li><?php _e('Key', 'court-designer'); ?></li>
            <li><?php _e('Top of Key', 'court-designer'); ?></li>
            <li><?php _e('Center Court Circle', 'court-designer'); ?></li>
        </ul>
        
        <h3><?php _e('Pickleball', 'court-designer'); ?></h3>
        <ul>
            <li><?php _e('Court', 'court-designer'); ?></li>
            <li><?php _e('Border', 'court-designer'); ?></li>
            <li><?php _e('Non-Volley Zone', 'court-designer'); ?></li>
        </ul>
    </div>
</div>