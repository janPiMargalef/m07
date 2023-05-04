<?php
session_start();
?>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menú</title>
  <link rel="stylesheet" type="text/css" href="estilsPerfil.css">
  <style>
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
  }

  .container-principal {
    flex-grow: 1;
  }

  header {
    background-color: #1a1a1a;
    padding: 1rem;
  }
  nav {
    background-color: #333;
    overflow: hidden;
    display: flex;
 
    align-items: center;
  }

  nav a {
    display: inline-block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
  }

  nav a:hover {
    background-color: #ddd;
    color: black;
  }

   .buscador {
    display: flex;
    align-items: center;
    border-radius: 4px;
    margin-top: 0.5%;
    padding: 4px 8px;
    margin-left: 50%;
  }
  #nom_equip_buscar {
    border: none;
    padding: 4px 8px;
    border-radius: 4px;
    outline: none;
    font-size: 14px;
    height: 35px;
  }

  

  .boto {
    border: none;
    background-color: #FF6600;
    color: white;
    padding: 6px 12px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    height: 35px;
    margin-left: 2%;
  }

  .boto:hover {
    background-color: #c27100;
  }
  
   .menu {
    background-image: url('map.webp');
    background-size: cover;
    background-position: center;
    height: 400px;
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
    font-size: 2rem;
    position: relative;
     z-index: -1;
  }

   .menu {
    background-image: url('map.webp');
    background-size: cover;
    background-position: center;
    height: 400px;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
  }

  .menu::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: -1;
  }

  .menu-cont {
    color: white;
    font-size: 2rem;
    z-index: 1;
  }

   .container {
    padding: 2rem;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
  }
.content-box {
    background-color: #d1d1d1;
    padding: 1rem;
    width: 30%;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
  }
  
  .titol {
    font-size: 1.25rem;
    margin-bottom: 1rem;
  }
  .footer {
    background-color: #1a1a1a;
    padding: 1rem;
    color: white;
    text-align: center;
    font-size: 1rem;
    margin-bottom: 0;
    
  }
  .logo {
      max-height: 150px;
      max-width: 200px;
  }
</style>

</head>
<body>
     <div class="container-principal">
  <header>
    <a href="menu.php"><img src="logo.png" class="logo"></a>
  </header>
  <nav>
    <a href="menu.php">Menú</a>
    <a href="equip.php">Equip</a>
    <a href="buscar.php">Buscar</a>
    <a href="partides.php">Partides</a>
    <a href="perfil.php">Perfil</a>
    <form action="buscar_equip.php" method="post" class="buscador">
            <input type="text" name="nom_equip_buscar" id="nom_equip_buscar" placeholder="Buscar equip" required>
            <button type="submit" class ="boto">Buscar</button>
        </form>
  </nav>
    
     <div class="menu">
    <div class="menu-cont">
      Títol de la pàgina
    </div>
  </div>
    
   <div class="container">
    <div class="content-box">
      <h2 class="titol">Cont 1</h2>
      <p>Descripció del contingut .</p>
    </div>
    <div class="content-box">
      <h2 class="titol">Cont 2</h2>
      <p>Descripció del contingut .</p>
    </div>
    <div class="content-box">
      <h2 class="titol">Cont 3</h2>
      <p>Descripció del contingut .</p>
    </div>
  </div>
     </div>
  <footer class="footer">
    Copyright &copy; <a href="#política de privacitat">Política de privacitat.</a>
  </footer>
<?php

if(isset($_SESSION['UsuariEmail'])) // afegir aixo a totes les pàgines, per si no s'ha iniciat sessió, surti la opció iniciar (fer-ho al acabar els CSS )
{
}
 else {
    
echo "<a href='registrarCompte.php'>Registret</a> <a href='iniciarSessio.php'>Inicia Sessió</a>";
 }
 ?>
    
</body>
</html>