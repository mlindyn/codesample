<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
if(!isset($no_javascript)){
?>
<noscript>
    Javascript is disabled.
    <meta HTTP-EQUIV="REFRESH" content="0; url=<?php echo SITE_ROOT_TWO ?>error/index/2/"> 
</noscript>
<?php
}
?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
	<meta charset="utf-8">
	<title>
    <?php
	if($page == 'feed_index'){
		echo "KidShowcase - Live Feed";
	}else if($page == 'kids_index'){
		echo "KidShowcase - Kids List";
	}else{
		echo "KidShowcase";
	}
	?>
    </title>

	<link rel="stylesheet" href="<?php echo SITE_ROOT ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo SITE_ROOT ?>css/jquery-ui-1.10.0.custom.css">
    <link rel="stylesheet" href="<?php echo SITE_ROOT ?>css/main.css">
    <link rel="stylesheet" href="<?php echo SITE_ROOT ?>css/emojionearea.min.css">
    
    <?php
	if($page == 'feed_index'){
    	echo '<link rel="stylesheet" href="'. SITE_ROOT .'css/feed_index.css">';
   	}
	?>
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    
    <script type="text/javascript" src="<?php echo SITE_ROOT ?>js/jquery.min.js"></script>
    
    <script type="text/javascript" src="<?php echo SITE_ROOT ?>js/emojionearea.min.js"></script>
    
    <script type="text/javascript" src="<?php echo SITE_ROOT ?>js/jquery-ui-1.9.2.custom.min.js"></script>
    
    <script type="text/javascript" src="<?php echo SITE_ROOT ?>js/popper.min.js"></script>
    <script type="text/javascript" src="<?php echo SITE_ROOT ?>js/bootstrap.bundle.min.js"></script>
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
    
    
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo SITE_ROOT ?>images/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo SITE_ROOT ?>images/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo SITE_ROOT ?>images/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo SITE_ROOT ?>images/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo SITE_ROOT ?>images/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo SITE_ROOT ?>images/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo SITE_ROOT ?>images/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo SITE_ROOT ?>images/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo SITE_ROOT ?>images/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo SITE_ROOT ?>images/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo SITE_ROOT ?>images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo SITE_ROOT ?>images/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo SITE_ROOT ?>images/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?php echo SITE_ROOT ?>images/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo SITE_ROOT ?>images/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    
</head>
<body>
<?php

$ci = & get_instance();




echo "<!-- START MENU -->";
	echo  '
	<nav class="navbar navbar-expand-lg">
	  <a class="navbar-brand" href="'.SITE_ROOT_TWO.'"><img src="'.SITE_ROOT.'images/logo.png" /></a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" style="color:#FFFFFF">
		<span class="navbar-toggler-icon"><strong>|||</strong></span>
	  </button>
	
	  <div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">';
		
		if($ci->session->userdata('user_id')!==null){
		  echo '<li class="nav-item">
			<a class="nav-link" href="' . SITE_ROOT_TWO . 'feed">Home</a>
		  </li>';
		  }
		  
		   echo '
		  <!--
		  <li class="nav-item active">
			<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
		  </li>
		  -->
		 
		  <li class="nav-item dropdown" >
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="the_drop" title="Notifications" >
			  Areas Of Interest
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdown">
			  <a class="dropdown-item" href="'.SITE_ROOT_TWO.'sports/">Sports</a>
			  <a class="dropdown-item" href="'.SITE_ROOT_TWO.'arts/">Arts</a>
			  <a class="dropdown-item" href="'.SITE_ROOT_TWO.'academics/">Academics</a>
			  <a class="dropdown-item" href="'.SITE_ROOT_TWO.'outdoors/">Outdoor & Nature</a>
			  <a class="dropdown-item" href="'.SITE_ROOT_TWO.'entertaoinment/">Entertainment</a>
			  <div class="dropdown-divider"></div>
			  <a class="dropdown-item" href="#">View All Notifications</a>
			</div>
		  </li>
		  
		  <!--
		  <li class="nav-item">
			<a class="nav-link" href="'.SITE_ROOT_TWO.'sports/">Sports</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" href="'.SITE_ROOT_TWO.'arts/">Arts</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" href="'.SITE_ROOT_TWO.'academics/">Academics</a>
		  </li>
		  -->
		  <li class="nav-item">
			<a class="nav-link" href="'.SITE_ROOT_TWO.'academics/">Teachers & Coaches</a>
		  </li>
		  
		  ';
		  
		 
		  if($ci->session->userdata('user_id')!==null){
		  
		  $ci->load->model('connections_model');
			$awaitingConnectionsArray = $ci->connections_model->getAwaitingConnections($ci->session->userdata('user_id'));
			$currentConnectionsArray = $ci->connections_model->getCurrentConnections($ci->session->userdata('user_id'));
		  
		  echo '
		  <li class="nav-item dropdown" >
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="the_drop" title="Member Options" >
			  <i class="fa fa-user-circle" style="font-size:22px; margin-top:2px"></i>
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdown">
			  <a class="dropdown-item" href="' . SITE_ROOT_TWO . 'Teachers"><i class="fas fa-chalkboard-teacher"></i>&nbsp; Teachers & Coaches</a>
			  <a class="dropdown-item" href="' . SITE_ROOT_TWO . '"><i class="fas fa-home" ></i>&nbsp; '.$ci->session->userdata('user_full_name').' Home</a>
			  <a class="dropdown-item" href="' . SITE_ROOT_TWO . 'Profiles"><i class="far fa-address-card"></i>&nbsp; Profile Info</a>
			  
			  <a class="dropdown-item" href="' . SITE_ROOT_TWO . 'kids"><i class="fas fa-child" ></i>&nbsp; My Kids</a>
			  <a class="dropdown-item" href="' . SITE_ROOT_TWO . 'Photos"><i class="fas fa-camera"></i>&nbsp; Photos</a>
			  <a class="dropdown-item" href="' . SITE_ROOT_TWO . 'Videos"><i class="fas fa-film"></i>&nbsp; Videos</a>
			  <a class="dropdown-item" href="#"><i class="fas fa-envelope-square" ></i>&nbsp; Email Invites</a>
			  <a class="dropdown-item" href="#"><i class="far fa-calendar-alt"></i>&nbsp; Practice Schedules</a>
			  <a class="dropdown-item" href="#"><i class="fas fa-cog"></i>&nbsp; Account Settings</a>
			  <div class="dropdown-divider"></div>
			  <a class="dropdown-item" href="'.SITE_ROOT_TWO.'member/logout"><i class="fas fa-sign-out-alt" ></i>&nbsp; Log Out</a>
			</div>
		  </li>
		  
		  <li class="nav-item dropdown" >
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="the_drop" title="Notifications" >
			  <i class="fas fa-bolt" style="font-size:22px; margin-top:2px"></i>
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdown">
			  <a class="dropdown-item" href="">My Kids</a>
			  <a class="dropdown-item" href="#">Another action</a>
			  <div class="dropdown-divider"></div>
			  <a class="dropdown-item" href="#">View All Notifications</a>
			</div>
		  </li>
		  
		  
		  
		  <li class="nav-item dropdown" >
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="the_drop" title="Connections" >
			  <i class="fas fa-handshake" style="color:red; font-size:22px; margin-top:2px"></i>
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdown">
			  <a class="dropdown-item" href="#" onclick="show_current_connections()" >Current Connections ('.count($currentConnectionsArray).')</a>
			  <a class="dropdown-item" href="#"onclick="" >Connection Requests Awaiting ('.count($awaitingConnectionsArray).')</a>
			  <a class="dropdown-item" href="#"onclick="" >Suggested Connections</a>
			  
		  </li>
		  
		  ';
		  
		  }
		  
		  
		  
		 echo '
		  <!--<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			  Dropdown
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdown">
			  <a class="dropdown-item" href="#">Action</a>
			  <a class="dropdown-item" href="#">Another action</a>
			  <div class="dropdown-divider"></div>
			  <a class="dropdown-item" href="#">Something else here</a>
			</div>
		  </li>
		  <li class="nav-item">
			<a class="nav-link disabled" href="#">Disabled</a>
		  </li>-->
		</ul>';
		
		if($page=='sports_index'){
			
			echo '<button id="search_open_close_button" class="btn btn-success" onclick="show_hide_search()" ><i class="fa fa-search"></i> Search Players</button>&nbsp;';
			
		}
		
		if($ci->session->userdata('user_id')==null){
			if($page!='login'){	
				echo  '
					<button class="btn btn-primary" ><a href="' . SITE_ROOT_TWO . 'member/login" ><i class="fas fa-sign-in-alt"></i> Login</a></button>&nbsp; ';
			}
		}
		if($ci->session->userdata('user_id')!==null){
			if($page=='feed_index'){	  
				echo  '
				<button class="btn btn-danger" onclick="open__posting_model()" ><i class="fas fa-plus"></i> New Post</button>&nbsp;
				';
			}
		}
		
		
		echo '<!--
		<li class="nav-item dropdown hidden-md-down" style="list-style: none" >
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            
			<i class="fa fa-user-circle" style="font_size:75px"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item">Register</a>
            <a href="#" class="dropdown-item"><strong>Profile</strong></a>
            <a href="#" class="dropdown-item"><strong>My Jobs</strong></a>
            <a href="#" class="dropdown-item"><strong>My Searches</strong></a>
            <a href="#" class="dropdown-item"><strong>Employer Dashboard</strong></a>
            <a href="#" class="dropdown-item"><strong>Login</strong></a>
            <a href="#" class="dropdown-item">
              <div class="dropdown-divider"></div>
              <strong>Logout</strong>
            </a>
          </div>
        </li>
		-->
	</nav>
	';
echo "<!-- END MENU -->";
?>
<div id="main_dialog" ></div>
<div class="modal fade" id="headerModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#0066FF; color:#ffffff; border:none">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border:none">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="header_model_body" style="height:300px; overflow-y:scroll">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<div id="wrap">
  <div id="main" class="container clear-top">
    <!-- MAIN CONTENT -->
   <!-- Button trigger modal -->


<script>
	function show_current_connections(){
		$('#headerModel').modal('show');
	}
</script>
