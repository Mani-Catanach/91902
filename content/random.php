    <?php

    // Wild card 'search term' to return all results so that we can choose five random results and still use a prepared statement
    $search_term = "%%";
    $params = [$search_term];


    // Set up query
    // $sql_condition = "ORDER BY RAND() LIMIT 5";
    
    $sql_condition = "WHERE `Play` LIKE ? ORDER BY RAND() LIMIT 5";    
    $heading="Random";
    
    $help_text = "Press 'random' again to generate another set of characters.";

    include("results.php");

    ?>