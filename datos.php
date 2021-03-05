<?php
if (isset($_POST['page'])) {
    // Include pagination library file 
    include_once 'clases/pagination.class.php';

    // Include database configuration file 
    require_once 'config/db.php';

    // Set some useful configuration 
    $baseURL = 'datos.php';
    $offset = !empty($_POST['page']) ? $_POST['page'] : 0;
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
        'currentPage' => $offset,
        'contentDiv' => 'postContent',
        'link_func' => 'searchFilter'
    );
    $pagination =  new Pagination($pagConfig);

    // Fetch records based on the offset and limit 
    $stmt = $db->prepare("SELECT * FROM paginacion LIMIT $offset,$limit");
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
}
?>