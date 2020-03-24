<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BDD Cinema</title>
    <style>
        table {
            border-collapse: collapse;
        }

        table, tr, th, td {
            border: 1px solid black;
            padding: 5px;
        }

    </style>
</head>

<body>

    <h1>Liste des Cinémas :</h1>

    <table>
        <th>Nom du cinema : </th>
        <th>Ville : </th>
        <th>Adresse : </th>
        <th>Email : </th>
        <th>Numéro de téléphone : </th>
        <?php 
        include 'include/connexion.php';
        $cinemas = $bdd->prepare('SELECT * from cinema');
        $cinemas->execute();
        while ($cinema = $cinemas->fetch()) {
            echo "<tr>";
            echo "<td><a href='infocinema.php?cine=".$cinema[0]."'>".$cinema[1]."</a></td>";
            echo "<td>".$cinema[2]."</td>";
            echo "<td>".$cinema[3]."</td>";
            echo "<td>".$cinema[4]."</td>";
            echo "<td>".$cinema[5]."</td>";
            echo "</tr>";
        }
        $cinemas->closeCursor();
        ?>
    </table>

    <a href="ajoutcinema.php"><h3>Ajouter un Cinéma ></h3></a>

</body>
</html>