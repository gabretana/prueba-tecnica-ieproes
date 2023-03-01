CREATE DATABASE control_notas;

CREATE TABLE IF NOT EXISTS alumno(
  id int NOT NULL AUTO_INCREMENT,
  nombres varchar(255) NOT NULL,
  apellidos varchar(255) NOT NULL,
  fecha_nacimiento date NOT NULL,
  primary key(id)
);

CREATE TABLE IF NOT EXISTS calificacion(
  id int NOT NULL AUTO_INCREMENT,
  asignatura varchar(255) NOT NULL,
  nota decimal(15,1) NOT NULL,
  periodo varchar(255) NOT NULL,
  alumno_id int NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY(alumno_id)
  REFERENCES alumno(id)
);

INSERT INTO alumno(
  nombres,
  apellidos,
  fecha_nacimiento
)
VALUES(
  "Yanira", "Perez", "2013-10-21"
);

INSERT INTO alumno(
  nombres,
  apellidos,
  fecha_nacimiento
)
VALUES(
  "Francisco", "Menendez", "2012-12-31"
);
