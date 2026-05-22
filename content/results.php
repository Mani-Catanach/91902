<?php // retrieve data
    list($find_query, $find_count) = get_query($dbconnect, $sql_condition, $params);

    // set up heading for single / multiple results
    if($find_count == 1) {
        $results_heading = $heading;
    }

    else {
        $results_heading = $heading." (".$find_count." results)";
    }

    if($find_count > 0)

    {

        if($heading != "") {
    ?>

        <h2 class="search-heading">
            <?= htmlspecialchars($results_heading); ?>
        </h2>

    <?php

        }   // end non-blank heading if

        // display help text if it exists...
        if($help_text!="")
        {
            ?>
            <i class="results-heading"><i class="fa-solid fa-circle-info"></i> <?= $help_text; ?></i><br><br>
            <?php
        }

        // if we don't have help text, put in some extra white space between the sub-heading and the results.
        else {
            echo "<br>";
        }

    ?>

<div class="cards-outer">
    
<div class='all-cards'>


        <?php
while($find_rs = mysqli_fetch_assoc($find_query)) {


    // Search term / Text setup (retrieve text and save as variables for easy reference)
    // This is mostly to make searching / clickable links easy
    $ID = $find_rs['ID'];
    
    $character = $find_rs['Character_name'];
    $play = $find_rs['Play'];
    $category = $find_rs['Play_Cat'];
    $gender = $find_rs['Gender'];
    $role = $find_rs['Role'];
    $alignment = $find_rs['Alignment'];   
    $action = $find_rs['Action'];    
    $method = $find_rs['Method'];    

    $trait1 = $find_rs['Trait1'];
    $trait2 = $find_rs['Trait2'];
    $trait3 = $find_rs['Trait3'];

    $featured = $find_rs['Featured_Image'];

    // Image and icon set up...
    $category_icon = "images/icons/".$find_rs['Category_Icon'];
    $gender_icon = "images/icons/".$find_rs['Gender_Icon'];
    $role_icon = "images/icons/".$find_rs['Role_Icon'];
    $alignment_icon = "images/icons/".$find_rs['Moral_Icon'];
    $action_icon = "images/icons/".$find_rs['Action_Icon'];
    $method_icon = "images/icons/".$find_rs['Method_Icon'];

    // URL helpers
    $click_type = "index.php?page=content/click_search&search_type=";
    $click_term = "&search_term=";

    ?>




<div class="char-details">

    <div class="character-name"><?=  $character; ?></div>

    <div class="play-title">
        <a title="<?=  $category; ?>" class="category" 
        href="<?=  $click_type?>category<?=  $click_term.$category; ?>">
            <img src="<?=  $category_icon; ?>" alt="<?=  $category; ?>">
        </a>
        <a class="play" 
        href="index.php?page=content/click_search&search_type=play&search_term=<?=  urlencode($play); ?>">
        <?=  $play; ?></a>    </div>

    <?php

    // list to hold icons to easily generate 'icon row'
    // Title (and alt) | URL | icon     

    $all_icons = [

        [$gender, $click_type."gender".$click_term.$gender, $gender_icon],
        [$role, $click_type."ms_role".$click_term.$role, $role_icon],
        [$alignment, $click_type."moral_alignment".$click_term.$alignment, $alignment_icon],
        [$action, $click_type."cod_action".$click_term.urlencode($action), $action_icon],
        [$method, $click_type."cod_method".$click_term.urlencode($method), $method_icon]

    ];

    ?>

    <div class="icon-row">

    <?php foreach($all_icons as $item): ?>
            <a title="<?= $item[0]; ?>" href="<?= $item[1]; ?>"><img src="<?= $item[2]; ?>" alt="<?= $item[0]; ?>" ></a>  
            
    <?php endforeach; ?>
    
    </div> <!-- / icon row -->

    <div class="description">
    <?=  $find_rs['Description']; ?>
    </div>


    <div class="trait-tags">

    <?php
    
    $all_traits = [$trait1, $trait2, $trait3];
    
    // iterate through list of traits and output them (if they are not n/a)
    foreach ($all_traits as $trait) {
        if($trait != "n/a") {

            ?>
            
            <a href="<?=  $click_type?>trait<?=  $click_term.$trait; ?>" class="trait"><?=  $trait; ?></a>

            <?php

        }   // end if not n/a

    } // end trait foreach

    ?>

    </div>  <!-- / trait tags -->


    <?php
            // if user is logged in, show edit / delete options
        if (isset($_SESSION['admin']))  {

            ?>
            <div class="tools">
                <a class="nav-button" href="index.php?page=admin/edit&ID=<?= $ID; ?>"><i class="fa-solid fa-pen-nib"></i></a> &nbsp; &nbsp;

                <?php
                // only display 'delete' icon if the character is not a featured character.

                if($featured == "") {

                    ?>
                    <a class="nav-button" href="index.php?page=admin/delete_confirm&ID=<?= $ID; ?>"><i class="fa-solid fa-trash"></i></a>
                    <?php

                }   // end of featured if

                    else{
                        ?>
                        <a title="Featured item (can't be deleted)" class="nav-button grey-button" href="#"><i class="fa-solid fa-trash"></i></a>

                        <?php
                    }   // end of featured else     

                ?>


            </div>
            <?php
        }

        ?>



    </div>  <!-- / character details -->


    <?php

}   // end results while

?>


    </div>  <!-- / all-cards -->

</div>  <!-- / cards outer -->

<?php

    } // end more than 0 results

// if there are no results...
else {

    ?>

   <h2>No Results</h2>

   <div class="no-results-message">

    <div class='center-image'>
    <img class='error-image' src="images/no_results.png" alt="No results image" >
    </div>  <!-- / center-image -->

    <p>&nbsp;</p>

    <div class="error all">

   <p>
        Sorry!  There are no results for your search.
    </p>

    <p>
        Please try another search term / user fewer characters in the 'quick search' box.
    </p>

    </div>  <!--  / error box -->

</div>  <!-- / no results message -->

    <?php

} // end no results else

?>

<p>&nbsp;</p>