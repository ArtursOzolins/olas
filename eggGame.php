<?php

function buildEggs($type, $winChance, $quantity) {
    $egg = new stdClass();
    $egg->type = $type;
    $egg->winChance = $winChance;
    $egg->quantity = $quantity;

    return $egg;
}

$yourEggs = [
    buildEggs('weakEgg', 40, 3),
    buildEggs('mediumEgg', 50, 2),
    buildEggs('strongEgg', 60, 1)
];
$yourEggCount = 0;
foreach ($yourEggs as $eggs) {
    $yourEggCount += $eggs->quantity;
}
$yourObtainedEggs = [];

$computerEggs = [
    buildEggs('weakEgg', 40, 3),
    buildEggs('mediumEgg', 50, 2),
    buildEggs('strongEgg', 60, 1)
];
$computerEggCount = 0;
foreach ($computerEggs as $eggs) {
    $computerEggCount += $eggs->quantity;
}
$computerObtainedEggs = [];

$fightChoice = readline('Fight eggs? y/n: ');

while ($fightChoice === 'y' && count($yourObtainedEggs) !== $yourEggCount && count($computerObtainedEggs) !== $computerEggCount) {
    foreach ($yourEggs as $key => $egg) {
        echo "{$key} || {$egg->type} || {$egg->quantity} units" . PHP_EOL;
    }
    $eggChoice = readline('Choose egg: ');

    $randomCoef = rand(0, count($computerEggs) - 1);
    $chance = $yourEggs[$eggChoice]->winChance + $computerEggs[$randomCoef]->winChance;

    if (rand(1, $chance) <= $yourEggs[$eggChoice]->winChance) {
        $broken = clone $computerEggs[$randomCoef];
        $broken->quantity = 1;
        array_push($yourObtainedEggs, $broken);
        echo "You took out computers {$computerEggs[$randomCoef]->type} with your {$yourEggs[$eggChoice]->type}" . PHP_EOL;
        $computerEggs[$randomCoef]->quantity--;
        if ($computerEggs[$randomCoef]->quantity === 0) {
            array_splice($computerEggs, $randomCoef, 1);
        }
    } else {
        $broken = clone $yourEggs[$eggChoice];
        $broken->quantity = 1;
        array_push($computerObtainedEggs, $broken);
        echo "You lost your {$yourEggs[$eggChoice]->type} to a {$computerEggs[$randomCoef]->type}" . PHP_EOL;
        $yourEggs[$eggChoice]->quantity--;
        if ($yourEggs[$eggChoice]->quantity === 0) {
            array_splice($yourEggs, $eggChoice, 1);
        }
    }


    if (count($yourEggs) > 0 && count($computerEggs) > 0) {
        $fightChoice = readline('Try again? y/n: ');
    } else {
        break;
    }
}

echo '================================ Game has ended! ================================' . PHP_EOL;
echo PHP_EOL;
echo '                                   Statistics                                    ' . PHP_EOL;
echo 'You have claimed:' . PHP_EOL;
foreach ($yourObtainedEggs as $value) {
    echo "{$value->type} | ";
}
echo PHP_EOL;
echo 'Computer broke:' . PHP_EOL;
foreach ($computerObtainedEggs as $value) {
    echo "{$value->type} | ";
}
echo PHP_EOL;
echo '=================================================================================' . PHP_EOL;
