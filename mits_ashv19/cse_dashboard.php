<head>
    <title>GoforEvent</title>
    <link rel="icon" href="../eventfavicon.png" size="16x16" type="image/png">
</head>
<?php
   require_once('./db/db.php');
      $sql = "select * from ashv_cse_events, ashv_cse_people where ashv_cse_events.people_email=ashv_cse_people.people_email";
      $db = new db();
      $conn = $db->connect();
      $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
      $stmt->execute(array());

  // $stmt = $conn->query($sql);
      $result = $stmt->fetchAll();
      $x = "people_id.people_name.people_email.people_roll.people_campusid.people_amount.people_mobile.people_branch.people_gender.people_college.people_date.people_txid.people_status.events_workshop.events_multi_workshop.events_paper.events_poster.events_project.events_larynx.events_dancewance.events_artsalad.events_theatre.events_haute.events_cricket.events_volleym.events_kabaddi.events_football.events_tennikoit.events_volleyw.events_accom";
     ?>
	 <body style="background-color:#2C3E50;color:white">
	 <h1 style="text-align:center;font-size:50px;margin-top:30px;font-family:arial"> Candidates List<h1>
	 <style>
	 table{
		 margin-left:10px;
		 margin-top:20px;
		 border-collapse:collapse;
	 }
	 table, th,td
	 {
		  border:1px solid black;
	 }
	 </style>
	 <table style="width:100%;">
	 <tr>
		<th>ASHVId</th>
		<th>Name</th>
		<th>Email</th>
		<th>Roll No</th>
		<th>Campus Amb. ID</th>
		<th>Amount</th>
		<th>Mobile</th>
		<th>Branch</th>
		<th>Gender</th>
		<th>College</th>
		<th>DateofRegistration</th>
		<th>TransactionId</th>
		<th>Status</th>

		<th>Workshop</th>
		<th>Drop Workshop</th>
		<th>Paper Presentation</th>
		<th>Poster Presentation</th>
		<th>Project Expo</th>

		<th>Larynx Warz</th>
		<th>Dance Wance</th>
		<th>Art Salad</th>
		<th>Theatre</th>
		<th>Haute Couture(Fashion)</th>

		<th>Cricket(Men)</th>
		<th>Volley ball(Men)</th>
		<th>Kabbadi(Men)</th>
		<th>Football(Men)</th>
		<th>Tennikoit(Men)</th>
		<th>Volleyball(Women)</th>
		<th>Accomodation</th>


	 </tr>
	 <?PHP
	  $arr1 = explode('.', $x);
	  	  for ($j=0;$j<count($result);$j++) {
			  ?><tr><?php
      for ($i = 0; $i < count($arr1); $i++) {
		  if ($i==0) {
			  ?>
			  <td style="text-align:center">ASHV2K19<?php echo $result[$j][$arr1[$i]];?></td>
			  <?php
		  }else {
			  ?>
		 <td style="text-align:center"><?php echo $result[$j][$arr1[$i]];?></td>
		<?php
		  }
      }
	  ?></tr><?php
		  }
	  ?>
	  </table>
	  
	  </body>
	  <?php

?>