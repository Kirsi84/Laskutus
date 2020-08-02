<?php
//header('Content-Type: text/html; charset=UTF-8');

if (isset($_POST["upload-settings"])) {
  
    // Get file extension
    $file_extension = pathinfo($_FILES["file-input-settings"]["name"], PATHINFO_EXTENSION);
   
    // Validate file input to check if is not empty
    $filename = $_FILES["file-input-settings"]["tmp_name"];
   
    if (! file_exists($_FILES["file-input-settings"]["tmp_name"])) {
        $responseSettings = array(
            "type" => "error",
            "message" => "Tiedosto tulee olla valittuna ennen tiedoston lataamista!" 
        );
    } // Validate file input to check if is with valid extension
    else if ($file_extension != "csv") {
            $responseSettings = array(
                "type" => "error",
                "message" => "Virheellinen asetustiedosto. Tiedostolla on oltava .csv tiedostopääte."
            );
          
        } // Validate file size
    else if (($_FILES["file-input-settings"]["size"] > 2000000)) {
            $responseSettings = array(
                "type" => "error",
                "message" => "CSV-tiedoston koko on liian suuri!"  
            );
        } // Validate if all the records have same number of fields
    else {
        $lengthArray = array();
        
        $row = 1;
        if (($fp = fopen($_FILES["file-input-settings"]["tmp_name"], "r")) !== FALSE) {

           // utf8_encode(fgets($file));
           while (($data = fgetcsv($fp, 1000, ",")) !== FALSE) {
                $data = array_map("utf8_encode", $data); //added
               
                $lengthArray[] = count($data);
                $row ++;
            }
            fclose($fp);
        }            
        
        $lengthArray = array_unique($lengthArray);
        
        // everything is ok
        if (count($lengthArray) == 1) {
            $responseSettings = array(
                "type" => "success",
                "message" => "Asetustiedoston validointi onnistui!"
            );
           

          
        } else {
            $responseSettings = array(
                "type" => "error",
                "message" => "Virheellinen CSV-tiedosto!"   
            );
         
        }
    }
}

?>