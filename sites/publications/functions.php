<?php

/**
 * Initialize the America_Theme_Extender class if it is not already loaded
 * sending in both a path to the directory on filesystem where assets are
 * located and url to assets. The params are set to reasonable defaults
 * and can be changed if necessary.
 *
 * @param  string $path default path to grandchild assets (i.e. sites/publications)
 */
function initialize_site( $path ) {

	$dir = get_stylesheet_directory() . '/' . $path;
	$uri = get_stylesheet_directory_uri() . '/' . $path;

	if( class_exists ('America_Theme_Extender') ) {
		$america_theme_extender = new America_Theme_Extender( $dir, $uri );
	}
}

//* Enqueue Scripts (add additional font weights)
add_action( 'wp_enqueue_scripts', 'amgov_pubs_load_scripts' );
function amgov_pubs_load_scripts() {
  wp_enqueue_style( 'google-font-amgov-pubs', '//fonts.googleapis.com/css?family=Signika:600,700|Source+Sans+Pro:600', array(), CHILD_THEME_VERSION );
}

//* Display a custom favicon
add_filter( 'genesis_pre_load_favicon', 'amgov_pubs_favicon_filter' );
function amgov_pubs_favicon_filter( $favicon_url ) {
	return '/wp-content/themes/america/sites/publications/images/dist/favicon.ico';
}

//* Add image sizes
add_image_size( 'publication', 450, 564 );
add_image_size( 'publication-small', 200, 250, true );
set_post_thumbnail_size( 150, 190, true );


//* Modify the length of post excerpts
add_filter( 'excerpt_length', 'amgov_pubs_excerpt_length' );
function amgov_pubs_excerpt_length( $length ) {
	return 30; // pull first 50 words
}

//* Remove archive pages from search results
add_action('pre_get_posts','amgov_pubs_search_filter');
function amgov_pubs_search_filter($query) {
  if ( !is_admin() && $query->is_main_query() ) {
    if ($query->is_search || $query->is_category ) {
      $query->set( 'post_type', array('publication') );
      //$query->set( 'posts_per_page', 12 );
    }
  }
}

// make additional file types available for upload
add_filter('upload_mimes', 'amgov_pubs_upload_mimes');
function amgov_pubs_upload_mimes( $mime_types ) {
    $mime_types['epub'] = 'application/epub+zip';
    $mime_types['mobi'] = 'application/x-mobipocket-ebook';

    return $mime_types;
}


//* Add Google Tag Manager
add_action('wp_head', 'amgov_pubs_gtm_head');
function amgov_pubs_gtm_head() {
	$html = '<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({"gtm.start":
	new Date().getTime(),event:"gtm.js"});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!="dataLayer"?"&l="+l:"";j.async=true;j.src=
	"//www.googletagmanager.com/gtm.js?id="+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,"script","dataLayer","GTM-T2866D");</script>
	<!-- End Google Tag Manager -->';
	  echo $html;
}
add_action('genesis_before', 'amgov_pubs_gtm_body');
function amgov_pubs_gtm_body() {
  $html = '<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-T2866D"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager -->';
  echo $html;
}

add_filter( 'genesis_search_text', 'amgov_pubs_search_text' );
function amgov_pubs_search_text( $text ) {
  return esc_attr( 'Search Publications' );
}

//* Remove Footer Credits
remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_footer', 'amgov_pubs_custom_footer' );
function amgov_pubs_custom_footer() {
  ?>

  <p class="site-footer footer-contact">Comments? Suggestions?  <a href="mailto:gpa_graphics@america.gov">Contact Us</a></div>

  <p class="site-footer-legal">This site is managed by the <a href="https://www.state.gov/bureaus-offices/under-secretary-for-public-diplomacy-and-public-affairs/bureau-of-global-public-affairs/" target="_blank">Bureau of Global Public Affairs</a> within the  <a href="http://www.state.gov" target="_blank">U.S. Department of State</a>. External links to other Internet sites should not be construed as an endorsement of the views or privacy policies contained therein.</p>
  <?php
}
