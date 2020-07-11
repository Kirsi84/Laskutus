<?php
    // testing data
    // $vendors = array (
    //     array("1", "Dösä Oy", "FI12345678"),
    //     array("2", "Taukopupa Oy", "FI778845678")
    // );
   
    include "logWriting.php";
    include "getFilePath.php";

    if (session_status() == PHP_SESSION_NONE) {
        session_start();              
    }
   
    $vendors = array();    

    try {
     
        $filepath = getDefaultFilepath();
        $key = 1;
        if (file_exists($filepath)) {
            $file = fopen($filepath,"r");
            while (($line = fgetcsv($file)) !== FALSE) {
                 
                // creating array from parameters: key, vendor and accountnumber
                if ($line[0] == "LASKUTTAJA") {                  
                    $vendor = array($key, $line[1], $line[2]);
                    array_push($vendors, $vendor);
                    $key =  $key + 1;
                }              
            }
            fclose($file);
        }
        else {
            log_writing( "File not found: " . $filepath ); 
        }      
    }
    catch(Exception $e) {
     
        log_writing($e->getMessage());
       // show_user_error("Virhe tietokantakäsittelyssä. Kokeile hetken kuluttua uudelleen.");
    }

    

?> 