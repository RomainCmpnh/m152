<?php
include "connect.php";

function InsertPost($commentaire,$creationDate){
    $sql = "INSERT INTO `post`(`commentaire`,`creatonDate`,`modificationDate`)
    VALUES (:commentaire, :creatonDate, :modifDate)";

    $query = connect()->prepare($sql);

    $query->execute([
        ':commentaire' => $commentaire,
        ':creatonDate' => $creationDate,
        ':modifDate' => $creationDate,
    ]);

    $latest_id = connect()->lastInsertId();
    return $latest_id;
}


function InsertMedia($typeMedia, $nomMedia, $creationDate,$lastid)
{
    $sql = "INSERT INTO `media`(`typeMedia`,`nomMedia`,`creationDate`,`idPost`)
    VALUES (:typeMedia,:nomMedia ,:creationDate , $lastid)";
    $query = connect()->prepare($sql);
    $query->execute([
        ':typeMedia' => $typeMedia,
        ':nomMedia' => $nomMedia,
        ':creationDate' => $creationDate,
    ]);
}

function GetLastID(){
    return connect()->lastInsertID();
}

function getPost() {
    static $requete = null;
    $estOK = false;

    try {
        if ($requete == null) {
            $requete = connect()->prepare("SELECT * FROM `post`");
        }
        $estOK = $requete->execute();
    } catch (Exception $e) {
        $estOK = false;
    }
    if ($estOK)
        return $requete->fetchAll();
    else
        return $requete;
}