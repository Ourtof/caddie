<?php
include('caddie.class.php');

$catalogue = [
    0 => [
        'id' => 27,
        'nom' => 'lait',
        'designation' => 'Lait de vache.',
        'prix_ht' => 4.00,
    ],
    1 => [
        'id' => 122,
        'nom' => 'chocolat',
        'designation' => 'chocolat noir.',
        'prix_ht' => 2.50,
    ],
    2 => [
        'id' => 34,
        'nom' => 'pâtes',
        'designation' => 'Des féculents pour toute la famille.',
        'prix_ht' => 8.50,
    ]
];

$caddie1 = new caddie();

$caddie1->ajoutProduit($catalogue[0]);
$caddie1->ajoutProduit($catalogue[1]);
$caddie1->ajoutProduit($catalogue[2]);

$caddie1->modifierQttProduit(27, 3);
$caddie1->setTva(10);

$caddie1->supprimerProduit(27);

echo $caddie1->printProduits();

// méthode magique __toString

// echo $caddie1;

// echo $caddie1->tva;

// 3eme question : 
// On obtient une erreur fatale.
// La raison est que la variable TVA est privée, et ne peut donc accéder à cette dernière.

?>
