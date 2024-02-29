/**
 * idonate admin dashboard js
 *
 */

;(function ($) {
    "use strict";
    
	var $t = $('[data-target]'),
		$c = $( '[data-dismiss]' );
	
	// Show modal
	$t.on( 'click', function(){
		
		var modalOpen = $(this).data('target');
		
		$( modalOpen ).fadeIn();
		
	} );
	
	// Close modal
	$c.on( 'click', function(){
		var dismissBtn = $( this ).data('dismiss');
						
			$(dismissBtn).fadeOut();
		
	} );
	
	/**
	 * Donor action
	 *
	 */
	
	var $donoraction = $('[data-donoraction]');
	
	// User id 
	$donoraction.on( 'click', function(){

		var $this = $( this ),
			$uid = $this.data('uid'),
			dataAction = $this.data('donoraction'),
			setAction = '';
			
			
		// Check action
		if( dataAction == 'delete' ){
			setAction = 'delete';
		}else{
			setAction = 'approve';
		}
				
		$.ajax({
			type: 'post',
			url: idonate_dashboardwidget.ajax_url,
			data: {
				action: 'panding_donor_action',
				target: setAction,
				userid: $uid
			},
			success: function( response ){

				var listdismis = $this.parents('[data-listid]');
				
				$(listdismis).fadeOut();
				
				var res = JSON.parse( response );
				$( 'body' ).append( '<div class="ido-pop" style="position: fixed;width: 300px;top: 10%;right: 0;background-color: #00b200;padding: 12px;color: #fff;">'+res.msg+'</div>' );
				$( '.ido-pop' ).delay('800').fadeOut('slow');
				
			}
			
		});
		
		return false;
	} );
	
	/**
	 * Blood request action
	 *
	 */
	
	var $reqaction = $('[data-reqaction]');
	
		
	// User id 
	$reqaction.on( 'click', function(){

		var $this = $( this ),
			$uid = $this.data('uid'),
			dataAction = $this.data('reqaction'),
			setAction = '';
			
			
		// Check action
		if( dataAction == 'delete' ){
			setAction = 'delete';
		}else{
			setAction = 'approve';
		}
				
		$.ajax({
			type: 'post',
			url: idonate_dashboardwidget.ajax_url,
			data: {
				action: 'panding_blood_request_action',
				target: setAction,
				userid: $uid
			},
			success: function( response ){
								
				var listdismis = $this.parents('[data-listid]');
				
				$(listdismis).fadeOut();
				
				var res = JSON.parse( response );
				$( 'body' ).append( '<div class="ido-pop" style="position: fixed;width: 300px;top: 10%;right: 0;background-color: #00b200;padding: 12px;color: #fff;">'+res.msg+'</div>' );
				$( '.ido-pop' ).delay('800').fadeOut('slow');
				
			}
		});
		return false;
		
	} );
	
	
		
})(jQuery);