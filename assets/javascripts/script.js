jQuery( document ).ready(function( $ ){

    var quick_gallery_gallery = {

        data: {
            caption: $('.gallery .gallery-item img').first().attr('alt'),
            initial_item: $('.gallery .gallery-item img').first(),
            initial_item_href: $('.gallery .gallery-item a:first-child').attr('href'),
            initial_item_full_url: $('.gallery .gallery-item a:first-child').attr('data-quick_gallery_attachment_url_full')
        },

        /**
         * Set-up
         *
         * Add an element to attach our medium sized item to
         */
        init: function(){

            $('.gallery').prepend('<div id="qg-main-image"/>');

            quick_gallery_gallery.set_initial_item();
            quick_gallery_gallery.set_caption();

        },

        /**
         * Add gallery caption
         *
         * Add our initial caption
         */
        set_caption: function(){
            $('#qg-image-target').append( '<div class="wp-caption-text gallery-caption">' + quick_gallery_gallery.data.caption + '</div>' );
        },

        /**
         * Build the first "medium" sized image
         *
         * Assign our first gallery link
         * Add the current class to the first gallery-item element
         * Add our first image to the qg-main-image area
         * var first_item = $('.gallery .gallery-item a:first-child');
         */
        set_initial_item: function(){

            var $initial = quick_gallery_gallery.data.initial_item,
                initial_item_src = quick_gallery_gallery.data.initial_item_href;

            if ( typeof initial_item_src == "undefined" ){

                var initial_item_src = quick_gallery_gallery.get_url( $initial.attr('src') ),
                    href = initial_item_src;

            } else {

                href = quick_gallery_gallery.data.initial_item_full_url;

            }

            $( quick_gallery_gallery.data.initial_item ).closest('.gallery-item:first').addClass('current');

            $('<div id="qg-image-target" class="gallery-item"><a href="' + href + '"><img src="' + initial_item_src + '"/></a></div>').appendTo('#qg-main-image');
        },

        get_url: function( url ){

            var extension = url.split('-').pop().split(".").pop(),
                url_array = url.split('-');

            url_array.pop();

            var url = url_array.join('-'),
                full_url = url + "." + extension,
                src = full_url;

            return full_url;

        },

        /**
         * Handle switching the larger/medium sized image with the url provided via the
         * thumbnail image.
         */
        switch_item: function( my_obj ){


            var full_url = $( 'a', my_obj ).attr('data-quick_gallery_attachment_url_full');
            if ( typeof full_url === "undefined" ){

                full_url = quick_gallery_gallery.get_url( $('img', my_obj ).attr('src' ) );
                src = full_url;

            } else {

                var src = $( 'a', my_obj ).attr('href');

            }

            $('#qg-image-target a').replaceWith('<a href="'+full_url+'"><img src="'+src+'" /></a>');

            var caption = $('img', my_obj).attr('alt');

            $('#qg-image-target .gallery-caption').html( caption );
            $('.gallery .gallery-item').removeClass('current');

            $( my_obj ).toggleClass('current');
        }
    };

    if ( $('.gallery').length ){


        quick_gallery_gallery.init();


        $( document ).on('hover', '.gallery .gallery-item:not(#qg-image-target)', function( e ){
            e.preventDefault();
            quick_gallery_gallery.switch_item( $(this) );
        });
    }

});