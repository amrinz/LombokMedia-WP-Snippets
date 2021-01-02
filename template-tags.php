<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Starhotel
 */

if ( ! function_exists( 'starhotel_paging_nav' ) ) :
    /**
     * Display navigation to next/previous set of posts when applicable.
     */
    function starhotel_paging_nav() {
        // Don't print empty markup if there's only one page.
        if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
            return;
        }
        ?>
        <nav class="navigation paging-navigation" role="navigation">
            <h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'starhotel' ); ?></h1>
            <div class="nav-links">

                <?php if ( get_next_posts_link() ) : ?>
                    <div class="nav-previous"><span class="meta-nav"><i class="fa fa-arrow-left" aria-hidden="true"></i></span><?php next_posts_link( __( 'Older posts', 'starhotel' ) ); ?></div>
                <?php endif; ?>

                <?php if ( get_previous_posts_link() ) : ?>
                    <div class="nav-next"><?php previous_posts_link( __( 'Newer posts', 'starhotel' ) ); ?><span class="meta-nav"><i class="fa fa-arrow-right" aria-hidden="true"></i></span></div>
                <?php endif; ?>

            </div><!-- .nav-links -->
        </nav><!-- .navigation -->
    <?php
    }
endif;

/**
 * Pagination for archive, taxonomy, category, tag and search results pages
 *
 * @global $wp_query http://codex.wordpress.org/Class_Reference/WP_Query
 * @return Prints the HTML for the pagination if a template is $paged
 */
// Use wp_link_pages for standard pagination
wp_link_pages();
function starhotel_pagination( $query=null ) {
    global $wp_query;
    $query = $query ? $query : $wp_query;
    $big = 999999999;
    $paginate = paginate_links( array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'type' => 'array',
            'total' => $query->max_num_pages,
            'format' => '?paged=%#%',
            'current' => max( 1, get_query_var('paged') ),
            'prev_text' => '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
            'next_text' => '<i class="fa fa-arrow-right" aria-hidden="true"></i>',
        )
    );
    if ($query->max_num_pages > 1) :
        ?>
        <div class="text-center mt50">
            <ul class="pagination clearfix">
                <?php
                foreach ( $paginate as $page ) {
                    echo '<li>' . $page . '</li>';
                }
                ?>
            </ul>
        </div>
    <?php
    endif;
}

if ( ! function_exists( 'starhotel_post_nav' ) ) :
    /**
     * Display navigation to next/previous post when applicable.
     */
    function starhotel_post_nav() {
        // Don't print empty markup if there's nowhere to navigate.
        $previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
        $next     = get_adjacent_post( false, '', false );

        if ( ! $next && ! $previous ) {
            return;
        }
        ?>
        <nav class="row" role="navigation">
            <div class="col-md-12">
                <?php
                previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav"><i class="fa fa-arrow-left" aria-hidden="true"></i></span> %title', 'Previous post link', 'starhotel' ) );
                next_post_link(     '<div class="nav-next">%link</div>',     _x( '%title <span class="meta-nav"><i class="fa fa-arrow-right" aria-hidden="true"></i></span>', 'Next post link',     'starhotel' ) );
                ?>
            </div><!-- .nav-links -->
        </nav><!-- .navigation -->
    <?php
    }
endif;

if ( ! function_exists( 'starhotel_posted_on' ) ) :
    /**
     * Prints HTML with meta information for the current post-date/time and author.
     */
    function starhotel_posted_on() {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
        if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
            $time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf( $time_string,
            esc_attr( get_the_date( 'c' ) ),
            esc_html( get_the_date() ),
            esc_attr( get_the_modified_date( 'c' ) ),
            esc_html( get_the_modified_date() )
        );

        $posted_on = sprintf(
            _x( 'Posted on %s', 'post date', 'starhotel' ),
            '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
        );

        $byline = sprintf(
            _x( 'by %s', 'post author', 'starhotel' ),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
        );

        echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>';

    }
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function starhotel_categorized_blog() {
    if ( false === ( $all_the_cool_cats = get_transient( 'starhotel_categories' ) ) ) {
        // Create an array of all the categories that are attached to posts.
        $all_the_cool_cats = get_categories( array(
            'fields'     => 'ids',
            'hide_empty' => 1,

            // We only need to know if there is more than one category.
            'number'     => 2,
        ) );

        // Count the number of categories that are attached to the posts.
        $all_the_cool_cats = count( $all_the_cool_cats );

        set_transient( 'starhotel_categories', $all_the_cool_cats );
    }

    if ( $all_the_cool_cats > 1 ) {
        // This blog has more than 1 category so starhotel_categorized_blog should return true.
        return true;
    } else {
        // This blog has only 1 category so starhotel_categorized_blog should return false.
        return false;
    }
}

/**
 * Flush out the transients used in starhotel_categorized_blog.
 */
function starhotel_category_transient_flusher() {
    // Like, beat it. Dig?
    delete_transient( 'starhotel_categories' );
}
add_action( 'edit_category', 'starhotel_category_transient_flusher' );
add_action( 'save_post',     'starhotel_category_transient_flusher' );
