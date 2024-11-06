let themeButton = document.getElementById("theme-button");
let themeLogo = document.getElementById("theme-logo");

let theme = localStorage.getItem("theme");

themeButton.addEventListener("click", () => {
  if (theme === "light") {
    theme = "dark";
    themeLogo.name = "sun";
  } else if (theme === "dark") {
    theme = "light";
    themeLogo.name = "moon";
  }

  localStorage.setItem("theme", theme);
});