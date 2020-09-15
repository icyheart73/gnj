<?php
/**
 * Import & Export for Option Panel
 *
 * @package     ReduxFramework
 * @author      Dovy Paukstys
 * @version     4.0.0
 */

defined( 'ABSPATH' ) || exit;

// Don't duplicate me!
if ( ! class_exists( 'Redux_Import_Export', false ) ) {

	/**
	 * Main Redux_import_export class
	 *
	 * @since       1.0.0
	 */
	class Redux_Import_Export extends Redux_Field {


		/**
		 * Redux_Import_Export constructor.
		 *
		 * @param array  $field Field array.
		 * @param string $value Value array.
		 * @param object $parent ReduxFramework object.
		 *
		 * @throws ReflectionException .
		 */
		public function __construct( $field = array(), $value = '', $parent ) {
			parent::__construct( $field, $value, $parent );

			$this->is_field = $this->parent->extensions['import_export']->is_field;
		}

		/**
		 * Set field defaults.
		 */
		public function set_defaults() {
			// Set default args for this field to avoid bad indexes. Change this to anything you use.
			$defaults = array(
				'options'          => array(),
				'stylesheet'       => '',
				'output'           => true,
				'enqueue'          => true,
				'enqueue_frontend' => true,
			);

			$this->field = wp_parse_args( $this->field, $defaults );
		}

		/**
		 * Field Render Function.
		 * Takes the vars and outputs the HTML for the field in the settings
		 *
		 * @since       1.0.0
		 * @access      public
		 * @return      void
		 */
		public function render() {
			$secret = md5( md5( Redux_Functions_Ex::hash_key() ) . '-' . $this->parent->args['opt_name'] );

			// No errors please.
			$defaults = array(
				'full_width' => true,
				'overflow'   => 'inherit',
			);

			$this->field = wp_parse_args( $this->field, $defaults );

			$do_close = false;

			$id = $this->parent->args['opt_name'] . '-' . $this->field['id'];
			?>
			<h4><?php esc_html_e( 'تنظیمات درون ریزی', 'redux-framework' ); ?></h4>
			<p>
				<a
					href="javascript:void(0);"
					id="redux-import-code-button"
					class="button-secondary">
					<?php esc_html_e( 'درون ریزی از فایل', 'redux-framework' ); ?>
				</a>

				<a
					href="javascript:void(0);"
					id="redux-import-link-button"
					class="button-secondary">
					<?php esc_html_e( 'درون ریزی از آدرس', 'redux-framework' ); ?>
				</a>
			</p>
			<div id="redux-import-code-wrapper">
				<p class="description" id="import-code-description">

					<?php // phpcs:ignore WordPress.NamingConventions.ValidHookName ?>
					<?php echo esc_html( apply_filters( 'redux-import-file-description', esc_html__( 'Input your backup file below and hit Import to restore your sites options from a backup.', 'redux-framework' ) ) ); ?>
				</p>
				<textarea
					id="import-code-value"
					name="<?php echo esc_attr( $this->parent->args['opt_name'] ); ?>[import_code]"
					class="large-text no-update" rows="2"></textarea>
			</div>
			<div id="redux-import-link-wrapper">
				<p class="description" id="import-link-description">
					<?php // phpcs:ignore WordPress.NamingConventions.ValidHookName ?>
					<?php echo esc_html( apply_filters( 'redux-import-link-description', esc_html__( 'Input the URL to another sites options set and hit Import to load the options from that site.', 'redux-framework' ) ) ); ?>
				</p>
				<textarea
					class="large-text no-update"
					id="import-link-value"
					name="<?php echo esc_attr( $this->parent->args['opt_name'] ); ?>[import_link]"
					rows="2"></textarea>
			</div>
			<p id="redux-import-action">
				<input
					type="submit"
					id="redux-import"
					name="import"
					class="button-primary"
					value="<?php esc_html_e( 'درون ریزی', 'redux-framework' ); ?>">&nbsp;&nbsp;
				<span>
					<?php // phpcs:ignore WordPress.NamingConventions.ValidHookName ?>
					<?php echo esc_html( apply_filters( 'redux-import-warning', esc_html__( 'هشدار ! با درون آوری موارد تمامی اطلاعات تغییر خواهد کرد', 'redux-framework' ) ) ); ?>
				</span>
			</p>
			<div class="hr">
				<div class="inner">
					<span>&nbsp;</span>
				</div>
			</div>
			<h4><?php esc_html_e( 'تنظیمات برون ریزی', 'redux-framework' ); ?></h4>
			<div class="redux-section-desc">
				<p class="description">
					<?php // phpcs:ignore WordPress.NamingConventions.ValidHookName ?>
					<?php echo esc_html( apply_filters( 'redux-backup-description', esc_html__( 'در این قسمت می توانید تنظیمات گزینه های فعلی خود را کپی / بارگیری کنید و از تنظیمات فعلی خود نسخه ای پشتیبان داشته باشید. ', 'redux-framework' ) ) ); ?>
				</p>
			</div>
			<?php $link = admin_url( 'admin-ajax.php?action=redux_download_options-' . $this->parent->args['opt_name'] . '&secret=' . $secret ); ?>
			<p>
				<a href="javascript:void(0);" id="redux-export-code-copy" class="button-secondary">
					<?php esc_html_e( 'کپی داده ها', 'redux-framework' ); ?>
				</a>
				<a href="<?php echo esc_url( $link ); ?>" id="redux-export-code-dl" class="button-primary">
					<?php esc_html_e( 'دانلود فایل داده ها', 'redux-framework' ); ?>
				</a>
				<a href="javascript:void(0);" id="redux-export-link" class="button-secondary">
					<?php esc_html_e( 'کپی آدرس برون ریزی', 'redux-framework' ); ?>
				</a>
			</p>
			<p></p>
			<textarea class="large-text no-update" id="redux-export-code" rows="2"></textarea>
			<textarea
				class="large-text no-update"
				id="redux-export-link-value"
				data-url="<?php echo esc_url( $link ); ?>"
				rows="2"><?php echo esc_url( $link ); ?></textarea>
			<?php
		}

		/**
		 * Enqueue Function.
		 * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
		 *
		 * @since       1.0.0
		 * @access      public
		 * @return      void
		 */
		public function enqueue() {
			wp_enqueue_script(
				'redux-extension-import-export-js',
				$this->url . 'redux-import-export' . Redux_Functions::is_min() . '.js',
				array( 'jquery', 'redux-js' ),
				Redux_Extension_Import_Export::$version,
				true
			);

			wp_enqueue_style(
				'redux-import-export',
				$this->url . 'redux-import-export.css',
				array(),
				Redux_Extension_Import_Export::$version,
				'all'
			);
		}
	}
}
