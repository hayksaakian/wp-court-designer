<?php
if (!defined('ABSPATH')) {
    exit;
}

// Handle form submission
if (isset($_POST['court_designer_save_settings']) && wp_verify_nonce($_POST['court_designer_nonce'], 'court_designer_settings')) {
    // Save logo attachment ID
    $logo_id = isset($_POST['court_designer_logo_id']) ? absint($_POST['court_designer_logo_id']) : 0;
    update_option('court_designer_logo_id', $logo_id);
    
    echo '<div class="notice notice-success is-dismissible"><p>' . __('Settings saved.', 'court-designer') . '</p></div>';
}

$logo_id = get_option('court_designer_logo_id', 0);
$logo_url = $logo_id ? wp_get_attachment_url($logo_id) : '';
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
                        <label><?php _e('Logo Image', 'court-designer'); ?></label>
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
                        
                        <button type="button" class="button" id="upload_logo_button"><?php _e('Select Logo', 'court-designer'); ?></button>
                        <button type="button" class="button" id="remove_logo_button" <?php echo $logo_id ? '' : 'style="display:none;"'; ?>><?php _e('Remove Logo', 'court-designer'); ?></button>
                        
                        <p class="description"><?php _e('Recommended size: 200x60px. Transparent PNG works best.', 'court-designer'); ?></p>
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
    var mediaUploader;
    
    // Media uploader
    $('#upload_logo_button').click(function(e) {
        e.preventDefault();
        
        // If the uploader object has already been created, reopen the dialog
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }
        
        // Create the media frame
        mediaUploader = wp.media({
            title: '<?php _e('Choose Logo', 'court-designer'); ?>',
            button: {
                text: '<?php _e('Use this logo', 'court-designer'); ?>'
            },
            multiple: false,
            library: {
                type: 'image'
            }
        });
        
        // When an image is selected in the media frame
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            
            // Set the attachment ID
            $('#court_designer_logo_id').val(attachment.id);
            
            // Show preview
            $('#logo-preview').attr('src', attachment.url).show();
            
            // Show remove button
            $('#remove_logo_button').show();
        });
        
        // Open the media frame
        mediaUploader.open();
    });
    
    // Remove logo
    $('#remove_logo_button').click(function(e) {
        e.preventDefault();
        
        // Clear the attachment ID
        $('#court_designer_logo_id').val('0');
        
        // Hide preview
        $('#logo-preview').attr('src', '').hide();
        
        // Hide remove button
        $(this).hide();
    });
});
</script>