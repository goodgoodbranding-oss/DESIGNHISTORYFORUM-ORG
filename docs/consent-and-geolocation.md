# Zgoda przy pierwszej wizycie — wymaganie wdrożeniowe DHF

Data: 2026-10-30. Decyzja właściciela: zgoda ma być dostępna na początku korzystania z serwisu. Ten dokument jest specyfikacją; nie jest działającym banerem ani wdrożeniem analityki. Polityka: [projekt PL](privacy-policy.pl.md).

## Stan potwierdzony

- W sprawdzonych ustawieniach WordPress nie potwierdzono działającego narzędzia analityki ani zapisu pozycji użytkowników. Nie jest to kompletny audyt wszystkich zewnętrznych skryptów.
- Mapy miejsc wyświetlają adresy obiektów, nie pozycje użytkowników. Kafelki OSM są obecnie pobierane przy ładowaniu mapy.
- Istniejąca strona polityki WordPress ID 3 jest szkicem z domyślnym tekstem szablonu.
- Administrator proponowany przez właściciela: Jerzy Tchórzewski; do potwierdzenia właściwa rola, dane działalności i adres kontaktowy.
- Nie publikować projektu z niewypełnionymi polami. Nie włączać zbierania pozycji na podstawie samej zgody na dokument lub pozwolenia przeglądarki.

## Pierwszy ekran (język EN serwisu)

**Your privacy, your choice**

“Choose whether DHF may measure how you use this website and collect your device location for visitor-location statistics. You can read stories and browse places without accepting either option. You can change your choice at any time in Privacy settings.”

Opcje niezaznaczone:

- **Website analytics** — “Allow statistics about visit times, pages, clicks, devices and approximate city or region.”
- **Location statistics** — “Allow DHF to record your device location, its estimated accuracy and measurement time to understand where people use the website. This is separate from showing your location on the map. Your browser will also ask for location permission.”

Przyciski o porównywalnej widoczności: **Reject optional / Save my choices**. Link: **Privacy policy**. Nie dodawać niejasnego „Continue”, domyślnego „Accept all” ani checkboxa „akceptuję politykę” jako zbiorczej zgody. Kategorie niegotowe do działania mają być wyłączone z objaśnieniem, a nie zbierać zgodę na nieokreślone przyszłe przetwarzanie. Panel docelowy można aktywować dopiero po uzupełnieniu informacji, odbiorców i retencji.

Wariant PL:

**Twoja prywatność, Twój wybór**

„Zdecyduj, czy DHF może analizować korzystanie ze strony i zapisywać lokalizację Twojego urządzenia do statystyk odwiedzin w mieście. Możesz czytać artykuły i przeglądać miejsca bez tych zgód. Wybór zmienisz w dowolnym momencie w Ustawieniach prywatności.”

Kategorie: **Analityka strony / Statystyki lokalizacji**. Przyciski: **Odrzuć opcjonalne / Zapisz mój wybór**.

## Niezależna funkcja mapy

Przycisk **Show my location / Pokaż moją lokalizację** wyjaśnia cel i wywołuje jednorazowe `getCurrentPosition` dopiero po działaniu użytkownika. Nie używać `watchPosition` ani żądania uprawnienia przy samym wejściu. Pozycja może pozostać lokalnie do wyświetlenia pobliskich miejsc; odmowa zapisu statystycznego nie blokuje tej funkcji. Bez zgody na statystyki nie wysyłać do serwera współrzędnych, dokładności, geohasha, wyliczonej dzielnicy ani pochodnych lokalizacji.

## Warunki techniczne

1. Przed wyborem domyślnie `analytics=false`, `locationStatistics=false`. Brak odpowiedzi, przewinięcie, zamknięcie i błędny/nieaktualny zapis nie udzielają zgody.
2. Nie uruchamiać SDK analityki ani endpointów lokalizacji przed właściwą zgodą. Kontrola nie może ograniczać się do ukrycia banera.
3. Zapis dokładnej pozycji wymaga odrębnej zgody statystycznej i ważnego uprawnienia przeglądarki; zgoda na zwykłą analitykę nie wystarcza.
4. „Privacy settings / Ustawienia prywatności” stale dostępne w stopce. Wycofanie natychmiast zatrzymuje przyszłe wysyłki, pomiary, timery i aktywne obserwacje; czyści niezbędne do usunięcia identyfikatory oraz niewysłane kolejki.
5. Wykazywanie zgody: wersja komunikatu i polityki, cele, czas decyzji, identyfikator potwierdzenia oraz historia zmian. Minimalizować dane dowodowe, nie dołączać automatycznie IP ani GPS. Ustalić retencję dowodów przed wdrożeniem. Lokalny znacznik zgody nie daje samodzielnej gwarancji wykazania zgody na serwerze.
6. Serwer waliduje cel i aktualny stan zgody; nie ufa dowolnemu `consent=true` przesłanemu przez klienta. Ograniczenia częstotliwości i rozmiaru, walidacja współrzędnych, kontrola dostępu do raportów.
7. Nie wiązać lokalizacji z nazwiskiem, e-mailem, treścią formularza ani promptem AI. Nie umieszczać jej w adresach URL, refererach i logach diagnostycznych. Nie zbierać danych w tle.
8. Ustalić przed uruchomieniem: próbkowanie, dokładność, automatyczną agregację, usuwanie surowych pomiarów i próg minimalnej liczby wizyt na mapie zagęszczenia. Nie pokazywać pojedynczych prywatnych punktów ani tras w publicznym raporcie. Ocenić ryzyko i potrzebę DPIA dla rzeczywistego zakresu monitorowania.
9. Uzgodnić obsługę żądań usunięcia danych z modelem identyfikatorów, zamiast obiecywać usunięcie danych, których nie da się odnaleźć. Danych nie nazywać anonimowymi wyłącznie dlatego, że brak nazwiska.
10. Zrobić audyt cookies, localStorage i żądań zewnętrznych, w tym map i fontów. Jeśli zewnętrzne mapy będą kategorią wymagającą zgody, blokować również żądania kafelków przed zgodą i zapewnić lokalny placeholder. Baner nie blokuje ich automatycznie.
11. Odmowa dostępu do GPS lub brak API nie blokuje katalogu. Lokalizację z IP oznaczać jako przybliżoną, nie jako fizycznie potwierdzony pobyt.

## Kryteria odbioru

- [ ] Pełna tożsamość administratora, retencja, dostawcy i transfery zatwierdzone; polityka opublikowana i podlinkowana.
- [ ] Nowy użytkownik widzi panel; opcje niezaznaczone; brak żądań analitycznych i lokalizacyjnych przed decyzją.
- [ ] Odrzucenie zapamiętywane; odświeżenie nie uruchamia pomiaru ani nie wymusza ponownej zgody.
- [ ] Zgoda wyłącznie na analitykę nie zapisuje GPS.
- [ ] Pozwolenie na mapę bez zgody statystycznej nie zapisuje GPS.
- [ ] Zgoda statystyczna i odmowa uprawnienia przeglądarki nie generują fikcyjnych pozycji.
- [ ] Cofnięcie zgody zatrzymuje wysyłki i pomiary; brak ponownego włączenia po odświeżeniu.
- [ ] Nowa wersja celu wymaga ponownego wyboru; stara zgoda nie jest automatycznie rozszerzana.
- [ ] Klawiatura, czytnik ekranu i telefon: dostępne etykiety, fokus, czytelne przyciski, brak przymusu akceptacji.
- [ ] Serwer odrzuca nieuprawnione zdarzenia; testy obejmują endpoint, nie tylko UI.

## Podstawa projektu i źródła

- RODO, zwłaszcza art. 4 pkt 7 i 11, art. 5–7, 12–13, 15–22, 25, 32 i 35: https://eur-lex.europa.eu/eli/reg/2016/679/2016-05-04?locale=pl
- EROD, Wytyczne 05/2020 o zgodzie: https://www.edpb.europa.eu/sites/default/files/files/file1/edpb_guidelines_202005_consent_en.pdf
- Prawo komunikacji elektronicznej, art. 399: https://eli.sejm.gov.pl/eli/DU/2024/1221/ogl/pol
- UODO, informacje o obowiązku informacyjnym i prawach: https://uodo.gov.pl/pl/493/2254

Niniejsza zmiana dodaje dokumenty do Git. Nie uruchamia banera, GPS, analityki ani publikacji polityki na WordPress. Nie scalać całego starego motywu na produkcję w celu synchronizacji ręcznych zmian z 29–30.10; to osobne zadanie.
