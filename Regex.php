<?php
$pattern = '/^cat|c.|paw$/';
if(preg_match($pattern, 'ca paw', $match))echo"Found<br>"; 
if(preg_match($pattern, 'ca ear'))echo"Found<br>"; 
if(preg_match($pattern, 'ca'))echo"Found<br>"; 


$attern = '/.*a{1,3}.$/';
if(preg_match($attern, 'afasaasaaar'))echo"Found1<br>"; 

$ttern = '/a*/';
if(preg_match($ttern,'da'))echo"Found2<br>";   
if(preg_match($ttern, 'da'))echo"Found2<br>";  
if(preg_match($ttern, 'dsbsa'))echo"Found2<br>";    

$numpt='/\D/';

if(preg_match($numpt, "2w"))echo"Num Found<br>";

$cpattern="/.[aeiou]./";

if(preg_match($cpattern, "Sudip"))echo"Found Character<br>";

$pattern = '/\w+/';
$string = "sudip@#$@";
if(preg_match($pattern, $string))echo"Special Character<br>"; 

?>