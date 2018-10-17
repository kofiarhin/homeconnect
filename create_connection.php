<?php 

require_once "header.php";

$user_id = session::get("user");

if(!input::get('person_id')) {

	echo "error";


}

$user_id = input::get('user_id');
$person_id = input::get("person_id"); 




?>


<div class="container">


	<h1 class="title text-center">Send Hosting Request</h1>


	<!--====  check if request already exist=======-->


	<?php 

	$request = new Request;


	$check = $request->check_exist($user_id, $person_id);


	if(!$check) {


		?>

		<div class="row">

			<div class="col-md-4 offset-md-4">

				<?php 

								// check if user has submitted data


				if(input::exist("post", 'submit') ) {

					$validation = new validation;


					$fields = array(

						'start' => array(

							'required' => true
						),

						'end' => array(

							'required' => true

						)

					);


					$check = $validation->check($_POST, $fields);


					if($check->passed()) {





						$fields = array(

							'user_id' => $user_id,
							'person_id' => $person_id,
							'start_date' => input::get('start'),
							'end_date' => input::get('end'), 
							'request_status' => 1,
							'created_on' => date("Y-m-d H:i:s") 

						);





						$send_request = $request->create_request($fields);

						if(!$send_request) {

							foreach($request->errors() as $error) {

								?>

								<p class="alert alert-danger"><?php echo $error; ?></p>

								<?php 
							}
						}


						if($send_request) {

							redirect::to("index.php");
						}	



					} else  {


						foreach($check->errors() as $error) {

							?>
							<p class="alert alert-danger"><?php echo $error; ?></p>

							<?php 
						}


					}
				}

				?>

				<form action="" method="post">

					<div class="form-group">

						<label for="start">Start</label>
						<input type="date" class="form-control" name="start">					


					</div>


					<div class="form-group">

						<label for="end">End</label>
						<input type="date" name="end" class="form-control">

					</div>


					<button class="btn btn-primary" type="submit" name="submit">Send Request</button>


				</form>
			</div>


		</div>


		<?php 


	} else {

		?>

		<div class="row">
			<div class="col-md-8 offset-md-2">
				
				<p class="alert alert-danger text-center">Request already Exist</p>
	

				<div class="button-wrapper">
					

				<a href="index.php" class="btn btn-primary">Go back</a>
					
				</div>

				
			</div>

			
		</div>
		


		<?php 
	}

	?>

	



</div>