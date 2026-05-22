    <div class="common logo-banner">
        <a href="index.php">
        <img class="logo-image" src="images/logo.png" alt="Line drawing of William Shakespear" height="75">
    </a>

        <h1>Shakespeare's People</h1>
    </div>  <!-- / logo-banner --> 



    <nav>

     <a href="index.php?page=content/random" class='nav-button' title="Displays five random characters"><i class="fa-solid fa-shuffle"></i></a>


      <?php include("filter-box.php"); ?>

        <!-- Filter button - uses Javascript... -->

        <a href="#" class="nav-button" title="Filter results based play, role etc" onclick="openNav()">
        <i class="fa-solid fa-filter"></i></a>      

        <div class="nav-combo">
            <div class="hamburger">
            <i class="fa-solid fa-search" onclick="changeIcon(this)"></i>
            </div>

            <div class="nav-items">


            <!-- Loop to create four quick search boxes -->
            <?php
            $quick_searches = [
                'quick_search'     => 'Quick',
                'play_search'      => 'Play',
                'character_search' => 'Character',
                'death_search'     => 'Death'
            ];

            foreach ($quick_searches as $name => $placeholder) : ?>
                
                <form class="key-search" method="post" action="index.php?page=content/quick_search" enctype="multipart/form-data">
                    
                <input class="search quicksearch" 
                        type="text" 
                        name="quick_search_term" 
                        value="" 
                        required 
                        placeholder="<?= $placeholder; ?>">

                <button type="submit" class="submit" name="<?= $name; ?>">
                    <i class="fa-solid fa-magnifying-glass fa-flip-horizontal"></i>
                </button>
                </form>

            <?php endforeach; ?>


            </div>  <!-- / nav-items -->


        </div>    <!-- /  nav combo -->


    </nav>

    <div class="log-in-out">

        <?php
        if(isset($_SESSION['admin'])) {

            ?>

            <a class="nav-button" href="index.php?page=admin/add_entry">
            <i class="fa-solid fa-plus"></i></a>
            &nbsp; &nbsp;
            <a class="nav-button" href="index.php?logout=1">
            <i class="fa-solid fa-right-to-bracket fa-flip-horizontal"></i></a>

            <?php

        } // end admin if

    else {

        ?>
            <a class="nav-button" href="index.php?page=admin/login">
            <i class="fa-solid fa-right-to-bracket"></i></a>
        <?php

    } // end login else
    ?>


    </div>  <!-- / log-in-out -->
