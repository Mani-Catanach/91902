<?php

// check user is logged in
if(isset($_SESSION['admin'])) {

    // get ID for quote to be edited
    $ID = $_REQUEST['ID'];

    // retrieve contents of quote
    $get_entry_sql = "WHERE ID LIKE ?";
    $params = [$ID];

    // use our function but just get the query, not the number of results.
    $get_entry_query = get_query($dbconnect, $get_entry_sql, $params)[0];
    $get_entry_rs = mysqli_fetch_assoc($get_entry_query);

    // retrieve existing data to populate form
    $character_name = $get_entry_rs['Character_Name'];
    $description = $get_entry_rs['Description'];

    // dropdowns
    $dropdown_details = [
        ['play', 'play_name', 'PlayID', 'Play', 'Play Name...', $get_entry_rs['PlayID']],
        ['gender', 'gender', 'GenderID', 'M_or_F', 'Gender...', $get_entry_rs['GenderID']],
        ['role', 'ms_role', 'RoleID', 'Role', 'Role...', $get_entry_rs['RoleID']],
        ['alignment', 'moral_alignment', 'Moral_AlignmentID', 'Alignment', 'Moral Alignment...', $get_entry_rs['Moral_AlignmentID']],
        ['COD_action', 'cod_action', 'COD_ActionID', 'Action', 'Cause of Death (action)...', $get_entry_rs['COD_ActionID']],
        ['COD_method', 'cod_method', 'COD_MethodID', 'Method', 'Cause of Death (method)...', $get_entry_rs['COD_MethodID']],
    ];

    // get Key Traits from database
    $all_traits_sql = "SELECT * FROM key_traits ORDER BY Trait ASC";
    $all_traits = autocomplete_list($dbconnect, $all_traits_sql, 'Trait');

    // traits
    $traits = [];
    for ($i=1; $i<=3; $i++) {
        $trait_value = $get_entry_rs["Trait$i"] ?? '';
        $traits[$i] = ($trait_value === 'n/a') ? '' : $trait_value;
    }
?>

<div class="big-form">

<h2>Edit Entry</h2>

<form action="index.php?page=admin/edit_entry&ID=<?= $ID; ?>" method="post">

    <p>
        <input name="character" value="<?= htmlspecialchars($character_name); ?>" required/>
    </p>

    <!-- Dropdown boxes -->
    <?php
    foreach ($dropdown_details as $drop) {
        list($name, $table, $id_field, $label_field, $placeholder, $selected_id) = $drop;

        echo '<select name="' . htmlspecialchars($name) . '" class="big-dropdown" required>';
        echo '<option value="" disabled>' . htmlspecialchars($placeholder) . '</option>';
        get_options($dbconnect, $table, $id_field, $label_field, $selected_id);
        echo '</select>';
    }
    ?>

    <p>
        <textarea name="description" required><?= htmlspecialchars($description); ?></textarea>
    </p>

    <!-- Traits inputs looped -->
    <?php for ($i=1; $i<=3; $i++): ?>
        <div class="autocomplete">
            <input name="Trait<?= $i ?>" id="Trait<?= $i ?>" value="<?= htmlspecialchars($traits[$i]); ?>" <?= $i === 1 ? 'required' : ''; ?> />
        </div>
    <?php endfor; ?>

    <br /><br />

    <p><input class="large-submit" type="submit" name="submit" value="Submit" /></p>
</form>

</div>  <!-- / big form -->

<script>
    <?php include("autocomplete.php"); ?>  

    var all_traits = <?= $all_traits ?>;
    <?php for ($i=1; $i<=3; $i++): ?>
        autocomplete(document.getElementById("Trait<?= $i ?>"), all_traits);
    <?php endfor; ?>
</script>

<?php 
} else {
    $login_error = 'Please login to access this page';
    header("Location: index.php?page=admin/login&error=<?= urlencode($login_error) ?>");
}

ob_end_flush();
?>
