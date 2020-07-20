<?php
    require('updateSettings.php'); 
?>

<!DOCTYPE html>

<html>
    <?php
        include 'head.php';
    ?>
    <body>
    <script>
          function hidePermission() {
             // document.getElementById("permission").style.display = "none";   
              document.getElementById("setCheckbox").style.display = "none";              
          };

          function showPermission() {
            //  document.getElementById("permission").style.display = "block"; 
              document.getElementById("setCheckbox").style.display = "block"; 
          };
      </script>
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

        <br><br>
      
        <form id="form-create" class="form-create" action="create.php" method="post">
                
            <fieldset>            

                <legend>Asetustietojen lisäys</legend>   

                <p id="setCheckbox">
                  <?php if (!file_exists(getDefaultPath())) { ?>
                      <label for="checkbox">Asetushakemiston luonti työasemaan <?php
                              echo "(" . getDefaultPath() . ")";?></label> 
                      <input type="checkbox" id="permission" name="permission" value="0" required>
                  <?php } ?>
                </p>

                
              
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
                

                <label for  ="create-button" class="label"></label>
                <input type="submit" name="create-button"  id="create-button"  class="btn-submit" value="Tallenna" />

                <br><br>

                <div id ="msg">
                <?php    
                    if(isset($_POST['create-button'])) // button name
                    {      
                        $infoarr = createSetting();
                        // if ($infoarr[0] == "error") {
                        //     echo "Virhe: ";
                        // }                        
                        // else {                                
                        //     echo "Ok: ";
                        // }
                        if (file_exists(getDefaultPath())) {                         
                          echo '<script>hidePermission();</script>';
                        }
                        else {
                          echo '<script>hidePermission();</script>';
                        }
                        echo $infoarr[1];
                    }
                ?>
                </div>
                <br>
            </fieldset>
                                 
            <br>
            <div class="div-create">
                <p><a href="settings.php">Paluu</a></p>
            </div>
          
       </form>

      </div>
      
    </body>
 
</html>

