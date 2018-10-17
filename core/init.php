<?php 

		session_start();

		$GLOBALS['config'] = array(

			'mysql' => array(

				'host' => 'localhost',
				'dbname' => 'test',
				'username' => 'root',
				'password' => 'root'
			),

			'session' => array(

				'session_name' => 'user',
				'token_name' => 'token'
			),

			'cookie' => array(


				'cookie_name' => 'hash',
				'cookie_expiry' => 604800
			)

		);

		spl_autoload_register(function($class){

			require_once "classes/".$class.".php";

		});


		require_once "functions/sanitize.php";
		

		$countries = db::get_instance()->get('apps_countries')->result();


		//var_dump($countries);
