<?php 

require_once "header.php";


$user = new User;


if(!$user->logged_in()) {

	redirect::to('login.php');
}


$profile_pic = $user->data()->profile_pic;


if(input::exist('get', 'user_id')) {



} else  {


}





//changes profile picture
if(input::exist('post', 'picture_submit')) {

	$upload = new Upload;

	$checks = $upload->check(input::get('file'));


	if($checks->passed()) {


		$change = $upload->upload();

		if($change) {

			redirect::to('profile.php');
		}


	}
}



//change personal details

if(input::exist("post", "save_submit")) {

	$validation = new Validation();

	$fields = array(

		'first_name' => array(


			'required' => true,
			'min' => 2,
			'max' => 50
		),


		'last_name' => array(

			'required' => true,
			'min' => 2,
			'max' => 50

		)


	);


	$checks = $validation->check($_POST, $fields);

	if($checks->passed()) {

		$fields = array(

			'first_name' => input::get('first_name'),
			'last_name' => input::get("last_name")

		);

		$update  = $user->update($fields);

		if($update) {

			if($update) {

				redirect::to('profile.php');

			}
		} else {

			echo "error";
		}
	} else {


		foreach($validation->errors() as $error) {
			?>

			<div class="container">

				<div class="row">

					<div class="col-md-6 offset-md-3"><p class="alert alert-danger"><?php echo $error; ?></p></div>

				</div>

			</div>

			<?php 
		}
	}
}

?>


<section id="profile">
	

	<div class="container">


		<h1 class="display-4 text text-center title" style="margin-bottom: 10px">Edit Your Profile</h1>

		<p class="sub-title text-center">Personal Information</p>

		<div class="row">


			<div class="col-md-3 offset-md-3">

				<div class="face-unit">

					<div class="face" style="background-image: url(uploads/<?php echo $profile_pic; ?>)">
						


					</div>


					<form action="" method="post" enctype="multipart/form-data">

						<div class="form-group">

							<input type="file" name='file' class="form-control">

						</div>

						<button class="btn btn-primary btn-sm" name="picture_submit" type="submit">Change Picture</button>


					</form>


				</div>

			</div>

			<div class="col-md-4 offset-md-1">


				<form action="" method="post" style="margin-bottom: 30px">



					<div class="form-group">

						<label for="first_name">First Name</label>
						<input type="text" name="first_name" class="form-control" value="<?php echo $user->data()->first_name; ?>">


					</div>


					<div class="form-group">

						<label for="last_name">Last Name</label>

						<input type="text" class="form-control" class="form-control" value="<?php echo $user->data()->last_name ?>" name="last_name">
					</div>



					<button class="btn btn-primary btn-sm" type="submit" name="save_submit">Save Changes</button>

				</form>

				<p class="text text-lead">Preferences</p>

				<?php 

				$preferences = $user->get_preferences();

				if($preferences) {

					?>
					<p class="text text-capitalize"><?php echo $preferences->interest_1;?></p>
					<p  class='text text-capitalize'><?php echo $preferences->interest_2; ?></p>

					<p class='text text-capitalize'> <?php echo $preferences->interest_3; ?></p>

					<p class="text text-capitalize"><?php echo $preferences->interest_4; ?></ps>


						<p class="text">
							<a href="change_preference" class='link link-danger'>Change Preference</a>
						</p>

						<?php 
					} 


					?>



				</div>


			</div>


			<p class="lead text-center sub-title">Other information</p>

			<div class="row">

				<div class="col-md-4 offset-md-3">


					<p class="text">Current Location: </p>
					<p class="text"><?php echo $user->data()->location; ?></p>

					<a href="change_current_location.php" class="link">Change Current Location!</a>




				</div>


				<div class="col-md-4">


					<p class="text">Desired Location</p>

					<p class="text"><?php echo $user->data()->desired_location; ?></p>

					<a href="change_desired_location.php" class="link">Change Desired Location!</a>
				</div>

			</div>


		</div>

	</section>