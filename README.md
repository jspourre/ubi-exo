## Procédure d'utilisation

##### Une fois l'archive extraite sur votre serveur web ou docker, modifiez le fichier .env pour correspondre avec votre base de donnée.


1. Exécutez la commande `composer install`
2. Dans le dossier racine de l'application, lancez la commande  `php bin/console d:d:c` pour créer la base de donnée
3. Lancez la commande `php bin/console d:m:mi ` pour créer les tables.
4. Optionnel, vous pouvez charcher des fixtures de test avec `php bin/console hautelook:fixtures:load`
5. Vous pouvez accéder à l'application à l'adresse suivante http://votreserver/api/
