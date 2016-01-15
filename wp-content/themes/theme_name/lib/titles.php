<?php
namespace PD\ThemeFramework\Titles;

function title() {
	if ( is_home() ) {
		if ( get_option( 'page_for_posts', true ) ) {
			return get_the_title( get_option( 'page_for_posts', true ) );
		}

		return 'Latest Posts';

	}

	if ( is_archive() ) {
		return get_the_archive_title();
	}

	if ( is_search() ) {
		return sprintf( 'Search Results for %s', get_search_query() );
	}

	if ( is_404() ) {
		return 'Not Found';
	}

	return get_the_title();
}

