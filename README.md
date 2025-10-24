## MacroMate — Calories & Macros Tracker

Lightweight Laravel app to track meals, foods and calculate macros/calories per meal.
Designed as a developer-friendly, testable codebase with static analysis, linters, and simple setup for local development.

### Features

 - Meal & Food management.
 - Meal::nutrients() returns aggregated macros: proteins, fat, carbs, fiber, water, calories.
 - Redis for caching
 - Google auth
 - Admin panel
 - Background job for image processing, optimization, formats (webp, avif, etc.) and sizes creation 
 - Static analysis ready: PHPStan (Larastan) configured.
 - Code style & formatting: friendsofphp/php-cs-fixer (PHP) and recommended blade formatters (Prettier + blade plugin).
 - Tests with PHPUnit.

### Requirements

 - PHP 8.2+
 - Composer
 - Node.js + npm (optional — for frontend tooling used by composer run dev)
 - SQLite / MySQL
 - Project targets Laravel 12.