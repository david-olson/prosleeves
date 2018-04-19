<?php
/**
 * Template for displaying search forms in Twenty Eleven
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>
	<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label for="s" class="assistive-text screen-reader-text"><?php _e( 'Search', 'twentyeleven' ); ?></label>
		<div class="grid-x grid-padding-x">
			<div class="large-8 cell">
				<input type="text" class="field" name="s" id="s" placeholder="<?php esc_attr_e( 'Search', 'twentyeleven' ); ?>" />
			</div>
			<div class="large-4 cell">
				<input type="submit" class="submit button tiny" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'twentyeleven' ); ?>" />
			</div>
		</div>
	</form>