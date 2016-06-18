<?php
require_once("Pdo.php");


class Commenter
{

    private $id;
    private $heure_saisie;
    private $fidUtilisateur;
    private $fidRecette;
    private $contenu;

    /**
     * Commenter constructor.
     *
     * @param $id
     * @param $fidRecette
     * @param $fidUtilisateur
     * @param $heure_saisie
     * @param $contenu
     */
    public function __construct($id = null, $fidRecette = null, $fidUtilisateur = null, $heure_saisie = null, $contenu = null)
    {
        $this->id = $id;
        $this->fidRecette = $fidRecette;
        $this->fidUtilisateur = $fidUtilisateur;
        $this->heure_saisie = $heure_saisie;
        $this->contenu = $contenu;
    }


    public function ajout()
    {
        if ($this->fidUtilisateur == 0 || $this->fidUtilisateur == null || $this->fidRecette == 0 || $this->fidRecette == null) {
            return "Erreur vos idUtilisateur ou idRecette est faux";
        }
        $sql = "insert into commenter (heure_saisie,fidUtilisateur,fidRecette,contenu) values (NOW(),:fidUtilisateur,:fidRecette,:contenu)";
        $array = array(
            ":contenu"        => $this->contenu,
            ":fidUtilisateur" => $this->fidUtilisateur,
            ":fidRecette"     => $this->fidRecette
        );

        return Spdo::getInstance()->query($sql, $array);
    }

    public function supprimerRecette()
    {
        if ($this->fidRecette == 0 || $this->fidRecette == null || $this->fidRecette == "") {
            return "L'identifiant de votre recette n'est pas conforme";
        }
        $sql = "delete from commenter where fidRecette=:fidRecette";
        $array = array(
            ":fidRecette" => $this->fidRecette
        );

        return Spdo::getInstance()->query($sql, $array);
    }

    public function supprimerUtilisateur()
    {
        if ($this->fidUtilisateur == 0 || $this->fidUtilisateur == null || $this->fidUtilisateur == "") {
            return "L'identifiant de votre Utilisateur n'est pas conforme";
        }
        $sql = "delete from commenter where fidUtilisateur=:fidUtilisateur";
        $array = array(
            ":fidUtilisateur" => $this->fidUtilisateur
        );

        return Spdo::getInstance()->query($sql, $array);
    }

}
