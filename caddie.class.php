<?php

class Caddie
{

    // Attributs de la classe

    private array $produits;
    private float $tva;
    private int $nbProduits;
    private float $prixTotalHT;
    private const MAX_PRODUITS = 100;


    public function __construct(float $tva = 20.0)
    {
        // FAIT : S'assurer que la TVA passée en paramètre est >= 0
        if ($tva >= 0) {
            $this->tva = $tva;
        }
        $this->produits = [];
        $this->nbProduits = 0;
        $this->prixTotalHT = 0;
    }


    // private const MAX_PRODUITS = 100;

    // public function __construct(
    //     private float $tva = 20.0
    // ) {
    //     $this->setTva($tva);
    //     $this->produits = [];
    //     $this->nbProduits = 0;
    //     $this->prixTotalHT = 0.00;
    // }



    public function setTva(float $tva): bool
    {
        // FAIT : S'assurer que la TVA passée en paramètre est >= 0 (la méthode retournera false si ce n'est pas le cas)
        if ($tva >= 0) {
            return true;
        }
        return false;
    }

    // ----------------------------

    public function getTva(): float
    {
        return $this->tva;
    }

    private function coefTva(): float
    {
        return 1 + $this->tva / 100;
    }

    public function ajoutProduit(array $produit): bool
    {
        // FAIT : Avant d'ajouter le produit, vérifier si le caddie n'est pas plein (par rapport à la constante MAX_PRODUITS, retourner false le cas échéant)
        if (($this->nbProduits + 1) <= self::MAX_PRODUITS) {
            $this->produits[$produit['id']] = $produit;
            $this->produits[$produit['id']]['qtt'] = 1;
            $this->nbProduits += 1;
            $this->prixTotalHT = $this->prixTotalHT + $produit['prix_ht'];
            return true;
        }
        return false;
    }

    public function supprimerProduit(int $id): bool
    {
        // S'il existe dans le caddie un produit dont l'identifiant vaut $id...
        if (array_key_exists($id, $this->produits)) {
            // (1) Récupérer la quantité actuelle $qttActuelle du produit dont l'identifiant vaut $id dans le caddie
            $qttActuelle = $this->produits[$id]['qtt'];
            // (2) Mettre à jour le prix total du caddie. $this->prixTotalHT vaut $this->prixTotalHT - (prix unitaire ht du produit * $qttActuelle)
            $this->prixTotalHT = $this->prixTotalHT - ($this->produits[$id]['prix_ht'] * $qttActuelle);
            // (3) Mettre à jour le nombre total de produits dans le caddie. $this->nbProduits vaut $this->nbProduits - $qttActuelle 
            $this->nbProduits = $this->nbProduits - $qttActuelle;
            // (4) Supprimer le produit dont l'identifiant vaut $id de la liste des produits du caddie
            unset($this->produits[$id]);
            return true;
        } else {
            return false;
        }
    }

    public function modifierQttProduit(int $id, int $qtt): bool
    {
        // FAIT : Avant d'ajouter le produit, vérifier si le caddie n'est pas plein (par rapport à la constante MAX_PRODUITS, retourner false le cas échéant)
        if (($this->nbProduits + $qtt) <= self::MAX_PRODUITS && array_key_exists($id, $this->produits)) {
            // Ci-dessous, $qttActuelle doit prendre la valeur actuelle de la quantité du produit dans le caddie
            $qttActuelle = $this->produits[$id]['qtt'];
            $this->produits[$id]['qtt'] = $qtt;
            // Le prix total vaut : le prix total actuel - ($qttActuelle * le prix unitaire du produit) + (la nouvelle quantité $qtt * le prix unitaire du produit)
            $this->prixTotalHT = $this->prixTotalHT + ($qtt - $qttActuelle) * $this->produits[$id]['prix_ht'];
            // Le nombre total de produits vaut : le nombre total actuel - $qttActuelle + la nouvelle quantité $qtt
            $this->nbProduits = $this->nbProduits - $qttActuelle + $qtt;
            return true;
        }
        return false;
    }

    public function getNbProduits(): int
    {
        return $this->nbProduits;
    }

    public function getPrixTotalHT(): float
    {
        return $this->prixTotalHT;
    }

    public function getPrixTTC(): float
    {
        return $this->prixTotalHT * $this->coefTva();
    }

    public function printProduits(): string
    {
        $strProduits = "<pre>"
            . print_r($this->produits, true)
            . "</pre>";
        return $strProduits;
    }

    public function __toString()
    {
        return $this->getnbProduits() . " article(s) pour un prix total TTC de " . $this->getPrixTTC() . " euro(s).";
    }

    public function __destruct()
    {
    }
}
