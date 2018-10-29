<?php 

			require_once "header.php";
 ?>

	<?php 


	?>

	<div class="container">
		
		<div class="row">
			
			<div class="col-md-4 offset-md-4">

				<h1 class="display-4">Login</h1>
				<?php 

				//check if there is a session succeess

				if(session::exist('success')) {

					?>

				<p class="alert alert-success"><?php echo session::flash("success"); ?></p>

					<?php 
				}

				//check if user has submitte data
				if(input::exist('post', 'submit')) {

					$validation = new Validation;

					$fields = array(

						'username' => array(

							'required' => true

						),

						'password' => array(

							'required' => true

						)

					);

					$check = $validation->check($_POST,  $fields);


					if($check->passed()) {

						$user = new User;

						$login = $user->login(input::get('username'), input::get('password'));

						if($login) {
							redirect::to('index.php');
						} else {

							?>

							<p class="alert alert-danger">Invalid Username & Password Combination</p>

							<?php 
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

					
					
					<div class="form-group">
						<label for="username">Username</label>
						<input type="text" class="form-control" name='username' placeholder="Enter Your username" value="<?php echo input::get('username') ?>">
					</div>

					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" placeholder="Enter Your Password" name='password' value = "<?php echo input::get('password'); ?>">
					</div>

					
					<button class="btn btn-primary" type='submit' name='submit'>Login</button> <span>or <a href="register.php">Register</a></span>

				</form>	
			</div>

		</div>

	</div>
	
</body>
</html>