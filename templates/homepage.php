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

///Bestsellers products
get_template_part('template-parts/best-sellers');

///Novelty
get_template_part('template-parts/novelty');

///Promotions
get_template_part('template-parts/promotions');

///Promotions Second
get_template_part('template-parts/promotions-second');

///Novelty Second
get_template_part('template-parts/novelty-second');

///Promotions Thord
get_template_part('template-parts/promotions-third');

///Promotions Four
get_template_part('template-parts/promotions-four');
?>

<?php get_footer(); ?>