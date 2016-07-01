
<?php 
ini_set('display_errors', 1);
require_once("utilisateur.php");
require_once("Recette.php");
require_once("Favoris.php");
require_once("Noter.php");
require_once("Commenter.php");
$obj = new utilisateur(NULL,"zaafrani","gabriel","gabESGI","gabriel.zaafrani@gmail.com",1,"1990/09/29","gaby",NULL,0);
$arrayTab = $obj->ajoutStorage();

$tab = $obj->getUtilisateur();

$recette = new Recette();
$list = $recette->getRecette($tab[0]["id"]);
$Noter = new Noter(NULL,100,$tab[0]["id"],$list[0]["id"]);
//$Noter->ajout();
$Comment = new Commenter(NULL,$list[0]["id"],$tab[0]["id"],NULL,"CECI EST UNE BONNE RECETTE");
/*
if($Comment->ajout()){
    echo "Le commentaire a ete rajouté";
}else{
    echo "Le commentaire n'a pu etre rajouté";
}
*/


if($Comment->supprimerUtilisateur()==true){
    echo "Le commentaire a ete supprimé";
}else{
    echo "Le commentaire n'a pas ete supprime";
}

?>
