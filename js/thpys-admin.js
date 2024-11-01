jscolor.presets.default = {
	required:false, closeButton:true
};

function styleShadow() {
	
	var xhorizontal = jQuery(".ysxfw-horizontal").val() ? jQuery(".ysxfw-horizontal").val() : 0;
	var xvertical = jQuery(".ysxfw-vertical").val() ? jQuery(".ysxfw-vertical").val() : 0;
	var xblur = jQuery(".ysxfw-blur").val() ? jQuery(".ysxfw-blur").val() : 15;
	var xspread = jQuery(".ysxfw-spread").val() ? jQuery(".ysxfw-spread").val() : 0;
	var xcolor = jQuery(".ysxfw-shadow-color").val() ? jQuery(".ysxfw-shadow-color").val() : '#333';
	
    let props = new Array(
        xhorizontal,
        xvertical,
        xblur,
        xspread,
        xcolor
    );

    jQuery("div.thp-ysxfw-shadow-block").css("box-shadow",
        props[0] + "px " +
        props[1] + "px " +
        props[2] + "px " +
        props[3] + "px" +
        props[4]
    );
}

jQuery(function () {
    styleShadow();
	
	jQuery("input[type='range']").on("input", function () {
		let rangeValue = jQuery(this).val();
		let parent = jQuery(this).parents(".thp-ysxfw-property");
		parent.find("input[type='number']").val(rangeValue);
		
		styleShadow();
	})
	
	jQuery("input[type='number']").on("input", function () {
		let numberValue = jQuery(this).val();
		let parent = jQuery(this).parents(".thp-ysxfw-property");
		parent.find(".thp-ysxfw-bottom > input").val(numberValue);
		
		styleShadow();
	})
	
	jQuery(".ysxfw-shadow-color").on("input", function () {
        styleShadow();
    })

})