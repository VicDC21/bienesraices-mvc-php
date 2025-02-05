document.addEventListener('DOMContentLoaded', function() {
    eventListeners();
    darkMode();
});

function darkMode() {
    const prefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark)');

    if (prefiereDarkMode.matches) {
        document.body.classList.add('dark-mode');
    } else {
        document.body.classList.remove('dark-mode');
    }

    prefiereDarkMode.addEventListener('change', function() {
        if (prefiereDarkMode.matches) {
            document.body.classList.add('dark-mode');
        } else {
            document.body.classList.remove('dark-mode');
        }
    });

    const botonDarkMode = document.querySelector('.dark-mode-boton');
    botonDarkMode.addEventListener('click', function() {
        document.body.classList.toggle('dark-mode');
    });
}

function eventListeners() {
    const mobileMenu = document.querySelector('.mobile-menu');
    mobileMenu.addEventListener('click', navegacionResponsive);

    // Mostrar campos condicionales
    const metodoContacto = document.querySelectorAll('input[name="contacto"]');
    metodoContacto.forEach(input => input.addEventListener('click', mostrarContacto));
}

function navegacionResponsive() {
    const navegacion = document.querySelector('.navegacion');
    navegacion.classList.toggle('mostrar');
}

function mostrarContacto(e) {
    const contactoDiv = document.querySelector('#contacto');

    if (e.target.value === 'telefono') {
        contactoDiv.innerHTML = `
            <input type="tel" id="telefono" placeholder="Tu Teléfono" name="telefono">

            <p>Elige la fecha y la hora para que te contactemos</p>

            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha">

            <label for="hora">Hora</label>
            <input type="time" id="hora" min="09:00" max="18:00" name="hora">
        `;
    } else {
        contactoDiv.innerHTML = `
            <input type="email" id="email" placeholder="Tu E-mail" name="email">
        `;
    }

}