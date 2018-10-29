<?php 


require_once "header.php";

$username = input::get('username');

$new_user = new User($username);

?>



<?php 


if(!$new_user->exist()) {

	echo "user does not exist";
} else {



	$name = $new_user->data()->first_name." ".$new_user->data()->last_name;

	$profile_pic = $new_user->data()->profile_pic;


	?>

	<div class="container">





		<h1>New Message to: <span class='text-capitalize'><?php echo $name; ?></span>  </h1>

		<?php 


		if(input::exist('post', 'submit')) {

			$validation = new Validation();

			$fields = array(

				'content' => array(

					'required' => true

				)

			);


			$check = $validation->check($_POST, $fields);

			if($check->passed()) {

				
					$conversation = new Conversation;

					$users = array(

						'receiver_id' => (int)$new_user->data()->id,
						'sender_id' => (int) $user->data()->id

					);



					$create = $conversation->create($users, input::get('subject'), input::get('content'));

					if($create) {

						redirect::to('messages.php');
					}



			} else {

				?>


				<div class="col-md-6 offset-md-2">


					<?php 





					foreach($check->errors() as $error) {

						?>

						<p class="alert alert-danger text-center"><?php echo $error; ?></p>

						<?php 
					}



				}
			}



			?>



		</div>






		<div class="row">


			<div class="col-md-3 offset-md-2">
				<div class="face" style='background-image: url(uploads/<?php echo $profile_pic; ?>)'></div>
			</div>

			<div class="col-md-5">


				<form action="" method='post'>


					<div class="form-group">

						<input type="hidden" name='subject' value="default subject">

						<textarea name="content" id="" cols="30" rows="10" class="form-control"></textarea>


					</div>


					<button class="btn btn-primary" type="submit" name='submit'>Send Message</button>

				</form>


			</div>
		</div>


	</div>


	<?php  
}


?>