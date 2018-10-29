<?php 


require_once "header.php";


if(!$user->logged_in()) {

	redirect::to('login.php');
}

$con_id = input::get('con_id');

if(!$con_id) {

	redirect::to('messages.php');
}

$user_id = session::get('user');
$conversation = new Conversation;



$messages = $conversation->get_message($con_id);

?>



<div class="container">





	<div class="row">


		<div class="col-md-6 offset-md-3">


			<?php 

					//validate data from user


				if(input::exist('post', 'submit')) {


					$validation = new Validation;

					$fields =array(

						'content' => array(

							'required' => true
						)

					);

					$check = $validation->check($_POST, $fields);


					if($check->passed()) {

						
							$fields = array(

								'conversation_id' =>  input::get("con_id"), 
								'user_id' => input::get('user_id'),
								'content' => input::get('content'),
								'message_date' => strtotime('now')

							);



							$add_message = $conversation->add_message($fields);

							if($add_message) {

								redirect::to('messages.php');
							}


					} else {


							foreach($check->errors() as $error) {

								?>
			<p class="alert alert-danger"><?php echo $error; ?></p>

								<?php 
							}

					}


				}

					

			 ?>



			<?php 

			if($messages) {

				foreach($messages as $message) {

					//var_dump($message);

					$profile_pic = $message->profile_pic;
					$message_id = $message->message_id; 

					$name = $message->first_name. " ".$message->last_name;
					$content = $message->content;
					$message_date = date("jS M Y", $message->message_date);

					$person_id = $message->user_id;





					?>


					<div class="con-unit">

						<div class="face" style="background-image: url(uploads/<?php echo $profile_pic; ?>)"></div>

						<div class="content">

							<p class="message"><?php echo $content; ?></p>
							<p class='date'>Date	<?php echo $message_date; ?></p>

							<div class="con-button-wrapper">
								
								<?php 

										if($user_id == $person_id) {


											?>

	<a href="delete_message.php?message_id=<?php echo $message_id; ?>" class="btn btn-danger">Delete</a>

											<?php 
										}
								?>

							</div>
						</div>

					</div>

					<?php 
				}
			}


			?>



			<form action="" method='post'>
				
					<div class="form-group">

						<input type="hidden" name="con_id" value="<?php echo $con_id; ?>">
						<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
						
						<textarea name="content" class="form-control" id="" cols="" rows=8></textarea>

					</div>

					<button class="btn btn-primary" type="submit" name="submit">Add Message</button>


			</form>


		</div>






	</div>





</div>