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

window.onload = function () {
  const sunIcon = document.getElementById("sunIcon");
  const moonIcon = document.getElementById("moonIcon");
  const themeToggle = document.getElementById("themeToggle");

  DarkReader.setFetchMethod(window.fetch);

  const isDarkMode = localStorage.getItem("darkMode") === "enabled";

  if (isDarkMode) {
    document.body.classList.add("dark");
    DarkReader.enable({
      brightness: 90,
      contrast: 110,
      sepia: 0,
    });
    sunIcon.style.display = "none";
    moonIcon.style.display = "block";
  } else {
    document.body.classList.remove("dark");
    DarkReader.disable();
    sunIcon.style.display = "block";
    moonIcon.style.display = "none";
  }

  themeToggle.addEventListener("click", function () {
    const isCurrentlyDark = document.body.classList.contains("dark");

    if (isCurrentlyDark) {
      document.body.classList.remove("dark");
      DarkReader.disable();
      localStorage.setItem("darkMode", "disabled");
      sunIcon.style.display = "block";
      moonIcon.style.display = "none";
    } else {
      document.body.classList.add("dark");
      DarkReader.enable({
        brightness: 90,
        contrast: 110,
        sepia: 0,
      });
      localStorage.setItem("darkMode", "enabled");
      sunIcon.style.display = "none";
      moonIcon.style.display = "block";
    }
  });
};

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
