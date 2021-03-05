<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="js/ajax.js"></script>
    <title>AJAX Pagination PHP</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>

<body>
    <div class="bg-light p-5 rounded-lg m-3">
        <h1 class="display-4">Ajax Pagination PHP</h1>
        <p class="lead">Esto es un ejemplo de paginación con AJAX y PHP</p>
        <hr class="my-4">
        <div class="loading-overlay">
            <div class="overlay-content">Loading...</div>
        </div>
        <div class="row" id="contenido">
            <?php
            // Include pagination library file 
            include_once 'clases/pagination.class.php';

            // Include database configuration file 
            require_once 'config/db.php';

            // Set some useful configuration 
            $baseURL = 'datos.php';
            $limit = 8;

            // Count of all records 
            $query   = $db->prepare("SELECT COUNT(*) FROM paginacion");
            $query->execute();
            $count = $query->fetchColumn();

            // Initialize pagination class 
            $pagConfig = array(
                'baseURL' => $baseURL,
                'totalRows' => $count,
                'perPage' => $limit,
                'contentDiv' => 'postContent',
                'link_func' => 'searchFilter'
            );
            $pagination =  new Pagination($pagConfig);

            // Fetch records based on the limit 
            $stmt = $db->prepare("SELECT * FROM paginacion ORDER BY id DESC LIMIT $limit");
            $stmt->execute();
            $count = $stmt->rowCount();
            $data = $stmt->fetchAll();
            if ($count) {
            ?>
            <?php foreach ($data as $datos) { ?> 
                <!-- Display posts list -->
                <div class="col-3">
                    <div class="card" style="width: 18rem;">
                        <img src="<?php echo $datos['image'] ?>" class="card-img-top" alt="<?php echo $datos['title'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $datos['title'] ?></h5>
                            <p class="card-text"><?php echo $datos['description'] ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?> 
                <!-- Display pagination links -->
                <?php echo $pagination->createLinks(); ?>
            <?php
            } else {
                echo '<p>Post(s) not found...</p>';
            }
            ?>
        </div>
    </div>
</body>

</html>