jQuery(function ($) {
    $.add_new_range = function (t) {
        var range_filter = t.parents('.widget-content').find('.range-filter'),
            input_field = range_filter.find('input:last-child'),
            field_name = range_filter.data('field_name'),
            position = parseInt(input_field.data('position')) + 1,
            html = '<input type="text" placeholder="min" name="' + field_name + '[' + position + '][min]" value="" class="yith-wcan-price-filter-input widefat" data-position="' + position + '"/>' +
                   '<input type="text" placeholder="max" name="' + field_name + '[' + position + '][max]" value="" class="yith-wcan-price-filter-input widefat" data-position="' + position + '"/>';

        range_filter.append(html);
    };

    $.select_dropdown = function( elem ) { console.log( elem );
        var t = elem,
           select = t.parents('p').next('p');

        t.is(':checked') ? select.fadeIn('slow') : select.fadeOut('slow');
    }

    $(document).on('change', '.gnj_type, .gnj_attributes', function (e) {
        var t = this,
            container       = $(this).parents('.widget-content').find('.gnj_placeholder').html(''),
            spinner         = container.next('.spinner').show(),
            display         = $(this).parents('.widget-content').find('#gnj-display'),
            attributes      = $(this).parents('.widget-content').find('.gnj-attribute-list'),
            tag_list        = $(this).parents('.widget-content').find('.gnj-widget-tag-list');

        var data = {
            action   : 'gnj_select_type',
            id       : $('input[name=widget_id]', $(t).parents('.widget-content')).val(),
            name     : $('input[name=widget_name]', $(t).parents('.widget-content')).val(),
            attribute: $('.gnj_attributes', $(t).parents('.widget-content')).val(),
            value    : $('.gnj_type', $(t).parents('.widget-content')).val()
        };

        /* Hierarchical hide/show */
        if (data.value == 'list' || data.value == 'select' || data.value == 'tags' ) {
            display.show();
        } else if (data.value == 'color') {
            display.hide();
        }

        if( data.value == 'tags' || data.value == 'categories' ){
            attributes.hide();
        } else {
            attributes.show();
        }

        if( data.value == 'tags' ){
            tag_list.show();
        } else {
            tag_list.hide();
        }

       $.post(ajaxurl, data, function (response) {
            spinner.hide();
            container.html(response.content);
            $(document).trigger('gnj_colorpicker');
        }, 'json');
    });

    //color-picker
    $(document).on('gnj_colorpicker',function () {
        $('.gnj-colorpicker').each(function () {
            $(this).wpColorPicker();
        });
    }).trigger('gnj_colorpicker');
});
