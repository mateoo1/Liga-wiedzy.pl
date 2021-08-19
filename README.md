# liga-wiedzy.pl

v 2.1
- Aktualizacja formuły gry. Celem gry wciąż jest udzielenie odpowiedzi na wszystkie pytania jednak tym razem każda zakończona niepowodzeniem runda odejmuje 30 punktów. Wykorzystano istniejącą funkcję addPoints w game.js.
- Usunięto problem ostatniego pytania. Gdy gracz udzielał błędnej odpowiedzi na ostatnie pytanie w puli nie miał możliwości rozpoczęcia kolejnej rundy z tym pytaniem, przez co kończył grę z wynikiem o 10 pkt mniejszym od maksymalnego. Dodano dodatkową logikę w funkcji displayQuestion.
- Zmieniono licznik ukończenia gry z procentowego na liczbowy w profilu gracza. Modyfikacja klasy gracza.
- Przyznanie nagrody „Puchar Wiedzy” jest przyznawane na podstawie ilości pytań a nie procentu ukończonej gry (za wszystkie pytania).
- Zaktualizowano zasady gry.
