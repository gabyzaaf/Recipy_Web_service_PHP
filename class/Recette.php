<?php

namespace Recipy\Entity;

use \Symfony\Component\Validator\Mapping\ClassMetadata;
use \Symfony\Component\Validator\Constraints as Asserts;
use Recipy\Db\SPdo;

/**
 * Class Recette
 * @package Recipy\Entity
 */
class Recette extends AbstractEntity
{

    protected $id;
    protected $title;
    protected $contenu;
    protected $image;
    protected $visible;
    protected $partage;
    protected $fid;

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
            'title',
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
     * @param $id
     *
     * @return $this
     */
    public function load($id)
    {
        $data = $this->find($id);

        if (empty($data))
            return $this;

        foreach (current($data) as $attribute => $value) {
            $this[$attribute] = $value;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function exist()
    {
        $sql = "SELECT * FROM recette
        WHERE title =:title AND fid = :fid ;";
        $array = array(
            ":title" => $this->getTitle(),
            ":fid"   => $this->getFid()
        );

        return !!SPdo::getInstance()->query($sql, $array);
    }

    /**
     * @return array|bool|string
     */
    public function add()
    {
        $sql = "INSERT INTO recette(title, contenu, image_lien, visible, fid) 
                VALUES (:title, :contenu, :image_lien, :visible, :fid)";
        $array = array(
            ":title"      => $this->getTitle(),
            ":contenu"    => $this->getContenu(),
            ":image_lien" => $this->getImage(),
            ":visible"    => $this->getVisible() ? 1 : 0,
            ":fid"        => $this->getFid()
        );

        return SPdo::getInstance()->query($sql, $array);
    }

    /**
     * @return array|bool|string
     */
    public function save()
    {
        $sql = "UPDATE recette 
                SET title = :title, contenu = :contenu, image_lien = :image_lien, 
                visible = :visible, fid = :fid 
                WHERE id = :id";
        $array = array(
            ":id"         => $this->getId(),
            ":title"      => $this->getTitle(),
            ":contenu"    => $this->getContenu(),
            ":image_lien" => $this->getImage(),
            ":visible"    => $this->getVisible() ? 1 : 0,
            ":fid"        => $this->getFid()
        );

        return SPdo::getInstance()->query($sql, $array);
    }

    /**
     * @param int    $uid
     * @param string $title
     *
     * @return Recette
     */
    public function findByUserIdAndTitle(int $uid, string $title) : Recette
    {
        $this->query = "SELECT SQL_CALC_FOUND_ROWS * FROM recette WHERE fid = :fid AND title LIKE :title";
        $this->setParams([
            ':fid'   => $uid,
            ':title' => '%' . $title . '%'
        ]);

        return $this;
    }

    /**
     * Return all recipes by id user
     *
     * @param int $uid
     *
     * @return Recette
     */
    public function findByUserId(int $uid) : Recette
    {
        $this->query = "SELECT  SQL_CALC_FOUND_ROWS * FROM recette WHERE fid = :fid";
        $this->setParams([
            ":fid" => $uid
        ]);

        return $this;
    }

    /**
     * @param $id
     *
     * @return array|bool|string
     */
    public function find($id) : array
    {
        $sql = "SELECT * FROM recette WHERE id=:id LIMIT 1 ;";

        $array = array(
            ":id" => $id
        );

        return SPdo::getInstance()->query($sql, $array);
    }

    /**
     * @param bool $isVisible
     *
     * @return Recette
     */
    public function findByVisibility($isVisible = true) : Recette
    {
        $this->query = "SELECT SQL_CALC_FOUND_ROWS * FROM recette WHERE visible = :visible";
        $this->setParams(array(
            ":visible" => !!$isVisible
        ));

        return $this;
    }

    public function findByVisibilityAndTitle($title, $isVisible = true) : Recette
    {
        $this->query = "SELECT SQL_CALC_FOUND_ROWS * FROM recette WHERE title LIKE :title AND visible = :visible";
        $this->setParams(array(
            ":visible" => !!$isVisible,
            ":title" => '%' . $title . '%'
        ));
        
        return $this;
    }

    public function getRecette($idUtilisateur)
    {
        $sql = "select * from recette where fid=:fid and visible=1";

        $array = array(
            ":fid" => $idUtilisateur
        );

        return SPdo::getInstance()->query($sql, $array);
    }

    /**
     * @param $title
     *
     * @return array|bool|string
     */
    public function findByTitle($title)
    {
        $sql = "SELECT * FROM recette WHERE title LIKE :title AND visible=1";

        $array = array(
            ":title" => '%' . $title . '%'
        );

        return SPdo::getInstance()->query($sql, $array);
    }

    public function visible($idRecette)
    {
        $sql = "update recette set visible=0 where id=:id";
        $array = array(
            ":id" => $idRecette
        );

        return SPdo::getInstance()->query($sql, $array);
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
            ":title"   => $this->getTitle(),
            ":contenu" => $this->getContenu(),
            ":image"   => $this->getImage(),
            ":visible" => $this->getVisible(),
            ":fid"     => $this->getFid()
        );

        return SPdo::getInstance()->query($sql, $array);
    }


    public function deleteRecette($idRecette)
    {
        $sql = "delete from recette where id = :id";
        $array = array(
            ":id" => $idRecette
        );

        return SPdo::getInstance()->query($sql, $array);
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
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
        return ($this->visible == true);
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

    public function getCurrentOwn()
    {
        return $this->fid;
    }

    /**
     * @param mixed $fid
     */
    public function setFid($fid)
    {
        $this->fid = $fid;
    }

}
