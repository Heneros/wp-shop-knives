<?php
get_header();

/**
 * 
 * Template Name: Filter Page
 * 
 */

?>


<?php


$paged = (get_query_var('paged')) ? get_query_var('paged') : 0;
$postsPerPage = 5;
$postOffset = $paged * $postsPerPage;
$args = array(
    'post_type' => 'projects',
    'offset'            => $postOffset,
    'posts_per_page'    => $postsPerPage,
    // 'paged' => 
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
                $field_activities = '';

                if ($field_activities_tax) {
                    $field_activities = explode(',', $field_activities_tax);
                    foreach ($field_activities as &$area) {
                        $area = '<span class="tax">' . trim(strip_tags($area)) . '</span>';
                    }
                }

                $project_areas_tax = get_the_term_list($post->ID, 'project_areas', '', ', ');
                $project_areas =   strip_tags($project_areas_tax);
                $project_areas = '<span>' . $project_areas . '</span>';
        ?>

                <div class="cardd-item">
                    <div class="card-img" style="background-image: url(<?php echo $featured_img  ?>); ">
                        <div class="taxs">
                            <?php
                            echo implode(' ', $field_activities);
                            ?>
                        </div>
                    </div>
                    <div class="card-content">
                        <h1>
                            <a href="<?= $link ?>">
                                <?php the_title(); ?>
                            </a>
                        </h1>
                        <?php if ($project_areas_tax) : ?>
                            <div class="card-location">
                                <?php
                                echo $project_areas;
                                ?>
                            </div>
                        <?php
                        endif;
                        ?>
                    </div>
                </div>
            <?php
            endwhile;
            ?>
            <?php
            $next_page = $query->query_vars['paged'] + 1;
            $max_pages = $wp_query->max_num_pages;
            if ($next_page <= $max_pages) :
            ?>
                <div style="text-align: center;" class="best-works__botton-wrapper">
                    <button id="loadmore-btn" data-nextpage="<?php echo $next_page; ?>" data-maxpages="<?php echo $max_pages; ?>">
                        Load More
                    </button>
                </div>
        <?php endif;
        endif;
        wp_reset_postdata(); ?>
    </div>
    <?php
    ?>


</div>

<?php
get_footer();
?>