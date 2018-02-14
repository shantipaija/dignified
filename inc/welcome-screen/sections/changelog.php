<?php
/**
 * Changelog
 */

$dignified = wp_get_theme( 'dignified' );

?>
<div class="featured-section changelog">
	

	<?php
	WP_Filesystem();
	global $wp_filesystem;
	$dignified_changelog       = $wp_filesystem->get_contents( get_template_directory() . '/changelog.txt' );
	$dignified_changelog_lines = explode( PHP_EOL, $dignified_changelog );
	foreach ( $dignified_changelog_lines as $dignified_changelog_line ) {
		if ( substr( $dignified_changelog_line, 0, 3 ) === '###' ) {
			echo '<h4>' . substr( $dignified_changelog_line, 3 ) . '</h4>';
		} else {
			echo $dignified_changelog_line, '<br/>';
		}
	}

	echo '<hr />';


	?>

</div>
