<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);
session_start();
require_once __DIR__ . "../../constants.php";
require __DIR__ . '../../database/db_connect.php';

$sql = "
            SELECT P.p_id AS p_id, P.product_name AS product_name, P.price AS price, P.compare_price AS compare_price, P.image AS image, P.description AS description, GROUP_CONCAT(C.category_name) AS 'categories'
            FROM product P 
            LEFT JOIN product_category PC ON P.p_id = PC.p_id 
            LEFT JOIN category C ON C.c_id = PC.c_id
            GROUP BY P.p_id
        ";

$stmt = $conn->prepare($sql);
$stmt->execute();
$all_products = $stmt->fetchAll(PDO::FETCH_ASSOC);


// fetching all cart items
$cart_items = $_SESSION["cart"];

$all_product_ids = array_keys($cart_items);

foreach($all_product_ids as $k){
    echo "$k" . "<br>";
}

// $placeholder = str_repeat("?", count($all_product_ids));
$placeholder = array_fill(0, count($all_product_ids), "?");
$placeholder = implode(",", $placeholder);

$product_sql = "SELECT * FROM product WHERE p_id IN ($placeholder)";
$product_stmt = $conn->prepare($product_sql);
$product_stmt->execute($all_product_ids);
$products = $product_stmt->fetchAll(PDO::FETCH_ASSOC);

echo "length" . count($products);


?>


<!doctype html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<style>
    .dropdown-submenu {
    position: relative;
  }
  
  .dropdown-submenu > .dropdown-menu {
    top: 0;
    left: 100%;
    margin-left: .1rem;
  }
  
  .dropdown-submenu:hover > .dropdown-menu {
    display: block;
  }
</style>

<body>

    <div class="container-fluid m-0 p-0">
        <!-- navbar -->
        <!-- <nav class="navbar navbar-expand-lg bg-body-tertiary mb-3">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Navbar</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                        <a class="nav-link" href="#">Features</a>
                        <a class="nav-link" href="#">Pricing</a>
                        <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                    </div>
                </div>
            </div>
        </nav> -->

        <?php require '../user/components/user_navbar.php'; 
        ?>

        <!-- listing all products -->
        <div class="products container">
            <!-- <div class="row mt-3 mb-3">
                <div class="col col-md-8">
                    <h1>Cart Items</h1>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-4 g-3">
                <?php foreach ($all_products as $p) { ?>
                    <div class="col">
                        <div class="card h-100" style="width: 18rem;">
                            <img src="<?php echo $p["image"] ?>" class="card-img-top" alt="..." width="200px" height="200px">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $p["product_name"]; ?></h5>
                                <p class="card-text"><strong>Categories:</strong> <?php echo $p["categories"]; ?></p>
                                <p class="card-text"><strong>Description:</strong> <?php echo $p["description"]; ?></p>
                                <p class="card-text"><strong>Price: </strong><?php echo $p["price"]; ?>&#8377 <span class="text-decoration-line-through"><?php echo $p["compare_price"]; ?>&#8377 </span></p>
                            </div>
                            <div class="card-footer">
                                <div class="col col-sm-6">
                                    <a href="./update_product.php/?p_id=<?php echo $p["p_id"] ?>" class="btn btn-primary" target="">Add to Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div> -->

            <div class="row">
                <div class="col-7">
                    <div class="row mt-3 mb-3">
                        <div class="col col-md-8">
                            <h1>Cart Items</h1>
                        </div>
                    </div>

                    <?php foreach($products as $p){ ?>
                    <div class="card mb-3" style="max-width: 540px;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="https://picsum.photos/id/250/50/" class="img-fluid rounded-start h-100" alt="..." width="200px">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $p["product_name"] ?></h5>
                                    <p class="card-text">Price : <?php echo $p["price"] ?></p>
                                    <p class="card-text">Quantity : <?php echo $cart_items[$p["p_id"]] ?></p>
                                    <button class="btn btn-primary">Update cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="col-5">
                    <div class="row mt-3 mb-3">
                        <div class="col col-md-8">
                            <h3>Total</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>