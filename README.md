# Projet MyWishlist


## Membres du groupe
* Lucas Veynand
* Quentin Donadoni
* Nael Boussetta
* Eddy Demoulin

## Suivi du projet

Excel : (TableauDeBord.xlsx)
 
Rendu web : [Site MyWishList](https://webetu.iutnc.univ-lorraine.fr/www/veynand2u/php/PHP/index.php/)

## Installation
* Cloner le dépôt :
```
  git clone https://github.com/LucasInf/S3D_MyWishList.git
```
* Importer le fichier wish.sql se trouvant dans S3D_MyWishList_Veynand_Donadoni_Boussetta_Demoulin à votre base de données
* Créer le fichier *conf.ini* dans la racine
    * Modifier le pour qu'il corresponde aux informations de votre base de données :
```
  	driver=mysql
	username=?
	password=?
	host=localhost
	database=?
	charset=utf8
	collation=utf8_unicode_ci
	prefix=
  ```

* Supprimer le fichier composer.lock  puis installer le composer.phar à l'aide de la commande php composer install.htaccess 
* Le site est prêt, vous pouvez l'utiliser

## Fonctionnalités

### Participant

1. [x] *Afficher une liste de souhaits* (Veynand Lucas)
2. [x] *Afficher un item d'une liste* (Boussetta Nael, Veynand Lucas)
3. [x] *Réserver un item* (Boussetta Nael, Quentin Donadoni, Veynand Lucas)
4. [x] *Ajouter un message avec sa réservation* (Veynand Lucas)
5. [x] *Ajouter un message sur une liste* (Demoulin Eddy, Veynand Lucas)

### Créateur

6. [x] *Créer une liste* (Veynand Lucas)
7. [x] *Modifier les informations générales d'une de ses listes* (Boussetta Nael, Veynand Lucas)
8. [x] *Ajouter des items* (Boussetta Nael, Veynand Lucas)
9. [x] *Modifier un item* (Boussetta Nael,  Veynand Lucas)
10. [x] *Supprimer un item* (Boussetta Nael,  Veynand Lucas)
11. [x] *Rajouter une image à un item* (Boussetta Nael, Donadoni Quentin)
12. [x] *Modifier une image d'un item* (Boussetta Nael, Donadoni Quentin)
13. [x] *Supprimer une image d'un item* (Boussetta Nael, Donadoni Quentin)
14. [x] *Partager une liste* (Donadoni Quentin)
15. [x] *Consulter les réservations d'une de ses listes avant échéance*  (Veynand Lucas)
16. [x] *Consulter les réservations et messages d'une de ses listes après échéance* (Veynand Lucas)

### Extensions

17. [x] *Créer un compte* (Veynand Lucas)
18. [x] *S'authentifier* (Quentin Donadoni, Veynand Lucas)
19. [x] *Modifier son compte* (Boussetta Nael / Veynand Lucas)
20. [x] *Rendre une liste publique* (Veynand Lucas)
21. [x] *Afficher les listes de souhaits publiques* (Veynand Lucas)
22. [ ] *Créer une cagnotte sur un item*
23. [ ] *Participer à une cagnotte*
24. [x] *Uploader une image* (Quentin Donadoni)
25. [ ] *Créer un compte participant*
26. [x] *Afficher la liste des créateurs* (Veynand Lucas)
27. [x] *Supprimer son compte* (Boussetta Nael / Veynand Lucas)
28. [ ] *Joindre des listes à son compte*


