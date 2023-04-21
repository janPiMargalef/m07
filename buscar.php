<?php
session_start();
require_once('config.php');
?>
<html>
    <head>
        <title>buscar partida</title>
        <link rel="stylesheet" type="text/css" href="estilsOfertes.css">
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
<?php
$consulta5 = "SELECT dia, hora, mapa, nom_equip FROM ofertes ORDER BY dia ASC, hora ASC";//llistar ofertes
$sentencia5 = $db->prepare($consulta5);
$sentencia5->execute();




if(isset($_POST['crearOferta']))//crear oferta
{
$dia = $_POST['dia'];
$hora = $_POST['hora'];
$mapa = $_POST['mapa'];
$NomEquipCrear = $_SESSION['UsuariEquip'];

$consulta4 = "INSERT INTO ofertes (dia, hora, mapa, nom_equip) VALUES (:dia, :hora, :mapa, :nom_equip)";
$sentencia4 = $db->prepare($consulta4); //proxim que he de comprobar es si funciona llistarlos en ordre, sino pasarlos a diferent format suposo XD

$sentencia4->bindParam(':dia', $dia);
$sentencia4->bindParam(':hora', $hora);
$sentencia4->bindParam(':mapa', $mapa);
$sentencia4->bindParam(':nom_equip', $NomEquipCrear);
// Ejecutar la consulta
$sentencia4->execute();
 header("Location: ".$_SERVER['PHP_SELF']);
}
if(isset($_GET['nom_equip'], $_GET['dia'], $_GET['hora'], $_GET['mapa'])) {
    
}
?>
<div class="container">
<table>
  <thead>
    <tr>
      <th>Equip</th>
      <th>Dia</th>
      <th>Hora</th>
      <th>Mapa</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($registro5 = $sentencia5->fetch(PDO::FETCH_ASSOC)) { //al donarli al boto, es guarda en la bd el nom d'equip que accepta i el acceptat, despres, al iniciar sessio comprobar si aquell nom_equip esta dins de partides trobades, si es aixi, mostrar info en partides'?>
      <tr>
        <td><?php echo $registro5['nom_equip']; ?></td>
        <td><?php echo date('d/m', strtotime($registro5['dia'])); ?></td>
        <td><?php echo date('H:i', strtotime($registro5['hora'])); ?></td>
        <td><?php echo $registro5['mapa']; ?></td> 
       
        <td><a href="partides.php?nom_equip=<?php echo $registro5['nom_equip']; ?>&dia=<?php echo $registro5['dia']; ?>&hora=<?php echo $registro5['hora']; ?>&mapa=<?php echo $registro5['mapa']; ?>">
                <button type="button" name="acceptar_oferta">Acceptar Oferta</button>
            </a></td>
      </tr>
    <?php } ?>
  </tbody>
</table>
</div>
<form method="post" action="buscar.php" class="formulario">
    <label for="dia">Día:</label>
  <input type="date" name="dia" required>
  </br>
  <label for="hora">Hora:</label>
  <input type="time" name="hora" required>
  </br>
      <label for="mapa">Mapa:</label>
      <select name ="mapa">
        <option value="Dust II">Dust II</option>
        <option value="Mirage">Mirage</option>
        <option value="Inferno">Inferno</option>
        <option value="Nuke">Nuke</option>
        <option value="Overpass">Overpass</option>
      </select>
      <input type="submit" name="crearOferta" value="crea">
    </form>
    </body>
</html>
