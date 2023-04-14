<?php
session_start();
?>
<html>
    <head>
        <title>perfil</title>
        <link rel="stylesheet" type="text/css" href="estilsPerfil.css">
    </head>
    <body>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">LOGO</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="menu.php">Menu</a>
        <a class="nav-link active" href="equip.php">Equip</a>
        <!--a class="nav-link" href="#">Pricing</a>
        <a class="nav-link disabled">Disabled</a>
        <a class="nav-link disabled">Disabled</a>-->
        <a class="nav-link active" href="buscar.php">Buscar</a>
        <a class="nav-link active" href="partides.php">Partides</a>
        <a class="nav-link active" href="perfil.php">Perfil</a>
      </div>
    </div>
  </div>
</nav>
<div class="perfil-container">
    
   
    
		<div class="perfil-header">
                    

			<h2>Configuració d'usuari</h2>
			<a href="tancarSessio.php" class="cerrar-sesion">Tancar Sessió</a>
		</div>
		<div class="perfil-content">
                    <h3>Informació de perfil</h3>
                    <?php
                    echo"Nom d'usuari: $_SESSION[usuariS] </br>";
                    echo "Id d'usuari: $_SESSION[UsuariId]</br>";
                    ?>
		</div>
	</div>
<?php
//id
//usuari
//email potser
//cambiar contrasenya
//confirmar contrasenya
//tancar sessio
?>
</body>
</html>