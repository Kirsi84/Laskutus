<?php   
 include "logWriting.php";
 include "settingsFilePath.php";

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
     
        $filepath = getSettingsFilepath();
        
        // reading old data from parameters into an array
        if (file_exists($filepath)) {
            $file = fopen($filepath,"r");

            while (($line = fgetcsv($file)) !== FALSE) {                 
                array_push($settings, $line); 
            }
        }
        // add new data into an array
        array_push($settings, $newdata);

        //log_writing(implode(" ", $newdata));

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
   // header("Location: settings.php?Message=".$userMessage);
}
?>
