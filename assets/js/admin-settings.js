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
            title: courtDesignerAdmin.chooseLogoText,
            button: {
                text: courtDesignerAdmin.useLogoText
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