<?php
include 'connexionDB.php';


function getFavorisByClientId($id = null)
{
    global $nom_base_de_donnee;
    if (!empty($id)) {
        $sql = "SELECT article.*
                FROM $nom_base_de_donnee.article 
                INNER JOIN $nom_base_de_donnee.favoris 
                ON favoris.id_article = article.id_article 
                WHERE id_client=?";

        $req = $GLOBALS['connexion']->prepare($sql);

        $req->execute(array($id));

        return $req->fetchAll(); // Renvoie tous les commentaires avec les informations du client
    }
}
