<?php 

require_once "header.php";

?>

<?php 

if(!$user->logged_in()) {


	redirect::to('index.php');
}

$conversation = new Conversation;

var_dump($conversation->data());

?>


<div class="container">



	
			<a href="user_new_message.php?" class="btn btn-primary">New Message</a>
			<h1 class="title">Your Inbox</h1>
		



	<div class="row">


		<div class="col-md-8 offset-md-2">

			<?php 


			if($conversation->exist()) {



				foreach($conversation->data() as $data) {

						//svar_dump($data);
						$last_reply = $data->last_reply;
						$subject = $data->subject;
						$con_id = $data->id;

					?>

					<div class="message-unit">


						<h2 class="message-title"><a href="view_conversation.php?con_id=<?php echo $con_id; ?>"><?php echo $subject;?></a></h2>
						<p class="text">Last Reply: <?php echo date("jS M Y", $last_reply);?></p>




					</div>


					<?php 
				}


			}



			?>

		</div>

		


	</div>



	


</div>



