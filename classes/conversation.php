<?php 



class Conversation {

	private $db = null,
			$data = array();

	public function __construct($user = false) {


		$this->db = db::get_instance();

		if(!$user) {

			if(session::exist(config::get('session/session_name'))) {


				$user_id = (int) session::get('user');

				$this->data = $this->get_conversation($user_id);
			}
		}


	}


	public function exist() {


		return (!empty($this->data)) ? true : false;
	}




	public function data() {

		return $this->data;
	}



	public function get_message($con_id) {


		//echo $con_id;


		$sql = "select * from conversation_messages


			inner join conversations

			on conversations.id = conversation_messages.conversation_id

			inner join users on

			conversation_messages.user_id = users.id 

			where conversation_id = ?


			order by conversation_messages.message_date desc	

		";


		$fields = array(

			'conversation_id' => $con_id

		);


		$query = $this->db->query($sql, $fields);

		if($query->count()) {

			return ($query->result());
		}
	}


	public function delete($message_id) {


		$sql = "delete from conversation_messages 

				where message_id = ?
		";

		$fields = array(

			'message_id' => $message_id
		);

			$query = $this->db->query($sql, $fields);

			if($query->count()) {

				session::flash('success', 'message successfully deleted');

				return true;
			}

			return false;
	}


	public function get_conversation($user_id) {

		$sql = "select 
		
			conversations.id,
			conversations.subject,
			conversation_members.user_id,
			max(conversation_messages.message_date) as  last_reply,
			max(conversation_messages.message_date) > conversation_members.last_view as unread
  


			from conversations

			inner join conversation_messages

			on conversations.id = conversation_messages.conversation_id




			inner join conversation_members

			on conversations.id = conversation_members.conversation_id


			where conversation_members.user_id = ?

			group by conversations.id, conversations.subject, conversation_members.last_view


			";

		$fields = array(

			'user_id' => $user_id

		);

		$query = $this->db->query($sql, $fields);


		if($query->count()) {

			return($query->result());
		}


		return false;

	}


	public function create($users, $subject, $content) {

		$current_time_stamp = (new DateTime)->getTimestamp();





		//insert into conversations table
		$con_fields = array(

			'subject' => $subject
		);


		$con_id = ($this->db->insert('conversations', $con_fields));


		//insert into conversation members

		foreach($users as $user) {



			$mem_fields = array(

				'conversation_id' => $con_id,
				'user_id' => $user,
				'last_view' => 0
			);


			$mem_insert = $this->db->insert("conversation_members", $mem_fields);


			if(!$mem_insert) {

				return false;
			}



		}



		//update the current memeber last view conversation

		$sql = "update conversation_members
		set last_view = ? 

		where user_id = ? and conversation_id = ?";


		$fields = array(

			'last_view' => $current_time_stamp,
			'user_id' => session::get('user'),
			'conversation_id' => $con_id

		);

		$query = $this->db->query($sql, $fields);

		if($query) {

			echo "member updated <br>";
		}


			//insert into conversatin message field

		$message_fields  = array(

			'conversation_id' => $con_id,
			'user_id' => session::get('user'),
			'content' => $content,
			'message_date' => $current_time_stamp

		);


		$message_insert = $this->db->insert("conversation_messages", $message_fields );

		if($message_insert) {

			session::put('success', 'Message successfully sent');
			return true;



		}


		return false;


	}


	public function add_message($fields) {


		//insert into conversation messsages

		//update the last view of the useer
		$con_id = (int) $fields['conversation_id'];

		$insert = $this->db->insert('conversation_messages', $fields);

		if($insert) {

			//update the user

			$fields = array(

				'last_view' => $fields['message_date']

			);

			$update = $this->db->update('conversation_members', $fields, array('conversation_id' , '=', $con_id));

			if($update) {

				session::flash("success", "message successfully sent!");

				return true;
			}
		}


		return false;
	}
}