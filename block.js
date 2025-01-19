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

// Cria o conteúdo da tela de bloqueio
const modalContent = document.createElement("div");
modalContent.style.backgroundColor = "#2c3e50";
modalContent.style.color = "#ecf0f1";
modalContent.style.padding = "40px";
modalContent.style.borderRadius = "15px";
modalContent.style.width = "450px";
modalContent.style.textAlign = "center";
modalContent.style.boxShadow = "0px 4px 30px rgba(0, 0, 0, 0.6)";
modalContent.style.transform = "scale(1)";
modalContent.style.transition = "transform 0.3s ease";

// Título da tela de bloqueio
const modalTitle = document.createElement("h1");
modalTitle.textContent = "🚨 Atenção! Mudança Importante 🚨";
modalTitle.style.fontSize = "2.5rem";
modalTitle.style.marginBottom = "20px";
modalTitle.style.fontWeight = "bold";
modalTitle.style.textTransform = "uppercase";
modalContent.appendChild(modalTitle);

// Mensagem explicativa
const message = document.createElement("p");
message.textContent =
  "Para uma experiência ainda melhor, nosso site foi movido para um novo endereço. Acesse o novo domínio:";
message.style.fontSize = "1.2rem";
message.style.marginBottom = "30px";
message.style.fontStyle = "italic";
modalContent.appendChild(message);

// Novo domínio
const newDomain = document.createElement("h2");
newDomain.textContent = "vacinasdigital.com";
newDomain.style.color = "#3498db";
newDomain.style.fontSize = "1.5rem";
newDomain.style.marginBottom = "30px";
newDomain.style.fontWeight = "bold";
modalContent.appendChild(newDomain);

// Botões de confirmação
const buttonYes = document.createElement("button");
buttonYes.textContent = "Ir para o novo domínio";
buttonYes.style.backgroundColor = "#3498db";
buttonYes.style.color = "white";
buttonYes.style.border = "none";
buttonYes.style.padding = "15px 30px";
buttonYes.style.fontSize = "1.4rem";
buttonYes.style.borderRadius = "10px";
buttonYes.style.cursor = "pointer";
buttonYes.style.marginRight = "20px";
buttonYes.style.transition = "background-color 0.3s ease";
buttonYes.addEventListener(
  "mouseenter",
  () => (buttonYes.style.backgroundColor = "#2980b9")
);
buttonYes.addEventListener(
  "mouseleave",
  () => (buttonYes.style.backgroundColor = "#3498db")
);

const buttonNo = document.createElement("button");
buttonNo.textContent = "Cancelar";
buttonNo.style.backgroundColor = "#e74c3c";
buttonNo.style.color = "white";
buttonNo.style.border = "none";
buttonNo.style.padding = "15px 30px";
buttonNo.style.fontSize = "1.4rem";
buttonNo.style.borderRadius = "10px";
buttonNo.style.cursor = "pointer";
buttonNo.style.transition = "background-color 0.3s ease";
buttonNo.addEventListener(
  "mouseenter",
  () => (buttonNo.style.backgroundColor = "#c0392b")
);
buttonNo.addEventListener(
  "mouseleave",
  () => (buttonNo.style.backgroundColor = "#e74c3c")
);

// Adicionando botões à tela de bloqueio
modalContent.appendChild(buttonYes);
modalContent.appendChild(buttonNo);
blockScreen.appendChild(modalContent);

// Adiciona a tela de bloqueio à página
document.body.appendChild(blockScreen);

// Função para exibir a tela de bloqueio
function showBlockScreen() {
  blockScreen.style.display = "flex";
  modalContent.style.transform = "scale(1.1)";
}

// Função para esconder a tela de bloqueio
function hideBlockScreen() {
  blockScreen.style.display = "none";
  modalContent.style.transform = "scale(1)";
}

// Adiciona comportamento para bloquear a navegação ao tentar sair ou navegar para outro site
window.addEventListener("beforeunload", function (event) {
  event.preventDefault(); // Previne a ação de navegação
  event.returnValue = ""; // Ação necessária para exibir o pop-up padrão

  // Exibe a tela de bloqueio
  showBlockScreen();
});

// Ação do botão "Ir para o novo domínio"
buttonYes.addEventListener("click", function () {
  hideBlockScreen();
  window.location.href = "https://vacinasdigital.com"; // Redireciona para o novo domínio
});

// Ação do botão "Cancelar"
buttonNo.addEventListener("click", function () {
  hideBlockScreen();
});
