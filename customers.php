<?php
    header('Content-Type: text/html; charset=UTF-8');
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
 
<?php

    if(!empty(isset($_POST["upload"]))) {
        if (($fp = fopen($_FILES["file-input"]["tmp_name"], "r")) !== FALSE) {
?>

<!-- <br> -->

<form action="price.php" method="post">

    <fieldset>
        <div>

        <legend>3. Laskujen muodostus: hinta- ja lisäviestin syöttö tarvittaessa</legend>      

        <br> 

        <input type="submit" class="btn-submit" id="btn-billing" name="btn-billing" 
            value="Muodosta laskut">

        <br>
        <br>

        <div class="container" id ="container">
        <table class="gridtable" id="tableMain">
            <thead>
                <tr class="tableheader">      
                    <th>Sukunimi</th>
                    <th>Etunimi</th> 
                    <th>Osoite</th>
                    <th>Postinumero</th>
                    <th>Postitoimipaikka</th>
                    <th>Sähköpostiosoite</th>      
                    <th>Hinta €</th>
                    <th>Lisäviesti laskulle</th>    
                </tr>
            <thead>
            <tbody>
        <?php
            $i = 0;
            while (($row = fgetcsv($fp)) !== false) {

                $class ="";
                if($i==0) {
                $class = "header";
                }
                ?>

                <!-- <tr class="datarow"> -->
                <tr class="datarow" onclick="getSelectedRow(this)">
                            
                    <td><?php echo $row[1]; ?></td>
                    <td><?php echo $row[0]; ?></td>
                    <td><?php echo $row[2]; ?></td>
                    <td><?php echo $row[3]; ?></td>
                    <td><?php echo $row[4]; ?></td>
                    <td><?php echo $row[5]; ?></td>
                    
                    <td> 
                        <input type="number" step="any" id="price" name="price">
                    </td>

                    <td> 
                        <textarea  name="usermessage" class="textareagrid"></textarea>
                    </td>
                </tr>
            <?php
                $i ++;
            }
        
            fclose($fp);
            ?>
            </tbody>
            </table>
        </div>

        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>  -->

        <!-- <script>
        $(document).ready(function ()) {
            // click on
            $("#tableMain tbody tr").click(function () {
        
                var tabledata = $this.children("td").map(function() {
                return $(this).text(); 
                }).get;

                alert("jep");
                var td=tableData[0];
                alert (td);
            });
        });
        </script>  -->

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
        </div>
        </fieldset>
</form>

<script>
   function getSelectedRow(x) { 
       // console.log("jep");
     //  alert("Row index is: " + x.rowIndex);
       document.getElementById("ind").innerHTML = x.rowIndex;
    //    return x.rowIndex;
   }
</script>

</div>
</body>
</html>