/**
 * idonate admin js
 *
 */

;(function ($) {
    "use strict";
    
	// Add Color Picker to all inputs that have 'color-picker' class
    $(function() {
        $('.date-picker').datepicker();
        $('#datebirth').datepicker({
        	changeMonth: true,
      		changeYear: true,
      		yearRange: "1800:2030"
        });
		
		// Donor Popup
		$('.open-popup-link').magnificPopup({
		  type:'inline',
		  midClick: true, // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
		  mainClass: 'mfp-with-zoom', 
		  removalDelay: 300,

		});


		// On change country 
		$('body').on( 'change', '.country', function() {
			$.ajax({
				type: "POST",
				url:localData.statesurl,
				data:{
					country: $(this).val(),
					action: 'country_to_states_ajax'
				},
				success:function(rss){
				    					
					$('.state').empty();
					var $opt = '';	
					$.each( JSON.parse(rss), function(key, value) {
								
						$opt += '<option value="'+key+'">'+value+'</option>';
					  
					});
					
					$('.state').append($opt);
				}
				
			});
			
			//return false;
		});
		
		// Selected  state
		var $selectedCount = $('.country').val(),
			$selectedState = $('.state').data('state');
						
		if( $selectedCount ){		
				$.ajax({
					type: "POST",
					url:localData.statesurl,
					data:{
						country: $selectedCount,
						action: 'country_to_states_ajax'
					},
					success:function(rss){
											
						$('.state').empty();
						var $opt = '';	
						$.each( JSON.parse(rss), function(key, value) {
							
							var $selected;
							
							if( $selectedState  === key ){
								$selected = 'selected';
							}else{
								$selected = '';
							}
							
							$opt += '<option value="'+key+'" '+$selected+'>'+value+'</option>';
						  
						});
						
						$('.state').append($opt);
					}
					
				});
			
		}
		// Data Table
		var $tbl = $('#table_id');
		if( $tbl.length ){
			$tbl.DataTable();
		}
		
		/**
		 * File upload
		 *
		 */
		 
		$(document).on( 'change', '.profilepic', function(){
			
			var $this 	 = $( this );
			
			
				if( $this[0]['files'] ){
					
					var reader = new FileReader(),
						$target  = $( $this.data( 'target' ) );;
										
						reader.onload = function (e) {
							
						$target.attr( 'src', e.target.result );
						
						};
						
					reader.readAsDataURL( $this[0]['files'][0] );	
					
				}
		
		} );
		
		
    });
	
})(jQuery);
