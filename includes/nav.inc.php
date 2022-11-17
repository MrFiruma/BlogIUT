<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="index.php">THE Article</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="recherche.php">Recherche</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Menu</a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <?php if (isset($_COOKIE["sid"])) { ?>
                                    <li><a class="dropdown-item" href="articles.php">Ajouter un article</a></li>
                                    <li><a class="dropdown-item" href="deconnect.php">Se deconnecter</a></li>
                                <?php }else { ?>
                                    <li><a class="dropdown-item" href="connect.php">Se connecter</a></li>
                                    <li><a class="dropdown-item" href="utilisateurs.php">S'inscrire</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>