<?php
$linked_title = function ( $jpost ) {
	return sprintf('<a href="%s" class="%s">%s</a>', 
						esc_url($jpost->permalink()),
						esc_attr($jpost->classes( 'linked-title' )),
						esc_html($jpost->title())
					);
};

$linked_thumbnail = function ( $jpost ) {
	return sprintf("<a href='%s' class='%s'>%s</a>", 
						esc_url($jpost->permalink()),
						esc_attr($jpost->classes( 'linked-thumbnail' )),
						$jpost->thumbnail()
					);
};

$edit_post_link = function ( $jpost ) {
	if( is_user_logged_in() && current_user_can('edit_post', $jpost->ID) ) {
		return sprintf("<a class='admin-edit-post' href='%s' title='Edit this Item'>Edit</a>", esc_url(get_edit_post_link( $jpost->ID )) );
	}
};

J_Post::register_partial( 'linked_title', $linked_title );
J_Post::register_partial( 'linked_thumbnail', $linked_thumbnail );
J_Post::register_partial( 'edit_post_link', $edit_post_link );
