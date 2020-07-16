<?php
if (!function_exists('nano_shortcode_blog_featured')) {
    function nano_shortcode_blog_featured($atts)
    {
        $atts = shortcode_atts(array(
            'title'             => '',
            'type_post'         => 'no',
            'category_name'     => '',
            'layout_section'    => 'layout_carouse',
            'layout_post'       => 'tran',
            'number_post'       => 8,
            'show_post'         => 3,
            'el_class'          => ''
        ), $atts);
        ob_start();
        nano_template_part('shortcode', 'blog-featured', array('atts' => $atts));
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}
add_shortcode('blog_featured', 'nano_shortcode_blog_featured');

add_action('vc_before_init', 'nano_blog_featured_integrate_vc');

if (!function_exists('nano_blog_featured_integrate_vc')) {
    function nano_blog_featured_integrate_vc()
    {
        vc_map(array(
            'name' => __('NA Featured Posts', 'nano'),
            'base' => 'blog_featured',
            'category' => __('NA', 'nano'),
            'icon' => 'nano-blog-featured',
            "params" => array(
                array(
                    "type" => "textfield",
                    "heading" => __("Title", 'nano'),
                    "param_name" => "title",
                    "admin_label" => true
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Type Post", 'nano'),
                    "param_name" => "type_post",
                    "value" => array(
                        esc_html__('Most Views', 'nano' )   => 'views',
                        esc_html__('Featured', 'nano' )     => 'featured',
                    ),
                    'std' => 'views',
                    "description" => esc_html__("The criteria you want to show",'nano')
                ),
                array(
                    "type" => "nano_post_categories",
                    "heading" => __("Category IDs", 'nano'),
                    "description" => __("Select category", 'nano'),
                    "param_name" => "category_name",
                    "admin_label" => true
                ),
                array(
                    'type' => 'nano_image_radio',
                    'heading' => esc_html__('Layout section the post', 'nano'),
                    'value' => array(
                        esc_html__(NANO_PLUGIN_URL.'assets/images/col.png', 'nano')     => 'layout_carouse',
                        esc_html__(NANO_PLUGIN_URL.'assets/images/largel.jpg', 'nano')  => 'layout_grid',
                    ),
                    'width' => '100px',
                    'height' => '70px',
                    'param_name' => 'layout_section',
                    'std' => 'layout_carouse',
                ),
                array(
                    "type" => "textfield",
                    "heading" => __("Posts Count", 'nano'),
                    "param_name" => "number_post",
                    "value" => '8'
                ),
                array(
                    "type" => "textfield",
                    "heading" => __("Posts show in a row", 'nano'),
                    "param_name" => "show_post",
                    "value" => '3'
                ),
                array(
                    'type' => 'nano_image_radio',
                    'heading' => esc_html__('Layout a post', 'nano'),
                    'value' => array(
                        esc_html__(NANO_PLUGIN_URL.'assets/images/box-tran.jpg', 'nano') => 'tran',
                        esc_html__(NANO_PLUGIN_URL.'assets/images/box-grid.jpg', 'nano') => 'grid',
                    ),
                    'width' => '100px',
                    'height' => '70px',
                    'param_name' => 'layout_post',
                    'std' => 'tran',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __( 'Extra class name', 'nano' ),
                    'param_name' => 'el_class',
                    'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'nano' )
                )
            )
        ));
    }
}
