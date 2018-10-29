<?php 


require_once "header.php";

if(!$user->logged_in()) {

	redirect::to('login.php');
}

?>


<?php 

$user = new User;

$sender_id = session::get('user');

$user_id = session::get('user');

$receiver_id = input::get('receiver_id');

$receiver = new User($receiver_id);


$receiver_name = $receiver->data()->first_name;

//var_dump($receiver);



?>

<section id="create_message">
	





	<div class="container">


		<h1 class="sub-title text-center">Send <?php echo $receiver_name ?> a  Message!</h1>

		
		<?php 	


		if(input::exist('post', 'send_message')) {


			$validation  = new Validation;

			$fields = array(


				'subject' => array(

					'required' => true
				),

				'content' => array(


					'required' => true
				)

			);


			$check = $validation->check($_POST, $fields);

			if($check->passed()) {


				$conversation = new Conversation;


				$users = array(

					'user_1' => $user_id,
					'user_2' => $receiver_id

				);


				$create = $conversation->create($users, input::get('subject'), input::get('content'));

				if($create) {

					redirect::to('index.php');
				}




			} else {

				?>

				<div class="row">

					<div class="col-md-8 offset-md-2">
						
						<?php 
						foreach($check->errors() as $error) {

							?>
							<p class="alert alert-danger"><?php echo $error;  ?></p>

							<?php 
						}

						?>

					</div>


				</div>
				<?php
			}


		}

		?>

		
		<div class="row">




			<div class="col-md-3 offset-md-2">

				<a  href="view_user.php?user_id=<?php echo $receiver_id; ?>"class="face" style="width: 200px; height: 200px; background-image: url(uploads/<?php echo $receiver->data()->profile_pic; ?>);">


				</a>

			</div>		


			<div class="col-md-6">

				<form action="" method='post'>

					<div class="form-group">
						
						<label for="subject">Subject</label>
						<input type="text" class="form-control" name="subject" placeholder="Enter Subject Here" value="<?php echo input::get('subject'); ?>">

					</div>

					<div class="form-group">
						<textarea name="content" id="" cols="30" rows="10" class='form-control'><?php echo input::get('content'); ?></textarea>
					</div>

					<input type="hidden" name="receiver_id" value="<?php echo $receiver_id ?>">

					<input type="hidden" name="sender_id" value="<?php echo $sender_id; ?>">
					<button class="btn btn-primary" type='submit' name='send_message'>Send Message</button>

				</form>		



			</div>



		</div>


	</div>

</div>


</section>