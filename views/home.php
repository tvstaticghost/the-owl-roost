<?php 
session_start();
require('database.php');

function filterClasses($haystack) {
    $newResult = [];
    $searchValue = strtolower($_POST['classFilter']);
    
    for ($i = 0; $i < count($haystack); $i++) {
        if (str_contains(strtolower($haystack[$i]['course_name']), $searchValue)) {
            $newResult[] = $haystack[$i];
        }
    }
    return $newResult;
}

$classList = $conn->queryAll("class_list");

if (isset($_POST['classFilter']) && $_POST['classFilter'] !== '') {
    $result = filterClasses($classList);
} 
elseif (isset($_POST['nameSort'])) {
    if (!isset($_SESSION['nameSort']) || $_SESSION['nameSort'] === 'DESC') {
        $_SESSION['nameSort'] = 'ASC';
    } 
    else {
        $_SESSION['nameSort'] = 'DESC';
    }
    $result = $conn->querySortedTable('class_list', 'course_name', 'name', $_SESSION['nameSort']);
}
elseif (isset($_POST['diffSort'])) {
    if (!isset($_SESSION['diffSort']) || $_SESSION['diffSort'] === 'DESC') {
        $_SESSION['diffSort'] = 'ASC';
    }
    else {
        $_SESSION['diffSort'] = 'DESC';
    }
    $result = $conn->querySortedTable('class_list', 'course_difficulty', 'difficulty', $_SESSION['diffSort']);
}
else {
    $result = $classList;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Owl Roost</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="icon" href="owl.sv" type="image/x-icon">
    <link rel="shortcut icon" href="owl.svg" type="image/x-icon">
    <script>
        console.log(window.location.href);
    </script>
</head>
<body class="relative min-h-svh">
    <?php include('includes/header.php');?>
    <main class="text-slate-200">
<!-- hero -->
        <div class="flex flex-col items-center mt-10">
            <h1 class="text-5xl sm:text-6xl md:text-8xl">The Owl Roost</h1>
            <h2 class="text-xl text-amber-600 text-center mt-2 sm:text-2xl md:text-3xl">Providing night owls with <span class="text-slate-200">quality</span> <br>study <span class="text-slate-200">resources</span></h2>
        </div>
<!-- Filter options -->
        <div class="mx-2 grid grid-cols-3 mt-10 text-lg pl-4 pr-1 items-center md:w-3/4 md:m-auto md:mt-4">
            <form method="post" class="self-end">
                <button id="sortName" name="nameSort"><img src="assets/images/sort-alpha-down.svg" alt="sortletter" class="w-8 hover:cursor-pointer" id="sortNameIcon"></button>
            </form>
            <form method="post" class="self-end ml-8 md:ml-1">
                <button id="sortDiff" name="diffSort"><img src="assets/images/sort-numeric-down.svg" alt="sortnumbers" class="w-8 hover:cursor-pointer md:ml-8" id="sortDiffIcon"></button>
            </form>
<!-- Form used for desktop view -->
            <form method="post" class="col-span-3 grid grid-cols-10 gap-2 text-black mr-3 md:mb-2 lg:col-span-1" id="searchBar">
                <input type="text" name="classFilter" class="col-span-7 py-2 pl-2 pr-2 rounded bg-slate-200" placeholder="Search by name...">
                <button class="col-span-3 bg-amber-500 rounded col-span-3 hover:cursor-pointer hover:bg-amber-700">Search</button>
            </form>
<!-- Form only used for mobile view -->
            <form method="post" class="hidden flex justify-end">
                <img src="assets/images/search.svg" alt="search" class="logo w-6 mr-4 sm:hidden">
            </form>
        </div>
<!-- Class List -->
        <div class="mt-2 text-lg mx-2 md:w-3/4 md:m-auto" id="course-table">
            <div class="grid grid-cols-3 border-2 min-w-3/4 py-3 rounded-t-xl bg-slate-200 font-background">
                <span class="ml-5 font-bold text-sm sm:text-lg">Class Name</span>
                <span class="font-bold ml-10 text-sm sm:text-lg">Difficulty</span>
                <span class="font-bold text-sm sm:text-lg">Prerequisite</span>
            </div>
            <?php for($i = 0; $i < count($result); $i++) : ?>
            <?php if ($i % 2 == 0) : ?>
                <?php if ($i === count($result) - 1) : ?>
                    <div class="min-w-3/4 m-auto py-2 grid grid-cols-3 items-center border-2 border-t-0 text-lg hover:cursor-pointer bg-slate-300 font-background hover-font rounded-b-xl course-container">
                <?php else : ?>
                    <div class="min-w-3/4 m-auto py-2 grid grid-cols-3 items-center border-2 border-t-0 text-lg hover:cursor-pointer bg-slate-300 font-background hover-font course-container">
                <?php endif ?>
            <?php else : ?>
                <?php if ($i === count($result) - 1) : ?>
                <div class="min-w-3/4 m-auto py-2 grid grid-cols-3 items-center border-2 border-t-0 text-lg hover:cursor-pointer bg-slate-200 rounded-b-xl font-background hover-font course-container">
                <?php else : ?>
                <div class="min-w-3/4 m-auto py-2 grid grid-cols-3 items-center border-2 border-t-0 text-lg hover:cursor-pointer bg-slate-200 font-background hover-font course-container">
                <?php endif ?>
            <?php endif ; ?>
                <div class="ml-5">
                    <p class="text-xs course-number-field"><?= $result[$i]['course_number']?></p>
                    <p class="text-sm sm:text-lg"><?= $result[$i]['course_name']?></p>
                </div>
                <p class="ml-10 text-sm"><?=$result[$i]['course_difficulty']?>/5</p>
                <p class="text-sm"><?=$result[$i]['prereq']?></p>
            </div>
            <?php endfor ; ?>
            <?php if (count($result) === 0) : ?>
                <div class="min-w-3/4 m-auto py-2 border-2 border-t-0 text-lg bg-slate-300 font-background rounded-b-xl">
                    <p class="text-center bold">No Classes Found...</p>
                </div>
            <?php endif ; ?>
        </div>
    </main>
    <?php include('includes/footer.php')?>
    <form action="/course" method="get" id="form">
        <input type="hidden" name="courseId" value="">
    </form>
    
    <script src="https://theowlroost.000webhostapp.com/assets/js/main.js"></script>
</body>
</html>
