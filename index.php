<html>
<?php
    include 'head.php';
?>

<body>
    <?php
        include 'navbar.php';
    ?>
    <div class="main">
      
    </div>
    <?php
        // define variables and set to empty values
        // $nameErr =  "";
        // $name =  "";
      //  include_once 'resetData.php';
    ?>
   
    <br>

    <!-- <h2>PHP Image Upload with Size Type Dimension Validation</h2> -->
    <form id="frm-upload" action="upload.php" name='indexform'
        method="post" enctype="multipart/form-data">

        <fieldset>
            <legend>Laskuttajan tiedot</legend>

            <label for  ="name" class="lbTitle">Laskun lähettäjä:</label>
            <input type ="text" id="name" name="name" class="txtBox" required> 
  
            <br>

            <label for  ="duedate" class="lbTitle">Eräpäivä:</label>
            <input type ="date"  id="duedate" name="duedate" class="txtBox" required><br>

            <label for  ="accountnumber" class="lbTitle">Tilinumero:</label>
            <input type ="text" id="accountnumber" name="accountnumber" class="txtBox" required><br>

            <label for  ="message" class="lbTitle">Laskun viesti:</label>
            <textarea id="message" name="message" rows="4" cols="54" required></textarea>
                 
            <br>
           
        </fieldset>
       
        <fieldset>
            <legend>Laskutettavat asiakkaat:</legend>
     
            <div>
                <input type="file" class="file-input" name="file-input">
                
                <input  type="submit" id="btn-submit" name="upload" value="Lataa tiedosto">
            </div>
           

           
        </fieldset>

        <!-- <div class="button-row">
            <input type="submit" id="btn-submit" name="upload"
                value="Lataa tiedosto">
        </div> -->
    </form>

    <?php if(!empty($response)) { ?>
    <div class="response <?php echo $response["type"]; ?>">    
        <?php echo $response["message"]; ?>
    </div>
    <?php }?>


    <?php
           if(isset($_GET['Message'])){
            echo $_GET['Message'];
        }       
     ?> 

<footer>
  <p>Footer</p>
</footer>

</body>
</html>

