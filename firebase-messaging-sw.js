
// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here, other Firebase libraries
// are not available in the service worker.
importScripts('https://www.gstatic.com/firebasejs/4.8.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/4.8.1/firebase-messaging.js');

// Initialize the Firebase app in the service worker by passing in the
// messagingSenderId.
var config = {
    // Some code here
    apiKey: "AIzaSyCLBoiPZvSBAnjQb4ZFN4cwm9K-byfmx44",
    authDomain: "anomoz-library.firebaseapp.com",
    databaseURL: "https://anomoz-library.firebaseio.com",
    projectId: "anomoz-library",
    storageBucket: "anomoz-library.appspot.com",
    messagingSenderId: "353030890439",
    appId: "1:353030890439:web:3c157dfc00a515e8"
  };
  firebase.initializeApp(config);

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();


messaging.setBackgroundMessageHandler(function(payload) {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);
  // Customize notification here
  var notificationTitle = 'Background Message Title';
  var notificationOptions = {
    body: 'Background Message body.',
    icon: '/firebase-logo.png'
  };

  return self.registration.showNotification(notificationTitle,
    notificationOptions);
});