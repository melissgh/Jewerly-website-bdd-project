<?php
include 'connexionDB.php';

function isFavori($articleId)
{
    global $nom_base_de_donnee;
    if (isset($_SESSION['user_id'])) {
        $idClient = $_SESSION['user_id'];
        $sql = "SELECT COUNT(*) AS count FROM $nom_base_de_donnee.favoris WHERE id_client = ? AND id_article = ?";
        $req = $GLOBALS['connexion']->prepare($sql);
        $req->execute([$idClient, $articleId]);
        $result = $req->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0; // Renvoie true si l'article est favori, sinon false
    }
    return false;
}
