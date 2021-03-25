<?php
include "connect.php";

function InsertPost($commentaire,$creationDate){

   connect()->begin_transaction();

try {
    $sql = "INSERT INTO `post`(`commentaire`,`creatonDate`,`modificationDate`)
    VALUES (:commentaire, :creatonDate, :modifDate)";

    $query = Connect()->prepare($sql);

    $query->execute([
        ':commentaire' => $commentaire,
        ':creatonDate' => $creationDate,
        ':modifDate' => $creationDate,
    ]);
    
    $latest_id = Connect()->lastInsertId();
    return $latest_id;
    connect()->commit();
} 
    
    catch (mysqli_sql_exception $exception) {
        connect()->rollback();
    
        throw $exception;
    }
}


function InsertMedia($typeMedia, $nomMedia, $creationDate,$lastid)
{
    connect()->begin_transaction();

try {
    $sql = "INSERT INTO `media`(`typeMedia`,`nomMedia`,`creationDate`,`idPost`)
    VALUES (:typeMedia,:nomMedia ,:creationDate , $lastid)";
    $query = Connect()->prepare($sql);
    $query->execute([
        ':typeMedia' => $typeMedia,
        ':nomMedia' => $nomMedia,
        ':creationDate' => $creationDate,
    ]);

    connect()->commit();
} catch (mysqli_sql_exception $exception) {
    connect()->rollback();

    throw $exception;
}
}

function GetLastID(){
    return Connect()->lastInsertID();
}

function getPost() {
    static $requete = null;
    $estOK = false;

    try {
        if ($requete == null) {
            $requete = Connect()->prepare("SELECT * FROM `post`");
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

function getAllPosts()
{

    $db = connect();

    $sql = "SELECT * FROM post ORDER BY idPost DESC";
    $request = $db->prepare($sql);
    $request->execute();
    return $request->fetchAll(PDO::FETCH_ASSOC);
}

function getAllMedias()
{
    $db = connect();

    $sql = "SELECT * FROM media ORDER BY idPost DESC ";
    $request = $db->prepare($sql);
    $request->execute();
    return $request->fetchAll(PDO::FETCH_ASSOC);
}