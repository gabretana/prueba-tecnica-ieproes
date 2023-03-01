document.onload = () => {
    setTimeOut(() => {
        w3.getHttpObject('server/service.php?actividades=true', cargar_notas);
    }, 1000);
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

}
