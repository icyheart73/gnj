<?php
/**
 * View template for Testimonial widget
 *
 * @package CAFE\Templates
 * @copyright 2018 CleverSoft. All rights reserved.
 */

if ( $settings['content'] != '' ) {

	$layout = $settings['layout'];
	$quote  = "";
	if ( $settings['show_quotation'] == 'true' ) {
		$quote = '<span class="cafe-quotation"><i class="cs-font clever-icon-quote-1"></i></span>';
	}

	if ( $layout == 'grid' ) {

		?>
        <div class="container">
            <div class="row">
				<?php foreach ( $settings['content'] as $content ) { ?>
                    <div class="col-<?php echo 12 / ( $settings['columns']['size'] ); ?>">
                        <article class=" <?php echo esc_attr( 'cafe-testimonial-' . $content['_id'] ) ?>">
                            <div class="cafe-wrap-content">
								<?php echo $quote; ?>
                                <div class="cafe-testimonial-content">
									<?php echo $content['testimonial_content'];
									if ( $settings['show_star'] == 'true' ) {
										?>
                                        <div class="cafe-testimonial-rate">
                                            <span class="cafe-rate-star stars-<?php echo esc_attr( $content['star']['size'] ) ?>"></span>
                                        </div>
										<?php
									}
									?>
                                </div>
                                <div class="cafe-wrap-testimonial-info">
									<?php
									$ava = $content['author_avatar'];
									if ( $ava['url'] != '' && $settings['show_avatar'] == 'true' ) {
										?>
                                        <div class="cafe-wrap-avatar">
                                            <img src="<?php echo esc_url( $ava['url'] ); ?>"
                                                 alt="<?php $content['author']; ?>" class="cafe-testimonial-avatar"/>
                                        </div>
									<?php } ?>
                                    <div class="cafe-wrap-author-info">
										<?php
										if ( $content['author'] != '' ) { ?>
                                            <h4 class="cafe-testimonial-author"><?php
												echo esc_html( $content['author'] ); ?>
                                            </h4>
										<?php } ?>
										<?php
										if ( $content['author_des'] != '' && $settings['show_des'] == 'true' ) { ?>
                                            <div class="cafe-testimonial-des"><?php
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
                        <article class=" <?php echo esc_attr( 'cafe-testimonial-' . $content['_id'] ) ?>">
                            <div class="cafe-wrap-content">
								<?php echo $quote; ?>
                                <div class="cafe-testimonial-content">
									<?php echo $content['testimonial_content']; ?>
									<?php if ( $settings['show_star'] == 'true' ) {
										?>
                                        <div class="cafe-testimonial-rate">
                                            <span class="cafe-rate-star stars-<?php echo esc_attr( $content['star']['size'] ) ?>"></span>
                                        </div>
										<?php
									}
									?>
                                </div>
                                <div class="cafe-wrap-testimonial-info">
									<?php
									$ava = $content['author_avatar'];
									if ( $ava['url'] != '' && $settings['show_avatar'] == 'true' ) {
										?>
                                        <div class="cafe-wrap-avatar">
                                            <img src="<?php echo esc_url( $ava['url'] ); ?>"
                                                 alt="<?php $content['author']; ?>" class="cafe-testimonial-avatar"/>
                                        </div>
									<?php } ?>
                                    <div class="cafe-wrap-author-info">
										<?php
										if ( $content['author'] != '' ) { ?>
                                            <h4 class="cafe-testimonial-author"><?php
												echo esc_html( $content['author'] ); ?>
                                            </h4>
										<?php } ?>
										<?php
										if ( $content['author_des'] != '' && $settings['show_des'] == 'true' ) { ?>
                                            <div class="cafe-testimonial-des"><?php
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
