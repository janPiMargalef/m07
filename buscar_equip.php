<?php
session_start();
require_once('config.php');
?>
<html>
    <head>
        <title>buscar partida</title>
        <script>
        function buscarEquipo() {
            var nomEquip = document.getElementById("nom_equip_buscar").value;
            if (nomEquip.length > 0) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("resultados").innerHTML = this.responseText;
                    }
                };
                xhttp.open("POST", "buscar_equip.php?nom_equip_buscar=" + nombreEquipo, true);
                xhttp.send();
            }
        }
    </script>
    <style>
    .nom-equip {
        font-weight: bold; 
        color: #333;
        font-size: 2rem;
        font-family: Courier New;
    }
   

    .centrar {
        margin-left: 36%;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding-top: 2rem;
        font-size: 1.5rem; 
    }

    details {
        width: 80%; 
        margin-bottom: 1rem;
    }

    details summary {
        display: flex;
        align-items: center;
        cursor: pointer;
    }

    details img {
        margin-right: 1rem;
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

  .container-principal {
    flex-grow: 1;
  }
  
  .boto:hover {
    background-color: #c27100;
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
  
   body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
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
<?php
if (isset($_POST['nom_equip_buscar'])) {
    $nom_equip = $_POST['nom_equip_buscar'];

    $consulta_jugadors = "SELECT usuari FROM usuaris WHERE nom_equip= :nom_equip";
    $sentencia_jugadors = $db->prepare($consulta_jugadors);
    $sentencia_jugadors->bindParam(':nom_equip', $nom_equip);
    $sentencia_jugadors->execute();
    $resultats_jugadors = $sentencia_jugadors->fetchAll(PDO::FETCH_ASSOC);
    
    $consulta = "SELECT * FROM equips WHERE nom_equip LIKE :nom_equip";
    $sentencia = $db->prepare($consulta);
    $sentencia->bindValue(':nom_equip', '%' . $nom_equip . '%');
    $sentencia->execute();
    $resultats_busqueda = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    //select usuari  where nom_EQUIP = post_nom_equip... mostrar usuaris
    
    if(count($resultats_busqueda) > 0)
    {
    echo '<div class="centrar">';
foreach ($resultats_busqueda as $fila) {
    echo "<details>";
    echo "<summary><img src='".$fila['imatge']."' alt='Perfil' width='50' height='50' style='border-radius: 50%; object-fit: cover;'><span class='nom-equip'>" . $fila['nom_equip'] . "</span></summary>";
    echo "<p></p>";
    echo "<p>ID de l'equip: " . $fila['id_equip'] . "</p>";
    echo "<p>Nom curt: " . $fila['nom_curt'] . "</p>";
    echo "<p>Descripció: " . $fila['descripcio'] . "</p>";
    
     echo "<p><span class='nom-equip'>Jugadors:</span></p>";
    echo "<ul>";
    foreach ($resultats_jugadors as $jugador) {
        echo "<li>" . $jugador['usuari'] . "</li>";
        echo "<p></p>";
    }
    echo "</ul>";
    echo "</details>";
}
echo '</div> <br> <br>';


    }
    else{
         echo"no existeix";
    }
}
?>
 </div>
     <footer class="footer">
    Copyright &copy; <a href="#política de privacitat">Política de privacitat.</a>
  </footer>
 </body>
</html>
