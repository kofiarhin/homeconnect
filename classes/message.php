<?php 


	class Message {

		
			private $db = null,
					$session_name = null,
					$messages = array();


			public function __construct() {

				$this->db = db::get_instance();

				$this->session_name = config::get('session/session_name');
			}



			public function get_messages() {


				if(session::exist($this->session_name)) {


						$receiver_id = session::get($this->session_name);

						$datas = $this->db->get('messages', array('receiver_id', '=', $receiver_id));


						if($datas->count()) {

							return $datas->result();
						}


				}

				return false;
			}

			public function checked($message_id) {

				$fields = array(

					'checked' => 1
				);

				$update = $this->db->update('messages', $fields, array('id', '=', $message_id ));

				if($update) {

					//echo "updated";

					return true;
				}

				return false;
			}






			public function get_message($id = false) {

				$sql = "select messages.id as message_id, messages.content, messages.created_on,  users.first_name, users.last_name, users.id as sender_id, users.profile_pic from messages 

					inner join users

					on messages.sender_id = users.id
		

				where messages.id = ?";

				$fields = array(

					'id' => $id

				);


				$message = $this->db->query($sql, $fields);

				if($message->count()) {

					return $message->first();
				}

				return false;


				/*

				$message = $this->db->get('messages', array('id', '=', $id));

				if($message->count()) {

					return $message->first();
				}

				return false;

				*/
			}


			public function create_reply($fields) {


					$reply = $this->db->insert('message_replies', $fields);

					if($reply) {

						echo "reply created";
						session::flash("success", "Reply Successfully sent!");

						return true;
					}

					return false;
			}


			public function test() {

				echo "test";
			}

			public function get_replies($id) {

				$sql = "select * from message_replies 

				inner join users

				on message_replies.user_id  = users.id

				where message_replies.message_id = ?";

				$fields = array(

					'message_id' => $id
				);

				$query = $this->db->query($sql, $fields);



				//$replies = $this->db->get('message_replies', array('message_id', '=', $id));

				if($query->count()) {

					return $query->result();

				}

				return false;
			}


			public function delete($message_id = false) {


				if(!$message_id) {

					//you will do something special for me later

					//test

					echo "pass";
				}


				$delete = $this->db->delete('messages', array('id',  '=', $message_id));

				if($delete) {

					echo "message deteted";

					session::put('success', 'Mesage Deleted');
					return true;
				}

				return false;

			}


	}