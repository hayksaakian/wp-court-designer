<?php
if (!defined('ABSPATH')) {
    exit;
}

// Handle form submission
if (isset($_POST['court_designer_save_settings']) && wp_verify_nonce($_POST['court_designer_nonce'], 'court_designer_settings')) {
    update_option('court_designer_logo_url', sanitize_text_field($_POST['court_designer_logo_url']));
    echo '<div class="notice notice-success is-dismissible"><p>' . __('Settings saved.', 'court-designer') . '</p></div>';
}

$logo_url = get_option('court_designer_logo_url', '');
?>

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    
    <div class="notice notice-info">
        <p><?php _e('Court Designer allows you to embed interactive court designers using the shortcode [court_designer type="tennis|basketball|pickleball"] or the Gutenberg block.', 'court-designer'); ?></p>
    </div>
    
    <form method="post" action="">
        <?php wp_nonce_field('court_designer_settings', 'court_designer_nonce'); ?>
        
        <div class="card">
            <h2><?php _e('Company Logo', 'court-designer'); ?></h2>
            <p><?php _e('Upload your company logo to display on all court designs. This logo will appear at the bottom of the court preview.', 'court-designer'); ?></p>
            
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="court_designer_logo_url"><?php _e('Logo URL', 'court-designer'); ?></label>
                    </th>
                    <td>
                        <input type="text" id="court_designer_logo_url" name="court_designer_logo_url" value="<?php echo esc_attr($logo_url); ?>" class="regular-text" />
                        <button type="button" class="button" id="upload_logo_button"><?php _e('Upload Logo', 'court-designer'); ?></button>
                        <?php if ($logo_url) : ?>
                            <button type="button" class="button" id="remove_logo_button"><?php _e('Remove Logo', 'court-designer'); ?></button>
                        <?php endif; ?>
                        <p class="description"><?php _e('Recommended size: 200x60px. Transparent PNG works best.', 'court-designer'); ?></p>
                        
                        <?php if ($logo_url) : ?>
                            <div style="margin-top: 10px;">
                                <img src="<?php echo esc_url($logo_url); ?>" style="max-width: 200px; height: auto; border: 1px solid #ddd; padding: 5px; background: #fff;" />
                            </div>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
            
            <p class="submit">
                <input type="submit" name="court_designer_save_settings" class="button-primary" value="<?php _e('Save Settings', 'court-designer'); ?>" />
            </p>
        </div>
    </form>
    
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

<script type="text/javascript">
jQuery(document).ready(function($) {
    // Media uploader
    $('#upload_logo_button').click(function(e) {
        e.preventDefault();
        
        var mediaUploader = wp.media({
            title: '<?php _e('Choose Logo', 'court-designer'); ?>',
            button: {
                text: '<?php _e('Use this logo', 'court-designer'); ?>'
            },
            multiple: false
        });
        
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#court_designer_logo_url').val(attachment.url);
            
            // Show preview
            var preview = '<div style="margin-top: 10px;"><img src="' + attachment.url + '" style="max-width: 200px; height: auto; border: 1px solid #ddd; padding: 5px; background: #fff;" /></div>';
            $('#court_designer_logo_url').parent().find('div').remove();
            $('#court_designer_logo_url').parent().append(preview);
            
            // Show remove button
            if (!$('#remove_logo_button').length) {
                $('#upload_logo_button').after(' <button type="button" class="button" id="remove_logo_button"><?php _e('Remove Logo', 'court-designer'); ?></button>');
                bindRemoveButton();
            }
        });
        
        mediaUploader.open();
    });
    
    // Remove logo
    function bindRemoveButton() {
        $('#remove_logo_button').click(function(e) {
            e.preventDefault();
            $('#court_designer_logo_url').val('');
            $('#court_designer_logo_url').parent().find('div').remove();
            $(this).remove();
        });
    }
    
    bindRemoveButton();
});
</script>