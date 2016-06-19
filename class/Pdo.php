<?php
ini_set('display_errors', 1);

class SPdo
{
    public $PDOinstance = null;
    private static $instance = null;

    const SERVER = "localhost";
    const SERVER_DOCKER = "mariadb";
    const PORT = "8889";
    const DATABASE = "recipy";
    const LOGIN = "root";
    const PASSWORD = "root";


    private function __construct()
    {
        $dsn = 'mysql:dbname=' . self::DATABASE . ';host=' . self::SERVER . ':3306';
        try {
            $this->PDOinstance = new PDO($dsn, self::LOGIN, self::PASSWORD);
        } catch (PDOException $e) {
            $dsn = 'mysql:dbname=' . self::DATABASE . ';host=' . self::SERVER_DOCKER . ':3306';
            $this->PDOinstance = new PDO($dsn, self::LOGIN, "");
        }
        $this->PDOinstance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new SPDO();
        }

        return self::$instance;
    }

    /*
        Execution de requete sql
    */
    public function query($query, $array)
    {
        try {

            $str = preg_replace('/\s+/', '', $query);
            $str = strtolower($str);
            $statement = $this->PDOinstance->prepare($query);
            if (substr($str, 0, 6) == "select") {

                $statement->execute($array);

                return $statement->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return $statement->execute($array);
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }

    }

}
