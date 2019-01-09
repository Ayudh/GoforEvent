<?php

if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') == 0){
  //Request hash
  $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
	if(strcasecmp($contentType, 'application/json') == 0){
    $data = json_decode(file_get_contents('php://input'));
    $data->key = 'lH3qHLzS';
    $data->salt = '8QcIRCig2E';

    $data->amount = 0;

    $events=explode('#',$data->pinfo);

    $productInfo = $data->pinfo;

    $prices = [1500, 1300, 1300, 1000, 700, 1300];
    for ($i=5; $i < 21; $i++) {
      if ($i <= 13) {
        if ($i == 5 && $events[$i] != 0) {
          $data->amount = $data->amount + 3000;
        } else {
          $data->amount = $data->amount + 400 * $events[$i];
        }
      } elseif ($i <= 19) {
        $data->amount = $data->amount + $events[$i] * $prices[$i-14];
      } else {
        $data->amount = $data->amount + $events[$i] * 150;
      }
    }

    if ($events[21] != 0) {
      $data->amount = $data->amount + 1300;
    }

    $data->amount = $data->amount * 1.03;
		$hash=hash('sha512', $data->key.'|'.$data->txnid.'|'.$data->amount.'|'.$data->pinfo.'|'.$data->fname.'|'.$data->email.'|||||'.$data->udf5.'||||||'.$data->salt);
		$json=array();
		$json['success'] = $hash;
		$json['amount'] = $data->amount;
    	echo json_encode($json);

	}
	exit(0);
}

function getCallbackUrl()
{
	$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	return $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . 'response.php';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>GoforEvent</title>
  <link rel="icon" href="../eventfavicon.png" size="16x16" type="image/png">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link rel="stylesheet" href="./css/index.css">
  <meta name="theme-color" content="#F44336" />

  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

  <!-- this meta viewport is required for BOLT //-->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" >
  <!-- BOLT Sandbox/test //-->
  <!-- <script id="bolt" src="https://sboxcheckout-static.citruspay.com/bolt/run/bolt.min.js" bolt-color="e34524" bolt-logo="http://boltiswatching.com/wp-content/uploads/2015/09/Bolt-Logo-e14421724859591.png"></script> -->
<!-- BOLT Production/Live // -->
<script id="bolt" src="https://checkout-static.citruspay.com/bolt/run/bolt.min.js" bolt-color="e34524" bolt-logo="http://boltiswatching.com/wp-content/uploads/2015/09/Bolt-Logo-e14421724859591.png"></script>
</head>

<body>

  <div class="navbar-fixed z-depth-3">
    <nav>
      <div class="nav-wrapper red">
        <a href="#" class="brand-logo">GoforEvent</a>
        <a href="#login-modal" class="modal-trigger hide-on-med-and-up"><i class="material-icons">menu</i></a>

        <ul id="user-profile" class="right hide-on-med-and-down">
          <li>
            <button data-target="login-modal" id="login-button" class="btn modal-trigger">Login</button>
          </li>
          <li>
            <div id="username">Username</div>
          </li>
          <li><a class="modal-trigger" href="#login-modal"><img id="profile-image" src="./images/profile_placeholder.png"
                class="responsive-img" /></a></li>
        </ul>
      </div>
    </nav>
    <!-- Modal Structure -->
    <div id="login-modal" class="modal">
      <div class="modal-content center">
        <div class="hide-on-med-and-up">
          <div id="m-username">Username</div>
          <img id="m-profile-image" src="./images/profile_placeholder.png" class="responsive-img" />
        </div>
        <a class="waves-effect waves-light btn" id="sign-in-button">Sign in with Google</a>
        <a class="waves-effect waves-light btn" id="sign-out-button">Logout</a>
      </div>
    </div>
  </div>

  <span><input type="hidden" id="txnid" name="txnid" placeholder="Transaction ID" value="<?php echo  "Txn" . rand(10000,99999999)?>" /></span>
  <span><input type="hidden" id="udf5" name="udf5" placeholder="Transaction ID" value="mits_ashv_2018_2" /></span>
  <input type="hidden" id="surl" name="surl" value="<?php echo getCallbackUrl(); ?>" />

  <main>
    <form id="complete-form" action="#" method="get" class="col s12">
    <div class="container">
    <h3 class="center">Ashv the race of talent</h3>
    <marquee>Participate to win prizes worth upto 5 Lakhs</marquee>
        <ul class="collapsible popout expandable z-depth-3">
          <li>
            <div class="collapsible-header"><i class="material-icons">details</i><span class="flow-text">Details</span></div>
            <div class="collapsible-body">

              <div class="row">
                <div class="input-field col m6">
                  <i class="material-icons prefix">account_circle</i>
                  <input id="name" name="name" type="text" required class="validate">
                  <label for="name">Your Name</label>
                </div>
                <div class="input-field col m6">
                  <i class="material-icons prefix">mail</i>
                  <input disabled id="email" type="text" class="validate" value="Login mail">
                  <label for="email">Email ID</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col m6">
                  <i class="material-icons prefix">code</i>
                  <input id="rollno" name="rollno" type="text" required class="validate">
                  <label for="rollno">Roll no.</label>
                </div>
                <div class="input-field col m6">
                  <i class="material-icons prefix">account_balance</i>
                  <input id="campusambasdor" type="text" class="validate" value="">
                  <label for="campusambasdor">Campus Ambasdor ID</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col m6">
                  <i class="material-icons prefix">phone</i>
                  <input id="mobile-number" name="mobile" type="number" class="validate" required>
                  <label for="mobile-number">Mobile</label>
                </div>
                <div class="input-field col m6">
                  <span>
                    <label>
                      <input class="with-gap" name="gender" type="radio" checked value="male" />
                      <span>Male</span>
                    </label>
                  </span>
                  <span>
                    <label>
                      <input class="with-gap" name="gender" type="radio" value="female" />
                      <span>Female</span>
                    </label>
                  </span>
                </div>

              </div>
              <div class="row">
                <div class="input-field col m6">
                  <i class="material-icons prefix">home</i>
                  <input id="college" type="text" name="college" class="validate" required>
                  <label for="college">College</label>
                </div>
                <div class="input-field col m6">
                  <i class="material-icons prefix">library_books</i>
                  <select name="course" id="course" required>
                    <option value="" disabled selected>--Select--</option>
                    <option value="cse">Computer science</option>
                    <option value="eee">Electrical and Electronics</option>
                    <option value="mech.">Mechanical </option>
                    <option value="ece">Electronics and Commucations</option>
                    <option value="civil">Civil</option>
                    <option value="others">Others</option>
                  </select>
                  <label>Course</label>
                </div>
              </div>

            </div>
          </li>
          <li>
            <div class="collapsible-header"><i class="material-icons">event_note</i><span class="flow-text">Events</span></div>
            <div class="collapsible-body">
              <div class="row valign-wrapper">
                <div class="col s6 left">
                  <span class="flow-text">Design Thinking Workshop</span>
                </div>
                <div class="col s6 center">
                  <span class="custom-blue inline-block-display white-text">
                    <button class="waves-effect waves-light btn custom-blue left" type="button" onclick="decrement(1)"><i class="material-icons">remove</i></button>
                    <span class="flow-text count-span center inline-block-display" id="mainevent-1">0</span>
                    <button class="waves-effect waves-light btn custom-blue right" type="button" onclick="increment(1)"><i class="material-icons">add</i></button>
                  </span>
                </div>
              </div>
              <!-- <div class="row valign-wrapper">
                <div class="input-field col m12">
                  <i class="material-icons prefix">library_books</i>
                  <select name="workshop" id="workshop" required onchange='updateAmount()'>
                    <option value="0" selected>None</option>
                    <option value="1">Quad copter</option>
                    <option value="2">3D Printer</option>
                    <option value="3">Mini Robot</option>
                    <option value="4">Ethical Hacking and Cyber Security</option>
                    <option value="5">Digital marketing and Web Design</option>
                    <option value="6">Augmented reality</option>
                  </select>
                  <label>Workshop</label>
                </div>
              </div> -->

              <div class="row valign-wrapper">
                <div class="col s6 m8 left">
                  <span class="flow-text">Workshop</span>
                </div>
                <div class="col s6 m4 center">
                  <select name="workshop" id="workshop" required onchange='updateAmount()'>
                    <option value="0" selected>None</option>
                    <option value="1">Quad copter</option>
                    <option value="2">3D Printer</option>
                    <option value="3">Mini Robot</option>
                    <option value="4">Ethical Hacking and Cyber Security</option>
                    <option value="5">Digital marketing and Web Design</option>
                    <option value="6">Augmented reality</option>
                  </select>
                </div>
              </div>


              <div class="row valign-wrapper">
                <div class="col s6 left">
                  <span class="flow-text">Paper Presentation (Max. 2 Persons)</span>
                </div>
                <div class="col s6 center">
                  <span class="custom-blue inline-block-display white-text">
                    <button class="waves-effect waves-light btn custom-blue left" type="button" onclick="decrement(2)"><i class="material-icons">remove</i></button>
                    <span class="flow-text count-span center inline-block-display" id="mainevent-2">0</span>
                    <button class="waves-effect waves-light btn custom-blue right" type="button" onclick="increment(2)"><i class="material-icons">add</i></button>
                  </span>
                </div>
              </div>
              <div class="row valign-wrapper">
                <div class="col s6 left">
                  <span class="flow-text">Poster Presentation (Max. 2 Persons)</span>
                </div>
                <div class="col s6 center">
                  <span class="custom-blue inline-block-display white-text">
                    <button class="waves-effect waves-light btn custom-blue left" type="button" onclick="decrement(3)"><i class="material-icons">remove</i></button>
                    <span class="flow-text count-span center inline-block-display" id="mainevent-3">0</span>
                    <button class="waves-effect waves-light btn custom-blue right" type="button" onclick="increment(3)"><i class="material-icons">add</i></button>
                  </span>
                </div>
              </div>
              <div class="row valign-wrapper">
                <div class="col s6 left">
                  <span class="flow-text">Project Expo (Max. 4 Persons)</span>
                </div>
                <div class="col s6 center">
                  <span class="custom-blue inline-block-display white-text">
                    <button class="waves-effect waves-light btn custom-blue left" type="button" onclick="decrement(4)"><i class="material-icons">remove</i></button>
                    <span class="flow-text count-span center inline-block-display" id="mainevent-4">0</span>
                    <button class="waves-effect waves-light btn custom-blue right" type="button" onclick="increment(4)"><i class="material-icons">add</i></button>
                  </span>
                </div>
              </div>
              <div class="row valign-wrapper">
                <div class="col s6 left">
                  <span class="flow-text">Larynx Warz (Max. 8 Persons)</span>
                </div>
                <div class="col s6 center">
                  <span class="custom-blue inline-block-display white-text">
                    <button class="waves-effect waves-light btn custom-blue left" type="button" onclick="decrement(5)"><i class="material-icons">remove</i></button>
                    <span class="flow-text count-span center inline-block-display" id="mainevent-5">0</span>
                    <button class="waves-effect waves-light btn custom-blue right" type="button" onclick="increment(5)"><i class="material-icons">add</i></button>
                  </span>
                </div>
              </div>
              <div class="row valign-wrapper">
                <div class="col s6 left">
                  <span class="flow-text">Dance Wance (Max. 8 Persons)</span>
                </div>
                <div class="col s6 center">
                  <span class="custom-blue inline-block-display white-text">
                    <button class="waves-effect waves-light btn custom-blue left" type="button" onclick="decrement(6)"><i class="material-icons">remove</i></button>
                    <span class="flow-text count-span center inline-block-display" id="mainevent-6">0</span>
                    <button class="waves-effect waves-light btn custom-blue right" type="button" onclick="increment(6)"><i class="material-icons">add</i></button>
                  </span>
                </div>
              </div>
              <div class="row valign-wrapper">
                <div class="col s6 left">
                  <span class="flow-text">Art Salad (Max. 2 Persons)</span>
                </div>
                <div class="col s6 center">
                  <span class="custom-blue inline-block-display white-text">
                    <button class="waves-effect waves-light btn custom-blue left" type="button" onclick="decrement(7)"><i class="material-icons">remove</i></button>
                    <span class="flow-text count-span center inline-block-display" id="mainevent-7">0</span>
                    <button class="waves-effect waves-light btn custom-blue right" type="button" onclick="increment(7)"><i class="material-icons">add</i></button>
                  </span>
                </div>
              </div>
              <div class="row valign-wrapper">
                <div class="col s6 left">
                  <span class="flow-text">Theatre (Max. 2 Persons)</span>
                </div>
                <div class="col s6 center">
                  <span class="custom-blue inline-block-display white-text">
                    <button class="waves-effect waves-light btn custom-blue left" type="button" onclick="decrement(8)"><i class="material-icons">remove</i></button>
                    <span class="flow-text count-span center inline-block-display" id="mainevent-8">0</span>
                    <button class="waves-effect waves-light btn custom-blue right" type="button" onclick="increment(8)"><i class="material-icons">add</i></button>
                  </span>
                </div>
              </div>
              <div class="row valign-wrapper">
                <div class="col s6 left">
                  <span class="flow-text">Haute Couture(Fashion) (Max. 4 Persons)</span>
                </div>
                <div class="col s6 center">
                  <span class="custom-blue inline-block-display white-text">
                    <button class="waves-effect waves-light btn custom-blue left" type="button" onclick="decrement(9)"><i class="material-icons">remove</i></button>
                    <span class="flow-text count-span center inline-block-display" id="mainevent-9">0</span>
                    <button class="waves-effect waves-light btn custom-blue right" type="button" onclick="increment(9)"><i class="material-icons">add</i></button>
                  </span>
                </div>
              </div>
              <div class="row valign-wrapper">
                <div class="col s6 left">
                  <span class="flow-text">Cricket(Men)</span>
                </div>
                <div class="col s6 center">
                  <label>
                    <input type="checkbox" id="mainevent-10" />
                    <span></span>
                  </label>
                </div>
              </div>
              <div class="row valign-wrapper">
                <div class="col s6 left">
                  <span class="flow-text">Volley ball(Men)</span>
                </div>
                <div class="col s6 center">
                  <label>
                    <input type="checkbox" id="mainevent-11" />
                    <span></span>
                  </label>
                </div>
              </div>
              <div class="row valign-wrapper">
                <div class="col s6 left">
                  <span class="flow-text">Kabbadi(Men)</span>
                </div>
                <div class="col s6 center">
                  <label>
                    <input type="checkbox" id="mainevent-12" />
                    <span></span>
                  </label>
                </div>
              </div>
              <div class="row valign-wrapper">
                <div class="col s6 left">
                  <span class="flow-text">Football(Men)</span>
                </div>
                <div class="col s6 center">
                  <label>
                    <input type="checkbox" id="mainevent-13" />
                    <span></span>
                  </label>
                </div>
              </div>
              <div class="row valign-wrapper">
                <div class="col s6 left">
                  <span class="flow-text">Tennikoit(Women)</span>
                </div>
                <div class="col s6 center">
                  <label>
                    <input type="checkbox" id="mainevent-14" />
                    <span></span>
                  </label>
                </div>
              </div>
              <div class="row valign-wrapper">
                <div class="col s6 left">
                  <span class="flow-text">Volleyball(Women)</span>
                </div>
                <div class="col s6 center">
                  <label>
                    <input type="checkbox" id="mainevent-15" />
                    <span></span>
                  </label>
                </div>
              </div>
              <div class="row valign-wrapper">
                <div class="col s6 left">
                  <span class="flow-text">Accomodation</span>
                </div>
                <div class="col s6 center">
                  <span class="custom-blue inline-block-display white-text">
                    <button class="waves-effect waves-light btn custom-blue left" type="button" onclick="decrement(16)"><i class="material-icons">remove</i></button>
                    <span class="flow-text count-span center inline-block-display" id="mainevent-16">0</span>
                    <button class="waves-effect waves-light btn custom-blue right" type="button" onclick="increment(16)"><i class="material-icons">add</i></button>
                  </span>
                </div>
              </div>
            </div>
          </li>
        </ul>

      <div class="container"></div>
      <div class="row valign-wrapper">
        <div class="col s6">
          <span class="flow-text left"><b>Rs. <span id="final-amount">0</span></b></span>
        </div>
        <div class="col s6">
          <button class="btn waves-effect waves-light right" id="pay-button" type="submit" name="action">Pay
            <i class="material-icons right">send</i>
          </button>
        </div>
      </div>

    </div>
  </form>
  </main>
  <div class="container">
  <ul class="collapsible">
    <li>
      <div class="collapsible-header"><i class="material-icons">list</i>Instructions</div>
      <div class="collapsible-body">
        <ul>
          <li>* GST and Transaction charges will be applied at the time of payment.</li>
          <li>* Please send a mail to <a href="mailto:ashvtheraceoftalent@gmail.com">Ashv (ashvtheraceoftalent@gmail.com)</a> mentioning the team details if are registering as a team.</li>
        </ul>
      </div>
    </li>
  </ul>
  </div>

  <script src="https://www.gstatic.com/firebasejs/5.5.7/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/5.5.7/firebase-auth.js"></script>
  <script>
    // Initialize Firebase
    var config = {
      apiKey: "AIzaSyCUZf5kkPFJtEjHLgf_AvGrW-ukkPWDa5k",
      authDomain: "goforevent-web.firebaseapp.com",
      databaseURL: "https://goforevent-web.firebaseio.com",
      projectId: "goforevent-web",
      storageBucket: "goforevent-web.appspot.com",
      messagingSenderId: "566112055985"
    };
    firebase.initializeApp(config);
  </script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script src="./js/index.js"></script>
</body>

</html>