<?php
//USAREMOS LA SESION 
require "../includes/app.php";
autenticado();

use App\Propiedad;
use App\Vendedor;

$propiedades = Propiedad::all();
// $vendedores = Vendedor::all();

// debug($vendedores);

$mensaje = $_GET['mensaje'] ?? null;


if ($_POST) {
    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ($id) {
        $propiedad = Propiedad::forId($id);

        $propiedad->eliminarBD();
    }
}

incluirTemplate('header');
?>
<main class="contenedor seccion">
    <h1>Administrar registros</h1>
    <!-- intval convierte un dato a entero -->
    <?php if (intval($mensaje) === 1) : ?>
        <p class="alerta exito">Anuncio creado correctamente</p>
    <?php elseif (intval($mensaje) === 2) : ?>
        <p class="alerta exito">Anuncio actualizado correctamente</p>
    <?php elseif (intval($mensaje) === 3) : ?>
        <p class="alerta exito">Anuncio eliminado correctamente</p>
    <?php endif; ?>
    <a href="./propiedades/crear.php" class="boton boton-verde">Nueva propiedad</a>

    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- IMPORTAMOS LAS PROPIEDADES DE LA BD -->
            <?php foreach ($propiedades as $propiedad) : ?>
                <tr>
                    <td><?php echo $propiedad->id; ?></td>
                    <td><?php echo $propiedad->titulo; ?></td>
                    <td><img class="imagen-tabla" src="../imagenes/<?php echo $propiedad->imagen; ?>" alt="Imagen"></td>
                    <td><?php echo $propiedad->precio; ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php
incluirTemplate('footer');
?>