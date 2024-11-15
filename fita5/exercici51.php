<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FITA 5 - Ejercicicio 5.1</title>
</head>

<body>

    <form method="post">
        <label for="searchCity">Pais:</label>
        <input type="text" name="searchCity" id="searchCity">
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

    if (isset($_POST["searchCity"])) {
        try {
            //preparem i executem la consulta
            $query = $pdo->prepare("SELECT ci.name as 'cityName', co.name as 'countryName' FROM city ci JOIN country co ON ci.countrycode = co.code WHERE co.name LIKE '%$_POST[searchCity]%';");
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

        //anem agafant les fileres d'amb una amb una
        $row = $query->fetch();
        while ($row) {
            echo "<br>" . $row['cityName'] . " - " . $row['countryName'] . "<br>\n";
            $row = $query->fetch();
        }
    }

    //eliminem els objectes per alliberar memòria 
    unset($pdo);
    unset($query)

    ?>

</body>

</html>