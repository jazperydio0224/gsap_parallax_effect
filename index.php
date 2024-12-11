<?php

function wedding_slider_shortcode_desktop($atts)
{
    // Parse shortcode attributes.
    $atts = shortcode_atts([
        'count' => '', // Default is empty, meaning "show all".
    ], $atts, 'wedding_slider');


    $count = ($atts['count'] !== '') ? intval($atts['count']) : -1;

    $args = [
        'post_type' => 'wedding',
        'posts_per_page' => $count,
        'orderby' => 'date',
        'order' => 'ASC'
    ];

    $query = new WP_Query($args);

    if (!$query->have_posts()) {
        return '<p>No weddings found.</p>';
    }

    ob_start();

    $nonce = wp_create_nonce('wedding_slider_nonce');
    echo '<div class="wedding-swiper-desktop" data-nonce="' . esc_attr($nonce) . '">';
    echo '<div class="swiper-wrapper">';

    $posts = [];

    while ($query->have_posts()) {
        $query->the_post();

        $wedding_id = get_the_ID();
        $wedding_title = get_the_title();

        $wedding_thumbnail_id = get_post_meta($wedding_id, 'thumbnail', true);
        $wedding_thumbnail_url = wp_get_attachment_url($wedding_thumbnail_id);
        $wedding_date_raw = get_post_meta($wedding_id, 'wedding_date', true);

        $wedding_fb_link = get_post_meta($wedding_id, 'facebook_link', true);
        $wedding_image_ids = get_post_meta($wedding_id, 'wedding_gallery_images', false);
        $wedding_gallery_urls = [];

        if (!empty($wedding_image_ids)) {
            foreach ($wedding_image_ids as $wedding_image_id) {
                $url = wp_get_attachment_url($wedding_image_id);
                if ($url) {
                    $wedding_gallery_urls[] = $url; // Add the URL to the array
                }
            }
        }

        if (!empty($wedding_date_raw)) {
            $wedding_date = date('F j, Y', strtotime($wedding_date_raw));
        } else {
            $wedding_date = 'No date available';
        }

        $posts[] = [
            'wedding_id' => $wedding_id,
            'wedding_title' => $wedding_title,
            'wedding_thumbnail_url' => $wedding_thumbnail_url,
            'wedding_date' => $wedding_date,
            'wedding_fb_link' => $wedding_fb_link,
            'wedding_gallery_urls' => $wedding_gallery_urls
        ];
    }

    wp_reset_postdata();

    $chunks = array_chunk($posts, 6);

    foreach ($chunks as $chunk) {
        echo '<div class="swiper-slide">';

        // Create a grid layout for each slide.
        echo '<div class="wedding-grid">';

        // Keep track of the column index (1-based).
        $column_index = 1;

        foreach (array_chunk($chunk, 2) as $pair) {
            echo '<div class="wedding-column wedding-column-' . $column_index . '">';

            foreach ($pair as $post) {
                echo '<div class="wedding-item">';
                if (!empty($post['wedding_thumbnail_url'])) {
                    echo '<img 
                    class="wedding-thumbnail" 
                    src="' . esc_url($post['wedding_thumbnail_url']) . '" 
                    alt="' . esc_attr($post['wedding_title']) . '" 
                    data-id="' . esc_attr($post['wedding_id']) . '"
                    data-fb-link="' . esc_url($post['wedding_fb_link']) . '" 
                    data-gallery="' . htmlspecialchars(json_encode($post['wedding_gallery_urls']), ENT_QUOTES, 'UTF-8') . '"
                    data-title="' . esc_attr($post['wedding_title']) . '"
                >';
                }

                echo '<h2>' . esc_html($post['wedding_title']) . '</h2>';
                echo '<h5>' . esc_html($post['wedding_date']) . '</h5>';
                echo '</div>';
            }

            echo '</div>';
            $column_index++;
        }

        echo '</div>'; // End grid layout.
        echo '</div>'; // End Swiper slide.
    }
    echo '</div>'; // End Swiper wrapper.

    // Optional Swiper controls.
    echo '<div class="swiper-pagination"></div>';
    echo '<div class="swiper-arrow is-prev">
        <svg xmlns="http://www.w3.org/2000/svg" width="29" height="57" viewBox="0 0 29 57" fill="none">
        <path d="M28 1L0 29L28 57" stroke="black" stroke-width="2"/>
        </svg>
    </div>';

    echo '<div class="swiper-arrow is-next">
        <svg xmlns="http://www.w3.org/2000/svg" width="29" height="57" viewBox="0 0 29 57" fill="none">
          <path d="M1 1L29 29L1 57" stroke="black" stroke-width="2"/>
        </svg>
    </div>';

    echo '</div>'; // End Swiper main container.

    // Return the Swiper HTML.
    return ob_get_clean();
}

function wedding_slider_shortcode_mobile($atts)
{
    // Parse shortcode attributes.
    $atts = shortcode_atts([
        'count' => '', // Default is empty, meaning "show all".
    ], $atts, 'wedding_slider');


    $count = ($atts['count'] !== '') ? intval($atts['count']) : -1;

    $args = [
        'post_type' => 'wedding',
        'posts_per_page' => $count,
        'orderby' => 'date',
        'order' => 'ASC'
    ];

    $query = new WP_Query($args);

    if (!$query->have_posts()) {
        return '<p>No weddings found.</p>';
    }

    ob_start();

    $nonce = wp_create_nonce('wedding_slider_nonce');
    echo '<div class="wedding-swiper-mobile" data-nonce="' . esc_attr($nonce) . '">';
    echo '<div class="swiper-wrapper">';

    $posts = [];

    while ($query->have_posts()) {
        $query->the_post();

        $wedding_id = get_the_ID();
        $wedding_title = get_the_title();

        $wedding_thumbnail_id = get_post_meta($wedding_id, 'thumbnail', true);
        $wedding_thumbnail_url = wp_get_attachment_url($wedding_thumbnail_id);
        $wedding_date_raw = get_post_meta($wedding_id, 'wedding_date', true);

        $wedding_fb_link = get_post_meta($wedding_id, 'facebook_link', true);
        $wedding_image_ids = get_post_meta($wedding_id, 'wedding_gallery_images', false);
        $wedding_gallery_urls = [];

        if (!empty($wedding_image_ids)) {
            foreach ($wedding_image_ids as $wedding_image_id) {
                $url = wp_get_attachment_url($wedding_image_id);
                if ($url) {
                    $wedding_gallery_urls[] = $url; // Add the URL to the array
                }
            }
        }

        if (!empty($wedding_date_raw)) {
            $wedding_date = date('F j, Y', strtotime($wedding_date_raw));
        } else {
            $wedding_date = 'No date available';
        }

        $posts[] = [
            'wedding_id' => $wedding_id,
            'wedding_title' => $wedding_title,
            'wedding_thumbnail_url' => $wedding_thumbnail_url,
            'wedding_date' => $wedding_date,
            'wedding_fb_link' => $wedding_fb_link,
            'wedding_gallery_urls' => $wedding_gallery_urls
        ];
    }

    wp_reset_postdata();

    foreach ($posts as $post) {
        echo '<div class="swiper-slide">';
        echo '<div class="wedding-item">';
        if (!empty($post['wedding_thumbnail_url'])) {
            echo '<img 
                class="wedding-thumbnail" 
                src="' . esc_url($post['wedding_thumbnail_url']) . '" 
                alt="' . esc_attr($post['wedding_title']) . '" 
                data-id="' . esc_attr($post['wedding_id']) . '"
                data-fb-link="' . esc_url($post['wedding_fb_link']) . '" 
                data-gallery="' . htmlspecialchars(json_encode($post['wedding_gallery_urls']), ENT_QUOTES, 'UTF-8') . '"
                data-title="' . esc_attr($post['wedding_title']) . '"
            >';
        }
        echo '<h2>' . esc_html($post['wedding_title']) . '</h2>';
        echo '<h5>' . esc_html($post['wedding_date']) . '</h5>';
        echo '</div>';
        echo '</div>';
    }

    echo '</div>'; // End Swiper wrapper.

    // Optional Swiper controls.
    echo '<div class="swiper-pagination"></div>';
    echo '<div class="swiper-arrow is-prev">
        <svg xmlns="http://www.w3.org/2000/svg" width="29" height="57" viewBox="0 0 29 57" fill="none">
        <path d="M28 1L0 29L28 57" stroke="black" stroke-width="2"/>
        </svg>
    </div>';

    echo '<div class="swiper-arrow is-next">
        <svg xmlns="http://www.w3.org/2000/svg" width="29" height="57" viewBox="0 0 29 57" fill="none">
          <path d="M1 1L29 29L1 57" stroke="black" stroke-width="2"/>
        </svg>
    </div>';

    echo '</div>'; // End Swiper main container.

    // Return the Swiper HTML.
    return ob_get_clean();
}
