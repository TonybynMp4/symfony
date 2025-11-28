# 1. Nouveautée entre PHP 4.0 et PHP 8.0
## Structuration du code : namespaces, traits, closures
### Namespaces (Depuis PHP 5.3)

Les Namespaces permettent d'éviter les collisions de noms et d'organiser le code par domaine.

```php
<?php

namespace App\Service;

class Mailer
{
    public function send(string $to, string $message): void
    {
        // ...
    }
}
```

Sans namespace, si deux classes `Mailer` existent dans des bibliothèques différentes, il y aurait un conflit.

### Closures / fonctions anonymes (Depuis PHP 5.3)

Les closures permettent de définir des fonctions sans nom, souvent utilisées comme callbacks.

```php
<?php

$numbers = [1, 2, 3];

$doubles = array_map(function (int $n): int {
    return $n * 2;
}, $numbers);
```

## Performances (PHP 7)

Une amélioration majeure des performances a été introduite avec PHP 7, ainsi qu'une consommation mémoire réduite.

---

## Typage renforcé (PHP 8)

PHP 7+ introduit progressivement de nouveaux types natifs et le mode strict.

### Exemple : fonction sans type vs avec type

Avant (PHP 4/5) :

```php
<?php

function add($a, $b)
{
    return $a + $b;
}
```

On peut appeler `add('foo', [])` sans erreur claire.

Avec PHP 7+ :

```php
<?php

declare(strict_types=1);

function add(int $a, int $b): int
{
    return $a + $b;
}

add(1, 2); // OK
add('1', 2); // TypeError en mode strict => bug détecté plus tôt
```

**Intérêt** : détection de bugs à l'exécution, meilleure auto-complétion IDE, refactorings plus sûrs.

---

## 1.5. Nouvelles syntaxes/productivité (PHP 7.4 & 8.0)

### Propriétés typées (7.4)

```php
<?php

class Product
{
    public int $id;
    public string $name;
}
```

### Arrow functions (7.4)

```php
<?php

$names = array_map(fn ($user) => $user->getName(), $users);
```

### Constructor property promotion (8.0)

```php
<?php

class UserDto
{
    public function __construct(
        public int $id,
        public string $name,
        public ?string $email = null,
    ) {
    }
}
```

Au lieu de déclarer les propriétés + les affecter dans le constructeur, tout est compacté.

### `match` expression (8.0)

```php
<?php

$status = 404;

$message = match ($status) {
    200, 201 => 'OK',
    400 => 'Bad request',
    404 => 'Not found',
    default => 'Unknown',
};
```

Plus sécurisé que `switch` (évaluation stricte, pas de `break` oublié).

---

## 1.6. PHP 8.0 : JIT, union types, attributes

D'après la doc officielle PHP 8 (`php.net/releases/8.0`) :

- **JIT** : compilation Just-In-Time pour des workloads CPU intensifs
- **Union types** : `public int|string $value;`
- **Attributes** (métadonnées natives) :

```php
<?php

#[Route('/users', methods: ['GET'])]
class UserController
{
}
```

En Symfony/Doctrine, ça remplace progressivement les annotations DocBlock (doctrine/annotations).

---

# 2. Deux fonctions anciennes remplacées

## 2.1. API `mysql_*` → `mysqli` / PDO

### Statut

- Extension `mysql` : **dépréciée en PHP 5.5**, **supprimée en PHP 7.0**
- Références : `mysql_query`, `mysql_connect`, etc. (cf. PHP manual / migration guides)

### Pourquoi supprimée ?

- Pas de prepared statements → risques d'injection SQL
- Pas de support moderne (Unicode, SSL, etc.)
- API spécifique MySQL, difficile à abstraire

### Remplacement : PDO (recommandé)

Avant (legacy) :

```php
<?php

$conn = mysql_connect('localhost', 'user', 'pass');
mysql_select_db('mydb', $conn);

$result = mysql_query(
    "SELECT * FROM user WHERE email = '" . $_GET['email'] . "'"
);

while ($row = mysql_fetch_assoc($result)) {
    echo $row['email'];
}

mysql_close($conn);
```

Problèmes : concaténation directe de `$_GET['email']` → injection SQL possible.

Après (PDO + requête préparée) :

```php
<?php

$pdo = new PDO('mysql:host=localhost;dbname=mydb', 'user', 'pass', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

$stmt = $pdo->prepare('SELECT * FROM user WHERE email = :email');
$stmt->execute(['email' => $_GET['email']]);

foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
    echo $row['email'];
}
```

**Gains :**

- Sécurité (paramètres liés)
- Exceptions au lieu de `false` silencieux
- Portabilité (MySQL, PostgreSQL, SQLite, etc.)

---

## 2.2. `split()` → `explode()` / `preg_split()`

### Statut

- `split()` (POSIX regex) : **déprécié en PHP 5.3**, **supprimé en PHP 7.0**
  (cf. doc / migrations 5.3 et 7.0)

### Pourquoi supprimée ?

- Basée sur POSIX regex (vieille techno, lente, incohérente)
- Doublon avec `explode()` pour les cas simples
- Doublon avec les fonctions PCRE (`preg_*`) pour les regex

### Cas 1 : séparation simple → `explode()`

Avant :

```php
<?php

$parts = split(',', 'one,two,three');
```

Après :

```php
<?php

$parts = explode(',', 'one,two,three');
// ['one', 'two', 'three']
```

### Cas 2 : séparation avec motif complexe → `preg_split()`

Avant :

```php
<?php

// séparateur = virgule OU point-virgule
$parts = split('[,;]', 'one,two;three');
```

Après :

```php
<?php

$parts = preg_split('/[,;]/', 'one,two;three');
// ['one', 'two', 'three']
```

**Intérêt :**

- API plus claire (`explode` pour un simple séparateur)
- Performances meilleures
- Une seule famille regex cohérente (`preg_*`).

---

# 3. Migration du projet Ndombi (Symfony 4.4 → version actuelle)

Contexte : Ndombi est en **Symfony 4.4 LTS**, basé sur une version ancienne de Symfony et probablement sur une version ancienne de PHP (PHP ≥ 7.1.3 d'après `symfony.com/releases/4.4`).

## 3.1. Choix de la version cible

D'après les releases officielles Symfony (`symfony.com/releases` et `endoflife.date/symfony`) :

- Symfony 4.4 LTS : fin du support sécurité en **novembre 2023** (obsolète)
- Symfony 6.4 LTS :
  - sortie : nov. 2023
  - support bugs jusqu'en nov. 2026
  - support sécurité jusqu'en nov. 2027
  - **requiert PHP ≥ 8.1**

En novembre 2025, pour un projet legacy qui doit rester stable :

- **Choix recommandé** : **Symfony 6.4 LTS**
  (stabilité long terme, écosystème mature, docs abondantes)
- Éventuel futur : migration plus tard vers Symfony 7.4 LTS (quand stabilisé)

Donc : *objectif du document* = migration Ndombi de **4.4 → 6.4 LTS** sur **PHP 8.1/8.2**.

---

## 3.2. Pré-requis techniques

### Versions cibles

- **PHP** : au minimum 8.1 (idéalement 8.2, toutes deux supportées par PHP au 26/11/2025, cf. `php.net/supported-versions.php`)
- **Symfony** : 6.4.x
- **Composer** : version récente (min. 2.x)
- **Base de données** : version maintenue (MySQL ≥ 5.7 / MariaDB, PostgreSQL, etc.)

### Environnements

1. **Dev** : première cible de migration (sans impact prod)
2. **Staging/preprod** : validation intégration + perf
3. **Prod** : bascule finale contrôlée

---

## 3.3. Plan de migration détaillé

### Étape 0 – Audit de l'existant

- Récupérer `composer.json` / `composer.lock`
  → lister versions exactes : Symfony, Doctrine, API Platform, bundles tiers.
- Noter la version PHP utilisée en prod.
- Identifier l'architecture Ndombi :
  - bundles internes (par ex. `App\NdombiBundle`),
  - modules métier (entités, formulaires, API Platform, sécurité).

Sortie attendue : un **rapport d'audit** avec les points bloquants évidents (PHP < 7.4, bundles non maintenus, etc.).

---

### Étape 1 – Mise à jour de PHP

1. Préparer une branche Git `feature/upgrade-php-8`.
2. Mettre à jour l'environnement de dev vers **PHP 8.1 ou 8.2**.
3. Corriger tous les problèmes **purement PHP** (fonctions supprimées, typage plus strict, etc.) :
   - remplacer `mysql_*`, `split()`, `each()`, `create_function()`, etc.
   - corriger les signatures incompatibles (par ex. ajout de types natifs si nécessaire).

**Recommandation** : activer `error_reporting(E_ALL)` et `display_errors=On` en dev pour voir tous les warnings.

---

### Étape 2 – Nettoyer les dépréciations Symfony 4.4

Objectif : **zéro dépréciation** avant de changer de version majeure.

1. **Activer les logs de dépréciations** :

   - via le `monolog.yaml` ou le handler dédié pour les notices `E_USER_DEPRECATED`.
   - ou l'outil Symfony : PHPUnit Bridge.

2. Installer le PHPUnit bridge (doc : `symfony.com/doc/current/components/phpunit_bridge.html`) :

```bash
composer require --dev symfony/phpunit-bridge
```

3. Lancer les tests :

```bash
php bin/phpunit
# ou ./bin/phpunit selon la config
```

4. Corriger les dépréciations une par une (voir § 3.5 pour 3 exemples concrets).

Sortie attendue : plus de `User Deprecated` liés à **NOTRE** code (les déprécations venant de bundles tiers doivent être traitées par mise à jour de ces bundles).

---

### Étape 3 – Migration Symfony 4.4 → 5.4 LTS

Symfony recommande de passer par la **dernière minor de chaque major**
(doc « Upgrading a Major Version » : `symfony.com/doc/current/setup/upgrade_major.html`).

1. Modifier `composer.json` pour cibler Symfony 5.4 :

```json
{
  "require": {
    "php": "^8.1",
    "symfony/framework-bundle": "5.4.*",
    "symfony/console": "5.4.*",
    "symfony/doctrine-bridge": "5.4.*"
    // ...
  },
  "extra": {
    "symfony": {
      "require": "5.4.*"
    }
  }
}
```

2. Mettre à jour :

```bash
composer update "symfony/*" --with-all-dependencies
```

3. Suivre les fichiers `UPGRADE-5.0.md` puis `UPGRADE-5.1.md` → `UPGRADE-5.4.md`
   dans le repo Symfony (`github.com/symfony/symfony`).

4. Corriger les BC breaks (exemples : sécurité, form, validator, API Platform).

5. Lancer les tests / QA, corriger.

---

### Étape 4 – Migration Symfony 5.4 → 6.4 LTS

1. Mettre à jour `composer.json` pour Symfony 6.4 :

```json
{
  "require": {
    "php": "^8.1",
    "symfony/framework-bundle": "6.4.*",
    "symfony/console": "6.4.*"
    // ...
  },
  "extra": {
    "symfony": {
      "require": "6.4.*"
    }
  }
}
```

2. Mettre à jour :

```bash
composer update "symfony/*" --with-all-dependencies
```

3. Lire et appliquer les guides d'upgrade :
   - `UPGRADE-6.0.md`
   - `UPGRADE-6.1.md` … `UPGRADE-6.4.md`

Points clés entre 5.4 et 6.x :

- Renforcement du typage (types de retour natifs sur beaucoup de composants)
- Changements sur Security (nouvelle authentification, `firewalls` simplifiés)
- API Platform s'aligne sur les attributes PHP 8

4. Adapter le code Ndombi :
   - contrôleurs (héritage, signatures)
   - formulaires (options, types)
   - configuration (`framework.yaml`, `security.yaml`, `doctrine.yaml`, `routes.yaml`)

---

### Étape 5 – Validation fonctionnelle & déploiement

1. **Tests automatiques** : unitaires, fonctionnels, API (Postman / PHPUnit).
2. **Tests manuels métier** : parcours critiques Ndombi (création, consultation,
   modification d'objets métier).
3. Bench de performance rudimentaire (temps de réponse, mémoire).
4. Mise en production progressive :
   - fenêtre de maintenance
   - rollback plan (tag Git/backup DB)
   - monitoring (logs, alertes)

---

## 3.4. Recommandations et règles de sécurité

1. **Versions supportées** :
   - PHP 8.1+ support sécurité jusqu'en 2026/2027 (cf. `php.net/supported-versions.php`)
   - Symfony 6.4 LTS support sécurité jusqu'en 2027 (cf. `symfony.com/releases/6.4`)

2. **Configuration sensible** :
   - ne jamais committer `.env.local`, secrets, clés JWT
   - utiliser le système `secrets` de Symfony pour `APP_SECRET`, mots de passe, etc.

3. **HTTPS partout** :
   - forcer `https` au niveau du reverse proxy
   - configurer `framework.trusted_proxies` et `trusted_headers` pour prendre en
     compte `X-Forwarded-Proto`.

4. **Sécurité applicative** :
   - toujours utiliser les mécanismes de formulaire Symfony (CSRF, validation)
   - jamais utiliser `$_GET`/`$_POST` directement dans les contrôleurs, mais
     `Request` + Validator.
   - pour les mots de passe : **`password_hashers`** (nouvelle config) et
     algos modernes (argon2i, bcrypt cost élevé).

5. **Droits BDD** :
   - compte DB dédié à Ndombi avec **principe du moindre privilège**
   - pas de droits `SUPER`, pas de `DROP DATABASE`, etc.

6. **Logs & monitoring** :
   - configurer Monolog pour séparer : `app`, `security`, `deprecation`
   - surveiller les erreurs 4xx/5xx, tentatives d'injection, échecs login.

---

## 3.5. Exemples de dépréciations et résolution

Les exemples suivants sont typiques d'un projet Symfony 4.4 avec Doctrine, Security, etc.
On part d'un log de type : `php.INFO: User Deprecated: ...`.

### 3.5.1. Dépréciation 1 : contrôleur hérite de `Controller` au lieu de `AbstractController`

**Message type :**

> User Deprecated: The "Symfony\Bundle\FrameworkBundle\Controller\Controller"
> class is deprecated since Symfony 4.2, use
> "Symfony\Bundle\FrameworkBundle\Controller\AbstractController" instead.

**Code actuel (Ndombi) :**

```php
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function list()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('user/list.html.twig', [
            'users' => $users,
        ]);
    }
}
```

**Procédure de résolution :**

1. Remplacer l'héritage :

```php
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    // ...
}
```

2. Vérifier l'utilisation de méthodes héritées :
   - `getDoctrine()` est toujours dispo dans `AbstractController` en 4.4/5.x,
     mais sera amené à disparaître → idéalement injecter les repositories par
     autowiring :

```php
<?php

use App\Repository\UserRepository;

class UserController extends AbstractController
{
    public function list(UserRepository $repo): Response
    {
        $users = $repo->findAll();

        return $this->render('user/list.html.twig', [
            'users' => $users,
        ]);
    }
}
```

3. Re-tester le contrôleur (tests fonctionnels + navigation manuelle).

---

### 3.5.2. Dépréciation 2 : `encoders` → `password_hashers` (sécurité)

**Message type :**

> User Deprecated: The "security.encoders" configuration key is deprecated
> since Symfony 5.3, use "security.password_hashers" instead.

Dans un projet Ndombi en 4.4, lors du passage vers 5.4 puis 6.4, cette
dépréciation apparaît dès qu'on utilise l'ancienne config.

**Configuration actuelle (`config/packages/security.yaml`) :**

```yaml
security:
  encoders:
    App\Entity\User:
      algorithm: bcrypt
```

**Nouvelle configuration :**

```yaml
security:
  password_hashers:
    App\Entity\User:
      algorithm: auto
      cost: 12
```

**Procédure :**

1. Remplacer la section `encoders` par `password_hashers`.
2. Choisir un algo moderne (`auto` laisse Symfony choisir la meilleure option).
3. Vérifier le process de login / changement de mot de passe :
   - les anciens hash restent valides, Symfony les migre si nécessaire.
4. Vérifier les tests d'authentification Ndombi.

Référence : doc officielle Security pour Symfony 5.3+.

---

### 3.5.3. Dépréciation 3 : `Doctrine\Common\Persistence\ObjectManager`

**Message type :**

> User Deprecated: The "Doctrine\Common\Persistence\ObjectManager" class is
> deprecated, use "Doctrine\Persistence\ObjectManager" instead.

Typique avec DoctrineBundle et du code legacy.

**Code actuel Ndombi :**

```php
<?php

namespace App\Service;

use Doctrine\Common\Persistence\ObjectManager;

class UserManager
{
    private ObjectManager $om;

    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    public function save(User $user): void
    {
        $this->om->persist($user);
        $this->om->flush();
    }
}
```

**Procédure :**

1. Remplacer l'`use` :

```php
use Doctrine\Persistence\ObjectManager;
```

2. Si possible, aller plus loin et typer sur `EntityManagerInterface` :

```php
use Doctrine\ORM\EntityManagerInterface;

class UserManager
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function save(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }
}
```

3. Mettre à jour `composer.json` pour avoir une version récente de
   `doctrine/persistence` et `doctrine/orm` compatible Symfony 6.4.
4. Lancer les tests qui utilisent `UserManager` pour s'assurer que tout fonctionne.

---

## 3.6. Références officielles utiles

- Historique PHP & migrations :
  - `https://www.php.net/manual/en/history.php`
  - guides de migration 7.x → 8.x (`migration80.php`, `migration81.php`, etc.)
- Versions PHP supportées :
  - `https://www.php.net/supported-versions.php`
- Releases Symfony & durées de support :
  - `https://symfony.com/releases`
  - `https://endoflife.date/symfony`
- Guide upgrade majeur Symfony :
  - `https://symfony.com/doc/current/setup/upgrade_major.html`
- Sécurité Symfony (SecurityBundle) :
  - `https://symfony.com/doc/current/security.html`

---

Si tu veux, je peux ensuite t'aider à « alléger » ou reformuler certaines parties pour que ça corresponde mieux à ton style et au niveau attendu (et éviter que ça ressemble trop à un texte généré).