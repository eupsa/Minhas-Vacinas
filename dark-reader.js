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
