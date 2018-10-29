<?php 

require_once "header.php";

?>


<div class="container">


	<div class="row">

		<div class="col-md-4 offset-md-4">


			<?php 


			if(input::exist('post', 'submit')) {

				$validation = new Validation();

				$fields = array(


					'username' => array(


						'required' => true
					)

				);

				$check = $validation ->check($_POST, $fields);

				if($check->passed()) {

					
				} else {

				foreach($check->errors() as $error)  {

					?>

					<p class="alert alert-danger"><?php echo $error; ?></p>

					<?php 
				}
			}

			} 

			?>


			<form action="new_message.php" method='get'>

				<div class="form-group">

					<label for="">Enter Username</label>
					<input type="text" class="form-control" name='username'>

				</div>
				<button class="btn btn-primary" type='submit' name="submit">Next</button>
			</form>


		</div>


	</div>


</div>