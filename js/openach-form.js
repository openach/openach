$(document).ready(function(event){
	$(document).on('keyup', '#odfi-branch-form #OdfiBranch_odfi_branch_dfi_id', function(e) {
		var node = $("#routing-number-bank-name");
		if ( $('#odfi-branch-form #OdfiBranch_odfi_branch_dfi_id_qualifier').val() != '01' )
		{
			node.html("");
			return;
		}
		var number = $(this).val();
		if (number.length == 9) {
			$.getJSON("/routing/lookup/dfi/" + number, function(data) {
				node.html(data.customer_name);
				if (data.customer_name === "Unknown") {
					node.css("color", "red");
				} else if ( data.customer_name != '' ) {
		  			node.css("color", "green");
					$('#odfi-branch-form #OdfiBranch_odfi_branch_name').val( data.customer_name );
					$('#odfi-branch-form #OdfiBranch_odfi_branch_city').val( data.city );
					$('#odfi-branch-form #OdfiBranch_odfi_branch_state_province').val( data.state_province );
					$('#odfi-branch-form #OdfiBranch_odfi_branch_country_code').val( 'US' ).selectmenu('refresh'); // All ABA Routing Numbers are in the US
				}
			});
		} else {
		  node.html("");
		}
		return false;
	});
	$(document).on('change', '#odfi-branch-form #OdfiBranch_odfi_branch_plugin', function(e) {
		var pluginId = $(this).val();
		var node = $('#odfi-branch-form #OdfiBranch_odfi_branch_go_dfi_id');
		$.getJSON("/bankPlugin/goDfiLookup/id/" + pluginId, function(data) {
			node.val( data.gateway_dfi_id );
		});
	});

	$(document).on('keyup', '#external-account-form #ExternalAccount_external_account_dfi_id', function(e) {
		var node = $("#routing-number-bank-name");
		if ( $('#external-account-form #ExternalAccount_external_account_dfi_id_qualifier').val() != '01' )
		{
			node.html("");
			return;
		}
		var number = $(this).val();
		if (number.length == 9) {
			$.getJSON("/routing/lookup/dfi/" + number, function(data) {
				node.html(data.customer_name);
				if (data.customer_name === "Unknown") {
					node.css("color", "red");
				} else if ( data.customer_name != '' ) {
					node.css("color", "green");
					$('#external-account-form #ExternalAccount_external_account_bank').val( data.customer_name );
				}
			});
		} else {
		  node.html("");
		}
		return false;
	});


	$(document).on( 'pageinit', 'div', function() {

		$('#originator-form #user_login').autocomplete(
			{
				minLength:'3',
				source:function( request, response ){
					$.ajax({
						url: '/user/lookup',
						dataType: 'json',
						data: {
							term: request.term
						},
						success: function( data ) {
							response( $.map( data, function( item ) {
								return {
									label: item.user_login,
									value: item.user_id
								}
							}));
						}
					});
				},
				select: function( event, ui ) {
					$('#originator-form #user_login').val( ui.item.label );
					$('#originator-form #Originator_originator_user_id').val( ui.item.value );
					return false;
				}
			}
		);
	});

	$('#oa-nav-menu-button').click(function(){
		$('#oa-nav-menu').show();
		$('#oa-footer').animate({'top': '-=22px', 'height': '-=38px'}, 'slow');
		//$('#oa-footer').animate({'top': '-=62px'}, 'slow');
	});

	// Automatically bind simpledialog to data-role='simpledialog-link' items.
	$(document).on( 'click', ":jqmData(role='simpledialog-link')", function() {
		var content = $(this).next('.simpledialog-content');
		if ( content )
		{
			// First check if the content needs to be loaded
			if ( content.attr('data-source') == 'ajax' && ! content.html() )
			{
				var dataUrl = content.attr('data-path') + '/id/' + content.attr('data-model-id') + '/ajax/1';
				content.load( dataUrl, function(){
					$(this).simpledialog({
						'mode' : 'blank',
						'prompt' : false,
						'forceInput' : false,
						'useModal' : true,
						'fullHTML' : content.html()
					});
				});
			}
			else
			{
				$(this).simpledialog({
					'mode' : 'blank',
					'prompt' : false,
					'forceInput' : false,
					'useModal' : true,
					'fullHTML' : content.html()
				});
			}
		}
	});
	

});

