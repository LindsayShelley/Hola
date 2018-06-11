<?php
//  = Default Theme Customizer Settings  =
function shopline_customize_register( $wp_customize ) {
//  Genral Settings 
$wp_customize->get_section('title_tagline')->title = esc_html__('General Settings', 'shopline');
$wp_customize->get_section('title_tagline')->priority = 3;


$wp_customize->add_panel( 'settings_theme_options', array(
        'priority'       => 4,
        'title'          => __('Appearance Settings', 'shopline'),
    ) );
// global section
$wp_customize->add_section('global_set', array(
        'title'    => __('Global Setting', 'shopline'),
        'priority' => 1,
        'panel'  => 'settings_theme_options',
));
$wp_customize->add_setting( 'shopline_layout',
    array(
              'sanitize_callback' => 'sanitize_text_field',
              'default'           => 'right',
              )
         );
$wp_customize->add_control( 'shopline_layout',
        array(
        'type'        => 'select',
        'label'       => esc_html__('Page Layout', 'shopline'),
        'description'       => esc_html__('Choose sidebar option for inner pages (non-home)', 'shopline'),
        'section'     => 'global_set',
        'choices' => array(
        'right' => esc_html__('Right sidebar', 'shopline'),
        'left' => esc_html__('Left sidebar', 'shopline'),
        'no-sidebar' => esc_html__('No sidebar', 'shopline'),
                    )
                )
            );

// Disable back to top button
    $wp_customize->add_setting( 'shopline_backtotop_disable',
        array(
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control( 'shopline_backtotop_disable',
        array(
            'type'        => 'checkbox',
            'label'       => esc_html__('Hide back to top button ?', 'shopline'),
            'section'     => 'global_set',
            'description' => esc_html__('Check here to disable Back To Top button.', 'shopline')
        )
    );
     $wp_customize->get_section('colors')->title = esc_html__('Theme Color', 'shopline');
    $wp_customize->get_section('colors')->priority = 59;
    $wp_customize->get_section('colors')->panel = 'settings_theme_options';

$wp_customize->add_section('footer_setting', array(
        'title'    => __('Footer Setting', 'shopline'),
        'priority' => 8,
    ));

    $wp_customize->add_setting('copyright_text', array(
            'default'           => '',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field'
            ));
       $wp_customize->add_control('copyright_text', array(
            'label'    => __('Copyright Text', 'shopline'),
            'section'  => 'footer_setting',
            'settings' => 'copyright_text',
             'type'       => 'text',
            )); 

}
add_action('customize_register','shopline_customize_register');
?>