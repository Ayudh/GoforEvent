<?php
$postdata = $_POST;
$msg = '';
$email='';
if (isset($postdata ['key'])) {
	$key = $postdata['key'];
	$salt				=   '8QcIRCig2E';
	$txnid 				= 	$postdata['txnid'];
  $amount      		= 	$postdata['amount'];
  $productInfo  		= 	$postdata['productinfo'];
  $info = explode("#", $productInfo);
	$firstname    		= 	$postdata['firstname'];
  $email        		=	$postdata['email'];
  $phone = $postdata['phone'];
	$udf5				=   $postdata['udf5'];
	$mihpayid			=	$postdata['mihpayid'];
	$status				= 	$postdata['status'];
	$resphash				= 	$postdata['hash'];
	//Calculate response hash to verify
	$keyString 	  		=  	$key.'|'.$txnid.'|'.$amount.'|'.$productInfo.'|'.$firstname.'|'.$email.'|||||'.$udf5.'|||||';
	$keyArray 	  		= 	explode("|",$keyString);
	$reverseKeyArray 	= 	array_reverse($keyArray);
	$reverseKeyString	=	implode("|",$reverseKeyArray);
	$CalcHashString 	= 	strtolower(hash('sha512', $salt.'|'.$status.'|'.$reverseKeyString));


	if ($status == 'success'  && $resphash == $CalcHashString) {
    $msg = "Transaction Successful and Hash Verified...";
    require_once('./db/db.php');
    $db = new db();
    $conn = $db->connect();

    $sql = "select * from ashv_cse_people where people_email=:people_email";
    $db = new db();
    $conn = $db->connect();
    $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $stmt->execute(array(':people_email' => $email));
    $result = $stmt->fetchAll();

		if (count($result) == 0) {
      
      $sql = "INSERT INTO `ashv_cse_people`( `people_name`, `people_email`, `people_mobile`, `people_branch`, `people_gender`, `people_college`, `people_date`, `people_txid`, `people_status`) VALUES (:people_name,:people_email, :people_mobile, :people_branch, :people_gender, :people_college, :people_date, :people_txid, :people_status)";

  try {
    $db = new db();
    $conn = $db->connect();
    $stmt = $conn->prepare($sql);
    $date = date("Y-m-d H:i:s");

    $stmt->bindParam(':people_name', $firstname);
    $stmt->bindParam(':people_email', $email);
    $stmt->bindParam(':people_mobile', $phone);
    $stmt->bindParam(':people_branch', $info[2]);
    $stmt->bindParam(':people_gender', $info[1]);
    $stmt->bindParam(':people_college', $info[0]);
    $stmt->bindParam(':people_date', $date);
    $stmt->bindParam(':people_txid', $txnid);
    $stmt->bindParam(':people_status', $status);

    $stmt->execute();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

  $sql = "INSERT INTO `ashv_cse_events`(`people_email`, `events_workshop`, `events_paper`, `events_poster`, `events_project`, `events_quiz`, `events_cricket`, `events_volleym`, `events_kabaddi`, `events_football`, `events_tennikoit`, `events_volleyw`, `events_flash`, `events_dance`, `events_treasure`, `events_slowbike`, `events_larynx`, `events_dancewance`, `events_picorama`, `events_theatre`, `events_haute`, `people_amount`) VALUES (:people_email, :events_workshop, :events_paper, :events_poster, :events_project, :events_quiz, :events_cricket, :events_volleym, :events_kabaddi, :events_football, :events_tennikoit, :events_volleyw, :events_flash, :events_dance, :events_treasure, :events_slowbike, :events_larynx, :events_dancewance, :events_picorama, :events_theatre, :events_haute, :people_amount)";

  try {

    $db = new db();
    $conn = $db->connect();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':people_email', $email);

    $stmt->bindParam(':events_workshop', $info[3]);
    $stmt->bindParam(':events_paper', $info[4]);
    $stmt->bindParam(':events_poster', $info[5]);
    $stmt->bindParam(':events_project', $info[6]);
    $stmt->bindParam(':events_quiz', $info[7]);
    $stmt->bindParam(':events_cricket', $info[8]);
    $stmt->bindParam(':events_volleym', $info[9]);
    $stmt->bindParam(':events_kabaddi', $info[10]);
    $stmt->bindParam(':events_football', $info[11]);
    $stmt->bindParam(':events_tennikoit', $info[12]);
    $stmt->bindParam(':events_volleyw', $info[13]);
    $stmt->bindParam(':events_flash', $info[14]);
    $stmt->bindParam(':events_dance', $info[15]);
    $stmt->bindParam(':events_treasure', $info[16]);
    $stmt->bindParam(':events_slowbike', $info[17]);
    $stmt->bindParam(':events_larynx', $info[18]);
    $stmt->bindParam(':events_dancewance', $info[19]);
    $stmt->bindParam(':events_picorama', $info[20]);
    $stmt->bindParam(':events_theatre', $info[21]);
    $stmt->bindParam(':events_haute', $info[22]);

    $finalamount = 0;
    $prices = [1200, 500, 350, 350, 300, 1500, 1300, 1300, 1000, 700, 1300, 2000, 300, 500, 300];
    for ($i=3; $i < 18; $i++) {
      $finalamount = $finalamount + $info[$i] * $prices[$i-3];
    }
    for ($i=18; $i < 23; $i++) {
      if ($info[$i] != 0) {
        if ($info[$i] == 1)
          $finalamount = $finalamount + 500;
        else
          $finalamount = $finalamount + 250 * $info[$i];
      }
    }

    $stmt->bindParam(':people_amount', $finalamount);
    $stmt->execute();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }    
    } else {
      
      $sql = "select * from ashv_cse_events where people_email=:people_email";
  $db = new db();
  $conn = $db->connect();
  $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
  $stmt->execute(array(':people_email' => $email));

  $result = $stmt->fetchAll();

  $x = "events_workshop.events_paper.events_poster.events_project.events_quiz.events_cricket.events_volleym.events_kabaddi.events_football.events_tennikoit.events_volleyw.events_flash.events_dance.events_treasure.events_slowbike.events_larynx.events_dancewance.events_picorama.events_theatre.events_haute";

  $arr1 = explode('.', $x);

  for ($i = 3; $i < 23; $i++) {
    $info[$i] = $info[$i] + $result[0][$arr1[$i-3]];
  }

  $finalamount = 0;
  $prices = [1200, 500, 350, 350, 300, 1500, 1300, 1300, 1000, 700, 1300, 2000, 300, 500, 300];
  for ($i=3; $i < 18; $i++) {
    $finalamount = $finalamount + $info[$i] * $prices[$i-3];
  }
  for ($i=18; $i < 23; $i++) {
    if ($info[$i] != 0) {
      if ($info[$i] == 1)
        $finalamount = $finalamount + 500;
      else
        $finalamount = $finalamount + 250 * $info[$i];
    }
  }

  $sql = "UPDATE `ashv_cse_events` SET `events_workshop`=:events_workshop,`events_paper`=:events_paper,`events_poster`=:events_poster,`events_project`=:events_project,`events_quiz`=:events_quiz,`events_cricket`=:events_cricket,`events_volleym`=:events_volleym,`events_kabaddi`=:events_kabaddi,`events_football`=:events_football,`events_tennikoit`=:events_tennikoit,`events_volleyw`=:events_volleyw,`events_flash`=:events_flash,`events_dance`=:events_dance,`events_treasure`=:events_treasure,`events_slowbike`=:events_slowbike,`events_larynx`=:events_larynx,`events_dancewance`=:events_dancewance,`events_picorama`=:events_picorama,`events_theatre`=:events_theatre,`events_haute`=:events_haute,`people_amount`=:people_amount WHERE `people_email`=:people_email";

  $db = new db();
  $conn = $db->connect();
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':people_email', $email);

  $stmt->bindParam(':events_workshop', $info[3]);
  $stmt->bindParam(':events_paper', $info[4]);
  $stmt->bindParam(':events_poster', $info[5]);
  $stmt->bindParam(':events_project', $info[6]);
  $stmt->bindParam(':events_quiz', $info[7]);
  $stmt->bindParam(':events_cricket', $info[8]);
  $stmt->bindParam(':events_volleym', $info[9]);
  $stmt->bindParam(':events_kabaddi', $info[10]);
  $stmt->bindParam(':events_football', $info[11]);
  $stmt->bindParam(':events_tennikoit', $info[12]);
  $stmt->bindParam(':events_volleyw', $info[13]);
  $stmt->bindParam(':events_flash', $info[14]);
  $stmt->bindParam(':events_dance', $info[15]);
  $stmt->bindParam(':events_treasure', $info[16]);
  $stmt->bindParam(':events_slowbike', $info[17]);
  $stmt->bindParam(':events_larynx', $info[18]);
  $stmt->bindParam(':events_dancewance', $info[19]);
  $stmt->bindParam(':events_picorama', $info[20]);
  $stmt->bindParam(':events_theatre', $info[21]);
  $stmt->bindParam(':events_haute', $info[22]);

  $stmt->bindParam(':people_amount', $finalamount);

  $stmt->execute();

    }

    $sql = "select * from ashv_cse_people where people_email=:people_email";
  $db = new db();
  $conn = $db->connect();
  $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
  $stmt->execute(array(':people_email' => $email));
  $result = $stmt->fetchAll();
  $id = $result[0]['people_id'];

  $content= " <div style='text-align:center;'>
  <h2>Thank you for registering through GoforEvent.  </h2><br/>
<div style='font-size:20px;'>
<span>Your Registered ASHVId is<b> ASHV2K19<span>".$id. "</b><br/>
Make sure that you produce this QRCode at the time of verification in PIXEL2K18.<br/>
</div><br/>
<div>
<img src='http://www.goforevent.com/qrget.php?email=$email' width='150' height='150'>
</div>
<a href='http://www.goforevent.com/qrget.php?email=$email' download='goforevent.jpg'>Please download the QRCode using this link.</a>
<p>You can also downlaod QRCode in your dashboard.</p>
<b style='font-size:20px;'>You can view your event details in PIXEL2K18 website dashboard.</b><br><br>
<a href='http://www.goforevent.com/mits_ashv19/login/'>
<button style='background-color:#FF5335;border-radius:10px;border-color:#FF5335;padding:10px 10px;font-size:15px;'><b>Your Dashboard</b></button></a><br><br>
<span style='font-size:20px'> To host your event or to view similar events visit:</span><br><br> <a href='http://www.goforevent.com'>
<button style='background-color:#FF5335;border-radius:10px;border-color:#FF5335;padding:10px 10px;font-size:15px;'><b>GoforEvent</b></button></a> 
</div>";
require_once '../vendor/autoload.php';

$subject = "GoforEvent: ASHV2K19 Registration Confirmation";
$gmailuser = "goforeventindia@gmail.com";
$gmailpwd = "Chenna@536";
$to = $email;
$transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
->setUsername($gmailuser)
->setPassword($gmailpwd);
$mailer = new Swift_Mailer($transport);
$message = (new Swift_Message($subject))
->setFrom([$gmailuser=>'GoforEvent'])
->setTo([$to=>'You'])
->setBody($content, "text/html");
$res = $mailer->send($message);
header("location:./thankyou.php");
	}
	else {
		//tampered or failed
    $msg = "Payment failed for Hasn not verified...";
    echo $msg;
	}
}
else exit(0);

?>