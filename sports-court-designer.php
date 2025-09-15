<?php
/**
 * Plugin Name: Sports Court Designer
 * Plugin URI: https://github.com/HaykSaakian/wp-court-designer
 * Description: Interactive sports court designer for tennis, basketball, and pickleball courts with customizable colors
 * Version: 1.5.0
 * Author: Hayk Saakian
 * Author URI: https://github.com/HaykSaakian
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: sports-court-designer
 */

if (!defined('ABSPATH')) {
    exit;
}

define('COURT_DESIGNER_VERSION', '1.5.0');
define('COURT_DESIGNER_URL', plugin_dir_url(__FILE__));
define('COURT_DESIGNER_PATH', plugin_dir_path(__FILE__));

class CourtDesigner {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        add_action('init', array($this, 'init'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_shortcode('court_designer', array($this, 'render_shortcode'));
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('init', array($this, 'register_block'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        
        // Add Settings link on plugins page
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'add_plugin_action_links'));
    }
    
    public function init() {
        // Migrate old logo URL to attachment ID if needed
        $this->migrate_logo_setting();
    }
    
    private function migrate_logo_setting() {
        // Check if we have an old logo URL but no logo ID
        $old_logo_url = get_option('court_designer_logo_url', '');
        $logo_id = get_option('court_designer_logo_id', 0);
        
        if ($old_logo_url && !$logo_id) {
            // Try to find the attachment ID from the URL using WordPress function
            $attachment_id = attachment_url_to_postid($old_logo_url);
            
            if ($attachment_id) {
                update_option('court_designer_logo_id', $attachment_id);
            }
            
            // Clean up old option
            delete_option('court_designer_logo_url');
        }
    }
    
    public function enqueue_scripts() {
        global $post;
        
        if (is_a($post, 'WP_Post') && (has_shortcode($post->post_content, 'court_designer') || has_block('court-designer/designer', $post))) {
            wp_enqueue_style(
                'court-designer-style',
                COURT_DESIGNER_URL . 'assets/css/style.css',
                array(),
                COURT_DESIGNER_VERSION
            );
            
            wp_enqueue_script(
                'court-designer-script',
                COURT_DESIGNER_URL . 'assets/js/designer.js',
                array(),
                COURT_DESIGNER_VERSION,
                true
            );
            
            $colors_json = @file_get_contents(COURT_DESIGNER_PATH . 'assets/data/colors.json');
            $colors = $colors_json ? json_decode($colors_json, true) : array();
            
            // Validate colors array
            if (!is_array($colors)) {
                $colors = array();
            }
            
            // Get logo URL from attachment ID
            $logo_id = get_option('court_designer_logo_id', 0);
            $logo_url = $logo_id ? wp_get_attachment_url($logo_id) : '';
            
            wp_localize_script('court-designer-script', 'courtDesignerData', array(
                'pluginUrl' => COURT_DESIGNER_URL,
                'colors' => $colors,
                'logoUrl' => $logo_url,
                'strings' => array(
                    'court' => __('Court', 'sports-court-designer'),
                    'border' => __('Border', 'sports-court-designer'),
                    'lines' => __('Lines', 'sports-court-designer'),
                    'threePointArea' => __('3-Point Area', 'sports-court-designer'),
                    'key' => __('Key', 'sports-court-designer'),
                    'topOfKey' => __('Top of Key', 'sports-court-designer'),
                    'centerCourtCircle' => __('Center Court Circle', 'sports-court-designer'),
                    'nonVolleyZone' => __('Non-Volley Zone', 'sports-court-designer'),
                    'primaryLines' => __('Primary Lines', 'sports-court-designer'),
                    'secondaryLines' => __('Secondary Lines', 'sports-court-designer'),
                    'reset' => __('Reset', 'sports-court-designer'),
                    'changeCourt' => __('Change Court', 'sports-court-designer'),
                    'download' => __('Download Design', 'sports-court-designer'),
                    'colorNote' => __('Note: Colors may vary from actual product. Some pigments may have higher cost.', 'sports-court-designer')
                )
            ));
        }
    }
    
    public function render_shortcode($atts) {
        $atts = shortcode_atts(array(
            'type' => 'tennis'
        ), $atts, 'court_designer');
        
        $valid_types = array(
            'tennis', 'basketball', 'pickleball',
            'tennis-1pb', 'tennis-2pb', 'tennis-4pb',
            '2pb-tennis'
        );
        
        if (!in_array($atts['type'], $valid_types)) {
            $atts['type'] = 'tennis';
        }
        
        ob_start();
        $template_path = COURT_DESIGNER_PATH . 'templates/designer-template.php';
        if (file_exists($template_path)) {
            include $template_path;
        } else {
            echo '<p>' . esc_html__('Court designer template not found.', 'sports-court-designer') . '</p>';
        }
        return ob_get_clean();
    }
    
    public function add_admin_menu() {
        add_options_page(
            __('Sports Court Designer Settings', 'sports-court-designer'),
            __('Sports Court Designer', 'sports-court-designer'),
            'manage_options',
            'court-designer-settings',
            array($this, 'settings_page')
        );
    }
    
    public function settings_page() {
        $settings_path = COURT_DESIGNER_PATH . 'admin/settings-page.php';
        if (file_exists($settings_path)) {
            include $settings_path;
        } else {
            echo '<p>' . esc_html__('Settings page not found.', 'sports-court-designer') . '</p>';
        }
    }
    
    public function register_block() {
        if (!function_exists('register_block_type')) {
            return;
        }
        
        wp_register_script(
            'court-designer-block',
            COURT_DESIGNER_URL . 'assets/js/block.js',
            array('wp-blocks', 'wp-element', 'wp-editor'),
            COURT_DESIGNER_VERSION,
            true
        );
        
        register_block_type('court-designer/designer', array(
            'editor_script' => 'court-designer-block',
            'render_callback' => array($this, 'render_block'),
            'attributes' => array(
                'courtType' => array(
                    'type' => 'string',
                    'default' => 'tennis'
                )
            )
        ));
    }
    
    public function render_block($attributes) {
        return $this->render_shortcode(array('type' => $attributes['courtType']));
    }
    
    public function add_plugin_action_links($links) {
        $settings_link = '<a href="' . admin_url('options-general.php?page=court-designer-settings') . '">' . __('Settings', 'sports-court-designer') . '</a>';
        array_unshift($links, $settings_link);
        return $links;
    }
    
    public function enqueue_admin_scripts($hook) {
        if ('settings_page_court-designer-settings' !== $hook) {
            return;
        }
        
        wp_enqueue_media();
        
        // Enqueue our admin settings script
        wp_enqueue_script(
            'court-designer-admin',
            COURT_DESIGNER_URL . 'assets/js/admin-settings.js',
            array('jquery', 'media-upload'),
            COURT_DESIGNER_VERSION,
            true
        );
        
        // Localize script with translatable strings
        wp_localize_script('court-designer-admin', 'courtDesignerAdmin', array(
            'chooseLogoText' => __('Choose Logo', 'sports-court-designer'),
            'useLogoText' => __('Use this logo', 'sports-court-designer')
        ));
    }
}

CourtDesigner::get_instance();