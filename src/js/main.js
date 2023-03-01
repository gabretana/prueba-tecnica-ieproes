document.onload = () => {
    setTimeOut(() => {
        w3.getHttpObject('server/service.php?asignaturas=true', cargar_asignaturas);
    }, 500);

    setTimeOut(() => {
        w3.getHttpObject('server/service.php?periodos=true', cargar_periodos);
    }, 1000);

    setTimeOut(() => {
        cambiar_asignatura(document.getElementById('asignaturas_select'));
    }, 1500);
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

let cargar_asignaturas = (asignaturas) => {
    w3.displayObject('asignaturas_select', asignaturas);
}

let cargar_periodos = (periodos) => {
    w3.displayObject('periodos_select', periodos);
}
