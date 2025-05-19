# P7_bilemo

Installation du projet : 
 
  1/Il faut faire cette commande pour cloner le projet : 
   `git clone https://github.com/RedaKH/P7_bilemo.git`
   
   2/Vous devez ensuite configurer la connexion à la base de données en allant sur le fichier .env :
   `DATABASE_URL="mysql://votre_nom:votre_mdp@127.0.0.1:3306/votre_bdd?serverVersion=5.7&charset=utf8mb4"`

 3/Il faut installer composer en faisant ca :
   `composer install`
   
   
   
 4/Si vous n'avez pas créer de bases de données vous devez faire cette commande :   
   `php bin/console doctrine:database:create`
   
   
   
  5/Ensuite effectuez cette commande pour créer vos tables en faisant cette commande pour la migration :
  `php bin/console doctrine:migrations:migrate `
  
  
  6/Enfin mettez en place vos fixtures pour créer vos données en faisant ceci : 
  `php bin/console doctrine:fixtures:load`

 Concernant la documentation vous devez taper dans l'adresse url `127.0.0.1/swagger/index.html`
