
##PHP##
Version > 5.3.1 

##Mysql ##
Version > 5.1.40

##Apache##
Version > 2.2.17

<VirtualHost *:80>
    ServerName tutoriel-zf.localhost
    DocumentRoot /var/www/html/tutoriel-zf/public
    <Directory "/var/www/html/tutoriel-zf/public">
        AllowOverride All
    </Directory>
</VirtualHost>

Doit avoir l'extension mod_rewrite install�e et configur�e.
Apache est configur� pour accepter les fichiers .htaccess.
Changer AllowOverride None � AllowOverride All dans le  httpd.conf.

##Fichiers source##
Le r�pertoire � caisse-retraite � contient l�ensemble des fichiers sources

##Aide##
V�rifiez les d�tails exacts dans la documentation de votre distribution. Vous ne pourrez naviguer sur aucune autre page que la page d'accueil si vous n'avez pas convenablement configur� l'utilisation de mod_rewrite et .htaccess. 

##Utilisateur##
login : administrator
password : admincrc