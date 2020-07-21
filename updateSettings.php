<?php 

include "logWriting.php";
include "filePath.php";
include_once "iban.php";

error_reporting(0); // in production not showing when zero
//error_reporting(E_ALL); // in test environment show all errors

function createSetting() {
    $infoarr = array();
    $infoarr[0] = "error"; 
    $infoarr[1] = "Virhe asetustietojen käsittelyssä!"; 
    $userMessage = "";
    
    if (checkPath()) {

        $type = "";
        $accountnumber = "";
        $vendorname = "";
        $userMessage = "";
        $ok = true;
             
        if (isset( $_POST['type']))  {     
            $type        = trim(strip_tags( $_POST['type']));
        }
        if (isset( $_POST['accountnumber']))  {     
            $accountnumber       = trim(strip_tags( $_POST['accountnumber']));
        }
        else {
            $userMessage = "Tilinumero on pakollinen. ";
            $ok = false;
        }  
        if (!checkIBAN($accountnumber)) {
            $userMessage = $userMessage . "Virheellinen IBAN-tilinumero. ";
            $ok = false;
        } 
        if (isset( $_POST['vendorname']))  {     
            $vendorname        = trim(strip_tags( $_POST['vendorname']));
        }
        else {
            $userMessage = $userMessage . "Laskun lähettäjä on pakollinen. ";
            $ok = false;
        }         
    
        if ($ok) { 
            $newdata = array($type,  $vendorname, $accountnumber);
            $settings = array();

            try {
            
                $filepath = getDefaultFilepath();
               
                $dublicates = false;
                // reading old data from parameters into an array
                if (file_exists($filepath)) {
                   
                    $dublicates = false;
                    $file = fopen($filepath,"r");

                    while (($line = fgetcsv($file)) !== FALSE) {                 
                        array_push($settings, $line); 
                        if ( $line == $newdata) {
                            $dublicates = true;
                        }
                    }
                }
                
                if ($dublicates == true) {
                    $userMessage = "Sama asetus on lisätty jo aiemmin asetustiedostoon! ";
                    $ok = false;
                }
                else {
                    // add new data into an array
                    array_push($settings, $newdata);

                    sort($settings);
                   
                    // write rows into the file
                    $file = fopen($filepath,"w");
                    foreach ($settings as $row) {
                        fputcsv($file, $row);
                    } 
                    $infoarr[0] = "success";
                    $userMessage = "Asetus on lisätty asetustiedostoon! "; 
                   
                }  
                //close file
                fclose($file);
 
            }
            catch(Exception $e) {
                $userMessage = "Asetustiedon päivitys ei onnistunut! ";
                log_writing($e->getMessage());                 
            }
        }
        else {
            $userMessage =   $userMessage . " Asetustietoa ei lisätty. ";
        }
       
    }
    else {
        $userMessage =   $userMessage . "Asetustiedoston hakemistorakenteen luonti ei onnistu. Asetustietoa ei lisätty!";
    }
    $infoarr[1] = $userMessage;
    return $infoarr;
}

function checkPath(){
    $path = getDefaultPath(); // folder

    if (file_exists($path)) {
        return true;
    }
    else  {
        // user allows to create file path
        if (isset( $_POST['permission']))  {     
            if (generateDefaultFolder()) {
                return true;
            }
            else {
                return false;
            }            
        }
        else {
            return false;
        }
    } 
}

function deleteSetting() {

    $type = "";
    $accountnumber = "";
    $vendorname = "";
    $userMessage = "";

    if (isset( $_POST['type']))  {     
        $type        = trim(strip_tags( $_POST['type']));
    }
    if (isset( $_POST['accountnumber']))  {     
        $accountnumber       = trim(strip_tags( $_POST['accountnumber']));
    }
    if (isset( $_POST['vendorname']))  {     
        $vendorname        = trim(strip_tags( $_POST['vendorname']));
    }     
   
    $deletedata = array($type,  $vendorname, $accountnumber);
    $settings = array();

    try {
     
        $filepath = getDefaultFilepath();
        
        // reading old data from parameters into an array
        if (file_exists($filepath)) {
            $file = fopen($filepath,"r");

            while (($line = fgetcsv($file)) !== FALSE) { 
                
                if (($line[0]== $type) && ($line[1]== $vendorname) && ($line[2]== $accountnumber)) {
                    continue;
                }
                else {
                    array_push($settings, $line); 
                }               
            }
        }       

        // write rows into the file
        $file = fopen($filepath,"w");
        foreach ($settings as $row) {
            fputcsv($file, $row);
        }    
       
        fclose($file);
        // $userMessage = "Asetus on poistettu asetustiedostosta!";
        /* Redirect browser */
        header("Location: settings.php"); 
        exit();
       
    }
    catch(Exception $e) {
        $userMessage = "Asetustiedon päivitys ei onnistunut!";
        log_writing($e->getMessage());    
    }
    
    return $userMessage;
}

function getAllSettings() {
  
    $settings = array();
    $userMessage = "";
    try {
     
        $filepath = getDefaultFilepath();
        
        // reading old data from parameters into an array
        if (file_exists($filepath)) {
            $file = fopen($filepath,"r");
            
            while (($line = fgetcsv($file)) !== FALSE) {                 
                array_push($settings, $line); 
               
            }
             //close file
            fclose($file);
        }
               
        return $settings;      
       
    }
    catch(Exception $e) {
       // $userMessage = "Asetustietojen haku ei onnistu!";
        log_writing($e->getMessage()); 
        //return $userMessage; 
        return $settings;  
    }
}

function getSetting($ind) {
  
    $settings = array();
   
    try {
     
        $filepath = getDefaultFilepath();
        
        if (file_exists($filepath)) {
            $file = fopen($filepath,"r");
            $i = 0;
            while (($line = fgetcsv($file)) !== FALSE) { 
                if ($i == $ind)  {                       
                    array_push($settings, $line); 
                    break;
                }
                $i = $i + 1; 
            }
           
            fclose($file);
        }
      
        return $settings;      
       
    }
    catch(Exception $e) {
     
        log_writing($e->getMessage()); 
     
        return $settings;  
    }
}



?>
