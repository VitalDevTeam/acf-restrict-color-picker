(function($) {

    var input, pickerWrap, valBox;

    acf.add_action('ready append', function() {

        var acfRCPColorPalettes = JSON.parse(acfRCPOptions);
        var acfRCPColorPaletteMaster = JSON.stringify(acfRCPColorPalettes['master']);
        var acfRCPColorPalette = '';
        var acfRCPColorInput = '';
        var acfRCPColorInputDefaultIndex = -1;
        var acfRCPColorInputDefaultColor = '';

        acf.get_fields({type : 'color_picker'}).each(function() {

            if( !$(this).hasClass('color_restricted') ) {  // Set this class to avoid modifying Color Picker more than once per load

                acfRCPColorPalette = JSON.stringify(acfRCPColorPalettes[acf.get_field_key($(this))]);

                if(acfRCPColorPalette === undefined) {  // If there was no default set for this color picker field, load the master palette
                    acfRCPColorPalette = acfRCPColorPaletteMaster;
                }

                $(this).find('input[type="text"]').each(function() {  // For each color text input: find, load and sanitize the default val (if necessary)

                    acfRCPColorInput = $(this).val();

                    if((!acfRCPColorInput) || acfRCPColorInput.indexOf(',') !== -1) {  // If there's no input value set, or it contains a comma-delimited list of hex values

                        if(!acfRCPColorInput) {  // If there's no input value set
                            acfRCPColorInput = acfRCPColorPalette.replace(/[\[\"\]]/g, '');  // Load it with the current color palette
                        }

                        acfRCPColorInputDefaultIndex = acfRCPColorInput.indexOf('default-');  // Find the index of the default hex

                        if(acfRCPColorInputDefaultIndex !== -1) {  // If there's a default hex
                            acfRCPColorInputDefaultColor = acfRCPColorInput.substring(acfRCPColorInputDefaultIndex + 8);
                            if(acfRCPColorInput.indexOf(',', acfRCPColorInputDefaultIndex) !== -1) {  // Remove anything after ',', inclusive
                                acfRCPColorInputDefaultColor = acfRCPColorInputDefaultColor.substring(0, acfRCPColorInputDefaultColor.indexOf(',', 0));
                            }
                            $(this).val(acfRCPColorInputDefaultColor);
                            $(this).parents('.wp-picker-container').find('.wp-color-result').css('background-color', acfRCPColorInputDefaultColor);

                        } else {
                            $(this).val('');
                            $(this).parents('.wp-picker-container').find('.wp-color-result').css('background-color', '');
                        }
                    }
                });

                $(this).iris({
                    palettes: JSON.parse(acfRCPColorPalette.replace(/default\-/g, '')),  // Remove 'default-' from JSON so that it's a valid hex value for color picker
                    change: function(event, ui) {
                        $(this).parents('.wp-picker-container').find('.wp-color-result').css('background-color', ui.color.toString());
                    }
                });

                $(this).addClass('color_restricted');
            }
        });
    });
})(jQuery);