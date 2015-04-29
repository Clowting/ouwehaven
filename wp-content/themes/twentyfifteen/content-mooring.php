<?php
global $wpdb;
/**
 * The template used for displaying page content
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); 
		
		
		?>
		
		                    <table class="table table-striped table-hover" id="tbl">

                            <thead>
                            <tr>
                                <th>Beschrijving</th>
                                <th width="10%">Bedrag</th>
                                <th width="10%">Datum</th>
                                <th>Van</th>
                                <th>Voor</th>
                                <th>   </th>
                            </tr>
                            </thead>
                            
                            <tbody>
                            
                            <?php

                            $entries = $wpdb->get_results("SELECT * FROM oh_cashbook", ARRAY_A);
                            foreach($entries as $e) {
                            	
                            	
                            	$date = DateTime::createFromFormat('Y-m-d', $e['Datum']);
                            	
                            	
                                echo '<tr>';
                                echo '<td>' . $e["Beschrijving"] . '</td>';
                                echo '<td> &euro;' . $e['Bedrag'] . '</td>';
                                echo '<td>' . $date->format('d/m/Y') .'</td>';
                                echo '<td>'.$e['Afzender'].'</td>';
                                echo '<td>'.$e['Ontvanger'].'</td>';
                                
                                echo '</tr>';
                            }

                            ?>

                            </tbody>
                	</table>

	</div><!-- .entry-content -->

	<?php //edit_post_link( __( 'Edit', 'twentyfifteen' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer><!-- .entry-footer -->' ); ?>

</article><!-- #post-## -->
