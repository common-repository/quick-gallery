<?php

Class QuickGallery {

    public $settings;


    public function __construct(){

        global $quick_gallery_settings;
        $this->settings = $quick_gallery_settings;

        add_action( 'wp_head', array( &$this, 'setGalleryHeight' ) );

        if ( $this->settings['quick_gallery_enabled'] == 'no' )
            return;

        add_action( 'wp_enqueue_scripts', array( &$this, 'enqueueScripts' ) );
        // add_filter( 'use_default_gallery_style', '__return_false' );
        add_filter( 'wp_get_attachment_link', array( &$this, 'galleryItemLink' ), 10, 6 );
        add_filter( 'template_include', array( &$this, 'removePostGalleryStyle' ) );

    }


    public function enqueueScripts(){

        global $post;

        if ( ! empty( $post ) && in_array( $post->post_type, $this->settings['quick_gallery_cpt'] )
            && is_singular( $post->post_type ) ){

            wp_enqueue_script( 'quick-gallery-script', QUICK_GALLERY_URL . 'assets/javascripts/script.js', array('jquery'), QUICK_GALLERY_VERSION );
            wp_enqueue_style( 'quick-gallery-style', QUICK_GALLERY_URL . 'assets/stylesheets/style.css', '', QUICK_GALLERY_VERSION );

        }

    }


    public function galleryItemLink( $link_text, $id, $size, $permalink, $icon, $text ){

        global $post;

        if ( in_array( $post->post_type, $this->settings['quick_gallery_cpt'] )
            && $this->settings['quick_gallery_enabled'] == 'yes' ){

            list( $url, $width, $height ) = wp_get_attachment_image_src( $id, 'large' );
            list( $full_url, $full_width, $full_height ) = wp_get_attachment_image_src( $id, 'full' );

            $link_text = '<a href="'.$url.'" data-quick_gallery_attachment_url_full="'.$full_url.'">'.wp_get_attachment_image( $id, $size ) . '</a>';
        }

        return $link_text;

    }


    public function removePostGalleryStyle( $template ){

        if ( is_singular( $this->settings['quick_gallery_cpt'] )
            && $this->settings['quick_gallery_enabled'] == 'yes' ){

            remove_all_filters( 'post_gallery' );

        }

        return $template;

    }


    public function setGalleryHeight(){

        global $settings;

        if ( $this->settings['quick_gallery_enabled'] == 'no' )
            return;

        ?>
        <!--  Quick Gallery: Gallery height -->
        <style type="text/css">
        #qg-main-image {
            min-height: <?php echo absint( $this->settings['quick_gallery_max_height'] ); ?>px;
            min-height: <?php echo absint( $this->settings['quick_gallery_min_height'] ); ?>px;
            }
        </style>
        <!--  Quick Gallery: Gallery height -->
        <?php
    }

}