<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webbsida</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f2f5;
            color: #333;
            overflow: hidden; /* Hindrar scrollning på sidan */
        }
        .container {
            text-align: center;
            max-width: 400px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h1 {
            font-size: 1.5rem;
            color:rgb(219, 143, 255);
        }
        p {
            margin: 10px 0;
            color: #555;
        }
        form {
            margin-top: 20px;
        }
        input {
            align-content: center;
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background:rgb(219, 143, 255);
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 1rem;
            cursor: pointer;
        }
        button:hover {
            background:rgb(205, 97, 255);
        }
        a {
            color:rgb(219, 143, 255);
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
            font-weight: bold;
        }
        .error {
            color: red;
            font-size: 0.9rem;
        }

        /* CSS för att skapa animationen */
        @keyframes moveAround {
            0% {
                transform: translate(var(--start-x), var(--start-y)) rotate(var(--start-rotation));
            }
            100% {
                transform: translate(var(--end-x), var(--end-y)) rotate(var(--end-rotation));
            }
        }

        /* Container för kaotiska bilder */
        #chaos-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none; /* Gör så att bilderna inte blockerar klick på andra element */
            z-index: 9999; /* Se till att bilderna är över allt annat */
        }

        .running-image {
            position: absolute;
            width: 50px; /* Justera storleken på bilderna här */
            height: auto;
            animation: rainFall 5s linear infinite;
            pointer-events: none; /* Förhindrar att bilderna blockerar klick på annat */
        }

        /* Animering för att bilderna regnar ner */
        @keyframes rainFall {
            0% {
                top: -50px; /* Startposition (lite ovanför toppen av skärmen) */
                left: calc(100% * var(--start-x)); /* Slumpmässig x-position */
            }
            100% {
                top: 100vh; /* Slutposition (när bilden är nere vid botten) */
                left: calc(100% * var(--end-x)); /* Slumpmässig x-position */
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        session_start(); // Startar en session för att hålla reda på användaren

        // Funktion för att visa meddelande baserat på cookie
        function handleWelcomeMessage() {
            if (isset($_COOKIE['last_visit'])) { // Om det finns en cookie
                $lastVisit = $_COOKIE['last_visit']; // Hämta senaste besökstid
                $timeElapsed = time() - $lastVisit; // Räkna ut hur lång tid sedan senaste besök

                if ($timeElapsed < 3600) { // Om besöket var mindre än en timme sedan
                    echo "<h1>Välkommen tillbaka!</h1>";
                    echo "<p>Du var här för " . round($timeElapsed / 60) . " minuter sedan.</p>";
                } else {
                    echo "<h1>Hej igen!</h1>";
                    echo "<p>Det var över en timme sedan du var här.</p>";
                }
            } else {
                echo "<h1>Välkommen!</h1>"; // Första besöket
                echo "<p>Detta är ditt första besök.</p>";
            }
            setcookie('last_visit', time(), time() + (3600 * 24)); // Sätt en cookie för att hålla koll på senaste besöket
        }

        // Funktion för att hantera inloggning
        function handleLogin() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Om formuläret har skickats
                $username = htmlspecialchars($_POST['username'] ?? ''); // Hämta användarnamn från formuläret
                $password = htmlspecialchars($_POST['password'] ?? ''); // Hämta lösenord från formuläret

                // Använd password_hash och password_verify för bättre säkerhet
                $correctPasswordHash = password_hash('404NotFound', PASSWORD_DEFAULT); // Skapa ett hashat lösenord

                // Om användarnamn och lösenord är rätt
                if ($username === 'CodeCrasher' && password_verify($password, $correctPasswordHash)) {
                    $_SESSION['logged_in'] = true; // Sätt sessionen till inloggad
                    $_SESSION['username'] = $username; // Spara användarnamnet i sessionen
                    header('Location: ?page=secret'); // Skicka till den hemliga sidan
                    exit();
                } else {
                    echo "<p class='error'>Felaktiga inloggningsuppgifter. Försök igen.</p>"; // Om inloggningen misslyckas
                }
            }
        }

        // Funktion för att visa den hemliga sidan
        function showSecretPage() {
            if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) { // Om användaren inte är inloggad
                header('Location: ?page=login'); // Skicka till inloggningssidan
                exit();
            }
            echo "<h1>404NotFound</h1>";
            echo "<p>Å nej! Så många buggs!!! /).(\.</p>";

            // Här visas de kaotiska bilderna
            echo '<div id="chaos-container">';
            for ($i = 0; $i < 40; $i++) { // Generera 40 bilder som ska regna
                echo '<img src="bug.png" class="running-image" alt="Running Image">'; // Lägg till varje bild
            }
            echo '</div>';

            // Logga ut-länk
            echo '<a href="?page=logout">Logga ut</a>';
        }

        // Funktion för att hantera utloggning
        function handleLogout() {
            session_destroy(); // Ta bort sessionen
            header('Location: ?page=welcome'); // Skicka användaren tillbaka till startsidan
            exit();
        }

        // Routing - Välj vilken sida som ska visas baserat på URL-parametern
        $page = $_GET['page'] ?? 'welcome'; // Hämta vilken sida som ska visas
        switch ($page) {
            case 'welcome': // Om sidan är "welcome"
                handleWelcomeMessage(); // Visa välkomstmeddelandet
                echo '<a href="?page=login">Logga in</a>'; // Länk till inloggning
                break;

            case 'login': // Om sidan är "login"
                echo '<form method="POST">'; // Skapa inloggningsformulär
                echo '<h1>Logga in</h1>';
                handleLogin(); // Hantera inloggning
                echo '<label for="username">Användarnamn:</label>';
                echo '<input type="text" id="username" name="username" required>';
                echo '<label for="password">Lösenord:</label>';
                echo '<input type="password" id="password" name="password" required>';
                echo '<button type="submit">Logga in</button>';
                echo '</form>';
                break;

            case 'secret': // Om sidan är "secret"
                showSecretPage(); // Visa den hemliga sidan
                break;

            case 'logout': // Om sidan är "logout"
                handleLogout(); // Logga ut användaren
                break;

            default: // Om sidan inte finns
                echo '<h1>Fel: Sidan finns inte!</h1>';
                break;
        }
        ?>
    </div>

    <script>
        // Funktion för att slumpa positionerna för varje bild
        function randomizeRainEffect() {
            const images = document.querySelectorAll('.running-image'); // Hämta alla bilder

            images.forEach(image => {
                // Slumpmässig x-position på skärmen
                const startX = Math.random();
                const endX = Math.random();

                // Slumpmässig hastighet (mellan 4 och 8 sekunder för att slutföra regncykeln)
                const duration = Math.floor(Math.random() * 4) + 4; // 4-8 sekunder

                // Sätt CSS-variabler för att anpassa animationen
                image.style.setProperty('--start-x', startX);
                image.style.setProperty('--end-x', endX);
                image.style.animationDuration = `${duration}s`; // Slumpa animationens varaktighet
            });
        }

        // Anropa funktionen för att slumpa rörelsen när sidan laddas
        window.onload = randomizeRainEffect; // När sidan har laddats, kör regnslumpningen
    </script>
</body>
</html>