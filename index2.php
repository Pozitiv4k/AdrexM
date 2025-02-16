<?php
session_start ();
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adăugare și Vizualizare Date</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php 
include "include/nav.php"?>

    <h2>Adăugare și Vizualizare Date</h2>
    <form action="insert.php" method="POST">
        <label for="produs">Alegeți produsul:</label>
        <select name="produs" id="produsSelect" onchange="updateTabel()">
            <option value="Pâine de grâu din făină integrală">Pâine de grâu din făină integrală</option>
            <option value="Chifla Orășenească">Chifla Orășenească</option>
            <option value="Pâine impletită">Pâine impletită</option>
            <option value="Franzela Orășenească">Franzela Orășenească</option>
            <option value="Pâine de grâu de calitate I">Pâine de grâu de calitate I</option>
        </select>
        <br><br>
        <label for="tabel">Alegeți tabelul:</label>
        <select name="tabel" id="tabelSelect" onchange="updateParametri()">
            <!-- Opțiunile pentru tabel vor fi actualizate dinamic -->
        </select>
        <br><br>
        <div id="parametriContainer">
            <!-- Aici vor fi afișate formularele pentru parametrii corespunzători -->
        </div>
        <br>
        <input type="submit" value="Adăugare Date">
    </form>

    <hr>

    <h2>Afișare Date</h2>
    <p>Alegeți tabelul pentru a afișa datele:</p>
    <ul>
        <li><a href="display.php?tabel=TabelNr3">Parametrii procesului tehnologic</a></li>
        <li><a href="display.php?tabel=TabelNr4">Parametrii de calitate pentru făina</a></li>
        <li><a href="display.php?tabel=TabelNr5">Parametrii de calitate pentru aluat</a></li>
        <li><a href="display.php?tabel=TabelNr6">Parametrii de calitate pentru pâine</a></li>
        <li><a href="display.php?tabel=TabelNr7">Parametrii din secția de fabricare a produsului</a></li>
        <li><a href="display.php?tabel=TabelNr9">Recomandări pentru dirijarea procesului tehnologic</a></li>
    </ul>
    <script>
        function updateTabel() {
            var produsSelect = document.getElementById("produsSelect");
            var produs = produsSelect.value;
            var tabelSelect = document.getElementById("tabelSelect");

            // Elimină toate opțiunile existente
            tabelSelect.innerHTML = "";

            // Adaugă opțiunile corespunzătoare produsului selectat
            switch (produs) {
                case "Pâine de grâu din făină integrală":
                    tabelSelect.innerHTML += `
                        <option value="TabelNr3">Parametrii procesului tehnologic</option>
                        <option value="TabelNr4">Parametrii de calitate pentru făina</option>
                        <option value="TabelNr5">Parametrii de calitate pentru aluat</option>
                        <option value="TabelNr6">Parametrii de calitate pentru pâine</option>
                        <option value="TabelNr7">Parametrii din secția de fabricare a produsului</option>
                        <option value="TabelNr9">Recomandări pentru dirijarea procesului tehnologic</option>`;
                    break;
                case "Chifla Orășenească":
                    tabelSelect.innerHTML += `
                        <option value="TabelNr3">Parametrii procesului tehnologic</option>
                        <option value="TabelNr4">Parametrii de calitate pentru făina</option>
                        <option value="TabelNr5">Parametrii de calitate pentru aluat</option>
                        <option value="TabelNr6">Parametrii de calitate pentru pâine</option>
                        <option value="TabelNr7">Parametrii din secția de fabricare a produsului</option>`;
                    break;
                case "Pâine impletită":
                case "Franzela Orășenească":
                case "Pâine de grâu de calitate I":
                    tabelSelect.innerHTML += `
                        <option value="TabelNr3">Parametrii procesului tehnologic</option>
                        <option value="TabelNr4">Parametrii de calitate pentru făina</option>
                        <option value="TabelNr5">Parametrii de calitate pentru aluat</option>
                        <option value="TabelNr6">Parametrii de calitate pentru pâine</option>
                        <option value="TabelNr7">Parametrii din secția de fabricare a produsului</option>`;
                    break;
                default:
                    break;
            }
        }

        function updateParametri() {
            var tabelSelect = document.getElementById("tabelSelect");
            var tabel = tabelSelect.value;
            var parametriContainer = document.getElementById("parametriContainer");

            // Sterge vechile parametri
            parametriContainer.innerHTML = "";

            // Generează formularele pentru parametri corespunzători tabelului selectat
            switch (tabel) {
                case "TabelNr3":
                    parametriContainer.innerHTML = `
                        <h3>Parametrii procesului tehnologic</h3>
                        <label for="durataFermentarii">Durata fermentării aluatului (minute):</label>
                        <input type="number" name="durataFermentarii" id="durataFermentarii" required><br><br>
                        <label for="durataDospirii">Durata dospirii bucăților de aluat (minute):</label>
                        <input type="number" name="durataDospirii" id="durataDospirii" required><br><br>
                        <label for="temperaturaCoacerii">Temperatura de coacere (°C):</label>
                        <input type="number" name="temperaturaCoacerii" id="temperaturaCoacerii" required><br><br>
                        <label for="durataCoacerii">Durata de coacere (minute):</label>
                        <input type="number" name="durataCoacerii" id="durataCoacerii" required><br><br>`;
                    break;
                case "TabelNr4":
                    parametriContainer.innerHTML = `
                        <h3>Parametrii de calitate pentru făina</h3>
                        <label for="umiditateaFaina">Umiditatea (%):</label>
                        <input type="number" name="umiditateaFaina" id="umiditateaFaina" required><br><br>
                        <label for="aciditateaFaina">Aciditatea (%):</label>
                        <input type="number" name="aciditateaFaina" id="aciditateaFaina" required><br><br>
                        <label for="continutDeGluten">Conținut de gluten umed (%):</label>
                        <input type="number" name="continutDeGluten" id="continutDeGluten" required><br><br>`;
                    break;
                case "TabelNr5":
                    parametriContainer.innerHTML = `
                        <h3>Parametrii de calitate pentru aluat</h3>
                        <label for="umiditateaAluat">Umiditatea aluatului (%):</label>
                        <input type="number" name="umiditateaAluat" id="umiditateaAluat" required><br><br>
                        <label for="aciditateaAluat">Aciditatea aluatului (%):</label>
                        <input type="number" name="aciditateaAluat" id="aciditateaAluat" required><br><br>`;
                    break;
                case "TabelNr6":
                    parametriContainer.innerHTML = `
                        <h3>Parametrii de calitate pentru pâine</h3>
                        <label for="umiditateaPaine">Umiditatea pâinii (%):</label>
                        <input type="number" name="umiditateaPaine" id="umiditateaPaine" required><br><br>
                        <label for="aciditateaPaine">Aciditatea pâinii (%):</label>
                        <input type="number" name="aciditateaPaine" id="aciditateaPaine" required><br><br>
                        <label for="porozitateaPaine">Porozitatea pâinii (%):</label>
                        <input type="number" name="porozitateaPaine" id="porozitateaPaine" required><br><br>
                        <label for="masaPaine">Masa pâinii (KG):</label>
                        <input type="number" name="masaPaine" id="masaPaine" required><br><br>`;
                    break;
                case "TabelNr7":
                    parametriContainer.innerHTML = `
                        <h3>Parametrii din secția de fabricare a produsului</h3>
                        <label for="temperaturaAerului">Temperatura aerului (°C):</label>
                        <input type="number" name="temperaturaAerului" id="temperaturaAerului" required><br><br>
                        <label for="umiditateaAerului">Umiditatea relativă a aerului (%):</label>
                        <input type="number" name="umiditateaAerului" id="umiditateaAerului" required><br><br>`;
                    break;
                case "TabelNr9":
                    parametriContainer.innerHTML = `
                        <h3>Recomandări pentru dirijarea procesului tehnologic</h3>
                        <label for="recomandari">Recomandări tehnologice:</label><br>
                        <textarea name="recomandari" id="recomandari" rows="4" cols="50" required></textarea><br><br>`;
                    break;
                default:
                    break;
            }
        }
    </script>
    
</body>
</html>
