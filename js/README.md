# JavaScript structure

Use this folder for browser-side interactions only. Keep authentication, permissions, validation authority, database work, matching rules, and form processing in PHP.

Suggested layout:

```text
assets/js/
├── app.js              # Shared entry point loaded by pages
├── components/         # Reusable UI behavior
│   ├── navigation.js   # Mobile navigation enhancements, if needed
│   ├── dialogs.js      # Confirmation dialogs and modal behavior
│   └── alerts.js       # Dismissible alerts and notices
├── pages/              # Page-specific behavior
│   ├── browse.js       # Search and filter conveniences
│   ├── report-form.js  # Image preview and report form helpers
│   └── claims.js       # Claim interface conveniences
└── utils/              # Small reusable helpers
    ├── dom.js          # DOM query and event helpers
    └── validation.js   # Client-side convenience checks only
```

Add the relevant script near the end of each HTML page, for example:

```html
<script type="module" src="assets/js/app.js"></script>
```

Pages inside `admin/` need paths one level higher:

```html
<script type="module" src="../assets/js/app.js"></script>
```

Do not place passwords, database credentials, permission checks, or trusted validation in JavaScript. PHP remains the authority for security and data changes.
