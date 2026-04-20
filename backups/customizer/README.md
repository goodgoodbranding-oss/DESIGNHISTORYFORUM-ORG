# Backup ustawien Kadence / Customizer

Trzymaj tutaj eksporty ustawien wygladu jako kopie zapasowe.

## Wazne

WordPress sam z siebie nie daje wygodnego przycisku eksportu wszystkich ustawien Customizera do `.dat`.
Plik `.dat` najczesciej pochodzi z wtyczki **Customizer Export/Import** albo podobnego narzedzia.

## Eksport do .dat

1. Zainstaluj w WordPressie wtyczke typu **Customizer Export/Import**.
2. Wejdz w `Wyglad > Dostosuj`.
3. Otworz sekcje eksportu dodana przez wtyczke.
4. Kliknij eksport i zapisz plik `.dat`.
5. Wrzuc plik do tego katalogu.

## Eksport do JSON

Niektore elementy ekosystemu Kadence eksportuja ustawienia osobno do `.json`, na przyklad:

- ustawienia szablonow startowych
- header / footer builder w narzedziach dodatkowych
- ustawienia innych wtyczek powiazanych z wygladem

Jesli widzisz przycisk `Export`, `Export Settings` albo `Export to JSON` w Kadence lub powiazanej wtyczce, zapisz taki plik tutaj obok eksportu `.dat`.

## Przykladowe nazwy

- `2026-04-20-kadence-customizer.dat`
- `2026-04-20-kadence-theme-options.json`

## Dobra praktyka

- eksport przed duzym redesignem
- eksport po zatwierdzeniu stabilnej wersji
- commit z opisem, co obejmuje dany backup
