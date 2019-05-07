<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;

use App\Libraries\ImageResizeClass;

use App\Kidpost as Kidpost;
use App\Kid as Kid;
use App\Interest_kidpost as IK;
use App\Kid_kidpost as KK;
use App\Kidpost_media as KM;
use App\Interest as Interest;
use App\Media as Media;
use FFMpeg;
use FFProbe;

$the_user_id = null;
$the_connect_string = null;

class FeedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
                
    }

    public function index(request $request){
        
        $user = Auth::user();
        $user_id = $user->id;

        $data = array();
        $data['user_id']=$user_id;
        $data['page_id']="feed";
        $this->the_user_id = $user_id;

        $k = Kid::query();
        $k->where(function ($query) {
            $query->where('user_id', $this->the_user_id);
            $query->where('status', 1);
        });
        $k->orderBy('dob', 'desc');
        $data['kids_array'] = $k->get();

        $i = Interest::query();
        $i->orderBy('title', 'asc');
        $data['interest_array'] = $i->get();

        $connections_array = $user->allUserConnections();
        //echo count($user_connections);
        $connect_string = '';
        $y = 0;
        foreach ($connections_array as $uc){
            if($uc->user_id_1 != $user->id){
                if($y!=0){ $connect_string .= ','; }
                $connect_string .= $uc->user_id_1;
            }
            if($uc->user_id_2 != $user->id){
                if($y!=0){ $connect_string .= ','; }
                $connect_string .= $uc->user_id_2;
            }
            $y++;
        }

        $this->the_connect_string = explode(",",$connect_string);

        if(!isset($request['par_id'])){
            $par_id = 0;
        }else{
            $par_id = $request['par_id'];
        }
        

		$par_connected = 0;
		if($par_id!=0){
			for($x=0; $x<count($connections_array); $x++){
				if($par_id==$connections_array[$x]['user_id']){
					$par_connected = 1;
				}
			}
		}
        
        // POST_TYPE 1 = Invite Only
        // POST_TYPE 2 = Friends
        // POST_TYPE 3 = Public
        if(!isset($request['filter'])){
            $filter = 0;
        }else{
            $filter = $request['filter'];
        }

        if(!isset($request['ch_id'])){
            $ch_id = 0;
        }else{
            $ch_id = $request['ch_id'];
        }

        
		if($filter==0){  // ALL POST 
			if(count($connections_array)>0){
            
                $q = Kidpost::query();
                $q->where(function ($query) {
                    $query->where('user_id', $this->the_user_id);
                })->orWhere(function($query) {
                    $query->whereIn('user_id', $this->the_connect_string)
                        ->where('post_type', '>', 1);	
                })->orWhere(function($query) {
                    $query->where('post_type', 3);	
                });
                $q->orderBy('created_at', 'desc');
                $data['feed_posts'] = $q->get();

                   
			}else{
				
                //$feedPosts = Kidpost::select("SELECT * FROM kidposts WHERE user_id = $user_id  OR post_type = 3 ORDER BY created_at DESC")->paginate(10);  
                $q = Kidpost::query();
                $q->where(function ($query) {
                    $query->where('user_id', $this->the_user_id);
                })->orWhere(function($query) {
                    $query->where('post_type', 3);	
                });
                $q->orderBy('created_at', 'desc');
                $data['feed_posts'] = $q->get();
         
			}
		}
		
		if($filter==1){  // ONLY MY POST 
            
            //$feedPosts = DB::raw("SELECT * FROM kidposts WHERE user_id = $user_id ORDER BY created_at DESC"); 
            $q = Kidpost::query();
            $q->where(function ($query) {
                $query->where('user_id', $this->the_user_id);
            });
            $q->orderBy('created_at', 'desc');
            $data['feed_posts'] = $q->get();

				
		}
		
		if($filter==2){  // ONLY CONNECTIONS POST 
						
            //$feedPosts = DB::raw("SELECT * FROM kidposts WHERE ( user_id IN ( $connect_string ) AND post_type > 1 ) ORDER BY created_at DESC");
            $q = Kidpost::query();

            $q->whereIn('user_id', $this->the_connect_string);
            $q->orderBy('created_at', 'desc');
            $data['feed_posts'] = $q->get();
            
        }
		
		if($filter==3){  // ONLY PUBLIC POST 
						
            //$feedPosts = DB::raw("SELECT * FROM kidposts WHERE  post_type = 3 ORDER BY created_at DESC");
            $q = Kidpost::query();

            $q->where('post_type', 3);
            $q->orderBy('created_at', 'desc');
            $data['feed_posts'] = $q->get();
            
    
		}
		
		if($filter==777){ // MY KID 
            
            
            $data['feed_posts'] = DB::raw("SELECT * FROM kidposts WHERE  user_id = $user_id AND Id IN(SELECT kidpost_id FROM kidpost_kids WHERE kid_id=$ch_id) ORDER BY created_at DESC");

		}

		if($filter==778){ // OTHER PERSON'S POST
           
			if($par_connected == 1){
				$extender = " post_type > 1 ";
			}else{
				$extender = " post_type = 3 ";	
            }
            $data['feed_posts'] = DB::raw("SELECT * FROM kidposts WHERE  user_id = $par_id AND $extender ORDER BY created_at DESC");
			
		}

		if($filter==788){ // OTHER PERSON'S POST FOR A PARTICULAR KID
			
			if($par_connected == 1){
				$extender = " kid_post_type > 1 ";
			}else{
				$extender = " kid_post_type = 3 ";	
			}

            $data['feed_posts'] = DB::raw("SELECT * FROM kidposts WHERE  user_id = $par_id AND Id IN(SELECT kidpost_id FROM kid_post_to_kid_tbl WHERE kid_id=$ch_id) AND $extender ORDER BY created_at DESC");
			
		}
        

        $mediaModel = Media::find(1);
        return \View::make("feed")->with("data",$data)->withModel("mediaModel",$mediaModel);

    }

    public function createEdit($edit_id=0){
        $data=array();
        $user = Auth::user();
        $user_id = $user->id;
        
        $i = Interest::query();
        $i->orderBy('title', 'asc');
        $data['interests_list'] = $i->get();

        $post_data='';
        if($edit_id!=0){
            $post_data = Kidpost::find($edit_id);
            
            $arr = (array)$post_data;
            if (empty($arr)) {
                return redirect('error')->withErrors('You do not have permission to edit this file');// do stuff
            }

            if($post_data->user_id!=$user_id){
                return redirect('error')->withErrors('You do not have permission to edit this file');
            }
            
        }
        $data['post_data']=$post_data;
        $data['edit_id']=$edit_id;
        $data['user']=$user;
        
        return \View::make("feed_create_edit")->with("data",$data);
    }


    public function processCreateEdit(request $request){

        $user = Auth::user();
        $user_id = $user->id;
        $file_count = 1;
        
        
        
        $post_type = $request['post_type'];
        $post_text = $request['post_text'];
        $edit_id = $request['edit_id'];

        if($edit_id==0){
            $kidpost = new Kidpost;
            $kidpost->user_id = $user_id;
            $kidpost->post_type = $post_type;
            $kidpost->post_text = $post_text;
            $kidpost->save();

            $kidpost_id = $kidpost->id;
        }else{

        }
       
        foreach ($request['interest_select'] as $interest){
            $ik = new IK;
            $ik->kidpost_id = $kidpost_id;
            $ik->interest_id = $interest;
            $ik->save();
        }

        foreach ($request['kid_select'] as $kid){
            $ik = new KK;
            $ik->kidpost_id = $kidpost_id;
            $ik->kid_id = $kid;
            $ik->save();
        }
        

        
        if(isset($request['my_file'])){
            foreach ($request['my_file'] as $file){
            
                if(!$file->isValid()){
                    $error = 1;
                    $status = 0;
                    $msg = "There was a problem uploading this file."; 
                }else{
                    
                    $file_ext = strtolower(pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION));
                    $uploaded_as = $file->getClientOriginalName();
                    $file_type = $file->getMimeType();
                    $new_filename = time().'_'.$file_count.'_'.$user_id;
                    $file_count++;

                    
                    if($file_ext == "jpg" || $file_ext == "jpeg" || $file_ext == "swf" || $file_ext == "tiff" || $file_ext == "gif" || $file_ext == "png"){

                        
                        $ImageResizeClass = new ImageResizeClass;
                        $img = $ImageResizeClass->resizeAndStoreImage($file->getRealPath(), $new_filename);

                        $full_new_filename = $new_filename.".jpg";

                        $mediaType = 1;
                        $error = 0;
                        $status = 1;
                        $msg = "";
    

                    }else if ($file_ext=='doc' || $file_ext=='docx' || $file_ext=='xlsx' || $file_ext=='csv' 
                    || $file_ext=='xls' || $file_ext=='pdf' || $file_ext=='txt' || $file_ext=='ppt' 
                    || $file_ext=='pptx' || $file_ext=='zip' || $file_ext=='wav' || $file_ext=='mp3' 
                    || $file_ext=='ai' || $file_ext=='psd' || $file_ext=='rtf'){

                        $full_new_filename = $new_filename.".".$file_ext;
                        $file->move("media_files\\", $full_new_filename);

                        $mediaType = 5;
                        $error = 0;
                        $status = 1;
                        $msg = "";

                    }else if ($file_ext=='mov'  || $file_ext=='mp4' ){

                        $full_new_filename = $new_filename.".".$file_ext;
                        
                        $file->move("media_files\\", $full_new_filename);
                        
                        $sec = 1;
                        $movie = "media_files\\".$full_new_filename;
                        $thumbnail = "media_files\\".$new_filename.'.png';
                        $ffmpeg = FFMpeg\FFMpeg::create([
                            'ffmpeg.binaries'  => 'C:/FFmpeg/bin/ffmpeg.exe',
                            'ffprobe.binaries' => 'C:/FFmpeg/bin/ffprobe.exe',
                            'timeout'          => 3600, // the timeout for the underlying process
                            'ffmpeg.threads'   => 1,   // the number of threads that FFMpeg should use
                        ]);
                        //$ffmpeg = FFMpeg\FFMpeg::create();
                        $video = $ffmpeg->open($movie);
                        $frame = $video->frame(FFMpeg\Coordinate\TimeCode::fromSeconds($sec));
                        $frame->save($thumbnail);
                        

                        $mediaType = 10;
                        $error = 0;
                        $status = 1;
                        $msg = "";

                    }else{

                        $error = 1;
                        $status = 0;
                        $msg = "Invalid file type.";
                        
                    }


                }
                ///// Store Media to DB /////
                
                $media = new Media;
                $media->user_id = $user_id;
                $media->media_type_id = $mediaType;
                $media->uploaded_as = $uploaded_as;
                $media->filename = $full_new_filename;
                $media->file_ext = $file_ext;
                $media->file_type = $file_type;
                $media->error = $error;
                $media->error_msg = $msg;
                $media->kidpost_id = $kidpost_id;
                $media->save();

                $media_id = $media->id;

                $km = new KM;
                $km->media_id = $media_id;
                $km->kidpost_id = $kidpost_id;
                $km->save();
                /////

                
            }

        }


       
    }
}
