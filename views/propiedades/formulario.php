    <fieldset>
        <legend>Información General</legend>

        <label for="titulo">Título</label>
        <input type="text" id="titulo" name="titulo" placeholder="Título Propiedad" value="<?php echo s($propiedad->titulo); ?>">

        <label for="precio">Precio</label>
        <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo s($propiedad->precio); ?>">

        <label for="imagen">Imagen</label>
        <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

        <?php if($propiedad->imagen): ?>
            <img src="/imagenes/<?php echo $propiedad->imagen; ?>" class="imagen-small">
        <?php endif; ?>

        <label for="descripcion">Descripción</label>
        <textarea id="descripcion" name="descripcion"><?php echo s($propiedad->descripcion); ?></textarea>
    </fieldset>

    <fieldset>
        <legend>Información de la Propiedad</legend>

        <label for="habitaciones">Habitaciones</label>
        <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej. 3" min="1" max="9" value="<?php echo s($propiedad->habitaciones); ?>">

        <label for="wc">Baños</label>
        <input type="number" id="wc" name="wc" placeholder="Ej. 3" min="1" max="9" value="<?php echo s($propiedad->wc); ?>">

        <label for="estacionamiento">Estacionamiento</label>
        <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej. 3" min="1" max="9" value="<?php echo s($propiedad->estacionamiento); ?>">
    </fieldset>

    <fieldset>
        <legend>Datos del Vendedor</legend>

        <label for="vendedorId">Vendedor</label>
        <select id="vendedorId" name="vendedorId">
            <option value="">-- Seleccione --</option>
            <?php foreach($vendedores as $vendedor): ?>
                <option <?php echo (s($propiedad->vendedorId) === $vendedor->id) ? 'selected' : '';?>  value="<?php echo s($vendedor->id);?>">
                <?php echo s($vendedor->nombre) . " " . s($vendedor->apellido); ?>
            </option>
            <?php endforeach;?>
        </select>
    </fieldset>