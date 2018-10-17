<?php 
	

	require_once "core/init.php";


	$request = new Request();

	$check = $request->check_request();


	if($check) {

		?>

		<span class="check"><?php echo $check; ?></span>

		<?php 
	}

 ?>