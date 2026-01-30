## Exemple : `/etc/apache2/sites-available/innsmouth.local.conf`

```apache
# =========================
# VHOST HTTP (port 80)
# =========================
<VirtualHost *:80>
    ServerName innsmouth.local
    ServerAlias www.innsmouth.local

    # Dossier racine "web" : là où Apache va chercher index.php, css, images...
    DocumentRoot /var/www/innsmouth/public

    # Logs dédiés à CE site (meilleur diagnostic)
    ErrorLog  ${APACHE_LOG_DIR}/innsmouth_error.log
    CustomLog ${APACHE_LOG_DIR}/innsmouth_access.log combined

    # Politique d'accès et options appliquées au dossier DocumentRoot
    <Directory /var/www/innsmouth/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    # Redirection simple : forcer HTTPS (301 = permanent)
    Redirect permanent / https://innsmouth.local/
</VirtualHost>


# =========================
# VHOST HTTPS (port 443)
# =========================
<IfModule mod_ssl.c>
<VirtualHost *:443>
    ServerName innsmouth.local
    ServerAlias www.innsmouth.local

    DocumentRoot /var/www/innsmouth/public

    ErrorLog  ${APACHE_LOG_DIR}/innsmouth_ssl_error.log
    CustomLog ${APACHE_LOG_DIR}/innsmouth_ssl_access.log combined

    <Directory /var/www/innsmouth/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    # --- TLS / Certificat ---
    SSLEngine on
    SSLCertificateFile      /etc/ssl/certs/innsmouth.local.crt
    SSLCertificateKeyFile   /etc/ssl/private/innsmouth.local.key

    # (Optionnel mais fréquent) : règles de sécurité basiques côté HTTPS
    Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains"
</VirtualHost>
</IfModule>
```

---

## Explication de chaque notion (en s’appuyant sur les valeurs de l’exemple)

### 1) `<VirtualHost *:80>` / `<VirtualHost *:443>`

* **Rôle :** définit un “site” (un hôte virtuel) que Apache va servir.
* `*:80` signifie : “écouter sur **toutes** les IP de la machine, port **80** (HTTP)”.
* `*:443` : même idée, port **443** (HTTPS).

**À faire comprendre aux étudiants :**

* Un serveur Apache peut héberger **plusieurs sites**. Les VirtualHosts sont les “fiches d’identité” de chaque site.

---

### 2) `ServerName innsmouth.local`

* **Rôle :** c’est le **nom principal** du site auquel ce vhost répond.
* Ici, si le navigateur demande `Host: innsmouth.local`, Apache sait que c’est ce vhost.

**Important en local :**

* Il faut que `innsmouth.local` résolve vers la machine (via `hosts` ou DNS).
* Sinon, le navigateur ne “tombe” jamais sur le bon vhost.

---

### 3) `ServerAlias www.innsmouth.local`

* **Rôle :** noms alternatifs qui pointent vers **le même site**.
* Ici, `www.innsmouth.local` répondra comme `innsmouth.local`.

**Erreur typique :**

* On teste `www...` mais on n’a pas mis de `ServerAlias` → ça part sur le vhost par défaut.

---

### 4) `DocumentRoot /var/www/innsmouth/public`

* **Rôle :** dossier racine “web” du site.
* Concrètement :

  * `GET /` → Apache cherche un index (`DirectoryIndex`, souvent `index.html`/`index.php`) dans :

    * `/var/www/innsmouth/public/`
  * `GET /assets/app.css` → fichier :

    * `/var/www/innsmouth/public/assets/app.css`

**Pourquoi “/public” ? (bonne pratique)**

* On évite que des fichiers sensibles du projet (config, sources, vendor, etc.) soient accessibles depuis le web.
* Seul le dossier “public” est exposé.

---

### 5) `ErrorLog` et `CustomLog`

* `ErrorLog ${APACHE_LOG_DIR}/innsmouth_error.log`

  * **Rôle :** écrit les erreurs (config, droits, modules, etc.) dans un fichier dédié à ce site.
* `CustomLog ${APACHE_LOG_DIR}/innsmouth_access.log combined`

  * **Rôle :** journal des requêtes (URL, code 200/404/500, user-agent…) au format `combined`.

**Pourquoi des logs dédiés ?**

* Avec plusieurs sites, un log unique mélange tout → diagnostic pénible.
* Là, si `innsmouth.local` a un 500, tu vas lire **son** log, pas celui des autres.

---

### 6) `<Directory /var/www/innsmouth/public> ... </Directory>`

Ce bloc applique des règles **à un dossier du système de fichiers**.

#### a) `Options -Indexes +FollowSymLinks`

* `-Indexes` : interdit l’affichage de la liste des fichiers si aucun index n’existe.

  * Sans ça, un dossier sans `index.*` pourrait afficher son contenu (souvent indésirable).
* `+FollowSymLinks` : autorise Apache à suivre des liens symboliques Linux.

  * Utile en dev, mais à cadrer en prod selon le contexte.

#### b) `AllowOverride All`

* Autorise l’utilisation de `.htaccess` dans ce dossier (et ses sous-dossiers).
* **Pratique** en atelier (rewrite, redirections locales).
* **Point sécurité/perf** : en production, on limite souvent (voire on met `None`) et on préfère config vhost.

#### c) `Require all granted`

* Autorise l’accès à tous les clients.
* Sans cette directive (selon la config globale), tu peux tomber sur des **403 Forbidden**.

---

### 7) `Redirect permanent / https://innsmouth.local/`

* **Rôle :** redirection **simple** (pas du rewrite) :

  * Toute URL demandée en HTTP (port 80) est renvoyée vers HTTPS.
* `permanent` = code HTTP **301** (cache navigateur probable).

**Point pédagogique**

* Redirection = le navigateur **change** d’URL et refait une requête.
* Si on se trompe et qu’on casse la redirection, le 301 peut rester en cache : il faut parfois vider cache / tester en navigation privée.

---

## Partie HTTPS

### 8) `<IfModule mod_ssl.c>`

* Le vhost 443 n’est chargé **que si** le module SSL est actif.
* En atelier : il faut activer `ssl` (`a2enmod ssl`) et le site SSL.

---

### 9) `SSLEngine on`

* Active TLS pour ce vhost.
* Sans ça, Apache ne négocie pas de connexion chiffrée sur 443.

---

### 10) `SSLCertificateFile` / `SSLCertificateKeyFile`

* `SSLCertificateFile /etc/ssl/certs/innsmouth.local.crt`

  * le **certificat** (contient notamment la clé publique, l’identité du site).
* `SSLCertificateKeyFile /etc/ssl/private/innsmouth.local.key`

  * la **clé privée** correspondante (secret, permissions strictes).

**Auto-signé vs CA**

* Ici on imagine un auto-signé en atelier : le navigateur avertira “non reconnu”.
* En production : certificat d’une autorité de confiance (ex: Let’s Encrypt).

---

### 11) `Header always set Strict-Transport-Security ...`

* Ajoute l’en-tête **HSTS** : “ce site doit être visité en HTTPS uniquement”.
* `max-age=31536000` = 1 an.
* `includeSubDomains` étend aux sous-domaines.

**À cadrer en atelier**

* HSTS peut compliquer les retours en HTTP (le navigateur force HTTPS).
* Utile pour montrer la notion, mais en dev il faut expliquer l’impact.

---

## Mini-checklist atelier (utile quand “ça marche pas”)

* `apachectl -S` : voir si `innsmouth.local` est bien mappé.
* Logs dédiés :

  * `tail -n 50 /var/log/apache2/innsmouth_error.log`
  * `tail -n 50 /var/log/apache2/innsmouth_access.log`
* Le nom résout bien ?

  * `ping innsmouth.local` (ou vérifier `hosts` côté Windows)
* Les modules :

  * `a2enmod ssl headers rewrite` (selon besoins)
