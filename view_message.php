<?php 

require_once "header.php";

		//check if user is logged in

if(!$user->logged_in()) {


	redirect::to('login.php');
}


$message_id = input::get('message_id');

if(!$message_id) {

	session::flash('error', 'sorry message does not exist');

	redirect::to('index.php');
}


		//update the checked part of the message


$message = new Message;



$message->checked($message_id);

$user_message = $message->get_message($message_id);

?>

<div class="container">

	<div class="col-md-6 offset-md-3">


		<?php 

		if($user_message) {

			//var_dump($user_message);

			?>

			<div class="message-unit">

				<p class="text name">Name: <?php echo $user_message->first_name." ".$user_message->last_name; ?></p>

				<p class="text content"><?php echo $user_message->content; ?>
				<p class="text date"><?php 

					$created_on = $user_message->created_on;

					

					//format the date to my specification 
					$date = new DateTime($created_on);

					echo $date->format("jS M Y");


				  ?> </p>


				  <div class="button-wrapper">
				  	
						<a href="reply_message.php?message_id=<?php  echo $user_message->message_id; ?>" class='btn btn-primary' >Reply</a>

						<a href="delete_message.php?" class='btn btn-danger'>Delete</a>

				  </div>


			</p>


			<p class="sub-title">Replies</p>

			<div class="reply-content">
				
				<?php 


							$replies =  $message->get_replies($message_id);


							if($replies) {

								foreach($replies as $reply) {

									?>
						<p class="text"><?php echo $reply->reply_content; ?></p>

									<?php 
								}

							}

				 ?>
			</div>

		</div>

		<?php 
	}


	?>


</div>


</div>

