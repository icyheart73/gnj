<span class="gnj-or"><?php _e( 'Or', 'mobile-login-woocommerce' ); ?></span>
<button type="button" class="gnj-open-lwo-btn button btn <?php echo implode( ' ', $button_class ); ?> "><?php _e( 'Login with OTP', 'mobile-login-woocommerce' ); ?></button>

<div class="gnj-lwo-form-placeholder" <?php if( $login_first !== 'yes' ): ?> style="display: none;" <?php endif; ?> >

	<div class="gnj-login-phinput-cont <?php echo esc_attr( implode( ' ', $cont_class ) ); ?>">

		<?php if( $label ): ?>
			<label class="<?php echo esc_attr( implode( ' ', $label_class ) ); ?>" for="gnj-login-phone"> <?php echo $label; ?>&nbsp;<span class="required">*</span></label>
		<?php endif; ?>


		<?php if( $is_login_popup ): ?>

			<div class="xoo-aff-group">
				<div class="xoo-aff-input-group">
					<span class="xoo-aff-input-icon fas fa-phone"></span>
					<input type="text" placeholder="<?php _e( 'Phone', 'mobile-login-woocommerce' ); ?>" name="gnj-phone-login" class="gnj-phone-login gnj-phone-input <?php echo esc_attr( implode( ' ', $input_class ) ); ?>" required autocomplete="tel">
				</div>
			</div>

		<?php else: ?>

			<input type="text" placeholder="<?php _e( 'Phone', 'mobile-login-woocommerce' ); ?>" name="gnj-phone-login" class="gnj-phone-login gnj-phone-input <?php echo esc_attr( implode( ' ', $input_class ) ); ?>" required  autocomplete="tel" >

		<?php endif; ?>

	</div>

	<input type="hidden" name="gnj-form-token" value="<?php echo $form_token; ?>">
	<input type="hidden" name="gnj-form-type" value="login_user_with_otp">
	<input type="hidden" name="redirect" value="<?php echo $redirect; ?>">
	<button type="submit" class="gnj-login-otp-btn <?php echo implode( ' ', $button_class ); ?> "><?php _e( 'Login with OTP', 'mobile-login-woocommerce' ); ?></button>
	<span class="gnj-or"><?php _e( 'Or', 'mobile-login-woocommerce' ); ?></span>
	<button type="button" class="gnj-low-back <?php echo implode( ' ', $button_class ); ?>"><?php _e( 'Login with Email & Password', 'mobile-login-woocommerce' ); ?></button>
</div>
