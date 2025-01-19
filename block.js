// Cria a tela de bloqueio
const blockScreen = document.createElement("div");
blockScreen.style.position = "fixed";
blockScreen.style.top = "0";
blockScreen.style.left = "0";
blockScreen.style.width = "100%";
blockScreen.style.height = "100%";
blockScreen.style.backgroundColor = "rgba(0, 0, 0, 0.7)";
blockScreen.style.display = "none"; // Inicialmente oculta
blockScreen.style.justifyContent = "center";
blockScreen.style.alignItems = "center";
blockScreen.style.zIndex = "9999";

// Cria o conteúdo da tela de bloqueio
const modalContent = document.createElement("div");
modalContent.style.backgroundColor = "#333";
modalContent.style.color = "#fff";
modalContent.style.padding = "30px";
modalContent.style.borderRadius = "10px";
modalContent.style.width = "400px";
modalContent.style.textAlign = "center";
modalContent.style.boxShadow = "0px 4px 20px rgba(0, 0, 0, 0.5)";

// Título da tela de bloqueio
const modalTitle = document.createElement("h1");
modalTitle.textContent = "Atenção! Acesse o novo domínio";
modalTitle.style.fontSize = "2rem";
modalContent.appendChild(modalTitle);

// Mensagem explicativa
const message = document.createElement("p");
message.textContent = "Por favor, acesse o novo domínio: vacinasdigital.com";
message.style.fontSize = "1.2rem";
message.style.marginBottom = "20px";
modalContent.appendChild(message);

// Botões de confirmação
const buttonYes = document.createElement("button");
buttonYes.textContent = "Ir para o novo domínio";
buttonYes.style.backgroundColor = "#3498db";
buttonYes.style.color = "white";
buttonYes.style.border = "none";
buttonYes.style.padding = "10px 25px";
buttonYes.style.fontSize = "1.2rem";
buttonYes.style.borderRadius = "8px";
buttonYes.style.marginRight = "10px";

const buttonNo = document.createElement("button");
buttonNo.textContent = "Cancelar";
buttonNo.style.backgroundColor = "#e74c3c";
buttonNo.style.color = "white";
buttonNo.style.border = "none";
buttonNo.style.padding = "10px 25px";
buttonNo.style.fontSize = "1.2rem";
buttonNo.style.borderRadius = "8px";

// Adicionando botões à tela de bloqueio
modalContent.appendChild(buttonYes);
modalContent.appendChild(buttonNo);
blockScreen.appendChild(modalContent);

// Adiciona a tela de bloqueio à página
document.body.appendChild(blockScreen);

// Função para exibir a tela de bloqueio
function showBlockScreen() {
  blockScreen.style.display = "flex";
}

// Função para esconder a tela de bloqueio
function hideBlockScreen() {
  blockScreen.style.display = "none";
}

// Evento de navegação para bloquear
window.onbeforeunload = function (event) {
  event.preventDefault();
  event.returnValue = ""; // Esse retorno é necessário para ativar a caixa de confirmação

  // Exibe a tela de bloqueio
  showBlockScreen();
};

// Ação do botão "Ir para o novo domínio"
buttonYes.addEventListener("click", function () {
  hideBlockScreen();
  window.location.href = "https://vacinasdigital.com"; // Redireciona para o novo domínio
});

// Ação do botão "Cancelar"
buttonNo.addEventListener("click", function () {
  hideBlockScreen();
});
