<?php

require_once('tabla.php');

class Alumno extends Tabla
{
    public $id, $nombres, $apellidos, $fecha_nacimiento;

    public function insertar()
    {
        if (!$this->estado)
            return false;
        
        $sql = 'INSERT INTO alumno(nombres,apellidos,fecha_nacimiento) VALUES(?,?,?)';

        $stmt = $this->dbc->conexion->prepare($sql);

        $stmt->bindParam(1, $this->nombres);
        $stmt->bindParam(2, $this->apellidos);
        $stmt->bindParam(3, $this->fecha_nacimiento);

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

        $sql = 'UPDATE habitacion SET nombres=:nombres,apellidos=:apellidos,fecha_nacimiento=:fecha_nacimiento';
        
        $sql .= ' WHERE id=:id';
        
        $stmt = $this->dbc->conexion->prepare($sql);

        $stmt->bindParam(':nombres', $this->nombres);
        $stmt->bindParam(':apellidos', $this->apellidos);
        $stmt->bindParam(':fecha_nacimiento', $this->fecha_nacimiento);
        
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

        $sql = 'SELECT id,nombres,apellidos,fecha_nacimiento FROM alumno';
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
