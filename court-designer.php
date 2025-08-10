<?php
/**
 * Plugin Name: Court Designer
 * Plugin URI: https://github.com/HaykSaakian/wp-court-designer
 * Description: Interactive court designer for tennis, basketball, and pickleball courts with customizable colors
 * Version: 1.0.0
 * Author: Hayk Saakian
 * Author URI: https://github.com/HaykSaakian
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: court-designer
 */

if (!defined('ABSPATH')) {
    exit;
}

define('COURT_DESIGNER_VERSION', '1.0.0');
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
    }
    
    public function init() {
        load_plugin_textdomain('court-designer', false, dirname(plugin_basename(__FILE__)) . '/languages');
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
            
            $colors_json = file_get_contents(COURT_DESIGNER_PATH . 'assets/data/colors.json');
            $colors = json_decode($colors_json, true);
            
            wp_localize_script('court-designer-script', 'courtDesignerData', array(
                'pluginUrl' => COURT_DESIGNER_URL,
                'colors' => $colors,
                'strings' => array(
                    'court' => __('Court', 'court-designer'),
                    'border' => __('Border', 'court-designer'),
                    'threePointArea' => __('3-Point Area', 'court-designer'),
                    'key' => __('Key', 'court-designer'),
                    'topOfKey' => __('Top of Key', 'court-designer'),
                    'centerCourtCircle' => __('Center Court Circle', 'court-designer'),
                    'nonVolleyZone' => __('Non-Volley Zone', 'court-designer'),
                    'reset' => __('Reset', 'court-designer'),
                    'changeCourt' => __('Change Court', 'court-designer'),
                    'download' => __('Download Design', 'court-designer'),
                    'colorNote' => __('Note: Colors may vary from actual product. Some pigments may have higher cost.', 'court-designer')
                )
            ));
        }
    }
    
    public function render_shortcode($atts) {
        $atts = shortcode_atts(array(
            'type' => 'tennis'
        ), $atts, 'court_designer');
        
        if (!in_array($atts['type'], array('tennis', 'basketball', 'pickleball'))) {
            $atts['type'] = 'tennis';
        }
        
        ob_start();
        include COURT_DESIGNER_PATH . 'templates/designer-template.php';
        return ob_get_clean();
    }
    
    public function add_admin_menu() {
        add_options_page(
            __('Court Designer Settings', 'court-designer'),
            __('Court Designer', 'court-designer'),
            'manage_options',
            'court-designer-settings',
            array($this, 'settings_page')
        );
    }
    
    public function settings_page() {
        include COURT_DESIGNER_PATH . 'admin/settings-page.php';
    }
    
    public function register_block() {
        if (!function_exists('register_block_type')) {
            return;
        }
        
        wp_register_script(
            'court-designer-block',
            COURT_DESIGNER_URL . 'assets/js/block.js',
            array('wp-blocks', 'wp-element', 'wp-editor'),
            COURT_DESIGNER_VERSION
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
}

CourtDesigner::get_instance();