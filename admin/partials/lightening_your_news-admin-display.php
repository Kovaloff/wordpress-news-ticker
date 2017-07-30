<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/Kovaloff
 * @since      1.0.0
 *
 * @package    Lightening_your_news
 * @subpackage Lightening_your_news/admin/partials
 */

?>

<div class="wrap">

    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>

    <form method="post" name="cleanup_options" action="options.php">

        <?php
        //Grab all options
        $options = get_option($this->plugin_name);

        // Cleanup
        $cleanup = $options['cleanup'];
        $news = $options['news_text'] ?? false;

        settings_fields($this->plugin_name);
        do_settings_sections($this->plugin_name);
        ?>

        <h3>Ticker Options</h3>

        <fieldset>
            <label for="<?php echo $this->plugin_name; ?>-cleanup">
                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-cleanup"
                       name="<?php echo $this->plugin_name; ?>[cleanup]" value="1" <?php checked($cleanup, 1); ?> />
                <span><?php esc_attr_e('Clean up the head section', $this->plugin_name); ?></span>
            </label>
        </fieldset>

        <h3>Ticker News</h3>

        <div class="multi-field-wrapper">
            <fieldset class="multi-fields">
                <?php if ($news && !empty($news)): ?>
                    <?php foreach ($news as $key => $item): ?>
                        <fieldset class="multi-field">
                            <label for="<?php echo $this->plugin_name; ?>-cdn_provider">
                                <span><?php esc_attr_e('News text', $this->plugin_name); ?></span>
                                <input type="text" class="regular-text textbox"
                                       name="<?php echo $this->plugin_name; ?>[news_text][]"
                                       value="<?php echo $item; ?>"/>

                                <button type="button" class="remove-field">-</button>
                            </label>
                        </fieldset>
                    <?php endforeach; ?>

                <?php else: ?>
                    <fieldset class="multi-field">
                        <label for="<?php echo $this->plugin_name; ?>-cdn_provider">
                            <span><?php esc_attr_e('News text', $this->plugin_name); ?></span>
                            <input type="text" class="regular-text textbox"
                                   name="<?php echo $this->plugin_name; ?>[news_text][]"
                                   value=""/>
                            <button type="button" class="remove-field">-</button>
                        </label>
                    </fieldset>
                <?php endif; ?>

            </fieldset>
            <button type="button" class="add-field">Add new entrie</button>
        </div>

        <?php submit_button('Save all changes', 'primary', 'submit', true); ?>
</div>
<!-- /.wrap -->
