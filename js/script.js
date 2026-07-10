const kontaktForm = document.querySelector(".contact-form");

if (kontaktForm) {
    kontaktForm.addEventListener("submit", function () {
        const button = document.getElementById("submitButton");

        if (button) {
            button.disabled = true;
            button.innerHTML = "⏳ Anfrage wird gesendet...";
        }
    });
}
