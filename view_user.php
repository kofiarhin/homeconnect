<?php 

require_once "header.php";

$user_id = input::get('user_id');

if(!$user_id) {

	redirect::to('index.php');

	session::flash("error", "User does not exist");
}



$user = new User($user_id);


//var_dump($user)

if($user->exist()) {


	$user_bio = $user->data();

	$person_id = $user_bio->id;

	//var_dump($user_bio);

	$user_ints =  sanitize::object($user->get_user_ints($user->data()->id));

	

	//remove user_id

	if(isset($user_ints['id'])) {

		unset($user_ints['id']);
	}

	//remove user_id


	if(isset($user_ints['user_id'])) {

		unset($user_ints['user_id']);
	}


	

	?>



	<section id="view_user">



		<div class="container">


			<h1 class="title text-center"><?php echo $user_bio->first_name; ?>'s  Details</h1>


			<div class="row" style="margin-bottom: 20px">


				<div class="col-md-3 offset-md-2 view-unit">

					<div class="face" style="background-image: url(uploads/<?php echo $user_bio->profile_pic; ?>)"></div>

				</div>


				<div class="col-md-4">

					<div class="content">

						<p class="sub-title"><strong>Personal Details</strong></p>

						<p class="text text-capitalize">Name: <?php echo $user_bio->first_name." ".$user_bio->last_name;?></p>

						<p class="text">Current Location: <?php echo $user_bio->location ?></p>



						<p class="sub-title">Other Details</p>

						<!--====  Display matching user preference/interes =======-->

						<p class="sub-title"><strong>Preferences</strong></p>

						<p class='text text-capitalize'><?php if(count($user_ints)){

							$counter = 1;


							$string = implode(", ", $user_ints);

							echo $string;


						} ?>


					</p>	


					<p class="sub-title"><strong>Common Interest</strong></p>

					<p class="text text-capitalize">


						<?php 

						$user_preference = new Preference();



						$person_preference = new Preference($person_id);

						$similars = array_intersect($user_preference->data(), $person_preference->data());

						$similar_string = implode(', ', $similars);

						echo $similar_string;



						?>


					</p>


					<?php 



					?>


					<!--==== 

					//check if already hosting to dispay the right button
					//check if request already existy
					=======-->	

					<?php 


							//check if hosting


					$hosting = new Hostings;


					$check = $hosting->check_hosting($user_id,  $person_id);



					//var_dump($check);




					?>

					<div class="button-wrapper">


						<!--====  check if request already exist=======-->

						<?php 

									//echo $person_id;
						$user_id = session::get('user');

						$request = new Request();

						$check = $request->check_exist($user_id, $person_id);


						if($user_id == input::get('user_id')) {


						} else {


							if($check) {

								$request_status  = $check->request_status;
																		//check if request has been accepted
								if($check->request_status == 2) {

									?>


									<a href="#" class="btn btn-primary">Send Message</a>

									<?php 


								}  else if ($request_status == 1) {


									?>

									<button class="btn btn-info" style ="display: inline-block; margin-bottom: 10px">Pending Request</button>

									<?php 
								}

							} else {


								?>

								<a href="create_connection.php?user_id=<?php echo session::get('user');?>&person_id=<?php echo $person_id; ?>" class="btn btn-primary">Send Request</a>

								<?php 
							}


						}

									//if request has been accepted
									//user should s


						



						?>

						
						<a class='btn btn-success' href="index.php" class="link">Go Back</a>

					</div>



				</div>



			</div>

		</div>


		<div class="row">


			<div class="col-md-4 offset-md-2">



			</div>	




		</div>

	</div>


	<?php 

}


?>


</section>