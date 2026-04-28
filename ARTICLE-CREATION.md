# Article Creation Guide

## Why This Matters

Tak, to wpływa na tworzenie treści artykułów.

Nasz blok `Podsumuj z AI` buduje prompt bezpośrednio z tego, co znajduje się we wpisie. To znaczy, że jakość odpowiedzi w ChatGPT, Claude, Gemini, Perplexity i Groku zależy od jakości:

- tytułu,
- kategorii,
- tagów,
- leadu,
- śródtytułów,
- głównej treści artykułu.

Jeśli artykuł jest dobrze ustrukturyzowany, AI łatwiej:

- rozumie temat,
- wyciąga sensowne wnioski,
- proponuje dalsze rekomendacje,
- kojarzy DHF z konkretną dziedziną wiedzy.

## Current System

Na dziś nasz system AI-summary korzysta z:

- tytułu wpisu,
- URL artykułu,
- kategorii WordPress,
- tagów WordPress,
- śródtytułów `h2-h4`,
- skrótu treści,
- skróconej wersji body.

Na dziś nie mamy jeszcze wdrożonego mechanizmu łapania zainteresowań użytkownika.

To znaczy:

- AI może wnioskować zainteresowania z treści wpisu,
- ale nie ma jeszcze osobnego profilu użytkownika ani preferencji zapisanych w systemie.

## Editorial Goal

Każdy artykuł na Design History Forum powinien działać jednocześnie jako:

- dobry tekst redakcyjny dla człowieka,
- źródło wiedzy dla systemów AI,
- punkt wejścia do dalszego odkrywania Krakowa,
- baza do rekomendacji kolejnych artykułów i miejsc.

## Recommended Anatomy

### 1. Title

Tytuł powinien być:

- konkretny,
- tematyczny,
- łatwy do sklasyfikowania,
- bez clickbaitu.

Dobre przykłady:

- `Polish Poster Design and the Krakow Imagination`
- `How Modernist Interiors Changed Everyday Life in Krakow`
- `Why Krakow's Design Heritage Matters for the Future`

Unikaj:

- zbyt ogólnych tytułów,
- samych metafor bez tematu,
- nagłówków, które nie mówią AI, o czym jest tekst.

### 2. Category

Każdy wpis powinien mieć jedną główną kategorię.

Przykładowe kategorie:

- `Krakow Modernism`
- `Polish Poster School`
- `Typography`
- `Architecture`
- `Craft`
- `Urban Memory`

Kategoria powinna mówić, do jakiego świata interpretacyjnego należy wpis.

### 3. Tags

Tagi mają opisywać bardziej szczegółowe tropy.

Przykłady:

- `brutalism`
- `hotel cracovia`
- `neon signage`
- `museum culture`
- `interior design`
- `wayfinding`
- `print culture`

Dobrze jest używać 3-6 tagów na wpis.

### 4. Lead

Lead powinien:

- streszczać temat,
- pokazywać stawkę tekstu,
- zawierać 1-2 najważniejsze pojęcia,
- być użyteczny także po wyrwaniu z kontekstu.

Długość:

- najlepiej 2-4 zdania.

### 5. Headings

Śródtytuły są bardzo ważne dla AI promptu.

Powinny:

- dzielić tekst logicznie,
- nazywać sekcje jasno,
- zawierać rozpoznawalne pojęcia,
- nie być czysto poetyckie.

Dobre przykłady:

- `What Made Krakow's Modernism Distinct`
- `The Social Meaning of Interior Design`
- `Why This Matters for Today's Designers`

Słabsze przykłady:

- `Echoes`
- `Fragments`
- `A Quiet Return`

### 6. Body

Treść powinna prowadzić czytelnika od kontekstu do znaczenia.

Dobra struktura:

1. krótki kontekst historyczny,
2. opis konkretnego obiektu, zjawiska albo twórcy,
3. interpretacja,
4. znaczenie dla współczesności,
5. naturalne otwarcie na dalsze odkrywanie.

## GEO / AI Writing Principles

### Be Specific

Zamiast:

- `To ważne miejsce`

pisz:

- `Hotel Cracovia stał się symbolem nowoczesnej mobilności, miejskiego prestiżu i architektonicznej odwagi powojennego Krakowa.`

### Name Things Clearly

AI lepiej działa, gdy wpis jasno nazywa:

- osoby,
- budynki,
- style,
- epoki,
- praktyki projektowe,
- dzielnice,
- instytucje.

### Add Interpretable Meaning

Nie tylko opisuj obiekt, ale też wyjaśniaj:

- dlaczego jest ważny,
- co reprezentuje,
- jak łączy się z Krakowem,
- co może z niego wynieść współczesny czytelnik.

### Write for Reuse

Artykuł powinien zawierać fragmenty, które da się łatwo:

- streścić,
- zacytować,
- przekształcić w plan spaceru,
- przekształcić w rekomendację.

## Recommended Content Blocks

W tekstach warto regularnie używać:

- krótkiego leadu,
- sekcji `Why it matters`,
- sekcji `What to notice`,
- sekcji `Local context`,
- sekcji `Next step` albo `Where to go next`.

Nie muszą zawsze mieć dokładnie tych nazw, ale ich logika pomaga zarówno czytelnikowi, jak i AI.

## Article Template

Możemy trzymać się takiego prostego szkieletu:

```md
Title

Lead: 2-4 zdania streszczające temat i jego znaczenie.

H2: Historical Context
Krótki kontekst czasu, miejsca i zjawiska.

H2: The Object / Place / Designer
Opis konkretnego bohatera artykułu.

H2: Why It Matters
Interpretacja i znaczenie dla Krakowa, designu lub pamięci kulturowej.

H2: What To Notice
2-4 konkretne cechy wizualne, przestrzenne albo projektowe.

H2: Where To Go Next
Naturalne przejście do kolejnych artykułów, miejsc lub doświadczeń.
```

## Prompt-Aware Writing

Ponieważ nasz prompt AI korzysta z treści wpisu, warto pamiętać:

- pierwszy akapit powinien dawać sensowny skrót tematu,
- śródtytuły powinny być czytelne semantycznie,
- tagi muszą być sensowne, nie losowe,
- treść powinna zawierać realne tropy do rekomendacji,
- dobrze, jeśli artykuł wskazuje na 1-2 konkretne miejsca, obiekty lub zjawiska.

## What We Should Avoid

- rozwlekłych wstępów bez tematu,
- zbyt mglistych śródtytułów,
- tekstów bez kontekstu historycznego,
- pustych ogólników typu `to inspirujące`,
- clickbaitowych tytułów,
- wpisów bez kategorii i tagów,
- treści, które nie prowadzą do żadnego dalszego odkrycia.

## Future Upgrade

Jeśli później wdrożymy profil użytkownika albo preferencje zainteresowań, ten system można rozszerzyć o:

- zapis zainteresowań w `user_meta`,
- zapis zainteresowań anonimowego użytkownika w `localStorage`,
- quiz onboardingowy typu `interests selector`,
- dynamiczne prompty zależne od wybranych tematów.

Wtedy AI prompt będzie mógł łączyć:

- treść artykułu,
- kategorię,
- tagi,
- profil zainteresowań użytkownika.

## Pre-Publish Checklist

Przed publikacją sprawdź:

- czy tytuł jasno mówi, o czym jest wpis,
- czy wpis ma 1 główną kategorię,
- czy wpis ma 3-6 sensownych tagów,
- czy lead streszcza temat,
- czy śródtytuły są konkretne,
- czy tekst zawiera interpretację, a nie tylko opis,
- czy w treści są tropy do dalszego odkrywania,
- czy wpis da się sensownie streścić w 3-5 punktach.

## Bottom Line

Dla DHF artykuł nie jest tylko wpisem blogowym.

To jednocześnie:

- warstwa redakcyjna,
- warstwa semantyczna,
- warstwa pod AI,
- warstwa pod rekomendacje,
- warstwa pod przyszłe ścieżki użytkownika.

Im lepiej zbudowany wpis, tym lepiej działa cały system wokół niego.
