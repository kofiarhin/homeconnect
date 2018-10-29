<?php 


	require_once "core/init.php";


		if(session::exist('user')) {


			$user_id = session::get('user');



			$user = new User;

			$check = $user->check_messages();


			if($check) {


				?>
			
			<span class="check"><?php echo $check ?></span>

				<?php 
			}
		}

		


 ?>