<?php

// Nur POST-Anfragen zulassen
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php#kontakt");
    exit;
}

// Honeypot gegen Spam
if (!empty($_POST["website"])) {
    header("Location: index.php?status=spam#kontakt");
    exit;
}

// Datenschutzerklärung akzeptiert?
if (!isset($_POST["datenschutz"])) {
    header("Location: index.php?status=fehler#kontakt");
    exit;
}

// Eingaben bereinigen
$name = trim(strip_tags($_POST["name"] ?? ""));
$email = trim($_POST["email"] ?? "");
$telefon = trim(strip_tags($_POST["telefon"] ?? ""));
$nachricht = trim(strip_tags($_POST["nachricht"] ?? ""));

// Pflichtfelder prüfen
if (
    empty($name) ||
    empty($email) ||
    empty($nachricht) ||
    !filter_var($email, FILTER_VALIDATE_EMAIL)
) {
    header("Location: index.php?status=fehler#kontakt");
    exit;
}

// Empfänger
$empfaenger = "info@rubincare-solutions.de";

// Betreff
$betreff = "Neue Anfrage über Rubin Care Solutions";

// Nachricht
$text = "Neue Kontaktanfrage\n\n";
$text .= "Name: $name\n";
$text .= "E-Mail: $email\n";
$text .= "Telefon: $telefon\n\n";
$text .= "Nachricht:\n";
$text .= "$nachricht";

// Header
$header = [];
$header[] = "From: Rubin Care Solutions <info@rubincare-solutions.de>";
$header[] = "Reply-To: $email";
$header[] = "Content-Type: text/plain; charset=UTF-8";

// Mail versenden
$erfolg = mail(
    $empfaenger,
    "=?UTF-8?B?" . base64_encode($betreff) . "?=",
    $text,
    implode("\r\n", $header)
);

if ($erfolg) {
    header("Location: index.php?status=erfolg#kontakt");
} else {
    header("Location: index.php?status=fehler#kontakt");
}

exit;