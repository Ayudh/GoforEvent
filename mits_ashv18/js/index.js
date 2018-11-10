$('.sidenav').sidenav();
$('.modal').modal();
$('.collapsible').collapsible();
$('select').formSelect();

(() => {
  var elem = document.querySelector('.collapsible.expandable');
  var instance = M.Collapsible.init(elem, {
    accordion: false
  });
  // instance.open(0);
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
    userNameElement.text(userName);

    signInButton.hide();
    signOutButton.show();
    userNameElement.show();
    userImageElement.show();
    loginButton.hide();
  } else {
    // user is signed out
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
  return firebase.auth().currentUser.photoURL || '../images/profile_placeholder.png';
}