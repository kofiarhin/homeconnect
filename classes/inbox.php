<?php 


	class Inbox  {




			private $db = null,
					$session_name = null;



			public function __construct() {


				$this->db = db::get_instance();

				$this->session_name = config::get("session/session_name");
			}



			public function get_conversation() {


					echo session::get('user');


					if(session::exist($this->session_name)) {


						$user = session::get('user');


						$sql = "select conversation_id from conversation_members";




						$query = $this->db->query($sql);

						if($query->count()) {

							$all_convo  = $query->result();


							//convert all object to arrays to
							//so i can use the array_intersect function

							foreach($all_convo as $convo) {

									$conversations[] = sanitize::object($convo);

							}


							$all_con_ids = sanitize::flatten($conversations);

							


							// get al user convo 


							$sql = "select conversation_id from conversation_members where user_id = ?";

							$fields  = array(

								'user_id' => $user
							);


							$query = $this->db->query($sql, $fields);


							if($query->count()) {


								$user_convo = $query->result();


								//sanitize object

								//var_dump($user_convo);

								//var_dump($user_convo);


								$user_ids = array();

								foreach($user_convo as $convo) {

									$user_ids [] = (array) $convo;

								}

								$user_con_ids  = sanitize::flatten($user_ids);


								$common_fields = array_unique(array_intersect($all_con_ids, $user_con_ids));

								

								//get conversation members of with the conversation id

							foreach($common_fields as $con_id) {

									$sql = "select * from conversation_members

									inner join users

									on conversation_members.user_id = users.id


									 where conversation_id = ? and user_id != ?";

									$fields = array(

										'conversation_id' => $con_id,
										'user_id' => session::get('user') 

									);


									$query = $this->db->query($sql, $fields);

									if($query->count()) {

										var_dump($query->result());


									}

							}





								//var_dump($conversations);

								//var_dump($user_convo);




								



							}


						}

			}

		}


	}