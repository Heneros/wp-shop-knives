<?php
get_header();

/**
 * 
 * Template Name: Filter Page
 * 
 */

?>

<?php
echo do_shortcode('[shortcode_posts posts_per_page="10" post_type="news"]');
?>
<?php
get_footer();
?>