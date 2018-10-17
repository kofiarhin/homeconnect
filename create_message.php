<?php 


require_once "header.php";

if(!$user->logged_in()) {

	redirect::to('login.php');
}

?>


<?php 

$user = new User;

$sender_id = $user->data()->id;

$receiver_id = input::get('receiver_id');

$receiver = new User($receiver_id);


$receiver_name = $receiver->data()->first_name;

//var_dump($receiver);



?>

<section id="create_message">
	





	<div class="container">


		<h1 class="sub-title text-center">Send <?php echo $receiver_name ?> a  Message!</h1>


		<?php 

					//check if user has submitted data

		if(input::exist('post', 'submit')) {

			$validation = new Validation;

			$fields = array(


				'content' => array(

					'required' => true,
					'min' => 4

				)

			);

			$check = $validation->check($_POST, $fields);


			if($check->passed()) {

				$fields = array(

					'sender_id' => input::get('sender_id'),
					'receiver_id' => input::get("receiver_id"),
					'content' => input::get('content'),
					'checked' => 0,
					'created_on' => date("Y-m-d H:i:s")


				);


				
				$message = $user->send_message($fields);

				if($message) {

					redirect::to('index.php'); 
				}
			} else {


				foreach($check->errors() as $error) {

					?>

					<div class="row">

						<div class="col-md-6 offset-md-3 text-center">
							<p class="alert alert-danger"><?php echo $error; ?></p>

						</div>


					</div>



					<?php 
				}
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
						<textarea name="content" id="" cols="30" rows="10" class='form-control'></textarea>
					</div>

					<input type="hidden" name="receiver_id" value="<?php echo $receiver_id ?>">

					<input type="hidden" name="sender_id" value="<?php echo $sender_id; ?>">
					<button class="btn btn-primary" type='submit' name='submit'>Send Message</button>

				</form>		



			</div>



		</div>


	</div>

</div>


</section>