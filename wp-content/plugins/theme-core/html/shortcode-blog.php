<?php
/**
 * The default template for displaying content
 *
 * @author      Nanozum
 * @link        http://nanozum.co
 * @copyright   Copyright (c) 2015 Nanozum
 * @license     GPL v2
 */

$format = get_post_format();
$view_more = 'description-hidden';

if ($atts['view_more'] && $atts['view_more']=='yes'){
    $view_more = 'description-show';
}

//$args['paged'] = (nano_get_query_var('paged')) ? nano_get_query_var('paged') : 1;

$args = array(
    'post_type'           => 'post',
    'post_status'         => 'publish',
    'orderby'             => 'date',
    'order'               => 'DESC',
    'ignore_sticky_posts' => true,
    'category_name'       => $atts['category_name'],
    'posts_per_page'      =>($atts['number'] > 0) ? $atts['number'] : get_option('posts_per_page')
);
$args['paged'] = (nano_get_query_var('paged')) ? nano_get_query_var('paged') : 1;
$the_query = new WP_Query($args);
$num_pages = $the_query->max_num_pages;
//class for option columns
$class = '';
switch ($atts['columns']) {
    case '1':
        $class .= "col-xs-12 col-1";
        break;
    case '2':
        $class .= "col-xs-6 col-sm-6 col-md-6";
        break;
    case '3':
        $class .= "col-xs-6 col-sm-6 col-md-4";
        break;
}
$class_pagination='pagination';
if($atts['pagination']=='loadMore'){
    $class_pagination='loadMore';
}
if($atts['pagination']=='lazyLoading'){
    $class_pagination='infiniteScroll';
}
$i=1;
?>

<div class="<?php echo 'wrapper-posts type-'.esc_attr($class_pagination).' layout-' . esc_attr($atts['post_layout']); ?>" data-layout="<?php echo esc_attr($atts['post_layout']);?>" data-paged="<?php echo esc_attr($num_pages);?>" data-col="<?php echo esc_attr($class);?>" data-cat="<?php echo esc_attr($atts['category_name'])?>" data-number="<?php echo esc_attr($atts['number'])?>" data-ads="<?php echo esc_attr($atts['ads_layout']);?>">
    <div class="box-title clearfix">
        <?php if ($atts['title']) { ?>
            <h5 class="widgettitle title-box"><?php echo esc_html($atts['title']); ?></h5>
        <?php } ?>
        <?php if($atts['filter'] && $atts['type_filter']=='cat_filter' ){?>
            <ul class="wrapper-filter" data-filter="true">
                <?php
                $categories = explode( ',', $atts['category_name'] );

                foreach ($categories as $category){
                    $cat = get_term_by( 'slug',$category, 'category');
                    echo '<li><span class="cat-item"  data-catfilter="'.$category.'" >'.$cat->name.'</span></li>';
                }
                ?>
            </ul>
        <?php }?>
    </div>
    <span class="agr-loading"></span>
    <div class="tab-content">
        <div id="allCat" class="archive-blog affect-isotope row active <?php echo esc_attr($view_more);?>">
            <?php if($atts['post_layout'] == 'grid'){?>
                        <?php if ($the_query->have_posts()):
                            while ($the_query->have_posts()): $the_query->the_post(); ?>
                            <?php
                                if( $i == 1 && isset($atts['show_layout_first']) && !empty($atts['show_layout_first'])) {
                                ?>
                                    <div class=" col-md-12  layout-grid-full">
                                        <?php na_part_templates('layout/content-first');?>
                                    </div>
                                <?php }else{?>
                                <div class="col-item <?php echo esc_attr($class);?> ">
                                    <?php na_part_templates('layout/content-grid');?>
                                </div>

                                <?php if($i == $atts['number'] && $atts['ads_layout'] =='large-rectangle'){?>
                                    <div class="col-item ads-item <?php echo esc_attr($class);?>">
                                        <?php echo wp_kses_post(get_theme_mod('zum_ads_rectangle'));?>
                                    </div>
                                <?php }?>

                        <?php } $i++; endwhile;
                endif;
                wp_reset_postdata();
                ?>
            <?php }
            elseif($atts['post_layout'] == 'list'){?>
                <?php if ($the_query->have_posts()):
                    while ($the_query->have_posts()): $the_query->the_post(); ?>

                        <div class="col-item <?php echo esc_attr($class);?>">
                            <?php na_part_templates('layout/content-list');?>
                        </div>

                        <?php $i++; endwhile;
                endif;
                wp_reset_postdata();
                ?>
            <?php }
            elseif($atts['post_layout'] == 'tran'){?>
                        <?php if ($the_query->have_posts()):
                            while ($the_query->have_posts()): $the_query->the_post();

                                if( $i == 1 || ((($i-1)%5)==0) ) {?>
                                        <div class="col-md-12">
                                            <?php na_part_templates('layout/content-list');?>
                                        </div>
                                    <?php }
                                    else{?>
                                        <div class="col-item <?php echo esc_attr($class);?> ">
                                                <?php na_part_templates('layout/content-grid');?>
                                        </div>
                                    <?php }?>

                                    <?php if($i == $atts['number'] && $atts['ads_layout'] =='large-rectangle'){?>
                                        <div class="col-item ads-item <?php echo esc_attr($class);?>">
                                            <?php echo wp_kses_post(get_theme_mod('zum_ads_rectangle'));?>
                                        </div>
                                    <?php }?>

                                <?php $i++; endwhile;
                        endif;
                        wp_reset_postdata();
                        ?>
            <?php }
            else{
                if ($the_query->have_posts()):
                    while ($the_query->have_posts()): $the_query->the_post(); ?>

                        <div class="col-item <?php echo esc_attr($class);?>">
                            <?php na_part_templates('layout/content-list');?>
                        </div>

                        <?php $i++; endwhile;
                endif;
                wp_reset_postdata();
            }
            ?>
        </div>
    </div>

    <?php
    //paging
    if($atts['pagination']=='loadMore'){?>
        <span id="loadMore" class="button">
            <?php echo esc_html('... Load More ...','nano');?>
        </span>
    <?php }
    elseif($atts['pagination']=='lazyLoading'){  ?>
        <span id="nextPage" class="button">
        </span>
    <?php
    }
    else{
            nano_pagination(3, $the_query);
    }
    //end paging
    if($atts['filter'] && $atts['type_filter']=='cat_filter' ){?>
        <span id="loadMoreCat" class="button hidden">
            <?php echo esc_html('... Load More ...','nano');?>
        </span>
    <?php }

    ?>
</div>