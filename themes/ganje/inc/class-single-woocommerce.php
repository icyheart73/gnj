<?php

//add_filter('woocommerce_single_product_image_thumbnail_html','ganje_swiper_thumbnail',1,1);
//function ganje_swiper_thumbnail($attachment_id , $main_image = false){
//    echo 'A';
//}

add_action('woocommerce_product_thumbnails','ganje_swiper_thumbnail',10);
function ganje_swiper_thumbnail(){
    echo 'aaaaaaaaa';
}