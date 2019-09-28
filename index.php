<?php
//Get content from header.php
get_header();
//If the theme's disable_blog_on_homepage variable is false
if (!comicpress_themeinfo('disable_blog_on_homepage')) {
	//If there are any posts
	if (have_posts()) {
		//While there are posts
		while (have_posts()) : the_post();
			//Get the content of the post
			get_template_part('content', get_post_format());
		//End the while statement
		endwhile;
		if (comicpress_themeinfo('enable_comments_on_homepage') && (comicpress_themeinfo('home_post_count') == '1')) {
			$withcomments = true;
			comments_template('', true);
		} else
			comicpress_pagination();
	}
}

get_footer();
