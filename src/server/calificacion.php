<?php

require_once('tabla.php');

class Actividad extends Tabla
{
    public $id, $asignatura, $nota, $periodo, $alumno_id;

    public function insertar()
    {
        if (!$this->estado)
            return false;

        $sql = 'INSERT INTO actividad(asignatura,nota,periodo,alumno_id) VALUES(?,?,?,?)';

        $stmt = $this->dbc->conexion->prepare($sql);

        $stmt->bindParam(1, $this->asignatura);
        $stmt->bindParam(2, $this->nota);
        $stmt->bindParam(3, $this->periodo);
        $stmt->bindParam(4, $this->alumno_id);

        $this->estado = $stmt->execute();
        $this->cerrarConexion();
        $this->error = implode(' ', $stmt->errorInfo());

        $stmt = null;
        return $this->estado;
    }

    public function actualizar()
    {
        if (!$this->estado)
            return false;

        $sql = 'UPDATE calificacion SET asignatura=?,nota=?,periodo=?,alumno_id=?';

        $sql .= ' WHERE id=:id';

        $stmt = $this->dbc->conexion->prepare($sql);

        $stmt->bindParam(1, $this->asignatura);
        $stmt->bindParam(2, $this->nota);
        $stmt->bindParam(3, $this->periodo);
        $stmt->bindParam(4, $this->alumno_id);

        $stmt->bindParam(':id', $this->id);

        $this->estado = $stmt->execute();
        $this->cerrarConexion();
        $this->error = implode(' ', $stmt->errorInfo());
        $stmt = null;

        return $this->estado;
    }

    public function obtener($condicion = array())
    {
        if (!$this->estado)
            return false;

        $sql = 'SELECT id,nombre,asignatura,nota FROM calificacion';
        $stmt = null;

        if (count($condicion) > 0) {
            $sql = $sql . ' WHERE ';
            $count = 0;
            $items = array();

            foreach ($condicion as $key => $item) {
                $items[] = $item;
                $count++;
                $sql = $sql . $key . '=?';

                if ($count < count($condicion)) {
                    $sql = $sql . ' AND ';
                }

                $stmt = $this->dbc->conexion->prepare($sql);

                for ($i = 1; $i <= $count; $i++) {
                    $stmt->bindParam($i, $items[$i - 1]);
                }
                $stmt->execute();
            }
        } else {
            $stmt = $this->dbc->conexion->query($sql);
        }
        $this->error = implode(' ', $stmt->errorInfo());
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
}

?>
