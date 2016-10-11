<!DOCTYPE html>
<html lang="fr">
    <head>
        <title><?php if(isset($titre)) echo $titre; else echo "Gestion d'espaces de coworking - NF17"; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta charset="UTF-8" />
        <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    
    <body>
        <header>
            <nav class="navbar navbar-default navbar-static-top navbar-inverse">
                <div class="container">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Accueil</a></li>
                        <li><a href="espace_coworker.php<?php if(isset($_POST['login'])) echo '?login='.$_POST['login'];
                                                            else if(isset($_GET['login'])) echo '?login='.$_GET['login'];
                                                            else if(isset($login)) echo '?login='.$login;
                                                            ?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Espace Coworker</a></li>
                        <li><a href="espace_manager.php<?php if(isset($_POST['login'])) echo '?login='.$_POST['login'];
                                                            else if(isset($_GET['login'])) echo '?login='.$_GET['login'];
                                                            else if(isset($login)) echo '?login='.$login;
                                                            ?>"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Espace Manager</a></li>
                    </ul>
                </div>
            </nav>
        </header>
        
        <div class="container-fluid">