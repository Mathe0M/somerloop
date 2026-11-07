<?php
/**
 * Formulaire de contact somerloop.fr — envoi par e-mail (o2switch, fonction mail()).
 * Anti-spam sans cookie : champ piège, délai minimal de saisie, limite par IP.
 * Aucune donnée n'est stockée sur le serveur (hors compteur anti-abus anonymisé, effacé après 1 h).
 */

// ---- Réglages ----
const TO_EMAIL   = 'contact@somerloop.fr';      // destinataire
const FROM_EMAIL = 'formulaire@somerloop.fr';   // doit exister ou être un alias du domaine
const MIN_SECONDS = 3;                          // délai minimal entre affichage et envoi
const MAX_PER_HOUR = 5;                         // envois max par IP et par heure

header('X-Robots-Tag: noindex');

function back(string $to): void {
    header('Location: ' . $to, true, 303);
    exit;
}
function field(string $name, int $max): string {
    $v = isset($_POST[$name]) && is_string($_POST[$name]) ? trim($_POST[$name]) : '';
    $v = str_replace(["\r\n", "\r"], "\n", $v);
    return mb_substr($v, 0, $max);
}
function oneLine(string $v): string {
    return trim(preg_replace('/[\r\n\t]+/', ' ', $v));
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') back('/contact/');

// 1. Champ piège : rempli = robot. On fait semblant que tout va bien.
if (field('site_web', 200) !== '') back('/merci/');

// 2. Délai minimal
$t = (int) field('t', 20);
if ($t > 0 && (time() - $t) < MIN_SECONDS) back('/merci/');

// 3. Limite par IP (empreinte hachée, rien de lisible n'est conservé)
$ip = $_SERVER['REMOTE_ADDR'] ?? '0';
$key = sys_get_temp_dir() . '/sl_' . hash('sha256', $ip . date('YmdH'));
$count = is_file($key) ? (int) file_get_contents($key) : 0;
if ($count >= MAX_PER_HOUR) back('/contact/?erreur=limite');
@file_put_contents($key, (string) ($count + 1), LOCK_EX);
foreach (glob(sys_get_temp_dir() . '/sl_*') ?: [] as $f) {
    if (filemtime($f) < time() - 7200) @unlink($f);
}

// 4. Validation
$nom        = oneLine(field('nom', 120));
$entreprise = oneLine(field('entreprise', 120));
$email      = oneLine(field('email', 160));
$telephone  = oneLine(field('telephone', 30));
$sujet      = oneLine(field('sujet', 60));
$message    = field('message', 5000);

$sujets = [
    '' => 'Non précisé',
    'immersion-diagnostic' => 'Immersion et diagnostic',
    'logiciel-metier-sur-mesure' => 'Logiciel métier sur mesure',
    'automatisation-connexion-outils' => 'Automatisation et connexion des outils',
    'seo-technique-visibilite-locale' => 'SEO technique et visibilité locale',
    'suivi-evolution' => 'Suivi et évolution',
];

if ($nom === '' || $entreprise === '' || $message === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    back('/contact/?erreur=champs');
}
$sujetLabel = $sujets[$sujet] ?? 'Non précisé';

// 5. Envoi
$subject = 'Nouvelle demande : ' . $entreprise . ' (' . $sujetLabel . ')';
$body = "Nouvelle demande depuis somerloop.fr\n\n"
      . "Nom : $nom\n"
      . "Entreprise : $entreprise\n"
      . "E-mail : $email\n"
      . "Téléphone : " . ($telephone ?: '-') . "\n"
      . "Besoin : $sujetLabel\n"
      . "Date : " . date('d/m/Y H:i') . "\n\n"
      . "Message :\n$message\n";

$headers = [
    'From: Somerloop <' . FROM_EMAIL . '>',
    'Reply-To: ' . $email,
    'MIME-Version: 1.0',
    'Content-Type: text/plain; charset=UTF-8',
    'Content-Transfer-Encoding: 8bit',
];

$ok = mail(
    TO_EMAIL,
    '=?UTF-8?B?' . base64_encode($subject) . '?=',
    $body,
    implode("\r\n", $headers),
    '-f' . FROM_EMAIL
);

back($ok ? '/merci/' : '/contact/?erreur=envoi');
