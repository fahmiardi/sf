<?php
/*
Copyright (C) 2007  Tubagus Rafi Kusuma

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

error_reporting(E_ALL);
session_start();
//Please modify this file to match your environment.


include_once('ratcha.php');

//Generate a random text.
//Feel free to replace this with a custom solution.
$t =  md5(uniqid(rand(), 1));

//You can eliminate the above variable ($CAPTCHA_SESSION_KEY) and use 
// the key string literal directly below.

$_SESSION['ratcha'] =  $text = substr($t, rand(0, (strlen($t)-6)), rand(3,6));
$image_width = 150;
$image_height = 30;
$font_size = 15;
$font_depth = 1; //this is the size of shadow behind the character creating the 3d effect.

$img = new RatchaGif($image_width, $image_height);

//could not find a better name.
if($img->create()){
	
	//fill the background color.
	$img->apply(new GradientEffect());
	$t  = new TextEffect($text, $font_size, $font_depth);
	$t->addFont('verdana.ttf');
	// repeat the process for as much fonts as you want. Actually, the more the better.
	// A font type will be randomly selected for each character in the text code.
	$img->apply($t);
	//Output the image.
	$img->render();
}
?>