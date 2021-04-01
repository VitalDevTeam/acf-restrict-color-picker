(function($) {

    function getMasterPalette() {
		var rcpOptions = JSON.parse(acfRCPOptions.color_palettes);
		return rcpOptions.master;
	}

	acf.add_filter('color_picker_args', function(args) {
		args.palettes = getMasterPalette();
		return args;
	});

})(jQuery);
