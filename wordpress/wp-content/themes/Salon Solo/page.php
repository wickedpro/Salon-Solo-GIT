a<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the wordpress construct of pages
 * and that other 'pages' on your wordpress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */

get_header(); ?>

<div id="centered">
		<div class="flexslider">
 			<ul class="slides">
   			 	<li><img src="../img/slide1.png"/></li>
    		 	<li><img src="../img/slide2.png"/></li>
    		 	<li><img src="../img/slide3.png"/></li>
  		 	</ul>
		</div>
	
		<h2>Welcome to Salon Solo</h2>
		
		<img src="img/contact_button.png" class="contactbutton"/>
		
		<div id="dividerline"></div>
	
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php if ( is_front_page() ) { ?>
					<h2 class="entry-title"><?php the_title(); ?></h2>
				<?php } else { ?>	
					<h1 class="entry-title"><?php the_title(); ?></h1>
				<?php } ?>
					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '' . __( 'Pages:', 'boilerplate' ), 'after' => '' ) ); ?>
						<?php edit_post_link( __( 'Edit', 'boilerplate' ), '', '' ); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-## -->

<?php endwhile; ?>
		
		<div class="boxleft">
			<h3>Services</h3>
			<p class="white">Salon solo is a full service salon offerning many great services. Please click below to see our work and the list of services. </p>
		</div>
		
		<div class="boxmid">
			<h3>Services</h3>
			
			<p class="white">Salon solo is a full service salon offerning many great services. Please click below to see our work and the list of services. </p>
		</div>
		
		<div class="boxright">
			<h3>Services</h3>
			
			<p class="white">Salon solo is a full service salon offerning many great services. Please click below to see our work and the list of services. </p>
		</div>
		
		<img src="../img/footer.png" class="footer"/>
	
	</div>
	
   </div><!--closed container -->
    
 
  </div> <!--! end of #container -->



<?php get_footer(); ?>