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


<?php
    $name          = trim(strip_tags( $_POST['name']));
    $duedate       = trim(strip_tags( $_POST['duedate']));
    $accountnumber = trim(strip_tags( $_POST['accountnumber']));
    $message       = trim(strip_tags( $_POST['message']));  
   
    require_once "referenceNumber.php";
    $lasku = rand();  
    // echo "laskurand: " . $lasku;
    $suomiviite = SuomalainenViite::luo($lasku);
   // echo "Suomi: {$suomiviite}\n";
      
?>
<!-- <div class="sidebyside"> -->
    <div>

    <fieldset class="sidebyside">
        <label for  ="name" class="lbTitle">Laskun lähettäjä:</label>
        <input type ="text" id="name" name="name" class="txtBox" required value="<?php echo $name;?>">
    
        <label for  ="duedate" class="lbTitle">Eräpäivä:</label>
        <input type ="date" id="duedate" name="duedate" class="txtBox" required value="<?php echo $duedate;?>">
        
        <label for  ="accountnumber" class="lbTitle">Tilinumero:</label>
        <input type ="text" id="accountnumber" name="accountnumber" class="txtBox" required value="<?php echo $accountnumber;?>">

        <label for  ="refnumber" class="lbTitle">Viitenumero:</label>
        <input type ="text" id="refnumber" name="refnumber" class="txtBox" required value="<?php echo $suomiviite;?>">
    </fieldset>

    <fieldset class="sidebyside">
        <label for  ="message" class="lbTitle">Laskun viesti:</label>  
        <textarea id="message" name="message" rows="2" cols="40"><?php echo $message;?></textarea>
    </fieldset>
</div>
<?php


    if(!empty(isset($_POST["upload"]))) {
        if (($fp = fopen($_FILES["file-input"]["tmp_name"], "r")) !== FALSE) {
?>
<table class="tutorial-table" width="100%" border="1" cellspacing="0">
<tr class="titlerow">
        <th>Sukunimi</th>
        <th>Etunimi</th> 
        <th>Osoite</th>
        <th>Postinumero</th>
        <th>Postitoimipaikka</th>
        <th>Sähköpostiosoite</th>
        <th>Hinta €</th>
        <th>Viesti</th>
    </tr>
<?php
    $i = 0;
    while (($row = fgetcsv($fp)) !== false) {

        $class ="";
        if($i==0) {
           $class = "header";
        }
        ?>
    <tr>
            <td class="<?php echo $class; ?>"><?php echo $row[1]; ?></td>
            <td class="<?php echo $class; ?>"><?php echo $row[0]; ?></td>
            <td class="<?php echo $class; ?>"><?php echo $row[2]; ?></td>
            <td class="<?php echo $class; ?>"><?php echo $row[3]; ?></td>
            <td class="<?php echo $class; ?>"><?php echo $row[4]; ?></td>
            <td class="<?php echo $class; ?>"><?php echo $row[5]; ?></td>
            <td class="<?php echo $class; ?>"></td>
            <td class="<?php echo $class; ?>"></td>
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