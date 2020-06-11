<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- <link href="css/style2.css" rel="stylesheet" type="text/css"> -->
<link href="css/styles.css" rel="stylesheet" type="text/css">
<script src="https://code.jquery.com/jquery-2.1.1.min.js"
    type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function (e){
$("#frmContact").on('submit',(function(e){
	e.preventDefault();
	$('#loader-icon').show();
	var valid;	
	valid = validateContact();
	if(valid) {
		$.ajax({
		url: "contact_mail.php",
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		success: function(data){
		$("#mail-status").html(data);
		$('#loader-icon').hide();
		},
		error: function(){} 	        
		
		});
	} else {
		$('#loader-icon').hide();
    }
}));

function validateContact() {
	var valid = true;	
	$(".demoInputBox").css('background-color','');
	$(".info").html('');
	
	if(!$("#userName").val()) {
		$("#userName-info").html("(required)");
		$("#userName").css('background-color','#FFFFDF');
		valid = false;
	}
	if(!$("#userEmail").val()) {
		$("#userEmail-info").html("(required)");
		$("#userEmail").css('background-color','#FFFFDF');
		valid = false;
	}
	if(!$("#userEmail").val().match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/)) {
		$("#userEmail-info").html("(invalid)");
		$("#userEmail").css('background-color','#FFFFDF');
		valid = false;
	}
	if(!$("#subject").val()) {
		$("#subject-info").html("(required)");
		$("#subject").css('background-color','#FFFFDF');
		valid = false;
	}
	if(!$("#content").val()) {
		$("#content-info").html("(required)");
		$("#content").css('background-color','#FFFFDF');
		valid = false;
	}
	
	return valid;
}

});
</script>
</head>
<body>

	<div class="main">
        <?php   
            // include 'menu_bar.php';
            include 'navbar.php';
        ?>
    </div>
	<br>
	
    <form id="frmContact" action="" method="post">
        <div id="mail-status"></div>
        <div class="contact-row column-right">
            <label style="padding-top: 20px;">Name</label> <span
                id="userName-info" class="info"></span><br /> <input
                type="text" name="userName" id="userName"
                class="demoInputBox">
        </div>
        <div class="contact-row column-right">
            <label>Email</label> <span id="userEmail-info" class="info"></span><br />
            <input type="text" name="userEmail" id="userEmail"
                class="demoInputBox">
        </div>
        <div class="contact-row">
            <label>Phone</label> <span id="subject-info" class="info"></span><br />
            <input type="text" name="subject" id="subject"
                class="demoInputBox">
        </div>
        <div>
            <label>Message</label> <span id="content-info" class="info"></span><br />
            <textarea name="content" id="content" class="demoInputBox"
                rows="3"></textarea>
        </div>
        <div>
            <input type="submit" value="Send" class="btnAction" />
        </div>
    </form>
    <div id="loader-icon" style="display: none;">
        <img src="LoaderIcon.gif" />
    </div>
</body>
</html>