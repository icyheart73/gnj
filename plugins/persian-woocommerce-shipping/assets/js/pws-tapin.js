jQuery(function ( $ ) {
	
	function pws_selectWoo( element ) {
		let select2_args = {
			placeholder: element.attr('data-placeholder') || element.attr('placeholder') || '',
			width: '100%'
		};
		
		element.selectWoo(select2_args);
	}
	
	function pws_state_changed( type, state_id ) {
		
		let data = {
			'action': 'mahdiy_load_cities',
			'state_id': state_id,
			'type': type
		};
		
		$.post(pws_settings.ajax_url, data, function ( response ) {
			$('select#' + type + '_city').html(response);
		});
		
		pws_selectWoo($('select#' + type + '_city'));
	}
	
	$("select[id$='_state']").on('select2:select', function ( e ) {
		let type = $(this).attr('id').indexOf('billing') !== -1 ? 'billing' : 'shipping';
		let data = e.params.data;
		pws_state_changed(type, data.id);
	});
	
	pws_settings.types.forEach(type => {
		pws_selectWoo($('select#' + type + '_state'));
		pws_selectWoo($('select#' + type + '_city'));
	});
	
});