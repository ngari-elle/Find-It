# FindIt

FindIt is a university lost-and-found application. Students and staff can create lost or found item reports, browse active reports, receive rule-based match suggestions, and submit private recovery requests. Administrators can moderate reports and review claims.

## What the technologies do

- **HTML** provides the semantic page structure, navigation, report cards, forms, tables, and accessible labels.
- **CSS** in `assets/css/style.css` provides the responsive layout, colour system, cards, buttons, forms, status labels, and mobile navigation.
- **JavaScript** in `assets/js/app.js` adds progressive enhancement: confirmation prompts for withdrawals and client-side image preview support. Server-side PHP validation remains authoritative.
- **PHP** renders pages, starts sessions, validates input, protects forms with CSRF tokens, hashes passwords, checks permissions, calculates matches, and uses PDO prepared statements for MySQL queries.
- **MySQL** persists users, reports, match suggestions, and recovery requests. Foreign keys and unique constraints protect the relationships.

## Folder structure

```text
findit/
├── admin/                 # Administrator dashboard, report and claim moderation
├── assets/
│   ├── css/style.css      # Shared presentation
│   └── js/app.js          # Browser interactions
├── config/database.php    # PDO connection using FINDIT_DB_* environment variables
├── database/
│   ├── schema.sql         # MySQL tables, keys and indexes
│   └── seed.sql           # Safe administrator-account instructions
├── includes/              # Bootstrap, authentication, CSRF, shared layout and helpers
├── services/
│   └── MatchingService.php
├── uploads/reports/       # Reserved for validated report images
├── *.php                  # Public and signed-in application pages
└── *.html                 # Original static prototype pages retained for reference
```

## Local setup

1. Install PHP 8.1+ with the PDO MySQL extension and MySQL 8+. The application can run without the optional `mbstring` extension.
2. Create the database and tables:

   ```bash
   mysql -u root -p < database/schema.sql
   ```

3. Configure the connection. The defaults are `127.0.0.1`, port `3306`, database `findit`, user `root`, and an empty password. For another setup, export:

   ```text
   FINDIT_DB_HOST
   FINDIT_DB_PORT
   FINDIT_DB_NAME
   FINDIT_DB_USER
   FINDIT_DB_PASSWORD
   ```

4. Start PHP's local server from the project directory:

   ```bash
   php -S localhost:8000
   ```

5. Open `http://localhost:8000/index.php`.

For future launches, run:

```bash
chmod +x start-findit.sh
./start-findit.sh
```

The script asks for the database password without displaying it. You can also set
`FINDIT_DB_PASSWORD` before running it.

To create an administrator, generate a hash with `password_hash()` as shown in `database/seed.sql`, then insert it directly into MySQL. There is intentionally no public administrator registration.

## Main workflow

1. Register and log in.
2. Submit a lost or found report from `report-create.php`.
3. PHP validates the fields and stores the report with a prepared statement.
4. `MatchingService.php` compares compatible reports by category, location, colour, and date.
5. Review suggestions in **My matches** and submit private proof through a recovery request.
6. An administrator reviews claims and changes their status.

The original `.html` pages are kept as the visual prototype. The `.php` pages are the connected application and use the same stylesheet.
