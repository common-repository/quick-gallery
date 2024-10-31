<?php

/**
 * Assign our settings, defaults, and values.
 *
 * @since 1.0.0
 *
 * @return An array of settings
 */
function quick_gallery_base_settings(){

    $all_post_types = get_post_types( array('public'=>true ) );

    foreach( $all_post_types as $post_type ){
        $obj = get_post_type_object( $post_type );
        $formatted_post_types[ $post_type ] =  $obj->labels->singular_name;
    }


    /**
     * For a full list see "Supported Field Types"
     */
    $settings = array(
        'quick_gallery' => array(
            'title' => __( '', QUICK_GALLERY_TEXTDOMAIN ),
            'fields' => array(
                array(
                    'id' => 'quick_gallery_header',
                    'title' => __( 'General', QUICK_GALLERY_TEXTDOMAIN ),
                    'type' => 'header'
                    ),
                array(
                    'id' => 'quick_gallery_usage',
                    'title' => __( 'Usage', QUICK_GALLERY_TEXTDOMAIN ),
                    'type' => 'desc',
                    'desc' => __( 'Quick Gallery is designed to work with your native Gallery settings. Enable it below, assign which post types use it, and set the number of columns via your Gallery settings when editing a post type.', QUICK_GALLERY_TEXTDOMAIN )
                    ),
                array(
                    'id' => 'quick_gallery_enabled',
                    'title' => __( 'Enable', QUICK_GALLERY_TEXTDOMAIN ),
                    'type' => 'radio',
                    'std' => 'no',
                    'options' => array(
                        'no' => 'No',
                        'yes' => 'Yes'
                        )
                    ),
                array(
                    'id' => 'quick_gallery_cpt',
                    'title' => __( 'Post Types', QUICK_GALLERY_TEXTDOMAIN ),
                    'type' => 'checkboxes',
                    'desc' => __( 'Select the Post Types to use Quick Gallery on.', QUICK_GALLERY_TEXTDOMAIN ),
                    'options' => $formatted_post_types
                    ),
                array(
                    'id' => 'quick_gallery_max_height',
                    'title' => __( 'Gallery Max Height', QUICK_GALLERY_TEXTDOMAIN ),
                    'type' => 'number',
                    'std' => get_option( 'medium_size_h' ),
                    'max' => '2000',
                    'desc' => __( 'The number in pixels that should be used for the max height of the gallery container. Initial value is determined by your medium height media settings.', QUICK_GALLERY_TEXTDOMAIN )
                    ),
                array(
                    'id' => 'quick_gallery_min_height',
                    'title' => __( 'Gallery Min Height', QUICK_GALLERY_TEXTDOMAIN ),
                    'type' => 'number',
                    'std' => get_option( 'medium_size_h' ),
                    'max' => '2000',
                    'desc' => __( 'The number in pixels that should be used for the min height of the gallery container. Initial value is determined by your medium height media settings.', QUICK_GALLERY_TEXTDOMAIN )
                    )
            )
        )
    );

    return $settings;

}


/**
 * Set the page title for this instance of Quilt
 *
 * @since 1.0.0
 */
function quick_gallery_settings_page_title( $title, $namespace ){

    return __( 'Quick Gallery Settings', QUICK_GALLERY_TEXTDOMAIN );

}
add_filter( 'quilt_quick_gallery_page_title', 'quick_gallery_settings_page_title', 15, 2 );


function quick_gallery_settings_footer_content( $content ){

    return __( 'Thank you for using Quick Gallery', QUICK_GALLERY_NAMESPACE );

}
add_filter( 'quilt_quick_gallery_footer', 'quick_gallery_settings_footer_content', 15, 2 );