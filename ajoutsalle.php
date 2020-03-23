<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Salle</title>
</head>

<body>

    <?php 

    // recuperation numéro de cinema
    $cine = htmlspecialchars($_GET["nbcinema"]);
    $selected[$cine] = "selected";

    // Init var
    $nbsalleErr = $capsalleErr = $nbcinemaErr = "";
    $nbsalle = $capsalle = $nbcinema = "";
    $validadd = $erroradd = "";
    $selected[] = "";

    // Fontion test
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Vérification champs
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
        if (empty($_POST["nbsalle"])) {
            $nbsalleErr = "(Numéro de la salle requis.)";
        } else {
            $nbsalle = test_input($_POST["nbsalle"]);
            if (!filter_var($nbsalle, FILTER_VALIDATE_INT)) {
                $nbsalleErr = "(Format invalide.)";
            }
        }
    
        if (empty($_POST["capsalle"])) {
            $capsalleErr = "(Capacité de la salle requis.)";
        } else {
            $capsalle = test_input($_POST["capsalle"]);
            if (!filter_var($capsalle, FILTER_VALIDATE_INT)) {
                $capsalleErr = "(Format invalide.)";
            }
        }
        
        if (empty($_POST["nbcinema"])) {
        $nbcinemaErr = "(Association à un cinéma requis.)";
        } else {
            $nbcinema = test_input($_POST["nbcinema"]);
            $selected[$nbcinema] = "selected";
            if (!filter_var($nbcinema, FILTER_VALIDATE_INT)) {
                $nbcinemaErr = "(Format invalide.)";
            }
        }


        // Envoie BDD
        if ( empty($nbsalleErr) AND empty($capsalleErr) AND empty($nbcinemaErr) 
            AND !empty($nbsalle) AND !empty($capsalle) AND !empty($nbcinema) ) {

            // Connexion BDD
            include 'include/connexion.php';

            // Preparation requette
            $requette = array($nbsalle,$capsalle,$nbcinema);
            $stmt = $bdd->prepare("INSERT INTO salle (numero_salle, capacite_salle, id_cinema) 
                                    VALUES (?, ?, ?)");
            foreach ($requette as $key => $value) {
                $stmt->bindValue($key+1, $value);
            }

            // Envoie requette
            $stmt->execute();

            // Message validation
            if($stmt) {
                $validadd="La salle à bien été ajouté !";
            } else{
                $erroradd="Erreur d'envoie !";
            }

            // Fermer le requette
            $stmt->closeCursor();
        }
    }
    ?>



    <div>
        <h1>Ajouter une Salle :</h1>
        <p style='color:red;'><?php echo $erroradd;?></p>
        <p style='color:green;'><?php echo $validadd;?></p>
    </div>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <table>
            <tr>
                <td><label for="nbsalle">Numéro de salle : </label></td>
                <td><input type="text" id="nbsalle" name="nbsalle" size="20" value="<?php echo $nbsalle;?>"></td>
                <td><label for="nbsalle"><?php echo $nbsalleErr;?> </label></td>
            </tr>
            <tr>
                <td><label for="capsalle">Capacité : </label></td>
                <td><input type="text" id="capsalle" name="capsalle" size="20" value="<?php echo $capsalle;?>"></td>
                <td><label for="capsalle"><?php echo $capsalleErr;?> </label></td>
            </tr>
            <tr>
                <td><label for="nbcinema">Cinéma : </label></td>
                <td>
                    <select id="nbcinema" name="nbcinema" size="1">
                        <option value="">Sélectionner un cinéma : </option>
                        <?php 
                        include 'include/connexion.php';
                        $namecinemas = $bdd->query('SELECT id_cinema, nom_cinema from cinema');
                        while ($namecinema = $namecinemas->fetch()) {
                            echo '<option value="'.$namecinema[0].'" '.$selected[$namecinema[0]].'>'.$namecinema[1].'</option>';
                        }
                        $namecinemas->closeCursor();
                        ?>
                    </select>
                </td>
                <td><label for="nbcinema"><?php echo $nbcinemaErr;?> </label></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Envoyer"></td>
            </tr>
        </table>
    </form>


    <a href="infocinema.php?nbcinema=<?php echo $cine ?>"><h3>< Voir les salles</h3></a>
    <a href="index.php"><h3>< Voir les cinémas</h3></a>


    





</body>
</html>