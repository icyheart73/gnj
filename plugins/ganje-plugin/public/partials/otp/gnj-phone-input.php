<div class="gnj-reg-phinput-cont <?php echo esc_attr( implode( ' ', $cont_class ) ); ?>">

	<?php if( $label ): ?>
		<label class="<?php echo esc_attr( implode( ' ', $label_class ) ); ?>" for="gnj-reg-phone"> <?php echo $label; ?><?php if( $show_phone === 'required' ): ?>&nbsp;<span class="required">*</span><?php endif; ?></label>
	<?php endif; ?>

	<div class="<?php echo $show_cc !== 'disable' ? 'gnj-reg-has-cc' : ''; ?>">

		<?php if( $show_cc !== 'disable' ): ?>

			<?php $cc_list = include XOO_ML_PATH.'/countries/phone.php'; ?>

			<?php if( $show_cc === 'selectbox' && !empty( $cc_list ) ): ?>
				<select class="gnj-phone-cc gnj-reg-phone-cc-select <?php echo esc_attr( implode( ' ', $input_class ) ); ?>" name="gnj-reg-phone-cc" id="gnj-reg-phone-cc">
					<option disabled><?php _e( 'Select Country Code', 'mobile-login-woocommerce' ); ?></option>
					<?php foreach( $cc_list as $country_code => $country_phone_code ): ?>
						<option value="<?php echo $country_phone_code; ?>" <?php echo $country_phone_code === $default_cc ? 'selected' : ''; ?> ><?php echo $country_code.' '.$country_phone_code; ?></option>
					<?php endforeach; ?>
				</select>
			<?php endif; ?>

			<?php if( $show_cc === 'input' ): ?>
				<input name="gnj-reg-phone-cc" class="gnj-phone-cc gnj-reg-phone-cc-text <?php echo esc_attr( implode( ' ', $input_class ) ); ?>" value="<?php echo $default_cc; ?>" placeholder="<?php __( 'Country Code', 'mobile-login-woocommerce' ); ?>" id="gnj-reg-phone-cc" <?php echo $show_phone === 'required' ? 'required' : ''; ?>>
			<?php endif; ?>

		<?php endif; ?>

		<div class="gnj-regphin">
			<input type="text" class="gnj-phone-input gnj-reg-phone <?php echo esc_attr( implode( ' ', $input_class ) ); ?>" name="gnj-reg-phone" id="gnj-reg-phone" autocomplete="tel" value="<?php echo $default_phone; ?>" <?php echo $show_phone === 'required' ? 'required' : ''; ?>/>
			<span class="gnj-reg-phone-change"><?php _e( 'Change?', 'mobile-login-woocommerce' ); ?></span>
		</div>

		<input type="hidden" name="gnj-form-token" value="<?php echo $form_token; ?>">

		<input type="hidden" name="gnj-form-type" value="<?php echo $form_type; ?>">

	</div>

</div>
