/*
 * jQuery Mobile Hide-When plugin 1.0.0-2012012400
 *
 * Copyright 2012, Imagine Solutions, Ltd., OpenACH.com, and Steven Brendtro
 * (for more information, visit http://imaginerc.com/jqm-keypad
 * Dual licensed under the MIT or GPL Version 2 licenses.
 *
 */
(function( $ ) {
  $.widget( "mobile.hidewhen", $.mobile.widget, {
	// All widget options, including some internal runtime details
	options: {
		version: '1.0.0-2012012400', // jQMMajor.jQMMinor.HideWhenMinor-YrMoDaySerial
		hide: '',  // selector of element to hide
		whenEqual: '', // when value is equal to this, the element should be hidden
		disable: '', // selector of the element to disable
	},
	// Create the widget, called automatically by widget system
	_target: false,
	_create: function() {
		// Abort if the element is not an input or a select
		if ( ! this.element.is('input') && ! this.element.is('select') )
		{
			return;
		}
		$.extend( this.options, this.element.data('options') );

		if ( this.options.hide )
		{
			this._target = $( this.options.hide );
		}
		else if ( this.options.disable )
		{
			this._target = $( this.options.disable );
		}

		this._bindEvents();

		// do the initial check
		this._checkWhen();
	},
	_checkWhen: function(){
		if ( this.options.whenEqual && this.options.hide )
		{
			if ( this.element.val() === this.options.whenEqual )
			{
				this._hideTarget();
			}
			else
			{
				this._showTarget();
			}
		}
		else if ( this.options.whenEqual && this.options.disable )
		{
			if ( this.element.val() === this.options.whenEqual )
			{
				this._disableTarget();
			}
			else
			{
				this._enableTarget();
			}
		}
	},
	_bindEvents: function(){
		// Create an alias of this so we can use it inside the event functions
		// (the plugin's 'this' is out of scope when referenced inside of the event functions)
		var self = this;

		// Handle click events on the keypad keys
		$(this.element).bind('change', function(){
			self._checkWhen();
		});

	},
	_hideTarget: function(){
		$( this.options.hide ).hide();
	},
	_showTarget: function(){
		$( this.options.hide ).show();
	},
	_disableTarget: function(){
		$( this.options.disable ).attr('disabled','disabled');
	},
	_enableTarget: function(){
		$( this.options.disable ).removeAttr('disabled');
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
		$.Widget.prototype.destroy.call( this );
	}
  });

  // Automatically bind to data-action='hidewhen' items.
  $( document ).bind( 'pagecreate create', function( e ){
	$( ":jqmData(role='hidewhen')", e.target ).each(function() {
		if ( typeof($(this).data('hidewhen')) === 'undefined' ) {
			$(this).hidewhen();
		}
	});
  });
  
})( jQuery );
