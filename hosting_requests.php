<?php 

require_once "header.php";

$user_id = session::get('user');
$note_id = input::get('note_id');



if($note_id) {

	//update the notification table to checked

	$fields = array (

		'checked' => 1

	);		


	//update the notifications table  to checked

	$update = db::get_instance()->update('notifications', $fields, array('id', '=', $note_id));

}


//update all requests to checked

$update = db::get_instance()->update('requests', array('checked' => 1));



?>


<div class="container">

	<?php 

	$request = new Request;

	?>


	<div class="row">


		<?php 
				//check if user has submitted data

		if(input::exist('post', 'accept_submit')) {


			$accept = $request->accept(input::get('request_id'));
		}

		?>

		<?php 


		if($request->exist()) {


			foreach($request->data() as $data) {

				$person_id = $data->user_id;
					//var_dump($data);

				if($data->request_status == 1) {

					?>

					<div class="col-md-3 text-center user-unit">


						<!--====  correct this. Use a class for this =======-->

						<div class="face" style="width: 100px; height: 100px; background-size: cover; background-position: center; cursor: pointer; background-image: url(uploads/<?php echo $data->profile_pic; ?>); margin: 0 auto 20px; border-radius: 50%"></div>

						<p class='text text-capitalize'>Name: <?php echo $data->first_name ?></p>
						<p class='text text-capitalize'>Start Date: <?php echo format_date($data->start_date); ?></p>
						<p class='text text-capitalize'>End Date:<?php echo format_date($data->end_date); ?></p>


						<form action="" method='post'>


									<!--====  
									//get the various start fields
									=======-->

									<input type="hidden" name="start_date" value="<?php echo $data->start_date; ?>"> 
									<input type="hidden" name="end_date" value="<?php echo $data->end_date; ?>"> 

									<input type="hidden" name="request_id" value="<?php echo $data->request_id; ?>">

									<input type="hidden" name='person_id' value="<?php echo $person_id; ?>">

									<input type="hidden" name="user_id" value="<?php echo $user_id ?>">
									
									<div class="button-wrapper">

										<button class="btn btn-primary" type="submit" name="accept_submit">Accept</button>
										<button class="btn btn-danger">Decline</button>

									</div>

									
								</form>


							</div>

							<?php 
						} 



					}
				}


				?>



			</div>


		</div>