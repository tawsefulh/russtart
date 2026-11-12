# RusStart

A website for international students who are new to Russia.

- **Articles**: students write about their experience (visa, dormitory, SIM cards, winter) and newcomers search and read them by city and topic.
- **Marketplace**: people already in Russia post advertisements; newcomers contact them by phone, WhatsApp or Telegram.
- **Accounts**: sign up with name, username, email, password, city and university, or continue with Google.

- **Two languages**: English at `/`, Russian at `/ru/`. Visitors whose browser is set to Russian are sent to `/ru/` on their first visit, and anyone can switch with the selector in the header.

Built with plain PHP 8 and MySQL/MariaDB, so it runs on XAMPP and on ordinary PHP hosting. No Composer or build step.

## Run it locally (XAMPP)

1. Start **Apache** and **MySQL** in the XAMPP control panel.
2. Put this folder in `C:\xampp\htdocs\russtart` (or link it there).
3. Create a database called `russtart` and import `database/schema.sql` (phpMyAdmin > Import).
4. Check the database settings in `config/config.php`. To change them without touching that file, copy `config/config.local.example.php` to `config/config.local.php`.
5. Open <http://localhost/russtart/>.

## Google sign-in

1. In Google Cloud Console, create an OAuth client ID of type "Web application".
2. Add the redirect URI `http://localhost/russtart/auth/google/callback` (and the same path on your real domain).
3. Put the client ID and secret in `config/config.local.php`.

The "Continue with Google" button appears only when both keys are set.

## Put it online

1. Upload everything except `.git` into the host's `htdocs` folder.
2. Import `database/schema.sql` into the host's database.
3. Create `config/config.local.php` on the host with its database details and `'debug' => false`.

## Folders

| Folder | What is in it |
| --- | --- |
| `index.php` | Front controller and list of routes |
| `app/pages` | One file per page: reads input, talks to the database |
| `app/views` | HTML templates |
| `app/helpers.php` | Shared functions (forms, validation, uploads) |
| `assets` | CSS, JavaScript, logo |
| `lang` | Russian translations (`ru.php`). Text missing there shows in English |
| `config` | Settings (database, Google keys, main city) |
| `database` | Schema and default cities and categories |
| `uploads` | Images uploaded by members |
