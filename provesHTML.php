<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Encuesta de hora</title>
  </head>
  <body>
    <form method="post" action="procesar_encuesta.php">
      <label for="hora">Seleccione una hora:</label>
      <select name="hora" id="hora">
        <?php for ($i = 0; $i <= 23; $i++) { ?>
          <option value="<?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?>"><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?>:00</option>
        <?php } ?>
      </select>
      <br>
      <input type="submit" value="Enviar">
    </form>
      <h1>Guardar día en la base de datos</h1>
	<form method="POST" action="guardar_dia.php">
		<label>Ingresa el día (formato DD):</label>
		<input type="text" name="dia">
		<input type="submit" value="Guardar">
	</form>
      <form action="buscar.php" method="get">
  <label for="equipo">Buscar equipo:</label>
  <input type="text" id="equipo" name="equipo">
  <input type="submit" value="Buscar">
</form>
  </body>
</html>
<?php/*
// Conectarse a la base de datos
$dsn = 'mysql:host=localhost;dbname=nombre_de_la_base_de_datos;charset=utf8mb4';
$usuario = 'nombre_de_usuario';
$contraseña = 'contraseña_del_usuario';
$opciones = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
);
$pdo = new PDO($dsn, $usuario, $contraseña, $opciones);

// Obtener la hora seleccionada por el usuario
$hora = $_POST['hora'];

// Insertar la respuesta en la base de datos
$sql = 'INSERT INTO encuesta_hora (hora) VALUES (?)';
$stmt = $pdo->prepare($sql);
$stmt->execute([$hora]);

// Mostrar las respuestas ordenadas por la hora seleccionada
$sql = 'SELECT * FROM encuesta_hora ORDER BY hora';
$stmt = $pdo->query($sql);
while ($fila = $stmt->fetch()) {
    echo $fila['hora'] . '<br>';
}
*/?>
<?php
$nom = "jan";
$edat = 10;
$email = "email@gmailcom";
echo '<form method="post">';
  echo '<label>Nombre:</label>';
  echo '<input type="text" name="nombre" value="' . $nom . '"><br>';
  echo '<label>Edad:</label>';
  echo '<input type="number" name="edad" value="' . $edat . '" readonly><br>';
  echo '<label>Email:</label>';
  echo '<input type="email" name="email" value="' . $email . '"><br>';
  echo '<button type="submit" name="guardar">Guardar</button>';
  echo '</form>';
?>