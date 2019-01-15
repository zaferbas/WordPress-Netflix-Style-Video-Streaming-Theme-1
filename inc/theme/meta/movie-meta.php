<?php

function synopis_meta_starring( ) {
	
	// VIEW CAST::
	echo '<li class="synopis-meta-spacer">' . __( 'Cast', 'streamium' )  . ': <a class="streamium-view-cast" data-id="' . get_the_ID() .'" href="javascript:;">View Cast</a></li>';
	
}

add_action( 'synopis_meta', 'synopis_meta_starring', 1, 0 );


function synopis_meta_genre( ) {

	$categories = get_the_category();
	$genres = __( 'Genres', 'streamium' ) . ": ";
	if ($categories) {
		$numItems = count($categories);
		$i = 0;
	  	foreach($categories as $cat) {

	  		$genres .= '<a href="' . esc_url( get_category_link( $cat->term_id ) ) . '">' . ucwords($cat->name) . '</a>';
	  		if(++$i !== $numItems) {
	    		$genres .= ', ';
	  		}

	  	}
	  	echo '<li class="synopis-meta-spacer">' . $genres . '</li>';
	}

}

add_action( 'synopis_meta', 'synopis_meta_genre', 2, 0 );

function synopis_meta_release( ) {

	echo '<li class="synopis-meta-spacer">' . __( 'Released', 'streamium' ) . ': <a href="/?s=all&date=' . get_the_date('Y/m/d') . '">' . get_the_date() . '</a></li>';

}

add_action( 'synopis_meta', 'synopis_meta_release', 3, 0 );

function synopis_multi_meta_starring( ) {

	// VIEW CAST::
	echo '<li class="synopis-meta-spacer">' . __( 'Cast', 'streamium' )  . ': <a class="streamium-view-cast" data-id="' . get_the_ID() .'" href="javascript:;">View Cast</a></li>';

	
}

add_action( 'synopis_multi_meta', 'synopis_multi_meta_starring', 1, 0 );


function synopis_multi_meta_genre() {

	$query = get_post_taxonomies( get_the_ID() );
	$tax = isset($query[1]) ? $query[1] : "";

	// Get the taxonomy name
	$taxName  = get_theme_mod( 'streamium_section_input_taxonomy_' . $tax, $tax );

	// Get the terms which is the taxonomies
	$categories = get_the_terms( get_the_ID(), $tax );

	if ($categories) {

		$genres = ucfirst($taxName) . ': ';
		$numItems = count($categories);
		$i = 0;
	  	foreach($categories as $cat) {

	  		$genres .= '<a href="' . esc_url( get_category_link( $cat->term_id ) ) . '">' . ucwords($cat->name) . '</a>';
	  		if(++$i !== $numItems) {
	    		$genres .= ', ';
	  		}

	  	}
	  	echo '<li class="synopis-meta-spacer">' . $genres . '</li>';
	}

}

add_action( 'synopis_multi_meta', 'synopis_multi_meta_genre', 2, 0 );

function synopis_multi_meta_release(){

	// Release date
	$streamiumOverrideReleaseDate = get_post_meta( get_the_ID(), 'streamium_release_date_meta_box_text', true );
	if(!empty($streamiumOverrideReleaseDate)){
		echo '<li class="synopis-meta-spacer">' . __( 'Released', 'streamium' ) . ': ' . $streamiumOverrideReleaseDate . '</li>';
	}else{
		echo '<li class="synopis-meta-spacer">' . __( 'Released', 'streamium' ) . ': <a href="/?s=all&date=' . get_the_date('Y/m/d') . '">' . get_the_date() . '</a></li>';
	}	

}

add_action( 'synopis_multi_meta', 'synopis_multi_meta_release', 3, 0 );

function synopis_meta_ratings( ) {

	$streamium_ratings = get_post_meta( get_the_ID(), 'streamium_ratings_meta_box_text', true );
	if ( ! empty( $streamium_ratings ) ) {
		echo '<li class="synopis-meta-spacer">' . __( 'Rating', 'streamium' ) . ': ' . $streamium_ratings . '</a></li>';
	}

}

if(get_theme_mod( 'streamium_enable_ratings' )) {
	add_action( 'synopis_multi_meta', 'synopis_meta_ratings', 4, 0 );
}

function synopis_video_progressbar(){

	if(is_user_logged_in() && get_theme_mod( 'streamium_enable_premium' )) {
		$userId = get_current_user_id();
    	$percentageWatched = get_post_meta( get_the_ID(), 'user_' . $userId, true );
		$episodes = get_post_meta(get_the_ID(), 'repeatable_fields' , true);
		if(!empty($episodes) || get_post_type( get_the_ID() ) == 'stream') {

			

		}else{

			echo '<div class="progress tile_progress"><div class="progress-bar" role="progressbar" aria-valuenow="' . $percentageWatched . '" aria-valuemin="0" aria-valuemax="100" style="width:' . $percentageWatched . '%"></div></div>';
			
		}

	}

}

add_action( 'synopis_video_progress', 'synopis_video_progressbar', 0, 0 );

function streamium_video_extra_meta_callback(){

	$streamium_extra_meta = get_post_meta( get_the_ID(), 'streamium_premium_meta_box_extra_meta_text', true );
	if ( ! empty( $streamium_extra_meta ) ) {
	    echo '<div class="streamium-extra-meta"><h5>' . $streamium_extra_meta . '</h5></div>';
	}

}

add_action( 'streamium_video_extra_meta', 'streamium_video_extra_meta_callback', 0, 0 );