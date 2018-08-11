<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Feed_model extends CI_Model{
	
	private $db;
	
	function __construct(){
		parent:: __construct();
		
		$this->db = new MysqliDb ();
		//$this->cs = new cleanString ();
	}
	
	public function getMediaFromFeedPageId($feed_page_id){
		
		$this->db->where ('feed_page_id', $feed_page_id);
		$mediaData = $this->db->withTotalCount()->get('media_tbl');
		$num_rows = $this->db->totalCount;
		
		if($num_rows==1){
			return $mediaData;
		}else{
			return 0;
		}
		
	}
	
	public function getMediaFromKidPostId($kid_post_id){
		
		$this->db->where ('kid_post_id', $kid_post_id);
		$mediaData = $this->db->withTotalCount()->get('media_tbl');
		$num_rows = $this->db->totalCount;
		
		if($num_rows==1){
			return $mediaData;
		}else{
			return 0;
		}
		
	}
	
	public function editFeedPost($kid_post_id, $user_id, $post_text, $post_type, $feed_page_id){
		
		if(!isset($kid_post_id)){
			exit();
		}
		
		$post_array['user_id'] = $user_id;
		//$post_array['kid_post_text'] = $this->db->createCleanSQLString($post_text);
		$post_array['kid_post_text'] = $post_text;
		$post_array['kid_post_type'] = $post_type;
		$post_array['feed_page_id'] = $feed_page_id;
		$post_array['kid_post_last_edit'] = time();
		
		$this->db->where('kid_post_id', $kid_post_id);
		$this->db->update('kid_posts_tbl', $post_array);
		
		
	}
	
	
	
	public function insertNewFeedPost($user_id, $post_text, $post_type, $feed_page_id){
		
		$post_array['user_id'] = $user_id;
		//$post_array['kid_post_text'] = $this->db->createCleanSQLString($post_text);
		$post_array['kid_post_text'] = $post_text;
		$post_array['kid_post_type'] = $post_type;
		$post_array['feed_page_id'] = $feed_page_id;
		$post_array['kid_post_created'] = time();
		
		
						
		if(! $id = $this->db->insert ('kid_posts_tbl', $post_array)){
			
		}
		
		if ($this->db->getLastErrno() === 0)
    		$id = $id;
		else
    		$id = $this->db->getLastError();
		
		return $id;
	}
	
	public function insertPostComment($user_id, $comment_text, $kid_post_id){
		
		$post_array['user_id'] = $user_id;
		//$post_array['kid_post_text'] = $this->db->createCleanSQLString($post_text);
		$post_array['comment_text'] = $comment_text;
		$post_array['kid_post_id'] = $kid_post_id;
		$post_array['comment_timestamp'] = time();
		
		$id = $this->db->insert ('kid_post_comment_tbl', $post_array);
			
		return $id;
	}
	
	public function getPostComment($kid_post_id, $start=0, $limit=25){
		
		$feedPosts = $this->db->rawQuery("SELECT * FROM kid_post_comment_tbl WHERE kid_post_id = $kid_post_id  ORDER BY comment_timestamp LIMIT $start, $limit");

		return $feedPosts;
	}
	
	public function deleteKidsFromFeedPost($kid_post_id){
		
		$this->db->where('kid_post_id', $kid_post_id);
		$this->db->delete('kid_post_to_kid_tbl');
		
	}
	
	public function addKidToFeedPost($kid_id, $kid_post_id){
		
		$post_array['kid_id'] = $kid_id;
		$post_array['kid_post_id'] = $kid_post_id;
								
		$id = $this->db->insert ('kid_post_to_kid_tbl', $post_array);
		
		return $id;
	}
	
	public function deleteInterestsFromFeedPost($kid_post_id){
		
		$this->db->where('kid_post_id', $kid_post_id);
		$this->db->delete('kid_post_to_interest_tbl');
		
	}
	
	public function addInterestToFeedPost($interest_id, $kid_post_id){
		
		$post_array['interest_id'] = $interest_id;
		$post_array['kid_post_id'] = $kid_post_id;
								
		$id = $this->db->insert ('kid_post_to_interest_tbl', $post_array);
		
		return $id;
	}
	
	public function addMediaToFeedPost($media_id, $kid_post_id){
		
		$post_array['media_id'] = $media_id;
		$post_array['kid_post_id'] = $kid_post_id;
								
		$id = $this->db->insert ('kid_post_to_media_tbl', $post_array);
		
		return $id;
	}
	
	public function deleteMediaFromFeedPost($media_id){
		
		$this->db->where('media_id', $media_id);
		$this->db->delete('kid_post_to_media_tbl');
		
	}
	
	public function getFeedPosts($user_id, $connections_array, $offset=0, $count=15 ){
		
		$connect_string = '';
		
		for($x=0; $x<count($connections_array); $x++){
			
			if($x>0){
			$connect_string .= ", ";
			}
			
			$connect_string .= $connections_array[$x]['user_id'];
			
		}
		
		$feedPosts = $this->db->rawQuery("SELECT * FROM kid_posts_tbl WHERE user_id = $user_id OR ( user_id IN ( $connect_string ) AND kid_post_type > 1 ) OR kid_post_type = 3 ORDER BY kid_post_created DESC LIMIT 0, 14");

		return $feedPosts;

	}
	
	
	public function getFeedPostFromPostId($user_id, $kid_post_id){
		
		$connect_string = '';
		
		$this->db->where ('user_id', $user_id);
		$this->db->where ('kid_post_id', $kid_post_id);
		
		$post_data = $this->db->withTotalCount()->get('kid_posts_tbl');
		$num_rows = $this->db->totalCount;
		//echo $num_rows;
		return $post_data;

	}
	
	public function getKidsIdToKidPost($kid_post_id){
		$this->db->where ('kid_post_id', $kid_post_id);
		$kidIdData = $this->db->withTotalCount()->get('kid_post_to_kid_tbl');
		$num_rows = $this->db->totalCount;
		//echo $num_rows;
		return $kidIdData;
	}
	
	public function getKidsToKidPost($kid_post_id){
		$this->db->where ('kid_post_id', $kid_post_id);
		$kidIdData = $this->db->withTotalCount()->get('kid_post_to_kid_tbl');
		$num_rows = $this->db->totalCount;
		
		$ci = & get_instance();
		$ci->load->helper("age_from_date");
		
		if($num_rows>0){
			
			$return_array = array();
			//print_r($kidIdData);
			for($f=0; $f<count($kidIdData); $f++){
				$this->db->where ('kid_id', $kidIdData[$f]['kid_id']);
				$kidData = $this->db->withTotalCount()->get('kids_tbl');
				
				$return_array[$f]['kid_first_name'] = $kidData[0]['kid_first_name'];
				$return_array[$f]['kid_middle_name'] = $kidData[0]['kid_middle_name'];
				$return_array[$f]['kid_last_name'] = $kidData[0]['kid_last_name'];
				$return_array[$f]['kid_dob'] = $kidData[0]['kid_dob'];
				$return_array[$f]['kid_city'] = $kidData[0]['kid_town_city'];
				$return_array[$f]['kid_state'] = $kidData[0]['kid_state'];
				$return_array[$f]['kid_age'] = getAgeFromDate($kidData[0]['kid_dob']);
				$return_array[$f]['show_last_name'] = $kidData[0]['show_last_name'];
				
			}
			
			return $return_array;
			
		}else{
			return 0;
		}
	}
	
	public function getInterestIdToKidPost($kid_post_id){
		$this->db->where ('kid_post_id', $kid_post_id);
		$interestIdData = $this->db->withTotalCount()->get('kid_post_to_interest_tbl');
		$num_rows = $this->db->totalCount;
		
		return $interestIdData;

	}
	
	public function getInterestToKidPost($kid_post_id){
		$this->db->where ('kid_post_id', $kid_post_id);
		$interestIdData = $this->db->withTotalCount()->get('kid_post_to_interest_tbl');
		$num_rows = $this->db->totalCount;
		
		if($num_rows>0){
			
			$return_array = array();
			//print_r($kidIdData);
			for($f=0; $f<count($interestIdData); $f++){
				$this->db->where ('interest_id', $interestIdData[$f]['interest_id']);
				$interestData = $this->db->withTotalCount()->get('interest_tbl');
				
				$return_array[$f]['interest_title'] = $interestData[0]['interest_title'];
				
				
			}
			
			return $return_array;
			
		}else{
			return 0;
		}
	}
	
	public function getMediaToKidPost($kid_post_id){
		$this->db->where ('kid_post_id', $kid_post_id);
		$mediaIdData = $this->db->withTotalCount()->get('kid_post_to_media_tbl');
		$num_rows = $this->db->totalCount;
		
		if($num_rows>0){
			
			$return_array = array();
			//print_r($mediaIdData);
			//echo count($mediaIdData);
			$image_count =0;
			for($f=0; $f<count($mediaIdData); $f++){
				$this->db->where ('media_id', $mediaIdData[$f]['media_id']);
				$this->db->where ('confirmed_post', 1);
				$this->db->where ('awaiting_convertion', 0);
				$mediaData = $this->db->withTotalCount()->get('media_tbl');
				
				$return_array[$f]['media_id'] = $mediaData[0]['media_id'];
				$return_array[$f]['filename'] = $mediaData[0]['filename'];
				$return_array[$f]['media_type_id'] = $mediaData[0]['media_type_id'];
				$return_array[$f]['uploaded_as'] = $mediaData[0]['uploaded_as'];
				$return_array[$f]['file_ext'] = $mediaData[0]['file_ext'];
				if($mediaData[0]['media_type_id']==1){
					$image_count++;
				}	
			}
			$return_array['image_count']=$image_count;
			return $return_array;
			
		}else{
			return 0;
		}
	}
	
	public function countFeedThumbsUp($kid_post_id){
		$this->db->where ('kid_post_id', $kid_post_id);
		$this->db->where ('thumb_type', 1);
		$count = $this->db->getValue ("kid_post_thumb_tlb", "count(*)");
		
		return $count;
	}
	
	public function didIThumbsUpThisPost($kid_post_id, $user_id){
		$this->db->where ('user_id', $user_id);
		$this->db->where ('kid_post_id', $kid_post_id);
		$this->db->where ('thumb_type', 1);
		$count = $this->db->getValue ("kid_post_thumb_tlb", "count(*)");
		
		return $count;
	}
	
	public function thumbsUpThisPost($kid_post_id, $user_id){
		$data['user_id']=$user_id; 
		$data['kid_post_id']=$kid_post_id;
		$data['thumb_timestamp']=time();
		$data['thumb_type']=1;
		
		$id = $this->db->insert ('kid_post_thumb_tlb', $data);
	}
	
	public function removeThumbsUpFromThisPost($kid_post_id, $user_id){
		$this->db->where ('user_id', $user_id);
		$this->db->where ('kid_post_id', $kid_post_id);
		
		$this->db->delete('kid_post_thumb_tlb');
	}
	
	
	
}
		