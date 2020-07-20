<?php

function getDefaultPath() {  
    return  "c:\\Laskutus\\";  
}

function getDefaultFile() {
    return  "Asetukset.csv";
}

// default file path of settings file in workstation 
function getDefaultFilepath(){ 
    return getDefaultPath() . getDefaultFile();   
}


//generate default file path
function generateDefaultFilePath() {
   
    $path       = getDefaultPath();
    $filepath   = "";

    try {
        // check if folder exists or not
        if (!file_exists($path)) {
    
            $arr =  explode('\\', $path);     
            $testpath = 'c:\\';     
            $max = count($arr);

            $i = 1;
            while($i < $max) {
                    
                $testpath =  $testpath . '\\' . $arr[$i];          
                if (!file_exists($testpath)) {
                    mkdir($testpath);
                }                        
                $i++;
            }
            $filepath =  $testpath . getDefaultFile();
            return true;
        }
    }

    catch(Exception $e) {
        return false;
        //$filepath   = "";
    }
   
//return  $filepath;
}


?>