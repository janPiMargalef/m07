<?php
require_once('config.php');
session_start();
?>
<html>
    <head>
        <title>partides</title>
        <style>
table {
  border-collapse: collapse;
  width: 60%;
  margin: auto;
  margin-top: 2%;
}


tr:nth-child(odd) {
  background-color: #f2f2f2;
}

tr:nth-child(even) {
  background-color: #ffffff;
}

th, td {
  padding: 8px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}


h2 {
    margin-top: 3%;
    text-align: center;
}
.container {
  display: flex;
  flex-direction: column;
  align-items: center;
  position: relative;
  margin-top: 2%;
  margin-bottom: 2%;
}

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    background-image: url('map.webp');
    
  }
body::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5); 
    z-index: -1;
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
.content-capça {
  background-color: rgba(255, 255, 255, 0.8);
  padding: 1rem;
  margin-bottom: 1rem;
  width: 80%;
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
    <div class="content-capça">
    <h2>Partides que t'han acceptat:</h2>
    <table>
       <tr>
      <th></th>
      <th>Equip</th>
      <th>Dia</th>
      <th>Hora</th>
      <th>Mapa</th>
      <th></th>
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
      <th></th>
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
   </div>
   </div>
<footer class="footer">
    Copyright &copy; <a href="#política de privacitat">Política de privacitat.</a>
  </footer>
    </body>
</html>
