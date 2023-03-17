<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <table border ="1">
        <?php
        $n =12;
        for($i=0; $i<=12; $i++)
        {
          $q = $i * $i;
          echo "<tr><td>$i<td> *<td> $i<td> =<td> $q <tr>";
        }
        ?>
        </table>
    </body>
</html>
