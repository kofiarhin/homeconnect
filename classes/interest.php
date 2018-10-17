<?php 

	class Interest {

		private $db,
				$errors = array(),
				$passed = false;

		public  function __construct() {

				$this->db = db::get_instance();

		}


		public function checks($fields) {

				if(count($fields) > 4) {

					$this->add_error("You cannot select more than 4 interest");
				}


				if(empty($fields)) {

					$this->add_error("You need to select at least one interest");
				}


				if(empty($this->errors)) {

					$this->passed = true;
				}

				return $this;
		}


		public function create($user_id, $fields) {


			$counter = 1;

			$new_fields['user_id'] = $user_id;

			foreach($fields as $field) {

				$new_fields['interest_'.$counter] = $field;

				$counter ++;

			}

			$interest = $this->db->insert('user_ints', $new_fields);

			if($interest) {

				echo " interest created";

				return true;
			}

			return false;
		}


		public function add_error($error) {

			$this->errors[] = $error;
		}


		public function passed() {

			return $this->passed;
		}


		public function errors() {

			return $this->errors;
		}
	}