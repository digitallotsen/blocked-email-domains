# Blocked Email Domains for Fluent Forms

A simple WordPress plugin by [digitallotsen GmbH](https://digitallotsen.com) that allows you to block specific email domains in Fluent Forms.

## Features

- Block email domains via a simple admin interface
- One domain per line – no comma confusion
- Bilingual error message (German / English)
- Lightweight and no external dependencies

## Requirements

- WordPress 6.0+
- [Fluent Forms](https://wordpress.org/plugins/fluentform/) (free or pro)

## Installation

1. Download the plugin
2. Upload the folder `blocked-email-domains` to `/wp-content/plugins/`
3. Activate the plugin in WordPress → Plugins
4. Go to **Settings → Gesperrte Domains** and add domains (one per line)

## Usage

Enter one domain per line, e.g.:
```
spam.com
buildyourwpsites.com
webgrityworks.com
```

When a user submits a Fluent Form with a blocked domain, they will see:

> Wir reagieren nicht auf Formular-Spam. Spar Dir die Mühe. / We do not respond to form spam. Save yourself the effort.

## License

GPL v2 or later – https://www.gnu.org/licenses/gpl-2.0.html

## About

Made with ☕ by [digitallotsen GmbH](https://digitallotsen.com)
```

---

## 3. `LICENSE`
```
GNU GENERAL PUBLIC LICENSE
Version 2, June 1991

Copyright (C) digitallotsen GmbH
https://digitallotsen.com

Everyone is permitted to copy and distribute verbatim copies
of this license document, but changing it is not allowed.

[... vollständiger GPL v2 Text ...]
```

Für die LICENSE-Datei nimmst du am einfachsten den kompletten offiziellen Text von hier:
👉 https://www.gnu.org/licenses/old-licenses/gpl-2.0.txt

Einfach alles kopieren und als `LICENSE` (ohne Dateiendung) speichern.

---

## Deine Ordnerstruktur danach
```
blocked-email-domains/
├── blocked-email-domains.php
├── README.md
└── LICENSE