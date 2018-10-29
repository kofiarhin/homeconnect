<?php 



		require_once "core/init.php";



		if(session::exist(config::get('session/session_name'))) {



				$note  = new Notifications;

				$check = $note->check_note(session::get('user'));


				if($check) {



					?>
				
				<span class="check"><?php echo $check; ?></span>

					<?php 
				}


		}


		


 ?>