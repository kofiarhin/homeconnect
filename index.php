<?php 

require_once "header.php";


if(!$user->logged_in()) {

	redirect::to('login.php');
}


?>


<div class="container">



	<?php 

	$user = new User;
	$user_id = session::get('user');

	$request = new Request;


	//var_dump($request);



	//echo "Your Desired Location ".$desired_location;


	//echo $desired_location;


	$interest = $user->get_interests();


	if($user->logged_in()) {

		$current_location = $user->data()->location;

		$desired_location = $user->data()->desired_location;


		$name = $user->data()->first_name;



		?>

		
		<!--====  serach for user=======-->
		<form action="" method='post' class='search-form'>

			<label for="search">Search</label>
			<input type="text" name='search' id="search">
		</form>


		<?php 


		//check if user has created profile



		//check if user is available to host


		$login_id = $user->data()->id;

		$datas = $user->get_similar();

			//var_dump($datas);


		if(count($datas) > 1) {

 

			?>



			<div id="result">
				



				<div class="row">


					<?php 

					foreach($datas as $data) {

						//var_dump($data);


						$person_id = $data['id'];

						//echo $person_id;

						if($login_id != $data['id'] && $data['location'] == $desired_location) {

						//var_dump($data);

							?>

							<div class="col-md-3 user-unit">


								<div class="user-face" style='background-image: url(uploads/<?php echo $data['profile_pic']; ?>);'> 



								</div>

								<p class="text-capitalize name">Name: <?php echo $data['first_name']." ".$data['last_name']; ; ?></p>

								<a href="view_user.php?user_id=<?php echo $person_id; ?>" class='btn btn-default'>View Profile</a>


								<div class="button-wrapper">
									


								
								<?php

									//echo $user_id, "<br>";

									//echo $person_id;


								$check = $request->check_exist($user_id, $person_id);

								$hostings = new Hostings;


								$user_id = session::get(config::get('session/session_name'));

								$check_hosting = $hostings->check_hosting($user_id,  $person_id);


							//var_dump($check_hosting);


								if(!$check && !$check_hosting) {


								// check if user is already hosting



									?>

									<a href="create_connection.php?user_id=<?php echo $user_id; ?>&person_id=<?php echo $person_id; ?>" class='btn btn-primary'>Send Request</a>


									<?php 
								} 



								else {


									if(!$check && $hostings) {


										?>

										<a href="create_message.php?receiver_id=<?php echo $person_id; ?>" class="btn btn-primary">Send Message</a>


										<?php 

									} else {




										$request_status = $check->request_status;





										if($request_status == 2) {

											?>

											<a href="create_message?receiver_id=<?php echo $person_id; ?>" class="btn btn-warning">Send Message</a>

											<?php 
										}


										else if ($request_status == 1) {


											?>
											<button class="btn btn-info">Pending Request</button>
											<?php 
										}

									}





								}


								?>


								</div>



							<!--====  end

							<form action="" method="post">



								<div class="button-wrapper">



									 
									<a href="view_user.php?user_id=<?php echo $data['id']; ?>" class="cta link">View Profile</a>

									<a href="create_message.php?receiver_id=<?php echo $data['id']; ?>" class='link'>Send Messages</a>

									


								</div>

							</form>
							=======-->


						</div>

						<?php 
					}

				}


				?>




			</div>


			<?php 



		} else {


			?>

			<p class="alert alert-danger">No Match found</p>

			<?php 


		}



		?>






		<?php  


	} else {


		?>  <p>You need to <a href="login.php">Login</a></p>


		<?php  
	}

	?>

</div>

</div>




</body>
</html>