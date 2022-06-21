<?php
$tableaux=[
    ['title'=>'Identifiant',
     'type'=>'text'],
    ['title'=>'Mot de passe',
        'type'=>'password'
]
];

var_dump($tableaux);
$output='<form action="" method="POST" >';
foreach($tableaux as $tableau){
    $output.=$tableau['title'].'<input type="'.$tableau['type'].'" name="'.strtolower($tableau['type']).'"><br>';  

}
$output=substr($output,0,-4);
$output.='</form>';
echo $output;
?>