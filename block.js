const blockScreen = document.createElement("div");
blockScreen.style.position = "fixed";
blockScreen.style.top = "0";
blockScreen.style.left = "0";
blockScreen.style.width = "100%";
blockScreen.style.height = "100%";
blockScreen.style.backgroundColor = "rgba(0, 0, 0, 0.8)";
blockScreen.style.display = "none";
blockScreen.style.justifyContent = "center";
blockScreen.style.alignItems = "center";
blockScreen.style.zIndex = "9999";
blockScreen.style.transition = "all 0.3s ease";
blockScreen.style.backdropFilter = "blur(10px)";
blockScreen.style.overflow = "hidden";

const modalContent = document.createElement("div");
modalContent.classList.add("card", "text-center", "bg-dark", "text-white");
modalContent.style.padding = "30px";
modalContent.style.borderRadius = "15px";
modalContent.style.width = "500px";
modalContent.style.boxShadow = "0px 4px 20px rgba(0, 0, 0, 0.6)";
modalContent.style.transition = "transform 0.3s ease";
modalContent.style.transform = "scale(1.05)";

const modalTitle = document.createElement("h2");
modalTitle.textContent = "Importante Atualização de Domínio";
modalTitle.classList.add("h3", "font-weight-bold", "text-white");
modalContent.appendChild(modalTitle);

const message = document.createElement("p");
message.textContent =
  "Para sua segurança e para uma experiência ainda melhor, nossa plataforma foi movida para um novo domínio. Acesse o novo site agora:";
message.classList.add("lead", "font-italic", "text-white", "mb-4");
modalContent.appendChild(message);

const newDomain = document.createElement("a");
newDomain.href = "https://vacinasdigital.com";
newDomain.textContent = "https://vacinasdigital.com";
newDomain.classList.add("text-info", "font-weight-bold", "mb-4");
newDomain.style.fontSize = "20px";
newDomain.style.textDecoration = "underline";
newDomain.style.cursor = "pointer";
newDomain.addEventListener(
  "mouseenter",
  () => (newDomain.style.color = "#0d6efd")
);
newDomain.addEventListener("mouseleave", () => (newDomain.style.color = ""));
modalContent.appendChild(newDomain);

const buttonYes = document.createElement("button");
buttonYes.textContent = "Ir para o novo domínio";
buttonYes.classList.add("btn", "btn-light", "btn-lg", "mt-3");
buttonYes.style.width = "100%";
buttonYes.style.borderRadius = "12px";
buttonYes.style.padding = "10px";
buttonYes.style.fontSize = "18px";
buttonYes.addEventListener("mouseenter", () =>
  buttonYes.classList.add("btn-outline-primary")
);
buttonYes.addEventListener("mouseleave", () =>
  buttonYes.classList.remove("btn-outline-primary")
);

modalContent.appendChild(buttonYes);

blockScreen.appendChild(modalContent);

document.body.appendChild(blockScreen);

function showBlockScreen() {
  blockScreen.style.display = "flex";
  modalContent.style.transform = "scale(1.05)";
}

function redirectToNewDomain() {
  window.location.href = "https://vacinasdigital.com";
}

const currentDomain = window.location.hostname;

if (
  currentDomain === "www.minhasvacinas.online" ||
  currentDomain === "minhasvacinas.online"
) {
  showBlockScreen();
  document.body.style.overflow = "hidden";
}

buttonYes.addEventListener("click", function () {
  redirectToNewDomain();
});
