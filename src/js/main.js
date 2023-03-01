document.onload = () => {
    setTimeOut(() => {
        cambiar_asignatura(document.getElementById('asignaturas_select'));
    }, 1000);

    setTimeOut(() => {
        w3.getHttpObject('server/service.php?alumnos=true');
    }, 2000);
}

let login = () => {
  const form = document.getElementById('login_form');
  const formData = new FormData(form);

  if (formData.get('usuario') === 'admin' && formData.get('password') === '123456') {
    window.location.href = 'notas.html';
  }
}

let cargar_notas = (actividades) => {
    w3.displayObject('tabla_alumnos', actividades);
}

let editar_nota = (element) => {
    const nota = document.getElementById('nota_input').value;
    w3.getHttpObject(`server/service.php?actualizar_actividad=${element.dataset.id}&nota=${nota}`, (res) => {
        console.log(res);
    });
}

let cambiar_periodo = (element) => {
    const asignaturas = document.getElementById('asignaturas_select');
    const nombre_asignatura = asignaturas.options[asignaturas.value].text;
    const nombre_periodo = element.options[element.value].text;

    w3.getHttpObject(`server/service.php?actividades=true&asignatura=${nombre_asignatura}&periodo=${nombre_periodo}`, cargar_notas);
}

let cambiar_asignatura = (element) => {
    const periodos = document.getElementById('periodos_select');
    const nombre_periodo = periodos.options[periodos.value].text;
    const nombre_asignatura = element.options[element.value].text;

    w3.getHttpObject(`server/service.php?actividades=true&asignatura=${nombre_asignatura}&periodo=${nombre_periodo}`, cargar_notas);
}

let cargar_alumnos = (alumnos) => {
    w3.displayObject('alumnos_select', alumnos);
}

let insertar_calificacion = () => {
    const form = new FormData(document.getElementById('actividad_form'));

    const xhr = new XMLHttpRequest();

    xhr.addEventListener('load', (event) => {
        alert('Nota añadiad correctamente.');
    });

    xhr.addEventListener('error', (event) => {
        alert('No fue posible insertar la nota');
    });

    xhr.open('POST', 'server/service.php');

    xhr.send(form);

    document.getElementById('actividad_dialog').style.display = 'none';
}
