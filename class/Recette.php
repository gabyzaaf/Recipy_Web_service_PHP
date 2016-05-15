<?php

ini_set('display_errors', 1);
require_once("pdo.php");

/**
 * Class Recette
 */
class Recette
{

    private $id;
    private $autreId;
    private $titre;
    private $contenu;
    private $image;
    private $visible;
    private $partage;
    private $type;
    private $fid;

    /**
     * Recette constructor.
     *
     * @param null $id
     * @param null $titre
     * @param null $contenu
     * @param null $image
     * @param null $visible
     * @param null $partage
     * @param null $type
     * @param null $fid
     */
    public function __construct($id = null, $titre = null, $contenu = null, $image = null, $visible = null, $partage = null, $type = null, $fid = null)
    {
        $this->id = $id;
        $this->titre = $titre;
        $this->contenu = $contenu;
        $this->image = $image;
        $this->visible = $visible;
        $this->partage = $partage;
        $this->type = $type;
        $this->fid = $fid;

    }

    /**
     * @param $idUtilisateur
     *
     * @return array|bool|string
     */
    public function creation($idUtilisateur)
    {
        $sql = "insert into Recette(title,contenu,image_lien,visible,partage,fid) values (:title,:contenu,:image_lien,:visible,:partage,:fid)";
        $array = array(
            ":title"      => $this->titre,
            ":contenu"    => $this->contenu,
            ":image_lien" => $this->image,
            ":visible"    => $this->visible,
            ":partage"    => $this->partage,
            ":fid"        => $idUtilisateur
        );

        return Spdo::getInstance()->query($sql, $array);
    }

    /**
     * @param $idUtilisateur
     *
     * @return array|bool|string
     */
    public function getRecette($idUtilisateur)
    {
        if ($idUtilisateur == "" || $idUtilisateur == null || $idUtilisateur == 0) {

        }
        $sql = "select * from Recette where fid=:fid and visible = 1";
        $tabRecette = "";
        $array = array(
            ":fid" => $idUtilisateur
        );

        return Spdo::getInstance()->query($sql, $array);
    }

    /**
     * @param $title
     *
     * @return array|bool|string
     */
    public function getRecetteTitle($title)
    {
        $sql = "select * from Recette where title=:title and visible=1";
        $tabRecette = "";
        $array = array(
            ":title" => $title
        );

        return Spdo::getInstance()->query($sql, $array);
    }

    /**
     * @param $idRecette
     *
     * @return array|bool|string
     */
    public function visible($idRecette)
    {
        $sql = "update Recette set visible=0 where id=:id";
        $array = array(
            ":id" => $idRecette
        );

        return Spdo::getInstance()->query($sql, $array);
    }

    /**
     * @param $idRecette
     * @param $idUtilisateur
     * @param $title
     * @param $contenu
     *
     * @return array|bool|string
     */
    public function updateRecette($idRecette, $idUtilisateur, $title, $contenu)
    {
        $sql = "update Recette set title = :title, contenu = :contenu, image_lien = '', visible = 1, partage = 0, fid = :fid where id = :id;";
        $array = array(
            ":id"      => $idRecette,
            ":title"   => $title,
            ":contenu" => $contenu,
            ":fid"     => $idUtilisateur
        );

        return Spdo::getInstance()->query($sql, $array);
    }


    /**
     * @param $idRecette
     *
     * @return array|bool|string
     */
    public function deleteRecette($idRecette)
    {
        $sql = "delete from Recette where id = :id";
        $array = array(
            ":id" => $idRecette
        );

        return Spdo::getInstance()->query($sql, $array);
    }
}
