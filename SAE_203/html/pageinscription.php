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
                <fieldset>
                    <legend>Te connaître</legend>
                <div class="form-column">
                    <label for="pseudo">Pseudo :</label>
                    <input minlength="3" pattern="^[A-Za-z]+[\d\p{L}]{2,}" id="pseudo" type="text" name="pseudo" placeholder="Entrer votre pseudo" title="Le format attendu est de minimum 3 caractères" required="">
                </div>
                <div class="form-column">
                    <label for="datNais">Date de naissance :</label>
                    <input id="dateNais" type="date" name="dateNais" max="2012-01-01" placeholder="Entrer votre date de naissance" title="L'âge autorisé est de minimum 12 ans" required="">
                </div>
                <div class="form-column">
                    <label for="message">Adresse mail :</label>
                    <input id="email" type="email" name="email" placeholder="Entrer votre adresse mail"></input>
                </div>
                </fieldset>


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
        </div>
    </section>

</body>

</html>