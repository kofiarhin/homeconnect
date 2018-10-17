<?php 

	class Config {

		public static function get($path = null) {

			$config = $GLOBALS['config'];

			if($path) {

				$path = explode('/', $path);

				foreach($path as $bit) {

					if(isset($config[$bit])) {

						$config = $config[$bit];
					}
				}

				return $config;
			}
		}
	}