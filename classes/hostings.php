<?php 


 	class Hostings {


 		private $db = null;



 		public function __construct() {


 			$this->db = db::get_instance();



 		}


 		public  function check_hosting($user_id, $person_id) {

 					$sql = "select * from requests where
					
 					 requests.user_id = ? and requests.person_id = ?";


 					$fields = array(

 						'user_id' => (int) $person_id,
 						'person_id' => (int) $user_id

 					);

 					$query = $this->db->query($sql, $fields);

 					if($query->count()) {

 						return $query->first();
 					}


 					return false;

 		}



 	}