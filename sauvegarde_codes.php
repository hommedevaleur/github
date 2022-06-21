<?php
class Model{
 public $db;
 public $table;
 public $id;

function __construct(){
 $this->db=new PDO('mysql:host=localhost;dbname=w2services;charset=utf8','root','',[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]);
}
//FONCTION CONNEXION
public function connexion(){
//
}
//FONCTION READ
public function read($fields=null){

if($fields==null){$fields="*";}
$sql="SELECT $fields FROM ".$this->table;
$req=$this->db->query($sql);
//$datas=$req->fetchAll();
$datas=$req->fetchAll(PDO::FETCH_ASSOC);
$output="";

foreach($datas as $k=>$v){
  $output.='Clé= '.$k;
  $table= $datas[$k];
   foreach($table as $q=>$val){

    $output.='sC:'.$q.'Valeur:'.$val.'<br>';
   }
   $output.='<hr>';
}
echo $output;
}

    
//FONCTION DE MISE A JOUR ET D'INSERTION 
public function save($data){
if(isset($data["id"])&&!empty($data["id"])){//UPDATE
$sql="UPDATE".$this->table."SET";
         foreach($data as $k=>$v){
         if($k!="id"){
          $sql.="$k='$v',";
         }
         $sql=substr($sql,0,-1);
         $sql.="WHERE id=".$data["id"];
        }
        mysql_query($sql) or die(mysql_error());
        }
    else{//INSERT
         $sql="INSERT INTO".$this->table."(";
         foreach($data as $k=>$v){
          $sql.="$k,";
        }
        $sql=substr($sql,0,-1);
        $sql.="VALUES (";
         foreach($data as $v){
          $sql.="$v,";
        }
        $sql=substr($sql,0,-1);
        $sql.=")";
        mysql_query($sql) or die(mysql_error());
        if(!isset($data["id"])||empty($data["id"])){
        $this->id=mysql_insert_id;
        }else{
        $this->id=$data["id"];
        }
    }
}

public function find($data=array(),$db){
    $condition="1=1";
    $fields="*";
    $limit="";
    $order="id DESC";
    if(isset($data["conditions"])){$conditions=$data["conditions"];}
    if(isset($data["fields"])){$fields=$data["fields"];}
    if(isset($data["limit"])){$limit="LIMIT ".$data['limit'];}
    if(isset($data["order"])){$order=$data['limit'];}
    $sql="SELECT $fields FROM ".$this->table." WHERE $condition ORDER BY $order $limit";
    $d=array();
    $requete=$db->query($sql);
    $resultats=$requete->fetchAll();
    return $resultats;
  }

public function frmInsert($table){
//recuperer les champs d'une table
$sql="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '".$table."'";
$champ_table=array();
$req=$this->db->query($sql);
$datas=$req->fetchAll(PDO::FETCH_ASSOC);
var_dump($datas);
  foreach($datas as $k=>$v){
    foreach($datas[$k] as $value){
      array_push($champ_table,$value);
    }
  }
//Créer le formulaire
$output='<h1>Ajouter '.$table.'</h1>';
$output.='<form action="" method="POST">';
//
foreach($champ_table as $v){
  $output.='<label>'.ucfirst($v).'</label>
  <input type="text" id="'.$v.'" name="'.$v.'">
  <br>';
}
$output.='<input type="submit" id="inscrire" name="inscrire" value="Inscrire"></form>';
echo $output;
}

//Créer un formulaire de mise à jour
public function frmLoad($table){
//récuperer les informations avec l'ID
$sql="SELECT * FROM ".$table." WHERE id_".$table." = '".$this->id."'";
$req=$this->db->query($sql); 
$datas=$req->fetch(PDO::FETCH_ASSOC);
//
$output='<h1>Mise à jour de la table: '.$table.' ou ID: '.$this->id.'</h1>';
$output.='<form action="" method="POST">';
foreach($datas as $k=>$v){
  if($k!="id_".$table){
    $output.=ucfirst($k).' <input type="text" id='.$k.' name='.$k.' value="'.$v.'"/><br>';
  }
}
  $output.='<input type="submit" id="update" name="update" value="Mettre à jour"></form>';
  echo $output;
  }

}
?>