<?php
ini_set('display_errors', 1);
require_once("pdo.php");
/**
 * Created by PhpStorm.
 * User: zaafranigabriel
 * Date: 01/03/2016
 * Time: 21:23
 */
class Noter
{

    private $id;
    private $score;
    private $fidUtilisateur;
    private $fidRecette;

    /**
     * Noter constructor.
     * @param $id
     * @param $score
     * @param $fidUtilisateur
     * @param $fidRecette
     */
    public function __construct($id=NULL, $score=NULL, $fidUtilisateur=NULL, $fidRecette=NULL)
    {
        $this->id = $id;
        $this->score = $score;
        $this->fidUtilisateur = $fidUtilisateur;
        $this->fidRecette = $fidRecette;
    }

    public function ajout(){
        $variable = $this->exist();
        if($this->score>=0 && $this->score<=10 && $variable[0]['nb']==0){
            $sql = "insert into noter (score,fidUtilisateur,fidRecette) values(:score,:fidUtilisateur,:fidRecette)";
            $array = array(
                ":score" => $this->score,
                ":fidUtilisateur"=>$this->fidUtilisateur,
                ":fidRecette"=>$this->fidRecette
            );
            return Spdo::getInstance()->query($sql,$array);
        }else{
            echo "votre score doit etre entre 0 et 10  ou vous avez deja poste une note";
        }

    }

    private function exist(){
        if($this->fidRecette==0 || $this->fidRecette==NULL || $this->fidUtilisateur==0 || $this->fidUtilisateur==NULL){
            echo "Erreur vos identification de recette sont null";
        }
        $sql = "select count(*) as nb from noter where fidUtilisateur=:fidU AND fidRecette=:fidR";
        $array = array(
            ":fidU" => $this->fidUtilisateur,
            ":fidR" => $this->fidRecette
        );
        return Spdo::getInstance()->query($sql,$array);
    }

    public function modification(){
        $variable = $this->exist();
        if($this->score>=0 && $this->score<=10 && $variable[0]['nb']==1){

            $sql = "update noter set score=:note where fidUtilisateur=:fidU AND fidRecette=:fidR";
            $array = array(
                ":note" => $this->score,
                ":fidU" => $this->fidUtilisateur,
                ":fidR" => $this->fidRecette
            );
            var_dump($array);
            return Spdo::getInstance()->query($sql,$array);
        }else{

            echo "votre score doit etre entre 0 et 10";
        }
    }

    public function suppression()
    {
        $variable = $this->exist();
        var_dump($variable);
        if ($this->score >= 0 && $this->score <= 10  && $variable[0]['nb']==1) {
            $sql = "delete from noter where fidUtilisateur=:fidU AND fidRecette=:fidR";
            $array = array(
                ":fidU" => $this->fidUtilisateur,
                ":fidR" => $this->fidRecette
            );
            return Spdo::getInstance()->query($sql, $array);
        } else {
            echo "votre score doit etre entre 0 et 10";
        }
    }





}


?>