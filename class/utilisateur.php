<?php
ini_set('display_errors', 1);
require_once("pdo.php");

class Utilisateur
{

    private $id;
    private $nom;
    private $prenom;
    private $email;
    private $logins;
    private $admin;
    private $naissance;
    private $mdp;
    private $actif;
    private $token;

    public function __construct($id = null, $nom = null, $prenom = null, $logins = null, $email = null, $admin = null, $naissance = null, $mdp = null, $actif = null)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->logins = $logins;
        $this->email = $email;
        $this->admin = $admin;
        $this->naissance = $naissance;
        $this->mdp = $mdp;
        $this->actif = $actif;
    }

    /**
     * @param int    $id
     * @param string $token
     *
     * @return Utilisateur
     */
    public function getCurrentUser(int $id, string $token) : Utilisateur
    {
        $sql = "SELECT token FROM ustilisateur WHERE id = :id AND token = :token";
        $array = array(
            ":id"    => $id,
            ":token" => $token
        );

        $dataUsers = Spdo::getInstance()->query($sql, $array);
        if (is_array($dataUsers)) {
            $dataUsers = reset($dataUsers);
            $user = new Utilisateur();
        }

        return false;
    }

    public function ajoutStorage()
    {
        $sql = "select ajout(:nom,:prenom,:admin,:logins,:email,:naissance,:pwd)";
        $array = array(
            ":nom"       => $this->nom,
            ":prenom"    => $this->prenom,
            ":admin"     => $this->admin,
            ":logins"    => $this->logins,
            ":email"     => $this->email,
            ":naissance" => $this->naissance,
            ":pwd"       => $this->mdp
        );

        return Spdo::getInstance()->query($sql, $array);
    }


    public function createUser()
    {
        $sql = "insert into Utilisateur (nom,prenom,logins,email,naissance,pwd) values (:nom,:prenom,:logins,:email,:naissance,MD5(:pwd))";
        $array = array(
            ":nom"       => $this->nom,
            ":prenom"    => $this->prenom,
            ":logins"    => $this->logins,
            ":email"     => $this->email,
            ":naissance" => $this->naissance,
            ":pwd"       => $this->mdp
        );

        return Spdo::getInstance()->query($sql, $array);
    }


    public function exist()
    {
        $sql = "select count(*) as 'nb' from Utilisateur where logins=:logins and email=:email";
        $array = array(
            ":email"  => $this->email,
            ":logins" => $this->logins
        );

        return Spdo::getInstance()->query($sql, $array);
    }


    public function getUtilisateur()
    {
        if ($this->logins == null || $this->logins == "" || $this->email == "" || $this->email == null || $this->mdp == "" || $this->mdp == null) {
            echo "IN logins verificaiton <br/>";

            return false;
        }
        $tab = $this->exist();
        if ($tab[0]['nb'] < "1") {
            return false;
        }
        $sql = "select id,nom,prenom from Utilisateur where logins=:logins and email=:email and pwd=MD5(:mdp) and actif=0";
        $array = array(
            ":logins" => $this->logins,
            ":email"  => $this->email,
            ":mdp"    => $this->mdp
        );

        return Spdo::getInstance()->query($sql, $array);
    }

    public function getConnexion()
    {
        $sql = "select * from Utilisateur where logins=:logins and pwd=MD5(:mdp)";
        $array = array(
            ":logins" => $this->logins,
            ":mdp"    => $this->mdp
        );

        return Spdo::getInstance()->query($sql, $array);
    }


    public function modifier()
    {
        if ($this->nom == "" || $this->nom == null || $this->prenom === "" || $this->prenom == null || $this->email == "" || $this->email == null || $this->logins == "" || $this->logins == null) {
            return false;
        }
        $sql = "update Utilisateur set nom=:nom,prenom=:prenom,email=:email where logins=:logins";
        $array = array(
            ":nom"    => $this->nom,
            ":prenom" => $this->prenom,
            ":email"  => $this->email,
            ":logins" => $this->logins
        );

        return Spdo::getInstance()->query($sql, $array);
    }

    public function desactiver()
    {
        $val = $this->getUtilisateur();
        var_dump($val);
        if ($val == false || $val == null) {
            echo "<br/>IN null desactiver function <br/>";

            return false;
        }
        $sql = "update Utilisateur set actif=1 where id=:id";
        $array = array(
            ":id" => $val[0]["id"]
        );

        return Spdo::getInstance()->query($sql, $array);
    }


    public function getToken()
    {
        return $this->token;
    }


    public function setToken($token)
    {

        $this->token = $token;


    }

    /*
     *
     *   The ERROR 7 is when you can't get the a good id user
     *
     * */

    /*
     *
     *   The ERROR 8 is when the token is not good
     *
     * */

    public function activeSession($id)
    {

        if ($id == null || $id == 0) {

            header('Location: index.php?err=7');
        }
        if ($this->token == null) {

            header('Location: index.php?err=8');
        }

        $sql = "update Utilisateur set Token=:token where id=:id";
        $array = array(
            ":token" => $this->token,
            ":id"    => $id
        );

        return Spdo::getInstance()->query($sql, $array);
    }

    public function checkingToken($id)
    {

        if ($id == null || $id == 0) {
            header('Location: index.php?err=7');
        }
        $sql = "select Token from Utilisateur where id=:id";
        $array = array(
            ":id" => $id
        );

        return Spdo::getInstance()->query($sql, $array);
    }

    public function DesactiveSession($id)
    {
        if ($id == null || $id == 0) {
            header('Location: index.php?err=7');
        }

        $sql = "update Utilisateur set Token=:token where id=:id";
        $array = array(
            ":token" => null,
            ":id"    => $id
        );

        return Spdo::getInstance()->query($sql, $array);
    }


}


?>