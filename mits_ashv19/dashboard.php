<head>
    <title>GoforEvent</title>
    <link rel="icon" href="../eventfavicon.png" size="16x16" type="image/png">
</head>
<?php
   require_once('./db/db.php');
   if((isset($_POST['submit']))){
	   $email=$_POST['email'];
      $sql = "select * from ashv_cse_events where people_email=:people_email";
      $db = new db();
      $conn = $db->connect();
      $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
      $stmt->execute(array(':people_email' => $email));

  // $stmt = $conn->query($sql);
      $result = $stmt->fetchAll();
	  if (count($result) == 0)
	  {
      ?>
	 <body style="background-color:#2C3E50;color:white">
	 <style>
	 h1{
		 text-align:center;
		 margin-top:200px;
	 }
	 </style>
	 <h1> You Have Not been Registered For any EventsYet<br/>
	 If you Have Registered Check Your Email Once.<br/>
	 If Not Go to the Event Registration Page.
	 </h1>
	 <br><br><br>
	  <div >
	  <span style="margin-left:300px;"><a href="https://www.ashvtheraceoftalent.com"><button style="border-radius:20px;padding:10px;background-color:#CA2D4F;border-color:#CA2D4F;color:white"><b>ASHV2K19</b></button></a></span>
	  <span style="margin-left:200px;"><a href="login/index.html"><button style="border-radius:20px;padding:10px;background-color:#CA2D4F;border-color:#CA2D4F;color:white"><b>Back To Login Page</b></button></a></span>
	  <span style="margin-left:200px;"><a href="http://www.goforevent.com/mits_ashv19/"><button style="border-radius:20px;padding:10px;background-color:#CA2D4F;border-color:#CA2D4F;color:white"><b>Register More Events Here</b></button></a></span>
	  </div>
</body>	 
	  <?Php
	  }
	  else
	  {
      $x = "events_workshop.events_multi_workshop.events_paper.events_poster.events_project.events_larynx.events_dancewance.events_artsalad.events_theatre.events_haute.events_cricket.events_volleym.events_kabaddi.events_football.events_tennikoit.events_volleyw.events_accom";
        $y = "Workshop.Workshop.Paper Presentation.Poster Presentation.Project Expo.Larynx Warz.Dance Wance.Pic O Rama.Theatre.Haute Couture(Fashion).Cricket(Men).Volley ball(Men).Kabbadi(Men).Football(Men).Tennikoit(Men).Volleyball(Women).Accomodation";
     ?>
	 <body style="background-color:#2C3E50;color:white">
	 <h1 style="text-align:center;font-size:50px;margin-top:30px;font-family:arial"> Your registered Events<h1>
	 <style>
	 th{text-align:left;font-size:30px;}
	 td{font-size:25px;}
	 table{
		 margin-left:30%;
		 margin-top:70px;
	 }
	 </style>
	 <table style="width:50%;">
	 <tr >
		<th>Event</th>
		<th>No.of registrations</th>
	 </tr>
	 <?PHP
	  $arr1 = explode('.', $x);
	  	  $arr2 = explode('.', $y);
      for ($i = 0; $i < 17; $i++) {
		  ?>
		  <tr>
		 <td><?php echo $arr2[$i];?></td><td style="text-align:center"><?php echo $result[0][$arr1[$i]];?></td>
		 </tr>
		<?php
      }
	  ?>
	  </table>
	  <div >
			
	  <span style="margin-left:300px;"><a href="https://www.ashvtheraceoftalent.com"><button style="border-radius:20px;padding:10px;background-color:#CA2D4F;border-color:#CA2D4F;color:white"><b>ASHV2K19</b></button></a></span>
		<span style="margin-left:500px;"><a href="http://www.goforevent.com/mits_ashv19/"><button style="border-radius:20px;padding:10px;background-color:#CA2D4F;border-color:#CA2D4F;color:white"><b>Register More Events Here</b></button></a></span>
		<div style="margin-left:600px;">
<img src='http://www.goforevent.com/qrget.php?email=<?php echo $email?>' width='150' height='150'>
</div>
		<span style="margin-left:500px;font-size:20px;"><a href='http://www.goforevent.com/qrget.php?email=<?php echo $email?>' download='goforevent.jpg'>Please download the QRCode using this link.</a></span>
	  </div>
	  </body>
	  <?php
	  }
   }
   else
   {
	   header("Location:login/index.html");
   }
?>