<html>
<?php
    include 'head.php';
?>

<body>
    <div class="main">
        <?php
            include 'navbar.php';
        ?>
    </div>
    <br>

    <!-- <h2>PHP Image Upload with Size Type Dimension Validation</h2> -->
    <form id="frm-upload" action="upload.php" name='indexform'
        method="post" enctype="multipart/form-data">

        <fieldset>
            <legend>Laskuttajan tiedot</legend>

            <label for  ="name" class="lbTitle">Laskun lähettäjä:</label>
            <input type ="text" id="name" name="name" class="txtBox" required><br><br>

            <label for  ="duedate" class="lbTitle">Eräpäivä:</label>
            <input type ="date"  id="duedate" name="duedate" class="txtBox" required><br><br>

            <label for  ="accountnumber" class="lbTitle">Tilinumero:</label>
            <input type ="text" id="accountnumber" name="accountnumber" class="txtBox" required><br><br>

            <label for  ="message" class="lbTitle">Laskun viesti:</label>
            <textarea id="message" name="message" rows="4" cols="54" required></textarea>
                 
            <br>
            <!--                
            <label for  ="button" class="lbTitle"></label>
            <input type="submit" name="button" id="btn-submit" value="Tallenna"> 
            -->
        </fieldset>
       
        <div class="form-row">
            <div>Laskutettavat asiakkaat:</div>
            <div>
                <input type="file" class="file-input" name="file-input">
            </div>
        </div>

        <div class="button-row">
            <input type="submit" id="btn-submit" name="upload"
                value="Upload">
        </div>
    </form>

    <?php if(!empty($response)) { ?>
    <div class="response <?php echo $response["type"]; ?>">    
        <?php echo $response["message"]; ?>
    </div>
    <?php }?>


    <!-- <?php
      //  include 'upload.php';
     ?> -->

<footer>
  <p>Footer</p>
</footer>

</body>
</html>

