<?php 

	require_once "core/init.php";


	$user = new User;

	if(!$user->logged_in()) {


			redirect::to('login.php');
	}

	$message_id = input::get('message_id');



	$conversation = new  Conversation;

	$delete = $conversation->delete($message_id);


	if($delete) {

		redirect::to('messages.php');
	}




 ?>