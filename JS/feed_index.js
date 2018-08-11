	$(document).ready(function() {
		$('.comment_dialog_hidding_div').hide();
    
    $(".emojionearea1").emojioneArea({
		pickerPosition: "bottom",
		tonesStyle: "bullet",
		saveEmojisAs: "shortname",
		attributes: {
				spellcheck : true
			}
		
	  });
	  
	  
	});
	

	// EXPAND AND HIDE POST TEXT //
	$(document).ready(function() {
		// Configure/customize these variables.
		var showChar =300;  // How many characters are shown by default
		var ellipsestext = "...";
		var moretext = "Show more >";
		var lesstext = "Show less";
		
	
		$('.more').each(function() {
			var content = $(this).html();
	 		
			///////  FOR THE SMILES 
			var pos = [];
			var posEnd = [];
				
			for (var i = 0; i < content.length; i++) {
				if(content.charAt(i)=="<"){
					pos.push(i);
				}
				if(content.charAt(i)==">"){
					posEnd.push(i);
				}
			}
				
			var h=0;
			for (var t=0; t<25; t++){
				if(pos[t]< showChar && posEnd[t]<showChar){
					h=t;
					t=25;
				}else if(pos[t]>showChar){
					t=25;
				}
			}
				
			var addToShowChar = 0;
			if(h>0){
				for (var t=0; t<(h+1); t++){
					addToShowChar = (addToShowChar*1)+1 + (posEnd[t]*1)-(pos[t]*1);
				}
			}else{
				addToShowChar=0;
			}
			
			showChar = (showChar*1)+(addToShowChar+1);
			//alert ("1) "+content.length +" "+ showChar);	
			//alert(showChar);
				
			for (var t=0; t<25; t++){
				if(pos[t]< showChar && posEnd[t] >showChar){
					showChar = (posEnd[t]*1)+1;
					//alert(showChar);
						
					t=25;
				}else if(pos[t]>showChar){
					t=25;
				}
			}
				
			var hold_ans = 0;
			if(content.length > showChar) {
			
				while(hold_ans < 1){
					if(content.charAt(showChar)==" " || content.charAt(showChar)=="<"){
						hold_ans = 1;
					}else if (showChar>=content.length){
						hold_ans = 1;
					}else{
						showChar= (showChar*1)+1;
					}
				}
			}
			///////  FOR THE SMILES
			
			if(content.length > showChar) {
	 
				var c = content.substr(0, showChar);
				var h = content.substr(showChar, content.length - showChar);
	 
				var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
	 
				$(this).html(html);
			}
	 
		});
	 
		$(".morelink").click(function(){
			if($(this).hasClass("less")) {
				$(this).removeClass("less");
				$(this).html(moretext);
			} else {
				$(this).addClass("less");
				$(this).html(lesstext);
			}
			$(this).parent().prev().toggle();
			$(this).prev().toggle();
			return false;
		});
	});
	// END EXPAND AND HIDE POST TEXT //
	
	// EXPAND AND HIDE COMMENT TEXT //
	$(document).ready(function() {
		// Configure/customize these variables.
		  // How many characters are shown by default
		var ellipsestext = "...";
		var moretext = "Show more >";
		var lesstext = "Show less";
		
	
		$('.moreComment').each(function() {
			var showChar = 200;
			var content = $(this).html();
	 		
			///////  FOR THE SMILES 
			var pos = [];
			var posEnd = [];
				
			for (var i = 0; i < content.length; i++) {
				if(content.charAt(i)=="<"){
					pos.push(i);
				}
				if(content.charAt(i)==">"){
					posEnd.push(i);
				}
			}
				
			var h=0;
			for (var t=0; t<25; t++){
				if(pos[t]< showChar && posEnd[t]<showChar){
					h=t;
					t=25;
				}else if(pos[t]>showChar){
					t=25;
				}
			}
				
			var addToShowChar = 0;
			if(h>0){
				for (var t=0; t<(h+1); t++){
					addToShowChar = (addToShowChar*1)+1 + (posEnd[t]*1)-(pos[t]*1);
				}
			}else{
				addToShowChar=0;
			}
			
			showChar = (showChar*1)+(addToShowChar+1);
			//alert ("1) "+content.length +" "+ showChar);	
			//alert(showChar);
				
			for (var t=0; t<25; t++){
				if(pos[t]< showChar && posEnd[t] >showChar){
					showChar = (posEnd[t]*1)+1;
					//alert(showChar);
						
					t=25;
				}else if(pos[t]>showChar){
					t=25;
				}
			}
				
			var hold_ans = 0;
			if(content.length > showChar) {
			
				while(hold_ans < 1){
					if(content.charAt(showChar)==" " || content.charAt(showChar)=="<"){
						hold_ans = 1;
					}else if (showChar>=content.length){
						hold_ans = 1;
					}else{
						showChar= (showChar*1)+1;
					}
				}
			}
			///////  FOR THE SMILES 
				
			if(content.length > showChar) {
	 			
				
				/**/
				var c = content.substr(0, showChar);
				var h = content.substr(showChar, content.length - showChar);
	 			//alert(c);
				var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink1">' + moretext + '</a></span>';
				
				//html = html + pos.toString() + " " + posEnd.toString();
	 
				$(this).html(html);
			}
			
			
	 	
		});
	 
		$(".morelink1").click(function(){
			if($(this).hasClass("less")) {
				$(this).removeClass("less");
				$(this).html(moretext);
			} else {
				$(this).addClass("less");
				$(this).html(lesstext);
			}
			$(this).parent().prev().toggle();
			$(this).prev().toggle();
			return false;
		});
	});
	// END EXPAND AND HIDE COMMENT TEXT //

	function add_remove_thumbs_up(kid_post_id){
		event.preventDefault();
		var user_id = <?php echo $user_id; ?>; 
		//alert("yes");
		$.ajax({
			type: "post",
			url: "<?php echo SITE_ROOT_TWO ?>ajax/feed_ajax/add_remove_thumbs_up",
			cache: false,
			async: false,				
			data: { kid_post_id:kid_post_id, user_id:user_id},
			success: function(data){
				//alert(data);
				
				var dataArray = data.split("-");
				var holdString = '';
				if(dataArray[0]==1){
					holdString = '<a href="#" onclick="add_remove_thumbs_up('+kid_post_id+')" title="Thumbs Up" ><i class="fas fa-thumbs-up"></i></a> ('+dataArray[1]+')';
				}else{
					holdString = '<a href="#" onclick="add_remove_thumbs_up('+kid_post_id+')" title="Thumbs Up" ><i class="far fa-thumbs-up"></i></a> ('+dataArray[1]+')';
				}
				
				
				$('#thumbs_up_span_'+kid_post_id).html(holdString);
				return false();
				
			}
 		});
		
		
	}
	
	
	function post_post_comment(kid_post_id){
		
		
		var user_id = <?php echo $user_id; ?>; 
		
		var ftext = $('[name="Emojione_'+kid_post_id+'"]').val();
		//alert(ftext);
		
		$.ajax({
			type: "post",
			url: "<?php echo SITE_ROOT_TWO ?>ajax/feed_ajax/add_comment_to_post",
			cache: false,
			async: false,				
			data: { kid_post_id:kid_post_id, user_id:user_id, ftext:ftext},
			success: function(data){
				//alert(data);
				
				$('[name="Emojione_'+kid_post_id+'"]').html("");
				$('[name="Emojione_'+kid_post_id+'"]').val("");
				$('.emojionearea-editor').html("");
				$('#comment_dialog_hidding_div_'+kid_post_id).slideUp();
				//return false();
				
			}
 		});
		
	}
	
	 

	function hide_unhide_comment_dialog(kid_post_id){
		if($('#comment_dialog_hidding_div_'+kid_post_id).is(":visible")){
			$('#comment_dialog_hidding_div_'+kid_post_id).slideUp();
		}else{
			$('#comment_dialog_hidding_div_'+kid_post_id).slideDown();
		}
	}
	var interestArray =  new Array();
	var kidArray =  new Array();
	var unsaved_data = 0;
	
	
	function post_this_thing(){
		//alert("Posted that bitch!");
		var post_text = $('#post_text').val();
		var post_text_count = $("#post_text").val().length;
		var post_type = $('.hold_post_type').val();
		
		var user_id = <?php echo $user_id; ?>; 
		
		
		if(post_text_count<1){
			alert("You must write something in the post comment area.");
			return false;
		}
		
		var kidString = kidArray.toString();
		var interestString = interestArray.toString();
		
		var feed_page_id = '<?php echo $feed_page_id; ?>';
		
		$.ajax({
			type: "post",
			url: "<?php echo SITE_ROOT_TWO ?>ajax/feed_ajax/post_the_post",
			cache: false,
			async: false,				
			data: { feed_page_id:feed_page_id, kidString:kidString, interestString:interestString, post_text:post_text, post_type:post_type, user_id:user_id},
			success: function(data){
				//alert(data);
				$('.post_complete').val('1');
				unsaved_data = 0;
				full_cancel();
				check_for_uploads();
			}
 		});
	}
	
	
	function save_post_edits(){
		var kid_post_id = $('.hold_edit_id').val();
		
		var post_text = $('#post_text').val();
		var post_text_count = $("#post_text").val().length;
		var post_type = $('.hold_post_type').val();
		
		var user_id = <?php echo $user_id; ?>; 
		
		
		if(post_text_count<1){
			alert("You must write something in the post comment area.");
			return false;
		}
		
		var kidString = kidArray.toString();
		var interestString = interestArray.toString();
		
		//var feed_page_id = '<?php echo $feed_page_id; ?>';
		
		$.ajax({
			type: "post",
			url: "<?php echo SITE_ROOT_TWO ?>ajax/feed_ajax/edit_the_post",
			cache: false,
			async: false,				
			data: { kidString:kidString, interestString:interestString, post_text:post_text, post_type:post_type, user_id:user_id, kid_post_id:kid_post_id},
			success: function(data){
				//alert(data);
				$('.post_complete').val('1');
				unsaved_data = 0;
				full_cancel();
				check_for_uploads();
				$('.hold_edit_id').val("0");
			}
 		});
	}
	
	
	function delete_uploaded_file(media_id){
		var ans = confirm("Remove this uploaded file?");
		  
			if(!ans){
				return false;
			}
			
		$.ajax({
			type: "post",
			url: "<?php echo SITE_ROOT_TWO ?>ajax/feed_ajax/delete_media_for_post",
			cache: false,
			async: false,				
			data: { media_id:media_id},
			success: function(data){
				//alert(data);
				check_for_uploads();
			}
 		});
	}
	
	
	
	window.onbeforeunload = function(e) {
	 	delete_feed_page_id_media_files();
		
		if(unsaved_data==1){
			return 'You have an unfinished post are you sure you want to leave?';
		}
	};
	
	
	$('#postModal').on('hidden.bs.modal', function (e) {
	  // do something...
	  //alert("It's gone!");
	})
	
	$('#postModal').on('hide.bs.modal', function (e) {
	  // do something...
		var post_complete = $('.post_complete').val();
	 
	 	if(post_complete!="1"){
			var ans = confirm("Do you want to cancel this post?");
		  
			if(!ans){
				return false;
			}
			
			delete_feed_page_id_media_files();
			unsaved_data = 0;
			$('.post_complete').val('0');
			interestArray =  [];
			kidArray = [];
	  	}
	})
	
	function full_cancel(){
		
		
		$('#postModal').modal('hide');
	}
	
	function change_post_type(value){
		
		$('.hold_post_type').val(value);
		
		var hold_edit_id = $(".hold_edit_id").val();
		
		if(hold_edit_id=="0"){
			var hold_state = "New";
		}else{
			var hold_state = "Edit";
		}
		
		if(value==1){
			
			$('.hold_post_text').val("<i class='fas fa-lock'></i> "+hold_state+" Private Post - ");
			$("#left_side_model_footer").html("<i class='fas fa-lock'></i> Making your post private means only you and people you invite will be able to see this post. (Hit next to continue.)");
			$('#post_type1').attr('checked', 'checked');
		}else if(value==2){
			$('.hold_post_text').val("<i class='fas fa-users'></i> "+hold_state+" Shared Post - ");
			$("#left_side_model_footer").html("<i class='fas fa-users'></i> Shared post can be seen by you, your connections and people you send invites to. (Hit next to continue.)");
			$('#post_type2').attr('checked', 'checked');
		}else if(value==3){
			$('.hold_post_text').val("<i class='fas fa-globe'></i> "+hold_state+" Public Post - ");
			$("#left_side_model_footer").html("<i class='fas fa-globe'></i> Public post can be viewed by anyone so make sure this is something you want to share with the whole world. (Hit next to continue.)");
			$('#post_type3').attr('checked', 'checked');
		}
		var start_text = $('.hold_post_text').val();
		$('#interestLabel').html(start_text+"Step 1 (Select Who Can See Your Post)");
		
		setModelColor();
	}
	
	function setModelColor(){
		var post_type = $('.hold_post_type').val();
		
		if(post_type=='0'){
			$('#feed_model_header').css("background-color","#0066FF");
		}
		
		if(post_type=='3'){
			$('#feed_model_header').css("background-color","#ff0000");
		}
		
		if(post_type=='2'){
			$('#feed_model_header').css("background-color","#ffa500");
		}
		
		if(post_type=='1'){
			$('#feed_model_header').css("background-color","#009900");
		}
		
		//alert(post_type);
	}
	
	function step_zero_to_one_buttons(){
		var outputStr = '';
		outputStr += '<div class="row" style="width:105%">';
			outputStr += '<div class="form-group col-md-8" style="text-align:left; " id="left_side_model_footer" >';
				outputStr += 'You must select how or if this post can be viewed by others.  ';
			outputStr += '</div>';
			outputStr += '<div class="form-group col-md-4" style="text-align:right">';
				outputStr += '<button class="btn btn-secondary" onClick="full_cancel()" ><i class="far fa-times-circle"></i> Cancel</button> ';
				
				outputStr += '<button class="btn btn-primary" onClick="go_to_step_one()" ><i class="far fa-arrow-alt-circle-right"></i> Next</button>';
			outputStr += '</div>';
		outputStr += '</div>';
		
		return outputStr;
	}
	
	function step_one_to_two_buttons(){
		var outputStr = '';
		outputStr += '<div class="row">';
			outputStr += '<div class="form-group col-md-7" style="text-align:left" id="left_side_model_footer" >';
				outputStr += 'You must select at least one kid and at least one interest before continuing.  ';
			outputStr += '</div>';
			outputStr += '<div class="form-group col-md-5" style="text-align:right">';
				outputStr += '<button class="btn btn-secondary" onClick="full_cancel()" ><i class="far fa-times-circle"></i> Cancel</button> ';
				outputStr += '<button class="btn btn-primary" onClick="go_back_to_step_zero()" ><i class="far fa-arrow-alt-circle-left"></i> Back</button> ';
				outputStr += '<button class="btn btn-primary" onClick="go_to_step_two()" ><i class="far fa-arrow-alt-circle-right"></i> Next</button>';
			outputStr += '</div>';
		outputStr += '</div>';
		
		return outputStr;
	}
	
	function step_two_to_step_three_buttons(){
		
		var outputStr = '';
		outputStr += '<div class="row">';
			outputStr += '<div class="form-group col-md-7" style="text-align:left" id="left_side_model_footer" >';
				outputStr += 'File uploads are optional if you do not want to upload any files just click Next.  If you are uploading a bunch of files you can write descriptions for each of them after they are uploaded.';
			outputStr += '</div>';
			outputStr += '<div class="form-group col-md-5" style="text-align:right">';
				outputStr += '<button class="btn btn-secondary" onClick="full_cancel()" ><i class="far fa-times-circle"></i> Cancel</button> ';
				outputStr += '<button class="btn btn-primary" onClick="go_back_to_step_one()" ><i class="far fa-arrow-alt-circle-left"></i> Back</button> ';
				outputStr += '<button class="btn btn-primary" onClick="go_to_step_three()" ><i class="far fa-arrow-alt-circle-right"></i> Next</button> ';
			outputStr += '</div>';
		outputStr += '</div>';
		return outputStr;
	}
	
	function step_three_buttons(){
		
		var hold_edit_id = $('.hold_edit_id').val();
		
		var outputStr = '';
		outputStr += '<div class="row" style="width:105%">';
			outputStr += '<div class="form-group col-md-4" style="text-align:left" id="left_side_model_footer" >';
				outputStr += 'Post whatever you want to say.  ';
			outputStr += '</div>';
			outputStr += '<div class="form-group col-md-8" style="text-align:right">';
				outputStr += '<button class="btn btn-secondary" onClick="full_cancel()" ><i class="far fa-times-circle"></i> Cancel</button> ';
				outputStr += '<button class="btn btn-primary" onClick="go_to_step_two()" ><i class="far fa-arrow-alt-circle-left"></i> Back</button> ';
				if(hold_edit_id=="0"){
					outputStr += '<button class="btn btn-success" onClick="post_this_thing()" ><i class="fas fa-flag-checkered"></i> Finish and Post</button> ';
				}else{
					outputStr += '<button class="btn btn-success" onClick="save_post_edits()" ><i class="fas fa-check"></i> Save Changes</button> ';
				}
			outputStr += '</div>';
		outputStr += '</div>';
		return outputStr;
	}
	
	
	
	function go_to_step_three(){
		login_check();
		$('#step1').hide();
		$('#step2').hide();
		$('#step3').slideDown();
		
		
		var start_text = $('.hold_post_text').val();
		$('#interestLabel').html(start_text+"Step 4 (Post Your Thoughs)");
		var footer_text = step_three_buttons();
		$('#model-footer').html(footer_text);
		$("#interest_model_body").animate({ scrollTop: $('#interest_model_body').prop("scrollHeight")}, 1000);
		$("#post_text").focus();
	}
	
	function go_back_to_step_one(){
		login_check();
		$('#step1').slideDown();
		$('#step0').hide();
		$('#step2').hide();
		$('#step3').hide();
		
		
		var start_text = $('.hold_post_text').val();
		$('#interestLabel').html(start_text+"Step 2 (Select Kids and Area of Interest)");
		var footer_text = step_one_to_two_buttons();
		$('#model-footer').html(footer_text);
	}
	
	function go_to_step_one(){
		unsaved_data = 1;
		var isChecked = $('.post_type').is(':checked');
		
		if(!isChecked){
			alert("You must select who can view your post before continuing.");
			return false
		}
		
		
		login_check();
		$('#step1').slideDown();
		$('#step0').hide();
		$('#step2').hide();
		$('#step3').hide();
		
		var start_text = $('.hold_post_text').val();
		$('#interestLabel').html(start_text+"Step 2 (Select Kids and Area of Interest)");
		var footer_text = step_one_to_two_buttons();
		$('#model-footer').html(footer_text);
		$("#interest_model_body").animate({ scrollTop: $('#interest_model_body').prop("scrollHeight")}, 1000);
	}
	
	
	
	
	
	function go_to_step_two(){
		login_check();
		
		
		if(kidArray.length < 1 || kidArray == undefined){
			alert ("You must select at least one kid before continuing.");
			return false;
		}
		
		
		if(interestArray.length < 1 || interestArray == undefined){
			alert ("You must select at least one interest before continuing.");
			return false;
		}
			
		
		$('#step2').slideDown();
		$('#step1').hide();
		$('#step3').hide();
		$('#step0').hide();
		//$('.uploader_div').show();
		var start_text = $('.hold_post_text').val();
		$('#interestLabel').html(start_text+"Step 3 (Upload Files *Optional)");
		var footer_text = step_two_to_step_three_buttons();
		$('#model-footer').html(footer_text);
		$("#interest_model_body").animate({ scrollTop: $('#interest_model_body').prop("scrollHeight")}, 1000);
	}
	
	function go_back_to_step_zero(){
		login_check();
		$('#step0').slideDown();
		$('#step1').hide();
		$('#step3').hide();
		$('#step2').hide();
		
		var value1 = $('.hold_post_type').val();
		
		change_post_type(value1);
		var footer_text = step_zero_to_one_buttons();
		$('#model-footer').html(footer_text);
	}
	
	function open__posting_model(){
		login_check();
		
		$('.hold_edit_id').val(0);
		var this_feed_page_id = $('.hold_feed_page_id').val();
		$('#feed_page_id').val(this_feed_page_id);
		
		$('#post_text').val("");
		
		$('#postModal').modal('show');
		$('#step0').show();
		$('#step1').hide();
		$('#step3').hide();
		$('#step2').hide();
		
		$('.post_type').prop('checked', false);
		
		uncheck_all_interests();
		uncheck_all_kids();
		$('#interestLabel').html("New Post - Step 1 (Select Who Can See Your Post)");
		var footer_text = step_zero_to_one_buttons();
		$('#model-footer').html(footer_text);
		
		$('.post_type').prop('checked', false);
		$('.hold_post_type').val("0");
		change_post_type(0)
		setModelColor();
		
		$('#upload_label').html('<strong>Choose a file</strong><span class="box__dragndrop"> or drag it here</span>.');
		
		$("#file").val(null);
		
		$( '.box' ).each( function()
		{
			var $form		 = $( this ),
				$input		 = $form.find( 'input[type="file"]' ),
				$label		 = $form.find( 'label' ),
				$errorMsg	 = $form.find( '.box__error span' ),
				$restart	 = $form.find( '.box__restart' ),
				droppedFiles = false
		
				$form.removeClass( 'is-error is-success' );
				
				//alert($label.text());
		});





	}
	
	function edit_this_post(kid_post_id){
		login_check();
		
		$('.hold_edit_id').val(kid_post_id);
		
		$('#postModal').modal('show');
		$('#step0').show();
		$('#step1').hide();
		$('#step3').hide();
		$('#step2').hide();
		
		$('#interestLabel').html("Edit Post - Step 1 (Select Who Can See Your Post)");
		
		$.ajax({
			dataType: "json",
			type: "post",
			url: "<?php echo SITE_ROOT_TWO ?>ajax/feed_ajax/get_edit_post_info",
			cache: false,
			async: false,				
			data: { kid_post_id:kid_post_id},
			success: function(data){
				//alert(data);
				//alert(data['kid_post_id']);
				var kidArray2 = data['kid_id_string'].split("***");
				var interestArray2 = data['interest_id_string'].split("***");
				var kid_post_type = data['kid_post_type'];
				var kid_post_text = data['kid_post_text'];
				
				var feed_page_id = data['feed_page_id'];
				var current_feed_page_id = $('.hold_feed_page_id').val();
				//alert(feed_page_id +" "+current_feed_page_id);
				$('#feed_page_id').val(feed_page_id);
				
				$('#post_type'+kid_post_type).click();
				$('#post_type'+kid_post_type).prop("checked"); 
				change_post_type(kid_post_type);
				
				for(var x=0; x<kidArray2.length; x++){
					$('#kid_'+kidArray2[x]).attr('checked','checked');
					change_kid_list(kidArray2[x]);
				}
				
				for(var x=0; x<interestArray2.length; x++){
					$('#interest_'+interestArray2[x]).attr('checked','checked');
					change_interest_list(interestArray2[x]);
				}
				//alert();
				check_for_uploads();
				
				var footer_text = step_zero_to_one_buttons();
				$('#model-footer').html(footer_text);
				
				$("#post_text").val(kid_post_text);
				$('.emojionearea-editor').html(kid_post_text);
				
				
				$('.emojionearea-editor').focus();
				$('.emojionearea-editor').blur();
				//$(".emojionearea1").click();
				
			}
 		});
	}
	
	
	// KID SELECTIONS AND INTEREST SELECTION
	// STEP 1 
	
	
	function change_kid_list(kid_id){
		//alert(kidArray.toString());
			kid_id=kid_id*1;
			//alert("KID: "+kid_id)
		if ($('#kid_'+kid_id).prop('checked')) {
			
			var index = kidArray.indexOf(kid_id);
			if (index == -1) {
				kidArray.push(kid_id);
			}
		}else{
			var index = kidArray.indexOf(kid_id);
			//alert(index);
			//alert("OK1")
			if (index > -1) {
			  kidArray.splice(index, 1);
			}
		}
		
		//alert(kidArray.toString())
		if(kidArray.length>0){
			$('#kids_selected').html("<strong>Kids Selected</strong><br>");
		}else{
			$("#kids_selected").html("");
		}
		var arrayLength = kidArray.length;
		for (var i = 0; i < arrayLength; i++) {
			var id = kidArray[i];
			return_kid_name(id);
		}
	}
	
	function change_interest_list(interest_id){
		interest_id=interest_id*1;
		if ($('#interest_'+interest_id).prop('checked')) {
			interestArray.push(interest_id);
		}else{
			var index = interestArray.indexOf(interest_id);
			//alert(index);
			if (index > -1) {
			  interestArray.splice(index, 1);
			}
		}
		
		//alert(interestArray.join('\n'))
		if(interestArray.length>0){
			$("#interests_selected").html("<strong>Interests Selected</strong><br>");
		}else{
			$("#interests_selected").html("");
		}
		var arrayLength = interestArray.length;
		for (var i = 0; i < arrayLength; i++) {
			var id = interestArray[i];
			return_interest_titles(id);
		}
	}
	
	function wait_and_call(){
		window.setTimeout( set_label, 3000 );
	}
	
	function set_label(){
		$('#upload_label').html('<strong>Choose a file</strong><span class="box__dragndrop"> or drag it here</span>.');
	}
	
	
	
	function uncheck_all_kids(){
		<?php
        	for($r=0; $r<count($kids_array); $r++){
				echo "$('#kid_".$kids_array[$r]['kid_id']."').prop('checked', false);";
			}
		?>
		kidArray = new Array();
		$('#kids_selected').html("");
	}
	
	function uncheck_all_interests(){
		<?php
        	for($r=0; $r<count($full_interest_list); $r++){
				echo "$('#interest_".$full_interest_list[$r]['interest_id']."').prop('checked', false);";
			}
		?>
		
		interestArray =  new Array();
		$('#interests_selected').html("");
	}
	
	function return_kid_name(id){
		//alert(id)
		var theArray = new Array();
		<?php
			
        	for($r=0; $r<count($kids_array); $r++){
			
				$kid_full_name = $kids_array[$r]['kid_first_name']." ";
				if($kids_array[$r]['kid_middle_name']!==''){
                	$kid_full_name .= $kids_array[$r]['kid_middle_name']." ";
                }
                $kid_full_name .= $kids_array[$r]['kid_last_name']." ";
                                
			
				echo "theArray[".$kids_array[$r]['kid_id']."] = '".$kid_full_name."'; \n";
			}
			
			
		?>
		
		 $('#kids_selected').append("<div class='selection_out_div' >"+theArray[id]+"</div>");
	}
	
	function return_interest_titles(id){
		//alert(id)
		var theArray = new Array();
		<?php
			
        	for($r=0; $r<count($full_interest_list); $r++){
				echo "theArray[".$full_interest_list[$r]['interest_id']."] = '".$full_interest_list[$r]['interest_title']."'; \n";
			}
			
			
		?>
		
		 $('#interests_selected').append("<div class='selection_out_div' >"+theArray[id]+"</div>");
	}
	
	// END STEP 1
	
	
	
	function show__upload(){
		$('.uploader_div').slideDown();
	}
	
	$( document ).ready(function() {
		//$('.uploader_div').hide();
	});

	'use strict';

	;( function( $, window, document, undefined )
	{
		// feature detection for drag&drop upload

		var isAdvancedUpload = function()
			{
				var div = document.createElement( 'div' );
				return ( ( 'draggable' in div ) || ( 'ondragstart' in div && 'ondrop' in div ) ) && 'FormData' in window && 'FileReader' in window;
			}();


		// applying the effect for every form

		$( '.box' ).each( function()
		{
			var $form		 = $( this ),
				$input		 = $form.find( 'input[type="file"]' ),
				$label		 = $form.find( 'label' ),
				$errorMsg	 = $form.find( '.box__error span' ),
				$restart	 = $form.find( '.box__restart' ),
				droppedFiles = false,
				showFiles	 = function( files )
				{
					$label.text( files.length > 1 ? ( $input.attr( 'data-multiple-caption' ) || '' ).replace( '{count}', files.length ) : files[ 0 ].name );
				};

			// letting the server side to know we are going to make an Ajax request
			$form.append( '<input type="hidden" name="ajax" value="1" />' );

			// automatically submit the form on file select
			$input.on( 'change', function( e )
			{
				showFiles( e.target.files );

				
				$form.trigger( 'submit' );

				
			});


			// drag&drop files if the feature is available
			if( isAdvancedUpload )
			{
				$form
				.addClass( 'has-advanced-upload' ) // letting the CSS part to know drag&drop is supported by the browser
				.on( 'drag dragstart dragend dragover dragenter dragleave drop', function( e )
				{
					// preventing the unwanted behaviours
					e.preventDefault();
					e.stopPropagation();
				})
				.on( 'dragover dragenter', function() //
				{
					$form.addClass( 'is-dragover' );
				})
				.on( 'dragleave dragend drop', function()
				{
					$form.removeClass( 'is-dragover' );
				})
				.on( 'drop', function( e )
				{
					droppedFiles = e.originalEvent.dataTransfer.files; // the files that were dropped
					showFiles( droppedFiles );

					
					$form.trigger( 'submit' ); // automatically submit the form on file drop

					
				});
			}


			// if the form was submitted

			$form.on( 'submit', function( e )
			{
				// preventing the duplicate submissions if the current one is in progress
				if( $form.hasClass( 'is-uploading' ) ) return false;

				$form.addClass( 'is-uploading' ).removeClass( 'is-error' );

				if( isAdvancedUpload ) // ajax file upload for modern browsers
				{
					e.preventDefault();

					// gathering the form data
					var ajaxData = new FormData( $form.get( 0 ) );
					if( droppedFiles )
					{
						$.each( droppedFiles, function( i, file )
						{
							ajaxData.append( $input.attr( 'name' ), file );
						});
					}

					// ajax request
					$.ajax(
					{
						url: 			$form.attr( 'action' ),
						type:			$form.attr( 'method' ),
						data: 			ajaxData,
						
						cache:			false,
						contentType:	false,
						processData:	false,
						complete: function()
						{
							$form.removeClass( 'is-uploading' );
						},
						success: function( data )
						{
							//$form.addClass( data.success == true ? 'is-success' : 'is-error' );
							if( !data.success ) $errorMsg.text( data.error );
							//alert(data);
							check_for_uploads();
							var input = $("#file");

							function something_happens() {
								input.replaceWith(input.val('').clone(true));
							};
							
							wait_and_call();
						},
						error: function()
						{
							
							alert( 'Error. Please, contact the webmaster!' );
						}
					});
				}
				else // fallback Ajax solution upload for older browsers
				{
					var iframeName	= 'uploadiframe' + new Date().getTime(),
						$iframe		= $( '<iframe name="' + iframeName + '" style="display: none;"></iframe>' );

					$( 'body' ).append( $iframe );
					$form.attr( 'target', iframeName );

					$iframe.one( 'load', function()
					{
						var data = $.parseJSON( $iframe.contents().find( 'body' ).text() );
						$form.removeClass( 'is-uploading' ).addClass( data.success == true ? 'is-success' : 'is-error' ).removeAttr( 'target' );
						if( !data.success ) $errorMsg.text( data.error );
						$iframe.remove();
					});
				}
			});


			// restart the form if has a state of error/success

			$restart.on( 'click', function( e )
			{
				e.preventDefault();
				$form.removeClass( 'is-error is-success' );
				$input.trigger( 'click' );
			});

			// Firefox focus bug fix for file input
			$input
			.on( 'focus', function(){ $input.addClass( 'has-focus' ); })
			.on( 'blur', function(){ $input.removeClass( 'has-focus' ); });
		});

	})( jQuery, window, document );


	function check_for_uploads(){
		var feed_page_id = $('#feed_page_id').val();//'<?php echo $feed_page_id; ?>';
		
		var kid_post_id = $('.hold_edit_id').val();
		
		if(kid_post_id=="0"){
		
			$.ajax({
				type: "post",
				url: "<?php echo SITE_ROOT_TWO ?>ajax/feed_ajax/display_preview_images",
				cache: false,
				async: false,				
				data: { feed_page_id:feed_page_id },
				success: function(data){
					//alert(data);
					$('.media_holder').html(data);
					
				}
			});
		
		}else{
			
			$.ajax({
				type: "post",
				url: "<?php echo SITE_ROOT_TWO ?>ajax/feed_ajax/display_preview_images",
				cache: false,
				async: false,				
				data: { kid_post_id:kid_post_id, feed_page_id:feed_page_id },
				success: function(data){
					//alert(data);
					$('.media_holder').html(data);
					
				}
			});
		}
		
	}
	
	function check_for_uploads_for_edits(kid_post_id, feed_page_id){
		
		
		$.ajax({
			type: "post",
			url: "<?php echo SITE_ROOT_TWO ?>ajax/feed_ajax/display_preview_images",
			cache: false,
			async: false,				
			data: { kid_post_id:kid_post_id, feed_page_id:feed_page_id },
			success: function(data){
				//alert(data);
				$('.media_holder').html(data);
				
			}
 		});
		
	}
	
	function login_check(){
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
	}
	
	function delete_feed_page_id_media_files(){
		var feed_page_id = '<?php echo $feed_page_id; ?>';
		
		$.ajax({
			type: "post",
			url: "<?php echo SITE_ROOT_TWO ?>ajax/feed_ajax/delete_all_unconfirmed_media_from_feed_page_id",
			cache: false,
			async: false,				
			data: { feed_page_id:feed_page_id },
			success: function(data){
				//alert(data);
				$('.media_holder').html("");
				
			}
 		});
	}
