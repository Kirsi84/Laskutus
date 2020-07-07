<?php
    require('updateSettings.php'); 
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
      
        <form class="form-create" action="create.php" method="post">

        <div>
        
            <fieldset class="fieldset-create">            

                <legend>Asetustietojen lisäys</legend>   

                <label for  ="type" class="label">Asetus:</label>
                <input type ="text" id="type" name="type" class="txtBox-read"  
                    value="LASKUTTAJA" readonly required>
               
                <!-- <select id="type"  name="type" required>
                      <option value="LASKUTTAJA">LASKUTTAJA</option>                                            
                </select>  -->

                <br><br>    

                <label for  ="vendorname" class="label">Nimi:</label>
                <input type ="text" id="vendorname" name="vendorname" class="txtBox" placeholder="Laskun lähettäjä" required>

                <br><br> 

                <label for  ="accountnumber" class="label">Tilinumero:</label>
                <input type ="text" id="accountnumber" name="accountnumber" class="txtBox" placeholder="IBAN tilinro" maxlength="18" required>
               
                <br> <br>  

                <label for  ="create" class="label"></label>
                <input type="submit" name="create"  id="create"  class="btn-submit" value="Tallenna">
                <input type="reset"  class="btn-submit" value="Tyhjennä" onclick="resetForm()">
                
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

       <script>
            function resetForm() {        
                document.getElementById('msg').innerHTML = "";  
            }
        </script>
    </div>
      
    </body>
 
</html>

