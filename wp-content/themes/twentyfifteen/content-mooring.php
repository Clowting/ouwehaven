<?php
global $wpdb;
/**
 * The template used for displaying page content
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
    </header>
    <!-- .entry-header -->

    <div class="entry-content">
        <?php

        the_content ();

        ?>
        <!-- <select id="harbors" name="harbors"> -->

        <?php

        // 	$entries = $wpdb->get_results ( "SELECT DISTINCT ID, Naam FROM oh_harbors", ARRAY_A );
        // 	var_dump ( $entries );
        // 	foreach ( $entries as $e ) {
        // 		echo "<option value= '{$e['ID']}'  >" . $e ['Naam'] . "</option>";
        // 	}
        ?>
        <!-- </select> -->

        <table>
            <thead>
            <th>Haven</th>
            <th>Ligplaats Nummer</th>
            <th>Vrij</th>
            </thead>
            <tbody>
            <?php
            $result=$wpdb->get_results("SELECT lig.Nummer, lig.Haven_ID, haven.ID, haven.Naam FROM oh_moorings AS lig, oh_harbors AS haven WHERE lig.Haven_ID = haven.ID", ARRAY_A);

            foreach($result as $res){
                echo "<tr>";
                echo "<td>".$res['Naam']."</td>";
                echo "<td>".$res['Nummer']."</td>";
                echo "<td></td>";
                echo "</tr>";
            }

            ?>
            </tbody>
        </table>

    </div>
    <!-- .entry-content -->

    <?php //edit_post_link( __( 'Edit', 'twentyfifteen' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer><!-- .entry-footer -->' ); ?>

</article>
<!-- #post-## -->