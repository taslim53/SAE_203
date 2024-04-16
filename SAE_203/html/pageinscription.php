<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'inscription</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="Application pour décourire des langues">
    <script src="scripts/index.js"></script>
    <link rel="stylesheet" href="../css/index.css" type="text/css">
</head>

<body>
    <section id="inscription" class="inscription">
        <div class="container">
            <div class="title">
                <!--     <h6>Venez faire partie de l'équipe !</h6>-->
                <h1>Envie de découvrir le monde ?</h1>
                <h2>Inscrivez-vous !</h2>
                <!--   <h6>N'hésitez pas à me contacter et je vous répondrais dans les plus brefs délais.</h6>-->
            </div>


            <form action="./index.php" method="get">

                <label for="nom">Nom de famille :</label>
                <input id="nom" type="text" name="nom" placeholder="Entrer votre nom de famille" required="">

                <label for="prenom">Prénom :</label>
                <input id="prenom" type="prenom" name="prenom" placeholder="Entrer votre prénom" required="">

                <label for="email">Adresse mail :</label>
                <input id="email" type="email" name="adresseMail" placeholder="Entrer votre adresse mail" required="">

                <label for="phone">Numéro de téléphone :</label>
                <input id="phone" type="number" name="phone" placeholder="Entrer votre numéro de téléphone" required="">

                <label for="message">Message :</label>
                <textarea id="message" type="message" name="message" rows="5" cols="50" placeholder="Entrer votre message"></textarea>
aa
                <?php
                if (isset($_GET["nom"]) && isset($_GET["prenom"]) && isset($_GET["adresseMail"]) && isset($_GET["phone"]) && isset($_GET["message"])) {
                    if (($_GET["nom"] != "") && ($_GET["prenom"] != "") && ($_GET["adresseMail"] != "") && ($_GET["phone"] != "") && ($_GET["message"] != "")) {
                        require(__DIR__ . "/src/PHPMailer.php"); // Ajoute le fichier contenant le code de la classe PHPMailer
                        require(__DIR__ . "/src/SMTP.php"); // le code de la classe SMTP
                        require(__DIR__ . "/src/Exception.php"); // le code de la classe Exception
                        $mail = new PHPMailer\PHPMailer\PHPMailer();
                        // Configuration du serveur SMTP
                        $mail->SMTPDebug = 0; // Active/désactive les messages de mise au point
                        $mail->isSMTP(); // Utilise le protocole SMTP
                        $mail->Host = "smtp.gmail.com"; // Configure le nom du serveur SMTP
                        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS; // Active le cryptage sécurisé TLS
                        $mail->Port = 465; // Configure le numéro de port
                        $mail->SMTPAuth = true; // Active le mode authentification
                        $mail->Username = "taslim.tifaoui@gmail.com"; // Identifiant du compte SMTP
                        $mail->Password = "euzxbmltoynoaqjg"; // Mot de passe du compte SMTP // comm entre la page google et le formulaire
                        // Destinataires
                        $mail->setFrom("taslim.tifaoui@gmail.com", "Mailer: " . $_GET["prenom"] . " " . $_GET["nom"]);
                        $mail->addAddress("Taslim.Tifaoui.Etu@univ-lemans.fr", "Taslim Tifaoui"); // Ajout du destinataire
                        $mail->addAddress($_GET["adresseMail"], $_GET["nom"]);
                        // Contenu du mail
                        $mail->isHTML(true);
                        $mail->Subject = "Formulaire de contact";
                        $mail->Body = "Je vous remercie d'avoir pris contact. Merci " . $_GET["nom"] . "Votre nom est : " . $_GET["nom"] . "\n"
                            . "Votre prénom est : " . $_GET["prenom"] . "\n"
                            . "Votre adresse mail est : " . $_GET["adresseMail"] . "\n"
                            . "Votre numéro de téléphone est : " . $_GET["phone"] . "\n"
                            . "Votre message est : " . $_GET["message"] . "\n";

                        $mail->CharSet = PHPMailer\PHPMailer\PHPMailer::CHARSET_UTF8;
                        if ($mail->send() != false) {
                            echo ("Le message électronique a été transmis.\n");
                            /* header("Location: ./#contact");*/
                        } else {
                            echo ("Le message électronique n'a pas été transmis.\n");
                            echo ("Mailer Error: " . $mail->ErrorInfo);
                        }
                    }
                }
                ?>

                <button type="submit">Envoyer</button>
            </form>
            <!--  <div>
                    <img class="imageporte" src="images/porteouverte.jpg" alt="porteouverte">
                </div>
              !-->
        </div>
    </section>
    
</body>
</html>