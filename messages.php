<?php 

require_once "header.php";

?>


<?php 


 	//check if user is logged in

if(!$user->logged_in()) {


	redirect::to('login.php');
}



 	//var_dump($user);


$message = new Message;

$datas = $message->get_messages();



?>

<section id="messages">

	

	<div class="container">

		<?php 


				//chedk  if user wants to delete message

		if(input::exist('post', 'delete_submit')) {

			$message_id = (int) input::get(('message_id'));

			$message = new Message();

			$delete = $message->delete($message_id);

			if($delete) {

				redirect::to('messages.php');
			}


			
		}

		?>


		<h1 class="display-4">Display Messages</h1>

		<?php 

		if($datas) {


			?>

			<div class="col-md-8 offset-md-2">



				<?php 

				foreach($datas as $data) {

					$sender = new User($data->sender_id);

					if($sender->exist()) {

						

						?>

						<div href="" class="message-unit <?php if($data->checked == 0) {

							echo "grey";

						} ?>">
						<p class="text name"><?php echo $sender->data()->username; ?></p>
						<p class="text message"><?php echo substr($data->content, 0, 100); ?><span class="q">	</span></p>

						<div class="button-wrapper">

							<a class="btn btn-primary"   href="view_message.php?message_id=<?php echo $data->id; ?>">View Message</a>


							<form action="" method='post'>
								<input type="hidden" name='message_id' value="<?php echo $data->id; ?>">
								<button class="btn btn-danger" name='delete_submit' type='submit'>Delete
								</button>
							</form>


						</div>

					</div>

					<?php 




				}



			}


			?>	




		</div>


		<?php 


	}

	?>


</div>


</section>

