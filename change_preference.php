<?php 

require_once "header.php";

?>

<div class="container">


	<h1 class="display-4 title text-center">Change Preference</h1>

	<div class="row">

		<div class="col-md-6 offset-md-3">

			<?php 
			if(input::exist('post', 'submit')) {

				$interest = input::get("interests");

				if(empty($interest)) {

					?>

					<p class="alert alert-danger">You need to select a Preference</p>

					<?php 
				} else {



					$preference = new Preference();

					$update = $preference->update($interest);


					if($update) {

						redirect::to("index.php");
					}



				}
			}


			?>

			<form action="" method='post'>

				<div class="form-group">


					<div class="form-check">
						
						<input type="checkbox" id='sports' name='interests[]'  value="sports" class="form-check-input">
						<label for="sports" class="form-check-label">Sports</label>
						
					</div>


				</div>


				<div class="form-group">

					<div class="form-check">
						
						<input type="checkbox" id='technology' name='interests[]' value='technology' class="form-check-input">

						<label for="technology" class="form-check-label">Technology</label>
						
					</div>


				</div>


				<div class="form-group">

					<div class="form-check">
						
						<input type="checkbox" id='culture' name='interests[]' value='arts and culture' class="form-check-input">
						<label for="culture" class="form-check-label">Arts and Culture</label>
						
					</div>


				</div>


				<div class="form-group">

					<div class="form-check">
						
						<input type="checkbox" id='science' name='interests[]' value='science' class="form-check-input">
						<label for="science" class="form-check-label"> Science</label>
						
					</div>


				</div>



				<input type="hidden" name='user_id' value="<?php echo $user->data()->id?>">


				<button class="btn btn-primary" type='submit' name='submit'>Submit</button>


			</form>
		</div>


	</div>



</div>