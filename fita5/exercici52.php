<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FITA 5 - Ejercicicio 5.1</title>
</head>

<body>

    <form method="post">
        <label for="searchLanguage">Lenguaje:</label>
        <input type="text" name="searchLanguage" id="searchLanguage">
        <input type="submit" name="Buscar" value="Buscar">
    </form>

    <?php
    //connexió dins block try-catch:
    //  prova d'executar el contingut del try
    //  si falla executa el catch


    try {
        $hostname = "localhost";
        $dbname = "mundo";
        $username = "admin123";
        $pw = "superlocal777";
        $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", "$username", "$pw");
    } catch (PDOException $e) {
        echo "Error connectant a la BD: " . $e->getMessage() . "<br>\n";
        exit;
    }

    if (isset($_POST["searchLanguage"])) {
        try {
            //preparem i executem la consulta
            $query = $pdo->prepare("SELECT co.name as 'countryName', cl.language as 'languageName', cl.IsOfficial as 'isOfficial', cl.percentage as 'percentage' FROM country co JOIN countrylanguage cl ON co.code = cl.countrycode WHERE cl.language LIKE '%$_POST[searchLanguage]%';");
            $query->execute();
        } catch (PDOException $e) {
            echo "Error de SQL<br>\n";
            //comprovo errors:
            $e = $query->errorInfo();
            if ($e[0] != '00000') {
                echo "\nPDO::errorInfo():\n";
                die("Error accedint a dades: " . $e[2]);
            }
        }
        echo "<table>";
        echo "<thead><th colspan='4' align='center' bgcolor='cyan'>Lenguaje PAISES</th></thead>";
        //anem agafant les fileres d'amb una amb una
        $row = $query->fetch();
        while ($row) {
            echo "\t<tr style='margin: 10px'>";
            echo "\t\t<td>" . $row['countryName'] . "</td>\n";
            echo "\t\t<td>" . $row['languageName'] . "</td>\n";
            echo "\t\t<td>" . $row['isOfficial'] . "</td>\n";
            echo "\t\t<td>" . $row['percentage'] . "</td>\n";
            echo "\t</tr>\n";
            $row = $query->fetch();
        }
        echo "</table>";
    }

    //eliminem els objectes per alliberar memòria 
    unset($pdo);
    unset($query)

    ?>

</body>

</html>