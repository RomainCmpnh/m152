<?php 
include 'db\func.php';
session_start();            
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
    <div></div>
    <div class="container">
        <h1 class="my-4">Bienvenu sur le super Blog !&nbsp;</h1>
        <div class="row">
            <div class="col-md-8" style="width: 750px;padding: 17px;font-size: 23px;min-width: 33%;max-width: 30%;">
            <?php
									$posts = getAllPosts();
									$media = getAllMedias();
									$total = count($posts);
									$totalMedias = count($media);


									for ($i = 0; $i < $total; $i++) {
										echo $posts[$i]["commentaire"];
										echo "<td><a href='deletePost.php?id=" . $posts[$i]["idPost"] . "'> <button class='btn btn-primary btn-sm'>Delete</button></a> 
										<a href='updatePost.php?id=" . $posts[$i]["idPost"] . "'> <button class='btn btn-primary btn-sm'>Update</button></a>";
										echo '</b></p></td></tr>';
										echo '<div class="panel-thumbnail">';
										for ($j = 0; $j < $totalMedias; $j++) {
											if ($posts[$i]["idPost"] == $media[$j]["idPost"]) {
												echo "<tr><td>";									
													echo '<div class="input-group">
														<div class="input-group-btn">'
														. '<img src="uploaded_files/'. $media[$j]["nomMedia"] . '" width="350">'  .
														'</div></td>';
						

												echo "</tr>";
											}
											echo '</div>';
										}

										echo '</div>

								</div>';
									}

									?>
            
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>