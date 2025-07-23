<?php
// send email
$headers = "MIME-Version: 1.0\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\n";
$headers .= "From: QnE - Online Grocery<cs@qne.com.pk>\n";
$headers .= "X-Mailer: PHP's mail() Function\n";
$subject = "Job Application - Do Not Reply";

$bodyNew = "
<style>
td{border : 1px solid gray;}
th{border : 1px solid gray;}

</style>
Mr. Kashan Khalid has applied for job
<br>
<b>Regards,<br>
<i>Employee Self Service (ESS)</i><br>
Nagaria Textile Mills Limited<br>
</b>
<img src='https://ntmess.com/assets/ngt1.png'><br>
Address: HT/2, Landhi Industrial Area, Karachi, Pakistan. <br>
Website: www.nagariatextiles.com<br>";


    require 'sendgrid/vendor/autoload.php';

    $email = new \SendGrid\Mail\Mail();

    $email->setFrom("kashan@nagariatextiles.com", "Nagaria Textiles");
    $email->setSubject($subject);

    $email->addTo('rizwan@nagariatextiles.com', "Job Applicant");
    $email->addContent("text/plain", $bodyNew);
    $email->addContent("text/html", $bodyNew);
    $sendgrid = new \SendGrid('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');
    try
    {
        $response = $sendgrid->send($email);
        if($response){
           print_r($response);
        }
        
    }
    catch(Exception $e)
    {
        echo 'Caught exception: ' . $e->getMessage() . "\n";
    }
?>
