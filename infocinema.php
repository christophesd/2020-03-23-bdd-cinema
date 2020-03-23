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


    <?php
        // recuperation numéro de cinema
        $cine = htmlspecialchars($_SERVER['QUERY_STRING']);

        // recup nom du cinema
        include 'include/connexion.php';
        $cinemas = $bdd->query('SELECT * from cinema WHERE id_cinema = "'.$cine.'"');
        $cinema = $cinemas->fetch();
        $name = $cinema[1];
        $cinemas->closeCursor();

        // recep salles
        $salles = $bdd->query('SELECT * from salle WHERE id_cinema = "'.$cine.'"');
        while ($salle = $salles->fetch()) {
            $nbsalle++;
            $sallenb[] = $salle[1];
            $sallecap[] = $salle[2];
        }


    ?>



    <h1><?php echo $name ?></h1>
    <h3>Ce cinéma à <?php echo $nbsalle; ?> salles :</h3>
    <table>
        <tr>
            <th>Salle : </th>
            <?php 
            foreach ($sallenb as $value) {
                echo "<td>".$value."</td>";
            }
            ?>
        </tr>
        <tr>
            <th>Capacité : </th>
            <?php 
            foreach ($sallecap as $value) {
                echo "<td>".$value."</td>";
            }
            ?>
        </tr>
    </table>



    <a href="ajoutsalle.php"><h3>Ajouter une Salle ></h3></a>
    <a href="index.php"><h3>< Voir les cinémas</h3></a>

</body>
</html>