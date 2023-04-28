<?php
session_start();
require_once('config.php');
?>
<html>
    <head>
        <title>buscar partida</title>
        <link rel="stylesheet" type="text/css" href="estilsOfertes.css">
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
</style>

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
         <form action="buscar_equip.php" method="post">
            <input type="text" name="nombre_equipo" id="nombre_equipo" placeholder="Buscar equip" required>
            <button type="submit">Buscar</button>
        </form>
      </div>
    </div>
  </div>
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
 </body>
</html>
