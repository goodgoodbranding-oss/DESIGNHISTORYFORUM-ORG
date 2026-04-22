# Design History Forum WordPress Theme

Repozytorium jest folderem child theme dla Kadence i jest wdrazane na WordPress przez WP Pusher.

## Najwazniejsze pliki

- `PROJECT-FLOW.md` - aktualny flow pracy, deployu i checklisty do kolejnych projektow.
- `DESIGN-SYSTEM.md` - zasady wizualne projektu.
- `FIGMA-HANDOFF.md` - handoff do Figmy/Claude.
- `design-tokens.json` - tokeny kolorow, typo, spacingu i komponentow.
- `style.css` - naglowek child theme.
- `functions.php` - ladowanie fontow, CSS i JS.
- `assets/css/custom.css` - glowne style strony.
- `assets/js/homepage-cards.js` - interakcje kafelkow na homepage.

## Deploy

Glowny deploy idzie przez WP Pusher:

- repo: `goodgoodbranding-oss/DESIGNHISTORYFORUM-ORG`
- branch: `main`
- Push-to-Deploy: wlaczone
- aktywny folder motywu: `DESIGNHISTORYFORUM-ORG`

GitHub Actions jest zostawione tylko jako reczna alternatywa awaryjna przez `workflow_dispatch`.

## Robocze materialy

Folder `transport/` jest ignorowany przez git. Trzymamy tam screenshoty, plakaty, ZIP-y, eksporty robocze i materialy, ktore nie maja byc deployowane jako motyw.

Pelna instrukcja pracy jest w `PROJECT-FLOW.md`.
