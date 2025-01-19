// Cria a tela de bloqueio
const blockScreen = document.createElement("div");
blockScreen.style.position = "fixed";
blockScreen.style.top = "0";
blockScreen.style.left = "0";
blockScreen.style.width = "100%";
blockScreen.style.height = "100%";
blockScreen.style.backgroundColor = "rgba(0, 0, 0, 0.8)";
blockScreen.style.display = "none"; // Inicialmente oculta
blockScreen.style.justifyContent = "center";
blockScreen.style.alignItems = "center";
blockScreen.style.zIndex = "9999";
blockScreen.style.transition = "all 0.3s ease";
blockScreen.style.backdropFilter = "blur(10px)"; // Fundo turvo
blockScreen.style.overflow = "hidden"; // Travar rolagem

// Cria o conteúdo da tela de bloqueio
const modalContent = document.createElement("div");
modalContent.classList.add("card", "text-center", "bg-dark", "text-white");
modalContent.style.padding = "30px";
modalContent.style.borderRadius = "15px";
modalContent.style.width = "450px"; // Largura mais sóbria
modalContent.style.boxShadow = "0px 4px 20px rgba(0, 0, 0, 0.6)";
modalContent.style.transition = "transform 0.3s ease";
modalContent.style.transform = "scale(1.05)"; // Efeito de zoom suave

// Título da tela de bloqueio
const modalTitle = document.createElement("h2");
modalTitle.textContent = "Importante Atualização de Domínio";
modalTitle.classList.add("h3", "font-weight-bold", "text-white");
modalContent.appendChild(modalTitle);

// Mensagem explicativa
const message = document.createElement("p");
message.textContent =
  "Para sua segurança e para uma experiência ainda melhor, nossa plataforma foi movida para um novo domínio. Acesse o novo site agora:";
message.classList.add("lead", "font-italic", "text-white", "mb-4");
modalContent.appendChild(message);

// Novo domínio
const newDomain = document.createElement("h3");
newDomain.textContent = "https://vacinasdigital.com";
newDomain.classList.add("text-info", "font-weight-bold", "mb-4");
modalContent.appendChild(newDomain);

// Botão de confirmação
const buttonYes = document.createElement("button");
buttonYes.textContent = "Ir para o novo domínio";
buttonYes.classList.add("btn", "btn-primary", "btn-lg", "mt-3");
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

// Adiciona o botão à tela de bloqueio
modalContent.appendChild(buttonYes);

// Adiciona o conteúdo à tela de bloqueio
blockScreen.appendChild(modalContent);

// Adiciona a tela de bloqueio ao body
document.body.appendChild(blockScreen);

// Função para exibir a tela de bloqueio
function showBlockScreen() {
  blockScreen.style.display = "flex";
  modalContent.style.transform = "scale(1.05)";
}

// Função para redirecionar ao novo domínio
function redirectToNewDomain() {
  window.location.href = "https://vacinasdigital.com"; // Redireciona para o novo domínio
}

// Verifica se o usuário está no domínio correto
const currentDomain = window.location.hostname;

if (
  currentDomain === "www.minhasvacinas.online" ||
  currentDomain === "minhasvacinas.online"
) {
  // Exibe a tela de bloqueio
  showBlockScreen();
  // Desabilita a rolagem da página
  document.body.style.overflow = "hidden";
}

// Ação do botão "Ir para o novo domínio"
buttonYes.addEventListener("click", function () {
  redirectToNewDomain();
});
