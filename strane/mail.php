<?php

$ime = $_POST['ime70x50'];
$ulica = $_POST['ulica70x50'];
$mesto = $_POST['mesto'];
$mail = $_POST['email'];
$tel = $_POST['tel'];
$napomena = $_POST['napomena'];

function poruka() {
echo "ime:".$ime."<br>"."ulica: ".$ulica."<br>"."mesto: ".$mesto."<br>"."email: ".$mail."<br>".
"telefon: ".$tel."<br>"."napomena: ".$napomena;
}

echo poruka();

