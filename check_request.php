<?php 
	

	require_once "core/init.php";




	if(session::exist(config::get('session/session_name'))) {



				
				$request = new Request();

				$check = $request->check_request();


				if($check) {

					?>

					<span class="check"><?php echo $check; ?></span>

					<?php 
				}


	}



 ?>