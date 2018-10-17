<?php 

require_once "header.php";

?>
<div class="container">

	<div class="row">

		<div class="col-md-6 offset-md-3">

			<h1>Create An Account</h1>
			<?php


			if(Input::exist('post', 'submit')) {

				$validation = new Validation();

				$check = $validation->check($_POST, array(

					'first_name' => array(

						'required' => true,
						'min' => 3,
						'max' => 50
					),


					'last_name' => array(
						'required' => true,
						'min' => 2,
						'max' => 50

					), 

					'username' => array(

						'required' => true,
						'unique' => 'users',
						'min' => 3,
						'max' => 50
					),
					'password' => array(

						'required' => true,
						'max' => 50

					),

					'password_again' => array(

						'matches' => 'password'
					),

					'location' => array(

						'required' => true
					)

				));


				if($check->passed()) {

					$user  = new User;

					$fields = array (

						'first_name' =>  input::get('first_name'),
						'last_name' =>  input::get('last_name'),
						'username' => input::get('username'),
						'gender' => input::get('gender'), 
						'location' => input::get('location'),
						'desired_location' => input::get("desired_location"),
						'password' => input::get("password"),
						'joined' => date("Y-m-d H:i:s")

					);


					$int_fields = input::get('interests'); 



					if(count($int_fields) > 4) {

						?>
						<p class="alert alert-danger">Interest Cannot be more than 4</p>


						<?php 

					} else {


						$interest = new Interest;

						$checks = $interest->checks($int_fields);


						if($checks->passed()) {

							echo "create user account", "<br>";

							$account = $user->create($fields);

							if($account) {


								$user_id = $account;


								$user_ints = $interest->create($user_id, $int_fields);

								if($user_ints) {

								redirect::to('login.php');
									 
								} else {

									?>
			<p class="alert alert-danger">There was a problem creating account plesase try again!</p>


									<?php 
								}

							} else {

								?>
								<p class="alert alert-danger">There was a problem creating account</p>

								<?php 
							}
						} else {

							foreach($checks->errors() as $error) {

								?>
								<p class="alert alert-danger"><?php echo $error; ?></p>

								<?php 
							}
						}



						
						
					}
					



				} else {


					foreach($check->errors() as $error) {

						?>
						<p class="alert alert-danger"><?php echo $error; ?></p>

						<?php 
					}
				}

			}

			?>



			<form action="" method='post'>

				<div class="row">
					
					<div class="col">

						<div class="form-group">
							<label for="first_name">First Name</label>
							<input type="text" name="first_name" placeholder="Enter First Name" class="form-control" value="<?php echo input::get('first_name'); ?>">
						</div>

					</div>


					<div class="col">

						<div class="form-group">
							<label for="first_name">Last Name</label>
							<input type="text" name="last_name" placeholder="Last Name" class="form-control" value="<?php echo input::get('last_name'); ?>">
						</div>

					</div>


				</div>


				<div class="row">

					<div class="col">

						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" class="form-control" name='username' placeholder="Enter Your username" value="<?php echo input::get('username') ?>">
						</div>	

					</div>


					<div class="col">

						<div class="form-group">


							<label for="gender">Gender</label>

							<select name="gender" id="" class="form-control">

								<option value="male">Male</option>
								<option value="male">Female</option>
							</select>


						</div>

					</div>



				</div>

				


				<div class="row">
					
					

					<div class="col">


						<!--====  country =======-->

						<div class="form-group">

							<label for="location">Country</label>
							<select name="location" id="location" class="form-control">
								<?php 

								foreach($countries as $country) {

									?>

									<option value="<?php echo $country->country_name; ?>"><?php echo $country->country_name; ?></option>
									<?php 
								}

								?>
							</select>


						</div>

					</div>


					<div class="col">
						

						<!--====  desired location=======-->


						<div class="form-group">

							<label for="desired_location">Desired Travel Destination</label>
							<select name="desired_location" id="desired_location" class="form-control">
								<?php 

								foreach($countries as $country) {

									?>

									<option value="<?php echo $country->country_name; ?>"><?php echo $country->country_name; ?></option>
									<?php 
								}

								?>
							</select>


						</div>
					</div>

				</div>



				<div class="row">
						
						<div class="col">
							
							<div class="form-group">
								<label for="password">Password</label>
								<input type="password" class="form-control" placeholder="Enter Your Password" name='password' value = "<?php echo input::get('password'); ?>">
							</div>

						</div>


						<div class="col">
							
							<div class="form-group">
								<label for="password_again">Repeat Password</label>
								<input type="password" class="form-control" placeholder="Enter Your Password" name='password_again' value="<?php echo input::get('password_again');?>">
							</div>

						</div>


				</div>

				

				





				<!--==== user interests =======-->

				<div class="form-group">
					
					<label class="lead" style="font-weight: 400">Select Your Interest</label>
					
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

				<div class="form-group">

					<label for="books">
						<input type="checkbox" id='books' name='interests[]' value='books'>Books
					</label>

				</div>





				<!--====  usere interest=======-->





				




				<button class="btn btn-primary" type='submit' name='submit'>Create Account</button> <span>or <a href="login.php">Login</a></span>

			</form>	

		</div>

	</div>


</div>


</body>
</html>