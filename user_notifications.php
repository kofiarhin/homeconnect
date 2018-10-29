<?php 


	require_once "header.php";


	$user_id = session::get('user');


	$note = new Notifications;

	//var_dump($note)

 ?>


<section id="nnotifications">



	<?php 

			if(!$note->exist()) {

				?>
			
			<p class="alert alert-info text-center subtitle">No Notificataions</p>


				<?php 
			} else  {

				?>
				<p class="sub-title text-center">Your Notifications</p>


				<?php 
			}

	 ?>
	

	<div class="container">
		
		

		<div class="row">
			

				<div class="col-md-5 offset-md-3 text-center">
					

					<?php 


							if($note->exist()) {


								foreach($note->data() as $data) {


									//var_dump($data);

									$note_id = $data->id;

									$checked = $data->checked;


									$person_id = $data->sender_id;


									//echo $user_id;

									//echo $person_id; 

									$request_id = $note->get_request_id($user_id, $person_id);




									$note_type = $data->note_type;




									switch ($note_type) {

										case 1:

											$person_id = $data->sender_id;

											$person = new User($person_id);

											if($person->exist()) {


												$person_name = $person->data()->first_name." ".$person->data()->last_name;

												?>

							
															<p><a href="hosting_requests.php?note_id=<?php echo $note_id; ?>" class="note <?php if($checked) { echo "checked";} ?>"> You have a hosting Request From <?php echo $person_name; ?></a></p>

												<?php 

												

											}
											
											break;
										
										default:
											# code...
											break;
									}
								}


							}

					 ?>

				</div>


		</div>



	</div>


</section>