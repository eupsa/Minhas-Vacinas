const scrollToTopBtn = document.getElementById("scrollToTopBtn");

window.onscroll = function () {
  if (
    document.body.scrollTop > 100 ||
    document.documentElement.scrollTop > 100
  ) {
    scrollToTopBtn.classList.add("show");
  } else {
    scrollToTopBtn.classList.remove("show");
  }
};

scrollToTopBtn.addEventListener("click", () => {
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });
});

if (!localStorage.getItem("cookiesAccepted")) {
  document.getElementById("cookieNotice").classList.add("show");
} else {
  document.getElementById("cookieNotice").style.display = "none";
}

document.getElementById("acceptCookies").addEventListener("click", function () {
  localStorage.setItem("cookiesAccepted", "true");

  const cookieNotice = document.getElementById("cookieNotice");
  cookieNotice.style.opacity = 0;

  setTimeout(function () {
    cookieNotice.style.display = "none";
  }, 500);
});
