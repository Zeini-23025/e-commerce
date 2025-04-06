document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("form");
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");


    const emailError = document.createElement("small");
    emailError.style.color = "red";
    emailError.style.display = "none";
    emailInput.parentNode.appendChild(emailError);

    const passwordError = document.createElement("small");
    passwordError.style.color = "red";
    passwordError.style.display = "none";
    passwordInput.parentNode.appendChild(passwordError);

    form.addEventListener("submit", (e) => {
        let isValid = true;


        emailError.textContent = "";
        emailError.style.display = "none";
        passwordError.textContent = "";
        passwordError.style.display = "none";


        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(emailInput.value.trim())) {
            emailError.textContent = "Veuillez entrer une adresse email valide.";
            emailError.style.display = "block";
            isValid = false;
        }


        if (passwordInput.value.trim().length < 8) {
            passwordError.textContent = "Le mot de passe doit contenir au moins 8 caractères.";
            passwordError.style.display = "block";
            isValid = false;
        }


        if (!isValid) {
            e.preventDefault();
        }
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("signup-form");
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");

    form.addEventListener("submit", function (event) {

        resetErrors();

        let isValid = true;


        if (!validateEmail(emailInput.value)) {
            displayError(emailInput, "Veuillez entrer une adresse email valide.");
            isValid = false;
        }


        if (passwordInput.value.length < 8) {
            displayError(passwordInput, "Le mot de passe doit contenir au moins 8 caractères.");
            isValid = false;
        }


        if (!isValid) {
            event.preventDefault();
        }
    });

    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function displayError(input, message) {

        input.classList.add("is-invalid");


        const errorElement = document.createElement("div");
        errorElement.className = "invalid-feedback";
        errorElement.textContent = message;
        input.parentElement.appendChild(errorElement);
    }

    function resetErrors() {

        const invalidInputs = document.querySelectorAll(".is-invalid");
        invalidInputs.forEach(input => input.classList.remove("is-invalid"));

        const errorMessages = document.querySelectorAll(".invalid-feedback");
        errorMessages.forEach(error => error.remove());
    }
});
