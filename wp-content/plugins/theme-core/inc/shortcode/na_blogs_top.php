<?php
if (!function_exists('nano_shortcode_top_blog')) {
    function nano_shortcode_top_blog($atts)
    {
        $atts = shortcode_atts(array(
            'title'         => '',
            'layout_types'   => 'box',
            'type_post'     => 'news',
            'category_name' => '',
            'number_post'   => 8,
//            'style_content' =>'style_bottom',
            'el_class'      => ''
        ), $atts);
        ob_start();
        nano_template_part('shortcode', 'blog-top', array('atts' => $atts));
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}
add_shortcode('top_blog', 'nano_shortcode_top_blog');

add_action('vc_before_init', 'nano_top_blog_integrate_vc');

if (!function_exists('nano_top_blog_integrate_vc')) {
    function nano_top_blog_integrate_vc()
    {
        vc_map(array(
            'name' => __('NA Slider', 'nano'),
            'base' => 'top_blog',
            'category' => __('NA', 'nano'),
            'icon' => 'nano-top-blog',
            "params" => array(
                array(
                    "type" => "textfield",
                    "heading" => __("Title", 'nano'),
                    "param_name" => "title",
                    "admin_label" => true
                ),
                array(
                    'type' => 'nano_image_radio',
                    'heading' => esc_html__('Layout type', 'nano'),
                    'value' => array(
                        esc_html__(NANO_PLUGIN_URL.'assets/images/top-blog/col4.png', 'nano')           => 'column4',
                        esc_html__(NANO_PLUGIN_URL.'assets/images/top-blog/col.png', 'nano')             => 'col-center',
                        esc_html__(NANO_PLUGIN_URL.'assets/images/top-blog/col2-3box.png', 'nano') => 'column2-3box',
                    ),
                    'width' => '100px',
                    'height' => '70px',
                    'param_name' => 'layout_types',
                    'std' => 'box',
                    'description' => esc_html__('Select layout type for display post', 'nano'),
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Type Post", 'nano'),
                    "param_name" => "type_post",
                    "value" => array(
                        esc_html__('News', 'nano' )         => 'news',
                        esc_html__('Featured', 'nano' )     => 'featured',
                    ),
                    'std' => 'news',
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
                    "type" => "textfield",
                    "heading" => __("Posts Count", 'nano'),
                    "param_name" => "number_post",
                    "value" => '8'
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
