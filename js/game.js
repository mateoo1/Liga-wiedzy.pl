'use strict'

var POINTER
var intervalID = null
var pauseAnswer = ''
var pauseStatus = 0
var emptyAnswerCheck = 0
//array send to db to exclude questions
var passedQustions = []

//HINT: punkty w których kończy się gra można wyśledzić znajdując wystąpienia funkcji passedQustions.push(y[x]) - funkcja tworzy tablicę z poprawnych odpowiedzi.


function checkAnswer (x, y) {
/*
triggered by ENTER button in game.php
CHECK USER ANSWER
x is variable for picking element from random array
y is random array
*/

  // add class for animate question fade in
  classRemove("Qdiv", "questionAnimate")

// DOM
  document.getElementById('alert').innerHTML = ''
  emptyAnswerCheck = 0

  if (pauseStatus === 0) {

    var answerNode = document.getElementById('answer').value
    var answer = answerNode.toLowerCase()
    var ajaxResponse = ajq(y[x], 'answer', answer)
    var ajaxResponseArr = ajaxResponse.split('|')
    var ajaxAnswer = ajaxResponseArr[1]

  } else {

    answerNode = pauseAnswer
    answer = answerNode.toLowerCase()
    ajaxResponse = ajq(y[x], 'answer', answer)
    ajaxResponseArr = ajaxResponse.split('|')
    ajaxAnswer = ajaxResponseArr[1]
    pauseStatus = 0
  }

  if (ajaxAnswer === undefined) {
    ajaxAnswer = 'Błąd pisowni'
  }

  // if last element of array has been reached then stop checking
  if (y[x] === y[y.length]) {

    // stop the game

  } else {

    // clear interval after user pass the answer
    timer(false)

    // check the player answer

    //if answer is CORRECT
    if (ajaxResponseArr[0] == 1) {
      document.getElementById('answer').value = ''
      addPoints(10)
      displayQuestion(x + 1, y, false, y[x], "correct")
      document.getElementById('corrAn').innerHTML = "<span id='ok'> Dobrze! </span>"

      //save question number to passed_questions array to be sent at the end of the game.
      passedQustions.push(y[x])
      if (debugMode() == "TRUE") {console.log(passedQustions)}

    //if answer is INCORRECT
    } else {
      document.getElementById('answer').value = ''
      document.getElementById('corrAn').innerHTML = "<span id='not'>" + ajaxAnswer + '</span>'

      //check if player have lifes, send killer value "true" if not
      if (lifes() === 0) {
        addPoints(-30)
        displayQuestion(x + 1, y, true, y[x], "incorrect")
      } else {
        displayQuestion(x + 1, y, false, y[x], "incorrect")
      }
    }
      // incrementing variable that picking element from array
    POINTER++
  }
}



function displayQuestion (z, v, killer, lastQuestionNumber, answerStatus) {
/*
DISPLAY QUESTION
z is array element index number passed by function chcecking anwser (x + 1)
v is random array, the same that was delivered to function checking answer
*/
  if (debugMode() == "TRUE") {
    console.log('questions array: ' + v)
    console.log('Picked question: ' + v[z])
    console.log('Sent to AJAX: ' + ajq(v[z], 'question'))
  }

  //if player answered all questions and array is empty
  if (v[0] == "") {

    document.getElementById('lights').innerHTML = ''
    document.getElementById('answer').hidden = true
    document.getElementById('pause_button').hidden = true
    document.getElementById('go_button').hidden = true
    document.getElementById('play_again').hidden = true
    //document.getElementById('go_to_profile').hidden = false
    document.getElementById('Qdiv').innerHTML = "Ukończyłeś grę :-) <br> Na razie nie ma więcej pytań. <br> Użyj opcji reset aby zacząć od nowa."

  }

  // GAME OVER (if player have no more lifes or answered all questions)
  if (v[z] === undefined || killer === true) {

    //sends info to player_data that player ends game
    if (v[z] === undefined && answerStatus === "correct") {
        passedQustions.push(lastQuestionNumber)
    }

    document.getElementById('lights').innerHTML = ''
    document.getElementById('answer').hidden = true
    document.getElementById('pause_button').hidden = true
    document.getElementById('go_button').hidden = true
    document.getElementById('play_again').hidden = false
    //document.getElementById('go_to_profile').hidden = false

    if (v[z] === undefined) {
      document.getElementById('Qdiv').innerHTML = 'Gratulacje! Wyczerpałeś pulę pytań! Jeżeli odpowiedziałeś błędnie na jakieś pytanie rozegraj kolejną rundę dogrywkową.'
      document.getElementById('play_again').hidden = true
    } else if (killer === true) {
      document.getElementById('Qdiv').innerHTML = 'KONIEC RUNDY'
    } else {
      document.getElementById('Qdiv').innerHTML = 'KONIEC RUNDY'
    }

    timer(false)
    POINTER = undefined
    SSTD()
  

  // GAME CONTINUE
  } else {
    // passing question string into element
    // z is variable delivered from function that check the answer
    var getQuestionArr = ajq(v[z], 'question').split('|')
    var getQuestion = getQuestionArr[1]
    var Question = getQuestion.replace(/\"/g, "")

    timer(true) // new interval is started
    classAdd("Qdiv", "questionAnimate") // remove class for animate question fade in
    document.getElementById('Qdiv').innerHTML = Question //display question
  
 }
}

function addPoints (pt) {
  /*
  GRANT 10 POINT FOR CORRECT ANSWER
  frist call return 10 point and overwrites the function
  */
  var points = pt
  var Pdiv = document.getElementById('Pdiv')
  Pdiv.innerHTML = points

  addPoints = function (g) {
    points = points + g
    Pdiv.innerHTML = points
  }
}


function lifes () {
  /*
  Function that managing players lifes
  */
  var playerLifes = 2
  document.getElementById('lights').innerHTML = '<div class = "single_2"></div><div class = "single_2"></div>'

  lifes = function () {
    playerLifes--

    if (playerLifes === 1) {
        document.getElementById('lights').innerHTML = '<div class = "single_1"></div>'
    } else {
      document.getElementById('lights').innerHTML = '<div class = "single_1"></div>'
    }
    return playerLifes
  }
}


function timer (flag) {
  /*
  Counting time and triggering the button to submit answer
  */
  var theInt

  if (flag === true) {
    var second = 19

    intervalID = setInterval(function () {
      document.getElementById('timer').innerHTML = second
      second--

      if (second < 0) {
        document.getElementById('go_button').click()
        window.clearInterval(theInt)
      }
    }, 1000)
  } else {
    document.getElementById('timer').innerHTML = ''
    clearInterval(intervalID)
  }
}



function ajq (qid, cm, an) {
  /*
  AJAX
  qid = is the number of question id in databse [provide number]
  cm = is the column name from wchich will be return question or answer (depends on query) [provide column name]
  function is synchronous and return response from database as sinlge string.
  */
  //  var qid
  //  var cm
  var returnResponse
  var pName = document.getElementById('imie').innerHTML
  var vars = 'question_id=' + qid + '&column_nr=' + cm + '&player_answer=' + an + '&player_name=' + pName
  var xhr

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xhr = new XMLHttpRequest()
  } else {
    // code for IE6, IE5
    xhr = new ActiveXObject("Microsoft.XMLHTTP")
  }

  xhr.open('POST', '../php/klip.php', false)
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
  xhr.onreadystatechange = function () {

    if (xhr.readyState === 4 && xhr.status === 200) {
      returnResponse = xhr.responseText
    }
  }

  xhr.send(vars)
  return returnResponse
}



function SSTD () {
  /*
  AJAX for writing players score to database
  */

  //var d = new Date()
  //var datestamp = d.toString()
  var returnResponse
  var imie = document.getElementById('imie').innerHTML
  var punkty = document.getElementById('Pdiv').innerHTML
  var pytania = passedQustions
  //var pass = document.getElementById('pass').innerHTML
  //var playerVars = 'imie=' + imie + '&punkty=' + punkty + '&datestamp=' + datestamp + '&pass=' + pass
  var playerVars = 'imie=' + imie + '&punkty=' + punkty + '&pytania=' + pytania
  var xhr = new XMLHttpRequest()

  xhr.open('POST', '../php/player_data.php', true)
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      returnResponse = xhr.responseText
    }
  }

  xhr.send(playerVars)
  return returnResponse
}

/*
function randomArray_old () {
  // GENERATE RANDOM ARRAY
  var quant = 110
  var arr = []

  while (arr.length < quant) {
    var randomnumber = Math.ceil(Math.random() * quant)
    if (arr.indexOf(randomnumber) > -1) continue
    arr[arr.length] = randomnumber
  }
  return arr
}
*/

function randomArray () {
    /*
    AJAX to random_array_generator.php for questions number
    */

    var returnResponse
    var imie = document.getElementById('imie').innerHTML
    var playerVars = 'imie=' + imie
    var xhr = new XMLHttpRequest()
  
    xhr.open('POST', '../php/random_array_generator.php', false)
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
  
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        returnResponse = xhr.responseText
      }
    }
  
    xhr.send(playerVars)


        var arr = returnResponse.split(",")
        if (debugMode() == "TRUE") {console.log(arr)}
        return arr
  
  }

function pause (x, y) {
  /*
  Making able to pause the game (pause button)
  */

  if (pauseStatus == 0) {

    if (document.getElementById('answer').value == '' && emptyAnswerCheck == 0) {

      document.getElementById('alert').innerHTML = 'Zatrzymanie bez odpowiedzi spowoduje utratę szansy! <br/> Aby zatrzymać mimo to naciśnij ponownie ||'
      emptyAnswerCheck = 1

      } else {

      emptyAnswerCheck = 0
      pauseStatus = 1
      document.getElementById('alert').innerHTML = 'Aby powrócić do gry naciśnij ENTER .'

      var answerNode = document.getElementById('answer').value
      var answer = answerNode.toLowerCase()

      pauseAnswer = answerNode.toLowerCase()

      var ajaxResponse = ajq(y[x], 'answer', answer)
      var ajaxResponseArr = ajaxResponse.split('|')
      var ajaxAnswer = ajaxResponseArr[1]

      if (ajaxAnswer === undefined) {
        ajaxAnswer = 'Błąd pisowni'
      }

      if (y[x] === y[y.length]) {
    // do nothing
      } else {
        timer(false)

        if (ajaxResponseArr[0] == 1) {
          document.getElementById('answer').value = pauseAnswer
          document.getElementById('corrAn').innerHTML = "<span id='ok'> Dobrze! </span>"
          passedQustions.push(y[x])
          if (debugMode() == "TRUE") {console.log(passedQustions)}
        } else {
          document.getElementById('answer').value = pauseAnswer
          document.getElementById('corrAn').innerHTML = "<span id='not'>" + ajaxAnswer + '</span>'
        }
      }
    }
  } else {

  }
}

function debugMode() {

  var returnResponse
  var xhr

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xhr = new XMLHttpRequest()
  } else {
    // code for IE6, IE5
    xhr = new ActiveXObject("Microsoft.XMLHTTP")
  }

  xhr.open('POST', '../php/debug_mode_state.php', false)
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
  xhr.onreadystatechange = function () {

    if (xhr.readyState === 4 && xhr.status === 200) {
      returnResponse = xhr.responseText
    }
  }
  xhr.send()
  return returnResponse
}

function classRemove (elemntID, className) {
  var element = document.getElementById(elemntID);
  element.classList.remove(className);
}

function classAdd (elemntID, className) {
  var element = document.getElementById(elemntID);
  element.classList.add(className);
}