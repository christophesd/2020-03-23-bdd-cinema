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

        ul {
            padding: 0 10px 0 20px;
        }
    </style>
</head>

<body>

    <?php
        // recuperation numéro de cinema
        $cine = htmlspecialchars($_GET["cine"]);

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
            $salleid[] = $salle[0];
            $sallenb[] = $salle[1];
            $sallecap[] = $salle[2];
        }
        $salles->closeCursor();

        // recep nb equipement
        foreach ($salleid as $key => $value) {
            $equipements[] = $bdd->query('SELECT * from avoir WHERE id_salle = "'.$value.'"');
            while ($equipement[$key] = $equipements[$key]->fetch()) {
                $equipementnb[$key][] = $equipement[$key][0];
            }
            if (empty($equipementnb[$key])) {
                $equipementnb[$key] = NULL;
            }
            $equipements[$key]->closeCursor();
        }

        // nom des équipements
        $nameequipements = $bdd->query('SELECT * from equipement');
        while ($nameequipement = $nameequipements->fetch()) {
            $equipementname[$nameequipement[0]] = $nameequipement[1];
        }
        $nameequipements->closeCursor();
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
        <tr>
            <th>Equipements : </th>
            <?php 
                foreach ($equipementnb as $key => $xsalle) {
                    echo "<td><ul>";
                    foreach ($xsalle as $xequi) {
                        echo "<li>".$equipementname[$xequi]."</li>";
                    }
                    if (empty($xsalle)) {
                        echo "(Pas d'équipements ajouté)";
                    }
                    echo "</ul></td>";
                }
            ?>
        </tr>
    </table>



    <a href="ajoutsalle.php?cine=<?php echo $cine ?>"><h3>Ajouter une Salle ></h3></a>
    <a href="index.php"><h3>< Voir les cinémas</h3></a>

</body>
</html>