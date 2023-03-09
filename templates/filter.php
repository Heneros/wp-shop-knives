<?php
get_header();

/**
 * 
 * Template Name: Filter Page
 * 
 */

?>


<?php
do_action('filters_tax_projects');

$taxonomies = array('project_areas', 'project_types');
$form = get_projects_filter_form($taxonomies);

$args = array(
    'post_type' => 'projects',
);
if (!empty($_GET['project_areas'])) {
    $selected_term = sanitize_text_field($_GET['project_areas']);
    if (!empty($selected_term)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'project_areas',
                'field'    => 'slug',
                'terms'    => $selected_term,
            ),
        );
    }
}









$query = new WP_Query($args);
if ($query->have_posts()) :
    while ($query->have_posts()) :
        $query->the_post();
        the_title();
    endwhile;
endif;
wp_reset_postdata();
?>

<?php
get_footer();
?>