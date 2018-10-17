<?php 

	require_once "header.php";

 ?>

 <div class="container">
 	
			<h1 class="text text-lead text-center">Change Current Location</h1>

			<div class="row">
				
					<div class="col-md-4 offset-md-4">

						<?php 

									if(input::exist('post', 'submit')) {

										$location = input::get('location');

										$update = $user->update_location(session::get('user'), $location);

										if($update) {

											redirect::to('index.php');
										} else {


											?>
		<p class="alert alert-danger">There was a problem updating  Your location!</p>

											<?php
										}
									}

						?>
						
						<form action="" method='post'>
							
							<div class="form-group">
								
								<select name="location" id="location" class="form-control">
									
									<?php 

										if($countries) {
											
											foreach($countries as $country) {

												?>
			<option value="<?php echo $country->country_name; ?>"><?php echo $country->country_name ?></option>

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