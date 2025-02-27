document.addEventListener("DOMContentLoaded", function () {
    let page = document.body.getAttribute("data-page");

    function handleFormSubmission(formId) {
        const form = document.getElementById(formId);
        
        if (form) {
            form.addEventListener("submit", function (event) {
                event.preventDefault(); // Evita el envío múltiple

                let submitButton = form.querySelector("button[type='submit']");

                // Verifica si ya se está procesando
                if (submitButton.disabled) {
                    return;
                }

                submitButton.disabled = true; // Deshabilita el botón
                
                // Mantener el diseño original del botón
                submitButton.innerHTML = `
                    <span class="indicator-progress">Procesando...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                `;

                setTimeout(() => {
                    form.submit();
                }, 2000);
            });
        }
    }

    if (page === "sign-up") {
        handleFormSubmission("kt_sign_up_form");
    } else if (page === "sign-in" || page === "add-timezone" || page === "create_role" || page === "new_new") {
        handleFormSubmission("kt_sign_in_form");
    }
});
