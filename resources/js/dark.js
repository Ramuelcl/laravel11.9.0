// resources/js/dark.js

document.addEventListener('DOMContentLoaded', () => {
  let darkMode = localStorage.getItem('darkMode') === 'true';

  const toggleDarkMode = () => {
    darkMode = !darkMode;
    document.documentElement.classList.toggle('dark', darkMode);
    localStorage.setItem('darkMode', darkMode);

    // Cambiar icono según el modo
    document.getElementById('icon-sun').style.display = darkMode ? 'block' : 'none';
    document.getElementById('icon-moon').style.display = darkMode ? 'none' : 'block';
  };

  // Aplicar el modo oscuro si está almacenado en localStorage
  if (darkMode) {
    document.documentElement.classList.add('dark');
    document.getElementById('icon-sun').style.display = 'block';
    document.getElementById('icon-moon').style.display = 'none';
  } else {
    document.getElementById('icon-sun').style.display = 'none';
    document.getElementById('icon-moon').style.display = 'block';
  }

  // Asignar el evento de clic al botón
  document.getElementById('toggle-dark-mode').addEventListener('click', toggleDarkMode);
});
