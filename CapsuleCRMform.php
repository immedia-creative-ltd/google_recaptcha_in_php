<?php
/**
 * Plugin Name: CapusleCRMform
 * Plugin URI: https://www.immedia-creative.com/
 * Description: This form uses Google captcha to check it is being submitted by a human. If it is, the form contents is submitted to Capsule.
 * Version: 0.1
 * Author: Malcolm Kinross
 */
 
function CapusleCRMform($atts) {
	
$PERSON_NAME = $_POST['PERSON_NAME'];
$EMAIL = $_POST['EMAIL'];
$PHONE = $_POST['PHONE'];
$ORGANISATION_NAME = $_POST['ORGANISATION_NAME'];
$NOTE = $_POST['NOTE'];
$GDPR = $_POST['GDPR'];
?>

<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		//echo 'form submitted';
			if (!$PERSON_NAME) {
				echo '<script language="javascript">';
				echo 'alert("Please provide your name")';
				echo '</script>';
			}
			if (!$EMAIL) {
				echo '<script language="javascript">';
				echo 'alert("Please provide your email adress")';
				echo '</script>';
			}
			if (!$PHONE) {
				echo '<script language="javascript">';
				echo 'alert("Please provide your phone number")';
				echo '</script>';
			}
			if (!$ORGANISATION_NAME) {
				echo '<script language="javascript">';
				echo 'alert("Please provide your company name")';
				echo '</script>';
			}
			if (!$GDPR) {
				echo '<script language="javascript">';
				echo 'alert("Please agree that we can contact you")';
				echo '</script>';
			}
			if ($PERSON_NAME && $EMAIL && $PHONE && $ORGANISATION_NAME && $GDPR) {
				?>
					<script type="text/javascript">
					function formAutoSubmit () {
					var frm = document.getElementById("capsuleForm");
					frm.submit();
					}
					window.onload = formAutoSubmit;
					</script>
				<?php
			}
	} else {
		//echo 'not submitted';
	}

//echo "details";
//echo $PERSON_NAME;
//echo "<br />";
//echo $EMAIL;
//echo "<br />";
//echo $PHONE;
//echo "<br />";
//echo $ORGANISATION_NAME;
//echo "<br />";
//echo $NOTE;
//echo "<br />";
//echo $GDPR;

	
$site_key = '6LcpzLAUAAAAAFnCUqyow7YBmV30ed3RQ8qKZB4W';
$secret_key = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
 
if (isset($_POST['g-recaptcha-response'])) {
 
    //get verify response data
    $verifyCaptchaResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['g-recaptcha-response']);
    $responseCaptchaData = json_decode($verifyCaptchaResponse);
    if($responseCaptchaData->success) {
        //echo 'Captcha verified<br />';
        //proceed with form values
		?>
		<form method="post" id="capsuleForm" action="https://service.capsulecrm.com/service/newlead">
			<input type="hidden" name="FORM_ID" value="f59759f8-e6fb-4e8f-93ce-3212d18ff865">
			<input type="hidden" name="COMPLETE_URL" value="https://sounddampedsteel.com/thank-you/">
			<input type="hidden" name="TAG" value="web-to-lead">
			<input type="hidden" name="TAG" value="contact us">
			<input type="hidden" name="TAG" value="@@sound damped steel">
			<!--<input type="hidden" name="DEVELOPER" value="TRUE"/>-->

			<input type="hidden" name="PERSON_NAME" value="<?php echo $PERSON_NAME ?>" />
			<input type="hidden" name="EMAIL" value="<?php echo $EMAIL ?>" />
			<input type="hidden" name="PHONE" value="<?php echo $PHONE ?>" />
			<input type="hidden" name="ORGANISATION_NAME" value="<?php echo $ORGANISATION_NAME ?>" />
			<input type="hidden" name="NOTE" value="<?php echo $NOTE ?>" />
		</form>
<?php
    } else {
        //echo 'Verification failed';
    }
	//echo $verifyCaptchaResponse;
}

$mystring='
<div class="et_pb_contact">
<form class="et_pb_contact_form clearfix" action="" method="post" id="userForm">

<p class="et_pb_contact_field et_pb_contact_field_half">
<input type="text" name="PERSON_NAME" placeholder="Name" id="field1" value="'. $PERSON_NAME .'" required>
</p>
<p class="et_pb_contact_field et_pb_contact_field_half et_pb_contact_field_last">
<input type="text" name="EMAIL" placeholder="Email Address" value="'. $EMAIL .'" required>
</p>
<p class="et_pb_contact_field et_pb_contact_field_half">
<input type="text" name="PHONE" placeholder="Phone Number" value="'. $PHONE .'" required>
</p>
<p class="et_pb_contact_field et_pb_contact_field_half et_pb_contact_field_last">
<input type="text" name="ORGANISATION_NAME" placeholder="Company" value="'. $ORGANISATION_NAME .'" required>
</p>

<p class="et_pb_contact_field et_pb_contact_field_last">
<textarea cols="25" name="NOTE" rows="4" placeholder="Message">'. $NOTE .'</textarea>
</p>

<p class="et_pb_contact_field et_pb_contact_field_last">
<input class="gdpr-check" name="GDPR" type="checkbox" '.($GDPR == "on" ? 'checked="checked"': '').' required>Check to confirm that we can save your details and occasionally update you. We keep your information secure and will not share any of it with any other organisation without your explicit permission and you can unsubscribe at any time.
</p>

<div class="et_contact_bottom_container">
<button class="g-recaptcha btn btn-primary" data-sitekey="6LcpzLAUAAAAAFnCUqyow7YBmV30ed3RQ8qKZB4W" data-callback="submitForm">Submit</button>
</div>

</form>
</div>


<script src="https://www.google.com/recaptcha/api.js"></script>

<script>
function submitForm() {
    document.getElementById("userForm").submit();
}
</script>

	';
	
	$Content .= $mystring;
	 
    return $Content;
}

add_shortcode('CapusleCRMform-shortcode', 'CapusleCRMform');