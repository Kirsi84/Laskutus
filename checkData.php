<?php
// define variables and set to empty values
// include "logWriting.php";
// log_writing("test1");

$nameErr = $duedateErr = $accountnumberErr = $messageErr = $refnumberErr = "" ;
$name = $duedate = $accountnumber = $message = $refnumber = "";

$checkDataErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {   
    $checkDataErr = "Laskun lähettäjä on pakollinen!";
    
  } else {
    $name = test_input($_POST["name"]);   
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
    if (checkIBAN($accountnumber) == false) {     
      $checkDataErr =  "Virheellinen tilinumero!";
    }
  }
  if (empty($_POST["message"])) {
    $message = "";
  } else {
    $message = test_input($_POST["message"]);
  }
 
  include "makeRefNumber.php";
  
}

// function  generateErrorMessage($check) {
//   $checkDataErr = $check . " Tarkista tiedot!";
//   return $checkDataErr;
// }



//todo:
// Kansainvälinen IBAN-muotoinen tilinumero muodostuu kotimaisesta tilinumerosta,
// jonka eteen on lisätty maakoodi eli kirjaimet FI sekä kaksi tarkistenumeroa XX.
// Esimerkiksi tilinumero IBAN-muotoisena.  FI49 1234 5678 9123 XX.
function checkIBAN($iban)
{
    $iban = trim($iban);
    if (strlen($iban) == 18) {
        return true;
    }
    else {
        return false;
    }
}

   

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>