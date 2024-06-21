<?php
require('database.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['courseId'])) {
    $course = htmlspecialchars($_GET['courseId']);
    $result = $conn->querySpecificClass($course);
    $resources = $conn->queryResources($course);
    $descriptions = $conn->queryCourseDescription($course);
}
else {
    header('Location: /the-owl-roost/');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/index.css">
</head>
<body class="relative min-h-svh">
    <?php include('includes/header.php');?>
    <main class="flex flex-col items-center gap-2">
        <h1 class="text-slate-200 text-3xl mt-10 text-center"><?=$result[0]['course_name']?></h1>
        <div class="px-4 md:w-9/12 m-auto">
            <div class="p-4 bg-slate-300 rounded mt-4">
                <div class="grid grid-cols-4 gap-2">
                    <p class="text-sm sm:text-xl">Course Number</p>
                    <p class="text-sm self-end sm:text-xl">Difficulty</p>
                    <p class="text-sm self-end sm:text-xl">Prerequisite</p>
                    <p class="text-sm sm:text-xl">Language Used</p>
                </div>
                <div class="grid grid-cols-4 text-sm font-semibold gap-2">
                    <p class="lg:text-lg"><?=$result[0]['course_number']?></p>
                    <p class="lg:text-lg"><?=$result[0]['course_difficulty']?>/5</p>
                    <p class="lg:text-lg"><?=$result[0]['prereq']?></p>
                    <?php if ($resources[0]['language_used'] !== null) :?>
                        <p class="lg:text-lg"><?=$resources[0]['language_used']?></p>
                    <?php else : ?>
                        <p class="lg:text-lg">N/A</p>
                    <?php endif ?>
                </div>
            </div>
            <div class="bg-slate-300 rounded mt-4 p-4">
            <h2 class="font-semibold text-xl mb-2 lg:text-2xl">Course Description</h2>
                <?php if ($descriptions) :?>
                    <?=$descriptions['course_description']?>
                <?php endif ?>
            </div>
            <div class="p-4 bg-slate-300 rounded flex flex-col mt-4">
                <h2 class="font-semibold text-xl mb-2 lg:text-2xl">Course Resources</h2>
                <!--Rendering the course resources-->
                <?php foreach($resources as $resource) : ?>
                    <?php if ($resource['resource_desc_1'] !== null) : ?>
                        <p><a href="<?=$resource['resource_1']?>" class="text-amber-700 hover:text-amber-600"><?=$resource['resource_desc_1']?></a></p>
                    <?php else : ?>
                        <p><?=$resource['resource_1']?></p>
                    <?php endif ?>
                    <?php if ($resource['resource_desc_2'] !== null) : ?>
                        <p><a href="<?=$resource['resource_2']?>" class="text-amber-700 hover:text-amber-600"><?=$resource['resource_desc_2']?></a></p>
                    <?php else : ?>
                        <p><?=$resource['resource_2']?></p>
                    <?php endif ?>
                    <?php if ($resource['resource_desc_3'] !== null) : ?>
                        <p><a href="<?=$resource['resource_3']?>" class="text-amber-700 hover:text-amber-600"><?=$resource['resource_desc_3']?></a></p>
                    <?php else : ?>
                        <p><?=$resource['resource_3']?></p>
                    <?php endif ?>
                <?php endforeach ; ?>
                <h2 class="font-semibold mt-2 text-xl lg:text-2xl">Resource Links</h2>
                <!--Rendering the course links-->
                <?php foreach($resources as $resource) : ?>
                    <?php if ($resource['link_1'] !== null && $resource['link_desc_1'] !== null) :?>
                        <p><a href="<?=$resource['link_1']?>" class="text-amber-700 hover:text-amber-600"><?=$resource['link_desc_1']?></a></p>
                    <?php endif ?>
                    <?php if ($resource['link_2'] !== null && $resource['link_desc_2'] !== null) :?>
                        <p><a href="<?=$resource['link_2']?>" class="text-amber-700 hover:text-amber-600"><?=$resource['link_desc_2']?></a></p>
                    <?php endif ?>
                    <?php if ($resource['link_3'] !== null && $resource['link_desc_3'] !== null) :?>
                        <p><a href="<?=$resource['link_3']?>" class="text-amber-700 hover:text-amber-600"><?=$resource['link_desc_3']?></a></p>
                    <?php endif ?>
                <?php endforeach ; ?>
            </div>
        </div>
    </main>
    <?php include('includes/footer.php')?>
    <script src="../assets/js/main.js"></script>
</body>
</html>