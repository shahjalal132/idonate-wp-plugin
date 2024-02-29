/**
 * idonate admin js
 *
 */

;(function ($) {
    "use strict";
    
	// Add Color Picker to all inputs that have 'color-picker' class
    $(function() {
        $('.color-picker').wpColorPicker();
		
		$('#table_id').DataTable();

		$('#datebirth').datepicker({
			changeMonth: true,
      		changeYear: true,
      		yearRange: "1800:2030"
		});
		
    });
	
/**
 *
 *
 * Donor Admin View
 *
 *
 */
 
	var $selector = $( '.dedit' );
 
	$selector.on( 'click', function(){
		$( '.loaderadd').html( '<div class="loaderwrapper"><div class="loader"></div></div>' );
		var $this = this,
			$id   	  = $($this).data('donor-id'),
			$targetEdit   = $($this).data('donor-edit'),
			$targetView   = $($this).data('donor-view'),
			$targetDelete = $($this).data('donor-delete');
			

		$.ajax({
			url: localData.statesurl,
			data: {
			  'action' : 'admin_donor_profile_view',
			  'id' : $id
			  },
			dataType: 'json',
			success:function(response) {
						
				var post_template;

				if( $targetEdit === 1 ){
								
					post_template = wp.template( 'donot-edit-template' )(response);

				}
				
				if( $targetView === 1 ){
					post_template = wp.template( 'donor-view-template' )(response);
				}
					
				if( $targetDelete === 1 ){
					post_template = wp.template( 'donor-delete-template' )(response);
				}

				$( '.contentapp' ).html( post_template );
				$( '.loaderwrapper').remove();

					$('#datebirthedit').datepicker({
						changeMonth: true,
			      		changeYear: true,
			      		yearRange: "1800:2030"
					});

					// Select box selected value 
					$( '[data-select]' ).each( function(){
						
						var $this = $( this),
							selected;
						
						selected = $this.data( 'select' );
						
						if( selected !== '' ){

							$this.find('select').val(selected);
						}
						
						
					});
				
					// Selected country and state for donor edit 
					$.ajax({
						type: "POST",
						url:localData.statesurl,
						data:{
							country: response.contycode,
							action: 'country_to_states_ajax'
						},
						success:function(rss){
							
							$('.state').empty();
							var $opt = '';	
							$.each( JSON.parse(rss), function(key, value) {
								console.log( response.state );
								var selected = '';
								if( response.state === value ){
									selected = 'selected';
								}
										
										
								$opt += '<option value="'+key+'" '+selected+'>'+value+'</option>';
							  
							});
							
							$('.state').append($opt);
						}
						
					});
					
						
					
			}
		});


	 
	} );
	
	
	/**
	 * Country Select Box
	 *
	 */
		
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
	
	// File Upload	
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
		

	// Admin Shortcode modual

	$(".show-shortcode").click(function(){
		$(".shortcode-modual").slideToggle();
	  });

		
})(jQuery);


// Validating Empty Field
function check_empty() {
	if (document.getElementById('name').value == "" || document.getElementById('email').value == "" || document.getElementById('msg').value == "") {
		alert("Fill All Fields !");
	} else {
	document.getElementById('form').submit();
		alert("Form Submitted Successfully...");
	}
}

//Function To Display Popup
function div_show() {
	document.getElementById('abc').style.display = "block";
}
//Function to Hide Popup
function div_hide(){
	document.getElementById('abc').style.display = "none";
}
/**
 *
 * View donor
 *
 *
 */
//Function To Display Popup
function div_donor_show() {
	document.getElementById('donorProfile').style.display = "block";
}
//Function to Hide Popup
function div_donor_hide(){
	document.getElementById('donorProfile').style.display = "none";
}
