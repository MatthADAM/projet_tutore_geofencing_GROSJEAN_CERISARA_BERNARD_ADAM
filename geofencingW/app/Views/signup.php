<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Sign Up</title>
	<meta name="description" content="The small framework with powerful features">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/login.css" />
</head>
    <body>
        <div id="container">
            <!-- zone de creation de compte -->
            
            <form action="verification.php" method="POST">
                <h1>Créer un compte</h1>
                
                <label><b>Adresse Mail</b></label>
                <input type="text" placeholder="Entrer l'adresse mail" name="mail" required>

                <label><b>Mot de passe</b></label>
                <input type="password" placeholder="Entrer le mot de passe" name="password" required>

                <label><b>Mot de passe</b></label>
                <input type="password" placeholder="Confirmer le mot de passe" name="password" required>

                <input type="submit" id='submit' value='Créer un compte' >
                <button type="submit" onclick="window.location.href = '../'">Se connecter</button>
                <?php
                if(isset($_GET['erreur'])){
                    $err = $_GET['erreur'];
                    if($err==1 || $err==2)
                        echo "<p style='color:red'>Les mots de passe ne correspondent pas</p>";
                }
                ?>
            </form>
        </div>
    </body>
</html>