<?php

ini_set('display_errors', 1);
require_once("pdo.php");

class Recette
{

    private $id;
    private $titre;
    private $contenu;
    private $image;
    private $visible;
    private $partage;
    private $fid;

    public function creation($idUtilisateur)
    {
        $sql = "insert into recette(title,contenu,image_lien,visible,partage,fid) values (:title,:contenu,:image_lien,:visible,:partage,:fid)";
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
     * Return all recipies by id user
     *
     * @param $idUtilisateur
     *
     * @return array|bool|string
     */
    public function findByUserId(int $idUtilisateur) : array
    {
        $sql = "SELECT * FROM recette WHERE fid = :fid;";
        $params = array(
            ":fid" => $idUtilisateur
        );

        return Spdo::getInstance()->query($sql, $params);
    }

    public function getRecette($idUtilisateur)
    {
        $sql = "select * from recette where fid=:fid and visible=1";
        $tabRecette = "";
        $array = array(
            ":fid" => $idUtilisateur
        );

        return Spdo::getInstance()->query($sql, $array);
    }

    public function getRecetteTitle($title)
    {
        $sql = "select * from recette where title=:title and visible=1";
        $tabRecette = "";
        $array = array(
            ":title" => $title
        );

        return Spdo::getInstance()->query($sql, $array);
    }

    public function visible($idRecette)
    {
        $sql = "update recette set visible=0 where id=:id";
        $array = array(
            ":id" => $idRecette
        );

        return Spdo::getInstance()->query($sql, $array);
    }

    public function updateRecette($idRecette, $idUtilisateur, $title, $contenu)
    {
        $sql = "update recette set title = :title, contenu = :contenu, image_lien = '', visible = 1, partage = 0, fid = :fid where id = :id;";
        $array = array(
            ":id"      => $idRecette,
            ":title"   => $title,
            ":contenu" => $contenu,
            ":fid"     => $idUtilisateur
        );

        return Spdo::getInstance()->query($sql, $array);
    }


    public function deleteRecette($idRecette)
    {
        $sql = "delete from recette where id = :id";
        $array = array(
            ":id" => $idRecette
        );

        return Spdo::getInstance()->query($sql, $array);
    }
}
