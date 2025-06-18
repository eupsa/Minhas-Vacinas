// ARQUIVO SEPARADO PARA IMPORTAÇÃO
// SweetAlert2 Configuration

const SwalConfig = {
  customClass: {
    popup: "swal-custom-popup",
    title: "swal-custom-title",
    htmlContainer: "swal-custom-text",
  },
  buttonsStyling: false,
  showClass: {
    popup: "animate__animated animate__fadeInUp animate__faster",
  },
  hideClass: {
    popup: "animate__animated animate__fadeOutDown animate__faster",
  },
};

// Import SweetAlert2
const Swal = require("sweetalert2");

// Função para Success
function showSuccess(title, text, callback = null) {
  Swal.fire({
    ...SwalConfig,
    icon: "success",
    title: title,
    text: text,
    confirmButtonText: '<i class="bi bi-check-lg me-1"></i>Entendi',
    timer: 3000,
    timerProgressBar: true,
  }).then((result) => {
    if (callback && typeof callback === "function") {
      callback(result);
    }
  });
}

// Função para Error
function showError(title, text, callback = null) {
  Swal.fire({
    ...SwalConfig,
    icon: "error",
    title: title,
    text: text,
    confirmButtonText: '<i class="bi bi-x-lg me-1"></i>Fechar',
    timer: 5000,
    timerProgressBar: true,
  }).then((result) => {
    if (callback && typeof callback === "function") {
      callback(result);
    }
  });
}

// Função para Warning
function showWarning(title, text, callback = null) {
  Swal.fire({
    ...SwalConfig,
    icon: "warning",
    title: title,
    text: text,
    confirmButtonText: '<i class="bi bi-exclamation-triangle me-1"></i>Entendi',
    timer: 4000,
    timerProgressBar: true,
  }).then((result) => {
    if (callback && typeof callback === "function") {
      callback(result);
    }
  });
}

// Função para Info
function showInfo(title, text, callback = null) {
  Swal.fire({
    ...SwalConfig,
    icon: "info",
    title: title,
    text: text,
    confirmButtonText: '<i class="bi bi-info-circle me-1"></i>Entendi',
    timer: 4000,
    timerProgressBar: true,
  }).then((result) => {
    if (callback && typeof callback === "function") {
      callback(result);
    }
  });
}

// Função para Confirmação
function showConfirm(
  title,
  text,
  confirmCallback = null,
  cancelCallback = null
) {
  return Swal.fire({
    ...SwalConfig,
    icon: "question",
    title: title,
    text: text,
    showCancelButton: true,
    confirmButtonText: '<i class="bi bi-check-lg me-1"></i>Confirmar',
    cancelButtonText: '<i class="bi bi-x-lg me-1"></i>Cancelar',
    reverseButtons: true,
  }).then((result) => {
    if (
      result.isConfirmed &&
      confirmCallback &&
      typeof confirmCallback === "function"
    ) {
      confirmCallback(result);
    } else if (
      result.isDismissed &&
      cancelCallback &&
      typeof cancelCallback === "function"
    ) {
      cancelCallback(result);
    }
    return result;
  });
}

// Função para Loading
function showLoading(title = "Carregando...", text = "Aguarde um momento") {
  Swal.fire({
    ...SwalConfig,
    title: title,
    text: text,
    allowOutsideClick: false,
    allowEscapeKey: false,
    showConfirmButton: false,
    didOpen: () => {
      Swal.showLoading();
    },
  });
}

// Função para fechar loading
function closeLoading() {
  Swal.close();
}

// Toast Success
function toastSuccess(message) {
  Swal.fire({
    toast: true,
    position: "top-end",
    icon: "success",
    title: message,
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
  });
}

// Toast Error
function toastError(message) {
  Swal.fire({
    toast: true,
    position: "top-end",
    icon: "error",
    title: message,
    showConfirmButton: false,
    timer: 4000,
    timerProgressBar: true,
  });
}
