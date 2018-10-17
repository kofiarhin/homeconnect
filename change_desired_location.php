<?php 

require_once "header.php";

?>

<div class="container">
	
	<h1 class="display-4 title">Change Desired Location</h1>


	<div class="row">

		<div class="col-md-4 offset-md-4">

			<?php 

					if(input::exist('post', 'submit')) {

						$desired_location = input::get('desired_location');


						$update = $user->update_desired_location(session::get('user'), $desired_location);

						if($update) {

							redirect::to('index.php');
						} else {

							?>

			<p class="alert alert-danger">There was a problem updating Desired Location</p>

							<?php 
						}
					}
					//$validation = new Validation();



			 ?>

			<form action="" method='post'>

				<div class="form-group">
					<label for="desired_location">Desired_location</label>
					<select name="desired_location" id="" class="form-control">

						<?php 

						if($countries) {

							foreach($countries as $country) {

								?>
								<option value="<?php echo $country->country_name; ?>"><?php echo $country->country_name; ?></option>

								<?php 
							}
						}

						?>

					</select>


				</div>



				<button class="btn btn-primary" type="submit" name="submit">Change</button>
			</form>
		</div>


	</div>


</div>