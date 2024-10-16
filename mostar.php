<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smart_shoo";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Manejo de inserciones
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['pantallas_submit'])) {
        $cantidad = $_POST['cantidad'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $precio = $_POST['precio'];
        $fecha_venta = $_POST['fecha_venta'];
        $sql = "INSERT INTO ventas_pantallas (cantidad, marca, modelo, precio, fecha_venta) VALUES ('$cantidad', '$marca', '$modelo', '$precio', '$fecha_venta')";
        $conn->query($sql);
    }
    if (isset($_POST['accesorios_submit'])) {
        $tipo_accesorio = $_POST['tipo_accesorio'];
        $cantidad = $_POST['cantidad'];
        $precio = $_POST['precio'];
        $fecha_venta = $_POST['fecha_venta'];
        $sql = "INSERT INTO ventas_accesorios (tipo_accesorio, cantidad, precio, fecha_venta) VALUES ('$tipo_accesorio', '$cantidad', '$precio', '$fecha_venta')";
        $conn->query($sql);
    }
    if (isset($_POST['reparaciones_submit'])) {
        $numero_telefono = $_POST['numero_telefono'];
        $nombre_cliente = $_POST['nombre_cliente'];
        $modelo = $_POST['modelo'];
        $precio = $_POST['precio'];
        $fecha_reparacion = $_POST['fecha_reparacion'];
        $sql = "INSERT INTO reparaciones (numero_telefono, nombre_cliente, modelo, precio, fecha_reparacion) VALUES ('$numero_telefono', '$nombre_cliente', '$modelo', '$precio', '$fecha_reparacion')";
        $conn->query($sql);
    }
}

// Mostrar las tablas
function mostrarTabla($conn, $tabla) {
    $sql = "SELECT * FROM $tabla";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1'><tr>";
        // Obtener y mostrar los nombres de las columnas
        while ($field = $result->fetch_field()) {
            echo "<th>" . $field->name . "</th>";
        }
        echo "</tr>";
        // Mostrar los registros
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . $value . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No hay registros en la tabla $tabla.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Inserciones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('moto.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #fff;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        .navbar {
            width: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            padding: 15px;
            display: flex;
            justify-content: center;
        }

        .navbar button {
            margin: 0 10px;
            padding: 10px 20px;
            background-color: #222;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 18px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.2);
            transition: transform 0.3s, background-color 0.3s, box-shadow 0.3s;
        }

        .navbar button:hover {
            background-color: #555;
            transform: scale(1.05);
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.7), 0 0 30px rgba(0, 255, 255, 0.5);
        }

        .content {
            padding: 20px;
            background-color: rgba(50, 50, 50, 0.7);
            color: black;
            border-radius: 15px;
            margin: 20px auto;
            width: 90%;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        }

        .section {
            display: none;
            animation: fadeIn 0.7s ease-in-out;
            border: 2px solid #00ffcc;
            padding: 10px;
            margin: 10px 0;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 255, 255, 0.3);
        }

        .section.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table, th, td {
            border: 2px solid #00ffcc;
            padding: 10px;
            text-align: left;
            background-color: rgba(255, 255, 255, 0.9);
            color: black;
        }

        th {
            background-color: rgba(0, 255, 255, 0.5);
            color: black;
        }

        td:hover {
            background-color: rgba(0, 255, 255, 0.2);
            transition: background-color 0.3s ease;
        }

        .description {
            color: black;
            margin-top: 20px;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
        }





        .section {
    display: none;
    animation: fadeIn 0.7s ease-in-out;
    border: 2px solid #00ffcc; /* Color de borde */
    padding: 20px; /* Espaciado interno */
    margin: 10px 0;
    border-radius: 10px; /* Esquinas redondeadas */
    box-shadow: 0 0 20px rgba(0, 255, 255, 0.5); /* Sombra */
    background-color: rgba(255, 255, 255, 0.9); /* Fondo */
    transition: transform 0.3s; /* Efecto al pasar el ratón */
}

.section:hover {
    transform: scale(1.02); /* Escala al pasar el ratón */
}

input[type="text"], input[type="number"], input[type="date"] {
    width: calc(100% - 20px); /* Ancho del input */
    padding: 10px; /* Espaciado interno */
    margin: 5px 0; /* Margen superior e inferior */
    border: 2px solid #00ffcc; /* Borde */
    border-radius: 5px; /* Esquinas redondeadas */
    background-color: rgba(240, 240, 240, 0.8); /* Fondo del input */
    color: #222; /* Color del texto */
    transition: border-color 0.3s; /* Transición al cambiar el borde */
}

input[type="text"]:focus, input[type="number"]:focus, input[type="date"]:focus {
    border-color: #00ffcc; /* Color del borde al enfocar */
    outline: none; /* Sin borde de enfoque */
}

button {
    padding: 10px 20px; /* Espaciado interno del botón */
    background-color: #00ffcc; /* Color de fondo */
    border: none; /* Sin borde */
    color: black; /* Color del texto */
    cursor: pointer; /* Cambia el cursor al pasar el ratón */
    font-size: 18px; /* Tamaño de fuente */
    border-radius: 5px; /* Esquinas redondeadas */
    transition: background-color 0.3s, transform 0.3s; /* Transiciones */
}

button:hover {
    background-color: #00e6b3; /* Color al pasar el ratón */
    transform: scale(1.05); /* Escala al pasar el ratón */
}

    </style>
</head>
<body>

    <div class="navbar">
        <button onclick="showSection('pantallasInsert')">Insertar Ventas Pantallas</button>
        <button onclick="showSection('accesoriosInsert')">Insertar Ventas Accesorios</button>
        <button onclick="showSection('reparacionesInsert')">Insertar Reparaciones</button>
        <button onclick="showSection('verPantallas')">Ver Ventas Pantallas</button>
        <button onclick="showSection('verAccesorios')">Ver Ventas Accesorios</button>
        <button onclick="showSection('verReparaciones')">Ver Reparaciones</button>
        <a href="index3.html">
        <button >Inventario</button>
        </a>
    </div>

    <div class="content">
        <!-- Sección de Pantallas -->
        <div id="pantallasInsert" class="section">
            <h2>Insertar Ventas Pantallas</h2>
            <form method="post">
                <input type="number" name="cantidad" placeholder="Cantidad" required>
                <input type="text" name="marca" placeholder="Marca" required>
                <input type="text" name="modelo" placeholder="Modelo" required>
                <input type="number" step="0.01" name="precio" placeholder="Precio" required>
                <input type="date" name="fecha_venta" required>
                <button type="submit" name="pantallas_submit">Insertar</button>
            </form>
        </div>

        <!-- Sección de Accesorios -->
        <div id="accesoriosInsert" class="section">
            <h2>Insertar Ventas Accesorios</h2>
            <form method="post">
                <input type="text" name="tipo_accesorio" placeholder="Tipo de Accesorio" required>
                <input type="number" name="cantidad" placeholder="Cantidad" required>
                <input type="number" step="0.01" name="precio" placeholder="Precio" required>
                <input type="date" name="fecha_venta" required>
                <button type="submit" name="accesorios_submit">Insertar</button>
            </form>
        </div>

        <!-- Sección de Reparaciones -->
        <div id="reparacionesInsert" class="section">
            <h2>Insertar Reparaciones</h2>
            <form method="post">
                <input type="text" name="numero_telefono" placeholder="Número de Teléfono" required>
                <input type="text" name="nombre_cliente" placeholder="Nombre del Cliente" required>
                <input type="text" name="modelo" placeholder="Modelo" required>
                <input type="number" step="0.01" name="precio" placeholder="Precio" required>
                <input type="date" name="fecha_reparacion" required>
                <button type="submit" name="reparaciones_submit">Insertar</button>
            </form>
        </div>

        <!-- Sección para ver Ventas Pantallas -->
        <div id="verPantallas" class="section">
            <h2>Ventas de Pantallas</h2>
            <?php mostrarTabla($conn, 'ventas_pantallas'); ?>
        </div>

        <!-- Sección para ver Ventas Accesorios -->
        <div id="verAccesorios" class="section">
            <h2>Ventas de Accesorios</h2>
            <?php mostrarTabla($conn, 'ventas_accesorios'); ?>
        </div>

        <!-- Sección para ver Reparaciones -->
        <div id="verReparaciones" class="section">
            <h2>Reparaciones</h2>
            <?php mostrarTabla($conn, 'reparaciones'); ?>
        </div>

        <div class="description">
            <h3>Venta de Accesorios para Teléfonos</h3>
            <p>Ofrecemos una amplia variedad de accesorios para teléfonos móviles, diseñados para mejorar y proteger tu dispositivo. Desde fundas resistentes que ofrecen estilo y seguridad, hasta protectores de pantalla que mantienen tu pantalla libre de rayones. Además, contamos con cargadores, cables, audífonos y otros complementos esenciales para tu teléfono. En nuestra tienda, nos aseguramos de ofrecer productos de la mejor calidad, siempre a precios competitivos para garantizar que tengas todo lo necesario para tu teléfono en un solo lugar.</p>

            <h3>Venta de Pantallas para Teléfonos</h3>
            <p>Especialistas en la venta de pantallas para diferentes marcas y modelos de teléfonos, garantizamos productos originales o de alta calidad para reemplazo. Nuestras pantallas están diseñadas para ofrecer un rendimiento óptimo, asegurando colores nítidos, alta sensibilidad al tacto y resistencia a golpes y arañazos. Contamos con un equipo de expertos que puede ayudarte a elegir la pantalla adecuada para tu dispositivo y guiarte en todo el proceso de compra.</p>

            <h3>Ventas Generales</h3>
            <p>Nuestra sección de ventas abarca todos los productos disponibles en nuestro inventario, desde pantallas hasta accesorios y repuestos para teléfonos móviles. Nos enorgullece ofrecer una experiencia de compra rápida, segura y eficiente, asegurando que cada cliente reciba productos de calidad a precios accesibles. Además, nuestras ofertas y promociones constantes hacen que cada visita a nuestra tienda sea una oportunidad de encontrar lo que necesitas al mejor precio.</p>
        </div>
    </div>

    <script>
        function showSection(sectionId) {
            const sections = document.querySelectorAll('.section');
            sections.forEach(section => {
                section.classList.remove('active');
            });
            document.getElementById(sectionId).classList.add('active');
        }
    </script>
</body>
</html>
