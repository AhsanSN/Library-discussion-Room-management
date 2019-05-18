<script src="https://www.gstatic.com/firebasejs/5.0.4/firebase.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.0.4/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.0.4/firebase-messaging.js"></script>
<script>

function yes(){
//localStorage.setItem('ask_notf','19');//making default
    
        console.log('Developer: Anomoz by Syed Ahsan Ahmed');
        if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('../firebase-messaging-sw.js')
  .then(function(registration) {
    console.log('Registration successful, scope is:', registration.scope);
  }).catch(function(err) {
    console.log('Service worker registration failed, error:', err);
  });
}

var config = {
    apiKey: "AIzaSyCLBoiPZvSBAnjQb4ZFN4cwm9K-byfmx44",
    authDomain: "anomoz-library.firebaseapp.com",
    databaseURL: "https://anomoz-library.firebaseio.com",
    projectId: "anomoz-library",
    storageBucket: "anomoz-library.appspot.com",
    messagingSenderId: "353030890439",
    appId: "1:353030890439:web:3c157dfc00a515e8"
  };
  firebase.initializeApp(config);
  const messaging = firebase.messaging();
  messaging.usePublicVapidKey("BDJ-CmtI8HvB2kXz4-6S-yf49D9Y2e-k8azratWEefUXC2ZcFWWjY7FrSM5DMk76z-_iPnyUk9sPhur9mqIVIb8");
  if (Notification.permission == "default") {console.log("can be granted")

  }
  messaging.requestPermission()
  .then(function(){
    return messaging.getToken()
  .then(function(currentToken) {
    console.log("token", currentToken);
    localStorage.setItem("token",currentToken);
    localStorage.setItem("tokenExpiry", (new Date().getTime() / 1000)+2028000);
    document.getElementById("tokenValue").value = currentToken;
    document.getElementById("tokenForm").submit();
    //token received
  })
  .catch(function(err) {
    console.log('An error occurred while retrieving token. ', err);
    showToken('Error retrieving Instance ID token. ', err);
    setTokenSentToServer(false);
  });
  }).catch(function(err){
    console.log('Error');
  });
messaging.onTokenRefresh(function() {
  messaging.getToken().then(function(refreshedToken) {
    console.log('Token refreshed.');
    setTokenSentToServer(false);
    sendTokenToServer(refreshedToken);
    //token received
  }).catch(function(err) {
    console.log('Unable to retrieve refreshed token ', err);
    showToken('Unable to retrieve refreshed token ', err);
  });
});
messaging.onMessage(function(payload) {
  console.log('Message received. ', payload);
  // ...
});

}
</script>
