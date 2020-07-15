<div class="gnj-form-placeholder">
	<form class="gnj-otp-form">

		<div class="gnj-otp-sent-txt">
			<span class="gnj-otp-no-txt"></span>
			<span class="gnj-otp-no-change"> <?php _e( "Change", 'mobile-login-woocommerce' ); ?></span>
		</div>

		<div class="gnj-otp-notice-cont">
			<div class="gnj-notice"></div>
		</div>

		<div class="gnj-otp-input-cont">
			<?php for ( $i= 0; $i < $otp_length; $i++ ): ?>
				<input type="text" maxlength="1" autocomplete="off" name="gnj-otp[]" class="gnj-otp-input">
			<?php endfor; ?>
		</div>

		<input type="hidden" name="gnj-otp-phone-no" >
		<input type="hidden" name="gnj-otp-phone-code" >

		<button type="submit" class="button btn gnj-otp-verify-btn"><?php _e( 'Verify', 'mobile-login-woocommerce' ); ?> </button>

		<div class="gnj-otp-resend">
			<a class="gnj-otp-resend-link"><?php _e( 'Not received your code? Resend code', 'mobile-login-woocommerce' ); ?></a>
			<span class="gnj-otp-resend-timer"></span>
		</div>

		<input type="hidden" name="gnj-form-token" value="">

	</form>

</div>
