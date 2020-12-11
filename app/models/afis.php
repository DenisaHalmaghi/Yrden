<!DOCTYPE html
          PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Doi</title>


    <link href="stil.css" rel="stylesheet" type="text/css">
  </head>

  <body>
    <div id="wrapper">
      <div id="header">
        <h1>This is the Page Header</h1>
      </div>

      <div id="left-column">
        <h2>The Navigation</h2>
        <?php
      include "meniu.php";
      ?>
      </div>

      <div id="right-column">
        <h2>Studentii din scoala noastra</h2>
        <?php
      include "conect.php";

      ?>
        <table>
          <tr>
            <th>Nr Crt</th>
            <th>Nume</th>
            <th>Prenume</th>
            <th>An</th>
          </tr>
          <?php
        $i = 1;
        while ($row = mysql_fetch_array($rez)) {
          echo "<tr><td>" . $i . "</td><td>" . $row['Nume'] . "</td><td>" . $row['Prenume'] . "</td><td>" .
            $row['An'] . "</td></tr>";
          $i++;
        }
        ?>
        </table>
      </div>

      <div id="footer">
        <p>The Page Footer Goes Here</p>
      </div>
    </div>
    <!--aici se termina wrapperul-->


  </body>

</html>
