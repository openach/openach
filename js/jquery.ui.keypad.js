/*
 * jQuery Mobile Number Entry Keypad 1.0.0-2012012300
 *
 * Copyright 2012, Imagine Solutions, Ltd., OpenACH.com, and Steven Brendtro
 * (for more information, visit http://imaginerc.com/jqm-keypad
 * Dual licensed under the MIT or GPL Version 2 licenses.
 *
 */
(function( $ ) {
  $.widget( "mobile.keypad", $.mobile.widget, {
	// All widget options, including some internal runtime details
	options: {
		version: '1.0.0-2012012300', // jQMMajor.jQMMinor.KeypadMinor-YrMoDaySerial
		keypadTheme: 'a',
		displayTheme: 'c',
		maxValue: 99999999.99,
		cancelButton: false,
		clearButton: true
	},
	// the page the keypad container is on
	_keypadPage: false,
	// the keypad container, set in _createKeypad
	_keypadContainer: false,
	_keypadScreenId: '',
	_keypadId: '',
	// Create the widget, called automatically by widget system
	_create: function() {
		// Abort if the element is not an input
		if ( ! this.element.is('input') )
		{
			return;
		}

		// Trigger keypadcreate
		$( document ).trigger( "keypadcreate" );
		this._createKeypad();
		this._bindEvents();
	},
	_createKeypad: function(){

		// alias this to use in event functions
		var self = this;

		var buttonBlockA = $('<div class="ui-block-a"></div>')
					.append('<a keyid="7" class="jqm-keypad-key" data-role="button" href="#">7</a>',
						'<a keyid="4" class="jqm-keypad-key" data-role="button" href="#">4</a>',
						'<a keyid="1" class="jqm-keypad-key" data-role="button" href="#">1</a>',
						'<a keyid="x" class="jqm-keypad-key" data-role="button" href="#"><img src="/images/icons/delete.png" /></a>');

		var buttonBlockB = $('<div class="ui-block-b"></div>')
					.append('<a keyid="8" class="jqm-keypad-key" data-role="button" href="#">8</a>',
						'<a keyid="5" class="jqm-keypad-key" data-role="button" href="#">5</a>',
						'<a keyid="2" class="jqm-keypad-key" data-role="button" href="#">2</a>',
						'<a keyid="0" class="jqm-keypad-key" data-role="button" href="#">0</a>');

		var buttonBlockC = $('<div class="ui-block-c"></div>')
					.append('<a keyid="9" class="jqm-keypad-key" data-role="button" href="#">9</a>',
						'<a keyid="6" class="jqm-keypad-key" data-role="button" href="#">6</a>',
						'<a keyid="3" class="jqm-keypad-key" data-role="button" href="#">3</a>',
						'<a keyid="e" class="jqm-keypad-key" data-role="button" href="#"><img src="/images/icons/enter.png" /></a>');
		// These are the buttons added to the keypad's input
		var cancelButton = $('<a href="#" class="ui-input-clear" title="cancel">cancel</a>')
			.bind('click', function (e) {
				e.preventDefault();
				// do something
				setTimeout( function() { $(e.target).closest("a").removeClass($.mobile.activeBtnClass); }, 300);
			})
			.buttonMarkup({icon: 'delete', iconpos: 'notext', corners:true, shadow:true})
			.css({'vertical-align': 'middle', 'float': 'left'});

		var clearButton = $('<a href="#" class="ui-input-clear" title="clear">clear</a>')
			.bind('click', function (e) {
				e.preventDefault();
				self._updateVal( '0.00' );
				setTimeout( function() { $(e.target).closest("a").removeClass($.mobile.activeBtnClass); }, 300);
			})
			.buttonMarkup({icon: 'back', iconpos: 'notext', corners:true, shadow:true})
			.css({'vertical-align': 'middle', 'float': 'left'});
		
		var keypadInputName = 'jqm-keypad-input_' + this.element.attr('id');
		var keypadId = 'jqm-keypad_' + this.element.attr('id');
		var keypadScreenId = 'jqm-keypad-screen_' + this.element.attr('id');
		var keypadInput = $('<input type="text" id="' + keypadInputName + '" name="' + keypadInputName + '" class="jqm-keypad-input" value="0.00" />');
		
		var keypadInputContainer = $('<div style="padding-bottom: 15px;"></div>')
						.append( keypadInput )
						.addClass( 'jqm-keypad-input-container ui-shadow-inset ui-corner-all ui-body-' + this.options.displayTheme );

		if ( this.options.cancelButton )
		{
			keypadInputContainer.append( cancelButton );
		}

		if ( this.options.clearButton )
		{
			keypadInputContainer.append( clearButton );
		}

		var uiGridWrapper = $('<div class="ui-grid-b"></div>')
					.append( keypadInputContainer )
					.append( buttonBlockA )
					.append( buttonBlockB )
					.append( buttonBlockC );


		var keypadWrapper = $('<div class="jqm-keypad ui-selectmenu ui-selectmenu-hidden ui-overlay-shadow ui-corner-all ui-body-' + this.options.keypadTheme + ' pop in"></div>')
					.append( uiGridWrapper ).attr('id', keypadId);

		var keypadScreen = $('<div class="ui-selectmenu-screen ui-screen-hidden"></div>').attr('id', keypadScreenId);

		var fullKeypad = $('<div class="jqm-keypad-container" id="jqm-keypad-container_' + this.element.attr('id') + '">')
					.append( keypadScreen )
					.append( keypadWrapper );

		this._keypadScreenId = '#' + keypadScreenId;
		this._keypadId = '#' + keypadId;

		// Save this for later
		this._keypadContainer = fullKeypad;

		// Add the keypad to the DOM after the input 					
		//this.element.after( fullKeypad );
		this.element.closest('.ui-content').after( this._keypadContainer );

		this._keypadPage = this.element.closest('div[data-role="page"]');

		// Make sure jquery mobile updates the new content
		//$('.jqm-keypad-container', this.element.parent()).trigger('create');
		this._keypadContainer.trigger('create');

		// Do some cleanup to remove styling from
		keypadInput.removeClass('ui-corner-all ui-overlay-shadow ui-shadow-inset');

	},
	_recalcPosition: function(){
		var self = this,
			//keypadHeight = self._keypadContainer.outerHeight(),
			//keypadWidth = self._keypadContainer.outerWidth(),
			keypadHeight = $( ".jqm-keypad", self._keypadContainer ).outerHeight(),
			keypadWidth = $( ".jqm-keypad", self._keypadContainer ).outerWidth(),
			activePage = $( ".ui-page-active" ),
			tOverflow = $.support.touchOverflow && $.mobile.touchOverflowEnabled,
			tScrollElem = activePage.is( ".ui-native-fixed" ) ? activePage.find( ".ui-content" ) : activePage;
			scrollTop = tOverflow ? tScrollElem.scrollTop() : $( window ).scrollTop(),
			btnOffset = self.element.offset().top,
			screenHeight = window.innerHeight,
			screenWidth = window.innerWidth;

		// Try and center the overlay over the button
		var roomtop = btnOffset - scrollTop,
			roombot = scrollTop + screenHeight - btnOffset,
			halfheight = keypadHeight / 2,
			maxwidth = parseFloat( $( ".jqm-keypad", self._keypadContainer ).css( "max-width" ) ),
			newtop, newleft;

		if ( roomtop > keypadHeight / 2 && roombot > keypadHeight / 2 ) {
			newtop = btnOffset + ( self.element.outerHeight() / 2 ) - halfheight;
		} else {
			// 30px tolerance off the edges
			newtop = roomtop > roombot ? scrollTop + screenHeight - keypadHeight - 30 : scrollTop + 30;
		}

		// If the menuwidth is smaller than the screen center is
		if ( keypadWidth < maxwidth ) {
			newleft = ( screenWidth - keypadWidth ) / 2;
		} else {

			//otherwise insure a >= 30px offset from the left
			newleft = self.element.offset().left + self.element.outerWidth() / 2 - keypadWidth / 2;

			// 30px tolerance off the edges
			if ( newleft < 30 ) {
				newleft = 30;
			} else if ( (newleft + keypadWidth) > screenWidth ) {
				newleft = screenWidth - keypadWidth - 30;
			}
		}

		$( this._keypadScreenId )
			.css({
				height: screenHeight,
				width: '100%',
				top: 0,
				left: 0
			});

		$( this._keypadId )
			.css({
				top: newtop,
				left: newleft,
				position: 'absolute'
			});

	},
	_destroyKeypad: function(){
		this._keypadContainer.remove();
	},
	_bindEvents: function(){
	
		// Create an alias of this so we can use it inside the event functions
		// (the plugin's 'this' is out of scope when referenced inside of the event functions)
		var self = this;

		// Handle keydown events, translating them to keypad clicks
		$(document).keydown(function(event){
			var keyId = '';
			switch( event.keyCode ) {
				///////////
				// 0 key
				case 48:
				case 96:
					keyId = '0';
					break;
				///////////
				// 1 key
				case 49:
				case 97:
					keyId = '1';
					break;
				///////////
				// 2 key
				case 50:
				case 98:
					keyId = '2';
					break;
				///////////
				// 3 key
				case 51:
				case 99:
					keyId = '3';
					break;
				///////////
				// 4 key
				case 52:
				case 100:
					keyId = '4';
					break;
				///////////
				// 5 key
				case 53:
				case 101:
					keyId = '5';
					break;
				///////////
				// 6 key
				case 54:
				case 102:
					keyId = '6';
					break;
				///////////
				// 7 key
				case 55:
				case 103:
					keyId = '7';
					break;
				///////////
				// 8 key
				case 56:
				case 104:
					keyId = '8';
					break;
				///////////
				// 9 key
				case 57:
				case 105:
					keyId = '9';
					break;
				///////////
				// backspace key
				case 8:
					keyId = 'x';
					break;
				///////////
				// enter key
				case 13:
					keyId = 'e';
					break;
				///////////
				// escape key
				case 27:
					// Special case, as there is no button to click for escape
					self._handleEscape();
					break;
				///////////
				// Catch-all, do nothing
				default:
					break;
			}
		
			// If we've not found a valid key to handle, return
			if ( keyId === '' )
			{
				return;
			}

			// Translate the keypress to a click of a button
			self._clickButton( keyId );
		
		});

		// Handle click events on the keypad keys
		$('.jqm-keypad a.jqm-keypad-key', this._keypadContainer).bind('click', function(){
			var keyVal = $(this).attr('keyid');

			var curString = self._currentVal();

			if ( keyVal == 'e' )
			{
				self._handleEnter();
				return;
			}

			if ( keyVal == 'x' )
			{
				self._handleBackspace();
				return;
			}

			var curDec = parseFloat( curString );
			var newDec = (curDec * 10) + (parseInt( keyVal, 10 )/100);

			if ( newDec <= self.options.maxValue )
			{
				self._updateVal( newDec.toFixed(2) );
			}
		});

		// Hide keypad when something other than the keypad is clicked
		$('.ui-selectmenu-screen', this._keypadContainer ).bind('click', function(){
			self._hideKeypad();
		});
	
		// divert the focus away from the keypad-input to prevent direct entry
		$('.jqm-keypad-input', this._keypadContainer).bind('focus', function(){
			$(this).blur();
		});

		// when the input is focused, blur and open up the keypad for entry
		$(this.element).bind('focus',function(){
			$(this).blur();
			// Initialize the keypad input to zero and show the keypad
			self._updateVal( '0.00' );
			self._showKeypad();
		});

	},
	_currentVal: function(){
		var curString = $('.jqm-keypad-input', this._keypadContainer ).val();
		if ( curString === '' )
		{
			curString = '0.00';
		}
		return curString;
	},
	_updateVal: function(newValue){
		return $('.jqm-keypad-input', this._keypadContainer).val( newValue );
	},
	_saveValToInput: function(newValue){
		$( this.element ).val( newValue );
	},
	_clickButton: function(keyId){
		// Build a selector for the keypad key
		var keyClass = '.jqm-keypad-key[keyid=' + keyId + ']';
		var elementId = this.element.attr('id');

		// Trigger a click event and simulate the down and up action of the key
		$(keyClass, this._keypadContainer ).mousedown().click();
		setTimeout( '$("' + keyClass + '", $("#' + elementId + '").parent() ).mouseup()', 100 );
	},
	_hideKeypad: function(){
		$( '.ui-selectmenu-screen', this._keypadContainer ).addClass( 'ui-screen-hidden' ).css( {'top':'-9999px', 'left':'-9999px'} );
		$( '.ui-selectmenu', this._keypadContainer ).addClass( 'ui-selectmenu-hidden' ).css( {'top':'-9999px', 'left':'-9999px'} );
		//$( this._keypadContainer ).hide();
	},
	_showKeypad: function(){
		this._recalcPosition();
		$( '.ui-selectmenu-screen', this._keypadContainer ).removeClass( 'ui-screen-hidden' );
		$( '.ui-selectmenu', this._keypadContainer ).removeClass( 'ui-selectmenu-hidden' );
		//$( this._keypadContainer ).show();
	},
	_handleEnter: function(){
		// copy the value from the keypad's input to the target input and hide the keypad
		this._saveValToInput( this._currentVal() );
		this._hideKeypad();
	},
	_handleBackspace: function(){
		var curString = this._currentVal();

		// remove last character
		curString = curString.substr( 0, curString.length - 1 );

		// convert to a float
		var curDec = parseFloat( curString );

		// shift decimal to the left
		var newDec = curDec / 10;

		if ( newDec === 0.00 ) {
			this._updateVal( '0.00' );
		}
		else {
			this._updateVal( newDec.toFixed(2) );
		}
	},
	_handleEscape: function(){
		this._hideKeypad();
	},
	close: function(fromCloseButton) {
		// Trigger keypadclose
		$( document ).trigger( "keypadclose" );
	},
 	// Use the _setOption method to respond to changes to options
	_setOption: function( key, value ) {
		if ( key === 'clear' )
		{
			// handle changes to clear option
		}
		$.Widget.prototype._setOption.apply( this, arguments );
	},
	// Use the destroy method to clean up any modifications your widget has made to the DOM
	destroy: function() {
		this._destroyKeypad();
		$.Widget.prototype.destroy.call( this );
	}
  });

	  
  // Degrade number inputs to text inputs, suppress standard HTML5 UI functions.
  $( document ).bind( 'pagebeforecreate', function( e ) {
	$( ":jqmData(role='keypad')", e.target ).each(function() {
		$(this).replaceWith(
			$( '<div>' ).html( $(this).clone() ).html()
				.replace( /\s+type=["']number['"]?/, " type=\"text\" " )
		);
	});
  });

  // Automatically bind to data-role='keypad' items.
  $( document ).bind( 'pagecreate create', function( e ){
	$( document ).trigger( 'keypadbeforecreate' );
	$( ":jqmData(role='keypad')", e.target ).each(function() {
		if ( typeof($(this).data('keypad')) === 'undefined' ) {
			$(this).keypad();
		}
	});
  });
  
})( jQuery );
