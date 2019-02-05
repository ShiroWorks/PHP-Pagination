<?php

$db = new PDO('mysql:dbname=pagination;host=127.0.0.1', 'root','');

// User input

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage= isset($_GET['per-page']) && $_GET['per-page'] <= 50 ? (int)$_GET['per-page'] :5;

// Positioning
$start= ($page>1) ? ($page * $perPage) - $perPage:0;




// Query

$articles = $db->prepare("
    SELECT SQL_CALC_FOUND_ROWS id, title
    FROM article
    LIMIT {$start}, {$perPage}
");

$articles->execute();

$articles = $articles->fetchAll(PDO::FETCH_ASSOC);

// Pages

$total=$db->query("SELECT FOUND_ROWS() as total")->fetch()['total'];
$pages = ceil($total/$perPage);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <title>Articles</title>
</head>
<body>

    <div class="container center-align">
        <?php foreach($articles as $article): ?>
            <div class="row">
                <div class="col s12 offset-s4 left-align">
                 <p><?= $article['id']; ?> <?= $article['title']; ?></p>
                 </div>
         <?php endforeach; ?>
        <ul class="pagination">
          <?php for($x=1; $x <= $pages; $x++): ?>
               <li <?php if($page ===$x){echo ' class="active"';} ?>><a href="?page=<?php echo $x; ?>&per-page=<?php echo $perPage;?>"><?= $x; ?></a></li> 
            <?php endfor; ?>
       </ul>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>