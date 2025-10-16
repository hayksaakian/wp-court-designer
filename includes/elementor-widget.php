<?php
/**
 * Elementor Sports Court Designer Widget
 *
 * @package CourtDesigner
 * @since 1.7.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Sports Court Designer Elementor Widget
 */
class Court_Designer_Elementor_Widget extends \Elementor\Widget_Base {

    /**
     * Get widget name
     */
    public function get_name() {
        return 'sports-court-designer';
    }

    /**
     * Get widget title
     */
    public function get_title() {
        return esc_html__('Sports Court Designer', 'sports-court-designer');
    }

    /**
     * Get widget icon
     */
    public function get_icon() {
        return 'eicon-image-box';
    }

    /**
     * Get widget categories
     */
    public function get_categories() {
        return ['general'];
    }

    /**
     * Get widget keywords
     */
    public function get_keywords() {
        return ['court', 'sports', 'tennis', 'basketball', 'pickleball', 'designer'];
    }

    /**
     * Register widget controls
     */
    protected function register_controls() {

        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Court Settings', 'sports-court-designer'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Court Type Control
        $this->add_control(
            'court_type',
            [
                'label' => esc_html__('Court Type', 'sports-court-designer'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'tennis',
                'options' => [
                    'tennis' => esc_html__('Tennis', 'sports-court-designer'),
                    'basketball' => esc_html__('Basketball', 'sports-court-designer'),
                    'pickleball' => esc_html__('Pickleball', 'sports-court-designer'),
                    'tennis-1pb' => esc_html__('Tennis + 1 Pickleball', 'sports-court-designer'),
                    'tennis-2pb' => esc_html__('Tennis + 2 Pickleball', 'sports-court-designer'),
                    'tennis-4pb' => esc_html__('Tennis + 4 Pickleball', 'sports-court-designer'),
                    '2pb-tennis' => esc_html__('2 Pickleball + Tennis', 'sports-court-designer'),
                    'pb-halfbasketball' => esc_html__('Pickleball + Half Basketball', 'sports-court-designer'),
                ],
                'description' => esc_html__('Select the type of court to display', 'sports-court-designer'),
            ]
        );

        $this->end_controls_section();

        // Style Section (optional for future enhancements)
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style', 'sports-court-designer'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'style_info',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => esc_html__('Colors are customized by users in the front-end designer interface.', 'sports-court-designer'),
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $court_type = isset($settings['court_type']) ? esc_attr($settings['court_type']) : 'tennis';

        // Use the existing shortcode renderer
        if (class_exists('CourtDesigner')) {
            $instance = CourtDesigner::get_instance();
            echo $instance->render_shortcode(['type' => $court_type]);
        } else {
            echo '<p>' . esc_html__('Court Designer plugin not found.', 'sports-court-designer') . '</p>';
        }
    }

    /**
     * Render widget output in the editor (optional)
     */
    protected function content_template() {
        ?>
        <#
        var courtType = settings.court_type || 'tennis';
        var courtLabel = courtType.charAt(0).toUpperCase() + courtType.slice(1).replace(/-/g, ' ');
        #>
        <div class="court-designer-elementor-preview">
            <div style="background: #f0f0f0; padding: 40px; text-align: center; border: 2px dashed #ccc; border-radius: 4px;">
                <h3 style="margin: 0 0 10px 0; color: #333;">
                    <span class="dashicons dashicons-image-filter" style="font-size: 24px;"></span>
                    <?php echo esc_html__('Sports Court Designer', 'sports-court-designer'); ?>
                </h3>
                <p style="margin: 0; color: #666; font-size: 14px;">
                    <?php echo esc_html__('Court Type:', 'sports-court-designer'); ?> <strong>{{{ courtLabel }}}</strong>
                </p>
                <p style="margin: 10px 0 0 0; color: #999; font-size: 12px;">
                    <?php echo esc_html__('The interactive court designer will be displayed on the front-end.', 'sports-court-designer'); ?>
                </p>
            </div>
        </div>
        <?php
    }
}
