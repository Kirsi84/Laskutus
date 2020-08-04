<?php
    $configs = include('config.php');
    $csvDelimiter =  $configs['defaultCSVDelimiter'];
    $csvSize =  $configs['defaultCSVSize'];

    if (session_status() == PHP_SESSION_ACTIVE) {       
        session_unset();   // remove all session variables       
        session_destroy();      // destroy the session     
    }

    $new_vendorname = "";
    $new_accountnumber = "";   
    
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
            <br><br><br>

            <form id="frm-get-settings" action="" class="form-create" method="post" 
                enctype="multipart/form-data">
    
                <fieldset class="fieldset-create">  
                                     
                    <legend>Asetustiedot - laskun lähettäjän vakiotiedot</legend>      
                    <br> 
                    Valitse ja hae aiemmin talletettu asetustiedosto:
                    <br> <br>  
                    <input type="file" class="file-input" id="file-input-settings" name="file-input-settings" > 
                    <input type="submit" class="btn-submit" id="upload-settings" name="upload-settings"
                        value="Asetusten haku"> 

                </fieldset>
            </form> 

            <form id="frm-settings" action="save.php" class="form-create" method="post" 
                enctype="multipart/form-data">
    
                <fieldset class="fieldset-create">      
                                      
                    <legend>Asetustietojen päivitys</legend>      
                    
                    <fieldset>
                    <legend id ="sublegend">Asetustiedoston lisäys</legend> 
                  
                        <label for  ="new_vendorname" class="label">Laskuttaja:</label>
                        <input type ="text" id="new_vendorname" name="new_vendorname" class="txtBox"
                            placeholder="Laskun lähettäjä">                                                                
                                                   
                        <br>  
                        
                        <label for  ="new_accountnumber" class="label">Tilinumero:</label>
                        <input type ="text" id="new_accountnumber" name="new_accountnumber" class="txtBox"                            
                            placeholder="IBAN tilinro" maxlength="18" minlength=18                            
                            pattern="^[a-zA-Z0-9]*$" >

                        <label for  ="button-clear" class="label"></label>
                        <input type="button" id="button-clear" onclick="resetForm()"  class="btn-submit" value="Tyhjennä">
                

                    </fieldset>
                    <br>
                    <br>
    
                    <div class="container" id ="container">
                    <table class="gridtable" id="settingsTable" name="settingsTable">
                        <thead>
                            <tr class="tableheader">      
                                <th>Parametri</th>
                                <th>Laskuttajan nimi</th> 
                                <th>Laskuttajan tilinumero</th> 
                                <th></th>                                 
                            </tr>
                        <thead>

                        <tbody>

                        <?php                           

                            include 'uploadSettings.php';
                                                   
                            if(!empty(isset($_POST["upload-settings"]))) {

                              if ($responseSettings["type"] == "success") {
                            
                                if (file_exists ( $_FILES["file-input-settings"]["tmp_name"] )) {
                                    if (($fps = fopen($_FILES["file-input-settings"]["tmp_name"], "r")) !== FALSE) {
                                   
                                        $ind = 0;
                                       // while (($row = fgetcsv($fps)) !== false) {    
                                        while (($row = fgetcsv($fps, $csvSize, $csvDelimiter)) !== false) {                      
                                        ?>
                                            <tr name="datarow" class="datarow">                                            
                                                <td>                    
                                                    <?php echo $row[0]; ?>                   
                                                </td>
                                                <td>
                                                   
                                                    <input type="text" name="vendorname[]" class="textinput" readonly value="<?php echo $row[1]; ?>"     
                                                                 
                                                </td>
                                                <td>
                                                    <input type="text" name="accountnumber[]" class="textinput"
                                                    maxlength="18" minlength=18 required pattern="^[a-zA-Z0-9]*$"
                                                    readonly
                                                    value="<?php echo $row[2]; ?>"     
                                                                
                                                </td>
                                                <td> 
                                                    <input type="button" value="Poista" onclick="deleteRow(this)">                                      
                                                </td>                                
                                            </tr>
                            <?php
                                            $ind = $ind + 1;
                                        }  
                                        fclose($fps);                            
                                    }
                                } 
                              }                         
                            }
                        ?>

                        </tbody>
                    </table>
                    <br>
                  
                    </div>
                   
                    <?php if(!empty($responseSettings)) { ?>
                        <div id="responseSettings"class="response <?php echo $responseSettings["type"]; ?>
                            ">
                            <?php echo $responseSettings["message"]; ?>
                        </div>            
                    <?php }?> 

                    <br>  <br>
                    <input type="submit" class="btn-submit" id="btn-save" name="btn-save"
                    value="Tallenna" onclick="removeErrorMsg()"> 
                                        
                    <p id="message" name="message">                  
                        <?php                 
                            if(isset($_GET['Message'])){
                                echo $_GET['Message'];                                                                
                            }        
                        ?>
                    </p>                  
                   
                </fieldset>  
            </form>           
        </div> 

        <script>
            function deleteRow(r) {
                var i = r.parentNode.parentNode.rowIndex;
                document.getElementById("settingsTable").deleteRow(i);
            } 
            
            function resetForm() { 
                document.getElementById("new_vendorname").value = "";   
                document.getElementById("new_accountnumber").value = "";                           
                document.getElementById('message').innerHTML = "";                
            }
           
            function removeErrorMsg() {
                document.getElementById('message').innerHTML = ""; 
            }
                      
        </script>
    </body>
</html>
