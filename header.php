<?php 


require_once "core/init.php";

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Home Connect</title>

	<!--====  viewport=======-->
	
	<meta name="viewport" content="width=device-width">
	<!--====  end bootstrap=======-->
	<link rel="stylesheet" href="css/bootstrap.min.css">


	<!--====  font awesome=======-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<!--====  custom css=======-->
	<link rel="stylesheet" href="css/styles.css">

	<!--====  jquery=======-->

	<script src='js/jquery.min.js'></script>
	<script src='js/main.js'></script>

</head>
<body>

	<header>

		<div class="container">
			
			<h1 class="logo"><a href="index.php">HomeConnect</a></h1>


			<nav>

				<?php 

				$user = new User;
				if($user->logged_in()) {

					?>

					
					
					<a href="hostings.php">Hostings</a>
					<a href="hosting_requests.php">Hosting Requests <span id="request_result"><span class="check">1</span></span></a>
					<a href="inbox.php">Inbox<span id="message_result"></span></a>
					<a href="user_notifications.php">Notifications <span id="note_result"> <span class="check"></span></span></a>
					<a href="logout.php">Logout</a>
					<a href="profile.php" class='face' style="background-image: url(uploads/<?php echo $user->data()->profile_pic; ?>)"></a>

					<?php 
				} else {

					?>
					<a href="login.php">Login</a>
					<a href="register.php">Register</a>



					<?php 
				}

				?>



			</nav>

			<i class="fa fa-bars menu"></i>

		</div>
		
		

	</header>

<?php 

		require_once"info.php";


 ?>