    <main class="contenedor seccion">
        <h1>Contacto</h1>

        <?php
            if($mensaje) {
                if($error) {
                    echo "<p class='alerta error'>" . $mensaje . "</p>";
                } else {
                    echo "<p class='alerta exito'>" . $mensaje . "</p>";
                }
            }
        ?>

        <picture>
            <source srcset="build/img/destacada3.webp" type="image/webp">
            <source srcset="build/img/destacada3.jpg" type="image/jpeg">
            <img loading="lazy" src="build/img/destacada3.jpg" alt="Imagen Contacto">
        </picture>

        <h2>Llene el formulario de Contacto</h2>

        <form class="formulario" action="/contacto" method="POST">
            <fieldset>
                <legend>Información Personal</legend>

                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" placeholder="Tu Nombre" name="nombre">
                
                <label for="mensaje">Mensaje</label>
                <textarea id="mensaje" name="mensaje"></textarea>
            </fieldset>

            <fieldset>
                <legend>Información sobre la Propiedad</legend>

                <label for="opciones">Vende o Compra</label>
                <select id="opciones" name="tipo">
                    <option value="" disabled selected>-- Seleccione --</option>
                    <option value="Compra">Compra</option>
                    <option value="Vende">Vende</option>
                </select>

                <label for="presupuesto">Precio o Presupuesto</label>
                <input type="number" id="presupuesto" placeholder="Tu Precio o Presupuesto" min="1" name="precio">
            </fieldset>

            <fieldset>
                <legend>Contacto</legend>

                <label>Como desea ser contactado</label>

                <div class="forma-contacto">
                    <label for="contactar-telefono">Teléfono</label>
                    <input type="radio" id="contactar-telefono" name="contacto" value="telefono" name="contacto">

                    <label for="contactar-email">E-mail</label>
                    <input type="radio" id="contactar-email" name="contacto" value="email" name="contacto">
                </div>

                <div id="contacto"></div>
            <input type="submit" class="boton-verde" value="Enviar"></input>
        </form>
    </main>
