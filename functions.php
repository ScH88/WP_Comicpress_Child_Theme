<?php
add_action( 'wp_enqueue_scripts', 'mytheme_enqueue_styles' );
function mytheme_enqueue_styles() {
  $parent_style = 'parent-style';
  wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
  wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( $parent_style ), wp_get_theme()->get('Version'));
}

// Custom Function to Include
function my_favicon_link() {
  echo '<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />' . "\n";
}
add_action( 'wp_head', 'my_favicon_link' );

/**
* Declare textdomain for this child theme.
* Translations can be added to the /languages/ directory.
*/
function comicpress_child_theme_setup() {
  load_child_theme_textdomain( 'comicpress-child', get_stylesheet_directory() . '/lang' );
}
add_action( 'after_setup_theme', 'comicpress_child_theme_setup' );

/* Add CPTs to author archives */
function custom_post_author_archive($query) {
  if ($query->is_author)
  $query->set( 'post_type', array('comic', 'post') );
  remove_action( 'pre_get_posts', 'custom_post_author_archive' );
}
add_action('pre_get_posts', 'custom_post_author_archive');

//Change the texts of the standard WP comments form
function wp_comment_form_defaults($defaults) {
  $defaults['comment_notes_before'] = '<p>Your email address will not be published.</p>';
  return $defaults;
}
add_filter('comment_form_defaults', 'wp_comment_form_defaults');

//Change the texts of the standard WP comments form
function wp_comment_form_fields($fields) {
  $fields['author'] = '<p class="comment-form-author">' . '<label for="author">' . __( 'Your Name: ', 'comicpress' ) . '</label>'
  . '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" /></p>';
  $fields['email'] = '<p class="comment-form-email">'
  . '<label for="email">' . __( 'Your Email', 'comicpress' ) . '<small> <a href="https://gravatar.com" target="_blank" rel="noopener noreferrer">' . __( '(Get a Gravatar)', 'comicpress' ) . '</a></small>: </label>'
  . '<input id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" /></p>';
  $fields['url'] = '';
  return $fields;
}
add_filter('comment_form_default_fields', 'wp_comment_form_fields');

function wp_rearrange_form_fields( $fields ) {
$comment_field = $fields['comment'];
$cookies = $fields['cookies'];
unset( $fields['comment'] );
unset( $fields['cookies'] );
$fields['comment'] = $comment_field;
$fields['cookies'] = $cookies;
return $fields;
}
add_filter( 'comment_form_fields', 'wp_rearrange_form_fields' );
