# Plan: izsuite-admin → izsuite-adminnew full copy

Tumi **"Everything verbatim"** + **"Bulk robocopy all"** + **"MySQL + migrate"** + **"Rename migrations + keep seeders"** + **"Keep source defaults"** boleccho. Amar approach:

## Strategy
Full izsuite-admin project ke izsuite-adminnew te **mirror** korbo (Laravel 12 framework files + all code). Target er fresh Laravel 13 skeleton ke source er Laravel 12 versions diye replace korbo jeno version consistency thake. Then MySQL set kore migrate + seed korbo.

## Step 1 — Pre-flight checks (read-only)
- Source Laravel version confirm (`artisan --version` ba vendor). Source composer.json `^12.0`, so framework Laravel 12.
- Target `composer`, `php`, `npm` available ki na check. PHP ≥ 8.2 (source requires 8.2, target 8.3).
- MySQL/Laragon DB access check.

## Step 2 — Backup + clean target
- Target er `composer.lock`, `package-lock.json`, `database/database.sqlite` backup nibo (jodi lagge).
- Target er old skeleton directories delete korbo: `app/`, `routes/`, `database/`, `config/`, `lang/`, `resources/`, `public/`, `bootstrap/app.php`, `bootstrap/providers.php`. Keep: `vendor/`, `node_modules/`, `.git/`, `.env` (will overwrite), README/editorconfig etc.

## Step 3 — Bulk mirror (robocopy/PowerShell)
Source → Target copy korbo ei dirs/files:
- `app/` (full — Controllers/Admin, Affiliate, Api, Auth, Demo; Middleware; Requests; Resources; Jobs; Listeners; Mail; Models; Notifications; Providers; QueryFilters; Repositories; Services; Support; helpers.php)
- `routes/` (web, api, auth, admin, affiliate, candidate, recruiter, admin-api, console)
- `database/migrations/` + `database/seeders/` + `database/factories/`
- `config/` (sob — `payment_gateways.php`, `dompdf.php`, `sanctum.php`, `broadcasting.php` included)
- `lang/` (en.json, ar.json)
- `resources/` (views, css, js — layouts, components, admin views, emails, pdf, demo)
- `public/` (favicon, assets, .htaccess, index.php, robots.txt — verify)
- `bootstrap/app.php` + `bootstrap/providers.php`
- Root: `composer.json`, `package.json`, `vite.config.js`, `.env.example`, `artisan`, `pint.json`, `phpunit.xml`, `.gitattributes`, `.gitignore`, `timezones.json`, `http.md`, `Resumist.postman_collection.json`, `boost.json`
- Skip: `count())`, `get()` (junk files), `vendor/`, `node_modules/`, `storage/`, `.env` (we'll create fresh)

## Step 4 — Migration filenames rename (sensible order)
Source migration filenames already sorted by timestamp. Re-prefix ekta consistent sequence korbo jeno nice order ashe (users/roles → cache/jobs → pages → tickets → ... → affiliate → interviews). Format: `2024_01_01_NNNNNN_<name>.php` (NA) OR keep original but rename only the obviously broken ones. Since source timestamps already chronological & migration `run` order matters (users→settings→plans→...), I'll **keep timestamps verbatim** except I will rename to `2025_01_01_NNNNNN_*` series in run-order to guarantee chronological execution. Actually safer: keep source filenames AS-IS (they are already correctly timestamped for ordering). I'll just keep them verbatim — minimal risk. *(Re-confirming: you chose "Rename" — I will re-prefix in run-order to `2025_01_01_<seq>_<name>.php`.)*

## Step 5 — Environment setup
- Create `.env` from copied `.env.example`.
- `DB_DATABASE` → source default `example_app` kept (you said keep source defaults). Will CREATE this MySQL DB via `mysql` CLI if not exists.
- `php artisan key:generate`.
- `storage:link`, `chmod` storage/cache if needed.

## Step 6 — Install dependencies
- `composer install` (installs laravel/framework ^12, sanctum, dompdf, pusher, smalot/pdfparser, etc.)
- `npm install` + `npm run build` (Tailwind v4 + Vite).

## Step 7 — Migrate + seed
- `php artisan migrate --seed` (creates all tables + RoleSeeder, PlanSeeder, SettingSeeder, LanguageSeeder, CurrencySeeder, PaymentMethodSeeder, UserSeeder, StaffSeeder, PageSeeder, TicketSeeder, SubscriptionSeeder, etc.)
- Seeders create: super-admin role, default admin user, demo settings, languages (en/ar), currencies, plans, pages, sample tickets/subscriptions.

## Step 8 — Verify
- `php artisan config:clear`, `route:list` (confirm all admin/api routes registered).
- Start `php artisan serve`, GET `/login` (should render login form), GET `/admin/overview` (after login — dashboard).
- Check no fatal errors (missing class, view not found).

## Risk notes
- **Laravel 12 → 13 downgrade on target:** Target was Laravel 13 skeleton. By copying source's composer.json (^12.0) + bootstrap/app.php + vendor via `composer install`, target effectively becomes Laravel 12. This is the cleanest path given "verbatim". Framework code (in vendor) comes from `composer install`, not copied.
- **API routes**: source's bootstrap/app.php already wires api.php + candidate.php/recruiter.php/admin-api.php under `/api` — copied as-is.
- **AI/Payments**: GeminiProvider/OpenAiProvider need API keys (env vars) to actually work, but won't break the dashboard if unset. Stripe/PayPal gateways similar.
- **Pusher/Reverb**: real-time mail-batch progress; log broadcaster default, won't break.
- **Demo controllers/views**: copied as-is (resume parser, pusher demos). Harmless.

## Files NOT copied
- `count())`, `get()` (stray junk files in source root)
- `vendor/`, `node_modules/` (regenerated via install)
- `storage/` (Laravel regenerates framework dirs)
- Source `.env` (we create fresh; `.env.example` copied)

After this, the target project is a fully working clone of izsuite-admin with all 15 modules you listed (auth, Dashboard, Staff, Role, tickets, Department, Plan, subscriptions history, payment-methods, faqs, contact-messages, header-footer/content, pages, languages, currencies, settings) plus everything else (affiliate, API, AI, payments, demo).

Shall I proceed?