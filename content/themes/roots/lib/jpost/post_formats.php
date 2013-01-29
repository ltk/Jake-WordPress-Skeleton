<?php
$page_post_format = function ( $jpost ) {
	return sprintf('<h1>%s</h1>%s', 
						esc_html($jpost->title()),
						$jpost->content()
					);
};

$li_post_format = function ( $jpost ) {
	return sprintf('<li class="%s">%s</li>', 
						esc_attr($jpost->classes()),
						$jpost->linked_title()
					);
};

/**
Homepage
*/
$homepage_banner_post_format = function ( $jpost ) {
    return sprintf('<div class="item %s">%s</div>',
                    esc_attr($jpost->classes()),
                    $jpost->thumbnail( 'full', '' )
                );
};

$feature_box_post_format = function ( $jpost ) {
    return sprintf('<div class="feature-box %s"><h4 class="title">%s</h4><div class="details"><p class="desc">%s</p><a class="btn btn-shadowed" href="%s" title="%s">%s</a></div></div>',
                    esc_attr($jpost->classes()),
                    esc_html($jpost->title()),
                    esc_html($jpost->post_excerpt),
                    esc_url($jpost->meta('button-link', true)),
                    esc_attr($jpost->title()),
                    esc_html($jpost->meta('button-text', true))
                );
};

/**
News
*/
$news_item_post_format = function ( $jpost ) {
    $source_file = $jpost->meta('source-file', true);
    $source_link = $jpost->meta('source-link', true);

    $news_item_entry = sprintf('%s<h4 class="source">%s</h4><p class="title">%s</p>',
                   $jpost->thumbnail('full', 'img-portrait-thumbnail'),
                   esc_html($jpost->meta('source', true)),
                   esc_html($jpost->title())
                   );

    if( $source_file || $source_link ) {
        $link = $source_link ? $source_link : $source_file;
        $news_item_entry = sprintf('<a href="%s" title="%s" target="_blank">%s</a>',
                                   esc_url($link),
                                   esc_attr($jpost->title()),
                                   $news_item_entry
                                   );
    }

    return sprintf('<li class="news-item grid-item">%s%s</li>', $jpost->edit_post_link(), $news_item_entry );
};

/**
FAQs
*/
$faq_post_format = function ( $jpost ) {
    return sprintf('<li class="faq">%s<h3 class="question">%s</h3><div class="answer">%s</div></li>', $jpost->edit_post_link(), esc_html($jpost->title()), $jpost->content() );
};


J_Post::register_format( 'li', $li_post_format, true ); // 3rd param sets this as the default html format
J_Post::register_format( 'page', $page_post_format );
J_Post::register_format( 'homepage-banner', $homepage_banner_post_format );
J_Post::register_format( 'feature-box', $feature_box_post_format );
J_Post::register_format( 'news-item', $news_item_post_format );
J_Post::register_format( 'faq', $faq_post_format );