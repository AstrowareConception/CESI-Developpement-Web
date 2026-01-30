
# Créer l’alias Apache `/phpmyadmin` 

Crée un fichier :

```bash
sudo nano /etc/apache2/conf-available/phpmyadmin.conf
```

Mettre exactement ceci :

```apache
Alias /phpmyadmin /usr/share/phpmyadmin

<Directory /usr/share/phpmyadmin>
    Options SymLinksIfOwnerMatch
    DirectoryIndex index.php
    Require all granted
</Directory>

# Empêche l'accès direct au dossier interne
<Directory /usr/share/phpmyadmin/setup>
    Require all denied
</Directory>
```

Activez-le :

```bash
sudo a2enconf phpmyadmin
sudo apache2ctl configtest
sudo systemctl reload apache2
```

Puis retester :

* `http://localhost/phpmyadmin`
