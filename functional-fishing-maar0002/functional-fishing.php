<?php

session_start();
/**********************************************
 * STARTER CODE
 **********************************************/

/**
 * clearSession
 * This function will clear the session.
 */
function clearSession()
{
  session_unset();
  header("Location: " . $_SERVER['PHP_SELF']);
}

/**
 * Invokes the clearSession() function.
 * This should be used if your session becomes wonky
 */
if (isset($_GET['clear'])) {
  clearSession();
}

/**
 * getResponse
 * Gets the response history array from the session and converts to a string
 * 
 * This function should be used to get the full response array as a string
 * 
 * @return string
 */
function getResponse()
{
  return implode('<br><br>', $_SESSION['functional_fishing']['response']);
}

/**
 * updateResponse
 * Adds a new response to the response array found in session
 * Returns the full response array as a string
 * 
 * This function should be used each time an action returns a response
 * 
 * @param [string] $response
 * @return string
 */
function updateResponse($response)
{
  if (!isset($_SESSION['functional_fishing'])) {
    createGameData();
  }

  array_push($_SESSION['functional_fishing']['response'], $response);

  return getResponse();
}

/**
 * help
 * Returns a formatted string of game instructions
 * 
 * @return string
 */
function help()
{
  return 'Welcome to Functional Fishing, the text based fishing game. Use the following commands to play the game: <span class="red">eat</span>, <span class="red">fish</span>, <span class="red">fire</span>, <span class="red">wood</span>, <span class="red">bait</span>. To restart the game use the <span class="red">restart</span> command For these instruction again use the <span class="red">help</span> command';
}

/**********************************************
 * YOUR CODE BELOW
 **********************************************/

function createGameData() {
  $_SESSION['functional_fishing'] = [
    'response' => [],
    'fish' => 0,
    'wood' => 0,
    'bait' => 0,
    'fire' => true
  ];

  return isset($_SESSION['functional_fishing']);
}

function fire() 
{
  if ( $_SESSION['functional_fishing']['fire']) {
    $_SESSION['functional_fishing']['fire'] = false;
    return 'The fire is off.';
  }
  else if ($_SESSION['functional_fishing']['wood'] > 0) {
    $_SESSION['functional_fishing']['wood']--;
    $_SESSION['functional_fishing']['fire'] = true;

    return 'The fire is on.';
  } 
  else {
    return 'You are out of wood';
  }
  
  
}


function bait() {
  if ($_SESSION['functional_fishing']['fire'] === false) {
    $_SESSION['functional_fishing']['bait']++;

    return "You pick up more bait.";
  }

  return "The fire must be off before looking for bait";
}

function wood() {
  if ( $_SESSION['functional_fishing']['fire'] === false) {
    $_SESSION['functional_fishing']['wood']++;

    return "You grab a piece of wood.";
  }

  return "The fire must be off before looking for wood.";
}


 function fish() {
  if ($_SESSION['functional_fishing']['fire'] === true) {
    return "The fire must be off before fishing.";
  }
  else if ($_SESSION['functional_fishing']['bait'] > 0) {
    $success = rand(0,1);
    if ($success === 1){
      $_SESSION['functional_fishing']['fish']++;
      $_SESSION['functional_fishing']['bait']--;
      return "You catch a fish";
    }
    else{
      $_SESSION['functional_fishing']['bait']--;
      return "You don't catch a fish";
    }
    
  }
  else {
    return "You need to pick up bait before fishing";
  } 
 }

 function eat() {
  if ($_SESSION['functional_fishing']['fire'] === false) {
    return "The fire must be on before eating";
  }
  else if ($_SESSION['functional_fishing']['fish'] > 0){
    $_SESSION['functional_fishing']['fish']--;
    return "You eat a fish";
  }
  else {
    return "You need to catch a fish first";
  }
 }

function inventory() {
  $wood = $_SESSION['functional_fishing']['wood'];
  $bait = $_SESSION['functional_fishing']['bait'];
  $fish = $_SESSION['functional_fishing']['fish'];
  

  if ($_SESSION['functional_fishing']['fire'] === false){
    $fire = "off";
  }
  else {
    $fire = "on";
  }
  
  return "You have ${wood} wood <br> You have ${bait} bait <br> You have ${fish} fish <br> The fire is ${fire}";
  
}

function restart() {
  clearSession();
}

 if (isset($_POST['command'])) {
  if (function_exists($_POST['command'])) {
    updateResponse($_POST['command']());
  } else {
    updateResponse("{$_POST['command']} is not a valid command");
  }
 }