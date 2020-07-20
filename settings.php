<?php

    // Start the session
    session_start();

    // file upload
    include 'updateSettings.php';

    function resetSession(){
        // remove all session variables
       session_unset();
    }  

    function resetFormData() {
        resetSession();
       
    }
   // include 'logWriting.php';

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

            <!-- <form id="frm-settings" action="delete.php" method="post"> -->
            <form id="frm-settings">
    
            <fieldset class="fieldset-create">      
                              
                <a href="create.php">Lisää</a>
                
                <legend>Asetustiedot - laskun lähettäjän vakiotiedot</legend>      
                <br> 
                <label for  ="filepath" >Asetustiedoston oletustiedostopolku työasemassa:</label>
                <br> <br>  
                <input type ="text" id="filepath" name="filepath" class="txtBox-read"  readonly
                    value="<?php echo getDefaultFilepath(); ?>">

                <br><br>
   
                <div class="container" id ="container">
                <table class="gridtable" id="settingsTable">
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
                        $ind = 0;              
                        $settings = getAllSettings();
                        if (count($settings) > 0) {
                            foreach ($settings as $row) {                               
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
                                    <td>  
                                        <?php
                                            echo "<a href=\"delete.php?ind=".$ind."\">Poista</a>";
                                        ?>                                       
                                    </td>
                            
                                </tr>
                    <?php    
                                $ind = $ind + 1;                            
                            }
                        }
                    ?>

                    </tbody>
                </table>
                </div>
            </fieldset>
            </form>   
        </div> 
    </body>
</html>
