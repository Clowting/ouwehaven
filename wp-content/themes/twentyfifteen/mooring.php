<?php
/** 
 * Template Name: Show the Moorings!
 * The template for displaying moorings in the "d'n Ouwe Haven" website
 */

get_header(); ?>

<div class="clear"></div>

</header>

<div class="content" class="site-content">
	<div class="container">
	
	 <div class="content-left-wrap col-md-9">

		<div id="primary" class="content-area">
		
			<main id="main" class="site-main" role="main">
			
				<?php
				// Start the standard wordpress loop.
				while ( have_posts() ) : the_post();
		
					// Include the page content template.
					get_template_part( 'content', 'mooring' );
					
				// End the loop.
				endwhile;
				?>
				
			</main><!-- .site-main -->
		</div><!-- primary div/content area -->
	</div>
	<div class="sidebar-wrap col-md-3 content-left-wrap">
    	<?php get_sidebar(); ?>
  	</div>
	</div> <!-- end container -->
</div><!-- .content-area -->

<?php get_footer(); ?>
