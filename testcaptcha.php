<?php
function generateImage($text, $file) {
  $im = @imagecreate(74, 25) or die("Cannot Initialize new GD image stream");
  $background_color = imagecolorallocate($im, 200, 200, 200);
  $text_color = imagecolorallocate($im, 0, 0, 0);
  imagestring($im, 5, 5, 5,  $text, $text_color);
  imagepng($im, $file);
  imagedestroy($im);
}
$captchaImage = 'captcha/captcha'.time().'.png';
generateImage($expression->n1.' + '.$expression->n2.' =', $captchaImage);