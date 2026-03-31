# Licorne (Motech Symfony App)

## Quick Start (Local Dev)

1. **Prerequisites**: PHP 8.2+, Composer, Symfony CLI (optional).
2. ```bash
   cd Licorne
   composer install  # Install dependencies
   cp .env .env.local  # Copy env
   symfony console doctrine:database:create  # If DB needed
   symfony server:start  # Or php -S localhost:8000 -t public/
   ```
3. Open http://localhost:8000

## Git Workflow

- Initialized: `git init` done (commit f793bf5).
- Branch: `master` (rename to `main` if preferred: `git branch -M main`).
- Add remote: `git remote add origin <your-repo-url>`.
- Push: `git push -u origin main`.

## Project Structure

- `src/Controller/`: Controllers (LandingController, etc.)
- `templates/`: Twig views
- `public/assets/`: JS/CSS/Stimulus
- `config/packages/`: Symfony bundles

## Commands

- `symfony console make:controller` / `make:entity`
- Tests: `cd Licorne && bin/phpunit`
- Assets: `symfony console importmap:require <pkg>`

See [Symfony Docs](https://symfony.com/doc/current/index.html).
