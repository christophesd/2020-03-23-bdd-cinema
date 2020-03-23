<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Cinéma</title>
</head>

<body>

    <?php 
    // Init var
    $nameErr = $cityErr = $adressErr = $mailErr = $numberErr = "";
    $name = $city = $adress = $mail = $number = "";
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
        
        if (empty($_POST["name"])) {
        $nameErr = "(Nom requis.)";
        } else {
        $name = test_input($_POST["name"]);
        }
        
        if (empty($_POST["city"])) {
        $cityErr = "(Ville requis.)";
        } else {
        $city = test_input($_POST["city"]);
        }
        
        if (empty($_POST["adress"])) {
        $adressErr = "(Adresse requis.)";
        } else {
        $adress = test_input($_POST["adress"]);
        }
    
        if (empty($_POST["mail"])) {
            $mailErr = "(Email requis.)";
        } else {
            $mail = test_input($_POST["mail"]);
            if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "(Format de l'email invalide.)";
            }
        }
        
        if (empty($_POST["number"])) {
        $numberErr = "(Numero requis.)";
        } else {
        $number = test_input($_POST["number"]);
        }


        // Envoie BDD
        if ( empty($nameErr) AND empty($cityErr) AND empty($adressErr) AND empty($mailErr) AND empty($numberErr) 
            AND !empty($name) AND !empty($city) AND !empty($adress) AND !empty($mail) AND !empty($number) ) {

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
        <h1>Ajouter un Cinéma :</h1>
        <p style='color:red;'><?php echo $erroradd;?></p>
        <p style='color:green;'><?php echo $validadd;?></p>
    </div>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <table>
            <tr>
                <td><label for="name">Nom du cinema : </label></td>
                <td><input type="text" id="name" name="name" size="50" value="<?php echo $name;?>"></td>
                <td><label for="name"><?php echo $nameErr;?> </label></td>
            </tr>
            <tr>
                <td><label for="city">Ville : </label></td>
                <td><input type="text" id="city" name="city" size="50" value="<?php echo $city;?>"></td>
                <td><label for="city"><?php echo $cityErr;?> </label></td>
            </tr>
            <tr>
                <td><label for="adress">Adresse : </label></td>
                <td><input type="text" id="adress" name="adress" size="50" value="<?php echo $adress;?>"></td>
                <td><label for="adress"><?php echo $adressErr;?> </label></td>
            </tr>
            <tr>
                <td><label for="mail">Email : </label></td>
                <td><input type="email" id="mail" name="mail" size="50" value="<?php echo $mail;?>"></td>
                <td><label for="mail"><?php echo $mailErr;?> </label></td>
            </tr>
            <tr>
                <td><label for="number">Numéro de téléphone : </label></td>
                <td><input type="text" id="number" name="number" size="50" value="<?php echo $number;?>"></td>
                <td><label for="number"><?php echo $numberErr;?> </label></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Envoyer"></td>
            </tr>
        </table>
    </form>


    <a href="index.php"><h3>< Voir les cinémas</h3></a>


    





</body>
</html>