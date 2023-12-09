<?php
if (!isset($_SERVER['HTTP_REFERER']) || parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) != $_SERVER['SERVER_NAME']) {
  die("Accès non autorisé.");
}
session_start();

function generateCode() {
  $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
  $length = rand(2, 6);
  $puzzle = '';

  for ($i = 0; $i < $length; $i++) {
      $puzzle .= $chars[rand(0, strlen($chars) - 1)];
  }

  return rand(100, 9999) . $puzzle;
}

// Génération d'un code aléatoire
$code = generateCode(); 
$_SESSION["captcha"] = $code;

// Création de l'image
$width = strlen($code) * 10;
$height = 24;
$image = imagecreate($width, $height);
$background = imagecolorallocate($image, rand(0,100), rand(0,100), rand(0,100));
$text_color = imagecolorallocate($image, rand(150,255), rand(150,255), rand(150,255));
$line_color = imagecolorallocate($image, rand(100,150), rand(100,150), rand(100,150));

// Ajouter des lignes aléatoires
for ($i = 0; $i < 10; $i++) {
    imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $line_color);
}

// Ajout du code à l'image
imagestring($image, 5, 5, 5, $code, $text_color);

// Affichage de l'image
header("Content-type: image/png");
imagepng($image);
imagedestroy($image);
?>
