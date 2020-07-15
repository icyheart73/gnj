jQuery(function ($) {

	$(".gnj_invoice").click(function (e) {
		e.preventDefault();

		var w = window.open($(this).attr('href'), "_blank", "width=800,height=980,scrollbars=yes");

	});
	$("#gnj_invoice_label").click(function (e) {
		e.preventDefault();
		alert('invoice label clicked');
	});

})


