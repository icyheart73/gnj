<?php
/**
 * View template for Testimonial widget
 *
 * @package GNJE\Templates
 * @copyright 2018 GanjeSoft. All rights reserved.
 */

if ( $settings['content'] != '' ) {

	$layout = $settings['layout'];
	$quote  = "";
	if ( $settings['show_quotation'] == 'true' ) {
		$quote = '<span class="gnje-quotation"><i class="cs-font ganje-icon-quote-1"></i></span>';
	}

	if ( $layout == 'grid' ) {

		?>
        <div class="container">
            <div class="row">
				<?php foreach ( $settings['content'] as $content ) { ?>
                    <div class="col-<?php echo 12 / ( $settings['columns']['size'] ); ?>">
                        <article class=" <?php echo esc_attr( 'gnje-testimonial-' . $content['_id'] ) ?>">
                            <div class="gnje-wrap-content">
								<?php echo $quote; ?>
                                <div class="gnje-testimonial-content">
									<?php echo $content['testimonial_content'];
									if ( $settings['show_star'] == 'true' ) {
										?>
                                        <div class="gnje-testimonial-rate">
                                            <span class="gnje-rate-star stars-<?php echo esc_attr( $content['star']['size'] ) ?>"></span>
                                        </div>
										<?php
									}
									?>
                                </div>
                                <div class="gnje-wrap-testimonial-info">
									<?php
									$ava = $content['author_avatar'];
									if ( $ava['url'] != '' && $settings['show_avatar'] == 'true' ) {
										?>
                                        <div class="gnje-wrap-avatar">
                                            <img src="<?php echo esc_url( $ava['url'] ); ?>"
                                                 alt="<?php $content['author']; ?>" class="gnje-testimonial-avatar"/>
                                        </div>
									<?php } ?>
                                    <div class="gnje-wrap-author-info">
										<?php
										if ( $content['author'] != '' ) { ?>
                                            <h4 class="gnje-testimonial-author"><?php
												echo esc_html( $content['author'] ); ?>
                                            </h4>
										<?php } ?>
										<?php
										if ( $content['author_des'] != '' && $settings['show_des'] == 'true' ) { ?>
                                            <div class="gnje-testimonial-des"><?php
												echo esc_html( $content['author_des'] ); ?>
                                            </div>
											<?php
										} ?>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
				<?php } ?>
            </div>

        </div>
	<?php } else {
		?>
        <!-- Swiper -->
        <div class="swiper-container testimonail-slider"
             data-items="<?php echo $settings['slides_to_show']['size']; ?>"
             data-autoplay="1"
             data-delay="<?php echo $settings['autoplay_speed']; ?>">
            <div class="swiper-wrapper">
				<?php foreach ( $settings['content'] as $content ) { ?>
                    <div class="swiper-slide">
                        <article class=" <?php echo esc_attr( 'gnje-testimonial-' . $content['_id'] ) ?>">
                            <div class="gnje-wrap-content">
								<?php echo $quote; ?>
                                <div class="gnje-testimonial-content">
									<?php echo $content['testimonial_content']; ?>
									<?php if ( $settings['show_star'] == 'true' ) {
										?>
                                        <div class="gnje-testimonial-rate">
                                            <span class="gnje-rate-star stars-<?php echo esc_attr( $content['star']['size'] ) ?>"></span>
                                        </div>
										<?php
									}
									?>
                                </div>
                                <div class="gnje-wrap-testimonial-info">
									<?php
									$ava = $content['author_avatar'];
									if ( $ava['url'] != '' && $settings['show_avatar'] == 'true' ) {
										?>
                                        <div class="gnje-wrap-avatar">
                                            <img src="<?php echo esc_url( $ava['url'] ); ?>"
                                                 alt="<?php $content['author']; ?>" class="gnje-testimonial-avatar"/>
                                        </div>
									<?php } ?>
                                    <div class="gnje-wrap-author-info">
										<?php
										if ( $content['author'] != '' ) { ?>
                                            <h4 class="gnje-testimonial-author"><?php
												echo esc_html( $content['author'] ); ?>
                                            </h4>
										<?php } ?>
										<?php
										if ( $content['author_des'] != '' && $settings['show_des'] == 'true' ) { ?>
                                            <div class="gnje-testimonial-des"><?php
												echo esc_html( $content['author_des'] ); ?>
                                            </div>
											<?php
										} ?>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
				<?php } ?>
            </div>


            <!-- Add Arrows -->
            <?php
            if($settings['show_nav']){ ?>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
             <?php } ?>

              <!-- Add Pagination -->
   <?php if ( $settings['show_pag'] ) {
     echo '<div class="swiper-pagination"></div></div>';

    }
    ?>

        </div>
		<?php
	}


}
$this->admin_editor_js = "<script>(function ($) {
    $('.testimonail-slider').each(function() {

        // Configuration
        var conf 	= {};
        var item = $(this).data('items');
        conf.slidesPerView = item;
        conf.autoplay = { delay : 5000 , disableOnInteraction : false};
        var myye = new Swiper( this , conf);

    });
})(jQuery);</script>";

if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
	add_action( 'elementor/frontend/after_enqueue_scripts', $this->editor_js() );
}
