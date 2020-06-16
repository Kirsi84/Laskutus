<?php

require_once "referenceNumber.php";
$lasku = rand(100000, 999999);  
$refnumber = SuomalainenViite::luo($lasku);

?>