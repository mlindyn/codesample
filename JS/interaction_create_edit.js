// JS Doc

jQuery(document).ready(function(){
	
		new JsDatePick({
			useMode:2,
			isStripped:false,
			target:"interaction_date",
			cellColorScheme:"ocean_blue"
			
		});
		
		new JsDatePick({
			useMode:2,
			isStripped:false,
			target:"follow_up_date",
			cellColorScheme:"ocean_blue"
			
		});
		
		type_change();
		follow_up_change();
		
		<?php
		if ($customer_id==0){
			//echo "$('.form_hold').hide();";
		}
		?>
		
		$( "#dialog" ).dialog({ autoOpen: false });
		$( "#dialog_search_customer" ).dialog({ autoOpen: false });
		$( "#dialog_add_customer" ).dialog({ autoOpen: false });
		
		if($('.customer_id').val()==0){
			$('.invoice_options_tbl').hide();
			$('.submit_button').hide();
		}
		
		$('.customer_info_hider').hide();
		
		
		
		var status_selected = $('.invoice_status').val();
		
		if(status_selected!=1){
			$('.invoice_line_item_open').prop("disabled",true);
		}else{
			$('.invoice_line_item_open').prop("disabled",false);
		}
		
		
		  
	})
	
	function follow_up_change(){
		var customer_interaction_requires_follow_up = $('.customer_interaction_requires_follow_up').val()*1;
		
		if(customer_interaction_requires_follow_up==0){
			$('.follow_up_tr').hide();
		}else{
			$('.follow_up_tr').show();
		}
		
	}
	
	function type_change(){
		var customer_interaction_method = $('.customer_interaction_method').val()*1;
		
		if(customer_interaction_method<4){
			$('.location_tr').hide();
		}else{
			$('.location_tr').show();
		}
	}
	
	
	
	function open_search_customers(){
				
				//alert (this.mouseX +" = "+ this.mouseX);
				$("#dialog_search_customer").dialog({
					//autoOpen: true,
					//height: 200,
				   // width: 300,
					//modal: false,
					//draggable: true,
					position: ['top', 10 ],
				   // dialogClass: "foo",
					//show: {effect: 'bounce', duration: 350, times: 3}
					show: {effect: 'fade', duration: 800},
					hide: {effect: 'fade', duration: 800}
				});
				
				$( "#dialog" ).dialog( "option", "title", "Search Existing Customers" );
		
				$( "#dialog" ).dialog( "option", "width", 600 );
				
				
				$( "#dialog" ).dialog( "option", "closeOnEscape", true );
				
				$( "#dialog" ).html("<table style='min-width:570px; width:100%; ' ><tr><td align=right >Phone Number</td><td><input name='customer_phone' class='search_customer_phone' id='search_customer_phone'  onkeyup='phone_dash(\"search_customer_phone\")' onkeypress='theKeyUpEvent(event)' maxlength='12'  /></td></tr><tr><td align=right ></td><td><input type='button' onclick='search_customer()' value='Search' id='search_customer_button'  /></td></tr></table><br /><div class='customer_search_results_div' ></div>")
				$( "#dialog" ).dialog( "open" );
				
				$('.edit_element_mode').val(0);

		
	}
	
	function theKeyUpEvent(event){
		//alert("u");
		if(event.keyCode == 13){
			search_customer();
		}
	}
	
	function open_add_customer(){
				
			window.location.href = "<?php echo SITE_ROOT_TWO.'customers/create_edit/customer' ?>";	
			
	}
	
	function search_customer(){
		$('.customer_search_results_div').html("Searching...");
		$.ajax({
			type: "post",
			url: "<?php echo SITE_ROOT_TWO ?>ajaxinvoice/get_customers_from_phone_number",
			cache: false,
			async: false,				
			data: { phone_number: $('.search_customer_phone').val(), company_id: <?php echo $company_id; ?>   },
			success: function(data){
				//alert(data);
				
				var the_list = data;
				$('.customer_search_results_div').html(data);
			}
 		});
	}
	
	
	
	function select_customer_from_list(customer_id){
		var the_url = '<?php echo SITE_ROOT_TWO; ?>customers/create_edit_interaction/0/'+customer_id;
		
		window.location.href = the_url;
	}
	
	function nl2br (str, is_xhtml) {   
		var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';    
		return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
	}
	
	
	
	
	
	function confirm_form(){
		$('.changes_made').val(0);
	}
	
	$(window).bind('beforeunload', function(){
		  //return 'Are you sure you want to leave?';
		  var t=$('.changes_made').val();
		  if(t==1){
		  return 'You have made changes to this page that have not been saved yet.  To save your changes you must hit the submit button.  Are you sure you want to leave without saving your changes?';
		  }
	});
