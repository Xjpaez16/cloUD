const pass = document.getElementById("pass");
const toggleIcon = document.getElementById("togglePass");

toggleIcon.addEventListener("click", () => {
    if (pass.type === "password") {
        pass.type = "text";
        toggleIcon.setAttribute("fill", "#4A90E2"); // Cambia color si quieres
    } else {
        pass.type = "password";
        toggleIcon.setAttribute("fill", "#bbb");
    }
});
