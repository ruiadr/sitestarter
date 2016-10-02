# SiteStarter

SiteStarter permet à tout intégrateur/développeur de mettre en place simplement et rapidement un site internet, il utilise le framework `Slim` pour la gestion des routes.

## Installation

```
git clone https://github.com/ruiadr/sitestarter.git
composer install
```

## VHOST
```apache
<VirtualHost *:80>
    ServerName MON.DOMAINE.COM
    DocumentRoot /CHEMIN/VERS/LE/REPERTOIRE/web

    <Directory /CHEMIN/VERS/LE/REPERTOIRE/web>
        AllowOverride All
    </Directory>
</VirtualHost>
```
## Utilisation

### Route à l'aide de fichiers

Les fichiers placés à la racine du répertoire `app/design/` suffisent à créer des routes.
Exemple, en créant le fichier `app/design/contact.phtml`, la route `http://MON.DOMAINE.COM/contact` deviendra accessible et retournera le contenu du template `contact.phtml`.

### Route à l'aide de controleurs

Les fichiers de classe PHP placés à la racine du répertoire `app/controllers/` permettront la création de routes à condition:
- Qu'elles héritent de la classe: `Starter\Controller\Base`.
- Que le nom du fichier soit composé, du nom de la route suivi de `Controller` (sensible à la case), exemple `MyController`.
- Que les actions soient nommées ainsi: `<NOM_METHODE_ROUTE>Action`.

De la sorte, un controleur définit comme suit:

```php
class MyController extends Base {
    public function testAction () {/* ... */}
    public function test2Action () {/* ... */}
}
```

proposera les routes `http://MON.DOMAINE.COM/my/test` et `http://MON.DOMAINE.COM/my/test2`

### Exemples

Le dépôt est mis à disposition avec différents exemples:
- Création de routes en mode "fichier".
- Création de routes en mode "Controleur".
- Utilisation de différents layouts.
- Utilisation de variables globales.
- Utilisation de ressources statiques (CSS / JS / Images) à l'aide de fichiers de configuration (.yml).
