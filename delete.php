<?php
    require 'updateSettings.php'; 
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
      
        <form class="form-delete" action="delete.php" method="post">

        <div>
        
            <fieldset>            

                <legend>Haluatko poistaa tiedon?</legend> 

                <?php   
                    $ind = -1;                                          
                    if(isset($_GET['ind'])) {
                        $ind = $_GET['ind'];  
                    }
                    $settings = getSetting($ind);
                    if (count($settings) > 0) {
                        foreach ($settings as $row) {                               
                ?>         

                <label for  ="type" class="label">Asetus:</label>
                <input type ="text" id="type" name="type" class="txtBox-read" readonly 
                    value="<?php echo $row[0]; ?>">               
               
                <br><br>    

                <label for  ="vendorname" class="label">Nimi:</label>
                <input type ="text" id="vendorname" name="vendorname" class="txtBox" readonly
                    value="<?php echo $row[1]; ?>">

                <br><br> 

                <label for  ="accountnumber" class="label">Tilinumero:</label>
                <input type ="text" id="accountnumber" name="accountnumber" class="txtBox" readonly
                    value="<?php echo $row[2]; ?>">               
                   
                <br> <br>  

                <?php    
                            $ind = $ind + 1;                            
                        }
                    }
                ?>

                <label for  ="delete" class="label"></label>
                <input type="submit" name="delete"  id="delete"  class="btn-submit" value="Poista">
                             
                <br><br>

                <div id ="msg">
                <?php    
                    if(isset($_POST['delete'])) // button name
                    {      
                        echo deleteSetting();
                    }
                ?>
                </div>
                <br>
            </fieldset>
            
            </div>
           
            <br>
            <div class="div-create">
                <p><a href="settings.php">Paluu</a></p>
            </div>
          
       </form>     
    </div>      
    </body> 
</html>

