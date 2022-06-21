<?php
//Inclusion des fichiers sources
require_once 'core/lien.php';
require_once 'core/meta.php';
require_once 'core/configuration.php';



//Declaration de la classe et de ses propriétés
$model=new Model();
$model->table="personnel";
var_dump($model->champsTable());

$data=['id_personnel'=>'DIAMAK N_',
       'civilite'=>'M/Mme/Mlle',
       'motdepasse'=>'P@ssword',
       'profile'=>'About' ];



var_dump($model->setTitle($data));

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
datalist {
  position: absolute;
  max-height: 20em;
  border: 0 none;
  overflow-x: hidden;
  overflow-y: auto;
}

datalist option {
  font-size: 0.8em;
  padding: 0.3em 1em;
  background-color: #ccc;
  cursor: pointer;
}

/* option active styles */
datalist option:hover, datalist option:focus {
  color: #fff;
  background-color: red;
  outline: 0 none;
}
input::-webkit-calendar-picker-indicator {
  display: none;
}



</style>
<body>
<input list="encodings" value="" class="col-sm-6 form-control form-control-sm">
<datalist id="encodings">
    <option value="ISO-8859-1">ISO-8859-1</option>
    <option value="cp1252">ANSI</option>
    <option value="utf8">UTF-8</option>
</datalist>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/datalist-css/dist/datalist-css.min.js"></script>