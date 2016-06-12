<?php
ini_set('display_errors', 1);
require_once("Pdo.php");

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

    /**
     * @return bool
     */
    public function loadCurrentUser() : bool
    {
        if (!isset($_SESSION['user']['id']) || !isset($_SESSION['user']['token']))
            return false;

        $users = $this->getCurrentUser($_SESSION['user']['id'], $_SESSION['user']['token']);

        if (empty($users))
            return false;

        $user = reset($users);

        $this->id = $user['id'];
        $this->nom = $user['nom'];
        $this->prenom = $user['prenom'];
        $this->email = $user['email'];
        $this->naissance = new DateTime($user['naissance']);
        $this->logins = $user['logins'];
        $this->admin = $user['admin'];
        $this->actif = $user['actif'];
        $this->token = $user['token'];

        return true;
    }

    /**
     * @param int    $id
     * @param string $token
     *
     * @return Utilisateur
     */
    public function getCurrentUser(int $id, string $token)
    {
        $sql = "SELECT * FROM utilisateur WHERE id = :id AND token = :token";
        $array = array(
            ":id"    => $id,
            ":token" => $token
        );

        $dataUsers = Spdo::getInstance()->query($sql, $array);

        return $dataUsers;
    }

    /**
     * @return array|bool|string
     */
    public function saveProfile()
    {
        $sql = "UPDATE utilisateur 
                SET nom=:nom, prenom=:prenom, email=:email, naissance = :naissance 
                WHERE id = :id AND token = :token;";

        $naissance = $this->naissance;

        if ($naissance instanceof DateTime) {
            $naissance = $naissance->format('Y-m-d');
        }

        $array = array(
            ":id"        => $this->id,
            ":token"     => $this->token,
            ":nom"       => $this->nom,
            ":prenom"    => $this->prenom,
            ":email"     => $this->email,
            ":naissance" => $naissance
        );

        return Spdo::getInstance()->query($sql, $array);
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
        $sql = "insert into utilisateur (nom,prenom,logins,email,naissance,pwd) values (:nom,:prenom,:logins,:email,:naissance,MD5(:pwd))";
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
        $sql = "select count(*) as 'nb' from utilisateur where logins=:logins and email=:email";
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
        $sql = "select id,nom,prenom from utilisateur where logins=:logins and email=:email and pwd=MD5(:mdp) and actif=0";
        $array = array(
            ":logins" => $this->logins,
            ":email"  => $this->email,
            ":mdp"    => $this->mdp
        );

        return Spdo::getInstance()->query($sql, $array);
    }

    public function getConnexion()
    {
        $sql = "select * from utilisateur where logins=:logins and pwd=MD5(:mdp)";
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
        $sql = "update utilisateur set nom=:nom,prenom=:prenom,email=:email where logins=:logins";
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
        $sql = "update utilisateur set actif=1 where id=:id";
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
            unset($_SESSION['user']);
            header('Location: index.php?err=7');
        }
        if ($this->token == null) {
            unset($_SESSION['user']);
            header('Location: index.php?err=8');
        }

        $sql = "update utilisateur set token=:token where id=:id";
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
        $sql = "select token from utilisateur where id=:id";
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

        $sql = "update utilisateur set token=:token where id=:id";
        $array = array(
            ":token" => null,
            ":id"    => $id
        );

        return Spdo::getInstance()->query($sql, $array);
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @return null
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @return null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return null
     */
    public function getLogins()
    {
        return $this->logins;
    }

    /**
     * @return null
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * @return null
     */
    public function getNaissance()
    {
        return $this->naissance;
    }

    /**
     * @return null
     */
    public function getActif()
    {
        return $this->actif;
    }

    /**
     * @param null $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @param null $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @param null $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param null $naissance
     */
    public function setNaissance($naissance)
    {
        $this->naissance = $naissance;
    }

    /**
     * @return null
     */
    public function getMdp()
    {
        return $this->mdp;
    }

    /**
     * @param null $mdp
     */
    public function setMdp($mdp)
    {
        $this->mdp = $mdp;
    }

    /**
     * @param null $logins
     */
    public function setLogins($logins)
    {
        $this->logins = $logins;
    }


}
