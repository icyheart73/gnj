<?php
/**
 * Template for Slider widget
 *
 * @package CAFE\Templates
 * @copyright 2018 CleverSoft. All rights reserved.
 */

if ( empty( $settings['slides'] ) ) {
    return;
}

$button_class='cafe-button cafe-slide-btn ';
if ( ! empty( $settings['button_size'] ) ) {
	$button_class.='elementor-size-' . $settings['button_size'].' ';
}

$slides = [];
$slide_count = 0;



$sliderList = $settings['slides'];
//var_dump($sliderList);

$show_dots = $settings['show_dots']=='yes'?true:false;
$show_arrows = $settings['show_arrows']=='yes'?true:false;

?>
<!-- Swiper -->
<div class="swiper-container ibenzz_slider">
    <div class="swiper-wrapper">
        <?php
        $slide_count = 0;
        foreach ( $sliderList as $slide ) {



        $slide_url = $slide['link']['url'];
        if ( ! empty( $slide_url ) ) {
	        $this->add_render_attribute( 'slide_liink' . $slide_count, 'href', $slide_url );

	        if ( $slide['link']['is_external'] ) {
		        $this->add_render_attribute( 'slide_liink' . $slide_count, 'target', '_blank' );
	        }
        }
	        $slide_link = $this->get_render_attribute_string('slide_liink' . $slide_count );

            $output .= '<div class="swiper-slide elementor-repeater-item-'.$slide['_id'].' .swiper-slide">';
	        $output .='<a class="slide_liink' . $slide_count.'"'.$slide_link.'><div class="bg-banner"></div></a>';
	        $output .='<div class="cafe-slide-bg-overlay"></div>';
	        $output .='<div class="cafe-slide-heading">'.$slide['heading'].'<br/>'.$slide['description'];
	        $output .= '</div></div>';
	        $slide_count++;
        }

        echo $output;
        ?>

    </div>
    <!-- Add Arrows -->


    <?php
    if ( $show_arrows ) {
    echo '<div class="swiper-button-next"></div>';
    echo  '<div class="swiper-button-prev"></div>';
    }?>


    <!-- Add Pagination -->
   <?php if ( $show_dots ) {
     echo '<div class="swiper-pagination"></div></div>';
    }
    ?>
<?php
    $this->admin_editor_js = "<script>var swiper = new Swiper('.ibenzz_slider', {
    pagination: {
        el: '.swiper-pagination',
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
});</script>";
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
	add_action( 'elementor/frontend/after_enqueue_scripts', $this->editor_js() );
}


