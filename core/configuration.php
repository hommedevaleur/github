<?php
class Model{
 public $db;
 public $table;
 public $id;
 public $requete;

//Le constructeur
function __construct(){
 $this->db=new PDO('mysql:host=localhost;dbname=w2services;charset=utf8','root','',[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]);
 $this->requete=null;
}
///FONCTION DE RECUPERATION///
//FONCTION de recupération de tous les champs d'une table ou d'une requete personnalisée!
public function getAll(){
  if($this->requete==null){
  $sql="SELECT * FROM ".$this->table;
  }
  else if ($this->requete!=null){
  $sql=$this->requete;
  }
  $req=$this->db->query($sql);
  $datas=$req->fetchAll(PDO::FETCH_ASSOC);
  var_dump($datas);
  return $datas;
}

//FONCTION de recupération des champs d'une table ou d'une requete!
public function champsTable(){
  $resultats=array();
  if($this->requete==null){
    $sql="SELECT * FROM ".$this->table;
  }
  else if ($this->requete!=null){
    echo '$requete n"est pas null <br>';
    $sql=$this->requete;
  }
  $req=$this->db->query($sql);
  $datas=$req->fetchAll(PDO::FETCH_ASSOC);


    if(count($datas)==0 AND $this->requete==null){
      echo 'La table est vide';
      $sql="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '".$this->table."'";
      $req=$this->db->query($sql);
      $datas=$req->fetchAll();
      foreach($datas as $data){
        array_push($resultats,$data['COLUMN_NAME']);
       }

    }
    else if(count($datas)>0 AND $this->requete==null){
      foreach($datas[0] as $k=>$v){
        array_push($resultats,$k);
       }
    }
    else if(count($datas)>0 AND $this->requete!=null){
      foreach($datas[0] as $k=>$v){
        array_push($resultats,$k);
       }
    }
    else{
      echo 'la requete est vide! <br>';

    }
 
  //var_dump($resultats);
  return $resultats;
}

//FONCTION de recupération de champs personnalisées d'une table!
public function getValues($data){
    //Déclaration des variables
    isset($data["conditions"])? $condition=$data["conditions"]:$condition="1=1";
    isset($data["fields"])? $fields=$data["fields"]:$fields="*";
    isset($data["limit"]) ? $limit="LIMIT ".$data['limit']:$limit="";
    isset($data["order"]) ? $order="ORDER BY ".$data['order']:$order="";
    //Requête à excécuter
    $sql="SELECT $fields FROM ".$this->table." WHERE $condition $order $limit";
    $requete=$this->db->query($sql);
    $resultats=$requete->fetchAll();
    //
    return $resultats;
}

//FONCTION d'insertion des données ($data) dans la table $this->table
public function insert($data){
  $sql="INSERT INTO ".$this->table." (";
  foreach($data as $k=>$v){
   $sql.="$k,";
 }
 $sql=substr($sql,0,-1);
 $sql.=") VALUES (";
  foreach($data as $k=>$v){
   $sql.="'$v',";
 }
 $sql=substr($sql,0,-1);
 $sql.=")";
 var_dump($data);
 echo $sql;
 
 $req=$this->db->query($sql);
 $req?$resultat=1:$resultat=0;
 echo $resultat;

}
//FONCTION de mise à jour des données ($data) dans la table $this->table
public function update($data){
  $sql="UPDATE ".$this->table." SET ";
  foreach($data as $k=>$v){
   $sql.=$k."='".$v."',";
 }
 $sql=substr($sql,0,-1);
 $sql.=" WHERE id_".$this->table."='".$this->id."'";
 echo $sql.'</BR>';

 $req=$this->db->query($sql);
 $req?$resultat=1:$resultat=0;
 echo $resultat;
}
//FONCTION de suppression de l'entrée d'une table
public function delete($id=null){
  $id==null?$id=$this->id:$id=$id;
  $sql="DELETE FROM ".$this->table." WHERE id_".$this->table."='$id'";
  echo $sql;
}

///FONCTION DE CREATION D'UN FORMULAIRE///
//FONCTION de création d'un formulaire d'enregistrement (INSERT) dans une table!
public function frmInsert(){
  //recuperer les champs d'une table
  $sql="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '".$this->table."'";
  $champ_table=array();
  $req=$this->db->query($sql);
  $datas=$req->fetchAll(PDO::FETCH_ASSOC);

    foreach($datas as $k=>$v){
      foreach($datas[$k] as $value){
        array_push($champ_table,$value);
      }
    }
    //Créer le formulaire!
    $output='<h1>Ajouter '.$this->table.'</h1>';
    $output.='<form action="" method="POST">';
    foreach($champ_table as $k=>$v){
      if($k!='id_'.$this->table){
      $output.='<label>'.ucfirst($v).'</label>
      <input class="form-control form-control-sm" type="text" id="'.$v.'" name="'.$v.'">';
      }
    }
    $output.='<input class="btn btn-sm btn-success my-1" type="submit" id="insert" name="insert" value="Inscrire"></form>';
    echo $output;
}
//FONCTION de création d'un formulaire de mise à jour d'un élémént d'une table donnée!
public function frmUpdate(){
  //récuperer les informations avec l'ID
  $sql="SELECT * FROM ".$this->table." WHERE id_".$this->table." = '".$this->id."'";
  $req=$this->db->query($sql); 
  $datas=$req->fetch(PDO::FETCH_ASSOC);
  //
  $output='<h1>Mise à jour de la table: '.$this->table.' ou ID: '.$this->id.'</h1>';
  $output.='<form action="" method="POST">';
  foreach($datas as $k=>$v){
    if($k!="id_".$this->table){
      $output.=ucfirst($k).' <input class="form-control form-control-sm" type="text" id='.$k.' name='.$k.' value="'.$v.'"/>';
    }
  }
    $output.='<input class="btn btn-sm btn-success my-1" type="submit" id="update" name="update" value="Mettre à jour"></form>';
    echo $output;
}
//

public function viewTable(){
  $sql="SELECT * FROM ".$this->table;
  $titres=$this->champsTable();
  //
  $output='<div class="container"> <h1>Table -> '.ucfirst($this->table).'</h1><table class="table table-sm table-bordered">
  <tr class="table-success">';
  foreach($titres as $titre){
    $output.='<th>'.ucfirst($titre).'</th>';
  }
  $output.='<th colspan="2">Action</th>
  </tr>';

  $req=$this->db->query($sql);
  $resultats=$req->fetchAll(PDO::FETCH_ASSOC);
  if(count($resultats)>0){
  foreach($resultats as $k=>$v){
    $output.='<tr>';
    foreach($resultats[$k] as $key=>$resultat){
    $output.='<td>'.$resultat.'</td>';
   }
   $output.='<td><a class="btn btn-success btn-sm" href="update?id='.$resultats[$k]['id_'.$this->table].'">Editer</a></td>';
   $output.='<td><a class="btn btn-danger btn-sm" href="delete?id='.$resultats[$k]['id_'.$this->table].'">Supprimer</a></td>';
   $output.='</tr>';
   }
  }
 else{

  $output.= '<tr><td colspan="'.count($titres).'">La table est vide !</td></tr>';
 }
 $output.='</table></div>';
 echo $output;

}

//
function setTitle($datas){
  $natives=$this->champsTable();
  foreach($datas as $k=>$v){
    foreach($natives as $k_=>$v_){
      if($v_==$k){
        $natives[$k_]=$v;
      }
  }
    
  
}
return $natives;
}

}

?>