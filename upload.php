<?php
if (isset($_POST["upload"])) {
    
    // Get file extension
    $file_extension = pathinfo($_FILES["file-input"]["name"], PATHINFO_EXTENSION);
    // Validate file input to check if is not empty
    if (! file_exists($_FILES["file-input"]["tmp_name"])) {
        $response = array(
            "type" => "error",
            "message" => "File input should not be empty."
        );
    } // Validate file input to check if is with valid extension
    else if ($file_extension != "csv") {
            $response = array(
                "type" => "error",
                "message" => "Invalid CSV: File must have .csv extension."
            );
            echo $result;
        } // Validate file size
    else if (($_FILES["file-input"]["size"] > 2000000)) {
            $response = array(
                "type" => "error",
                "message" => "Invalid CSV: File size is too large."
            );
        } // Validate if all the records have same number of fields
    else {
        $lengthArray = array();
        
        $row = 1;
        if (($fp = fopen($_FILES["file-input"]["tmp_name"], "r")) !== FALSE) {
            while (($data = fgetcsv($fp, 1000, ",")) !== FALSE) {
                $lengthArray[] = count($data);
                $row ++;
            }
            fclose($fp);
        }
            
        $lengthArray = array_unique($lengthArray);
        
        if (count($lengthArray) == 1) {
            $response = array(
                "type" => "success",
                "message" => "File Validation Success."                
            );
                     
            include 'getCustomers.php';
            
        } else {
            $response = array(
                "type" => "error",
                "message" => "Invalid CSV: Count mismatch."
            );
        }
    }
}


?>