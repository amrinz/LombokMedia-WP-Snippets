<?php
/* Optional - Documentatiton */
//display contextual help for Books

function codex_add_help_text( $contextual_help, $screen_id, $screen ) {
  //$contextual_help .= var_dump( $screen ); // use this to help determine $screen->id
  if ( 'slideshows' == $screen->id ) {
    $contextual_help =
      '<p>' . __('Things to remember when adding or editing a book:', 'your_text_domain') . '</p>' .
      '<ul>' .
      '<li>' . __('Specify the correct genre such as Mystery, or Historic.', 'your_text_domain') . '</li>' .
      '<li>' . __('Specify the correct writer of the book.  Remember that the Author module refers to you, the author of this book review.', 'your_text_domain') . '</li>' .
      '</ul>' .
      '<p>' . __('If you want to schedule the book review to be published in the future:', 'your_text_domain') . '</p>' .
      '<ul>' .
      '<li>' . __('Under the Publish module, click on the Edit link next to Publish.', 'your_text_domain') . '</li>' .
      '<li>' . __('Change the date to the date to actual publish this article, then click on Ok.', 'your_text_domain') . '</li>' .
      '</ul>' .
      '<p><strong>' . __('For more information:', 'your_text_domain') . '</strong></p>' .
      '<p>' . __('<a href="http://codex.wordpress.org/Posts_Edit_SubPanel" target="_blank">Edit Posts Documentation</a>', 'your_text_domain') . '</p>' .
      '<p>' . __('<a href="http://wordpress.org/support/" target="_blank">Support Forums</a>', 'your_text_domain') . '</p>' ;
  } elseif ( 'edit-book' == $screen->id ) {
    $contextual_help =
      '<p>' . __('This is the help screen displaying the table of books blah blah blah.', 'your_text_domain') . '</p>' ;
  }
  return $contextual_help;
}
add_action( 'contextual_help', 'codex_add_help_text', 10, 3 );