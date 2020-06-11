<html>
<?php
    include 'head.php';
?>
<body class="bodyWide">
    <div class="main">
        <?php
            include 'navbar.php';
        ?>
    </div>
    <br>


<?php
    $name          = trim(strip_tags( $_POST['name']));
    $duedate       = trim(strip_tags( $_POST['duedate']));
    $accountnumber = trim(strip_tags( $_POST['accountnumber']));
    $message       = trim(strip_tags( $_POST['message']));   
?>
  
    <label for  ="name" class="lbTitleBlock">Laskun lähettäjä:</label>
    <input type ="text" id="name" name="name" class="txtBoxBlock" required value="<?php echo $name;?>">
   
    <label for  ="duedate" class="lbTitleBlock">Eräpäivä:</label>
    <input type ="date" id="duedate" name="duedate" class="txtBoxBlock" required value="<?php echo $duedate;?>">
      
    <label for  ="accountnumber" class="lbTitleBlock">Tilinumero:</label>
    <input type ="test" id="accountnumber" name="accountnumber" class="txtBoxBlock" required value="<?php echo $accountnumber;?>">
       
    <label for  ="message" class="lbTitleBlock">Laskun viesti:</label>  
    <textarea id="message" name="message" rows="2" cols="40"><?php echo $message;?></textarea>

<?php


    if(!empty(isset($_POST["upload"]))) {
        if (($fp = fopen($_FILES["file-input"]["tmp_name"], "r")) !== FALSE) {
?>
<table class="tutorial-table" width="100%" border="1" cellspacing="0">
<?php
    $i = 0;
    while (($row = fgetcsv($fp)) !== false) {
        $class ="";
        if($i==0) {
           $class = "header";
        }
        ?>
    <tr>
            <td class="<?php echo $class; ?>"><?php echo $row[0]; ?></td>
            <td class="<?php echo $class; ?>"><?php echo $row[1]; ?></td>
            <td class="<?php echo $class; ?>"><?php echo $row[2]; ?></td>
            <td class="<?php echo $class; ?>"><?php echo $row[3]; ?></td>
            <td class="<?php echo $class; ?>"><?php echo $row[4]; ?></td>
            <td class="<?php echo $class; ?>"><?php echo $row[5]; ?></td>
        </tr>
    <?php
        $i ++;
    }
    fclose($fp);
    ?>
    </table>
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


</body>
</html>