<?
/*
This game uses:
  - PHP Session for short-term memory: storing the correct answers, the number of gesses so far, etc.
  - Persisent Cookies for long-term memory: number of games played, number won, and some other stats.

No database is used.

Note: Each game is timed so that games are completed before short term memory (PHP session) is lost.
*/
session_start();  // Default session is fine, since game is timed and short

// Config
$game_length = 30;  // Seconds - should be less than 1440, the gc_maxlifetime for sessions.
$max_guesses = 3;

$now = time();
$cookie_expires_timestamp = $now + 60*60*24 * 365;       // (seconds per day)x(365 days)

// Base state for cookie counters
$games_played = 0;
$games_won = 0;
$tries_total = 0;
$winning_percentage = 0;
$tries_per_win = 'NA';


if (isset($_COOKIE['games_played'])){
  $games_played = $_COOKIE['games_played'];
  $games_won = $_COOKIE['games_won'];
  $tries_total = $_COOKIE['sum_of_tries_for_all_games_won'];
}
calculate_winning_percentage();


if (!isset($_GET['choice1'])) {
  // No Query String: Reset Game
  $status = "<strong>Submit choices to start new game. May the Force be with you!</strong>";

  if (!isset($_COOKIE['games_played'])) {
    setcookie("games_played", 0, $cookie_expires_timestamp);
    setcookie("games_won", 0, $cookie_expires_timestamp);
    setcookie("sum_of_tries_for_all_games_won", 0, $cookie_expires_timestamp);
  }

  // Do both for compatibility with all browsers and all versions of PHP
  session_unset();    // Unset every $_SESSION key
  session_destroy();  // Delete the Cookie

} // End No Query String: Reset Game
else {
  // Choices Submitted
  if ($_SESSION['game_over']===true) {
    // hitting reload, even after winning so need to bounce
    header ("Location: ".$_SERVER['PHP_SELF']);
    exit;
  }

  if (!isset($_SESSION['num_tries'])) {
    $_SESSION['num_tries'] = 0;
  }
  $_SESSION['num_tries']++;

  if ($_SESSION['num_tries'] == 1) {
    // Game on!
    $_SESSION['game_over'] = false;

    $_SESSION['correct1'] = random_int(1, 2);
    $_SESSION['correct2'] = random_int(1, 2);
    $_SESSION['correct3'] = random_int(1, 2);

    $_SESSION['game_start_time'] = $now;

    // This one is so they cant close the browser mid-game to try to weasel out.
    setcookie("game_started", 'true', $cookie_expires_timestamp);

    $games_played = 1;  // will get changed except for 1st game
    if (isset($_COOKIE['games_played'])) {
      $games_played = $_COOKIE['games_played'] + 1;
    }
    setcookie("games_played", $games_played, $cookie_expires_timestamp);

  }
  else {
    // some try after the first one
    $games_played = $_COOKIE['games_played'];
  }

  $time_remaining =  $game_length - ($now - $_SESSION["game_start_time"]);

  $num_correct = 0;
  if ( $_GET['choice1'] == $_SESSION['correct1'] ) {
    $num_correct++;
  }
  if ( $_GET['choice2'] == $_SESSION['correct2'] ) {
    $num_correct++;
  }
  if ( $_GET['choice3'] == $_SESSION['correct3'] ) {
    $num_correct++;
  }

  if ($time_remaining < 0) {
    // doesn't matter how many correct - will get chalked up as a game played, but that's it
    if (!$_SESSION['game_over']) {
      record_completed_game(false);
    }
    header ("Location: ".$_SERVER['PHP_SELF']);
    exit;
  }
  else if ($num_correct==3) {
    $status = "<strong>You have won! Strong, the Force is within you!</strong>";
    record_completed_game(true);
  }
  else if ($_SESSION['num_tries'] == $max_guesses) {
    $status = "<strong>Game Over. You have reached the limit of $max_guesses tries.</strong>";
    record_completed_game(false);
  }
  else {
    $status = "Game in Process. Submit another choice.";
  }
}  // end choices submitted


/////////////////////////////////////////////////////////////////////////////////////////////////////////
function record_completed_game($winner) {
  $_SESSION['game_over'] = true; // Hitting reload after this point needs to bounce them.
  setcookie("game_started", '', $now - 60);  // Wipe cookie

  global $games_played,$games_won,$winning_percentage,$tries_per_win,$tries_total;

  $games_won = $_COOKIE['games_won'];
  if ($winner) {
    $games_won++;
    setcookie("games_won", $games_won , $cookie_expires_timestamp);
    $tries_total = $tries_total + $_SESSION['num_tries'];
    setcookie("sum_of_tries_for_all_games_won", $tries_total , $cookie_expires_timestamp);
  }
  calculate_winning_percentage();
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////
function calculate_winning_percentage() {
  global $games_played,$winning_percentage,$tries_per_win,$tries_total,$games_won;

  if ($games_played>0) {
    $winning_percentage = round(($games_won/$games_played)*100,2);
  }
  if ($games_won>0) {
    $tries_per_win = $tries_total/$games_won;
  }
}


// Add query string ?reset to clear out all history and start over
if (isset($_GET['reset'])) {
  setcookie("game_started", '', $now - 60);
  setcookie("games_played", '', $now - 60);
  setcookie("games_won", '', $now - 60);
  setcookie("sum_of_tries_for_all_games_won", '', $now - 60);
  header ("Location: ".$_SERVER['PHP_SELF']);
  exit;
}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Guessing Game</title>
    <style>table, td, th {border-collapse: collapse;border: 0px solid black;}strong{color:red;}</style>
  </head>
  <body>
     <!-- Helps to see cookies and session stuff during development.
     <?=var_dump($_SESSION);?><br><?=var_dump($_COOKIE);?>
     -->

     <h3>A game of skill and chance. Are you a loser? You have a maximum of <?=$max_guesses?> guesses.</h3>

     <b>Status:</b> <span id="status"><?=$status?></span>
     <br>
     <? if (isset($_SESSION['num_tries'])) { ?>
      <table cellspacing="0" cellpadding="5">
        <tr><td width="200">Seconds Remaining:</td><td id="timer"><?=$time_remaining?></td></tr>
        <tr><td>Number of Tries:</td><td><?=$_SESSION['num_tries']?></td></tr>
        <tr><td>Number Correct:</td><td><?=$num_correct?></td></tr>
      </table>
     <? } ?>

     <br>
     <!--
      Notice the use of $_SERVER['PHP_SELF'] for the form action to submit to the same page.
      If script name changes, don't need to change the action value since it's set autmoatically.
     -->
     <form action="<?=$_SERVER['PHP_SELF']?>" method="GET">

       <input type="radio" name="choice1" value="1" <? if($_GET['choice1']==1){echo 'checked';} ?> required>&nbsp;&nbsp;
       <input type="radio" name="choice1" value="2" <? if($_GET['choice1']==2){echo 'checked';} ?> required>
       <br><br>
       <input type="radio" name="choice2" value="1" <? if($_GET['choice2']==1){echo 'checked';} ?> required>&nbsp;&nbsp;
       <input type="radio" name="choice2" value="2" <? if($_GET['choice2']==2){echo 'checked';} ?> required>
       <br><br>
       <input type="radio" name="choice3" value="1" <? if($_GET['choice3']==1){echo 'checked';} ?> required>&nbsp;&nbsp;
       <input type="radio" name="choice3" value="2" <? if($_GET['choice3']==2){echo 'checked';} ?> required>

       <br><br>

        <? if ($_SESSION['game_over']) { ?>
          <button type="button" onclick="start_over();"> Play Again </button>
          <script>clearInterval(timer);</script>
        <? } else { ?>
          <button> Submit Guesses </button>
        <? } ?>

     </form>

     <br><br>


     <b>Historical Results:</b>
     <table cellspacing="0" cellpadding="5">
      <tr><td width="175">Games Played:</td><td><?=$games_played?></td></tr>
      <tr><td>Games Won:</td><td><?=$games_won?></td></tr>
      <tr><td>Winning %:</td><td><?=$winning_percentage?>%</td></tr>
      <tr><td>Avg Guesses Per Win:</td><td><?=$tries_per_win?><br></td></tr>
     </table>

     <? if (isset($time_remaining) && !$_SESSION['game_over']) {

          if (!isset($_SESSION['game_over'])) {
            $_SESSION['game_over'] = false;   // Needs to be set here because seeds a javascript variable.
          }
     ?>

     <script>

      var game_over = "<?=$_SESSION['game_over']?>";  // value set from php
      var time_remaining = <?=$time_remaining?>; // value set from php
      var timer_display = document.getElementById("timer");
      var status_display = document.getElementById("status");

      window.onload = function() {
         if (!game_over) {
             timer = setInterval(function(){
                time_remaining--;
                if (time_remaining>0) {
                  timer_display.innerHTML = time_remaining;
                }
                else {
                  timer_display.innerHTML = 0;
                  timer_display.style.color = "red";
                  status_display.innerHTML = "<strong>Rut Roh. Time Expired. Game will reset in 3 seconds.</strong>";
                  status_display.style.color = "red";
                  setInterval(start_over,3000);
                }
              },1000);
         }
      } // end onload

     </script>
    <? } ?>  <!-- End if main script above is included in the page -->

    <script>
      function start_over() {
        location.href="<?=$_SERVER['PHP_SELF']?>"; // value set from PHP
      }
    </script>

  </body>
</html>