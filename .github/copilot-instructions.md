<!-- Copilot instructions for AI coding agents. Keep concise and actionable. -->
# Copilot Instructions — Laravel Social Media App

Purpose: Make AI agents immediately productive by documenting the repo's architecture, developer workflows, and project-specific conventions.

Quick setup & common commands
- `composer run setup` — installs PHP deps, runs migrations, builds assets
- `composer run dev` — starts Laravel, queue worker, and Vite hot reload (primary dev command)
- `npm run dev` / `npm run build` — Vite frontend (hot / production)
- `php artisan storage:link` — create public storage symlink
- `php artisan migrate` and `php artisan db:seed --class=AdminSeeder`
- `php artisan test` — run PHPUnit tests (see `tests/Feature/`)
- `./vendor/bin/pint` — format PHP

High-level architecture
- Backend: Laravel 12 + Blade views. Reactive UI is implemented with Livewire components in `app/Livewire/`.
- Frontend: Vite + a React entry at `resources/js/app.jsx`; Tailwind CSS for styling (`tailwind.config.js`).
- Media: normalized through `app/Models/Attachment.php` and `app/Models/PostAttachment.php`; files stored in `storage/app/public/` and served via `asset('storage/' . $attachment->path)`.
- Core domain models: `app/Models/Post.php`, `Comment.php`, `Like.php`, `Story.php`, `User.php`.

Project-specific conventions (do these)
- Use the `Attachment` model and relations (`$post->attachments()`) for media—do not add raw image columns to models.
- Prefer model accessors for computed attributes (example: `User::getAvatarUrlAttribute()`).
- Place interactive UIs as Livewire components in `app/Livewire/` (see `GlobalSearch.php` for debounced server search pattern).
- Always eager-load relations in controllers/queries to prevent N+1 (example: `Post::with('user','attachments')->find($id)`).
- Additive DB history: create new migration files for schema changes; never modify past migrations.

Integration points & important files
- Routes: `routes/web.php`, `routes/auth.php` (chat/auth endpoints)
- Livewire: `app/Livewire/` (look at `GlobalSearch`, `NotificationList` for patterns)
- Models: `app/Models/Attachment.php`, `PostAttachment.php`, `Post.php`, `User.php`
- Frontend entry: `resources/js/app.jsx`, styles in `resources/css/` and `vite.config.js`
- Migrations: `database/migrations/` (recent migration names show attachments, stories, followers tables)

Editing guidance for AI agents
- Make minimal, focused edits; follow existing public APIs and model relationships.
- Run `php artisan test` after non-trivial changes; only fix tests related to your change.
- Format PHP with `./vendor/bin/pint` before committing.
- When adding DB changes, create new migrations and seeders; reference `AdminSeeder` for admin setup.
- For media/public URLs use `asset('storage/' . $attachment->path)` and ensure `php artisan storage:link` is run in dev.

Quick copyable examples
- Eager-load a post: `Post::with('user','attachments')->find($id)`
- Public media URL: `asset('storage/' . $attachment->path)`

When to ask maintainers
- Requests needing DB credentials, seed data changes, or admin credentials.
- Large refactors touching queues, broadcasting, storage, or CI — get maintainers to run integration checks.

If anything here is ambiguous or you need extra context (credentials, seed data, CI access), update this file and ping the maintainer.
<parameter name="filePath">d:\app-media-Sosial\.github\copilot-instructions.md