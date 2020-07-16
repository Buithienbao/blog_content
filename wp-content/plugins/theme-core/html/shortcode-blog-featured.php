<?php
/**
 * The default template for displaying content
 *
 * @author      Nanoliberty
 * @link        http://nanoliberty.co
 * @copyright   Copyright (c) 2015 Nanoliberty
 * @license     GPL v2
 */

$format = get_post_format();
$add_class= $class ='';
$args = array(
    'category_name'  => $atts['category_name'],
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => $atts['number_post'],
    'meta_key'       => 'post_views_count',
    'orderby'       =>'meta_value_num',
    'order'         =>'DESC',
);
//check post type
if( $atts['type_post'] == 'featured' ){
    $meta_query[] = array(
        'key'   => '_featured',
        'value' => 'yes'
    );
    $args['meta_query'] = $meta_query;
}

//check layout section
$layout_section='article-carousel';
if( $atts['layout_section'] == 'layout_grid' ){
    $layout_section='article-grid';
}

//check column
$the_query = new WP_Query($args);
switch ($atts['show_post']) {
    case '1':
        $class .= "col-xs-12";
        break;
    case '2':
        $class .= "col-xs-12 col-sm-6 col-md-6";
        break;
    case '3':
        $class .= "col-xs-12 col-sm-6 col-md-4";
        break;
    case '4':
        $class .= "col-xs-12 col-sm-6 col-md-3";
        break;
    default:
        $class .= "col-xs-12 col-sm-6 col-md-4";
        break;
}
?>
<?php if ($atts['title']) { ?>
    <h5 class="widgettitle title-vertical"><?php echo esc_html($atts['title']); ?></h5>
<?php } ?>

<div class="posts-featured <?php echo esc_attr($layout_section); ?>" data-number="<?php echo esc_attr($atts['show_post']);?>"  data-dots="false" data-table="2" data-mobile = "2" data-mobilemin = "1" data-arrows="false">
    <?php   while ( $the_query->have_posts() ) {
        $the_query->the_post(); ?>
        <div class="description-hidden archive-blog clearfix <?php echo esc_attr($class);?>">
            <?php
                //check layout post
                if( $atts['layout_post'] == 'grid' ){
                    na_part_templates('layout/content-grid');
                }
                else{
                    na_part_templates('layout/content-tran');
                }
            ?>
        </div>
    <?php } ?>
    <?php wp_reset_postdata();?>
</div>



