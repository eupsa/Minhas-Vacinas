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
modalContent.style.borderRadius = "12px";
modalContent.style.width = "400px"; // Diminuir a largura
modalContent.style.boxShadow = "0px 4px 20px rgba(0, 0, 0, 0.5)";
modalContent.style.transition = "transform 0.3s ease";
modalContent.style.transform = "scale(1.05)"; // Efeito de zoom suave

// Título da tela de bloqueio
const modalTitle = document.createElement("h1");
modalTitle.textContent = "🚨 Atenção! Mudança Importante 🚨";
modalTitle.classList.add("display-4", "font-weight-bold");
modalContent.appendChild(modalTitle);

// Mensagem explicativa
const message = document.createElement("p");
message.textContent =
  "Para uma experiência ainda melhor, nosso site foi movido para um novo endereço. Acesse o novo domínio:";
message.classList.add("lead", "font-italic");
modalContent.appendChild(message);

// Novo domínio
const newDomain = document.createElement("h3");
newDomain.textContent = "vacinasdigital.com";
newDomain.classList.add("text-info", "font-weight-bold");
modalContent.appendChild(newDomain);

// Botão de confirmação
const buttonYes = document.createElement("button");
buttonYes.textContent = "Ir para o novo domínio";
buttonYes.classList.add("btn", "btn-info", "btn-lg", "mt-3");
buttonYes.style.width = "100%";
buttonYes.style.borderRadius = "10px";
buttonYes.addEventListener("mouseenter", () =>
  buttonYes.classList.add("btn-outline-info")
);
buttonYes.addEventListener("mouseleave", () =>
  buttonYes.classList.remove("btn-outline-info")
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
