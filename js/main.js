$(function(){


	//navigation stuff


	$('.menu').on('click', function(){


		$('.menu').toggleClass('active');

	});






		var check = setInterval(check_message, 100);


		var $counter = 1;





		function check_message() {


				$.get('check_messages.php', function(data){


					$('#message_result').html(data);

				});



				//check notifications


				$.get('check_note.php', function(data){


						$("#note_result").html(data);
				});


				//get check requests

				$.get("check_request.php", function(data){


							$("#request_result").html(data);

				});


		}


		$("#search").on("keyup", function(){


			var search = $('#search').val();

			console.log(search);


			if(search == "") {

					$("#result").html("<p>No match Found</p>");

			} else if( search != "") {

				$.post("search_user.php", {

					'search': search

				}, function(data){


						$("#result").html(data);

				});


			}

		
		})







})