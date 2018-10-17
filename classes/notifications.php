<?php 

	 class Notifications {



	 		private $db = null,

	 				$data = array();


	 		public function __construct($user = false) {

	 			$this->db = db::get_instance();

	 			$this->sesion_name = config::get('session/session_name');

	 			if(!$user) {

	 				$user_id = session::get($this->sesion_name);

	 				//echo $user_id;

	 				$this->find($user_id);

	 				
	 			}
	 		}


	 		public function find($id) {


	 				$data = $this->db->get('notifications', array('receiver_id', '=', $id));

	 				if($data->count()) {

	 					$this->data = $data->result();

	 					//echo "found";

	 					return true;
	 				}


	 				return false;

	 		}


	 		public function check_note($id) {

	 			$sql = "select * from notifications where receiver_id = ? and checked = ?";

	 			$fields = array(

	 				'receiver_id' => (int) $id, 
	 				'checked' => 0

	 			);



	 		$query = $this->db->query($sql, $fields);

	 		if($query->count()) {


	 			return count($query->result());
	 		}

	 		return false; ; 
	 		//var_dump($fields);
	 		}



	 		public function get_request_id($user_id, $person_id) {

	 			

	 			$sql = "select id from requests where user_id = ? and person_id = ? ";

	 			$fields = array(

	 				'user_id' => (int)$person_id,
	 				'person_id' => (int) $user_id
	 			);


	 			$query = $this->db->query($sql, $fields);

	 			if($query->count()) {

	 				return (int) $query->first()->id;
	 			}


	 			return false;
	 		}




	 		public function get_notification($user_id = false) {

	 			echo $user_id;
	 		}


	 		public function exist() {

	 			return (!empty($this->data)) ? true : false; 
	 		}


	 		public function data() {

	 			return $this->data;
	 		}


	 }