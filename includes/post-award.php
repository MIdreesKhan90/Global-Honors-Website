<?php
error_reporting(E_ALL ^ E_NOTICE);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

function valid_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'submit') {

    $store_in_database = valid_input($_REQUEST["agreeToDatabase"]);
    $award_name = valid_input($_REQUEST["awardName"]);
    $award_url = valid_input($_REQUEST["awardUrl"]);
    $agree_advertising = valid_input($_REQUEST["agreeAdvertising"]);
    $agree_other_interest = valid_input($_REQUEST["agreeOtherInterest"]);
    $other_interest = valid_input($_REQUEST["otherInterest"]);
    $company = valid_input($_REQUEST["company"]);
    $first_name = valid_input($_REQUEST["firstName"]);
    $last_name = valid_input($_REQUEST["lastName"]);
    $email = valid_input($_REQUEST["email"]);
    $phone = valid_input($_REQUEST["phone"]);
    $award_sponsor = valid_input($_REQUEST["awardSponsor"]);

    $full_name = $first_name . " " . $last_name;

    $to = 'admin@globalhonors.biz';
    $subject = 'Contact Form Submission';

    $name_from = 'Global Honors';
    $email_from = 'no-reply@globalhonors.biz';
    // Email Send
    try {
        //Server settings
        $mail->SMTPDebug = 0;
        $mail->isSMTP();

        $mail->Host = 'smtp.postmarkapp.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'PM-T-outbound-J4pS62TqijcPVCT430Xq4t';
        $mail->Password = 'ohJ2393m8L-AQXIvcml7SD6oz2DoQzgjbuLS';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 2525;

        //Recipients
        $mail->setFrom($email_from, $name_from);
        $mail->addAddress($to);
        $mail->addReplyTo('no-reply@globalhonors.biz', 'Global Honors');

        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = $subject;

        ob_start();
        ?>
        Hi!
        <p><?php echo ucfirst($full_name); ?> has sent you a message via Award Form Submission!</p>
        <br/>
        Company: <?php echo $email; ?><br/>
        Phone: <?php echo $phone; ?><br/>
        Company: <?php echo $company; ?><br/>
        I have an award that I would like included in the database: <?php echo $store_in_database; ?><br/>
        <?php if ($store_in_database == 'on') { ?>
            Award Name: <?php echo $award_name; ?><br/>
            Award Url: <?php echo $award_url; ?><br/>
        <?php } ?>
        I confirm I am an award sponsor: <?php echo $award_sponsor; ?>
        I am interested in advertising and sponsorship opportunities: <?php echo $agree_advertising; ?><br/>
        Other: <?php echo $agree_other_interest; ?><br/>
        <?php if ($agree_other_interest == 'on') { ?>
            Other Specification: <?php echo $other_interest; ?><br/>
        <?php } ?>
        <br/>
        ============================================================
        <?php
        $body = ob_get_contents();
        ob_end_clean();

        $mail->Body = $body;

        $mail->send();

        $output = json_encode(array('type' => 'success', 'text' => 'Thanks for your Email'));
        die($output);
    } catch (Exception $e) {
        $output = json_encode(array('type' => 'danger', 'text' => 'Something going wrong with sending mail...'));
        die($output);
    }
} else {
    $output = json_encode(array('type' => 'danger', 'text' => 'You can not access it directly!'));
    die($output);
}
