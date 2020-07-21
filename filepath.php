<?php 

function getDefaultPath() {
   $configs = include('config.php');
   return  $configs['defaultPath'];   
}

function getDefaultFile() { 
   $configs = include('config.php');
   return  $configs['defaultFile'];
}

// default file path of settings file in workstation 
function getDefaultFilepath(){
   return getDefaultPath() . getDefaultFile(); 
}

//generate default folder path
function generateDefaultFolder() {
   
    $path       = getDefaultPath();
    $filepath   = "";
    $ret = false;

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
                    //todo: safe or not
                    mkdir($testpath, 0777, true);
                    // mkdir($testpath);                    
                }                        
                $i++;
            }
            if (file_exists(getDefaultPath())) {
                $ret = true;
            }
            else {
                $ret = false;
            }               
        }
    }

    catch(Exception $e) {
        $ret = false;
        log_writing2($e->getMessage());       
    }
   
    return  $ret;
}

function log_writing2($msg) {      
    
    if (!file_exists('logs')) {
        mkdir('logs', 0777, true);
    }

    $date_utc = new \DateTime("now", new \DateTimeZone("UTC")); //UTC-time is used
    
    $log  = $date_utc->format(\DateTime::ISO8601) . " " . $msg .  "\r\n";
    file_put_contents('./logs/log_'.date("j.n.Y").'.txt', $log, FILE_APPEND);
}

?>