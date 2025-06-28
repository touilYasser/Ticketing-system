# Ticketing System

Application de gestion de tickets d’assistance développée avec Laravel.

## Présentation
Cette application permet de gérer les demandes de support (tickets) au sein d’une organisation. Elle offre une interface pour la création, le suivi et la résolution des tickets par les utilisateurs, agents et administrateurs.

## Fonctionnalités principales
- Création de tickets par les utilisateurs
- Attribution des tickets aux agents
- Suivi de l’état des tickets (ouvert, en cours, résolu, fermé)
- Notifications (mail, in-app)
- Tableau de bord pour clients, agents et administrateurs
- Historique et commentaires sur chaque ticket

## Prérequis
- PHP >= 8.2
- Composer
- Node.js & npm
- (Optionnel) SQLite ou MySQL

## Dépendances principales
- Laravel 12
- Laravel Breeze (authentification)
- Laravel Reverb (temps réel)
- Bootstrap, TailwindCSS, Chart.js, AlpineJS, FontAwesome, Laravel Echo, Pusher-js

## Installation & Configuration
1. Clonez le dépôt :
   ```bash
   git clone https://github.com/votre-utilisateur/Ticketing-System.git
   cd ticketing-system
   ```
2. Installez les dépendances :
   ```bash
   composer install
   npm install
   ```
3. Copiez le fichier `.env.example` en `.env` et configurez vos variables :
   ```bash
   cp .env.example .env
   ```
4. Générez la clé d’application :
   ```bash
   php artisan key:generate
   ```
5. Configurez la base de données dans `.env` (exemple SQLite) :
   ```env
   DB_CONNECTION=sqlite
   # DB_DATABASE=database/database.sqlite
   ```
   Puis lancez les migrations :
   ```bash
   php artisan migrate --seed
   ```
6. Compilez les assets front :
   ```bash
   npm run dev
   ```
7. Lancez le serveur :
   ```bash
   php artisan serve
   ```

## Exemple de configuration .env
```env
APP_NAME=TicketingSystem
APP_ENV=local
APP_KEY= # généré par artisan key:generate
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=sqlite
# DB_DATABASE=database/database.sqlite

MAIL_MAILER=log
MAIL_FROM_ADDRESS="support@example.com"
MAIL_FROM_NAME="TicketingSystem"
```

## Commandes utiles
- `php artisan migrate:fresh --seed` : Réinitialise la base avec des données de test
- `npm run dev` : Lancer le front en mode développement
- `npm run build` : Build de production
- `composer dev` : Serveur + queue + logs + front simultanés

## Structure du projet
- `app/Models` : Modèles Eloquent
- `app/Http/Controllers` : Logique métier
- `resources/views` : Vues Blade
- `routes/web.php` : Routes principales
- `database/seeders` : Données de test
- `public/` : Entrée web

## Lancement rapide
```bash
git clone https://github.com/votre-utilisateur/Ticketing-System.git
cd ticketing-system
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run dev
php artisan serve
```
Accédez à http://localhost:8000.

## Contribution
Les contributions sont les bienvenues ! Veuillez ouvrir une issue ou une pull request.

## Licence
Ce projet est sous licence [MIT](https://opensource.org/licenses/MIT).

- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
