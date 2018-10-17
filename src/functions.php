<?
	function p() {

		$backtrace = debug_backtrace();

		if($debug=value($backtrace,0)) {

			$accept_json = preg_match("/json/",value(getallheaders(),"accept"));

			echo '<div style="padding:2px;border: 0px dashed red;font-weight:bold">DEBUG: '.value($debug,"file").' @ line number '.value($debug,"line");
			
			foreach(func_get_args() as $value) {

				if($value===null)
					$value = "NULL";
				elseif($value===FALSE)
					$value = "FALSE";
				elseif($value===TRUE)
					$value = "TRUE";
				elseif(is_object($value) && is_a($value,"stdObject"))
					$value = (string)$value;

				if(is_array($value) || is_object($value)) {

					print "<pre style='margin:4px;margin-left:10px;font-weight:normal'>";

					print_r($value);

					print "</pre>";
				} else {

					print "<pre style='margin:4px;margin-left:10px;font-weight:normal'>";

					if(is_string($value))
						$value = htmlentities($value);

					print($value);

					print "</pre>";
				}
			}

			echo '</div>';
		}
	}

	function value($var,$index,$default=null) {

		if($var===null)
			return $default;

		$is_array = is_array($index);

		if($is_array && count($index)==1) {
			$index = array_shift($index);
			$is_array = is_array($index);
		}

		if($is_array) {

			$first_index = @$index[0];

			if($first_index!==null) {

				$vars = null;
				if(is_array($var))
					$vars = @$var[$first_index];

				elseif(is_object($var)) {

		        	if(is_a($var,"ArrayAccess"))
		        		$vars = $var[$first_index];
		        	else
		        		$vars = @$var->$first_index;
				}

				if($vars!==null) {

					array_shift($index);

					if(count($index)==1)
						$index = $index[0];

					if(is_array($vars) || is_object($vars))
						return value($vars,$index,$default);

					return $default;
				}
			}

			return $default;

        } elseif(is_array($var)) {

            if(@array_key_exists($index,$var))
                return $var[$index];

        } elseif(is_object($var)) {

        	if(is_a($var,"ArrayAccess")) {

        		if(isset($var[$index]))
        			return $var[$index];

        	} elseif(isset($var->$index))
        		return $var->$index;
        }

		return $default;
	}