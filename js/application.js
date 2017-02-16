$(document).ready(function(){

/*	$("#sidebar").resizable({
		maxWidth: 350,
		minWidth: 150,
		handles: 'e,w',
		alsoResizeReverseLeftMargin: '#pageWrapper'
	}); */
	$("#sidebarContent").load( 'menus/MainSidebar' );
	$("#pageContent").load( 'admin' );

	// All link clicks should load content in the pageContent div
	$("a").live('click',function( event ){
		$("#loading").show();
		$("#pageContent").load( $(this).attr('href'), function(){
			// Because live doesn't handle this code properly
			// we attach it in the callback.
			// Convert any forms in the pageContent to ajax forms
			$("form").submit( function(){
				$.post(  
					$(this).attr("action"),  
					$(this).serialize(),  
					function(response){  
						$("#pageContent").html( response );
					}  
				);  
				return false;
			});
			//$("ul.operations a", "#pageContent").button();
			$("#loading").hide();
		});
		document.location.hash = $(this).attr('href');
		return false;
	});

	$(window).bind('hashchange', function() {
	});


});
