<?php 

require_once "header.php";

?>


<section id="profile">

	<div class="container">
		



		<?php 

		if(input::exist('post', 'submit')) {

			$interests = input::get('interests');
			$counter = 1;

			$fields['user_id'] = (int) input::get('user_id');

			foreach($interests as $interest) {

				$fields["interest_{$counter}"] = $interest;

				$counter +=1;
			}


			$user_interests = $user->create_interest($fields);

			if($user_interests) {

				redirect::to('index.php');


			} else {

				?>
				<p class="alert alert-danger">There was a problem creating interest</p>

				<?php 
			}
			


		}

		?>

	</div>

	<div class="container">

		<div class="row">

			<div class="col-md-6 offset-md-4">

				<h1>Create Profile</h1>
				<form action="" method='post'>

					<div class="form-group">

						

					</div>

					<div class="form-group">
						
						<label class="lead">Select Select Interest</label>
						
					</div>


					<div class="form-group">

						<label for="sports">
							<input type="checkbox" id='sports' name='interests[]'  value="sports">Sports
						</label>

					</div>


					<div class="form-group">

						<label for="technology">
							<input type="checkbox" id='technology' name='interests[]' value='technology'>Technology
						</label>

					</div>


					<div class="form-group">

						<label for="culture">
							<input type="checkbox" id='culture' name='interests[]' value='arts and culture'>Arts and Culture
						</label>

					</div>


					<div class="form-group">

						<label for="science">
							<input type="checkbox" id='science' name='interests[]' value='science'>Science
						</label>

					</div>

					<input type="hidden" name='user_id' value="<?php echo $user->data()->id?>">


					<button class="btn btn-primary" type='submit' name='submit'>Submit</button>


				</form>
			</div>


		</div>

	</div>

</section>

