<?php

class DB
{
    private string $host = "localhost";
    private string $database = "deswebii";
    private static DB $instance;
    private int $rol=0;
    public $connection;

    /**
     * @throws Exception
     */
    private function __construct(){
        if(!isset($this->connection)){
            try{
                $this->ResetDefaultConnection();
            }catch(PDOException){
                throw new Exception('Error de conexion a la base de datos');
            }
        }
    }

    /**
     * @throws PDOException
     */
    private function ResetDefaultConnection(): void
    {
        $User='';
        $Pass='';
        switch ($this->rol) {
            case 0:$User='defaultuser';$Pass='defaultuserpassword';break;
            case 1:$User='client';$Pass='clientpassword';break;
            case 2:$User='admin';$Pass='adminpassword';break;
        }
        $this->connection = mysqli_connect($this->host,$User, $Pass, $this->database);
    }

    public function changeRol($newRol):void{
        /*
         * Method to change the role of the database "reestablishes
         * the connection with the user of the one corresponding
         * to his role"
         * */
        $this->rol=$newRol;
        $this->ResetDefaultConnection();
    }

    public function getConnection(){
        return $this->connection;
    }

    /**
     * @throws Exception
     */
    public static function getInstance():DB{
        if(!isset(self::$instance)){
            self::$instance = new self;
        }

        return self::$instance;
    }

    private function __wakeup()
    {
        //to prevent serialization
    }

    private function __clone()
    {
        //to prevent duplication
    }

}
