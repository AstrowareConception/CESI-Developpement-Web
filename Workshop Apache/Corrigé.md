## 1) Configuration d’Apache

### DocumentRoot : « où sont les fichiers du site ? »

* **Définition :** `DocumentRoot` indique à Apache **le dossier racine** à partir duquel il sert les fichiers quand un client demande une URL.
* **Exemple mental :**

  * Si `DocumentRoot /var/www/site1/public`
  * alors une requête sur `http://site1.local/images/logo.png` va chercher le fichier :

    * `/var/www/site1/public/images/logo.png`
* **Règle d’or pédagogique :** *une URL correspond à un chemin relatif sous le DocumentRoot*.

**Erreurs fréquentes**

* DocumentRoot pointe vers un dossier vide → “ça marche mais j’ai une page par défaut”.
* DocumentRoot mal orthographié ou dossier inexistant → erreurs 404 ou 403 selon les cas.
* Droits Linux insuffisants sur les fichiers → **403 Forbidden**.

---

### `<Directory ...>` : « quelles règles s’appliquent à ce dossier ? »

* **Définition :** le bloc `<Directory "/chemin"> ... </Directory>` sert à définir **les permissions et comportements** d’Apache pour un dossier *côté système de fichiers*.
* Ça ne “déclare pas” un site : ça fixe des règles. Typiquement :

  * autoriser ou non l’accès,
  * autoriser l’indexation,
  * autoriser l’exécution,
  * autoriser les `.htaccess` (via `AllowOverride`),
  * etc.

**Pourquoi Apache sépare DocumentRoot et Directory ?**

* Parce que :

  * `DocumentRoot` = **où chercher** les fichiers,
  * `<Directory>` = **comment traiter** ce dossier (sécurité, overrides, options).

**Exemple de discussion en classe**

* “Si je mets `DocumentRoot` sur `/var/www/site/public`, mais que dans `<Directory>` j’interdis l’accès, que se passe-t-il ?”

  * → site accessible ? non → souvent **403**, car les règles Directory bloquent.

---

### Logs Apache : “la vérité est dans /var/log/apache2/”

Quand ça ne marche pas, on arrête de deviner.

* **Logs principaux :**

  * `/var/log/apache2/error.log` : erreurs Apache + modules + parfois erreurs PHP selon config
  * `/var/log/apache2/access.log` : toutes les requêtes HTTP (qui, quoi, code retour)

**Méthode simple à enseigner**

1. Reproduire le bug dans le navigateur (ex: recharger la page).
2. Lire les logs juste après :

   * `tail -n 50 /var/log/apache2/error.log`
   * puis `tail -n 50 /var/log/apache2/access.log`
3. Chercher le code (403, 404, 500) et le message.

---

## 2) Virtual Hosts

### Le rôle du fichier `hosts` (côté client)

* **Problème à résoudre :** un nom de domaine doit être converti en IP pour que le navigateur se connecte.
* En production, ce rôle est assuré par le **DNS**.
* En local (atelier), on court-circuite le DNS avec le fichier `hosts`.

**Principe**

* Dans `hosts`, on écrit :
  `127.0.0.1  monsite.local`
* Résultat : quand on tape `http://monsite.local`, le PC va vers **127.0.0.1**, donc vers la machine locale (WSL/Windows selon réseau).

**Point pédagogique important**

* `hosts` ne “configure pas Apache”.
* Il ne fait que dire : **“ce nom = cette IP”**.

---

### `apachectl -S` : diagnostic “vhost”

`apachectl -S` affiche :

* les vhosts chargés,
* quel vhost répond à quel nom/port,
* quel est le “default” si aucun nom ne matche.

**Cas typique à illustrer**

* L’étudiant a créé `monsite.local.conf`, mais Apache charge un autre vhost par défaut.
* `apachectl -S` révèle : “namevhost monsite.local sur *:80” absent → alors le navigateur tombe sur le default.

**Réflexe intervenant**

* Si un vhost “ne prend pas”, faites `apachectl -S` avant de modifier au hasard.

---

### Séparer ressources statiques : intérêt (perf + sécurité + architecture)

“Ressources statiques” = images, CSS, JS, fonts… (ce qui ne passe pas par PHP).

**Performances**

* Un vhost (ou sous-domaine) statique peut être optimisé :

  * cache agressif,
  * compression,
  * moins de règles,
  * pas d’interpréteur PHP impliqué.
* En production, on met souvent ça derrière CDN / reverse proxy.

**Sécurité**

* Moins de surface d’attaque :

  * un serveur statique n’exécute pas PHP,
  * réduit les risques de mauvaise config (upload, exécution, etc.).
* Très bon sujet pour sensibiliser : *“tout ce qui n’a pas besoin d’exécuter du code ne devrait pas pouvoir en exécuter.”*

**Architecture / clarté**

* Séparer “app” et “assets” rend les responsabilités plus lisibles.

---

## 3) HTTPS

### Certificat auto-signé vs autorité de confiance

**Certificat auto-signé**

* Créé par toi-même, signé par toi-même.
* Chiffre bien la connexion, MAIS le navigateur n’a aucune raison de te croire → alerte “site non sécurisé” (confiance).

**Certificat signé par une autorité (CA)**

* Une CA (ex: Let’s Encrypt) signe le certificat.
* Le navigateur fait confiance à la CA → pas d’alerte.
* En production, c’est la norme.

**Phrase simple à retenir**

* Auto-signé = “je me présente moi-même”
* CA = “une institution reconnue confirme mon identité”

---

### Pourquoi HTTPS est indispensable en production

HTTPS apporte :

* **confidentialité** : le trafic n’est pas lisible sur le réseau,
* **intégrité** : on ne peut pas modifier le contenu en transit sans être détecté,
* **authenticité** : on réduit le risque d’usurpation (MITM).

Et aujourd’hui, c’est aussi :

* attendu par les navigateurs (warnings),
* nécessaire pour beaucoup d’API web modernes (certaines features exigent HTTPS),
* standard SEO/UX.

---

### Pourquoi utiliser HTTPS sur chaque projet (même étudiant)

Même en local / projets pédagogiques :

* habituer les étudiants aux bonnes pratiques (pas de “on verra plus tard”),
* éviter les surprises le jour où une feature exige HTTPS,
* cohérence avec la réalité du métier.

Et côté “notoriété / SEO” :

* les navigateurs marquent “Non sécurisé” si login en HTTP,
* ça dégrade la confiance utilisateur,
* HTTPS est un prérequis “hygiène” pour un site moderne.

---

## 4) Redirections (.htaccess et mod_rewrite)

### `AllowOverride All` : pratique mais dangereux

* `AllowOverride All` permet aux fichiers `.htaccess` **de modifier** la configuration Apache dans un dossier.
* C’est très pratique en mutualisé ou en pédagogie.
* Mais côté sécurité/production :

  * si un attaquant peut déposer un `.htaccess` (via upload mal sécurisé), il peut :

    * changer des règles d’accès,
    * activer des comportements inattendus,
    * exposer des dossiers,
    * etc.
* Et côté performance :

  * Apache doit chercher un `.htaccess` à chaque niveau de dossier à chaque requête.

**Bonne pratique à enseigner**

* En production : privilégier configuration vhost plutôt que `.htaccess`.
* Garder `AllowOverride` au minimum nécessaire (ex: `AllowOverride None` ou seulement `FileInfo` si besoin rewrite).

---

### Redirection simple vs réécriture avancée

**Redirection (HTTP)**

* Le serveur dit au navigateur : “va ailleurs”.
* Le navigateur change l’URL affichée.
* Ex : `Redirect 301 /ancien /nouveau`

**Réécriture (rewrite)**

* Apache transforme l’URL *en interne*, sans forcément changer ce que voit le client.
* Typique pour “URLs propres” :

  * `/article/42` → en interne `index.php?id=42`

**Exemple pédagogique**

* Redirection : déménagement officiel (le facteur change l’adresse)
* Réécriture : porte dérobée (le visiteur croit entrer par la façade mais tu l’envoies derrière)

---

### Comprendre la syntaxe de `mod_rewrite` (sans magie)

Les 3 briques :

1. `RewriteEngine On`
   → active le moteur.

2. `RewriteRule`
   → une règle qui matche une URL et la transforme.

   * Format : `RewriteRule PATTERN DESTINATION [FLAGS]`

3. `RewriteCond` (optionnel)
   → conditions supplémentaires (sur host, méthode, fichier existant, etc.)

**Mini-exemple typique expliqué**

* Objectif : si le fichier demandé n’existe pas, on envoie vers `index.php`.

Idée :

* si `REQUEST_FILENAME` n’est pas un fichier réel,
* et n’est pas un dossier,
* alors rewrite vers `index.php`.

**Clés de compréhension**

* Les patterns sont des regex.
* `$1`, `$2` récupèrent des morceaux capturés.
* Les flags changent le comportement (ex: `L` = dernière règle, `R=301` = redirection).

**Erreurs fréquentes**

* oublier `RewriteEngine On`
* règles trop larges → boucles infinies (redirect loop)
* confondre rewrite interne et redirection externe

---

## 5) Analyse des logs Apache

### `tail -f` : lecture temps réel (très formateur)

* `tail -f /var/log/apache2/error.log`
* Pendant que c’est ouvert, l’étudiant recharge sa page et voit “en direct” :

  * erreurs de fichier, droits,
  * erreurs de modules,
  * erreurs PHP (selon config),
  * etc.

**Très bon exercice**

* Provoquer volontairement un 404 (mauvais chemin) et lire access.log.
* Provoquer un 403 (chmod) et lire error.log.
* Provoquer un 500 (erreur PHP) et voir le comportement.

---

### Logs = outil sécurité + monitoring

**Sécurité**

* repérer des scans d’URL suspectes (`/wp-admin`, `/phpmyadmin`, etc.)
* repérer des pics de 401/403
* voir des user agents bizarres, tentatives d’injection dans query strings

**Trafic**

* pics de requêtes,
* endpoints les plus sollicités,
* codes 5xx = instabilité,
* temps de réponse (selon format de log).

---

### Pourquoi consulter régulièrement les logs

Parce que la majorité des problèmes sont visibles là avant d’être “visibles” autrement :

* mauvaise config,
* vhost pas chargé,
* droits filesystem,
* modules non activés,
* boucles rewrite,
* etc.

---

### Séparer les logs entre vhosts : intérêt concret

Si tu as plusieurs sites :

* un access.log global mélange tout,
* un error.log global mélange tout,
* diagnostic plus lent.

En séparant :

* tu sais immédiatement quel site génère l’erreur,
* tu peux analyser le trafic d’un site sans bruit,
* tu limites l’impact en incident (meilleure observabilité).

**Message simple aux étudiants**

* “Un vhost = un site = ses logs dédiés : c’est comme des dossiers patients séparés.”
