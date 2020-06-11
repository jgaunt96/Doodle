<?php

    include("config.php");
    include("classes/SiteResultsProvider.php");
    include("classes/ImageResultsProvider.php");

    if(empty($_GET["term"])){
        exit("You must enter a search term");
    } else {
        $term = $_GET["term"];
    }

    // if(empty($_GET["type"])){
    //     $type = "sites";
    // } else {
    //     $type = $_GET["type"];
    // }

    $type = empty($_GET["type"]) ? "sites" : $_GET["type"];
    $page = empty($_GET["page"]) ? 1 : $_GET["page"];
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doodle</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <script
			  src="https://code.jquery.com/jquery-3.5.1.min.js"
			  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
			  crossorigin="anonymous"></script>
</head>
<body>

    <div class="wrapper">

        <div class="header">

            <div class="headerContent">

                <div class="logoContainer">
                    <a href="index.php">
                        <img src="assets/images/DoodleLogo.png">
                    </a>
                </div>

                <div class="searchContainer">

                    <form action="search.php" method="GET">
                    
                        <div class="searchBarContainer">

                            <input type="hidden" name="type" value="<?php echo $type ?>">
                            <input type="text" name="term" value="<?php echo $term ?>" class="searchBox">
                            <button class="searchButton"><img src="Assets/images/icons/search.png"></button>

                        </div>

                    </form>
                </div>

            </div>

            <div class="tabsContainer">
                <ul class="tabList">
                    <li class="<?php echo $type ==  'sites' ? 'active' : '' ?>">
                        <a href='<?php echo "search.php?term=$term&type=sites"; ?>'>
                            Sites
                        </a>
                    </li>
                    <li class="<?php echo $type ==  'images' ? 'active' : '' ?>">
                        <a href='<?php echo "search.php?term=$term&type=images"; ?>'>
                            Images
                        </a>
                    </li>
                </ul>
            </div>

        </div>

        <div class="mainResultsSection">

        <?php

        if($type == "sites"){
            $resultsProvider = new SiteResultsProvider($con);
            $pageSize = 20;
        }
        else{
            $resultsProvider = new ImageResultsProvider($con);
            $pageSize = 30;
        }
        
        $numResults = $resultsProvider->getNumResults($term);

        echo "<p class='resultsCount'>$numResults results found</p>";

        echo $resultsProvider->getResultsHtml($page, $pageSize, $term);
        ?>

        </div>

        <div class="paginationContainer">

            <div class="pageButtons">

                <div class="pageNumberContainer">
                    <img src="assets/images/pageStart.png" alt="logo start">
                </div>

                <?php

                    $pagesToShow = 10;
                    $numPages = ceil($numResults / $pageSize);
                    $pagesLeft = min($pagesToShow, $numPages);

                    $currentPage = $page - floor($pagesToShow / 2);

                    if($currentPage < 1){
                        $currentPage = 1;
                    }

                    if($currentPage + $pagesLeft > $numPages){
                        $currentPage = $numPages + 1 - $pagesLeft;
                    }

                    while($pagesLeft != 0 && $currentPage <= $numPages){

                        if($currentPage == $page){
                            echo "<div class='pageNumberContainer'>
                                <img src='assets/images/pageSelected.png'>
                                <span class='pageNumber'>$currentPage</span>
                            </div>";

                        }
                        else {
                            echo "<div class='pageNumberContainer'>
                                <a href='search.php?term=$term&type=$type&page=$currentPage'>
                                    <img src='assets/images/page.png'>
                                    <span class='pageNumber'>$currentPage</span>
                                </a>
                            </div>";
                        }
                        

                            $currentPage++;
                            $pagesLeft--;
                    }

                ?>

                <div class="pageNumberContainer">
                    <img src="assets/images/pageEnd.png" alt="logo end">
                </div>

            </div>
        
        </div>

    </div>

    
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>