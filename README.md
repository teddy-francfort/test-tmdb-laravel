# Test - Application 

Application Laravel permettant d'afficher les films tendances de TMDB

L'application se base sur Laravel Jetstream + Livewire 3


## Installation


```shell
# Copie du projet
git clone git@github.com:teddy-francfort/test-tmdb-laravel.git

# Création du fichier d'environnement
cp .env.example .env

# Installation des dépendances PHP
composer install

# Génération de la clé dans le fichier .env
php artisan key:generate --ansi

# Construction et démarrage du container
vendor/bin/sail up --build

# Installation front
vendor/bin/sail npm install
vendor/bin/sail npm run build

# Initialise la base de données avec des données test
# Lancer la commande sans l'option --seed pour ne pas créer des données de test
vendor/bin/sail artisan migrate:fresh --seed

# Renseigner la clé API de TMDB dans le fichier .env
TMDB_API_TOKEN="mykey"
```

Après la phase d'installation, l'application est accessible via http://localhost

## Commande d'import

Pensez à bien renseigner la clé API de TMDB dans le fichier .env

```shell
vendor/bin/sail artisan tmdb:import-trending-movies
```



