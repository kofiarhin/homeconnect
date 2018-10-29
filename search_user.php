<?php 


require_once "core/init.php";
$search = input::get("search");

$user = new User;


$datas = $user->search($search);

if($datas) {

	?>

	<div class="container">

		<p>Your are searching for <?php echo $search; ?></p>
		<div class="sub-title"> Match Found!(<?php echo count($datas); ?>)</div>

		<div class="row">	


			<?php 	

			foreach($datas as $data) {




				?>
				<div class="col-md-3 user-unit">	

					<div class="face" style="background-image: url(uploads/<?php echo $data->profile_pic; ?>)"></div>
					<div class="content">

						<p class="text text-capitalize">Name: <?php echo $data->first_name." ".$data->last_name; ?> </p>

						<div class="button-wrapper">
							<a href="view_user.php?user_id=<?php echo $data->id; ?>" class="link btn">View Profile</a>
							<button class="btn btn-primary">Send Request</button>
							
						</div>


					</div>


				</div>

				<?php 	 

			}


			?>


		</div>


		<?php 	
	} else {


		?>

			<p class="text">No Match found!</p>

		<?php 
	}


	?>
				</div> <!--====  container=======-->