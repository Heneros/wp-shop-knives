<?php
get_header();

/**
 * 
 * Template Name: Filter Page
 * 
 */

?>


<?php





$args = array(
    'post_type' => 'projects',
    'posts_per_page' => 5,
);
?>
<div class="container">
    <?php


    do_action('filters_tax_projects');
    if (!empty($_GET['project_areas']) || !empty($_GET['field_activities'])) {
        $tax_query = array('relation' => 'AND');

        if (!empty($_GET['project_areas'])) {
            $selected_terms = is_array($_GET['project_areas']) ? $_GET['project_areas'] : array($_GET['project_areas']);
            $tax_query[] = array(
                'taxonomy' => 'project_areas',
                'field' => 'slug',
                'terms' => $selected_terms,
            );
        }

        if (!empty($_GET['field_activities'])) {
            $selected_terms = is_array($_GET['field_activities']) ? $_GET['field_activities'] : array($_GET['field_activities']);
            $tax_query[] = array(
                'taxonomy' => 'field_activities',
                'field' => 'slug',
                'terms' => $selected_terms,
            );
        }

        $args['tax_query'] = $tax_query;
    }

    ?>

    <div class="items-project">
        <?php
        $query = new WP_Query($args);
        if ($query->have_posts()) :
            while ($query->have_posts()) :
                $query->the_post();
                global $post;
                $featured_img = wp_get_attachment_url(get_post_thumbnail_id());
                $link = get_permalink();
                $field_activities_tax = get_the_term_list($post->ID, 'field_activities', '', ', ');
                $fields_active =   strip_tags($field_activities_tax);
                $fields_active = '<span>' . $fields_active . '</span>';


                $project_areas_tax = get_the_term_list($post->ID, 'project_areas', '', ', ');
                ///  get_the_term_list( $post->ID, 'project_areas', ' ', ', ' ); 
        ?>

                <div class="cardd-item">
                    <div class="card-img" style="background-image: url(<?php echo $featured_img  ?>); ">
                        <span class=""></span>
                    </div>
                    <div class="card-content">
                        <h1>
                            <a href="<?= $link ?>">
                                <?php the_title(); ?>
                            </a>
                        </h1>
                        <div class="card-bottom">
                            <?php
                            echo $fields_active
                            ?>
                        </div>
                    </div>
                </div>

        <?php
            endwhile;
        endif;
        wp_reset_postdata();
        ?>
    </div>
</div>

<?php
get_footer();
?>