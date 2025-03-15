document.addEventListener("DOMContentLoaded", function () {
    // Toggle visibility for password
    const passwordField = document.getElementById("password");
    const togglePassword = document.getElementById("toggle-password");

    if (togglePassword) {
        togglePassword.addEventListener("click", function () {
            const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
            passwordField.setAttribute("type", type);
            this.setAttribute("name", type === "password" ? "eye-off-outline" : "eye-outline");
        });
    }

    // Toggle visibility for confirm password
    const confirmPasswordField = document.getElementById("confirm-password");
    const toggleConfirmPassword = document.getElementById("toggle-confirm-password");

    if (toggleConfirmPassword) {
        toggleConfirmPassword.addEventListener("click", function () {
            const type = confirmPasswordField.getAttribute("type") === "password" ? "text" : "password";
            confirmPasswordField.setAttribute("type", type);
            this.setAttribute("name", type === "password" ? "eye-off-outline" : "eye-outline");
        });
    }
});
