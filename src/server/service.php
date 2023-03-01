<?php

if (isset($_POST['insertar_calificacion'])) {
    insertar_calificacion();
}
else if (isset($_GET['actualizar_actividad'])) {
    actualizar_actividad();
}
else if (isset($_GET['actividades'])) {
    mostrar_actividades();
}
else if (isset($_GET['alumnos'])) {
    mostrar_alumnos();
}
else {
    header('HTTP/1.1 500 Internal Server Error');
    die('Opción desconocida');
}

function insertar_calificacion()
{
    require_once('calificacion.php');
    $calificacion = new Calificacion();
    $calificacion->id = $_POST['id'];
    $calificacion->asignatura = $_POST['asignatura'];
    $calificacion->nota = $_POST['nota'];
    $calificacion->periodo = $_POST['periodo'];
    $calificacion->alumno_id = $_POST['alumno'];

    estado($calificacion->insertar(), $calificacion->error);
}

function actualizar_actividad()
{
    require_once('calificacion.php');

    $calificacion = new Calificacion();
    $calificacion->id = $_GET['actualizar_actividad'];
    $calificacion->nota = $_GET['nota'];

    estado($calificacion->actualizar(), $calificacion->error);
}

function mostrar_actividades()
{
    require_once('calificacion.php');

    $calificacion = new Calificacion();
    $datos = $calificacion->obtener(array(
        'alumno.id'=>'calificacion.alumno_id',
        'calificacion.asignatura'=>$_GET['asignatura'],
        'calificacion.periodo'=>$_GET['periodo']
    ));

    if ($datos === false) {
        estado(false, $calificacion->error);
    }

    header('HTTP/1.1 200 OK');
    echo json_encode(array(
        'notas_por_alumno'=>$datos
    ));
}

function mostrar_alumnos()
{
    require_once('alumno.php');

    $alumno = new Alumno();
    $datos = $alumno->obtener();

    if ($datos === false) {
        estado(false, $alumno->error);
    }

    header('HTTP/1.1 200 OK');
    echo json_encode(array(
        'alumnos'=>$datos
    ));
}

function estado($ok, $error)
{
    if ($ok) {
        header('HTTP/1.1 200 OK');
        echo json_encode(array('code'=>'200', 'error'=>$error));
    }
    else {
        header('HTTP/1.1 500 Internal Server Error');
        die(json_encode(array('code'=>'500', 'error'=>$error)));
    }
}

?>
