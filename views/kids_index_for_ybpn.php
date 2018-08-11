<div class="jumbotron">
  <h1 class="display-4">Your Kids</h1>
  <p class="lead">Here you can add your kids and create their showcases.  Adding a kid is easy and only takes a few moments.  Once they are added you can start creating your kid's showcase profiles, practice schedules, timeslines and more.</p>
  <hr class="my-4">
  <div class="row">
    
    <div class="col" style="text-align:right"><button id="search_open_close_button" class="btn btn-primary" onclick="show_model(0)" ><i class="fas fa-plus"></i> Add A Kid</button></div>
    </div>
 	<div class="kid_list_div">
 <?php
 	for($x=0; $x<count($kids_array); $x++){
		
		if($kids_array[$x]['kid_gender']==1){
			$gender = "Male";
		}else if($kids_array[$x]['kid_gender']==2){
			$gender = 'Female';
		}
		
		$dob = $kids_array[$x]['kid_dob'];
		$dobYear = substr($dob,0,4);
		$dobMonth = substr($dob,4,2);
		$dobDay = substr($dob,6,2);
		$display_dob = "$dobMonth/$dobDay/$dobYear";
		
		$full_name = $kids_array[$x]['kid_first_name'];
		if($kids_array[$x]['kid_middle_name']!=''){
			$full_name .= ' '. $kids_array[$x]['kid_middle_name'];
		}
		$full_name .= ' '. $kids_array[$x]['kid_last_name'];
		
		echo '<hr class="my-4">';
		echo '<div class="row">';
		echo '<div class="w-100"></div>';
		echo '<div class="col-sm-1" style="min-width:94px"><img class="" src="' .SITE_ROOT . 'images/kid_no_profile_image_girl.png" width="90px" /></div>';
		echo '<div class="col-sm-4"><strong>'.$full_name.'</strong> <br />D.O.B. '.$display_dob.'<br />Gender: '.$gender.'</div>';
		echo '<div class="col-sm-3">Number of Post: 24</div>';
		echo '<div class="col-sm-4" style="text-align:right"><button id="search_open_close_button" class="btn btn-secondary"  onclick="show_model('.$kids_array[$x]['kid_id'].')"  style="margin-top:3px;" ><i class="fas fa-pencil-alt"></i> Edit</button> <button class="btn btn-secondary" onclick="load_interests('.$kids_array[$x]['kid_id'].')" ><a href="#" style="text-decoration:none ; color:#ffffff; " ><i class="fas fa-rocket"></i> Interests</a></button> <button class="btn btn-danger" ><a href="#" style="text-decoration:none ; color:#ffffff; " ><i class="fas fa-plus"></i> New Post</a></button></div>';
		echo '</div>';
	}
 ?>
    
  </div>


</div>


<!-- Large modal -->

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    	<div class="modal-header" style="background-color:#FF0000; color:#FFFFFF">
            <h5 class="modal-title" id="exampleModalLabel1">Modal 2 title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
      	</div>	
      	<div class="modal-body">
        <!-- BODY OF MODEL -->
        	<p class="error_text" style="font-weight:bold; color:#FF0000; "></p>
            <input type="hidden"  id="kid_id"  name="kid_id" value="0" />
        	<div class="row"  >
        		<div class="form-group col-md-4">
                	<label for="first_name" style="margin-top:20px">First Name <span style="color:#FF0000">*</span></label><br />
            		<input type="text" class="form-control" id="first_name"  name="first_name" placeholder="" value="" style="font-size:16px; padding:8px" maxlength="45" />
                </div>
                <div class="form-group col-md-4">
                	<label for="middle_name" style="margin-top:20px">Middle Name</label><br />
            		<input type="text" class="form-control"  id="middle_name" name="middle_name" placeholder="" value="" style="font-size:16px; padding:8px" maxlength="45" />
                </div>
                <div class="form-group col-md-4">
                	<label for="last_name" style="margin-top:20px">Last Name <span style="color:#FF0000">*</span></label><br />
            		<input type="text" class="form-control"  id="last_name" name="last_name" placeholder="" value="" style="font-size:16px; padding:8px" maxlength="45" />
                </div>
            </div>
            
            <div class="row"  >
        		<div class="form-group col-md-4">
                	<label for="birth_month" style="margin-top:20px">Birth Month <span style="color:#FF0000">*</span></label><br />
            		<select class="form-control"  id="birth_month" name="birth_month">
                    	<option value='0'></option>
                        <option value='01'>Janaury</option>
                        <option value='02'>February</option>
                        <option value='03'>March</option>
                        <option value='04'>April</option>
                        <option value='05'>May</option>
                        <option value='06'>June</option>
                        <option value='07'>July</option>
                        <option value='08'>August</option>
                        <option value='09'>September</option>
                        <option value='10'>October</option>
                        <option value='11'>November</option>
                        <option value='12'>December</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                	<label for="birth_day" style="margin-top:20px">Birth Day <span style="color:#FF0000">*</span></label><br />
            		<select class="form-control"  id="birth_day" name="birth_day">
                    	<option value="0"></option>
                        <?php
							for ($number=1; $number<32; $number++){
								$ends = array('th','st','nd','rd','th','th','th','th','th','th');
								if (($number %100) >= 11 && ($number%100) <= 13){
								   $abbreviation = $number. 'th';
								}else{
								   $abbreviation = $number. $ends[$number % 10];
								}
								
								if($number<10){
									$numberOut = "0".$number;
								}else{
									$numberOut = $number;
								}
								echo "<option value='$numberOut' >$abbreviation</option>";
							}
						?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                	<label for="birth_year" style="margin-top:20px">Birth Year <span style="color:#FF0000">*</span></label><br />
            		<select class="form-control" id="birth_year" name="birth_year" >
                    	<option value="0"></option>
                        <?php
							$year = date("Y");
							for ($x=$year; $x>($year-101); $x--){
								echo "<option value='$x' >$x</option>";
							}
						?>
                    </select>
                </div>
            </div>
            <div class="row"  >
            	<div class="form-group col-md-6">
                	<label for="town" style="margin-top:20px">Town / City <span style="color:#FF0000">*</span></label><br />
            		<input type="text" class="form-control"  id="town" name="town" placeholder="" value="" style="font-size:16px; padding:8px" maxlength="45" />
                </div>
                <div class="form-group col-md-6">
                	<label for="state" style="margin-top:20px">State <span style="color:#FF0000">*</span></label><br />
            		<select class="form-control" id="state" name="state" >
                    	<option value="0"></option>
                        <?php
							$year = date("Y");
							foreach ($state_list as $key=>$value){
								echo "<option value='$key' >$value</option>";
							}
						?>
                    </select>
                </div>
            </div>
            
            
            <div class="row"  >
            	<div class="form-group col-md-4">
                	<label for="kid_gender" style="margin-top:20px">Gender <span style="color:#FF0000">*</span></label><br />
            		<select class="form-control" id="kid_gender" name="kid_gender" >
                    	<option value="0"></option>
                        <option value="1">Male</option>
                        <option value="2">Female</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                	<label for="kid_status" style="margin-top:20px">Status</label><br />
            		<select class="form-control" id="kid_status" name="kid_status" >
                    	<option value=""></option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                	<label for="show_last_name" style="margin-top:20px">Show Last Name on Profile <span style="color:#FF0000">*</span></label><br />
            		<select class="form-control" id="show_last_name" name="show_last_name" >
                    	<option value=""></option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>
            
        <!-- END BODY OF MODEL -->
      	</div>
      	<div class="modal-footer">
        	<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-times-circle"></i> Cancel</button>
        	<button type="button" class="btn btn-primary" onclick="save_kid_data()"><i class="far fa-save"></i> Save</button>
            
      	</div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="interestModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#FF0000; color:#FFFFFF">
        <h5 class="modal-title" id="interestLabel">My Kid's Interests</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="interest_model_body" style="overflow-y:scroll; height:45%; max-height:350px">
      <input type="hidden" id="kid_id_holder" value="0" />
      <?php
	  	for($x=0; $x<count($full_interest_list); $x++){
			if($x%2==1){
				$bg = "#f5f5f5";
			}else{
				$bg = "#ffffff";
			}	
			echo '<div  style="background-color:'.$bg.';"  >';
            	echo "<table width=100%><tr><td width=90%>";
					
					echo '<label for="interest_'.$full_interest_list[$x]['interest_id'].'" >'.$full_interest_list[$x]['interest_title'].'</label> ';
					echo "</td><td>";
				
					echo '<input type="checkbox"  value="1" name="interest_'.$full_interest_list[$x]['interest_id'].'" id="interest_'.$full_interest_list[$x]['interest_id'].'" checked="checked" style="font-size:18px" />';
				echo "</td></tr></table>";	
			echo '</div>';
		}
	  ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="save_interests()">Save changes</button>
      </div>
    </div>
  </div>
</div>
