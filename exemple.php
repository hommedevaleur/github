<?php
$data = json_decode(file_get_contents('php://input'), true);
$data['nom'];

isset($data['nom']) ? $a=$data['nom'] : $a="nom n'existe pas!";
isset($_GET['p']) ? $p=$_GET['p']: $p="p n'existe pas";

$tableau=[$a,$p];
//echo json_encode($tableau);
echo json_encode($data);
?>