$('.sidenav').sidenav();
$('.modal').modal();
$('.collapsible').collapsible();
$('select').formSelect();

(() => {
  var elem = document.querySelector('.collapsible.expandable');
  var instance = M.Collapsible.init(elem, {
    accordion: false
  });
  instance.open(0);
  instance.open(1);
})();

let signInButton = $('#sign-in-button');
let signOutButton = $('#sign-out-button');
let userNameElement = $('#username');
let userImageElement = $('#profile-image');
let loginButton = $('#login-button');

userNameElement.hide();
userImageElement.hide();

signInButton.on('click', signIn);
signOutButton.on('click', signOut);

initFirebaseAuth();

function signIn() {
  var provider = new firebase.auth.GoogleAuthProvider();
  firebase.auth().signInWithPopup(provider);
}

function signOut() {
  firebase.auth().signOut();
}

function initFirebaseAuth() {
  firebase.auth().onAuthStateChanged(authStateObserver);
}

function authStateObserver(user) {
  if (user) {
    // user is signed in
    var profilePicUrl = getProfilePicUrl();
    var userName = getUserName();

    userImageElement.attr('src', profilePicUrl);
    $('#m-profile-image').attr('src', profilePicUrl);
    userNameElement.text(userName);
    $('#m-username').text(userName);

    $('#email').text(getUserEmail);

    signInButton.hide();
    signOutButton.show();
    userNameElement.show();
    userImageElement.show();
    loginButton.hide();
  } else {
    // user is signed out
    $('#m-profile-image').attr('src', './images/profile_placeholder.png');
    $('#m-username').text("Username");
    $('#email').text('login');
    signInButton.show();
    signOutButton.hide();
    userNameElement.hide();
    userImageElement.hide();
    loginButton.show();
  }
}

function getUserName() {
  return firebase.auth().currentUser.displayName;
}

function getUserId() {
  return firebase.auth().currentUser.uid;
}

function getUserEmail() {
  return firebase.auth().currentUser.email;
}

function getProfilePicUrl() {
  return firebase.auth().currentUser.photoURL || './images/profile_placeholder.png';
}

// Payment Functionality

function increment(n) {
  let currValue = parseInt($('#mainevent-' + n).text());
  if ((n == 1 && currValue == 1) || ((n==2||n==3||n==7||n==8) && currValue ==2) || ((n==4||n==9) && currValue == 4) || ((n==5||n==6) && currValue == 8)) {
    toast("Not possible");
    return;
  }
  $('#mainevent-' + n).text(currValue + 1);
  updateAmount();
}

function decrement(n) {
  let currValue = parseInt($('#mainevent-' + n).text());
  if (currValue == 0) {
    toast("Not possible");
    return;
  }
  $('#mainevent-' + n).text(currValue - 1);
  updateAmount();
}

function toast(msg) {
  M.toast({
    html: msg
  });
}

$('input[type="checkbox"]').click(function () {
  updateAmount();
});

function updateAmount() {
  let prices = [1500, 1300, 1300, 1000, 700, 1300];
  let amount = 0;
  for (let index = 1;index<=16;index++) {
    if (index <= 9) {
      let curr = parseInt($('#mainevent-'+index).text());
      if (index == 1 && curr != 0) {
        amount = amount + 1300;
      } else {
        amount = amount + 400 * curr;
      }
    } else if (index<=15) {
      if ($('#mainevent-' + index).is(':checked')) {
        amount = amount + prices[index - 10];
      }
    } else {
      let curr = parseInt($('#mainevent-'+index).text());
      amount = amount + 400 * curr;
    }
  }
  $('#final-amount').text(amount);
}

$('#complete-form').submit(function (evt) {
  evt.preventDefault();
  //console.log('form submitted');

  if (firebase.auth().currentUser == null) {
    toast('Please login');
    return;
  }

  if ($('#final-amount').text() == 0) {
    toast('Please select atleast one event');
    return;
  }

  let txnid = $('#txnid').val();

  let productInfo = '';

  productInfo += $('#college').val()+'#';
  productInfo += $('input[name=gender]:checked').val()+'#';
  productInfo += $('#course :selected').text()+'#';

  productInfo += $('#rollno').val()+'#';
  productInfo += $('#campusambasdor').val()+'#';

  for (let index = 1;index <= 16;index++) {
    if (index <= 9) {
      productInfo += $('#mainevent-'+index).text() + '#';
    } else if (index<=15) {
      if ($('#mainevent-' + index).is(':checked'))
        productInfo += '1#'
      else
        productInfo += '0#';
    } else {
      productInfo += $('#mainevent-'+index).text() + '#';
    }
  }

  $.ajax({
    url: 'index.php',
    type: 'post',
    data: JSON.stringify({
      txnid: $('#txnid').val(),
      amount: $('#amount').val(),
      pinfo: productInfo,
      fname: $('#name').val(),
      email: getUserEmail(),
      mobile: $('#mobile-number').val(),
      udf5: $('#udf5').val()
    }),
    contentType: "application/json",
    dataType: 'json',
    success: function (json) {
      if (json['error']) {
        //console.log('error success');
      } else if (json['success']) {
        //console.log(json['success']);
        //console.log(json['amount']);
        launchBOLT(txnid, json['success'], json['amount'], productInfo);
      }
    },
    error: function () {
      //console.log('error ajax');
    }
  });

});


function launchBOLT(txnid, hash, amount, productInfo)
{
	bolt.launch({
	key: 'lH3qHLzS',
	txnid: txnid,
	hash: hash,
	amount: amount,
	firstname: $('#name').val(),
	email: getUserEmail(),
	phone: $('#mobile-number').val(),
	productinfo: productInfo,
	udf5: $('#udf5').val(),
	surl : $('#surl').val(),
	furl: $('#surl').val(),
	mode: 'dropout'
},{ responseHandler: function(BOLT){
  //console.log( BOLT.response.txnStatus );
	if(BOLT.response.txnStatus != 'CANCEL')
	{
		//Salt is passd here for demo purpose only. For practical use keep salt at server side only.
		var fr = '<form action=\"'+$('#surl').val()+'\" method=\"post\">' +
		'<input type=\"hidden\" name=\"key\" value=\"'+BOLT.response.key+'\" />' +
		'<input type=\"hidden\" name=\"phone\" value=\"'+BOLT.response.phone+'\" />' +
		'<input type=\"hidden\" name=\"txnid\" value=\"'+BOLT.response.txnid+'\" />' +
		'<input type=\"hidden\" name=\"amount\" value=\"'+BOLT.response.amount+'\" />' +
		'<input type=\"hidden\" name=\"productinfo\" value=\"'+BOLT.response.productinfo+'\" />' +
		'<input type=\"hidden\" name=\"firstname\" value=\"'+BOLT.response.firstname+'\" />' +
		'<input type=\"hidden\" name=\"email\" value=\"'+BOLT.response.email+'\" />' +
		'<input type=\"hidden\" name=\"udf5\" value=\"'+BOLT.response.udf5+'\" />' +
		'<input type=\"hidden\" name=\"mihpayid\" value=\"'+BOLT.response.mihpayid+'\" />' +
		'<input type=\"hidden\" name=\"status\" value=\"'+BOLT.response.status+'\" />' +
		'<input type=\"hidden\" name=\"hash\" value=\"'+BOLT.response.hash+'\" />' +
		'</form>';
		var form = jQuery(fr);
		jQuery('body').append(form);
		form.submit();
	}
},
	catchException: function(BOLT){
    alert( BOLT.message );
	}
});
}
