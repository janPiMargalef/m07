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
    font-size: 3rem;
    z-index: 1;
  }

.container {
  padding: 2rem;
  display: flex;
  justify-content: flex-start; 
  flex-wrap: wrap;
   margin-left: 14%; 
   margin-top: 2%;
}

.content-capça {
  background-color: #d1d1d1;
  padding: 1rem;
  width: 18%;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  margin-bottom: 1rem;
  margin-right: 10%; 
  
}
.content-capça button {
      background-color: #FF6600 ;
      border: none;
      color: white;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      padding: 10px 24px;
      cursor: pointer;
      border-radius: 5px;
      transition: background-color 0.3s;
      margin-top: 3%;
      margin-left: 18%;
    }

    .content-capça button:hover {
      background-color: #c27100;
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
      CS:GO Troba Equips i Enfronta't!
    </div>
  </div>
    
   <div class="container">
    <div class="content-capça">
      <h2 class="titol">Busca un equip</h2>
      <p>Forma o uneix-te a un equip amb els teus amics:
Descobreix nous companys de joc o crea el teu propi equip amb els teus amics per competir junts en CS:GO. Connecta amb altres jugadors apassionats i millora les teves habilitats en equip.</p>
     <button onclick="canviarPaginaEquip()">Equips</button>
  <script>
    function canviarPaginaEquip() {
      window.location.href = 'equip.php';
    }
  </script>

    </div>
    <div class="content-capça">
      <h2 class="titol">Busca partides</h2>
      <p>Cerca i accepta desafiaments amb altres equips:
Explora o crea ofertes de partides per enfrontar-te a altres equips, establint l'hora, el dia i el mapa que millor s'adapti a les vostres necessitats. Accepta el repte i demostra el teu domini en el joc.</p>
     <button onclick="canviarPaginaBuscar()">Buscar partides</button>
  <script>
    function canviarPaginaBuscar() {
      window.location.href = 'buscar.php';
    }
  </script>
    </div>
    <div class="content-capça">
      <h2 class="titol">Partides</h2>
      <p>Segueix les partides acceptades del teu equip:
Consulta la pàgina "Partides" per veure les partides que el teu equip ha acceptat. No perdis detall de les teves properes confrontacions i prepara't per a la victòria en el camp de batalla virtual.</p>
    <button onclick="canviarPaginaPartides()">Partides</button>
  <script>
    function canviarPaginaPartides() {
      window.location.href = 'partides.php';
    }
  </script>
    </div>
  </div>
     </div>
  <footer class="footer">
    Copyright &copy; <a href="#política de privacitat">Política de privacitat.</a>
  </footer>    
</body>
</html>