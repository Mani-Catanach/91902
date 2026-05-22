    <?php

    // default search order and help text
    $order = " ORDER BY d.Character_name ASC";
    $help_text = "";


    // retrieve search type and search term...

    $search_type_array = [
            "quick_search"  => "quick",
            "play_search" => "play",
            "character_search" => "character",
            "death_search" => "death"
    ];

    // Loop through the array to detect which submit button was pressed
    foreach ($search_type_array as $submit_name => $type_value) {
        if (isset($_POST[$submit_name])) {
            $search_type = $type_value;
            break;
        }
    }
    
    $search_term = $_REQUEST['quick_search_term'];



    // Set up heading before making it into a wildcard...
    $heading=$search_term;

    // make search term into a wildcard so we can use it with our prepared statement
    $search_term = '%'.$search_term.'%';

    // Dictionary containing 'single' searches and columns
    $search_columns = [
    "play"      => "Play",
    "character"  => "Character_name",
    ];

// Query for play / character (single column)
if (array_key_exists($search_type, $search_columns)) {
    $column = $search_columns[$search_type];
    $sql_condition = "WHERE `$column` LIKE ?";
    $params = [$search_term];

}

// Quick Search
elseif ($search_type == "quick")
{
    $sql_condition = "
    WHERE `Play` LIKE ?
    OR `Method` LIKE ?
    OR `Action` LIKE ?
    OR `Character_name` LIKE ?    
    OR k1.Trait LIKE ?
    OR k2.Trait LIKE ?
    OR k3.Trait LIKE ?    
    "; 

    // creates an array with seven terms
    $params = array_fill(0, 7, $search_term);

    $help_text = "Results are based on play name, character name, cause of death and key trait/s.";
}

// Cause of death (method and action)
else {
        $sql_condition = "
    WHERE `Method` LIKE ?
    OR `Action` LIKE ?
    "; 

    $params = [$search_term, $search_term];

    $help_text = "Results are based on how the character died - action (generic) and method (specific).";
}

    // Add order
    $sql_condition .= $order;


    include("results.php");

    ?>