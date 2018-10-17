<?php 

class User extends Preference {


	private $db = null,
	        $session_name,
	        $logged_in = false,
	        $preferences = array(),
	        $data = array();





	public function __construct($user = null)   {

		$this->db = db::get_instance();
		$this->session_name =  config::get('session/session_name');

		if(!$user) {

			if(session::exist($this->session_name)) {

				$user = session::get($this->session_name);

				if($this->find($user)) {

					$this->logged_in = true;
				}
			}

		} else {

			//just find user details


			$this->find($user);


			//get preferences of user

 			$preference = $this->db->get("user_Ints", array("user_id", '=', $user));

 			if($preference->count()) {

 				$new_data = sanitize::object($preference->first());



 				if(isset($new_data['user_id'])) {

 					unset($new_data['user_id']);
 				}


 				if(isset($new_data['id'])) {


 					unset($new_data['id']);
 				}


 				$this->preferences = $new_data;

 				//var_dump($this->preferences);

 				
 			}


			
		}

	}



	public function check_messages() {

		if(session::exist($this->session_name)) {


			$user_id = session::get("user");

			$sql = "select * from messages where receiver_id = ? and checked = ?";

			$fields = array(

				'receiver_id' => $user_id,
				'checked' => 0

			);

			$query = $this->db->query($sql, $fields);

			if($query->count()) {

				return count($query->result());
			}


			return false;
		}
	}


	public function send_message($fields) {

		$message = $this->db->insert('messages', $fields);

		if($message) {

			session::flash("success", "message successfully sent");
			return true;
		}

		return false;
	}





	public function create($fields) {

		$account = $this->db->insert('users', $fields);

		if($account) {

			session::flash("success", "your account ".input::get("username")." was successfully created");

				//return the last inserted row id;
			return $this->db->last_id();
		}

		return false;
	}






	public function update($fields = array()) {

		if(session::exist($this->session_name)) {

			$user_id = session::get($this->session_name);

			$update = $this->db->update('users', $fields, array('id', '=', $user_id));

			if($update) {

				session::flash('success', "Your details was successfully changed");

				return true;
			}
		}

		return false;

	}







	public function get_preferences($user_id = false) {

		if(!$user_id) {

			if(session::exist($this->session_name)) {

				$user_id = session::get($this->session_name);

				$preference = $this->db->get('user_ints', array('user_id', '=', $user_id));

				if($preference->count()) {

					return $preference->first();

				}
			}
		}

		return false;

	}





	public function create_interest($fields) {


		$check = $this->db->get('user_ints', array('user_id', '=', $this->data()->id));

		if(!$check->count()) {

			$interests = $this->db->insert('user_ints', $fields);

			if($interests) {

				$update_field = array(

					'profile_created' => 1
				);

				$this->db->update('users', $update_field, array('id', '=', $this->data()->id));
			}

			return true;
		}

		
		return false;
	}


	


	//get users with similar interest

	public function get_similar() {


		$data = array();

		//get user int

		$user_int = $this->db->get('user_ints', array('user_id', '=', $this->data()->id));




		if($user_int->count()) {

			//get the users interest

			$user_data = (array) $user_int->first();

			//remove if array returns null

			$act_data = array_filter($user_data);


			//get all users
			//$users = $this->db->get("users");

			$users_ints = $this->get_users_ints();


					//var_dump($act_data);

					//var_dump($users_ints);


			foreach($users_ints as $users_int) {


				if(count(array_intersect($act_data, $users_int)) > 0) {


					$users = $this->db->get('users', array('id', '=', $users_int['user_id']));

					if($users->count()) {

						$data[] = $users->first();
					}


				}					

			}


			if(!empty($data)) {

				return $this->sanitize($data);
			}


		}


		return false; 


	}




	public function get_users_ints() {

		$users = $this->db->get('user_ints');

		if($users->count()) {

			$datas = $this->sanitize($users->result());

			return $datas;
		}


		return false;

	}





	public function sanitize($fields) {

		$datas = array();

		foreach($fields as $field) {

			$datas[] = (array) $field;

		}

		foreach($datas as $data) {

			$act_datas[] = array_filter($data);
		}

		return $act_datas;

	}





	public function get_user_ints($user_id) {

		if($user_id) {

			$ints = $this->db->get('user_ints', array('user_id', '=', $user_id));

			if($ints->count()) {

				return $ints->first();
			}


		}
	}






	public function get_interests() {

			/*

			$interest = $this->db->get('user_interests', array('user_id', '=', $this->data()->id));

			if($interest->count()) {

				return $interest->first();
			}

			return  false;

		*/

		}






		public function similar_int($user_interests) {

			$users = $this->db->get('users');

			if($users->count()) {

				$interest = $this->db->get('user_interests', array('user_id', '=', $this->data()->id));

				var_dump($interest);
			}



		}





		public function find($user = null) {

			$field = (is_numeric($user)) ? 'id': 'username';

			$user = $this->db->get('users', array($field, '=', $user));

			if($user->count()) {

				$this->data = $user->first();

				return true;
			}

			return false;

		}






		public function login($username, $password) {

			$user = $this->find($username);

			if($user) {

				if($password == $this->data()->password) {

					session::put($this->session_name, $this->data()->id);
					return true;
				}
			}

			return false;
		}






		public function update_desired_location($user_id, $desired_location) {

			$fields = array(

					'desired_location' =>  $desired_location

			);

			$update = $this->db->update('users',$fields, array('id', '=', $user_id));

			if($update) {

				session::flash('success', 'Desired Location Successfully Changed!');

				return true;
			}
 		}






 		public function update_location($user_id, $location) {

 			$fields = array(
 				'location' => $location

 			);

 			$update = $this->db->update('users', $fields, array('id', '=',  $user_id));

 			if($update) {

 				session::put("success", "You have successfully changed your location");

 				return true; 
 			}

 			return false;
 			
 		}




		//general getters and setters


		public function get_prefences() {

			return $this->preferences; 

		}


		public function exist() {

			return (!empty($this->data)) ? true: false;
		}

		public function logout() {

			session::delete($this->session_name);
			
		}
		public function data() {

			return $this->data;

		}

		public function logged_in() {

			return $this->logged_in;

		}
	}