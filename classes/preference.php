<?php 


	class Preference {


		private  $db = null,
				$interests = array(),
				$session_name;

		public function __construct($user = null) {


				$this->db = db::get_instance();

				$this->session_name = config::get("session/session_name");


			if(!$user) {

				
					if(session::exist($this->session_name)) {

						$user = session::get($this->session_name);

						$this->find($user);
					}


			} else {

				$this->find($user);
			}

		}

		public function find($user) {

			// refactor later
			$user_id = $user;

			$user = $this->db->get('user_ints', array('user_id', '=', $user_id));

			if($user->count()) {

					$data =  (array) $user->first();

					$this->interests = array_filter($data);
					return true;
			}

		}


		public function update($fields = array()) {

			//check if session exist

			if(session::exist($this->session_name)) {

				$user_id = session::get($this->session_name);
				$interests['user_id'] = $user_id;
				$counter = 1;

				foreach($fields as $field) {

					$interests['interest_'.$counter] = $field;

					$counter +=1;

				}
				
				//delete interest first

				$delete = $this->db->delete('user_ints', array('user_id', '=', $user_id));

				if(!$delete) {

					return false;
						
				}

				

				$insert = $this->db->insert('user_ints', $interests);

				if($insert) {

					return true;
				}
 
				
			}

			return false;
		}


		public function data() {

			return $this->interests;
			
		}


	}