<?php 


	class Request {

		private $db = null,
				$data  = array(),

				$errors = array(); 




		public function __construct($user = false) {

			$this->db = db::get_instance();

			$this->session_name = config::get("session/session_name");


			if(!$user) {

				if(session::exist($this->session_name)) {

					$user_id = session::get('user');


					$this->data = $this->get_request($user_id);

					//var_dump($this->data);
					
				}
			}



		}


		public function check_request() {


			if(session::exist($this->session_name)) {


				$user = session::get($this->session_name);

				$sql = "select * from requests where person_id = ? and checked = ?";

				$fields = array(

					'person_id' => $user,
					'checked' =>  0
				);


				$query = $this->db->query($sql, $fields);

				if($query->count()) {

					return count($query->result());
				}


				return false;


			}



		}


		public function check_exist($user_id, $person_id) {


				$sql = "select * from requests where user_id = ? and person_id = ?";

				$fields = array(

					'user_id' => $user_id,
					'person_id' => $person_id

				);

				$query = $this->db->query($sql, $fields);

				if($query->count()) {


						return $query->first();
					
				}


				return false;
		}



		public function accept($id) {

							

				$fields = array(

					'request_status' => 2
				);





				$update = $this->db->update('requests', $fields, array('id', '=', $id));

				if($update) {

					session::flash("success", "you have successfully accepted hosting");
					
					return true;
				}

				return false;
		}


		public function get_request($user_id) {

			//echo $user_id;

			$sql = "select users.id as user_id, users.first_name, users.last_name,  users.profile_pic, requests.start_date, requests.id as request_id,  requests.end_date, requests.request_status  from requests 

			inner join users

			on requests.user_id = users.id

			where requests.person_id = ?";

			$fields = array(

				'person_id' => $user_id
			);


			$query = $this->db->query($sql, $fields);


				if($query->count()) {

					return $query->result();
				}

				return false;
		}


		public function delete($id) {

			$delete = $this->db->delete('requests', array('id', '=', $id));

			if($delete) {


				echo "request deleted";

				session::flash('success', 'Request successfully deleted');
				return true;

			}

			return false;
		}


		public function exist() {

			return (!empty($this->data)) ? true : false;
		}


		public function create_request($fields = array()) {



			//check if request already exist

			$user_id = $fields['user_id'];

			$person_id = $fields['person_id'];


			if(!$this->find($fields['user_id'], $fields['person_id'])) {

				$request = $this->db->insert('requests', $fields);

				if($request) {

					echo "request sent";

					//insert into notifications new notification

					$note_fields = array(

						'receiver_id' => $person_id,
						'sender_id' => $user_id, 
						'note_type' => 1,
						'created_on' =>  date("Y-m-d H:i:s"),
						'checked' => 0

					);

					$insert = $this->db->insert('notifications', $note_fields);

					if($insert) {

						echo "note sent";
						session::flash("success", "Request Successfully sent");
						return true;
					}

					
				}

				return false;
			}


			$this->errors[] = $this->add_error("Request already Exist");

			return false;

			//$this->find($fields['user_id'], $fields['person_id']);


			
		}


		public function errors() {

			return $errors = array_filter($this->errors);
			
		}


		public function add_error($error) {


			$this->errors[] = $error; 
		}


		public function find($user_id, $person_id) {



			$sql = "select * from requests where user_id = ? and person_id = ?";

			$fields = array(

				'user_id' => $user_id,
				'person_id' => $person_id

			);


			$query = $this->db->query($sql, $fields);

			if($query->count()) {

				//var_dump($query->result());


				if($query->first()->request_status == 1) {


					//echo "request already exist";
					return true;
				}



				return false;
			}
		}




		public function data() {

			return $this->data;
		}
	}