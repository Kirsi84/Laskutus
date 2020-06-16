<?php
 
 
 // log_writin by UTC-time 
    function log_writing($msg) {      
        
        if (!file_exists('logs')) {
            mkdir('logs', 0777, true);
        }

        $date_utc = new \DateTime("now", new \DateTimeZone("UTC")); //UTC-time is used
        
        $log  = $date_utc->format(\DateTime::ISO8601) . " " . $msg .  "\r\n";
        file_put_contents('./logs/log_'.date("j.n.Y").'.txt', $log, FILE_APPEND);
    }

    ?> 