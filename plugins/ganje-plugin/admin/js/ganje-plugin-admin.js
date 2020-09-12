jQuery(function ($) {

	$(".gnj_invoice").click(function (e) {
		e.preventDefault();

		var w = window.open($(this).attr('href'), "_blank", "width=800,height=980,scrollbars=yes");

	});
	$("#gnj_invoice_label").click(function (e) {
		e.preventDefault();
		alert('invoice label clicked');
	});

	$('.field-custom.description.description-wide.iconbox i').click(function () {
		var val = $(this).attr("class");
		$('.field-custom.description.description-wide.iconbox i.active').removeClass('active')
		$(this).addClass('active')
		var input_id = $(this).parent().attr('data-inputid')
		$('#'+input_id).val(val);
	})

})

