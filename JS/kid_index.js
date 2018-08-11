//JS Doc

function load_interests(kid_id){
		//alert(kid_id)
		$.ajax({
			type: "post",
			url: "<?php echo SITE_ROOT_TWO ?>ajax/ajax_construct/am_i_logged_in",
			cache: false,
			async: false,				
			data: {  },
			success: function(data){
				//alert(data);
				if(data=="No"){
					window.location.replace("<?php echo SITE_ROOT_TWO ?>member/logout");
				}
				
			}
 		});
		
		$.ajax({
				type: "post",
				url: "<?php echo SITE_ROOT_TWO ?>ajax/kids_ajax/getKidInfo",
				cache: false,				
				data: {  kid_id: kid_id  },
				success: function(json){						
				try{		
					var obj = jQuery.parseJSON(json);
					//alert(json);
							
					
				}catch(e) {		
					alert('Exception while request..'+ e );
				}		
				},
				error: function(){						
					alert('Error while request..');
				},success: function(data){
					//alert(data);
					var obj = jQuery.parseJSON(data);
					//alert(obj.html);
					
					if(obj.error==''){
							//alert(obj.list);
							//alert("yes")
							
						var string_t = decodeURIComponent(obj.list);
						var first_name = decodeURIComponent(obj.first_name);
						var middle_name =decodeURIComponent( obj.middle_name);
						var last_name = decodeURIComponent(obj.last_name);
						var dobYear = obj.dobYear;
						var dobMonth = obj.dobMonth;
						var dobDay = obj.dobDay;
						var kid_town_city = decodeURIComponent(obj.kid_town_city);
						var kid_state = decodeURIComponent(obj.kid_state);
						var kid_status = obj.kid_status;
						var kid_gender = obj.kid_gender;
						var show_last_name = obj.show_last_name;
						
						string_t=decodeURIComponent(string_t);
						
						$("#interestLabel").html("Interest List for " + first_name);					
						//hide_unhide_add_activity();
					}else{
						alert(decodeURIComponent(obj.error));
					
					}
				}
			});
		
		$("#kid_id_holder").val(kid_id);
		$('#interestModal').modal('show');
		$("#interest_model_body").scrollTop(50);
		<?php
		for($x=0; $x<count($full_interest_list); $x++){
			echo "$('#interest_".$full_interest_list[$x]['interest_id']."').prop('checked', false);";
		}
		?>
		
		$.ajax({
			type: "post",
			url: "<?php echo SITE_ROOT_TWO ?>ajax/kids_ajax/getKidsInterests",
			cache: false,
			async: false,				
			data: { kid_id:kid_id },
			success: function(data){
				//alert(data);
				var res = data.split("-");
				
				for(var z=0; z<res.length; z++){
					$('#interest_'+res[z]).prop('checked', true);
				}
			}
 		});
		
		
	}
	
	function save_interests(){
		
		var ans = confirm("Save these interests?");
		
		if(!ans){
			return false;
		}
		
		$.ajax({
			type: "post",
			url: "<?php echo SITE_ROOT_TWO ?>ajax/ajax_construct/am_i_logged_in",
			cache: false,
			async: false,				
			data: {  },
			success: function(data){
				//alert(data);
				if(data=="No"){
					window.location.replace("<?php echo SITE_ROOT_TWO ?>member/logout");
				}
				
			}
 		});
		
		var kid_id = $("#kid_id_holder").val();
		var outString = '';
		<?php
		for($x=0; $x<count($full_interest_list); $x++){
			
			echo "if ($('#interest_".$full_interest_list[$x]['interest_id']."').is(':checked')) {";
				echo "if(outString!=''){ outString += '-' }";
				echo "outString += '".$full_interest_list[$x]['interest_id']."' ";
			echo "}";
		}
		?>
		
		$.ajax({
			type: "post",
			url: "<?php echo SITE_ROOT_TWO ?>ajax/kids_ajax/saveKidsInterests",
			cache: false,
			async: false,				
			data: { kid_id:kid_id, interest_list:outString },
			success: function(data){
				$('#interestModal').modal('hide');
			}
 		});
		//alert(outString +" "+kid_id);
		
		
	}
	
	function save_kid_data(){
		
		$('.error_text').html("");
		$('#first_name').css("background-color","#fff");
		$('#last_name').css("background-color","#fff");
		$("#birth_year").css("background-color","#fff");
		$('#birth_month').css("background-color","#fff");
		$('#birth_day').css("background-color","#fff");
		$('#kid_gender').css("background-color","#fff");
		$('#kid_status').css("background-color","#fff");
		$('#state').css("background-color","#fff");
		$('#town').css("background-color","#fff");
		$('#show_last_name').css("background-color","#fff");
		
		var kid_id = $("#kid_id").val();
		
		//alert(kid_id);
		//$("#first_name")
		var first_name = $('#first_name').val();
		var middle_name = $('#middle_name').val();
		var last_name = $('#last_name').val();
		
		var birth_month = $('#birth_month').val();
		var birth_day = $('#birth_day').val();
		var birth_year = $('#birth_year').val();
		
		var kid_gender = $('#kid_gender').val();
		var kid_status = $('#kid_status').val();
		var show_last_name = $('#show_last_name').val();
		
		var town = $("#town").val();
		var state = $("#state").val();
		
		if(first_name==''){
			$('.error_text').html("ERROR: You must enter a first name for your kid.");
			$('#first_name').css("background-color","#ffb6c1");
			return false;
		}
		
		if(last_name==''){
			$('.error_text').html("ERROR: You must enter a last name for your kid.");
			$('#last_name').css("background-color","#ffb6c1");
			return false;
		}
		
		if(birth_month=='0'){
			$('.error_text').html("ERROR: You must enter a birth month for your kid.");
			$('#birth_month').css("background-color","#ffb6c1");
			return false;
		}
		
		if(birth_day=='0'){
			$('.error_text').html("ERROR: You must enter a birth day for your kid.");
			$('#birth_day').css("background-color","#ffb6c1");
			return false;
		}
		
		if(birth_year=='0'){
			$('.error_text').html("ERROR: You must enter a birth year for your kid.");
			$('#birth_year').css("background-color","#ffb6c1");
			return false;
		}
		
		if(town==''){
			$('.error_text').html("ERROR: You must enter thw town your kid lives in.");
			$('#town').css("background-color","#ffb6c1");
			return false;
		}
		
		if(state=='0'){
			$('.error_text').html("ERROR: You must enter thw state your kid lives in.");
			$('#state').css("background-color","#ffb6c1");
			return false;
		}
		
		if(kid_gender=='0'){
			$('.error_text').html("ERROR: You must enter your kid's gender.");
			$('#kid_gender').css("background-color","#ffb6c1");
			return false;
		}
		
		if(kid_status==''){
			$('.error_text').html("ERROR: You must set the staus of your kid's profile. Setting it to inactive will mean that people can not see the profile and you will not be able to post to it.");
			$('#kid_status').css("background-color","#ffb6c1");
			return false;
		}
		
		if(show_last_name==''){
			$('.error_text').html("ERROR: You must tell us if you want your child last name shared on thier public profile.");
			$('#show_last_name').css("background-color","#ffb6c1");
			return false;
		}
		
		var dob = birth_year+birth_month+birth_day;
		
		var ans = confirm("Save changes for this child?");
		
		if(!ans){
			return false;
		}
		
		
		$.ajax({
			type: "post",
			url: "<?php echo SITE_ROOT_TWO ?>ajax/kids_ajax/add_edit_kid",
			cache: false,
			async: false,				
			data: { kid_id:kid_id, kid_first_name: first_name, kid_middle_name: middle_name, kid_last_name: last_name, kid_dob: dob, kid_gender:kid_gender, kid_status:kid_status, kid_town_city:town, kid_state:state, show_last_name: show_last_name},
			success: function(data){
				//alert(data);
				//alert("yes");		
				$('.bd-example-modal-lg').modal('hide');
				location.reload();	
			}
 		});
		
		
		
	}
	
	function show_model(kid_id){
		
		$.ajax({
			type: "post",
			url: "<?php echo SITE_ROOT_TWO ?>ajax/ajax_construct/am_i_logged_in",
			cache: false,
			async: false,				
			data: {  },
			success: function(data){
				//alert(data);
				if(data=="No"){
					window.location.replace("<?php echo SITE_ROOT_TWO ?>member/logout");
				}
				
			}
 		});
		
		$('.bd-example-modal-lg').modal('show');
		
		$("#kid_id").val(kid_id);
		$('.error_text').html("");
		$('#first_name').css("background-color","#fff");
		$('#last_name').css("background-color","#fff");
		$("#birth_year").css("background-color","#fff");
		$('#birth_month').css("background-color","#fff");
		$('#birth_day').css("background-color","#fff");
		$('#kid_gender').css("background-color","#fff");
		$('#kid_status').css("background-color","#fff");
		$('#show_last_name').css("background-color","#fff");
		
		if(kid_id==0){
			$("#exampleModalLabel1").html("Add Kid");
			$("#first_name").val("");
			$("#middle_name").val("");
			$("#last_name").val("");
			$("#birth_month").val(0);
			$("#birth_day").val(0);
			$("#birth_year").val(0);
			$("#kid_gender").val(0);
			$("#kid_status").val("");
			$("#show_last_name").val(0);
		}
		
		if(kid_id!=0){
			$("#exampleModalLabel1").html("Edit Kid");
			
			$.ajax({
				type: "post",
				url: "<?php echo SITE_ROOT_TWO ?>ajax/kids_ajax/getKidInfo",
				cache: false,				
				data: {  kid_id: kid_id  },
				success: function(json){						
				try{		
					var obj = jQuery.parseJSON(json);
					//alert(json);
							
					
				}catch(e) {		
					alert('Exception while request..'+ e );
				}		
				},
				error: function(){						
					alert('Error while request..');
				},success: function(data){
					//alert(data);
					var obj = jQuery.parseJSON(data);
					//alert(obj.html);
					
					if(obj.error==''){
							//alert(obj.list);
							//alert("yes")
							
						var string_t = decodeURIComponent(obj.list);
						var first_name = decodeURIComponent(obj.first_name);
						var middle_name =decodeURIComponent( obj.middle_name);
						var last_name = decodeURIComponent(obj.last_name);
						var dobYear = obj.dobYear;
						var dobMonth = obj.dobMonth;
						var dobDay = obj.dobDay;
						var kid_town_city = decodeURIComponent(obj.kid_town_city);
						var kid_state = decodeURIComponent(obj.kid_state);
						var kid_status = obj.kid_status;
						var kid_gender = obj.kid_gender;
						var show_last_name = obj.show_last_name;
						
						string_t=decodeURIComponent(string_t);
						
						$("#first_name").val(first_name);
						$("#middle_name").val(middle_name);
						$("#last_name").val(last_name);
						
						$("#birth_year").val(dobYear);
						$("#birth_month").val(dobMonth);
						$("#birth_day").val(dobDay);
						
						$("#town").val(kid_town_city);
						$("#state").val(kid_state);
						$("#show_last_name").val(show_last_name);
						$("#kid_status").val(kid_status);
						$("#kid_gender").val(kid_gender);
						
						
						
						
						//hide_unhide_add_activity();
					}else{
						alert(decodeURIComponent(obj.error));
					
					}
				}
			});
		
		}
	}
