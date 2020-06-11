<!DOCTYPE html>
<!--

-->

<html>
    <head>
          
        <title>Sports</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">    

        <link rel="stylesheet" href="styles.css">
    
    </head>
    <body>

        <br>
     
        <form> 

            <fieldset>
                <legend>Virhe tietojen käsittelyssä</legend>
                
                <?php 
                  //  echo "session status: " . session_status(); //todo:

                   if(isset($_GET['Message'])){
                        echo $_GET['Message'];
                    }        
                ?>
           </fieldset>
           
           <br>
 
           <p><a href="users\login.php">Login</a></p>

          
       </form>
      
    </body>

 
</html>

<?php