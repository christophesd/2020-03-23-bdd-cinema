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
    $cinemas = $bdd->query('SELECT * from cinema');
    foreach($cinemas as $cinema) {
        echo "<tr>";
        echo "<td>".$cinema[1]."</td>";
        echo "<td>".$cinema[2]."</td>";
        echo "<td>".$cinema[3]."</td>";
        echo "<td>".$cinema[4]."</td>";
        echo "<td>".$cinema[5]."</td>";
        echo "</tr>";
    }
    ?>
</table>

<a href="ajoutcinema.php"><h2>Ajouter un Cinéma</h2></a>

</body>
</html>