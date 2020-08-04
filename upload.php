<?php
header('Content-Type: text/html; charset=UTF-8');

date_default_timezone_set('Europe/Helsinki');

if (isset($_POST["upload"])) {

    $configs = include('config.php');
    $csvDelimiter =  $configs['defaultCSVDelimiter'];
    $csvSize =  $configs['defaultCSVSize'];
  
    // Get file extension
    $file_extension = pathinfo($_FILES["file-input"]["name"], PATHINFO_EXTENSION);
    // Validate file input to check if is not empty

    if (! file_exists($_FILES["file-input"]["tmp_name"])) {
        $response = array(
            "type" => "error",
            "message" => "Tiedosto tulee olla valittuna ennen tiedoston lataamista!"           
        );
    } // Validate file input to check if is with valid extension
    else if ($file_extension != "csv") {
            $response = array(
                "type" => "error",
                "message" => "Virheellinen asiakastiedosto. Tiedostolla on oltava .csv tiedostopääte."
            );
          
        } // Validate file size
    else if (($_FILES["file-input"]["size"] > 2000000)) {
            $response = array(
                "type" => "error",
                "message" => "CSV-tiedoston koko on liian suuri!"               
            );
        } // Validate if all the records have same number of fields
    else {
        $lengthArray = array();
        
        $row = 1;
        $lask = -1;  // count of columns
        $checkEmail = true;
        $email = "";

        if (($fp = fopen($_FILES["file-input"]["tmp_name"], "r")) !== FALSE) {

           // utf8_encode(fgets($file));
          // while (($data = fgetcsv($fp, 1000, ",")) !== FALSE) {
            while (($data = fgetcsv($fp, $csvSize, $csvDelimiter)) !== FALSE) {
                $data = array_map("utf8_encode", $data); //added
               
                // email column must be empty or email
                if ($checkEmail == true) {
                   // $email =  $data[5]; 
                   if (isset($data[5])) {
                        $email = $data[5];
                        if ($email != "") {                   
                            if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {                     
                                $checkEmail = false;
                            }
                        }
                    }
                }               

                $lengthArray[] = count($data);
                if ($lask == - 1) {
                    $lask = count($data);
                }
                $row ++;
              
            }
            fclose($fp);
        }            
        
        $lengthArray = array_unique($lengthArray);
        
        // everything is ok
        if ((count($lengthArray) == 1)  && ($lask == 6)) {
       
            if ($checkEmail ==  false) {            
                $response = array(
                    "type" => "error",
                    "message" => "Asiakastiedostossa virheellinen sisältö!"  
                );
            }
            else {

                $response = array(
                    "type" => "success",
                    "message" => "Asiakastiedoston validointi onnistui!"
                );
            }   
          
        } else {
            $response = array(
                "type" => "error",
                "message" => "Virheellinen CSV-asiakastiedosto!"               
            );
        }
    }
}

?>