// script.js

document.addEventListener("DOMContentLoaded", function () {
    const metodoPago = document.getElementById("metodo_pago");
    const mobilePaymentFields = document.getElementById("mobile-payment-fields");
    const cardPaymentFields = document.getElementById("card-payment-fields");

    metodoPago.addEventListener("change", function () {
        const selected = metodoPago.value;

        // Mostrar u ocultar campos según el método de pago
        if (selected === "yape" || selected === "plin") {
            mobilePaymentFields.classList.remove("hidden");
            cardPaymentFields.classList.add("hidden");
        } else if (selected === "tarjeta") {
            mobilePaymentFields.classList.add("hidden");
            cardPaymentFields.classList.remove("hidden");
        } else {
            mobilePaymentFields.classList.add("hidden");
            cardPaymentFields.classList.add("hidden");
        }
    });
});
