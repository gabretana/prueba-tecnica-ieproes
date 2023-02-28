<?php 

class DBConnect {
    const USUARIO = 'root';
    const PASSWORD = '';
    const URL = 'localhost';
    const DB = 'control_notas';
    
    public $error = '';
    
    public $conexion, $conectado;

    public function __construct()
    {
        $constr = 'mysql:host=' . self::URL . ';port=3306;dbname=' . self::DB;
        
        try {
            $this->conexion = new PDO($constr, self::USUARIO, self::PASSWORD, array(PDO::ATTR_PERSISTENT => false));
            $this->conectado = true;
        }
        catch(PDOException $e)
        {
            $this->error = $e->getMessage();
            $this->conectado = false;
        }
        
    }

    public function cerrar_conexion()
    {
        $this->conexion = null;
        $this->conectado = false;
    }

}

?>
