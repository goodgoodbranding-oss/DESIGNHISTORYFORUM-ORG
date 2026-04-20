# Kadence Child Theme

To repozytorium jest zorganizowane tak, aby jego katalog glowny byl bezposrednio motywem potomnym `kadence-child`.

## Co znajduje sie w repo

- `style.css` - wymagany naglowek motywu potomnego.
- `functions.php` - ladowanie stylow Kadence oraz naszego CSS.
- `assets/css/custom.css` - miejsce na Wasze wlasne style.
- `.github/workflows/deploy.yml` - automatyczny deploy na Hostingera po pushu do `main`.
- `backups/customizer/` - backupy eksportow z Customizera Kadence.
- `DESIGN-SYSTEM.md` - zasady projektowe i kierunek wizualny.
- `FIGMA-HANDOFF.md` - gotowy handoff dla Claude / Figma.
- `design-tokens.json` - kolory, typografia, spacing i komponenty w formie maszynowej.

## GitHub Actions - sekrety

Dodaj w repo do `Settings > Secrets and variables > Actions`:

- `HOSTINGER_FTP_SERVER`
- `HOSTINGER_FTP_USERNAME`
- `HOSTINGER_FTP_PASSWORD`
- `HOSTINGER_FTP_PORT` - opcjonalnie, najczesciej `21`

Jesli WordPress nie jest w `public_html`, zmien wartosc `server-dir` w workflow.

## Jak dziala deploy

Workflow wysyla tylko pliki tego repozytorium do:

`/public_html/wp-content/themes/kadence-child/`

Nie wysyla:

- katalogu `.github`
- backupow z `backups/`
- lokalnych plikow konfiguracyjnych edytora

## Backup ustawien wygladu

Instrukcja eksportu znajduje sie w `backups/customizer/README.md`.

## Jak pracujemy z designem

To wazne: samo `WP Pusher` nie zmieni automatycznie strony na podstawie makiety z Figmy.

Automatyczne moze byc:

- `git push` do GitHuba
- aktualizacja motywu na WordPressie przez `WP Pusher`
- albo deploy na Hostingera przez GitHub Actions

Nieautomatyczne bez dodatkowej integracji:

- zamiana zmian z Figmy na kod
- automatyczna aktualizacja `DESIGN-SYSTEM.md` na podstawie makiety

Dlatego przyjmujemy prosty workflow:

1. Makieta lub decyzja projektowa powstaje w Figmie.
2. Aktualizujemy `DESIGN-SYSTEM.md` i ewentualnie `design-tokens.json`, jesli zmienia sie system.
3. Wprowadzamy zmiany w child theme.
4. Robimy commit i push.
5. `WP Pusher` lub GitHub Actions aktualizuje WordPress.

To daje nam jedno zrodlo prawdy dla designu i jedno zrodlo prawdy dla kodu.
