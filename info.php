<?php 

		if(session::exist('success')) {

			?>
		
			<div class="container">
				
				<div class="row">
					
					<div class="col-md-10 offset-md-1"><p class="alert alert-success text-center info"><?php echo session::flash('success'); ?></p></div>


				</div>


			</div>


			<?php 
		}


		

 ?>