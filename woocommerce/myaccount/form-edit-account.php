<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_edit_account_form' ); ?>

<div class="grid-x grid-padding-x align-center">
	<div class="large-8 cell">
		<div class="white-bg pad-full-medium shadow red-bd-top">
			<form class="woocommerce-EditAccountForm edit-account" action="" method="post">
			
				<?php do_action( 'woocommerce_edit_account_form_start' ); ?>
			
				<div class="grid-x grid-padding-x">
					<div class="large-6 cell">
						<label for="account_first_name"><?php esc_html_e( 'First name', 'woocommerce' ); ?> <span class="required">*</span></label>
						<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" value="<?php echo esc_attr( $user->first_name ); ?>" />	
					</div>
					<div class="large-6 cell">
						<label for="account_last_name"><?php esc_html_e( 'Last name', 'woocommerce' ); ?> <span class="required">*</span></label>
						<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" value="<?php echo esc_attr( $user->last_name ); ?>" />	
					</div>
					<div class="large-12 cell">
						<label for="account_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
						<input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" value="<?php echo esc_attr( $user->user_email ); ?>" />
					</div>
				</div>
			
				<fieldset>
					<legend><?php esc_html_e( 'Password change', 'woocommerce' ); ?></legend>
					<div class="grid-x grid-padding-x">
						<div class="large-12 cell">
							<label for="password_current"><?php esc_html_e( 'Current password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
							<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" />
						</div>
						<div class="large-12 cell">
							<label for="password_1"><?php esc_html_e( 'New password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
							<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" />
						</div>
						<div class="large-12 cell">
							<label for="password_2"><?php esc_html_e( 'Confirm new password', 'woocommerce' ); ?></label>
							<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" />
						</div>
					</div>
				</fieldset>
				<div class="clear"></div>
			
				<?php do_action( 'woocommerce_edit_account_form' ); ?>
				<div class="grid-x grid-padding-x align-center">
					<div class="large-12 cell">
						<button type="submit" class="woocommerce-Button button expanded" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>"><?php esc_html_e( 'Save changes', 'woocommerce' ); ?></button>
						<input type="hidden" name="action" value="save_account_details" />	
					</div>
				</div>
				<p>
					<?php wp_nonce_field( 'save_account_details' ); ?>
					
				</p>
			
				<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
			</form>
		</div>
	</div>
</div>
<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
