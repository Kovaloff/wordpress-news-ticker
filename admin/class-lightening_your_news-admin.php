<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/Kovaloff
 * @since      1.0.0
 *
 * @package    Lightening_your_news
 * @subpackage Lightening_your_news/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Lightening_your_news
 * @subpackage Lightening_your_news/admin
 * @author     Artem Kovalov <kovaloff1@gmail.com>
 */
class Lightening_your_news_Admin
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
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the admin area.
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

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/lightening_your_news-admin.css', array(),
            $this->version, 'all');

    }

    /**
     * Register the JavaScript for the admin area.
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
        wp_enqueue_script('jquery');
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/lightening_your_news-admin.js',
            array('jquery'), $this->version, false);
        wp_enqueue_script($this->plugin_name, '', array('jquery'), $this->version, false);

    }

    /**
     * Add shortcode to media buttons.
     *
     * @since    1.0.0
     */

    public function lnt_shortcode_button($context)
    {
        $txt = 'Light News';

        //title of the popup window
        $title = 'Light News Ticker';

        $context .= "<a class='button' title='{$title}' onclick='insert_shortcode();'>{$txt}</a>";

        return $context;

    }

    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */

    public function display_plugin_setup_page()
    {
        include_once('partials/lightening_your_news-admin-display.php');
    }

    /**
     * Can be used to store plugin settings
     *
     * @since    1.0.0
     */
    public function options_update()
    {
        register_setting($this->plugin_name, $this->plugin_name);
    }

    /**
     * Register news post type 'light news ticker'
     *
     * @since    1.0.0
     */

    public function lnt_posttype()
    {
        $labels = array(
            'name' => __('News Tickers', 'light-news-ticker'),
            'singular_name' => __('News Ticker', 'light-news-ticker'),
            'add_new' => __('Add New', 'light-news-ticker'),
            'add_new_item' => __('Add New News Ticker', 'light-news-ticker'),
            'edit_item' => __('Edit News Ticker', 'light-news-ticker'),
            'new_item' => __('New News Ticker', 'light-news-ticker'),
            'view_item' => __('View News Ticker', 'light-news-ticker'),
            'search_items' => __('Search News Tickers', 'light-news-ticker'),
            'not_found' => __('No News Tickers Found', 'light-news-ticker'),
            'not_found_in_trash' => __('No News Tickers Found In Trash', 'light-news-ticker'),
            'parent_item_colon' => '',
            'menu_name' => __('Light Ticker', 'light-news-ticker')
        );

        // Create the arguments
        $args = array(
            'labels' => $labels,
            'map_meta_cap' => true,
            'public' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => true,
            'supports' => array('title', 'author'),
            'show_in_nav_menus' => true,
            'capabilities' => array(
                'edit_posts' => 'edit_light_news_tickers',
                'edit_others_posts' => 'edit_others_light_news_tickers',
                'publish_posts' => 'publish_light_news_tickers',
                'read_private_posts' => 'read_private_light_news_tickers',
                'read' => 'read_light_news_tickers',
                'delete_posts' => 'delete_light_news_tickers',
                'delete_private_posts' => 'delete_private_light_news_tickers',
                'delete_published_posts' => 'delete_published_light_news_tickers',
                'delete_others_posts' => 'delete_others_light_news_tickers',
                'edit_private_posts' => 'edit_private_light_news_tickers',
                'edit_published_posts' => 'edit_published_light_news_tickers',
            )
        );

        register_post_type('light_news_ticker', $args);
    }

    /**
     * Set custom caps for out new post type
     *
     * @since    1.0.0
     */

    public function lnt_custom_caps()
    {

        $admins = get_role('administrator');
        $editors = get_role('editor');
        $authors = get_role('author');
        $contributors = get_role('contributor');
        $subscribers = get_role('subscriber');

        if ($admins) {
            $admins->add_cap('edit_light_news_tickers');
            $admins->add_cap('edit_others_light_news_tickers');
            $admins->add_cap('publish_light_news_tickers');
            $admins->add_cap('read_private_light_news_tickers');
            $admins->add_cap('read_light_news_tickers');
            $admins->add_cap('delete_light_news_tickers');
            $admins->add_cap('delete_private_light_news_tickers');
            $admins->add_cap('delete_published_light_news_tickers');
            $admins->add_cap('delete_others_light_news_tickers');
            $admins->add_cap('edit_private_light_news_tickers');
            $admins->add_cap('edit_published_light_news_tickers');
            $admins->add_cap('edit_published_light_news_tickers');
            $admins->add_cap('modify_light_news_ticker_settings');
        }

        if ($editors) {
            $editors->add_cap('edit_light_news_tickers');
            $editors->add_cap('edit_others_light_news_tickers');
            $editors->add_cap('publish_light_news_tickers');
            $editors->add_cap('read_private_light_news_tickers');
            $editors->add_cap('read_light_news_tickers');
            $editors->add_cap('delete_light_news_tickers');
            $editors->add_cap('delete_private_light_news_tickers');
            $editors->add_cap('delete_published_light_news_tickers');
            $editors->add_cap('delete_others_light_news_tickers');
            $editors->add_cap('edit_private_light_news_tickers');
            $editors->add_cap('edit_published_light_news_tickers');
        }

        if ($authors) {
            $authors->add_cap('edit_light_news_tickers');
            $authors->add_cap('publish_light_news_tickers');
            $authors->add_cap('read_light_news_tickers');
            $authors->add_cap('delete_light_news_tickers');
            $authors->add_cap('delete_published_light_news_tickers');
            $authors->add_cap('edit_published_light_news_tickers');
        }

        if ($contributors) {
            $contributors->add_cap('edit_light_news_tickers');
            $contributors->add_cap('read_light_news_tickers');
            $contributors->add_cap('delete_light_news_tickers');
        }

        if ($subscribers) {
            $subscribers->add_cap('read_light_news_tickers');
        }

    }

    /**
     * Display shortcode information
     *
     * @since    1.0.0
     */

    public function lnt_display_shortcode()
    {

        global $post, $typenow;

        if ($typenow == 'light_news_ticker') {

            echo '<div id="lnt-code">';
            echo '<table>';
            echo '<tr>';
            echo '<td id="lnt-shortcode-copy">';
            echo '<div class="wrapper">';
            echo '<h3>' . __('Shortcode', 'light-news-ticker') . '</h3>';
            echo '<p>' . __('Copy and paste this shortcode into a page or post.', 'light-news-ticker') . '</p>';
            echo '<pre><p>[light_news_ticker id="' . $post->ID . '"]</p></pre>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
            echo '</table>';
            echo '</div>';
        }
    }

    /**
     * Init default edit fields
     *
     * @since    1.0.0
     */

    public function init_default_boxes()
    {
        $this->lnt_default_box('lnt_default_box', $this->lnt_default_fields());

    }

    /**
     * Get default fields values
     *
     * @since    1.0.0
     */

    public function lnt_default_values()
    {
        global $post;

        $defaults = array(
            'ticks' => false,
        );

        $defaults = apply_filters('lnt_default_defaults', $defaults);

        $values = array(
            'ticks' => get_post_meta($post->ID, '_lnt_ticks', true),
        );
        foreach ($values as $i => $value) {
            if ($value == '') {
                unset($values[$i]);
            }
        }

        return wp_parse_args($values, $defaults);
    }


    /**
     * Set fields to be shown on the create/edit post page
     *
     * @since    1.0.0
     */

    public function lnt_default_fields()
    {

        $values = $this->lnt_default_values();

        $fields = array(
            'ticks' => array(
                'heading' => __('Ticks', 'light-news-ticker'),
                'type' => 'list',
                'name' => '_lnt_ticks',
                'value' => $values['ticks'],
                'fields' => array(
                    'tick' => array(
                        'heading' => __('News text', 'light-news-ticker'),
                        'type' => 'textarea',
                        'placeholder' => __('Add your text here.',
                            'light-news-ticker'),
                        'rows' => 3
                    ),
                )
            ),

        );

        return apply_filters('lnt_default_fields', $fields, $values);
    }

    /**
     * Create default meta box
     *
     * @since    1.0.0
     */

    public function lnt_default_box($id = '', $fields = false)
    {

        if ($id == '' || !$fields) {
            return;
        }

        // Loop through the fields
        if (is_array($fields) && count($fields) > 0) {
            foreach ($fields as $i => $field) {

                // Set some default values
                $defaults = array(
                    'id' => '',
                    'heading' => '',
                    'type' => '',
                    'name' => '',
                    'value' => ''
                );
                $field = wp_parse_args($field, $defaults);

                $id = (isset($field['id']) && $field['id'] != '') ? ' id="' . esc_attr($field['id']) . '"' : '';
                echo '<div' . $id . ' class="lnt-fields">';

                echo '<div class="lnt-heading lnt-clearfix">';

                echo "<h3>{$field["heading"]}</h3>";

                echo '</div>';

                $this->lnt_fields_list($field);

                echo '</div>';

            }
        }
    }

    /**
     * Create fields list
     *
     * @since    1.0.0
     */

    public function lnt_fields_list($args = array())
    {

        $name = $args['name'];
        $class = 'lnt_box_content';

        $fields = $args['fields'];
        $value = isset($args['value']) ? $args['value'] : '';

        echo '<div class="' . $class . '">';

        // Display the fields
        if (is_array($value) && count($value) > 0) {
            foreach ($value as $i => $val) {
                $this->lnt_item_box($name, $fields, $val);
            }
        } else {
            $this->lnt_item_box($name, $fields);
        }

        echo '</div>';
    }

    /**
     * Create single field item
     *
     * @since    1.0.0
     */

    public function lnt_item_box($name, $fields = array(), $val = false)
    {

        $classes = array();
        $classes[] = 'lnt-list-item';
        $classes[] = 'lnt-clearfix';
        if (!empty($class)) {
            if (!is_array($class)) {
                $class = preg_split('#\s+#', $class);
            }
            $classes = array_merge($classes, $class);
        } else {
            $class = array();
        }
        $classes = array_map('esc_attr', $classes);

        ob_start();

        echo '<div class="' . join(' ', $classes) . '">';

        echo '<div class="lnt-list-buttons">';
        echo '<a class="lnt-item-delete" href="#"><i class="dashicons dashicons-no"></i></a>';
        echo '<a class="lnt-item-add" href="#"><i class="dashicons dashicons-plus"></i></a>';
        echo '</div>';

        echo '<div class="lnt-list-contents">';

        // If this is a single field
        if (isset($fields['type']) && !is_array($fields['type'])) {
            // Create the field
            $fields['subheading'] = isset($fields['heading']) ? $fields['heading'] : '';
            $fields['name'] = $name . '[]';
            $fields['value'] = $val;
            call_user_func(array($this, 'lnt_item_box_' . $fields['type']), $fields);

            // If this is multiple fields
        } else {

            if (is_array($fields) && count($fields) > 0) {
                foreach ($fields as $fname => $field) {

                    // Set some default values
                    $defaults = array(
                        'heading' => '',
                        'type' => '',
                        'help' => ''
                    );
                    $field = wp_parse_args($field, $defaults);

                    // Append the field data
                    $field['name'] = $name . '[][' . $fname . ']';
                    $field['value'] = isset($val[$fname]) ? $val[$fname] : '';
                    $field['atts'] = array(
                        'data-name' => $name,
                        'data-key' => $fname
                    );

                    // Set a field class

                    echo '<div class="lnt-list-field-type-' . $field['type'] . '">';

                    // Create the field
                    $field['subheading'] = isset($field['heading']) ? $field['heading'] : '';

                    call_user_func(array($this, 'lnt_item_box_' . $field['type']), $field);

                    echo '</div>';
                }
            }
        }

        echo '</div>';
        echo '</div>';

        echo apply_filters('lnt_item_box', ob_get_clean(), $name, $fields, $val, $classes);
    }


    public function lnt_option_buttons()
    {
        global $typenow;

        if ($typenow == 'light_news_ticker') {

            echo '<div class="wrapper">';

            echo '<div id="lnt-default-boxes">';
            echo '<input type="hidden" name="lnt_nonce" value="' . wp_create_nonce(basename(__FILE__)) . '" />';
            do_action('init_default_boxes');
            echo '</div>';

            echo '</div>';
        }
    }

    /**
     * Create Textarea Field type
     *
     * @since    1.0.0
     */

    public function lnt_item_box_textarea($args = array())
    {
        $name = $args['name'];
        $class = isset($args['class']) ? $args['class'] : $name;
        $value = isset($args['value']) ? $args['value'] : '';
        $placeholder = isset($args['placeholder']) ? 'placeholder="' . $args['placeholder'] . '" ' : '';
        $cols = isset($args['cols']) ? $args['cols'] : 60;
        $rows = isset($args['rows']) ? $args['rows'] : 4;
        echo '<div class="' . $class . '">';
        if (isset($args['subheading']) && $args['subheading'] != '') {
            $html = '<div class="lnt-subheading">';
            $html .= '<span class="lnt-subheading-label">' . $args['subheading'] . '</span>';
            $html .= '</div>';
            echo $html;
        }
        echo '<textarea name="' . $name . '" cols="' . $cols . '" rows="' . $rows . '" ' . $placeholder . '>' . $value . '</textarea>';
        echo '</div>';
    }

    /**
     * Save our ticker post
     *
     * @since    1.0.0
     */

    public function lnt_box_save($post_id)
    {

        global $post;

        // verify nonce
        if (!isset($_POST['lnt_nonce']) || !wp_verify_nonce($_POST['lnt_nonce'], basename(__FILE__))) {
            return $post_id;
        }

        // check autosave
        if ((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || (defined('DOING_AJAX') && DOING_AJAX) || isset($_REQUEST['bulk_edit'])) {
            return $post_id;
        }

        // don't save if only a revision
        if (isset($post->post_type) && $post->post_type == 'revision') {
            return $post_id;
        }

        // check permissions
        if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        // Save news ticks
        $sanitized_ticks = array();
        if (isset($_POST['_lnt_ticks'])) {
            $allowed_tags = wp_kses_allowed_html('post');
            $allowed_tags['div']['data-href'] = true;
            $allowed_tags['div']['data-width'] = true;

            if (count($_POST['_lnt_ticks']) > 0) {
                foreach ($_POST['_lnt_ticks'] as $tick) {

                    $sanitized_tick = wp_kses($tick, $allowed_tags);

                    if ($sanitized_tick) {
                        $sanitized_ticks[] = $sanitized_tick;
                    }
                }
            }
        }
        update_post_meta($post_id, '_lnt_ticks', $sanitized_ticks);
    }
}
