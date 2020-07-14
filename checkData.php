<?php

// include "logWriting.php";
include 'iban.php';


// define variables and set to empty values
$vendornameErr = $duedateErr = $accountnumberErr = $vendormessageErr = $refnumberErr = "" ;
$vendorname = $duedate = $accountnumber = $vendormessage = $refnumber = "";
$vendordata = 0;
$checkDataErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  //todo:
  if (empty($_POST["vendordata"])) {   
    $vendordata = 0;    
  } else {
    $vendordata = test_input($_POST["vendordata"]);   
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

//todo:
// Kansainvälinen IBAN-muotoinen tilinumero muodostuu kotimaisesta tilinumerosta,
// jonka eteen on lisätty maakoodi eli kirjaimet FI sekä kaksi tarkistenumeroa XX.
// Esimerkiksi tilinumero IBAN-muotoisena.  FI49 1234 5678 9123 XX.
// function checkIBAN($iban)
// {
//     $iban = trim($iban);
//     if (strlen($iban) == 18) {
//         return true;
//     }
//     else {
//         return false;
//     }
// }
 
function test_input($data) {
  $data = trim($data);
  $data = strip_tags($data);

  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>