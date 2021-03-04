<?php
include 'db\func.php';
session_start();
 
$MAX_FILE_SIZE = 3145728;    // 3MB in bytes
$MAX_POST_SIZE = 73400320;  // 70MB in bytes
$error = "";
$message = ''; 
if (isset($_POST['btnPost']) && $_POST['btnPost'] == 'SendPost')
{
    $text = filter_input(INPUT_POST,"message",FILTER_SANITIZE_STRING);
    $last = InsertPost($text,date("Y-m-d"));
    if(isset($_FILES) && is_array($_FILES) && count($_FILES)>0) {
        foreach ($_FILES['img']['size'] as $key => $value) {
            if ($value > $MAX_FILE_SIZE ) {
                $error = 'File too heavy.';
            } else {
                $size_total += $value;
   
        // Raccourci d'écriture pour le tableau reçu
        $fichiers = $_FILES['img'];
        // Boucle itérant sur chacun des fichiers
        for($i=0;$i<count($fichiers['name']);$i++){

        // Action pour avoir un nom unique et cité les personnes qui upload plusieur fois le meme nom de fichier
        $nom_fichier = $fichiers['name'][$i];
        $nomFichierExplode = explode(".", $nom_fichier);
        $newNomFichier = md5(time() . $nom_fichier) . '.' . strtolower(end($nomFichierExplode));


        // Déplacement depuis le répertoire temporaire et vérification coté serveur
        if (move_uploaded_file($fichiers['tmp_name'][$i],'uploaded_files/'.$newNomFichier)){
        InsertMedia(end($nomFichierExplode),$newNomFichier,date("Y-m-d"), $last);
        }
        
        }
        header('Location: index.php');
    }
    }
    
    } 
}

$_SESSION['message'] = $message;


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
</head>

<body>
    <nav class="navbar navbar-dark navbar-expand-md" id="app-navbar">
        <div class="container-fluid"><a class="navbar-brand" href="#"><i class="icon ion-ios-infinite" id="brand-logo"></i></a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <div class="float-left float-md-right mt-5 mt-md-0 search-area"><i class="fas fa-search float-left search-icon"></i><input class="float-left float-sm-right custom-search-input" type="search" placeholder="Type to filter by address" style="width: 293px;margin-left: -4px;"></div>
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link active" href="index.php">HOME</a></li>
                    <li class="nav-item"><a class="nav-link" href="post.php">POST</a></li>
                    <li class="nav-item"></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="contact-clean" style="background: rgb(255,255,255);">
        <form method="post" style="background: rgb(232,228,228);width: 50%;min-width: -7px;max-width: 632px;min-height: 5px;max-height: -42px;padding: 17px;" enctype="multipart/form-data">
        <input type="hidden" name="maxValue" value="7000000"/>
            <h2 class="text-center"></h2>
            <div class="form-group"><small class="form-text text-danger"></small></div>
            <div class="form-group"><textarea class="form-control" name="message" placeholder="Message" rows="14"></textarea></div>
            <div class="form-group">
            <button class="btn btn-primary" type="submit" name="btnPost" value="SendPost">Publish</button>
            <input type="file" accept="image/png, image/jpeg" name="img[]" multiple/>
            
            </div>
            <h1> <?= $error ?></h1>
        </form>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>