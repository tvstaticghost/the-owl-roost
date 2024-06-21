<?php 
require('database.php');
$communities = $conn->queryCommunities();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Owl Roost | Communities</title>
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="icon" href="owl.sv" type="image/x-icon">
    <link rel="shortcut icon" href="owl.svg" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<?php include('includes/header.php');?>
    <h1 class="text-slate-200 text-3xl mt-10 text-center">Communities</h1>
    <div class="p-4 bg-slate-300 rounded mt-4 px-4 md:w-9/12 m-auto">
        <h2 class="font-semibold text-xl mb-2 lg:text-2xl">Community Links</h2>
        <?php foreach($communities as $community) :?>
            <p><a href="<?=$community['link']?>" class="text-amber-700 hover:text-amber-600"><?=$community['name']?></a></p>
        <?php endforeach ;?>
    </div>
</body>
</html>
