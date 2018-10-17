<?php 

	class Upload  {

		private $db,
				$file_name,
				$file_ext,
				$file_new_name,
				$file_size,
				$file_tmp_name,
				$file_error,
				$errors = array(),
				$allowed = array('jpg', 'png', 'jpeg'),
				$passed = false, 
				$file_destination = "uploads";


		public function __construct() {

			$this->db = db::get_instance();
		}

		public function check($file) {

				$this->file_name = $file['name'];
				$this->file_tmp_name = $file['tmp_name'];

				$this->file_ext = $this->get_file_ext($this->file_name);


				//check if file extention is allowed
				if(!in_array($this->file_ext, $this->allowed)) {

						$file_type = $this->file_ext;
						$this->add_error("File type {$file_type} is not allowed");


				}


				//check file size



				if($this->file_size > 12220) {

					$this->add_error("file size too huge");
				}


				if(empty($this->errors)) {


					$this->passed = true;
				}

				return $this;

		}


		public function upload() {

			$file_new_name = uniqid('', true).".".$this->file_ext;

			$destination = "uploads/".$file_new_name;

			if(move_uploaded_file($this->file_tmp_name, $destination)) {

				//update the database


				if(session::exist('user')) {


						$user_id = session::get('user');

						//update the users tabale

						$fields = array(

							'profile_pic' => $file_new_name
						);


						//update


						$update = $this->db->update('users', $fields, array('id', '=', $user_id));

						if($update) {

							session::flash("success", "Profile Picture successfully changed");
							return true;
						}


				}
			}


			return false;
		}


		public function get_file_ext($file_name) {

			$file_ext = explode(".", $file_name);

			$file_act_ext = strtolower(end($file_ext));

			return $file_act_ext;
		}


		public function add_error($error) {

			$this->errors[] = $error;
		}
  

		public function passed() {

			return $this->passed;
		}
	}