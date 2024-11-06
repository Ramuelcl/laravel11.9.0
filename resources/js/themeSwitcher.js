const root = document.documentElement;

const getBlackColors = () => {
  const bgBlackLight =
    getComputedStyle(root).getPropertyValue("--bg-black-light");
  const bgBlackMedium =
    getComputedStyle(root).getPropertyValue("--bg-black-medium");
  const bgBlackDark =
    getComputedStyle(root).getPropertyValue("--bg-black-dark");

  return [bgBlackLight, bgBlackMedium, bgBlackDark];
};

const getWhiteColors = () => {
  const bgWhiteLight =
    getComputedStyle(root).getPropertyValue("--bg-white-light");
  const bgWhiteMedium =
    getComputedStyle(root).getPropertyValue("--bg-white-medium");
  const bgWhiteDark =
    getComputedStyle(root).getPropertyValue("--bg-white-dark");

  return [bgWhiteLight, bgWhiteMedium, bgWhiteDark];
};

const getTextColors = () => {
  const textWhite = getComputedStyle(root).getPropertyValue("--text-white");
  const textBlack = getComputedStyle(root).getPropertyValue("--text-black");
  return [textWhite, textBlack];
};

export const toggleDarkTheme = (theme) => {
  const [bgBlackLight, bgBlackMedium, bgBlackDark] = getBlackColors();
  const [bgWhiteLight, bgWhiteMedium, bgWhiteDark] = getWhiteColors();
  const [textWhite, textBlack] = getTextColors();

  if (theme && theme === "light") {
    root.style.setProperty("--bg-light", bgWhiteLight);
    root.style.setProperty("--bg-medium", bgWhiteMedium);
    root.style.setProperty("--bg-dark", bgWhiteDark);
    root.style.setProperty("--text-color", textBlack);
  } else if (theme && theme === "dark") {
    root.style.setProperty("--bg-light", bgBlackLight);
    root.style.setProperty("--bg-medium", bgBlackMedium);
    root.style.setProperty("--bg-dark", bgBlackDark);
    root.style.setProperty("--text-color", textWhite);
  } else {
    return;
  }
};