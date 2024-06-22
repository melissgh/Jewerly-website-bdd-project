<?php
include 'connexionDB.php';


function getCommentsByArticleId($id = null)
{
    global $nom_base_de_donnee;
    if (!empty($id)) {
        $sql = "SELECT commentaire.*, client.prenom_client AS client_prenom, client.email_client AS client_email
                FROM $nom_base_de_donnee.commentaire 
                INNER JOIN $nom_base_de_donnee.client 
                ON commentaire.id_client = client.id_client 
                WHERE id_article=?";

        $req = $GLOBALS['connexion']->prepare($sql);

        $req->execute(array($id));

        return $req->fetchAll(); // Renvoie tous les commentaires avec les informations du client
    }
}
