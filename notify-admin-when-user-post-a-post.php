<?php 
/**
 *  Notify admin when user published post
 *  @author: takien
 */
function notify_admin_published_post( $ID, $post ) {
    $emailed_to       = 'admin@example.com';//edit this, your email here.
    
    $author_id        = $post->post_author; 
    $author_name      = get_the_author_meta( 'display_name', $author_id );
    $author_email     = get_the_author_meta( 'user_email', $author_id );
    $title     = $post->post_title;
    $permalink = get_permalink( $ID );
    $edit      = get_edit_post_link( $ID, '' );
    $to[]      = $emailed_to;
    $subject   = $author_name.' published an article "'. $title .'"';
    $message   = 'Dear Admin, '.$author_name.' has publised an article';
    $message   .= '<br />Title: '. $title ;
    $message   .= '<br />Link: '. $permalink ;
    $message   .= '<br />Edit Link: '. $edit ;
    
    $headers = "From: " . $author_email . "\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    
    wp_mail( $to, $subject, $message, $headers );
}
add_action( 'publish_post', 'notify_admin_published_post', 10, 2 );