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
$NomEquipCrear = $_SESSION['UsuariEquip'];
$ImatgeRuta = $_SESSION['SesionImatge'];

$consulta5 = "SELECT id_oferta, dia, hora, mapa, nom_equip, imatge_equip FROM ofertes WHERE nom_equip != :nom_equip ORDER BY dia ASC, hora ASC";//llistar ofertes
$sentencia_altres_equips = $db->prepare($consulta5);
$sentencia_altres_equips->bindParam(':nom_equip', $NomEquipCrear);
$sentencia_altres_equips->execute();

$consulta6 = "SELECT id_oferta, dia, hora, mapa, nom_equip, imatge_equip FROM ofertes WHERE nom_equip = :nom_equip ORDER BY dia ASC, hora ASC";//llistar ofertes
$sentencia_equips = $db->prepare($consulta6);
$sentencia_equips->bindParam(':nom_equip', $NomEquipCrear);
$sentencia_equips->execute();

if(isset($_POST['crearOferta']))//crear oferta
{
$dia = $_POST['dia'];
$hora = $_POST['hora'];
$mapa = $_POST['mapa'];


$consulta4 = "INSERT INTO ofertes (dia, hora, mapa, nom_equip, imatge_equip) VALUES (:dia, :hora, :mapa, :nom_equip, :imatge_equip)";
$sentencia4 = $db->prepare($consulta4); 
$sentencia4->bindParam(':dia', $dia);
$sentencia4->bindParam(':hora', $hora);
$sentencia4->bindParam(':mapa', $mapa);
$sentencia4->bindParam(':nom_equip', $NomEquipCrear);
$sentencia4->bindParam(':imatge_equip', $ImatgeRuta);
$sentencia4->execute();
 header("Location: ".$_SERVER['PHP_SELF']);
 exit();
}
if(isset($_POST['acceptar_oferta'])) {//acceptar oferta, enviar la info (post) a la pagina partides

}
if(isset($_POST['eliminar_oferta']) && isset($_POST['id_oferta'])) { //eliminar oferta
     $id_oferta = $_POST['id_oferta'];

    $stmt_eliminar_oferta = $db->prepare("DELETE FROM ofertes WHERE id_oferta = :id");
    $stmt_eliminar_oferta->bindParam(':id', $id_oferta);
    $stmt_eliminar_oferta->execute();

    // Redirigir de vuelta a la página de ofertas
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

?>

    <div class="container">
    <h2>Ofertes d'altres equips</h2>
    <table>
       <tr>
      <th></th>
      <th>Equip</th>
      <th>Dia</th>
      <th>Hora</th>
      <th>Mapa</th>
    </tr>
        <tbody>
        <?php
        while ($registro5 = $sentencia_altres_equips->fetch(PDO::FETCH_ASSOC)) {
          echo '<tr>
        <td>
            <img src="'.$registro5['imatge_equip'].'" alt="Perfil" width="50" height="50" style="border-radius: 50%; object-fit: cover;">
        </td>
        <td>'.$registro5['nom_equip'].'</td>
        <td>'.date('d/m', strtotime($registro5['dia'])).'</td>
        <td>'.date('H:i', strtotime($registro5['hora'])).'</td>
        <td>'.$registro5['mapa'].'</td> 
            <td>
        <form action="partides.php" method="post">
                    <input type="hidden" name="id_oferta" value="'.$registro5['id_oferta'].'">
                    <button type="submit" name="acceptar_oferta">Acceptar Oferta</button>
                </form>
                </td>
    </tr>';
  
        }
        ?>
        </tbody>
    </table>
    </div>
<div class="container">
    <br>
    <br>
    <h2>Ofertes del teu equip</h2>
    <table>
       <tr>
      <th></th>
      <th>Equip</th>
      <th>Dia</th>
      <th>Hora</th>
      <th>Mapa</th>
    </tr>
        <tbody>
        <?php
        while ($registro5 = $sentencia_equips->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>
        <td>
            <img src="'.$registro5['imatge_equip'].'" alt="Perfil" width="50" height="50" style="border-radius: 50%; object-fit: cover;">
        </td>
        <td>'.$registro5['nom_equip'].'</td>
        <td>'.date('d/m', strtotime($registro5['dia'])).'</td>
        <td>'.date('H:i', strtotime($registro5['hora'])).'</td>
        <td>'.$registro5['mapa'].'</td> 
        <td>
                <form action="buscar.php" method="post">
                    <input type="hidden" name="id_oferta" value="'.$registro5['id_oferta'].'">
                    <button type="submit" name="eliminar_oferta">Eliminar Oferta</button>
                </form>
            </td>
    </tr>';

        }
        ?>
        </tbody>
    </table>





  </tbody>
</table>
</div>
<form method="post" action="buscar.php" class="formulario">
  <label for="dia">Día:</label>
  <input type="date" name="dia" min="<?php echo date('Y-m-d'); ?>" required> <!-- No es poden seleccionar dies que ja han passat -->
  </br>
  <label for="hora">Hora:</label>
  <input type="time" name="hora" required>
  </br>
  <label for="mapa">Mapa:</label>
  <select name="mapa">
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
