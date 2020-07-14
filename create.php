<?php
    require('updateSettings.php'); 
?>

<!DOCTYPE html>

<html>
    <?php
        include 'head.php';
    ?>
    <body>

<?php
    // define variables and set to empty values
    $vendornameErr = $accountnumberErr = "";
    $vendorname = $accountnumber = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (empty($_POST["vendorname"])) {
        $vendornameErr = "Nimi on pakollinen tieto.";
      } else {
        $vendorname = test_input($_POST["vendorname"]);  
      }
      
      if (empty($_POST["accountnumber"])) {
        $accountnumberErr = "Tilinumero on pakollinen.";
      } else {
        $accountnumber = str_replace(' ', '', $accountnumber);
        $accountnumber = test_input($_POST["accountnumber"]);    
      }
    }

    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
?>

    <div class="main">
        <?php   
            include 'navbar.php';
        ?>  

        <br><br><br>
      
        <form id="form-create" class="form-create" action="create.php" method="post">
        <div>
        
            <fieldset>            

                <legend>Asetustietojen lisäys</legend>   

                <?php  if (!file_exists(getDefaultPath())) { ?>
                    <label for="checkbox">Asetushakemiston luonti työasemaan <?php
                            echo "(" . getDefaultPath() . ")";?></label> 
                    <input type="checkbox" id="permission" name="permission" value="0" required>
                <?php } ?>

                <br><br> 
              
                <label for  ="type" class="label">Asetus:</label>
                <input type ="text" id="type" name="type" class="txtBox-read"  
                    value="LASKUTTAJA" readonly required>
                              
                <br><br>    

                <label for  ="vendorname" class="label">Nimi:</label>
                <input type ="text" id="vendorname" name="vendorname" class="txtBox" placeholder="Laskun lähettäjä"
                required value="<?php echo $vendorname; ?>">

                <br><br> 

                <label for  ="accountnumber" class="label">Tilinumero:</label>
                <input type ="text" id="accountnumber" name="accountnumber" class="txtBox"
                placeholder="IBAN tilinro" maxlength="18" minlength="18" required              
                value="<?php echo $accountnumber;?>">
               
                <br> <br>  

                <label for  ="create" class="label"></label>
                <input type="submit" name="create"  id="create"  class="btn-submit" value="Tallenna" />

                <!-- <input type="reset"  class="btn-submit" value="Tyhjennä" onclick="resetForm()">
                 -->
                <br><br>

                <div id ="msg">
                <?php    
                    if(isset($_POST['create'])) // button name
                    {      
                        echo createSetting();
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

