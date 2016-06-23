<?php

use \Symfony\Component\Validator\Mapping\ClassMetadata;
use \Symfony\Component\Validator\Constraints as Asserts;

require_once("Pdo.php");

class Recette
{

    private $id;
    private $titre;
    private $contenu;
    private $image;
    private $visible;
    private $partage;
    private $fid;

    /** @var \Symfony\Component\HttpFoundation\File\File */
    public $file = null;

    /**
     * Use to the validation data form
     *
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint(
            'titre',
            new Asserts\Length(
                [
                    'min'        => 2,
                    'max'        => 50,
                    'minMessage' => 'Your first name must be at least {{ limit }} characters long',
                    'maxMessage' => 'Your first name cannot be longer than {{ limit }} characters',
                ]
            ))
            ->addPropertyConstraint('image', new Asserts\File(
                [
                    'maxSize'          => '5M',
                    'mimeTypes'        => ['image/jpeg', 'image/gif', 'image/png', 'image/tiff'],
                    'mimeTypesMessage' => 'Please upload a valid Image'
                ]
            ));
    }

    /**
     * @return bool
     */
    public function exist()
    {
        $sql = "SELECT * FROM recette
        WHERE title =:title AND fid = :fid ;";
        $array = array(
            ":title" => $this->getTitre(),
            ":fid"   => $this->getFid()
        );

        return !!Spdo::getInstance()->query($sql, $array);
    }

    public function add()
    {
        $sql = "INSERT INTO recette(title, contenu, image_lien, visible, fid) 
                VALUES (:title, :contenu, :image_lien, :visible, :fid)";
        $array = array(
            ":title"      => $this->getTitre(),
            ":contenu"    => $this->getContenu(),
            ":image_lien" => $this->getImage(),
            ":visible"    => $this->getVisible() ? 1 : 0,
            ":fid"        => $this->getFid()
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

    /**
     * @return array|bool|string
     */
    public function update()
    {
        $sql = "UPDATE recette 
          SET title = :title,
            contenu = :contenu,
            image_lien = :image, 
            visible = :visible,
            fid = :fid 
          WHERE id = :id;";

        $array = array(
            ":id"      => $this->getId(),
            ":title"   => $this->getTitre(),
            ":contenu" => $this->getContenu(),
            ":image"   => $this->getImage(),
            ":visible" => $this->getVisible(),
            ":fid"     => $this->getFid()
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

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param mixed $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * @return mixed
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * @param mixed $contenu
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return sprintf('http://lorempicsum.com/futurama/350/200/%d', srand(9) + 1);
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * @param mixed $visible
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
    }

    /**
     * @return mixed
     */
    public function getPartage()
    {
        return $this->partage;
    }

    /**
     * @param mixed $partage
     */
    public function setPartage($partage)
    {
        $this->partage = $partage;
    }

    /**
     * @return mixed
     */
    public function getFid()
    {
        return $this->fid <= 0 ? $_SESSION['_sf2_attributes']['user']['id'] : $this->fid;
    }

    /**
     * @param mixed $fid
     */
    public function setFid($fid)
    {
        $this->fid = $fid;
    }

}
