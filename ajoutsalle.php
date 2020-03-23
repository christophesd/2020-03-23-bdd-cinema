<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Salle</title>
</head>

<body>

    <?php 
    // Init var
    $nbsalleErr = $capsalleErr = $nbcinemaErr = "";
    $nbsalle = $capsalle = $nbcinema = "";
    $validadd = $erroradd = "";

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
            $requette = array($name,$city,$adress,$mail,$number);
            $stmt = $bdd->prepare("INSERT INTO cinema (nom_cinema, ville_cinema, adresse_cinema, mail_cinema, telephone_cinema) 
                                    VALUES (?, ?, ?, ?, ?)");
            foreach ($requette as $key => $value) {
                $stmt->bindValue($key+1, $value);
            }

            // Envoie requette
            $stmt->execute();

            // Message validation
            if($stmt) {
                $validadd="Le cinema à bien été ajouté !";
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
                        <option>Sélectionner un cinéma : </option>
                        <?php 
                        include 'include/connexion.php';
                        $namecinemas = $bdd->query('SELECT id_cinema, nom_cinema from cinema');
                        while ($namecinema = $namecinemas->fetch()) {
                            echo '<option value="'.$namecinema[0].'">'.$namecinema[1].'</option>';
                        }
                        $cinemas->closeCursor();
                        ?>
                    </select>
                </td>
                <td><label for="nbcinema"><?php echo $nbcinema;?> </label></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Envoyer"></td>
            </tr>
        </table>
    </form>


    <a href="index.php"><h3>< Voir les cinémas</h3></a>


    





</body>
</html>