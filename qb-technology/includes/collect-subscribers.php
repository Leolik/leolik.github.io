<?php 
	$json = json_decode(file_get_contents("php://input"));
  	if (is_null($json)) {
    	return;
  	}
  	$errors = array();
	$data = (array)$json;
  	if (isset($data['submit']) && $data['submit'] === 'Sign Up') {
    	foreach ($data as $item => $value) {
      		$data[$item] = htmlspecialchars(trim($value));
    	}
    	if (empty($data['email'])) {
	    	$errors['email'] = "Field is empty";
    	} else if (!preg_match("/^[a-z0-9\._-]+@+[a-z0-9\._-]+\.+[a-z]+$/i", $data['email'])) {
	    	$errors['email'] = "Invalid E-mail address";
	    }
    	if (empty($errors)) {
    	  $path = __DIR__ . DIRECTORY_SEPARATOR ."..". DIRECTORY_SEPARATOR ."data";
    		$filename = 'subscribers.csv';
    		if (!is_dir($path)) {
    			mkdir($path);
    		}
    		$path .= DIRECTORY_SEPARATOR . $filename;
    		$isFile = file_exists($path);
			  $file = fopen($path, 'a');
        if ($file) {
  			  if (!$isFile) {
  				  fputcsv($file, array("Email"));
  			  }
      		fputcsv($file, array($data['email']));
  			  fclose($file);
        } else {
          $errors['email'] = "Error saving E-mail";
        }
  		}
    	header('Content-Type: application/json');
    	echo json_encode(array(
    		'errors' => $errors, 
    		'success' => empty($errors)
    	));
  	}
?>