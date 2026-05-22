<?php

// retrieve search type and term
$search_type = to_clean($_REQUEST['search_type']);
$search_term = to_clean($_REQUEST['search_term']);

$heading = $search_term;
$help_text = "";
$order = " ORDER BY s.Character_Name ASC";

// Dictionary containing 'single' searches and columns
$search_columns = [
    "play"      => "Play",
    "category"  => "Play_Cat",
    "gender"    => "M_or_F",
    "ms_role"      => "Role",
    "moral_alignment" => "Alignment",
    "cod_action"    => "Action",
    "cod_method"    => "Method"
];

// Parameters for all the searches except 'Trait' (one term)
$params = [$search_term];

// Look up column based on search type (if it exists)
if (array_key_exists($search_type, $search_columns)) {
    $column = $search_columns[$search_type];
    $sql_condition = "WHERE `$column` LIKE ?";
}
else {
    // If it does not exist, it's a trait search...
    $sql_condition = "
        WHERE k1.Trait LIKE ?
        OR k2.Trait LIKE ?
        OR k3.Trait LIKE ?
    ";
    $params = array_fill(0, 3, $search_term);
}

// Add order
$sql_condition .= $order;

include("results.php");

?>
