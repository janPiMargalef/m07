<?php
session_start();
require_once('config.php');
?>
<html>
    <head>
        <title>buscar partida</title>
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

h2 {
    margin-top: 2%;
    text-align: center;
}
.container {
  display: flex;
  flex-direction: column;
  align-items: center;
  position: relative;
  margin-top: 2%;
}

th, td {
  padding: 8px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

.perfil-img {
  width: 10px;
  height: 10px;
  border-radius: 10%;
  overflow: hidden;
}

.perfil-img img {
  width: 10%;
  height: 10%;
  object-fit: cover;
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
  width: 60%;
}
.caja {
  display: flex;
  position: absolute;
  padding: 2rem;
   
  z-index: 10; 
}

.formulari {
  background-color: #f2f2f2;
  padding: 2rem;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  width: 100%;
  max-width: 200px;
}

.formulari label {
  display: block;
  font-weight: bold;
  margin-bottom: 0.5rem;
}

.formulari input,
.formulari select {
  display: block;
  width: 100%;
  padding: 8px;
  margin-bottom: 1rem;
  border-radius: 4px;
  border: 1px solid #ccc;
  outline: none;
}

.formulari input[type="submit"] {
  background-color: #4CAF50;
  color: white;
  font-weight: bold;
  border: none;
  cursor: pointer;
  transition: background-color 0.3s;
}

.formulari input[type="submit"]:hover {
  background-color: #45a049;
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
$NomEquipCrear = $_SESSION['UsuariEquip'];
$ImatgeRuta = $_SESSION['SesionImatge'];
//ofertes de tots els equips
$consulta5 = "SELECT id_oferta, dia, hora, mapa, nom_equip, imatge_equip FROM ofertes WHERE nom_equip != :nom_equip ORDER BY dia ASC, hora ASC";//llistar ofertes
$sentencia_altres_equips = $db->prepare($consulta5);
$sentencia_altres_equips->bindParam(':nom_equip', $NomEquipCrear);
$sentencia_altres_equips->execute();
//consulta per les ofertes del teu equip
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
<div class="caja">
  <form method="post" action="buscar.php" class="formulari">
    <label for="dia">Día:</label>
    <input type="date" name="dia" min="<?php echo date('Y-m-d'); ?>" required>
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
</div>

    <div class="container">
        <div class="content-capça">
    <h2>Ofertes d'altres equips</h2>
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
    </div>
<div class="container">
    <div class="content-capça">
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
       <th></th>
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
  </div>
      </div>
<footer class="footer">
    Copyright &copy; <a href="#política de privacitat">Política de privacitat.</a>
  </footer>
    </body>
</html>
