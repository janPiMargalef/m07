<?php
require_once('config.php');
session_start();
?>
<html>
    <head>
        <title>partides</title>
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
        <form action="buscar_equip.php" method="post" class="buscador">
            <input type="text" name="nom_equip_buscar" id="nom_equip_buscar" placeholder="Buscar equip" required>
            <button type="submit">Buscar</button>
        </form>
      </div>
    </div>
  </div>
</nav>
 <?php if (isset($_SESSION['UsuariEmail'])): ?>
<?php
if(isset($_SESSION['UsuariEmail'])){
if(isset($_POST['acceptar_oferta'])) {//fer select de tot de quan id = $_POST i insertar-ho to a p_t
$id_oferta = $_POST['id_oferta'];     
    
$consulta_partides = "SELECT dia, hora, mapa, nom_equip, imatge_equip FROM ofertes WHERE id_oferta= :id_oferta";//obtenir info de oferta acceptada
$sentencia_partides = $db->prepare($consulta_partides);
$sentencia_partides->bindParam(':id_oferta', $id_oferta);
$sentencia_partides->execute();
$resultat_ofertes = $sentencia_partides->fetch(PDO::FETCH_ASSOC);

$ofertes_dia = $resultat_ofertes['dia'];
$ofertes_hora = $resultat_ofertes['hora'];
$ofertes_mapa = $resultat_ofertes['mapa'];
$ofertes_equip_acceptat = $resultat_ofertes['nom_equip'];
$ofertes_imatge_equip = $resultat_ofertes['imatge_equip'];
$ofertes_equip_accepta = $_SESSION['UsuariEquip'];

$consulta_comprova = "SELECT * FROM partides_trobades WHERE id_oferta= :id_oferta AND nom_equip_accepta = :nom_equip_accepta";//comprovar que la oferta no ha sigut acceptada ja  per aquell equip
$sent_comprova = $db->prepare($consulta_comprova); 
$sent_comprova->bindParam(':id_oferta', $id_oferta);
$sent_comprova->bindParam(':nom_equip_accepta', $ofertes_equip_accepta);
$sent_comprova->execute();
$Files_comprova = $sent_comprova->rowCount(); 

if($Files_comprova > 0)
{
    echo "<script>alert('Ja has acceptat aquesta oferta'); </script>";
    header("Location:buscar.php");
    exit();
}
else{

$consulta_afegir = "INSERT INTO partides_trobades (mapa, dia_p, hora_p, id_oferta, nom_equip_acceptat, nom_equip_accepta, imatge_p) VALUES (:mapa, :dia, :hora, :id_oferta, :nom_equip_acceptat, :nom_equip_accepta, :imatge)";
$sent_p = $db->prepare($consulta_afegir); 
$sent_p->bindParam(':mapa', $ofertes_mapa);
$sent_p->bindParam(':dia', $ofertes_dia);
$sent_p->bindParam(':hora', $ofertes_hora);
$sent_p->bindParam(':id_oferta', $id_oferta);
$sent_p->bindParam(':nom_equip_acceptat', $ofertes_equip_acceptat);
$sent_p->bindParam(':nom_equip_accepta', $ofertes_equip_accepta);
$sent_p->bindParam(':imatge', $ofertes_imatge_equip);
$sent_p->execute();    
header("Location:buscar.php");
exit();
}
}
}
?>
<?php
$equip_partida = $_SESSION['NomEquipCrear'];

$consulta_partida = "SELECT id_partida, mapa, dia_p, hora_p, id_oferta, nom_equip_acceptat, nom_equip_accepta, imatge_p FROM partides_trobades WHERE nom_equip_acceptat = :nom_equip ORDER BY dia_p ASC, hora_p ASC";//llistar ofertes
$sentencia_partida = $db->prepare($consulta_partida);
$sentencia_partida->bindParam(':nom_equip', $equip_partida);
$sentencia_partida->execute();


$consulta_partida2 = "SELECT id_partida, mapa, dia_p, hora_p, id_oferta, nom_equip_acceptat, nom_equip_accepta, imatge_p FROM partides_trobades WHERE nom_equip_accepta = :nom_equip ORDER BY dia_p ASC, hora_p ASC";//llistar ofertes
$sentencia_partida2 = $db->prepare($consulta_partida2);
$sentencia_partida2->bindParam(':nom_equip', $equip_partida);
$sentencia_partida2->execute();
       
if(isset($_POST['eliminar_partida']) && isset($_POST['id_partida'])) { //eliminar partida
     $id_partida= $_POST['id_partida'];

    $stmt_eliminar_partida = $db->prepare("DELETE FROM partides_trobades WHERE id_partida = :id");
    $stmt_eliminar_partida->bindParam(':id', $id_partida);
    $stmt_eliminar_partida->execute();
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}  
?>
<div class="container">
    <h2>Partides que t'han acceptat:</h2>
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
        while ($registre = $sentencia_partida->fetch(PDO::FETCH_ASSOC)) {
          echo '<tr>
        <td>
            <img src="'.$registre['imatge_p'].'" alt="Perfil" width="50" height="50" style="border-radius: 50%; object-fit: cover;">
        </td>
        <td>'.$registre['nom_equip_accepta'].'</td>
        <td>'.date('d/m', strtotime($registre['dia_p'])).'</td>
        <td>'.date('H:i', strtotime($registre['hora_p'])).'</td>
        <td>'.$registre['mapa'].'</td> 
            <td>
       <form action="partides.php" method="post">
                    <input type="hidden" name="id_partida" value="'.$registre['id_partida'].'">
                    <button type="submit" name="eliminar_partida">Eliminar</button>
                </form>
                </td>
    </tr>';
  
        }
        ?>
        </tbody>
    </table>
    <h2>Partides que has acceptat:</h2>
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
        while ($registre2 = $sentencia_partida2->fetch(PDO::FETCH_ASSOC)) {
          echo '<tr>
        <td>
            <img src="'.$registre2['imatge_p'].'" alt="Perfil" width="50" height="50" style="border-radius: 50%; object-fit: cover;">
        </td>
        <td>'.$registre2['nom_equip_acceptat'].'</td>
        <td>'.date('d/m', strtotime($registre2['dia_p'])).'</td>
        <td>'.date('H:i', strtotime($registre2['hora_p'])).'</td>
        <td>'.$registre2['mapa'].'</td> 
            <td>
        <form action="partides.php" method="post">
                    <input type="hidden" name="id_partida" value="'.$registre2['id_partida'].'">
                    <button type="submit" name="eliminar_partida">Eliminar</button>
                </form>
                </td>
    </tr>';
  
        }
        ?>
        </tbody>
    </table>
    </div>
 <?php else: //afegir CSS als login sense session?>
     <div class="login-container">
		<h2>Iniciar sessió</h2>
		<form method="post">
			<label for="username">Usuari</label>
			<input type="text" name="emailS" id="username" required>
			<label for="password">Contrasenya</label>
			<input type="password" name="contrasenyaS" id="password" required>
			<button type="submit" name="iniciar" value="iniciarSessio">Iniciar sessió</button>
		</form>
                <p>No tens un compte?<a href="registrarCompte.php">Registret</a></p>
	</div>
<?php endif; ?>

    </body>
</html>
