<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<p><?php
	/* translators: 1: user display name 2: logout url */
	printf(
		__( 'Hello %1$s (not %1$s? <a href="%2$s">Log out</a>)', 'woocommerce' ),
		'<strong>' . esc_html( $current_user->display_name ) . '</strong>',
		esc_url( wc_logout_url( wc_get_page_permalink( 'myaccount' ) ) )
	);
?></p>

<p><?php
	printf(
		__( 'From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">shipping and billing addresses</a> and <a href="%3$s">edit your password and account details</a>.', 'woocommerce' ),
		esc_url( wc_get_endpoint_url( 'orders' ) ),
		esc_url( wc_get_endpoint_url( 'edit-address' ) ),
		esc_url( wc_get_endpoint_url( 'edit-account' ) )
	);
?></p>
<?php 
	$user_id = get_current_user_id();

	$fav_nfl = get_field('favorite_nfl_team', 'user_' . $user_id);
	$fav_ncaa = get_field('favorite_ncaa_team', 'user_' . $user_id);
	$fav_nhl = get_field('favorite_nhl_team', 'user_' . $user_id);
	$fav_nba = get_field('favorite_nba_team', 'user_' . $user_id);
	$fav_mlb = get_field('favorite_mlb_team', 'user_' . $user_id);

	if (!empty($fav_nfl)) : 
		$nfl = get_term_by('name', $fav_nfl, 'nfl_teams');
	endif; 
	if (!empty($fav_ncaa)) : 
		$ncaa = get_term_by('name', $fav_ncaa, 'college_teams');
	endif; 
	if (!empty($fav_nhl)) : 
		$nhl = get_term_by('name', $fav_nhl, 'nhl_teams');
	endif; 
	if (!empty($fav_nba)) : 
		$nba = get_term_by('name', $fav_nba, 'nba_teams');
	endif; 
	if (!empty($fav_mlb)) : 
		$mlb = get_term_by('name', $fav_mlb, 'mlb_teams');
	endif; 
	
	
	
	
	

?>

<div class="pad-full-small white-bg shadow red-bd-top">
	<div class="grid-x grid-padding-x">
		<div class="large-12 cell">
			<h2 class="h4 no-mb">Your Favorite Teams</h2>
		</div>
	</div>
	<div class="grid-x grid-padding-x">
		<div class="large-12 cell">
			<hr>
		</div>
	</div>
	<div class="grid-x grid-margin-x large-up-5 align-middle favorite-logos">
		<div class="cell text-center">
			<?php if (isset($nfl)) : ?>		
				<?php $team_logo = get_field('team_logo', $nfl); ?>
				<a href="<?php echo get_home_url(); ?>/nfl/<?php echo $nfl->slug; ?>"><img src="<?php echo $team_logo['sizes']['large']; ?>" alt="">
					<h2><?php echo $nfl->name; ?></h2></a>
			<?php else : ?>
				<h3>No NFL team set. Go to your account details to choose.</h3>
			<?php endif; ?>
		</div>
		<div class="cell text-center">
			<?php if (isset($ncaa)) : ?>
				<?php $team_logo = get_field('team_logo', $ncaa); ?>
				<a href="<?php echo get_home_url(); ?>/ncaa/<?php echo $ncaa->slug; ?>"><img src="<?php echo $team_logo['sizes']['large']; ?>" alt="">
					<h2><?php echo $ncaa->name; ?></h2></a>
			<?php else : ?>
				<h3>No NCAA team set. Go to your account details to choose.</h3>
			<?php endif; ?>
			
		</div>
		<div class="cell text-center">
			<?php if (isset($nhl)) : ?>
				<?php $team_logo = get_field('team_logo', $nhl); ?>
				<a href="<?php echo get_home_url(); ?>/nhl/<?php echo $nhl->slug; ?>"><img src="<?php echo $team_logo['sizes']['large']; ?>" alt="">
					<h2><?php echo $nhl->name; ?></h2></a>
			<?php else : ?>
				<h3>No NHL team set. Go to your account details to choose.</h3>
			<?php endif; ?>
		</div>
		<div class="cell text-center">
			<?php if (isset($nba)) : ?>
				<?php $team_logo = get_field('team_logo', $nba); ?>
				<a href="<?php echo get_home_url(); ?>/nba/<?php echo $nba->slug; ?>"><img src="<?php echo $team_logo['sizes']['large']; ?>" alt="">
					<h2><?php echo $nba->name; ?></h2></a>
			<?php else : ?>
				<h3>No NBA team set. Go to your account details to choose.</h3>
			<?php endif; ?>
		</div>
		<div class="cell text-center">
			<?php if (isset($mlb)) : ?>
				<?php $team_logo = get_field('team_logo', $mlb); ?>
				<a href="<?php echo get_home_url(); ?>/mlb/<?php echo $mlb->slug; ?>"><img src="<?php echo $team_logo['sizes']['large']; ?>" alt="">
					<h2><?php echo $mlb->name; ?></h2></a>
			<?php else : ?>
				<h3>No MLB team set. Go to your account details to choose.</h3>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php
	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );

	/**
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_before_my_account' );

	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_after_my_account' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
