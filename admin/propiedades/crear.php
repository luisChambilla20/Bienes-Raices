<?php
require "../../includes/app.php";

use App\Propiedad;
use App\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

autenticado();

//OPTENER TODOS LOS VENDEDORES
$vendedores = Vendedor::all();

$errores = Propiedad::getErrores();

$propiedad = new Propiedad();

if ($_POST) {
    // debug($_POST['propiedad']);
    $propiedad = new Propiedad($_POST['propiedad']);

    //Crear un nombre unico
    $nombreUnico = md5(uniqid(rand(), true)) . '.jpg';


    if ($_FILES['propiedad']['tmp_name']['imagen']) {
        //REALIZAMOS UN RESIZE
        $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
        $propiedad->setImage($nombreUnico);
    }

    $errores = $propiedad->validar();

    //Verificar que no se tenga errores
    if (empty($errores)) {

        if (!is_dir(CARPETA_IMAGEN)) { //Verifica si existe la carpeta 
            mkdir(CARPETA_IMAGEN);   //Crea la direccion de carpeta 
        }

        $image->save(CARPETA_IMAGEN . $nombreUnico);



        //Sube imagen al servidor
        $propiedad->guardar();
    }
}


incluirTemplate('header');

?>
<main class="contenedor seccion">
    <h1>Crear</h1>

    <a href="../" class="boton boton-verde">volver</a>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form method="POST" action="./crear.php" class="formulario" enctype="multipart/form-data">

        <?php include '../../includes/templates/formulario.php' ?>

        <input type="submit" value="Crear propiedad" class="boton boton-verde">
    </form>




</main>

<?php
incluirTemplate('footer');
?>