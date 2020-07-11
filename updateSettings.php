<?php   
 include "logWriting.php";
 include "getFilePath.php";

function createSetting() {

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
   
    $newdata = array($type,  $vendorname, $accountnumber);
    $settings = array();

    try {
     
        $filepath = getDefaultFilepath();
        
        // reading old data from parameters into an array
        if (file_exists($filepath)) {
            $file = fopen($filepath,"r");

            while (($line = fgetcsv($file)) !== FALSE) {                 
                array_push($settings, $line); 
            }
        }
        else {
            log_writing("jees1");

            $filepath = generateDefaultFilePath();
            log_writing("jees1" . $filepath);

        }
        // add new data into an array
        array_push($settings, $newdata);

        // write rows into the file
        $file = fopen($filepath,"w");
        foreach ($settings as $row) {
            fputcsv($file, $row);
        }    
        //close file
        fclose($file);
        $userMessage = "Asetus on lisätty asetustiedostoon!";
       
    }
    catch(Exception $e) {
        $userMessage = "Asetustiedon päivitys ei onnistunut!";
        log_writing($e->getMessage());    
    }
    
    return $userMessage;
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

function getSetting2($ind) {
  
    $settings = array();
   
    try {
     
        $filepath = getDefaultFilepath();
        
        if (file_exists($filepath)) {
            $file = fopen($filepath,"r");
            $i = 0;
            while (($line = fgetcsv($file)) !== FALSE) { 
                if ($i == $ind)  {                       
                    array_push($settings, $line); 
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
