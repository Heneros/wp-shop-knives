<?php
get_header();

/**
 * 
 * Template Name: Filter Page
 * 
 */

?>


<?php


$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$postsPerPage = 6;
$postOffset = ($paged - 1) * $postsPerPage;
$args = array(
    'post_type' => 'projects',
    'offset'            => $postOffset,
    'posts_per_page'    => $postsPerPage,
);
?>
<div class="container">
    <div class="filters-project">
        <?php
        do_action('filters_tax_projects');
        ?>
    </div>
    <?php
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
        endif;
        wp_reset_postdata();
        ?>
    </div>
    <?php
    $next_page = $paged + 1;
    $max_pages = $query->max_num_pages;


    $count_posts = wp_count_posts('projects');
    $total_posts = $count_posts->publish;


    if ($next_page <= $max_pages) { ?>
        <div class="loadmore">
            <a id="loadmore-btn" class="load_more" data-nextpage="<?php echo $next_page; ?>" data-maxpages="<?php echo $max_pages; ?>">
                הצג עוד 6 מתוך <?= $total_posts ?>
            </a>
        </div>
    <?php  } else { ?>
        <style>
            .loadmore {
                display: none !important;
            }
        </style>
    <?php  }   ?>
    <script>
        var offset = 0;
        var posts_per_page = 6;
        var next_page = 2;
        var post_type = 'projects';
        jQuery(function($) {
            $('#loadmore-btn').click(function() {
                var button = $(this);
                var next_page = button.data('nextpage');
                var max_pages = button.data('maxpages');
                $.ajax({
                    url: my_ajax_object.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'loadmore',
                        offset: offset + posts_per_page,
                        posts_per_page: posts_per_page,
                        next_page: next_page,
                        post_type: post_type
                    },
                    beforeSend: function() {
                        $('#loadmore-btn').text('Loading...');
                    },
                    success: function(data) {
                        $('#loadmore-btn').text('Load More');
                        $('.items-project').append(data);
                        offset += posts_per_page;
                        next_page++;
                        if (next_page + 1 > max_pages) {
                            button.hide();
                        }
                    }
                });
            });
        });
    </script>
</div>
<?php
get_footer();
?>