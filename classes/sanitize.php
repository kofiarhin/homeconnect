<?php 


	class Sanitize {


			public static function object($object) {

					//convert oject to array first

				$new_array = (array) $object;

				$new_data = array_filter($new_array);


				return $new_data;
			}


			public static function flatten(array $array) {


				$flattened = new RecursiveArrayIterator($array);

				$flattened = new RecursiveIteratorIterator($flattened);

				$flattened = iterator_to_array($flattened, false);

				return($flattened);
			}


	}