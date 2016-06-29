/**
 * Created by zaafranigabriel on 05/03/2016.
 */



    function mySubmitFunction(){
        var title = document.getElementsByName("title")[0].value;
        var content = document.getElementsByName("contenu")[0].value;
        if(title=="" || content==""){
            alert('erreur veuillez verifier vos données');
            return false;
        }else{
            alert('tout est verifié');
            return true;
        }
    }

    function stringCompare(val1,val2){
        for(var i = 0;i<val1.length;i++){
            if(val1.charAt(i) != val2.charAt(i)){
                return false;
            }
        }
        return true;
    }


/**
 * @return {boolean}
 */
function InscriptionValidation() {

    if (document.getElementsByName("name")[0].value == "" || document.getElementsByName("lastname")[0].value == "" || document.getElementsByName("login")[0].value == "" || document.getElementsByName("email")[0].value == "" || document.getElementsByName("email2")[0].value == "" || document.getElementsByName("born")[0].value == "" || document.getElementsByName("mdp")[0].value == "") {
        alert('Veuillez saisir tous les champs');
        return false;
    } else if (document.getElementsByName("email")[0].value.length != document.getElementsByName("email2")[0].value.length) {
        alert('vos mot de passe doivent etre identiques');
        return false;
    } else {
        if (!stringCompare(document.getElementsByName("email")[0].value, document.getElementsByName("email2")[0].value)) {
            alert('vos emails doivent etre identiques');
            return false;
        }

    }
    return true;
}









