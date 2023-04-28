<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Encuesta de hora</title>
    
    <style>
    
.tablinks {
  background-color: #f1f1f1;
  color: black;
  border: none;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 5px;
  cursor: pointer;
  padding: 10px 15px;
  border-radius: 4px;
}

.tablinks:hover {
  background-color: #ddd;
}

.tabcontent {
  display: none;
  padding: 20px;
  border-top: none;
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
      </div>
    </div>
  </div>
</nav>



<button class="tablinks" onclick="openTab(event, 'Equip')">Equip</button>
<button class="tablinks" onclick="openTab(event, 'Jugadors')">Jugadors</button>

<div id="Equip" class="tabcontent">
  <h3>Informació de l'equip</h3>
  <p>Contingut relacionat amb l'equip.</p>
</div>

<div id="Jugadors" class="tabcontent">
  <h3>Jugadors</h3>
  <p>Contingut relacionat amb els jugadors.</p>
</div>
<script>
function openTab(evt, tabName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " active";
}

// Obre la pestanya "Equip" per defecte en carregar la pàgina
document.addEventListener("DOMContentLoaded", function() {
  document.getElementsByClassName("tablinks")[0].click();
});
</script>

  </body>
</html>