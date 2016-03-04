(function($) {

    var input, pickerWrap, valBox;

    acf.add_action('ready append', function() {
        acf.get_fields({type : 'color_picker'}).each(function() {
            $(this).iris({
                palettes: JSON.parse(acfRCPOptions.colorPickerOptions),
                change: function(event, ui) {
                    $(this).parents('.wp-picker-container').find('.wp-color-result').css('background-color', ui.color.toString());
                }
            });
        });
    });

})(jQuery);