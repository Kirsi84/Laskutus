<?php

// include "logWriting.php";
include_once 'iban.php';

// define variables and set to empty values
//$vendornameErr = $duedateErr = $accountnumberErr = $vendormessageErr = "";
$vendorname = $duedate = $accountnumber = $vendormessage = $refnumber = "";
$selectedoption = 0;
$vendordata = 0;
$checkDataErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (isset($_POST["vendordata"])) {   
      $vendordata = $_POST["vendordata"];        
  } else {
      $vendordata = "";      
  }

  if (empty($_POST["vendorname"])) {   
    $checkDataErr = "Laskun lähettäjä on pakollinen!";
    
  } else {
    $vendorname = test_input($_POST["vendorname"]);   
  }

  if (empty($_POST["duedate"])) {   
    $checkDataErr = "Laskun eräpäivä on pakollinen!";    
  } else {
    $duedate = test_input($_POST["duedate"]);  
  }

  if (empty($_POST["accountnumber"])) {
    $checkDataErr =  "Tilinumero on pakollinen!";
  }
  else {
    $accountnumber = test_input($_POST["accountnumber"]);  
    $accountnumber = str_replace(' ', '', $accountnumber);
    $accountnumber =  strtoupper($accountnumber);
    if (checkIBAN($accountnumber) == false) {     
        $checkDataErr =  "Virheellinen IBAN-tilinumero!";
    }
  }
  if (empty($_POST["vendormessage"])) {
    $vendormessage = "";
  } else {
    $vendormessage = test_input($_POST["vendormessage"]);
  }  
}
 
function test_input($data) {
  $data = trim($data);
  $data = strip_tags($data);

  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>