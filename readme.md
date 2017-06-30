# SmartLabel PHP SDK

Le SDK SmartLabel vous permet d'intégrer rapidement et simplement
les webservices d'Adesa dans vos applications PHP. Il vous permet
de calculer des prix, créer des devis, les transformer en commande
et uploader les fichiers

- [x] Liste des mandrins, matériaux et finitions disponibles
- [x] Calcul de prix
- [x] Création de commande
- [x] Multi-modèles
- [x] Transfert de fichier
- [x] Traduction et libellés commerciaux des matériaux, finitions et mandrins
- [ ] Génération du formulaire HTML
- [ ] Mise en cache des retours Webservice


## Pré-requis

`PHP >= 5.3` avec les extensions `php-soap`

## Installation

Vous pouvez installer le SDK de trois façons :

1. En utilisant l'invite de commande composer
```bash
$ composer install "adesa/smartlabel-client"
```

2. En ajoutant `adesa/smartlabel-client` à vos dépendances dans le fichier `composer.json`

```json
{
    "require": {
      "adesa/smartlabel-client": "*"
    }
}
```

3. En téléchargeant le tarball sur Github. *Déconseillé*

## Configuration

1. Récupérer votre identifiant revendeur ainsi que vos informations de connexion FTP auprès d'Adesa.
2. Ajouter ces informations dans un fichier de configuration `.ini` ou un tableau associatif PHP

```ini
# ./config/smartlabel.ini

locale = {fr|en|es|…}
localeBasePath = ../locale
identifiantRevendeur = {votre identifiant revendeur}

[FTP]
host = adesaweb.adesa.fr
user = {votre login FTP}
password = {votre mot de passe FTP}
```

```php
$config = \Adesa\SmartLabelClient\Config::fromIniFile(__DIR__ . "/../config/smartlabel.ini");
```

ou

```php
$config = \Adesa\SmartLabelClient\Config::fromArray([
    "locale" => "fr-FR",
    "localeBasPath" => "../locale",
    "identifiantRevendeur" => "{votre identifiant revendeur}",
    "ftp" => [
        "host" => "adesaweb.adesa.fr",
        "user" => "{votre identifiant revendeur}"
        "password" => "{votre mot de passe FTP}"
    ]
]);
```

3. Instancier la classe `SmartLabel` en lui passant la configuration

```php
$smartLabel = new \Adesa\SmartLabelClient($config);
```

## Usage

### Les différents mandrins

Les Webservices Adesa SmartLabel proposent deux diamètres de mandrin :

- Mandrin de 40mm
- Mandrin de 76mm

Ce diamètre est particulièrement important dans le cas d'une pose automatique, car s'il
est de la mauvaise taille, il ne pourra pas s'adapter sur la machine de pose.

Pour récupérer la liste des mandrins disponibles, il faut appeler la méthode suivante :

```php
$smartLabel->listeMandrins(); // retourne un tableau d'objet Mandrin
```

### Récupérer la liste des matières

Une matière est le support sur lequel est imprimé le visuel.
Le webservice propose les supports suivants (peut évoluer) :

- Couché enlevable
- Couché permanent
- Papier de création naturel
- Papier de création perlé
- Polypropylène argent brillant
- Polypropylène blanc brillant
- Polypropylène transparent

```php
$matieres = $smartLabel->listeMatieres(); // tableau d'objet Matière

$select = "<select name=matieres>";
foreach($matieres as $matiere){
    $select.= '<option value="' . $matiere->numero . '">';
    $select.= $smartLabel->label($matiere);
    $select.= '</option>';
 }
$select.= "</select>";
```

### Récupérer les finitions

Une finition est un procédé technique qui est appliqué sur la matière après impression. Les
 finitions disponibles sont fonction de la matière sélectionnée (peut évoluer)
Le webservice propose les finitions suivantes :

- Vernis brillant
- Pelliculage brillant
- Pelliculage mat

```php
$matiere = $smartLabel->trouverMatiere($_GET['numero_matiere']);
// Les finitions disponibles sont fonctions de la matière sélectionnée
$finitions = $smartLabel->listeFinitions($matiere);

$select = "<select name=finitions>";
foreach($finitions as $finition){
    $select.= '<option value="' . $finition->numero . '">';
    $select.= $smartLabel->label($finition);
    $select.= '</option>';
 }
$select.= "</select>";
```

### Demander un prix

Pour calculer le prix d'une impression d'étiquette, il faudra tout d'abord connaitre le scénario
de fabrication. Pour cela, il convient d'appeler la méthode suivante :

<blockquote>
Le multi-modèle consite en l'impression de visuels différents sur des stickers partageant les
mêmes caractéristiques : dimensions, matériau, finition, etc.
</blockquote>

```php
$scenario = $smartLabel->trouverScenario($matiere, $finition);
```

Il faut ensuite appeler la méthode `demandePrix`, qui prend les arguments suivants :

- `scenario` : le scénario qui vient d'être trouvé par la combinaison matière / finition
- `quantite` : le nombre total d'étiquettes à produire, tous modèles confondus
- `hauteur` : la hauteur en millimètres d'une étiquette (pas du visuel)
- `largeur` : la largeur en millimètres d'une étiquette (pas du visuel)
- `poseAutomatique` : si `true`, les rouleaux sont destinés à être utilisés avec une
machine de pose automatique. Dans ce cas, il faut bien veiller à passer le bon diamètre de mandrin
et bien vérifier le diamètre total de la bobine
- `mandrin` : le mandrin utilisé
- `nombreEtiquettesParRouleau`
- `nombreRouleaux`
- `rotation` : l'orientation du visuel aposé sur l'étiquette par rapport au sens de
défilement de la bobine
- `quantitesParSerie`
- `nombreSeries`

Le webservice de demande de prix créer un dossier (devis) SmartLabel, qui contient les informations
suivantes :

- `numero` : Numéro de dossier
- `prix` : Le prix d'achat de la commande, en Euro (€)
- `poids`: Le poids du colis en Kg
- `diametre`: Le diamètre des bobines **(à bien vérifier en cas de pose automatique)**

### Créer un bon de commande et ajouter des modèles

Une fois le dossier créé, il est temps de passer commande ! Pour cela, il vous suffit
de passer l'objet Dossier à la méthode `commander`. Vous pouvez passer en argument de cette
méthode un identifiant de commande externe, qui pourra vous servir d'identiant pivot pour
rattacher la commande SmartLabel à votre ERP / système d'informations.

Cette méthode va créer un bon de commande SmartLabel, qui vous servira à décrire la liste des
modèles et leurs fichiers :

```php
$bonDeCommande = $smartLabel->commander($dossier, $myOrder->orderID);

foreach($myOrder->getAttachments() as $attachment){
    $bonDeCommande->ajouterModele($attachment['name'], $attachment['filename']);
}
```

Une fois tous les modèles ajoutés, il ne vous reste plus qu'à finaliser ce bon de commande.

```php
$smartLabel->finaliserBonDeCommande($bonDeCommande);
```

<blockquote>
La finalisation du bon de commande dépose les fichiers sur le FTP d'Adesa et écrit les
fiche de fabrication au format XML.
</blockquote>

### Suivre l'avancement des commandes

Une commande SmartLabel peut se trouver dans quatre états différents :

1. Pas pris en charge
2. En cours
3. Livraison
4. Fichier non conforme

Lorsqu'une commande est en livraison, SmartLabel retourne une URL de tracking vous permettant
de suivre le colis sur le site du transporteur ainsi que des informations de livraison, au format
texte.

Il est conseillé de mettre en place une tâche récurrent (dans la `crontab` par exemple), qui
récupère les statuts de toutes les commandes SmartLabel qui n'ont pas encore été livrées.

```php
// toutes vos commandes d'étiquettes smartlabel dans un tableau associatif
// avec pour clé le numéro de dossier
$orders = DB::fetchSmartLabelOrders();

$etats = $smartLabel->etatDossiers(array_keys($orders));

// Le tableau $etats est composé d'objets EtatDossier
foreach($etats as $numeroDossier => $etat) {
    $order = $orders[$numeroDossier];
    switch($etat->code){
        case EtatDossier::LIVRAISON:
            $order->setState("shipping");
            break;
        case EtatDossier::ERREUR_FICHIER:
            if(!$order->isInState("error")){
                $order->setState("error");
                $order->customer->sendErrorMail();
            }
            break;
    }
}

```