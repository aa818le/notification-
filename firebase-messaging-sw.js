importScripts("https://www.gstatic.com/firebasejs/9.0.0/firebase-app-compat.js");
importScripts("https://www.gstatic.com/firebasejs/9.0.0/firebase-messaging-compat.js");

firebase.initializeApp({
  apiKey: "AIzaSyB1_XCbC777hKwxlilhMeq5Hpty1dvDT1I",
  authDomain: "giper-8fd92.firebaseapp.com",
  projectId: "giper-8fd92",
  storageBucket: "giper-8fd92.appspot.com",
  messagingSenderId: "485740337398",
  appId: "1:485740337398:web:xxxxxxx" // ilovangizning appId sini to‘g‘ri qo‘ying
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage(function(payload) {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);
  const notificationTitle = payload.notification.title;
  const notificationOptions = {
    body: payload.notification.body,
    icon: '/icon.png'
  };
  self.registration.showNotification(notificationTitle, notificationOptions);
});
