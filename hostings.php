<?php 

require_once "header.php";

$request = new Request;

?>


<section id="hostings">



	<div class="container">


		<?php 

				if(!$request->data()) {

						?>
				<p class="alert alert-info text-center sub-title">No Hosting Request Yet!</p>

						<?php 
 
				}  else {

					?>
		<h1 class="title">Your are hosting!...</h1>

					<?php  
				}

		 ?>




		<?php 


		//check if user has submitted any data

			if(input::exist('post', 'submit')) {

					$request_id = input::get('request_id');

					$delete  = $request->delete($request_id);


					if($delete) {


						redirect::to('index.php');
					}
			}



		 ?>



		<div class="row">




			<!--====  display accepted hostings=======-->


			<?php 


			

			if($request->exist()) {

				foreach($request->data() as $data) {


					if($data->request_status == 2) {

						//var_dump($data);


						$person_id = $data->user_id;
						$request_id  = $data->request_id;

						?>

						<div class="col-md-4 user-unit">
	
								<div class="face" style="background-image: url(uploads/<?php echo $data->profile_pic; ?>)"></div>
								<div class="content">
										

										<p class="name text-capitalize"><?php echo $data->first_name." ".$data->last_name; ?></p>
						
										<div class="button-wrapper">
										
											<form action="" method="post">
												
					<input type="hidden" name="request_id" value="<?php echo $request_id; ?>">

					<a href="create_message.php?receiver_id=<?php echo $person_id; ?>" class="btn btn-primary">Send Message</a>

					<button class="btn btn-danger" type="submit" name="submit">Delete</button>


											</form>
											
										</div>

								</div>						
	
						</div>


						<?php 
					}


				}
			}

			?>


		</div>

		
	</div>

</section>