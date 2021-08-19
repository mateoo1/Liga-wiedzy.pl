<?php

require "cred.php";
//require "functions.php";

class member {
    public $member_name;
    public $member_points;
    public $member_attempts;
    public $member_achievments;
    public $count_of_member_passed_questions;
    public $number_of_questions;
    public $puchar_wiedzy;

    function achievemnts () {
        require "cred.php";

        $this->member_achievments = array();

        //pobranie ilości pytania z tabeli questions
        $NumberOfQuestions_query = $db->query("SELECT * FROM questions");
        $NumberOfQuestions = $NumberOfQuestions_query -> rowCount();

        //procent ukończonej gry
        $accuracy = ceil((($this->member_points / 10) / $NumberOfQuestions) * 100);
        //echo $accuracy;

        //przypisuje graczowi osiagniecia w zaleznosci od wpsolczynnika (procentu ukonczonej gry)
        switch (true) {

            case ($accuracy >75):
            $this->member_achievments[0] = '<img border="0" src="img/awards/general_wiedzy.png" alt="******" title="Generał wiedzy" width="28" height="45">';
            break;

            case ($accuracy >60 && $accuracy <=75);
            $this->member_achievments[0] = '<img border="0" src="img/awards/erudyta.png" alt="Erudyta" title="Erudyta" width="30" height="45">';
            break;

            case ($accuracy >45 && $accuracy <=60):
            $this->member_achievments[0] = '<img border="0" src="img/awards/starszy_obeznany.png" alt="****" title="Starszy obeznany" width="35" height="45">';
            break;

            case ($accuracy >30 && $accuracy <=45):
            $this->member_achievments[0] = '<img border="0" src="img/awards/mlodszy_obeznany.png" alt="***" title="Młodszy obeznany" width="35" height="45">';
            break;

            case ($accuracy >10 && $accuracy <=30):
            $this->member_achievments[0] = '<img border="0" src="img/awards/wschodzaca_gwiazda.png" alt="**" title="Wschodząca gwiazda" width="35" height="45">';
            break;

            case ($accuracy <=10):
            $this->member_achievments[0] = '<img border="0" src="img/awards/adept_wiedzy.png" alt="*" title="Adept wiedzy" width="35" height="55">';
            break;
        }

            // zwyciezca (dla gracza ktory uzyskal maksymalna ilosc punktów)
            if ($this->count_of_member_passed_questions >= $this->number_of_questions) {
                $length_of_array = sizeof($this->member_achievments);
                $this->member_achievments[$length_of_array] = '<img border="0" src="img/awards/puchar_wiedzy.png" alt="!" title="Puchar wiedzy" width="35" height="45">';
                $this->puchar_wiedzy = '<br><div><img id="puchar-gray" border="0" src="img/awards/puchar_wiedzy_big.png" alt="!" title="Puchar wiedzy">';
            } else {
                // szary puchar przed ukończeniem gry
                $this->puchar_wiedzy = '<br><div><img id="puchar-gray" border="0" src="img/awards/puchar_wiedzy_big.png" alt="!" title="Puchar wiedzy">';

            }


        if ($this->member_points == 0 || $this->member_attempts == 0) {

            // zabezpieczenie przed dzieleniem przez 0

        } else {

            // duzo prob a malo punktow wzór: nagroda = zaokrąglone((punkty/rundy)/10) < 10 - czyli gracz w jednej rundzie odpowiadał średnio na mniej niż 10 pytań
            $skutecznosc = ceil(($this->member_points/$this->member_attempts)/10);

            if ( $skutecznosc < 10 && $this->member_attempts > 5) {
                $length_of_array = sizeof($this->member_achievments);
                $this->member_achievments[$length_of_array] = '<img id="ekspert" border="0" src="img/awards/zapalony.png" alt="!" title="Zapalony zawodnik" width="30" height="35">';
            }

            // malo prob a duzo punktow wzór: nagroda = zaokrąglone((punkty/rundy)/10) > 20 - czyli gracz w jednej rundzie odpowiadał średnio na więcej niż 20 pytań
            $skutecznosc2 = ceil(($this->member_points/$this->member_attempts)/10);

            if ( $skutecznosc2 > 30) {
                $length_of_array = sizeof($this->member_achievments);
                $this->member_achievments[$length_of_array] = '<img id="ekspert" border="0" src="img/awards/bezbledny.png" alt="!" title="Wysoka skuteczność: ' . $skutecznosc2 . '" width="35" height="35">';
            }

        }
    }

    function __construct($imie){

        require "cred.php";

        //pobranie informacji o ilości uzyskanych punktów i rund
        $Player_query = $db->query("SELECT player_name, points, attempts, passed_questions FROM league WHERE player_name = '$imie'");
        $Player = $Player_query -> fetch(PDO::FETCH_NUM);

        //przypisanie informacji do zmiennych klasy
        $this->member_name = $Player[0];
        $this->member_points = $Player[1];
        $this->member_attempts = $Player[2];
        $this->count_of_member_passed_questions = count(explode(",", $Player[3]))-1;

        //pobranie ilosci pytan
        $number_of_questions_query = $db->query("SELECT * FROM questions");
        $this->number_of_questions = $number_of_questions_query -> rowCount();

        //przyznanie osiagnięć
        $this->achievemnts();
    }
}
?>