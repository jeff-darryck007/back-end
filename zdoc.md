# ICI LES INFOS DU PROJET

# ICI LES TACHES A FAIRES

    - IMPLEMENTER LA BASE DE DONNEES

        1) configurer la BD dans le fichier .env (MYSQL)
        DATABASE_URL="mysql://root:devcodegroup@127.0.0.1:3306/tfe?serverVersion=8.0.32&charset=utf8mb4"

        2) Creer la base de donnee en question sur MYSQL
        CREATE DATABASE tfe;

        3) CONCEPTION DE LA BD DANS LE PROJET
            implique la creation des Entities et Repository

            ENTITY => c'est la copie d'une table en base de donnee
            REPOSITORY => un composant tres proche de la la BD (generalement utilisrer pour effectuer des requetes sur la BD)

        ont vas proceder avec des commandes sur symfony

        alors le fichier principal de travail SRC/

        4) ==================== MIGRATION DE LA BASE DE DONNEES =======================

                
        




# commandes
        php bin/console make:entity Users (status, createAt)
        php bin/console make:entity Donation
        php bin/console make:entity UserDonation
        php bin/console make:entity Subscribe
        php bin/console make:entity Anouncement


# CHANGER LA VERSION DE PHP

update-alternatives --list php

sudo update-alternatives --set php /usr/bin/php8.2
sudo update-alternatives --set php /usr/bin/php8.4

php serve

