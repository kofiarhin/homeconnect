<?php 

	
	require_once "header.php";

	$user_id = session::get("user");

	


	$message = new Message();


	$message_id = input::get('message_id');


	$message =  $message->get_message($message_id);


	$content = $message->content;

	$sender_profile_pic = $message->profile_pic;



	//echo $content;



 ?>

 <div class="container">
 

			<div class="row">


				<div class="col-md-6 offset-md-3">

					<?php 

							//check if user has submitted the reply

					if(input::exist('post', 'reply_submit')) {

						$validation = new Validation;

						$fields = array(

							'reply_content' => array(

									'required' => true,
									'min' => 4
							)

						);


						$check = $validation->check($_POST, $fields);


						if($check->passed()) {



							$fields = array(

								'message_id' =>  (int) input::get('message_id'),
								'user_id' => (int) input::get('user_id'),
								'reply_content' => input::get("reply_content"),
								'created_on' => date("Y-m-d H:i:s")


							);

							$message = new Message();

							$reply = $message->create_reply($fields);

							if($reply) {

								redirect::to("messages.php");
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


					<!--====  content of message=======-->
					<div class="message-content">


						<div class="face" style='background-image: url(uploads/<?php echo $sender_profile_pic; ?>);'>
							
						</div>
						
							<p class="message-title"><?php echo $content; ?></p>

					</div>


					<div class="reply-content">
						
						<p class="lead">Reply Content Will go Here</p>
					</div>

					<!--====  create reply =======-->
					
					<div class="message-unit">
						
						<form action="" method='post'>
							
							<div class="form-group">


									<input type="hidden" name='message_id' value="<?php echo $message_id; ?>">
									<input type="hidden" name='user_id' value="<?php echo $user_id; ?>">
									<textarea name="reply_content" id="" cols="10" rows="8" class="form-control"></textarea>

							</div>


							<button class="btn btn-primary" type="submit" name="reply_submit">Reply</button>
						</form>

						
					</div>
					

				</div>
				


			</div>







 </div>