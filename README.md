# SAÉ 2.01 - Développement d’une application


Les membres de ce projet sont :
- Gaboyard Aymeric avec le login `gabo0013`
- Blachon Albin avec le login `blac0008`

# Dépendances

- [PHP](https://www.php.net/)
- [Composer](https://getcomposer.org/)

# Mise en place du projet sur une machine

Afin de pouvoir mettre en place le projet sur une machine locale,
Vous devrez d'abord commencer par cloner le dépositoire du projet : 

```
git clone https://iut-info.univ-reims.fr/gitlab/gabo0013/sae2-01.git
```
Vous devrez ensuite effectuer les instructions suivantes dans votre terminal :

```
composer dumpautoload
composer install
```

# Lancement du serveur web

Vous devrez effectuer cette command pour lancer le serveur web sur votre machine à l'adresse `localhost:8000`:

```
composer start
```

# Test du respect de la syntaxe et autocorrection

Ce projet devra impérativement appliqué la syntaxe PSR-12.

### Pour lancer les tests de syntaxe du projet vous devrez effectuer la commande suivante : 

- Sur linux : 
```
composer test:cs
```
- Sur windows :
```
composer test:cs:windows
```

### Pour lancer l'auto-correction de la syntaxe sur les fichiers du projet, vous devrez executer la commande suivante : 
- Sur linux
```
composer fix:cs
```
- Sur windows : 
```
composer fix:cs:windows
```