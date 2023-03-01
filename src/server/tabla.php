<?php

require_once('dbconnect.php');

abstract class CRUD
{
    public $estado = false;
    public $dbc, $error;

    public function __construct()
    {
        $this->conectar();
    }

    public function conectar()
    {
        $this->dbc = new DBConnect();
        $this->estado = $this->dbc->conectado;
        $this->error = $this->dbc->error;
    }

    public function consulta($sql)
    {
        if (!$this->estado) {
            return false;
        }

        $stmt = $this->dbc->conexion->query($sql);
        $this->error = implode(' ', $stmt->errorInfo());

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = null;

        return $data;

    }

    public function eliminar(string $tabla, int $id)
    {
        if (!$this->estado)
            return false;

        $stmt = $this->dbc->conexion->prepare('DELETE FROM ? WHERE id=?');
        $stmt->bindParam(1, $tabla);
        $stmt->bindParam(2, $id);

        $this->estado = $stmt->execute();
        $this->cerrarConexion();

        $this->error = implode(' ', $stmt->errorInfo());
        $stmt = null;

        return $this->estado;
    }

    public function cerrarConexion()
    {
        $this->dbc->cerrar_conexion();
    }
}

?>
