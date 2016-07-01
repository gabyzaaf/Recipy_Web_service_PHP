<?php

namespace Recipy\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Recipy\Db\SPdo;

class Utilisateur extends AbstractEntity implements UserInterface
{

    protected $id = 0;
    protected $nom = '';
    protected $prenom = '';
    protected $email = '';
    protected $logins = '';
    protected $admin = false;
    protected $naissance;
    protected $mdp = '';
    protected $actif = false;
    protected $token = '';
    protected $remember = false;

    public function __construct()
    {
        $this->naissance = new \DateTime();
    }

    /**
     * @return bool
     */
    public function loadCurrentUser() : bool
    {
        if (!isset($_SESSION['_sf2_attributes']['user']))
            return false;
        $user = $_SESSION['_sf2_attributes']['user'];

        if (!$user['id'] && !$user['token']) {
            return false;
        }

        $user = $this->findByIdAndToken($user['id'], $user['token']);

        if (!$user) {
            return false;
        }

        $this->id = $user['id'];
        $this->nom = $user['nom'];
        $this->prenom = $user['prenom'];
        $this->email = $user['email'];
        $this->naissance = new \DateTime($user['naissance']);
        $this->logins = $user['logins'];
        $this->admin = $user['admin'];
        $this->actif = $user['actif'];
        $this->token = $user['token'];

        return true;
    }

    /**
     * @return array|bool|string
     */
    public function findByIdAndToken()
    {
        $sql = "SELECT * FROM utilisateur WHERE id = :id AND token = :token";
        $array = array(
            ":id"    => $this->getId(),
            ":token" => $this->getToken()
        );

        $datas = Spdo::getInstance()->query($sql, $array);
        if (empty($datas))
            return false;

        $user = reset($datas);

        return $user;
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

        if ($naissance instanceof \DateTime) {
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

    /**
     * @return array|bool|string
     */
    public function saveToken()
    {
        $sql = "UPDATE utilisateur 
                SET token = :token
                WHERE logins = :logins AND pwd = MD5(:mdp);";

        $array = array(
            ":token"  => $this->getToken(),
            ":logins" => $this->getLogins(),
            ":mdp"    => $this->getMdp()
        );

        return SPdo::getInstance()->query($sql, $array);
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

        return SPdo::getInstance()->query($sql, $array);
    }

    /**
     * return false if user already exist
     * @return array|bool|string
     */
    public function createUser()
    {
        if ($this->exist())
            return false;
        $sql = "insert into utilisateur (nom,prenom,logins,email,naissance,pwd) values (:nom,:prenom,:logins,:email,:naissance,MD5(:pwd))";
        $array = array(
            ":nom"       => $this->getNom(),
            ":prenom"    => $this->getPrenom(),
            ":logins"    => $this->getLogins(),
            ":email"     => $this->getEmail(),
            ":naissance" => date('Y-m-d', $this->getNaissance()->getTimestamp()),
            ":pwd"       => $this->getMdp()
        );

        return SPdo::getInstance()->query($sql, $array);
    }

    /**
     * @param bool $withPass
     *
     * @return array|bool|string
     */
    public function exist($withPass = false)
    {
        if ($this->getLogins() === null || ($withPass && $this->getMdp() === null))
            return false;

        $sql = "SELECT * FROM utilisateur WHERE logins = :logins ";
        $query_params = [':logins' => $this->logins];

        if ($withPass) {
            $sql .= " AND pwd = MD5(:pwd)";
            $query_params = $query_params + [':pwd' => $this->getMdp()];
        }

        return !!SPdo::getInstance()->query($sql, $query_params);
    }

    /*
    public function exist(array $params = array())
    {
        $sql = "SELECT * FROM utilisateur WHERE ";
        $query_params = [];
        $and = false;
        foreach ($this as $attribute) {
            if (key_exists($attribute, $params)) {
                if ($and) {
                    $sql .= " AND ";
                }
                $sql .= $attribute . " = :" . $attribute;
                $query_params[":" . $attribute] = $params[$attribute];
                $and = true;
            }
        }

        return SPdo::getInstance()->query($sql, $query_params);
    }
*/

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

        return SPdo::getInstance()->query($sql, $array);
    }

    /**
     * @return Utilisateur $this
     */
    public function loadUser()
    {

        $sql = "SELECT * FROM utilisateur WHERE logins=:logins AND pwd=MD5(:mdp) LIMIT 1";
        $array = array(
            ":logins" => $this->logins,
            ":mdp"    => $this->mdp
        );
        $datas = SPdo::getInstance()->query($sql, $array);

        if (!empty($datas))
            foreach (current($datas) as $attribute => $value) {
                if ($attribute == 'pwd')
                    $attribute = 'mdp';
                $this[$attribute] = $value;
            }

        return $this;
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

        return SPdo::getInstance()->query($sql, $array);
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

        return SPdo::getInstance()->query($sql, $array);
    }

    /**
     * @return string
     */
    public function getToken() :string
    {
        return $this->token;
    }

    /**
     * @param string $token
     *
     * @return Utilisateur
     */
    public function setToken($token)
    {
        if (!is_string($token))
            $token = '';
        $this->token = $token;

        return $this;
    }

    /**
     * @param $id
     *
     * @return bool
     */
    public function updateToken(int $id = null) :bool
    {
        if ($id === null) {
            if ($this->getId()) {
                $id = $this->getId();
            } else {
                return false;
            }
        }

        $sql = 'UPDATE utilisateur SET token=:token WHERE id=:id ;';
        $array = array(
            ":token" => $this->token,
            ":id"    => $id
        );

        return !!SPdo::getInstance()->query($sql, $array);
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

        return SPdo::getInstance()->query($sql, $array);
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

        return SPdo::getInstance()->query($sql, $array);
    }

    /**
     * Return a int
     * @return int|bool
     */
    public function getId()
    {
        return ($this->id > 0) ? $this->id : false;
    }

    /**
     * @return string
     */
    public function getNom() :string
    {
        return $this->nom;
    }

    /**
     * @return string
     */
    public function getPrenom() : string
    {
        return $this->prenom;
    }

    /**
     * @return string
     */
    public function getEmail() :string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getLogins():string
    {
        return $this->logins;
    }

    /**
     * @return bool
     */
    public function getAdmin() :bool
    {
        return !!$this->admin;
    }

    /**
     * @return \DateTime
     */
    public function getNaissance() : \DateTime
    {
        return $this->naissance;
    }

    /**
     * @return bool
     */
    public function getActif() : bool
    {
        return !!$this->actif;
    }

    /**
     * @param string $nom
     *
     * @return Utilisateur
     */
    public function setNom(string $nom) : Utilisateur
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @param string $prenom
     *
     * @return Utilisateur
     */
    public function setPrenom(string $prenom): Utilisateur
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * @param string $email
     *
     * @return Utilisateur
     */
    public function setEmail(string $email): Utilisateur
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param $naissance
     *
     * @return Utilisateur
     */
    public function setNaissance($naissance): Utilisateur
    {
        if (!$naissance instanceof \DateTime)
            $naissance = new \DateTime($naissance);
        $this->naissance = $naissance;

        return $this;
    }

    /**
     * @return null
     */
    public function getMdp()
    {
        return $this->mdp;
    }

    /**
     * @param string $mdp
     *
     * @return Utilisateur
     */
    public function setMdp(string $mdp): Utilisateur
    {
        $this->mdp = $mdp;

        return $this;
    }

    /**
     * @param string $logins
     *
     * @return Utilisateur
     */
    public function setLogins(string $logins): Utilisateur
    {
        $this->logins = $logins;

        return $this;
    }

    /**
     * @return bool
     */
    public function getRemember() :bool
    {
        return !!$this->remember;
    }

    /**
     * @param bool $remember
     *
     * @return Utilisateur
     */
    public function setRemember(bool $remember) : Utilisateur
    {
        $this->remember = $remember;

        return $this;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param boolean $admin
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;
    }

    /**
     * @param boolean $actif
     */
    public function setActif($actif)
    {
        $this->actif = $actif;
    }

    /********************************************************/

    public function getRoles()
    {
        $roles = ['ROLE_ANONYMOUS'];
        if ($this->id > 0) {
            $roles = array_merge($roles, ['ROLE_USER']);

            if ($this->getAdmin())
                $roles = array_merge($roles, ['ROLE_ADMIN']);
        }

        return $roles;
    }

    public function getPassword()
    {
        return $this->getMdp();
    }

    public function getSalt()
    {
        return;
    }

    public function getUsername()
    {
        return $this->getLogins();
    }

    public function eraseCredentials()
    {
        return;
    }
}
