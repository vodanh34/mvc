<?php
declare(strict_types=1);

use Hile14\Dice\DiceHand;

?>

<h1>Game 21</h1>

<p>Welcome to the game 21, if you get 21 or less you might win, depends on what the
computer gets, if equal the computer wins if you have 21 or more you lose, same rules
applies for the computer.</p>

<?php
if (!isset($_SESSION["active"])) {
?>
    <form method="post" action="<?= $processDice ?>">
    <input type="number" name="content" placeholder="Enter amount of dice">
    <input type="submit" value="Play!" class="buttoninit">
<?php
} else {
    if (!isset($_SESSION["dice"])) {
        $_SESSION["dice"] = new DiceHand((intval($_SESSION["diceAmount"])));
    }
    if (isset($_SESSION["rolledDice"])) {
        echo "<div class='dice-utf8'>";
        foreach ($_SESSION["dice"]->getGraphic() as $item) : ?>
            <i class="<?= $item ?>"></i>
        <?php endforeach;
    }?></div>
    <form action="<?= $processRoll ?>" method="post">
        <input type="submit" value="Roll"
        <?php if (isset($_SESSION["stop"]) and $_SESSION["stop"] == true)
        { ?> disabled <?php } ?>  class="button">
    </form>
    <form action="<?= $processStop ?>" method="post">
        <input type="submit" value="Stop" 
        <?php if (isset($_SESSION["stop"]) and $_SESSION["stop"] == true)
        { ?> disabled <?php } ?> class="button">
    </form>
    <form action="<?= $processWipe ?>" method="post">
        <input type="submit" value="Wipe Game" class="button">
    </form>
    <?php
    if (isset($_SESSION["rolledDiceSum"])) {
        echo "<p class='sum-clear'>Player Sum:" . $_SESSION["rolledDiceSum"] . "</p>";

        if (isset($_SESSION["stop"])) {
            echo "<p>CPU Sum:" . $_SESSION["cpuRoll"] . "</p>";
            if ($_SESSION["cpuRoll"] > 21 and $_SESSION["rolledDiceSum"] <= 21) {
                echo "<p>You Win!</p>";
                $_SESSION["playerScore"] += 1;
            } else if ($_SESSION["cpuRoll"] == $_SESSION["rolledDiceSum"]) {
                echo "<p>You Lose!</p>";
                $_SESSION["cpuScore"] += 1;
            } else if ($_SESSION["cpuRoll"] > $_SESSION["rolledDiceSum"] and $_SESSION["cpuRoll"] < 21) {
                echo "<p>You Lose!</p>";
                $_SESSION["cpuScore"] += 1;
            } else {
                echo "<p>Draw!</p>";
                $_SESSION["draw"] += 1;
            }

            echo "<p>" . $_SESSION["round"] . " Rounds</p>";
            echo "<p>Player Won: " . $_SESSION["playerScore"];
            echo "<p>CPU Won: " . $_SESSION["cpuScore"];
            echo "<p>Draw: ". $_SESSION["draw"];

            ?>
            <form action="<?= $processNext ?>" method="post">
                <input type="submit" value="Next Round" class="button">
            </form>
        <?php
        }
        if ($_SESSION["rolledDiceSum"] == 21) {
            echo "<p>Congratulations!</p>";
        }
    }
}
