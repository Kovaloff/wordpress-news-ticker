
;function insert_shortcode() {
    window.send_to_editor('[light_news_ticker]');
    tb_remove();
}

jQuery(function ($) {
    'use strict';

    jQuery(document, jQuery(this)).on('click', '.lnt-item-add', function (e) {

        var $clone = jQuery('.lnt_box_content > div:first-child').clone();
        $clone.find('textarea, input, select').each(function () {
            $(this).val('');
        });

        $clone.appendTo('.lnt_box_content');

    });
    jQuery(document).on('click', '.lnt-item-delete', function () {

        if (jQuery('.lnt_box_content').length > 0)
            jQuery(this).closest('.lnt-list-item').remove();
    });

});

