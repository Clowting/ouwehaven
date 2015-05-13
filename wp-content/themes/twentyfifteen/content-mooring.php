<?php
global $wpdb;
/**
 * The template used for displaying page content
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
    </header>
    <!-- .entry-header -->

    <div class="entry-content">
        <?php

        the_content();

        ?>
        <select id="harbors" name="harbors">

            <?php

            $entries = $wpdb->get_results("SELECT DISTINCT ID, Naam FROM oh_harbors", ARRAY_A);
            var_dump($entries);
            foreach ($entries as $e) {
                echo "<option value= '{$e['ID']}'  >" . $e ['Naam'] . "</option>";
            }
            ?>
        </select>

        <table>
            <?php
            if ($_POST ['ID']) {
                $id = $_POST ['ID'];
                $result = $wpdb->get_results("SELECT * FROM oh_moorings WHERE Haven_ID == $id");
                var_dump($result);
                if ($result != null) {
                    ?>
                    <thead>
                    <th>Nummer</th>
                    <th>Prijs per meter?</th>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($result as $res) {
                        echo "<tr>";
                        echo "<td>" . $res ['Nummer'] . "<td>";
                        echo "<td></td>";
                        echo "<tr>";
                    }
                }
            }
            ?>
            </tbody>
        </table>

    </div>
    <!-- .entry-content -->

    <?php //edit_post_link( __( 'Edit', 'twentyfifteen' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer><!-- .entry-footer -->' ); ?>

</article>
<!-- #post-## -->