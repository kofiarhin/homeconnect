<?php 

require_once "header.php";

$user_id = input::get('user_id');

if(!$user_id) {

	redirect::to('index.php');

	session::flash("error", "User does not exist");
}



$user = new User($user_id);


//var_dump($user);


//var_dump($user);

if($user->exist()) {


	$user_bio = $user->data();

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


			<h1 class="title text-center">User Details</h1>
			<div class="row">



				<div class="col-md-3 offset-md-2">


					<div class="view-unit">

						<div class="face" style="background-image: url(uploads/<?php echo $user_bio->profile_pic; ?>)"></div>

						

					</div>

				</div>

				<div class="col-md-4">

					<div class="content">

						<p class="sub-title">Personal Details</p>

						<p class="text text-capitalize">Name: <?php echo $user_bio->first_name." ".$user_bio->last_name;?></p>

						<p class="text">Current Location: <?php echo $user_bio->location ?></p>


						<p class="sub-title">Other Details</p>

						<!--====  Display matching user preference/interes =======-->

						<p class="text">Preferences</p>
						<p class='text text-capitalize'><?php if(count($user_ints)){

							$counter = 1;


							$string = implode(", ", $user_ints);

							echo $string;


						} ?> </p>


						<p class="text">Common Interest</p>

						<p class="text text-capitalize">


							<?php 

							$user_preference = new Preference();

							$person_id = $user_bio->id;

							$person_preference = new Preference($person_id);

							$similars = array_intersect($user_preference->data(), $person_preference->data());

							$similar_string = implode(', ', $similars);

							echo $similar_string;





							?>


						</p>




		<a href="create_message.php?receiver_id=<?php echo $person_id; ?>" class='btn btn-primary'>Send Message</a>

		<!--====  check if request already exist=======-->


		<?php 

				

		 ?>

		<a href="create_connection.php?person_id=<?php echo $person_id ?>" class="btn btn-info">Connect</a>


					</div>



				</div>

			</div>

		</div>


		<?php 

	}


	?>


</section>