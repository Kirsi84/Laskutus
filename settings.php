<?php

    // Start the session
    session_start();

    // file upload
    include 'uploadSettings.php';

    // define variables and set to empty values
    // include 'checkData.php';

    // if (isset($_POST["upload"])) {
    //   require_once "getReferenceNumber.php";
    //   $_SESSION["refnumber"] =  $refnumber;
    // }

    function resetSession(){
        // remove all session variables
       session_unset();
    }  

    function resetFormData() {
        resetSession();
        
        // $vendorname  = "";
        // $accountnumber = "";
        // $duedate = "";
        // $message = "";
        // $refnumber = "";
    }


?>

<!DOCTYPE html>
<html>

    <?php
        include 'head.php';
    ?>

    <body>  
         
        <div class="main">
            <?php   
               include 'navbar.php';
            ?>  

            <form id="frm-upload" action="" method="post"
                enctype="multipart/form-data">
    
                
                    <div>
                    <br> <br> <br>
                    <p><a href="create.php">Lisää laskuttajatieto</a></p>
                   

                        <legend>2. Valitse ja lataa asiakastiedosto (csv):</legend>       
                        <br>
                      
                        <input type="file" class="file-input" name="file-input" value="<?php echo $fileinput;?>">
                        
                        <input type="submit" class="btn-submit" id="upload" name="upload"
                             value="Lataa tiedosto">

                        <?php if(!empty($response)) { ?>
                        <div class="response <?php echo $response["type"]; ?>
                            ">
                        <?php echo $response["message"]; ?>
                    </div>
               
                    <?php }?>
                    
                    </div>
              
              

                  <?php if(!empty($response)) {
                if ($response["type"] == "success") {   
                    if(!empty(isset($_POST["upload"]))) {
                        if (($fp = fopen($_FILES["file-input"]["tmp_name"], "r")) !== FALSE) {
            ?>

             
                    <div>

                    <legend>Laskun lähettäjän tietojen tallennus tiedostoon</legend>      
                    <br> 
           
                    <br>
                    <br>

                    <div class="container" id ="container">
                    <table class="gridtable" id="tableMain">
                        <thead>
                            <tr class="tableheader">      
                                <th>Parametri</th>
                                <th>Laskuttajan nimi</th> 
                                <th>Laskuttajan tilinumero</th>                            
                            </tr>
                        <thead>

                        <tbody>
                        <?php
                            $i = 0;
                            while (($row = fgetcsv($fp)) !== false) {

                                $class ="";
                                if($i==0) {
                                    $class = "header";
                                }
                        ?>
                         
                                <tr name="datarow" class="datarow">
                                            
                                    <td>                    
                                        <?php echo $row[0]; ?>                   
                                    </td>
                                    <td>
                                        <?php echo $row[1]; ?>                 
                                    </td>
                                    <td>
                                        <?php echo $row[2]; ?>                
                                    </td>
                            
                                </tr>
                        <?php
                                $i ++;
                            }
                    
                            fclose($fp);
                       
                        ?>
                        </tbody>
                    </table>
                    </div>
                    
                    <?php
                        $response = array("type" => "success", "message" => "CSV is converted to HTML successfully");
                        } else {
                            $response = array("type" => "error", "message" => "Unable to process CSV");
                        }
                    }
                    ?>
                    </div>
                    <?php if(!empty($response)) { ?>
                    <div class="response <?php echo $response["type"]; ?>
                        ">
                        <?php echo $response["message"]; ?>
                    </div>
                    <?php } ?>
                    </div>
            <?php
                }                      
            }
            ?>
            
            </form>   
        </div> 
    </body>
</html>
