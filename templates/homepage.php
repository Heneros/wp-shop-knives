<?php

/**
 * 
 * Template Name: HomePage
 * 
 * */
get_header();

?>


<?php

///Slider Homepage and icons
get_template_part('template-parts/homepage-slider');

///Slider Homepage and icons
get_template_part('template-parts/homepage-main-description');

///Cards category
get_template_part('template-parts/cards');

///Bestsellers
get_template_part('template-parts/bestsellers');

?>

<?php get_footer(); ?>