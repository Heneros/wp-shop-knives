<?php

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Make_me_up
 */

get_header();
?>

<!-- MAIN start  -->
<main class="main">


	<!-- CONTENT start  -->
	<div class="content">
	
		<div class="container">
		<?php woocommerce_breadcrumb(); ?>
			<?php the_content(); ?>
		</div>
	</div>
</main><!-- #main -->

<?php
get_footer();
