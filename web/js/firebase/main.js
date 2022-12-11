import { initializeApp } from 'https://www.gstatic.com/firebasejs/9.15.0/firebase-app.js'
import { getAuth } from 'https://www.gstatic.com/firebasejs/9.15.0/firebase-auth.js'
import { getFirestore } from 'https://www.gstatic.com/firebasejs/9.15.0/firebase-firestore.js'
const firebaseConfig = {
    apiKey: "AIzaSyAr8fuTEOIZRzH9VQSiPl9kuHRPoLUK9Ew",
    authDomain: "library-api-9b73a.firebaseapp.com",
    projectId: "library-api-9b73a",
    storageBucket: "library-api-9b73a.appspot.com",
    messagingSenderId: "503682698024",
    appId: "1:503682698024:web:e54826f4ea47d477279e1d",
    measurementId: "G-N8RL4647K4"
};

// Initialize Firebase
const fbApp = initializeApp(firebaseConfig);

export {fbApp}