# Project Flow: Kadence Child Theme + GitHub + WP Pusher

Ten plik opisuje aktualny sposob pracy przy motywie DHF oraz checklisty do odtworzenia tego samego systemu w kolejnym projekcie WordPress/Kadence.

## Aktualny projekt DHF

- WordPress live: `https://lightgoldenrodyellow-dunlin-240250.hostingersite.com/`
- GitHub repo: `https://github.com/goodgoodbranding-oss/DESIGNHISTORYFORUM-ORG`
- Branch produkcyjny: `main`
- Aktywny motyw WP: `DESIGNHISTORYFORUM-ORG`
- Parent theme: `kadence`
- Glowny deploy: `WP Pusher`
- GitHub Actions: tylko recznie przez `workflow_dispatch`, nie automatycznie po pushu
- Cache: LiteSpeed Cache, po deployu robimy `Purge All`

## Zasada glownego repo

Root repozytorium jest bezposrednio folderem child theme.

W repo trzymamy:

- `style.css` - naglowek motywu potomnego
- `functions.php` - ladowanie parent CSS, Google Fonts, custom CSS i JS
- `assets/css/custom.css` - glowne style motywu
- `assets/js/` - male interakcje front-end
- `DESIGN-SYSTEM.md` - decyzje projektowe i zasady wizualne
- `FIGMA-HANDOFF.md` - przekazanie do Figmy/Claude
- `design-tokens.json` - tokeny designu w formacie do ponownego uzycia
- `backups/` - backupy ustawien, np. eksporty Customizera

Poza repo trzymamy:

- `transport/` - screenshoty, robocze materialy, duze assety, eksporty, pliki do selekcji
- pliki WordPress core
- uploady z Media Library
- cache, backupy serwera, ZIP-y, SQL dumpy

## WP Pusher: aktualne ustawienia

W WordPress przejdz do `WP Pusher > Themes`.

Ustawienia dla DHF:

- Repository host: `GitHub`
- Theme repository: `goodgoodbranding-oss/DESIGNHISTORYFORUM-ORG`
- Repository branch: `main`
- Push-to-Deploy: wlaczone
- Link installed theme: uzywane tylko przy podpinaniu istniejacego folderu motywu

Wazne: folder aktywnego motywu na serwerze musi odpowiadac temu, co WP Pusher aktualizuje. W tym projekcie aktywny folder to `DESIGNHISTORYFORUM-ORG`.

## GitHub token i webhook

Push-to-Deploy nie jest kompletne, dopoki GitHub webhook faktycznie nie istnieje.

Sprawdzone ustawienie dla DHF:

- GitHub token typu `Personal Access Token (classic)`
- minimalne scope dla WP Pusher: `repo` + `admin:repo_hook`

Procedura:

1. `WP Pusher > Settings > GitHub`
2. `Obtain a GitHub token` albo wklejenie wlasnego tokena
3. zapisanie tokena
4. `WP Pusher > Themes > Edit theme`
5. `Push-to-Deploy` wylaczyc
6. zapisac
7. `Push-to-Deploy` wlaczyc ponownie
8. zapisac

Po tej operacji w `GitHub > Settings > Webhooks` powinien pojawic sie webhook WP Pusher.

Jezeli webhook nie istnieje:

- Push-to-Deploy nie dziala automatycznie
- sam `git push` nie wdrozy zmiany
- trzeba najpierw naprawic token albo przepiac theme w WP Pusher

Jezeli `Push-to-Deploy URL` zostal ujawniony publicznie, trzeba go odswiezyc:

1. wylaczyc `Push-to-Deploy`
2. zapisac
3. wlaczyc ponownie
4. sprawdzic nowy webhook i nowy URL

## Standardowy cykl pracy

1. Zmieniamy kod lokalnie w repo.
2. Sprawdzamy `git status`.
3. Commitujemy tylko swiadome zmiany.
4. Robimy `git push` na `main`.
5. GitHub webhook odpala WP Pusher.
6. Sprawdzamy `GitHub > Settings > Webhooks > Recent Deliveries`.
7. Oczekiwany status: `200`.
8. Jezeli zmiana nie wchodzi od razu, w WP Pusher klikamy `Update theme`.
9. W LiteSpeed Cache robimy `Purge All`.
10. Na stronie robimy `Ctrl + F5`.

## Komendy robocze

```bash
git status --short
git diff
git add assets/css/custom.css
git commit -m "Short clear message"
git push
```

Przy wiekszej zmianie:

```bash
git add .
git status --short
git commit -m "Describe the feature or fix"
git push
```

## Design flow

Figma i WordPress nie sa tu automatycznie zsynchronizowane. Figma jest zrodlem myslenia wizualnego, a repo jest zrodlem prawdy dla kodu.

Proces:

1. Ustalamy kierunek w rozmowie, screenach albo Figmie.
2. Jezeli zmiana dotyczy systemu, aktualizujemy `DESIGN-SYSTEM.md` i/lub `design-tokens.json`.
3. Implementujemy zmiane w child theme.
4. Pushujemy do GitHub.
5. WP Pusher wdraza zmiane na WordPress.
6. Testujemy live i dopiero wtedy przechodzimy dalej.

W praktyce:

- finalne assety, ktore maja byc wdrazane z motywem, trzymamy w `assets/`
- przyklad: `assets/images/hero-left-poster.webp`
- nie polegamy na `wp-content/uploads`, jesli asset ma byc kontrolowany przez repo

## Kadence Blocks i edycja wizualna

Child theme nie blokuje edycji wizualnej. Strone edytujemy przez:

- `Pages > Home > Edit`
- albo z frontu: `Edit Home Page`

Kadence Blocks kontroluje strukture blokow, teksty, obrazy i ustawienia wizualne w edytorze. Child theme robi warstwe systemowa:

- typografia globalna
- dopracowanie przyciskow
- mikrointerakcje
- layout fixes
- spojnosc kart, CTA i sekcji

## Customizer backup

Do backupu ustawien Kadence uzywamy eksportu Customizera.

Eksport:

1. WordPress Admin
2. `Appearance > Customize`
3. Panel `Export/Import`, jesli wtyczka jest aktywna
4. `Export`
5. Zapisz plik `.dat` w `backups/customizer/`
6. Commit i push, jezeli to wazny backup konfiguracji

Import:

1. WordPress Admin
2. `Appearance > Customize`
3. `Export/Import`
4. Wybierz plik `.dat`
5. Importuj
6. Sprawdz fonty, kolory, logo i menu
7. `Publish`

## Nowy projekt od zera

Checklist:

1. Utworz nowe repo na GitHub.
2. Nazwij repo tak, jak docelowy folder aktywnego motywu, jezeli chcesz najprostszy deploy przez WP Pusher.
3. W WordPress zainstaluj parent theme `Kadence`.
4. Utworz child theme albo skopiuj ten starter.
5. W `style.css` ustaw:

```css
/*
Theme Name: Project Name
Template: kadence
*/
```

6. W `functions.php` ustaw handle projektu, fonty i sciezki assetow.
7. Wgraj motyw do WordPress albo podepnij istniejacy folder przez WP Pusher.
8. W `WP Pusher > Settings > GitHub` skonfiguruj token `repo` + `admin:repo_hook`.
9. W WP Pusher wybierz repo, branch `main`, wlacz `Push-to-Deploy`.
10. Sprawdz, czy w GitHub pojawil sie webhook.
11. Zrob pierwszy testowy commit i push.
12. Sprawdz `Recent Deliveries`, czy jest `200`.
13. Kliknij `Update theme`, jezeli webhook jeszcze nie zadzialal.
14. Zrob `Purge All` w LiteSpeed Cache.
15. Sprawdz live przez `Ctrl + F5`.

## GitHub Actions

W tym projekcie GitHub Actions nie jest glownym kanalem deployu.

Plik `.github/workflows/deploy.yml` zostaje jako reczna alternatywa awaryjna. Uruchamia sie tylko z GitHub UI przez `Run workflow`.

Jezeli w nowym projekcie wybierasz GitHub Actions zamiast WP Pusher:

- ustaw sekrety FTP/FTPS w GitHub
- popraw `server-dir` na aktywny folder motywu
- zdecyduj, czy workflow ma dzialac po pushu, czy tylko recznie
- nie uzywaj jednoczesnie automatycznego WP Pusher i automatycznych Actions do tego samego folderu

## Deploy sanity check

Po deployu sprawdz:

- Czy live HTML laduje `wp-content/themes/TWOJ-FOLDER/assets/css/custom.css`
- Czy live CSS zawiera ostatnia zmiane, a nie starsza wersje z cache
- Czy finalny asset istnieje pod adresem typu `wp-content/themes/TWOJ-FOLDER/assets/images/...`
- Czy aktywny motyw w `Appearance > Themes` to ten sam folder, ktory aktualizuje WP Pusher
- Czy `Push-to-Deploy` jest wlaczone
- Czy branch to `main`
- Czy webhook istnieje w GitHub
- Czy `Recent Deliveries` maja status `200`
- Czy cache zostal wyczyszczony
- Czy `git status --short` lokalnie jest czysty

## Typowe problemy

### Push nic nie wdraza

Najczestsze przyczyny:

- brak webhooka w GitHub
- zly lub brakujacy token WP Pusher
- `Push-to-Deploy` wlaczone, ale theme zapisane bez poprawnego webhooka

### Zmiana jest na serwerze, ale jej nie widac

Najczestsze przyczyny:

- LiteSpeed pokazuje stary cache
- przegladarka trzyma stara wersje
- HTML albo CSS sa juz nowe, ale blok Kadence ma stara strukture i wymaga mocniejszego CSS

Kolejnosc sprawdzania:

1. `Purge All`
2. `Ctrl + F5`
3. sprawdzenie live CSS i assetu po bezposrednim URL
4. dopiero potem poprawki w kodzie

### 504 Gateway Time-out po deployu

To moze byc chwilowy timeout hostingu albo renderu po purge cache.

Jezeli po chwili:

- homepage zwraca `200`
- `wp-admin` zwraca normalny redirect do logowania
- pliki statyczne motywu zwracaja `200`

to zwykle nie jest trwala awaria, tylko chwilowy timeout po stronie serwera.

## Regula bezpieczenstwa

Nie mieszamy trzech rzeczy:

- kod motywu w repo
- robocze materialy w `transport/`
- pliki WordPress/Media Library na serwerze

Dzieki temu mozemy vibe-codowac szybko, ale nadal miec czysty deploy i mozliwosc odtworzenia projektu.
