<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/Kovaloff
 * @since      1.0.0
 *
 * @package    Lightening_your_news
 * @subpackage Lightening_your_news/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Lightening_your_news
 * @subpackage Lightening_your_news/public
 * @author     Artem Kovalov <kovaloff1@gmail.com>
 */
class Lightening_your_news_Public
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of the plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Lightening_your_news_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Lightening_your_news_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/lightening_your_news-public.css', array(),
            $this->version, 'all');

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Lightening_your_news_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Lightening_your_news_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/lightening_your_news-public.js',
            array('jquery'), $this->version, false);

        wp_localize_script( $this->plugin_name, 'ajax_object', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
        ));

    }

    /**
     * Register the shortcode for this plugin.
     *
     * @since    1.0.0
     */

    public function render_widget()
    {
        add_shortcode('light_news_ticker', array($this, 'get_light_news_ticker'));
    }

    /**
     * Get our ticker entries by post ID
     *
     * @since    1.0.0
     */

    public function get_light_news_ticker($atts = [], $content = null, $tag = '')
    {

        $atts = array_change_key_case((array)$atts, CASE_LOWER);

        //Here we can override default attributes with user attributes
        $wporg_atts = shortcode_atts([
            'title' => 'Light News',
        ], $atts, $tag);

        $id = $atts['id'];
        // Check if the ticker exists and is published
        $ticker = get_post($id);

        if ($ticker && $ticker->post_status == 'publish') {
            $custom_fields = get_post_custom($id);
            $meta_data = array();
            foreach ($custom_fields as $key => $value) {
                $meta_data[$key] = maybe_unserialize($value[0]);
            }

            $meta_data['ticker_title'] = $ticker->post_title;

            if(isset($meta_data['_lnt_ticks']) && !empty($meta_data['_lnt_ticks'])) {
                return $this->render_news_ticker($id, $meta_data);
            }
        }
    }

    /**
     * Render our ticker
     *
     * @since    1.0.0
     */

    public function render_news_ticker($id, $meta_data)
    {
        $lnt_content_html = '';
        $lnt_content_html .= '<div class="lnt_box lnt_box_' . $id . '">';
        $lnt_content_html .= '<input type="hidden" id="news_ticker_post_id" value="'.$id.'">';
        $lnt_content_html .= '<div class="simple-marquee-container">';
        $lnt_content_html .= '<div class="marquee-sibling">';

        // Check if current user have proper rights to edit ticker
        if (current_user_can('edit_pages')) {
            $lnt_content_html .= '<a class="lnt-edit" href="' . get_edit_post_link($id) . '">' . __('<i class="dashicons-before dashicons-admin-generic"></i>',
                    'light-news-ticker') . '</a>';
        }
        //Ticker Title (Post title)
        $lnt_content_html .= $meta_data['ticker_title'];

        $lnt_content_html .= '</div>';
        $lnt_content_html .= '<div class="marquee">';
        $lnt_content_html .= '<ul class="marquee-content-items">';
        foreach ($meta_data['_lnt_ticks'] as $tick) {
            $lnt_content_html .= "<li>{$tick['tick']}</li>";
        }
        $lnt_content_html .= '</ul>';
        $lnt_content_html .= '</div>';
        $lnt_content_html .= '</div>';
        $lnt_content_html .= '</div>';

        return $lnt_content_html;

    }

    public function my_action_javascript() {

        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            $shortcode = do_shortcode('[light_news_ticker id="'.$_POST['news_ticker_post_id'].'"]');
            echo $shortcode;
            wp_die();

        } else {

            wp_die();
        }

    }
}
