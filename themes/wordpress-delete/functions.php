<?php

    if( is_category() ) $insert = $ssep . __('Category','corpo');
    elseif( is_tag() ) $insert = $ssep . __('Tag','corpo');
    elseif( is_author() ) $insert = $ssep . __('Author','corpo');
    elseif( is_year() || is_month() || is_day() ) $insert = $ssep . __('Archives','corpo');
    elseif( is_home() ) $insert = $ssep . get_bloginfo('description');

    if( get_query_var( 'paged' ) )

    elseif( get_query_var( 'page' ) )

    register_sidebar(array(
        'name' => __('Main Sidebar', 'corpo'),
        'description' => __('Main widget area displayed on blog posts & archives', 'corpo'),
        'id' => 'main-sidebar',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>'
    ));
    
    //Register widgets
    register_widget( 'corpo_contact_widget' );
    register_widget( 'corpo_popular_posts_widget' );
    register_widget( 'corpo_recent_widget' );
    register_widget( 'corpo_services_widget' );

    $count = get_post_meta($postID, $count_key, true);

        delete_post_meta($postID, $count_key);

        add_post_meta($postID, $count_key, '0');

        update_post_meta($postID, $count_key, $count);

    $output = get_the_excerpt();

       $tags = get_the_tag_list('', __( ', ', 'corpo' ));

 
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {


                            <?php echo get_comment_author_link() ?>
                                    <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                            <div class="comment-text"><p><?php comment_text(); ?></p></div>


