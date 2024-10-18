const togglePassword = document.querySelector("#togglePassword");
const toggleConfPassword = document.querySelector("#ConftogglePassword");
const password = document.querySelector("#senha");
const confPassword = document.querySelector("#confSenha");

const toggleVisibility = (field, toggleBtn) => {
  const type = field.getAttribute("type") === "password" ? "text" : "password";
  field.setAttribute("type", type);
  toggleBtn.querySelector("i").classList.toggle("bi-eye");
  toggleBtn.querySelector("i").classList.toggle("bi-eye-slash");
};

togglePassword.addEventListener("click", () => {
  toggleVisibility(password, togglePassword);
});

toggleConfPassword.addEventListener("click", () => {
  toggleVisibility(confPassword, toggleConfPassword);
});



