<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skottår</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .leap-year {
            color: green;
            font-weight: bold;
        }
        .non-leap-year {
            color: red;
        }
    </style>
</head>
<body>
    <h1>Skottår mellan 2000 och 2100</h1>
    <ul>
        <?php
        function ärSkottår($år) {
            if ($år % 400 == 0) {
                return true; // Året är ett skottår
            } elseif ($år % 100 == 0) {
                return false; // Året är jämnt delbart men inte med 400
            } elseif ($år % 4 == 0) {
                return true; // Året är jämnt delbart med 4
            } else {
                return false; // Inte ett skottår
            }
        }

        // Loop för att lista alla år mellan 2000 och 2100
        for ($år = 2000; $år <= 2100; $år++) {
            if (ärSkottår($år)) {
                echo "<li class='leap-year'>$år är ett skottår</li>";
            } else {
                echo "<li class='non-leap-year'>$år är inte ett skottår</li>";
            }
        }
        ?>
    </ul>
</body>
</html>
