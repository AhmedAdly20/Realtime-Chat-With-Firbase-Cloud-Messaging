importScripts('https://www.gstatic.com/firebasejs/7.18.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.18.0/firebase-messaging.js');

// Initialize the Firebase app in the service worker by passing in
// your app's Firebase config object.
// https://firebase.google.com/docs/web/setup#config-object
var firebaseConfig = {
    apiKey: "AIzaSyB1v9SyK49K44K70OJdhYorxZdIx7CmpFE",
    authDomain: "chat-5e84b.firebaseapp.com",
    databaseURL: "https://chat-5e84b.firebaseio.com",
    projectId: "chat-5e84b",
    storageBucket: "chat-5e84b.appspot.com",
    messagingSenderId: "382518663796",
    appId: "1:382518663796:web:4cb70a5524f01ea0964f21"
};
// Initialize Firebase
firebase.initializeApp(firebaseConfig);

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();

const {title , body} = payload.notification
messaging.setBackgroundMessageHandler(function (payload) {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
    // Customize notification here
    const notificationOptions = {
        body
    };

    return self.registration.showNotification(title,
        notificationOptions);
});
