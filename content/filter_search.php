    <?php

    // default search order and help text
    $order = " ORDER BY d.Character_Name ASC";
    $help_text = "";

    // retrieve user input ...  
    $playID = $_REQUEST['play_name'];
    $roleID = $_REQUEST['ms_role'];
    $actionID = $_REQUEST['cod_action'];
    $methodID = $_REQUEST['cod_method'];
    $alignmentID = $_REQUEST['moral_alignment'];

    // if the item is blank, replace it with a %% wildcard.
    $all_input = [$playID, $roleID, $actionID, $methodID, $alignmentID];

    foreach ($all_input as $index => $value) {
        if ($value === "") {
            $all_input[$index] = "%%";
        }
    }

    list($playID, $roleID, $actionID, $methodID, $alignmentID) = $all_input;


    // Set up heading before making it into a wildcard...
    $heading="Filter Results...";

    // All characters
    $all_characters = "%%";
   
    $sql_condition = "
    WHERE d.PlayID  LIKE ?
    AND d.RoleID LIKE ?
    AND d.COD_ActionID LIKE ?
    AND d.COD_MethodID LIKE ?
    AND d.Moral_AlignmentID LIKE ?

    "; 

    $params = [$playID, $roleID, $actionID, $methodID, $alignmentID];

    // $params = [$playID, $roleID, $actionID, $methodID, $alignmentID];

    $help_text = "Results show characters which match ALL the filters you chose.  If there are no results, try fewer parameters.";


    // Add order
    $sql_condition .= $order;


    include("results.php");

    ?>