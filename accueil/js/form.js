// Fonction pour afficher le formulaire de connexion et masquer le formulaire d'inscription
function displayLoginForm() {
    document.getElementById('loginForm').style.display = 'block';
    document.getElementById('inscriptionForm').style.display = 'none';
}

// Fonction pour afficher le formulaire d'inscription et masquer le formulaire de connexion
function displayInscriptionForm() {

    document.getElementById('inscriptionForm').style.display = 'block';
    document.getElementById('loginForm').style.display = 'none';
   
}


// Fonction pour fermer le formulaire de connexion
function closeLoginForm() {
    document.getElementById('loginForm').style.display = 'none';
}

// Fonction pour fermer le formulaire d'inscription
function closeInscriptionForm() {
    document.getElementById('inscriptionForm').style.display = 'none';
}

// Récupérer l'élément de l'icône utilisateur
var userIcon = document.getElementById('userIcon');

// Ajouter un écouteur d'événements au clic sur l'icône utilisateur
userIcon.addEventListener('click', function() {
    displayLoginForm(); // Afficher le formulaire de connexion lorsque l'icône utilisateur est cliquée
});


// Récupérer le lien de connexion à l'intérieur du formulaire d'inscription
var loginLinkInInscriptionForm = document.querySelector('#inscriptionForm .login-link');

// Ajouter un écouteur d'événements au clic sur le lien de connexion à l'intérieur du formulaire d'inscription
loginLinkInInscriptionForm.addEventListener('click', function(event) {
    event.preventDefault(); // Empêcher le comportement par défaut du lien
    displayLoginForm(); // Afficher le formulaire de connexion lorsque le lien de connexion dans le formulaire d'inscription est cliqué
});

// Récupérer le lien d'inscription à l'intérieur du formulaire de connexion
var signUpLinkInLoginForm = document.querySelector('#loginForm .login-link');

// Ajouter un écouteur d'événements au clic sur le lien d'inscription à l'intérieur du formulaire de connexion
signUpLinkInLoginForm.addEventListener('click', function(event) {
    event.preventDefault(); // Empêcher le comportement par défaut du lien
    displayInscriptionForm(); // Afficher le formulaire d'inscription lorsque le lien d'inscription dans le formulaire de connexion est cliqué
});

// Récupérer l'icône de fermeture dans le formulaire de connexion
var closeIconLoginForm = document.querySelector('#loginForm .close-icon');

// Ajouter un écouteur d'événements à l'icône de fermeture dans le formulaire de connexion
closeIconLoginForm.addEventListener('click', function() {
    closeLoginForm(); // Fermer le formulaire de connexion lorsque l'icône de fermeture est cliquée
});

// Récupérer l'icône de fermeture dans le formulaire d'inscription
var closeIconInscriptionForm = document.querySelector('#inscriptionForm .close-icon');

// Ajouter un écouteur d'événements à l'icône de fermeture dans le formulaire d'inscription
closeIconInscriptionForm.addEventListener('click', function() {
    closeInscriptionForm(); // Fermer le formulaire d'inscription lorsque l'icône de fermeture est cliquée
});




