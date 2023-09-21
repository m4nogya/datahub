<?php
/* captcha image generator function
* caution no error report at generation */

/* data members set up
* ------------------------------------------------------------- */
/* string size number */
$digit = 10;

/* string setup (prevent 1 and i for confusion) */
$chaine = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';

/* default background image */
$image_file = 'Images/captcha.png';

/* truetype font */
$font = 'Fonts/Cartoon.ttf';

/* image string setup */
$PARAMS = array (
	"size"			=> 34,
	"angle_max"	=> 35,
	"space_max"	=> 2,
	"top"				=> 70,
	"color"			=> array(140, 0, 140)
);

/* functions
* ------------------------------------------------------------- */
/* digit number and setup code generation */
function getCode($length, $chars) {
	$code = null;
	for ($i = 0; $i < $length; $i++) {
		$code .= $chars { mt_rand( 0, strlen($chars) - 1 ) };
		}
	return $code;
	};

/* procedural image generation
* ------------------------------------------------------------- */
/* init image file based on */
$image = imagecreatefrompng($image_file);

/* string coloration */
$color = imagecolorallocate($image, $PARAMS['color'][0], $PARAMS['color'][1], $PARAMS['color'][2]);

/* function call to get random string
* easily recover to submit form and compare result */
$code = getCode($digit, $chaine);

/* chars in the string threated one by one */
for ($nb = 0; $nb < $digit; $nb++) {

	$char = substr($code, $nb, 1);
	/* string placement with randomized negative angle limiter */
	$angle = rand($PARAMS['angle_max'] * -1, $PARAMS['angle_max']);
	/* string placement with randomized space limiter */
	$posx = ($nb > 0) ? $posx + rand(0, $PARAMS['space_max']) + $PARAMS['size'] : 10;
	/* string placement over image */
	imagettftext($image, $PARAMS['size'], $angle, $posx, $PARAMS['top'], $color, $font, $char);
	}

/* image processing
* ------------------------------------------------------------- */

/* http header to send before */
header('Content-Type: image/png');

/* png file generated for browser */
imagepng($image);

/* image destruct memory alloc */
imagedestroy($image);

?>