# ProofWork — Laravel Waitlist App

Landing page + waitlist SaaS avec notifications Telegram & email.

---

## Stack

- **Laravel 11** — backend
- **MySQL** — base de données
- **SMTP (Gmail)** — emails utilisateur + admin
- **Telegram Bot API** — notification instantanée à chaque signup
- **Blade** — templating

---

## Installation rapide

### 1. Cloner / copier le projet

```bash
cp -r proofwork/ /var/www/proofwork
cd /var/www/proofwork
```

### 2. Installer les dépendances

```bash
composer install
```

### 3. Configurer l'environnement

```bash
cp .env.example .env
php artisan key:generate
```

Édite `.env` :

```env
APP_URL=https://ton-domaine.com

DB_DATABASE=proofwork
DB_USERNAME=root
DB_PASSWORD=ton_mdp

# Gmail SMTP
MAIL_USERNAME=ton@gmail.com
MAIL_PASSWORD=ton_app_password   # App Password Gmail, pas ton vrai mdp
MAIL_FROM_ADDRESS=ton@gmail.com

# Telegram
TELEGRAM_BOT_TOKEN=123456789:AAFxxx...
TELEGRAM_CHAT_ID=-100123456789   # ton chat ID ou channel ID

# ProofWork
PROOFWORK_ADMIN_EMAIL=ton@gmail.com
PROOFWORK_ADMIN_PASSWORD=motdepasse_admin_securise
```

### 4. Créer la base de données

```sql
CREATE DATABASE proofwork CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

```bash
php artisan migrate
```

### 5. Permissions

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 6. Lancer (dev local)

```bash
php artisan serve
```

---

## Créer un bot Telegram

1. Ouvre Telegram → cherche **@BotFather**
2. Envoie `/newbot` → donne un nom → récupère le **token**
3. Mets le token dans `.env` → `TELEGRAM_BOT_TOKEN=...`
4. Pour récupérer ton **chat ID** :
   - Envoie un message à ton bot
   - Visite : `https://api.telegram.org/bot<TOKEN>/getUpdates`
   - Le `chat.id` est dans la réponse JSON
5. Mets-le dans `.env` → `TELEGRAM_CHAT_ID=...`

---

## Gmail App Password

1. Compte Google → **Sécurité** → **Validation en 2 étapes** (doit être activée)
2. **Mots de passe des applications** → crée un mot de passe pour "Mail"
3. Utilise ce mot de passe (16 caractères) dans `MAIL_PASSWORD`

---

## URLs

| URL | Description |
|-----|-------------|
| `/` | Landing page publique |
| `/waitlist` (POST) | Endpoint signup (JSON) |
| `/admin` | Dashboard admin |
| `/admin/export` | Export CSV |

---

## Config Apache (production)

```apache
<VirtualHost *:80>
    ServerName proofwork.app
    DocumentRoot /var/www/proofwork/public

    <Directory /var/www/proofwork/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/proofwork_error.log
    CustomLog ${APACHE_LOG_DIR}/proofwork_access.log combined
</VirtualHost>
```

```bash
a2enmod rewrite
a2ensite proofwork
systemctl reload apache2
```

---

## Config Nginx (production)

```nginx
server {
    listen 80;
    server_name proofwork.app;
    root /var/www/proofwork/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

---

## Structure des fichiers importants

```
app/
  Http/
    Controllers/
      WaitlistController.php     ← logique principale
    Middleware/
      AdminAuth.php              ← protection admin
  Mail/
    WaitlistConfirmationMail.php ← email utilisateur
    WaitlistAdminNotificationMail.php ← email admin
  Models/
    WaitlistEntry.php            ← model Eloquent
  Services/
    TelegramService.php          ← notifications Telegram

config/
  proofwork.php                  ← config custom

database/migrations/
  ..._create_waitlist_entries_table.php

resources/views/
  landing.blade.php              ← page principale
  layouts/app.blade.php
  admin/
    waitlist.blade.php           ← dashboard admin
    login.blade.php              ← login admin
  emails/
    waitlist-confirmation.blade.php
    waitlist-confirmation-text.blade.php
    admin-notification.blade.php

routes/
  web.php
```

---

## Collecter les emails (CSV)

Va sur `/admin/export` — ça télécharge un CSV avec tous les signups.

---

## Post Reddit recommandé

Poste dans **r/SideProject** ou **r/Entrepreneur** :

> **Title:** I built a tool to auto-generate "proof of work" reports from GitHub, Linear & Calendar — no more "trust me" invoices. Would love brutal feedback.
>
> **Body:** Freelancer problem: clients don't trust manual status reports. So I built ProofWork — it pulls your real activity (commits, tasks, meetings) and generates a verifiable, timestamped report you can share with a link. No login required for clients.
>
> Still in waitlist phase. Landing: [your URL]
>
> What would make you actually use this?
