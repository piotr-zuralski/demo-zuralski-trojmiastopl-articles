# demo-zuralski-trojmiastopl-articles

Demo application for Trojmiasto.pl as an assignment.

Application made in 16th May 2011.

--

Artykuły

Opis zagadnienia:

W firmie jest 20 redaktorów, którzy napisali ok. 20 tys artykułów.

Każdy artykuł ma jednego autora, tytuł, treść i datę.

Art. jest przypisany do co najmniej jednej kategorii (np. fakty, sport, kultura).

1. Projekt bazy

Przygotować strukturę bazy modelującą opisane zagadnienie.

2. Generator

Napisać generator, który wypełni bazę artykułów zadaną ilością testowych danych (około 20 tyś).

Generator powinien przyjmować parametry: ilość art., przedział czasu, ilość autorów, ilość kategorii.

Rozkład wartości powinien być równomierny tzn art. powinny być równomiernie rozłożone w zadanym

okresie czasu, każdy autor ma podobną ilość art.

Art. powinny mieć od 1 do 5 kategorii.

Artykuły powinny mieć różną długość, treść i tytuły (mogą to być losowo generowane ciągi znaków [a-z]).

Długość treści artykułu do 2000 znaków, tytułu do 200 znaków.

3. Wyszukiwarka

Wyszukiwarka ma umożliwiać listowanie art. wg różnych kryteriów, kryteria można łączyć.

Możliwość wyszukania art. zawierających podaną frazę (w tytule i treści)

Możliwość wybrania autora i kategorii.

Wyniki można sortować wg: daty, autora i kategorii.

Wyniki powinny być stronnicowane.

Front-end może być minimalistyczny, nie będzie oceniany pod katem wyglądu.

4. Inne

Rozwiązanie powinno działać w środowisku: php 5.3, mysql 5.1.

Proszę nie korzystać z gotowych framework’ow.
