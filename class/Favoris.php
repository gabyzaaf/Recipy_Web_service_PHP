<?php
ini_set('display_errors', 1);
require_once("Pdo.php");

class Favoris
{

    private $id;
    private $fidUtilisateur;
    private $fidRecette;

    public function __construct($id = null, $fidUtilisateur = null, $fidRecette = null)
    {
        $this->id = $id;
        $this->fidUtilisateur = $fidUtilisateur;
        $this->fidRecette = $fidRecette;
    }

    private function exists()
    {
        $sql = "select count(*) as 'nb' from favoris where fidRecette=:fidR";
        $array = array(
            ":fidR" => $this->fidRecette
        );

        return Spdo::getInstance()->query($sql, $array);
    }

    public function ajout()
    {
        $tab = $this->exists();
        if ($tab[0]['nb'] != 0) {
            return "exist";
        }
        $sql = "insert into favoris (fidUtilisateur,fidRecette) values (:fidU,:fidR)";
        $array = array(
            ":fidU" => $this->fidUtilisateur,
            ":fidR" => $this->fidRecette
        );

        return Spdo::getInstance()->query($sql, $array);
    }

    /*
        ERR1 : id favoris n'existe pas
    */

    public function supprimer($idFavoris)
    {
        $sql = "select count(*) as 'nb' from favoris where id=:id";
        $array = array(
            ":id" => $idFavoris
        );
        $val = Spdo::getInstance()->query($sql, $array);
        if ($val[0]["nb"] == 0) {
            return "ERR1";
        }
        $sql = "delete from favoris where id=:id";
        $array = array(
            ":id" => $idFavoris
        );

        return Spdo::getInstance()->query($sql, $array);
    }


}
