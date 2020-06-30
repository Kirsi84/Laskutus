<?php
//  include("logWriting.php");
//require_once __DIR__ . '/vendor/autoload.php';

if(!isset($_POST)) {
    header('location:index.php');
    exit();
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();              
}
$customercount = 0;
if (isset($_SESSION['customercount']))  {     
    $customercount = $_SESSION['customercount'] ; 
}
if (isset($_SESSION['name']))  {     
    $vendor = $_SESSION['name'];
} 

$html = "";

try {
   
    $date = date("Ymd");
    $filename = "Laskut_" . $date . "_" . $vendor  . ".pdf";
    
    $path = (getenv('MPDF_ROOT')) ? getenv('MPDF_ROOT') : __DIR__;
    require_once $path . '/vendor/autoload.php';

    $mpdf = new \Mpdf\Mpdf([
        'margin_left' => 20,
        'margin_right' => 15,
        'margin_top' => 48,
        'margin_bottom' => 25,
        'margin_header' => 10,
        'margin_footer' => 10
    ]);
    
    $mpdf->SetProtection(array('print'));
    $mpdf->SetTitle("Laskut | " . $vendor);
    $mpdf->SetAuthor($vendor);
    $mpdf->SetWatermarkText("Lasku");
    $mpdf->showWatermarkText = true;
    $mpdf->watermark_font = 'DejaVuSansCondensed';
    $mpdf->watermarkTextAlpha = 0.1;
    $mpdf->SetDisplayMode('fullpage');   
  
    for ($i = 0; $i < $customercount; $i++) { 
        $html = gethtmldata($i);
        $mpdf->AddPage();
        $mpdf->WriteHTML($html);      
    } 
    $mpdf->AddPage();  
    $mpdf->SetWatermarkText("Laskutettu");
    $html = gethtmltotal($customercount); 
    $mpdf->WriteHTML($html);  
  
    //$mpdf->Output($filename, 'I');
    $mpdf->Output($filename, 'D');

}
catch(\Mpdf\MpdfException $e) {
    echo $e->getMessage();
}

function checkData($data) {
    return trim(strip_tags($data));
}

 
function gethtmldata($i) {
    $vendor         = "";
    $duedate       = "";
    $accountnumber  = "";
    $refnumber      = "";
    $message        = ""; 

    $lname = "";
    $fname = "";
    $address = "";
    $postcode = "";
    $postdistrict = "";
    $email = ""; 
    $price = 0;
    $usermessage = "";

    // vendor data
    if (isset($_SESSION['name']))  {     
        $vendor = checkData($_SESSION['name']);
    }    
    if (isset($_SESSION['duedate']))  {     
        $duedate = date("d.m.Y", strtotime($_SESSION['duedate']));
    }    
    if (isset($_SESSION['accountnumber']))  {     
        $accountnumber = checkData($_SESSION['accountnumber']) ; 
    }    
    if (isset($_SESSION['refnumber']))  {     
        $refnumber = checkData($_SESSION['refnumber']) ; 
    }
    if (isset($_SESSION['message']))  {     
        $message = checkData($_SESSION['message']) ; 
    }
    // customer data
    if (isset($_POST['lname'][$i]))  {     
        $lname = checkData($_POST['lname'][$i]);
    }
    if (isset($_POST['fname'][$i]))  {     
        $fname = checkData($_POST['fname'][$i]);
    }
    if (isset($_POST['address'][$i]))  {     
        $address = checkData($_POST['address'][$i]);
    }
    if (isset($_POST['postcode'][$i]))  {     
        $postcode = checkData($_POST['postcode'][$i]);
    }
    if (isset($_POST['postaldistrict'][$i]))  {     
        $postdistrict = checkData($_POST['postaldistrict'][$i]);
    }
    if (isset($_POST['email'][$i]))  {     
        $email = checkData($_POST['email'][$i]);
    }
    if (isset($_POST['price'][$i]))  {     
        $price =  (double) $_POST['price'][$i];
        $price =  number_format($price, 2, ',', '');
        $pricevar = strval($price);
    }
    // price is not given
    if ($price == 0) {
        $pricevar = "*****";           
    }
    if (isset($_POST['usermessage'][$i]))  {     
        $usermessage = checkData($_POST['usermessage'][$i]);
    }

    // generating number of invoice
    $invoiceno = strval($i + 1);
    $invoiceno = sprintf('%03d', $invoiceno);

    $date = date("d.m.Y");
      
    $html = '
<html>
<head>
    <link rel="stylesheet" href="css/pdfstyles.css">
</head>
<body>

<!--mpdf

<htmlpageheader name="myheader">
<table width="100%">
<tr>
    <td width="50%" style="color:#0000BB; ">
        <span style="font-weight: bold; font-size: 14pt;">' .$vendor . '</span>
        <br />
    </td>
    <td width="50%" style="text-align: right;">LASKU<br />
    <span style="font-weight: bold; font-size: 12pt;">' . $invoiceno . '</span>
    </td>
</tr>
</table>
</htmlpageheader>

<htmlpagefooter name="myfooter">
<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
Page {PAGENO} of {nb}
</div>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />

mpdf-->

<div class="pdfdiv" >Laskun päivä: ' . $date .'</div>

<table class="pdftable">

<tr>
    <td class="pdftd">
        <span class="pdfspan">'. $fname . ' ' . $lname .' </span>
        <br /><br />
        '. $address . '
        <br />'. $postcode . ' ' . $postdistrict .'
        
    </td>
    <td width="30%">&nbsp;</td>

    <td class="pdftd">
        
        <table>
            <tr>
                <td>Laskun lähettäjä:</td>
                <td>' . $vendor . '</td>          
            </tr>
            <tr>
                <td>Viite:</td>
                <td>' . $refnumber . '</td>          
            </tr>
            <tr>
                <td>Eräpäivä:</td>
                <td>' . $duedate . '</td>          
            </tr>
            <tr>
                <td>Tilinumero:</td>
                <td>' . $accountnumber . '</td>          
            </tr>        
        </table>
       
    </td>
   
</tr>
</table>
<br>

<table class="items" >
    <thead>
    <tr>    
        <td width="40%">Laskun viesti</td>
        <td width="40%">Lisätiedot</td>  
        <td width="20%">Hinta €</td>
    </tr>
    </thead>
    <tbody>

    <!-- ITEMS HERE -->
    <tr>
        <td class="pdftd2">
            <textarea class="pdftextarea">        
              '. $message .' 
            </textarea>
        </td>
        <td class="pdftd2">
            <textarea class="pdftextarea">        
                '. $usermessage . '
            </textarea>
        </td>
        <td class="cost">'. $pricevar .'</td>
    </tr>
    <!-- END ITEMS HERE -->

    </tbody>
</table>
</body>
</html>
<pagebreak/>';

    return $html;
}

function gethtmltotal($customercount) {
    $vendor         = "";
    $duedate       = "";
    $accountnumber  = "";
    $refnumber      = "";
    $message        = ""; 
     
    // vendor data
    if (isset($_SESSION['name']))  {     
        $vendor = $_SESSION['name'];
    }    
    if (isset($_SESSION['duedate']))  {     
        $duedate = date("d.m.Y", strtotime($_SESSION['duedate']));
    }    
    if (isset($_SESSION['accountnumber']))  {     
        $accountnumber = $_SESSION['accountnumber'] ; 
    }    
    if (isset($_SESSION['refnumber']))  {     
        $refnumber = $_SESSION['refnumber'] ; 
    }
    if (isset($_SESSION['message']))  {     
        $message = $_SESSION['message'] ; 
    }  

    // generating number of invoice
    $invoiceno = strval($i + 1);
    $invoiceno = sprintf('%03d', $invoiceno);

    $date = date("d.m.Y");

      
    $html = '
<html>
<head>
    <link rel="stylesheet" href="css/pdfstyles.css">
</head>
<body>

<!--mpdf

<htmlpageheader name="myheader">
<table width="100%">
<tr>
    <td width="50%" style="color:#0000BB; ">
        <span style="font-weight: bold; font-size: 14pt;">' .$vendor . '</span>
        <br />
    </td>
    <td width="50%" style="text-align: right;">YHTEENVETO<br />
    <span style="font-weight: bold; font-size: 12pt;">LASKUT</span>
    </td>
</tr>
</table>
</htmlpageheader>

<htmlpagefooter name="myfooter">
<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
Page {PAGENO} of {nb}
</div>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />

mpdf-->

<div class="pdfdivleft" >Laskun viesti:</div>
<div class="pdfdiv" >Laskun päivä: ' . $date .'</div>

<table class="pdftable">

<tr>
    <td class="pdftd">
        <textarea class="pdftextarea">        
            '. $message .' 
        </textarea>
    </td>
    <td width="30%">&nbsp;</td>

    <td class="pdftd">
        
        <table>
            <tr>
                <td>Laskun lähettäjä:</td>
                <td>' . $vendor . '</td>          
            </tr>
            <tr>
                <td>Viite:</td>
                <td>' . $refnumber . '</td>          
            </tr>
            <tr>
                <td>Eräpäivä:</td>
                <td>' . $duedate . '</td>          
            </tr>
            <tr>
                <td>Tilinumero:</td>
                <td>' . $accountnumber . '</td>          
            </tr>        
        </table>
       
    </td>
   
</tr>
</table>
<br>

<table class="items" >
    <thead>
    <tr>    
        <td width="30%">Sukunimi</td>
        <td width="30%">Etunimi</td>
        <td width="30%">Lisätiedot</td>    
        <td width="10%">Hinta €</td>
    </tr>
    </thead>

    <tbody>
         
        ';
                for($i = 0; $i < $customercount; $i++)
                {

                    $lname = "";
                    $fname = "";   
                    $price = 0;
                    $usermessage = "";            
                    
                    if (isset($_POST["lname"][$i]))  {     
                        $lname = checkData($_POST["lname"][$i]);
                    }
                    if (isset($_POST["fname"][$i]))  {     
                        $fname = checkData($_POST["fname"][$i]);
                    }           
                    
                    if (isset($_POST["price"][$i]))  {     
                        $price =  (double) $_POST["price"][$i];
                        $price =  number_format($price, 2, ",", "");
                        $pricevar = strval($price);
                    }
                    // price is not given
                    if ($price == 0) {
                        $pricevar = "*****";           
                    }
                    if (isset($_POST["usermessage"][$i]))  {     
                        $usermessage = checkData($_POST["usermessage"][$i]);
                    }  

                    $html .= '
                    <tr>
                    <td class="pdftd2">           
                        '. $lname .'            
                    </td>

                    <td class="pdftd2">                
                        '. $fname . '
                    </td>
        
                    <td class="pdftd2">
                        <textarea class="pdftextarea">        
                            '. $usermessage . '
                        </textarea>
                    </td>
        
                    <td class="cost">'. $pricevar .'</td>
                    </tr>
                    ' ;
                }

        $html .= '      
        
    </tr>

    </tbody>
</table>
</body>
</html>
<pagebreak/>';

    return $html;
}


?>