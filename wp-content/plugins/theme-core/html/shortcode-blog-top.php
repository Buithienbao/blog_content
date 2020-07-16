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
$add_class='';
$args = array(
    'category_name'  => $atts['category_name'],
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => $atts['number_post'],

);
if( $atts['type_post'] == 'featured' ){
    $meta_query[] = array(
        'key' => '_featured',
        'value' => 'yes'
    );
    $args['meta_query'] = $meta_query;
}

$the_query = new WP_Query($args);
$count = $the_query->found_posts;

?>
<?php if ($atts['title']) { ?>
    <h5 class="widgettitle title-vertical"><?php echo esc_html($atts['title']); ?></h5>
<?php } ?>
<?php
switch ($atts['layout_types']) {
    case 'column4':?>
        <div class="article-carousel post-vertical"   data-number="4" data-table="3" data-mobile = "2" data-mobilemin = "1" data-dots="false" data-arrows="true">
            <?php $k=1;
            while ( $the_query->have_posts() ) {
                $the_query->the_post(); ?>
                <div class="description-hidden archive-blog padding-balance  clearfix">
                    <?php na_part_templates('layout/slider','vertical', array('atts' => $atts));?>
                </div>
            <?php } ?>
            <?php wp_reset_postdata();?>
        </div>
        <?php break;
    case 'col-center':?>
        <div class="slider-blog  <?php echo 'blog-' . esc_attr($atts['layout_types']) . '-layout' ?>">
            <?php if ($atts['title']) { ?>
                <h5 class="widgettitle"><?php echo esc_html($atts['title']); ?></h5>
            <?php } ?>
            <div class="archive-blog row article-carousel-center <?php echo esc_attr($atts['style_content']); ?>" data-rtl="<?php echo esc_attr($add_rtl);?>" data-number="1" data-mobile = "1" data-mobilemin = "1" data-table="1" data-dots="false" data-arrows="false">
                <?php if ($the_query->have_posts()):
                    while ($the_query->have_posts()): $the_query->the_post(); ?>
                        <?php na_part_templates('layout/slider','box');?>
                    <?php endwhile;
                endif;
                wp_reset_postdata();?>
            </div>
        </div>
        <?php break;
    case 'box':?>
        <div class="<?php echo 'slider-blog blog-' . esc_attr($atts['layout_types']) . '-layout' ?>">
            <div class="archive-blog  row article-carousel slider-full" data-number="1" data-mobile = "1" data-mobilemin = "1" data-dots="true" data-arrows="false">
                <?php if ($the_query->have_posts()):
                    while ($the_query->have_posts()): $the_query->the_post(); ?>
                        <?php na_part_templates('layout/slider','box', array('atts' => $atts));?>
                    <?php endwhile;
                endif;
                wp_reset_postdata();?>
            </div>

        </div>
        <?php break;

    case 'column2-3box':?>
        <div class="article-carousel col-2-3box " data-number="1" data-table="1" data-mobile = "1" data-mobilemin = "1" data-dots="false" data-arrows="false">
            <?php $k=1;
            while ( $the_query->have_posts() ) {
                $the_query->the_post(); ?>
                <?php if ($k == 1 || (($k - 1) % 3) == 0) { ?>
                    <div class="row">
                        <div class="description-hidden padding-balance clearfix">
                            <?php //col large ?>
                            <div class="col-md-8 col-sm-12 description-show balance-padding-right box-large">
                                <?php na_part_templates('layout/slider','box', array('atts' => $atts));?>
                            </div>
                            <?php if ($k ==$atts['number_post']|| $k ==$count ) { ?>
                        </div>
                    </div>
                    <?php }?>
                <?php }
                else{ ?>
                    <div class="col-md-4 col-sm-6 col-xs-6 box-small balance-padding-left">
                        <?php na_part_templates('layout/slider','box', array('atts' => $atts));?>
                    </div>
                    <?php if (($k % 3) == 0 || $k ==$count ||$k ==$atts['number_post']) { ?>
                            </div>
                        </div>
                    <?php }?>
                <?php }?>

                <?php $k++;
            }
            wp_reset_postdata();?>
        </div>
    <?php break;
    case 'col8-4box': ?>
        <div class="slider-blog col8-4box " data-number="1" data-table="1" data-mobile = "1" data-mobilemin = "1" data-dots="false" data-arrows="false">
            <div class="row">
                <?php $k=1;
                while ( $the_query->have_posts() ) {
                    $the_query->the_post(); ?>
                    <?php if ((($k % 4)== 0) || ((($k+3)%4) == 0)) { ?>
                        <div class="col-md-8 col-sm-8  box-small">
                            <?php na_part_templates('layout/slider','box', array('atts' => $atts));?>
                        </div>
                    <?php } else{ ?>
                        <div class="col-md-4 col-sm-4  box-large ">
                            <?php na_part_templates('layout/slider','box', array('atts' => $atts));?>
                        </div>
                    <?php }?>
                    <?php $k++;
                }
                wp_reset_postdata();?>
            </div>
        </div>
    <?php break;
    default: ?>
        <div class="<?php echo 'slider-blog blog-' . esc_attr($atts['layout_types']) . '-layout' ?>">
            <div class="archive-blog  article-carousel slider-full " data-number="1" data-mobile = "1" data-mobilemin = "1" data-dots="true" data-arrows="false">
                <?php if ($the_query->have_posts()):
                    while ($the_query->have_posts()): $the_query->the_post(); ?>
                        <?php na_part_templates('layout/slider','box', array('atts' => $atts));?>
                    <?php endwhile;
                endif;
                wp_reset_postdata();?>
            </div>

        </div>
        <?php break;
}
?>



