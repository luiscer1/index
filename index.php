<?php
$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "biblioteca";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create Book
if (isset($_POST['create'])) {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $genero = $_POST['genero'];
    $num_paginas = $_POST['num_paginas'];

    $stmt = $conn->prepare("INSERT INTO libros (titulo, autor, genero, num_paginas) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $titulo, $autor, $genero, $num_paginas);
    $stmt->execute();
    $stmt->close();
}

// Read Books
$sql = "SELECT * FROM libros";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca</title>
</head>
<body>

    <h2>Libros en la Biblioteca</h2>

    <!-- Create Book Form -->
    <form method="post" action="">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" required>
        <label for="autor">Autor:</label>
        <input type="text" name="autor" required>
        <label for="genero">Género:</label>
        <input type="text" name="genero" required>
        <label for="num_paginas">Número de Páginas:</label>
        <input type="number" name="num_paginas" required>
        <button type="submit" name="create">Agregar Libro</button>
    </form>

    <!-- Display Books -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Autor</th>
            <th>Género</th>
            <th>Número de Páginas</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['titulo']}</td>";
            echo "<td>{$row['autor']}</td>";
            echo "<td>{$row['genero']}</td>";
            echo "<td>{$row['num_paginas']}</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <?php
    $conn->close();
    ?>
</body>
</html>
