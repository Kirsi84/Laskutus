<?php
 
if(!isset($_POST)) {
   // header('location:settings.php');  
   exit();
}
if(!isset($_POST['btn-save'])) {
   // header('location:settings.php'); 
   exit();
}

include_once 'iban.php';

$userMessage = "";

try {

    $configs = include('config.php');
    $csvDelimiter =  $configs['defaultCSVDelimiter'];
    $new_accountnumber = "";
    $new_vendorname = "";
    if (isset($_POST['new_vendorname']))  {           
        $new_vendorname =  trim($_POST['new_vendorname']);            
    }
    if (isset($_POST['new_accountnumber']))  {  
        if (! empty($_POST['new_accountnumber'])) {  
                    error_log("koe" . $_POST['new_accountnumber'], 0);
            $new_accountnumber =  test_input($_POST['new_accountnumber']);      
            $new_accountnumber = str_replace(' ', '', $new_accountnumber);
            $new_accountnumber =  strtoupper($new_accountnumber);
            if (checkIBAN($new_accountnumber) == false) {     
                $userMessage =  "Virheellinen IBAN-tilinumero!";
                header("Location: settings.php?Message=". urlencode($userMessage));      
                exit();
            }
        } 
    }

    $counter = 0;
    if (isset($_POST['accountnumber'])) {
        if (is_countable($_POST['accountnumber'])) {
            $counter = count($_POST['accountnumber']);
        }
    }
    if (($new_accountnumber == "") && ($new_vendorname == "")  && ($counter == 0)) {
        $userMessage = " Ei päivitettäviä tietoja. Lisää tiedot!";
        header("Location: settings.php?Message=". urlencode($userMessage));      
        exit();
    }
    if (($new_accountnumber == "") && ($new_vendorname != "")) {
        $userMessage = " Tilinumero puuttuu. Tarkista tiedot!";
        header("Location: settings.php?Message=". urlencode($userMessage));      
        exit();
    }
    if (($new_accountnumber != "") && ($new_vendorname == "")) {
        $userMessage = " Laskun lähettäjän nimi puuttuu. Tarkista tiedot!";
        header("Location: settings.php?Message=". urlencode($userMessage));      
        exit();
    }
    
    $dublicates = false;
    $settings = array();

    for ($i = 0; $i < $counter; $i++) { 
        if (isset($_POST['vendorname'][$i]))  {           
            $vendorname =  trim(trim($_POST['vendorname'][$i]));            
        }
        if (isset($_POST['accountnumber'][$i]))  {           
            $accountnumber =  trim(trim($_POST['accountnumber'][$i]));           
        }
        // no dublicates
        if (($vendorname == $new_vendorname) &&  ($accountnumber == $new_accountnumber)) {
            $dublicates = true;
        }
       
        $line = array("LASKUTTAJA",  $vendorname, $accountnumber);
        array_push($settings, $line); 
    }

    if ($dublicates == false) {
        if ($new_vendorname != "") {
            if ($new_accountnumber != "") {
                $line = array("LASKUTTAJA",  $new_vendorname, $new_accountnumber);
                array_push($settings, $line); 
            }
        }
    } 

    array_to_csv_download(
        $settings, 
        "Asetukset.csv", $csvDelimiter
    ); 
    $userMessage= "Csv-tiedoston muodostus onnistui!";
}
catch (Exception $e) { 
    error_log($e->getMessage(), 0);
}

function test_input($data) {
    $data = trim($data);
    $data = strip_tags($data);
  
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function array_to_csv_download($array, $filename = "export.csv", $delimiter) {
    // open raw memory as file so no temp files needed, you might run out of memory though
    $f = fopen('php://memory', 'w'); 
    // loop over the input array
    foreach ($array as $line) { 
        // generate csv lines from the inner arrays
        fputcsv($f, $line, $delimiter); 
    }
    // reset the file pointer to the start of the file
    fseek($f, 0);
    // tell the browser it's going to be a csv file
    header('Content-Type: application/csv');
    // tell the browser we want to save it instead of displaying it
    header('Content-Disposition: attachment; filename="'.$filename.'";');
    // make php send the generated csv lines to the browser
    fpassthru($f);
}


?>