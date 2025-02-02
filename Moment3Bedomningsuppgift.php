<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forms Demo</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* CSS från myCostom.css (från webb1), vissa namn kke skiljer */
        #citiescontainer p{
            color:white;
            font-size:1vw;
        }

        #citiescontainer h1{
            color:white;
            font-size:3vw;
        }

        #citiescolumn h2{
            font-size:2vw;
        }

        #citiescolumn p, h6{
            font-size:1vw;
        }

        .scrollablevertical {
            overflow-y: scroll;
            height: 200px;
        }

        /* Add a black background color to the top navigation */
        .topnav {
            background-color: #333;
            overflow: hidden;
        }

        /* Style the links inside the navigation bar */
        .topnav a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }

        /* Change the color of links on hover */
        .topnav a:hover {
            background-color: #ddd;
            color: black;
        }

        /* Add an active class to highlight the current page */
        .topnav a.active {
            background-color: #4CAF50;
            color: white;
        }

        /* Hide the link that should open and close the topnav on small screens */
        .topnav .icon {
            display: none;
        }

        @media screen and (max-width: 600px) {
            .topnav a:not(:first-child) {display: none;}
            .topnav a.icon {
                float: right;
                display: block;
            }
        }

        @media screen and (max-width: 600px) {
            .topnav.responsive {position: relative;}
            .topnav.responsive .icon {
                position: absolute;
                right: 0;
                top: 0;
            }
            .topnav.responsive a {
                float: none;
                display: block;
                text-align: left;
            }
        }

        /* Grid */
        .grid-container {
            display: grid;
            grid-template-areas:
                'header header header header header header'
                'menu main main main right right'
                'menu footer footer footer footer footer';
            gap: 10px;
            background-color: #2196F3;
            padding: 10px;
        }

        .grid-container > div {
            background-color: rgba(255, 255, 255, 0.8);
            text-align: center;
            padding: 20px 0;
            font-size: 30px;
        }

        /* Fixed footer */
        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #4CAF50;
            color: white;
            text-align: center;
        }

        span {
            color: red;
        }

        /* Custom form styling */
        .form-container {
            margin-top: 20px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
        }

    </style>
</head>
<body>
<!-- Stor del av html från contact.html (från webb1), vissa namn kke skiljer -->

<div class="topnav" id="myTopnav">
    <a href="index.html">Home</a>
    <a href="london.html">London</a>
    <a href="paris.html">Paris</a>
    <a href="#tokyo">Tokyo</a>
    <a href="cities.html">Cities Bucketlist</a>
    <a href="contactform.html">Contactforms</a>
    <a href="contact.html" class="active">Contact</a>
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
        <i class="fa fa-bars"></i>
    </a>
</div>

<!-- Rubrik -->
<div class="w3-container w3-yellow">
    <h1>Surbey</h1>
    <p>Vilken stad gillar du mest?</p>
</div>

<!-- Formulär -->
<div class="w3-row-padding">
    <div class="w3-third" id="formQuestion1">
        <h2>Contact Form</h2>

        <?php
        // Deklarerar variabler för formulärfält och felmeddelanden
        $fname = $ename = $email = $msg = $city = "";
        $fnameErr = $enameErr = $emailErr = $msgErr = $cityErr = "";

        // Om formuläret har skickats (POST)
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validering av fälten
            if (empty($_POST["fname"])) {
                $fnameErr = "Förnamn är obligatoriskt.";
            } else {
                // Rensar användardata
                $fname = clean_input($_POST["fname"]);
            }

            if (empty($_POST["ename"])) {
                $enameErr = "Efternamn är obligatoriskt.";
            } else {
                $ename = clean_input($_POST["ename"]);
            }

            if (empty($_POST["email"])) {
                $emailErr = "E-post är obligatoriskt.";
            } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                // Kollar om e-posten är korrekt
                $emailErr = "Ogiltig e-postadress.";
            } else {
                $email = clean_input($_POST["email"]);
            }

            if (empty($_POST["msg"])) {
                $msgErr = "Meddelande är obligatoriskt.";
            } else {
                $msg = clean_input($_POST["msg"]);
            }

            // Validering av radioknapp
            if (empty($_POST["city"])) {
                $cityErr = "Vänligen välj en favoritstad.";
            } else {
                $city = clean_input($_POST["city"]);
            }
        }

         // Funktion för att rensa användardata
        function clean_input($data) {
            $data = trim($data);               // Tar bort extra mellanslag i början och slutet
            $data = stripslashes($data);       // Tar bort snedstreck
            $data = htmlspecialchars($data);   // Omvandlar specialtecken för säkerhet
            return $data;
        }
        ?>

        <!-- Här börjar själva formuläret -->
        <div class="form-container">
            <form method="post" action="">
                <!-- Förnamn -->
                Förnamn:<br>
                <input type="text" name="fname" value="<?php echo $fname; ?>" /><br>
                <span><?php echo $fnameErr; ?></span><br>

                <!-- Efternamn -->
                Efternamn:<br>
                <input type="text" name="ename" value="<?php echo $ename; ?>" /><br>
                <span><?php echo $enameErr; ?></span><br>

                <!-- E-post -->
                E-post:<br>
                <input type="email" name="email" value="<?php echo $email; ?>" /><br>
                <span><?php echo $emailErr; ?></span><br>

                <!-- Meddelande -->
                Meddelande:<br>
                <textarea name="msg" cols="45" rows="5"><?php echo $msg; ?></textarea><br>
                <span><?php echo $msgErr; ?></span><br>

                <!-- Radioknappar -->
                Favoritstad:<br>
                <input type="radio" name="city" value="London" <?php echo ($city == "London") ? "checked" : ""; ?> /> London
                <input type="radio" name="city" value="Paris" <?php echo ($city == "Paris") ? "checked" : ""; ?> /> Paris
                <input type="radio" name="city" value="Tokyo" <?php echo ($city == "Tokyo") ? "checked" : ""; ?> /> Tokyo <br>
                <span><?php echo $cityErr; ?></span><br>

                <!-- Skicka -->
                <input type="submit" value="Skicka">
            </form>
        </div>

        <!-- Visa resultat när formuläret skickas -->
        <?php

        // Om formuläret har skickats och inga fält har fel
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !$fnameErr && !$enameErr && !$emailErr && !$msgErr && !$cityErr) {
            echo "<div class='form-container'>";
            echo "<h3>Resultat:</h3>";
            echo "<p><strong>Förnamn:</strong> $fname</p>";
            echo "<p><strong>Efternamn:</strong> $ename</p>";
            echo "<p><strong>E-post:</strong> $email</p>";
            echo "<p><strong>Meddelande:</strong> $msg</p>";
            echo "<p><strong>Favoritstad:</strong> $city</p>";
            echo "</div>";
        }
        ?>

    </div>
</div>

<!-- Footer -->
<div class="footer">
    <p>Footer Content</p>
</div>

</body>
</html>