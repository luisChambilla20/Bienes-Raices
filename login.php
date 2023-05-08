<?php
//IMPORTA DB
require 'includes/app.php';
$db = conectarDB();
$errores = [];

//INSERTAR EN LA BD
if ($_POST) {
    $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (!$email) {
        $errores[] = 'El email es obligatorio o no es valido';
    }
    if (!$password) {
        $errores[] = 'El Password es obligatorio';
    }

    if (empty($errores)) {
        //VALIDAR SI EXISTE EL USUARIO
        $query = "SELECT * FROM usuarios WHERE email = '{$email}'";
        $resultado = mysqli_query($db, $query);

        if ($resultado->num_rows) {
            //EN CASO EXISTA EL CORREO VARIFICAR LA CONTRASENA
            $user = mysqli_fetch_assoc($resultado);

            $auth = password_verify($password, $user['password']);

            if ($auth) {
                //UTILIZAMOS VARIABLES DE SESION
                session_start();

                $_SESSION['login'] = true;

                header('Location: ./admin');
            } else {
                $errores[] = 'El password es incorrecto';
            }
        } else {
            //EN CASO NO EXISTA EL CORREO
            $errores[] = 'El usuario no exite';
        }
    }
}


incluirTemplate('header');

?>
<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar Sesion</h1>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>
    <form method="post" class="formulario">
        <fieldset>
            <legend>Email y Password</legend>

            <label for="email">E-mail</label>
            <input type="email" name="email" placeholder="Tu Email" id="email">

            <label for="telefono">Password</label>
            <input type="password" name="password" placeholder="Tu Password" id="password">

        </fieldset>
        <input type="submit" value="Iniciar sesion" class="boton boton-verde">
    </form>
</main>
<?php
incluirTemplate('footer');
?>