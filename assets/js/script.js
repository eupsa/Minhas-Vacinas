const backToTopButton = document.querySelector(".back-to-top");

window.addEventListener("scroll", () => {
  if (window.scrollY > 300) {
    backToTopButton.style.display = "block";
  } else {
    backToTopButton.style.display = "none";
  }
});

backToTopButton.addEventListener("click", (e) => {
  e.preventDefault();
  window.scrollTo({ top: 0, behavior: "smooth" });
});

if (!localStorage.getItem("modificationsAccepted")) {
  document.getElementById("overlay").style.visibility = "visible";
}

document.getElementById("accept-btn").addEventListener("click", function () {
  // localStorage.setItem("modificationsAccepted", "true");
  document.getElementById("overlay").style.visibility = "hidden";
});
