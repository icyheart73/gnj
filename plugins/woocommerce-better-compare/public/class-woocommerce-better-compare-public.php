<?php

class WooCommerce_Better_Compare_Public extends WooCommerce_Better_Compare {

	protected $plugin_name;

	protected $version;

	public function __construct( $plugin_name, $version )
	{
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	public function enqueue_styles()
	{
		global $woocommerce_better_compare_options;

		$this->options = $woocommerce_better_compare_options;

		if (!$this->get_option('enable')) {
			return false;
		}

		wp_enqueue_style($this->plugin_name.'-public', plugin_dir_url(__FILE__).'css/woocommerce-better-compare-public.css', array(), $this->version, 'all');
		wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', array(), '4.7.0', 'all');
		wp_enqueue_style('slick', plugin_dir_url(__FILE__).'vendor/slick/slick.css', array(), $this->version, 'all');

		$css = "";
		$compareBarPosition = 'bottom';
		$compareBarBackgroundColor = $this->get_option('compareBarBackgroundColor');
		$compareBarHeight = '200';
		$compareBarItemWidth = '200';
		$compareBarItemHeight = '100';
		$compareBarTextColor = '#333';

		$css .= '.woocommerce-compare-bar {
			' . $compareBarPosition . ': 0;
			color: ' . $compareBarTextColor . ';
		}';

		$css .= '.woocommerce-compare-bar, .woocommerce-compare-bar-item a, .woocommerce-compare-bar-item a:hover {
			color: ' . $compareBarTextColor . ';
		}';

		if($compareBarPosition == "top") {
		    $css .= '.woocommerce-compare-bar-open-close-container {
				bottom: -32px;
			}';
			$css .= '.woocommerce-compare-bar-open-close {
				    border-radius: 0 0 15px 15px;
				}';
		}elseif($compareBarPosition == "bottom") {
		    $css .= '.woocommerce-compare-bar-open-close-container {
				top: -32px;
			}';
			$css .= '.woocommerce-compare-bar-open-close {
				    border-radius: 15px 15px 0 0;
				}';
		}

		$css .= 'a.woocommerce-compare-bar-action-clear, a.woocommerce-compare-bar-action-clear:hover {
			color: ' . $compareBarTextColor . ';
		}';


		$css .= '.woocommerce-compare-bar-items {
			height: ' . $compareBarHeight . 'px;
		}';

		$css .= '.woocommerce-compare-bar-item {
			max-width: ' . $compareBarItemWidth . 'px;
			width: ' . $compareBarItemWidth . 'px;
			height: ' . $compareBarItemHeight . 'px;
		}';

		$css .= '.woocommerce-compare-bar-open-close, .woocommerce-compare-bar-items {
			background-color: ' . $compareBarBackgroundColor['rgba'] . ';
			color: ' . $compareBarTextColor . ';
		}';


		$compareTableTextColor = $this->get_option('compareTableTextColor');
		$compareTableBackgroundColor = $this->get_option('compareTableBackgroundColor');
		$compareTableOddBackgroundColor = $this->get_option('compareTableOddBackgroundColor');
		$compareTableEvenBackgroundColor = $this->get_option('compareTableEvenBackgroundColor');
		$compareTableHighlightBackgroundColor = $this->get_option('compareTableHighlightBackgroundColor');

		$css .= '.woocommerce-compare-table-container {
			color: ' . $compareTableTextColor . ';
			background-color: ' . $compareTableBackgroundColor['rgba'] . ';
		}';

		$css .= '.woocommerce-compare-table-container .compare-table-row:nth-child(even) {
			background-color: ' . $compareTableEvenBackgroundColor['rgba'] . ';
		}';

		$css .= '.woocommerce-compare-table-container .compare-table-row:nth-child(odd) {
			background-color: ' . $compareTableOddBackgroundColor['rgba'] . ';
		}';

		$css .= '.woocommerce-compare-table-container .compare-table-row .compare-table-highlight  {
			background-color: ' . $compareTableHighlightBackgroundColor['rgba']. ';
		}';

		$css .= '.woocommerce-compare-table-close {
			color: ' . $compareTableTextColor . ';
		}';

		$compareSingleTableTextColor = $this->get_option('compareSingleTableTextColor');
		$compareSingleTableOddBackgroundColor = $this->get_option('compareSingleTableOddBackgroundColor');
		$compareSingleTableEvenBackgroundColor = $this->get_option('compareSingleTableEvenBackgroundColor');
		$compareSingleTableHighlightBackgroundColor = $this->get_option('compareSingleTableHighlightBackgroundColor');

		$css .= '.woocommerce-single-compare-table-container {
			color: ' . $compareSingleTableTextColor . ';
		}';

		$css .= '.woocommerce-single-compare-table-container .single-product-compare-value.even, 
				.woocommerce-single-compare-table-container .single-product-compare-key-column.even {
			background-color: ' . $compareSingleTableOddBackgroundColor['rgba'] . ';
		}';

		$css .= '.woocommerce-single-compare-table-container .single-product-compare-value.oddd, 
				.woocommerce-single-compare-table-container .single-product-compare-key-column.oddd {
			background-color: ' . $compareSingleTableEvenBackgroundColor['rgba'] . ';
		}';

		$css .= '.woocommerce-single-compare-table-container .single-product-compare-value.compare-table-highlight, 
				.woocommerce-single-compare-table-container .single-product-compare-key-column.compare-table-highlight  {
			background-color: ' . $compareSingleTableHighlightBackgroundColor['rgba']. ';
		}';

		$customCSS = $this->get_option('customCSS');
		$css = $css . $customCSS;

		file_put_contents( dirname(__FILE__)  . '/css/woocommerce-better-compare-custom.css', $css);

		wp_enqueue_style( $this->plugin_name.'-custom', plugin_dir_url( __FILE__ ) . 'css/woocommerce-better-compare-custom.css', array(), $this->version, 'all');
	}

	public function enqueue_scripts()
	{
		global $woocommerce_better_compare_options;

		$this->options = $woocommerce_better_compare_options;

		if (!$this->get_option('enable')) {
			return false;
		}

		wp_enqueue_script('slick', plugin_dir_url(__FILE__).'vendor/slick/slick.min.js', array('jquery'), $this->version, true);
		wp_enqueue_script('matchHeight', plugin_dir_url(__FILE__).'vendor/jquery-match-height/jquery.matchHeight.js', array('jquery'), '0.7.2', true);
		wp_enqueue_script($this->plugin_name.'-public', plugin_dir_url(__FILE__).'js/woocommerce-better-compare-public.js', array('jquery', 'slick', 'matchHeight'), $this->version, true);


        $forJS['ajax_url'] = admin_url('admin-ajax.php');
        $forJS['trans'] = $this->get_translations();
        $forJS['maxProducts'] = $woocommerce_better_compare_options['maxProducts'];
        // $forJS['enableDraggable'] = $woocommerce_better_compare_options['enableDraggable'];
        wp_localize_script($this->plugin_name . '-public', 'woocommerce_better_compare_options', $forJS);
	}


    public function init()
    {
        global $woocommerce_better_compare_options;
        $this->options = $woocommerce_better_compare_options;

		if (!$this->get_option('enable')) {
			return false;
		}

		$shopLoopCompareButtonPosition = 'woocommerce_after_shop_loop_item';
		!empty($shopLoopCompareButtonPosition) ? $shopLoopCompareButtonPosition = $shopLoopCompareButtonPosition : $shopLoopCompareButtonPosition = 'woocommerce_after_shop_loop_item';

		$shopLoopCompareButtonPriority = '10';

		add_action($shopLoopCompareButtonPosition, array($this, 'compare_button'), $shopLoopCompareButtonPriority);
    }

	public function compare_button()
	{
		global $product;

		if(!is_object($product)) {
			return false;
		}

		$show_add_to_compare = apply_filters('woocommerce_better_compare_show_add_to_compare_button', true, $product);
		if(!$show_add_to_compare) {
			return false;
		}

		$add_to_compare = 'افزودن به لیست مقایسه';

		$html = '<a href="#" class="button add-to-compare-button btn button btn-default theme-button theme-btn" data-product-id="' . $product->get_id() . '" rel="nofollow"><span class="add-to-compare-text">' . $add_to_compare . '</span></a>';

		echo $html;
	}

	public function compare_button_shortcode($atts)
	{
		$args = shortcode_atts( array(
	        'product' => '',
	    ), $atts );

		$product_id = absint($args['product']);

		if(empty($product_id)) {
			global $product;

		} else {
			 $product = wc_get_product($product_id);
		}

		if(!is_object($product)) {
			return false;
		}

		$add_to_compare = 'افزودن به لیست مقایسه';

		$html = '<a href="#" class="button add-to-compare-button btn button btn-default theme-button theme-btn" data-product-id="' . $product->get_id() . '" rel="nofollow">' . $add_to_compare . '</a>';

		echo $html;
	}


	public function maybe_show_compare_button_on_single_product()
	{
		if (!$this->get_option('enable')) {
			return false;
		}

		global $product;

		if(!is_product()) {
			return;
		}

		// Custom Button
		if(!$this->get_option('displayButtonOnProductPage')) {
			return false;
		}

		$show_add_to_compare = apply_filters('woocommerce_better_compare_show_add_to_compare_button', true, $product);
		if(!$show_add_to_compare) {
			return false;
		}

        $buttonPosition = 'woocommerce_product_meta_start';
        !empty($buttonPosition) ? $buttonPosition = $buttonPosition : $buttonPosition = 'woocommerce_single_product_summary';
        $displayButtonOnProductPagePriority = '30';

		add_action( $buttonPosition, array($this,'show_compare_button_on_single_product'), $displayButtonOnProductPagePriority );
	}

	public function show_compare_button_on_single_product()
	{
		global $product;

		$add_to_compare = 'افزودن به لیست مقایسه';

		$html = '<a href="#" class="button add-to-compare-button btn button btn-default theme-button theme-btn" data-product-id="' . $product->get_id() . '" rel="nofollow">' . $add_to_compare . '</a>';

		echo $html;
	}

	public function compare_products_shortcode($atts)
	{
		$args = shortcode_atts( array(
	        'products' => '',
	        'slidestoshow' => $this->get_option('singleCompareTableSliderSlidesToShow'),
	    ), $atts );

	    $products = $args['products'];
	    $sliderSlidesToShow = intval($args['slidestoshow']);

	    if(empty($products)) {
	    	if(isset($_COOKIE['compare_products_products']) && !empty($_COOKIE['compare_products_products'])) {
	    		$products = json_decode(stripslashes($_COOKIE['compare_products_products']), true);
	    	} elseif(isset($_GET['compare']) && !empty($_GET['compare'])) {
	    		$products = explode(',', $_GET['compare']);
	    	}
	    } else {
	    	$products = explode(',', $products);
	    }

	    if(!isset($products)|| empty($products)) {
	    	return __('No Products defined.', 'woocommerce-better-compare');
	    }

		$sliderSlidesToScroll = $this->get_option('singleCompareTableSliderSlidesToScroll');
		$sliderDots = $this->get_option('singleCompareTableSliderDots');
		$sliderArrows = $this->get_option('singleCompareTableSliderArrows');
		$sliderInfinite = $this->get_option('singleCompareTableSliderInfinite');

		$slick_data = array(
			'slidesToShow' => $sliderSlidesToShow,
			'slidesToScroll' => intval($sliderSlidesToScroll),
			'dots' => $sliderDots == "1" ? true : false,
			'arrows' => $sliderArrows == "1" ? true : false,
			'infinite' => $sliderInfinite == "1" ? true : false,
			'responsive' => array(
				array(
					'breakpoint' => 600,
					'settings' => array(
						'slidesToShow' => 2,
						'slidesToScroll' => 1
					)
				),
				array(
					'breakpoint' => 480,
					'settings' => array(
						'slidesToShow' => 1,
						'slidesToScroll' => 1
					)
				),
			),
		);

		$data_to_compare = $this->get_data_to_compare($products);

		// $args = array( 'posts_per_page' => -1, 'post_type' => 'attribute_group', 'post_status' => 'publish', 'orderby' => 'menu_order', 'suppress_filters' => 0);
		// $attribute_groups = get_posts( $args );
		// $attribute_taxonomies = wc_get_attribute_taxonomies();
		// $attribute_groups_for_compare = array();

		// if(!empty($attribute_groups)) {
		// 	foreach ($attribute_groups as $attribute_group) {

		// 		$attributes_in_group = get_post_meta($attribute_group->ID, 'woocommerce_group_attributes_attributes');
		// 		if(is_array($attributes_in_group[0])) {
		// 			$attributes_in_group = $attributes_in_group[0];
		// 		}

		// 		if(!empty($attributes_in_group)) {

		// 			$attribute_groups_for_compare[$attribute_group->ID] = array(
		// 				'name' => $attribute_group->post_title
		// 			);

		// 			foreach ($attributes_in_group as $attributes_in_group_id) {

		// 				foreach ($attribute_taxonomies as $key => $value) {

		// 					if($value->attribute_id == $attributes_in_group_id) {
		// 						$slug = $value->attribute_name;
		// 						$attribute_groups_for_compare[$attribute_group->ID][] = 'attr-' . $slug;
		// 					}
		// 				}
		// 			}
		// 		}
		// 	}

		// 	$oldData = $data_to_compare;
		// 	var_dump($oldData);
		// 	var_dump($attribute_groups_for_compare);
		// 	foreach ($attribute_groups_for_compare as $attribute_group_for_compare) {
		// 		$keyAdded = false;
		// 		foreach ($data_to_compare as $key => $value) {
		// 			if(in_array($key, $attribute_group_for_compare) ) {
		// 				unset($data_to_compare[$key]);

		// 				if(!$keyAdded) {
		// 					$data_to_compare[$]
		// 				}
		// 			}
		// 		}
		// 	}
		// }

	 	return $this->get_shortcode_compare_table($data_to_compare, $slick_data);
	}

	public function compare_bar()
	{
		if (!$this->get_option('enable')) {
			return false;
		}

		$html = "";
		$html .= $this->get_compare_table();



		$compare_now = __('Compare Now', 'woocommerce-better-compare');
		$clear_all = __('Clear All', 'woocommerce-better-compare');
		$compare_products = __('Compare Products', 'woocommerce-better-compare');


		$maxProducts = $this->get_option('maxProducts');
		$compareBarPage = $this->get_option('compareBarPage');
		if(!empty($compareBarPage)) {
			$compareBarPage = get_permalink($compareBarPage);
		} else {
			$compareBarPage = '#';
		}

		$html .= '<div id="woocommerce-compare-bar" class="woocommerce-compare-bar">';

			$html .= '<div id="woocommerce-compare-bar-open-close-container" class="woocommerce-compare-bar-open-close-container">';
				$html .= '<a href="#" id="woocommerce-compare-bar-open-close" class="woocommerce-compare-bar-open-close">' . $compare_products . ' <i class="fa fa-angle-double-up"></i></a>';
			$html .= '</div>';

			$html .= '<div id="woocommerce-compare-bar-items" class="woocommerce-compare-bar-items" style="display: none;">';

				for ($i=0; $i < $maxProducts; $i++) {
					$html .= $this->get_single_item();
				}

				// Compare Bar Actions
				$html .= '<div id="woocommerce-compare-bar-actions" class="woocommerce-compare-bar-actions">';
					$html .= '<a href="#" id="woocommerce-compare-bar-action-clear" class="woocommerce-compare-bar-action-clear clear-all-compared-products">' . $clear_all . ' <i class="fa fa-times"></i></a>';
					$html .= '<a href="' . $compareBarPage . '" id="woocommerce-compare-bar-action-compare" class="woocommerce-compare-table-action-compare">' . $compare_now . ' <i class="fa fa-chevron-right"></i></a>';
				$html .= '</div>';

			$html .= '</div>';

		$html .= '</div>';

		echo $html;
	}

	protected function get_single_item()
	{
		$html = "";
		$html .= '<div class="woocommerce-compare-bar-item-container woocommerce-compare-bar-item-placeholder">';
			$html .= '<div class="woocommerce-compare-bar-item">';

			$html .= '</div>';
		$html .= '</div>';

		return $html;
	}

	protected function get_shortcode_compare_table($product_data = array(), $slick_data)
	{
		$translations = $this->get_translations();

		$hide_similarities = __('Hide Similarities', 'woocommerce-better-compare');
		$highlight_differences = __('Highlight Differences', 'woocommerce-better-compare');

		$showAttrNameInColumn = $this->get_option('singleCompareTableShowAttrNameInColumn');
		$showAttrNameInColumnCSS = $showAttrNameInColumn ? ' has-keys-column' : '';

		$html = "";
		$html .= '<div id="woocommerce-single-compare-table-container" class="woocommerce-single-compare-table-container ' . $showAttrNameInColumnCSS . '">';

			if($this->get_option('singleCompareTableHideSimilarities')) {
				$html .= '<label><input type="checkbox" class="woocommerce-compare-table-hide-similarities" name="hide_similarities" value="1">' . $hide_similarities . '</label><br>';
			}
			if($this->get_option('singleCompareTableHighlightDifferences')) {
				$html .= '<label><input type="checkbox" class="woocommerce-compare-table-highlight-differences" name="highlight_differences" value="1">' . $highlight_differences . '</label> ';
			}



			$first = true;
			foreach ($product_data as $product_id => $single_product_data) {

				// Attribute in First Column
				if($showAttrNameInColumn && $first) {
					$html .= '<div class="single-product-compare-keys">';
					foreach ($single_product_data as $data_key => $data_value) {
						$html .= '<div class="single-product-compare-key-column ' . (++$count%2 ? "oddd" : "even") . ' single-product-compare-value-' . $data_key . '"><b>' . $translations[$data_key] . '</b></div>';
					}
					$html .= '</div>';

				}

				if($first) {
					$html .= '<div id="woocommerce-single-compare-table" class="woocommerce-single-compare-table woocommerce-single-compare-table-slick" data-slick=' . json_encode($slick_data) . '>';
					$first = false;
				}

				$html .= '<div class="single-product-compare-column single-product-compare-column-' . $product_id . '">';

				$count = 0;
				foreach ($single_product_data as $data_key => $data_value) {

					if($data_key == "im") {
						if(isset($product_data['ti'][$data_key])) {
							$data_value = '<a href="' . get_permalink($product_id) . '"><img src="' . $data_value . '" alt="' . $product_data['ti'][$data_key] . '"></a>';
						} else {
							$data_value = '<a href="' . get_permalink($product_id) . '"><img src="' . $data_value . '" alt=""></a>';
						}
					}

					if($showAttrNameInColumn) {
						$html .= '<div class="single-product-compare-value ' . (++$count%2 ? "oddd" : "even") . ' single-product-compare-value-' . $data_key . '">' . $data_value . '</div>';
					} else {
						$html .= '<div class="single-product-compare-value ' . (++$count%2 ? "oddd" : "even") . ' single-product-compare-value-' . $data_key . '"><span class="single-product-compare-key">' . $translations[$data_key] . '</span>' . $data_value . '</div>';
					}


				}

				$html .= '</div>';
			}
			$html .= '</div>';
		$html .= '</div>';

		return $html;
	}

	protected function get_compare_table()
	{
		$hide_similarities = __('Hide Similarities', 'woocommerce-better-compare');
		$highlight_differences = __('Highlight Differences', 'woocommerce-better-compare');

		$html = "";
		$html .= '<div id="woocommerce-compare-table-container" class="woocommerce-compare-table-container compare-table-grid" style="display: none;">';

			if($this->get_option('hideSimilarities')) {
				$html .= '<label><input type="checkbox" class="woocommerce-compare-table-hide-similarities" name="hide_similarities" value="1">' . $hide_similarities . '</label><br>';
			}


			$html .= '<a href="#" id="woocommerce-compare-table-close" class="woocommerce-compare-table-close"><i class="fa fa-times"></i></a>';
			$html .= '<div id="woocommerce-compare-table" class="woocommerce-compare-table">';

				// if(!empty($product_data)) {
				// 	$translations = $this->get_translations();
				// 	foreach ($product_data as $key => $single_product_data) {
				// 		$html .= '<tr>';
				// 			$html .= '<th>' . $translations[$key] . '</th>';

				// 			foreach ($single_product_data as $single_product_data_values) {
				// 				$html .= '<td>' . $single_product_data_values . '</td>';
				// 			}

				// 		$html .= '</tr>';
				// 	}
				// }

			$html .= '</div>';
		$html .= '</div>';

		return $html;
	}

    public function get_single_product()
    {
        if (!defined('DOING_AJAX') || !DOING_AJAX) {
        	header('HTTP/1.1 400 No AJAX call', true, 400);
            die();
        }

        if (!isset($_POST['product'])) {
            header('HTTP/1.1 400 No product ID', true, 400);
            die();
        }

        $product_id = intval($_POST['product']);
        if(!wc_get_product($product_id)) {
        	// $products_in_cookie = json_decode( stripslashes( $_COOKIE['compare_products_products']), true );
        	header('HTTP/1.1 400 No Product found', true, 400);
        	die();
        }

        $imageSize ='woocommerce_thumbnail';
        if(!empty($imageSize)) {
        	$img = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), $imageSize );
        } else {
        	$img = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'full' );
        }

        $product 		= new stdClass();
        $product->img	= (isset($img[0]) && !empty($img[0])) ?  $img[0] : wc_placeholder_img_src();
        $product->title	= get_the_title($product_id);
        $product->ID	= $product_id;
        $product->url	= get_permalink($product_id);

        echo json_encode($product, JSON_FORCE_OBJECT);
        die();
	}

	public function get_all_products()
	{
        if (!defined('DOING_AJAX') || !DOING_AJAX) {
        	header('HTTP/1.1 400 No AJAX call', true, 400);
            die();
        }

        if (!isset($_POST['products'])) {
            header('HTTP/1.1 400 No products found', true, 400);
            die();
        }

		$products = array_filter($_POST['products']);

		$productData = array();
		if(!empty($products)) {

			$dataToCompare = $this->get_option('dataToCompare');
			$notAvailableText = 'در دسترس نمی باشد';
			$dataToCompare = $dataToCompare['enabled'];
			unset($dataToCompare['placebo']);

			foreach ($dataToCompare as $key => $value) {
				foreach ($products as $product_id) {

					$output_key = $key;
					if(strpos($key, 'attr') === false && strpos($key, 'tx') === false && strpos($key, 'group') === false && strpos($key, 'mt') === false) {
						$output_key = substr($key, 0, 2);
					}
					$product_id = intval($product_id);
					$product = wc_get_product($product_id);
					if(!$product) {
						continue;
					}

					$data = $this->get_product_data($product, $key);

					$productData[$output_key][$product_id] = !empty($data) ? $data : $notAvailableText;
				}
			}

		 	foreach ($productData as $key => $value) {
		 		if (count(array_unique($value)) === 1 && end($value) === $notAvailableText) {
		 			unset($productData[$key]);
		 		}
		 	}
		}


		// $args = array( 'posts_per_page' => -1, 'post_type' => 'attribute_group', 'post_status' => 'publish', 'orderby' => 'menu_order', 'suppress_filters' => 0);
		// $attribute_groups = get_posts( $args );
		// $attribute_taxonomies = wc_get_attribute_taxonomies();
		// $attribute_groups_for_compare = array();

		// if(!empty($attribute_groups)) {
		// 	foreach ($attribute_groups as $attribute_group) {

		// 		$attributes_in_group = get_post_meta($attribute_group->ID, 'woocommerce_group_attributes_attributes');
		// 		if(is_array($attributes_in_group[0])) {
		// 			$attributes_in_group = $attributes_in_group[0];
		// 		}

		// 		if(!empty($attributes_in_group)) {

		// 			$attribute_groups_for_compare[$attribute_group->ID] = array(
		// 				'name' => $attribute_group->post_title
		// 			);

		// 			foreach ($attributes_in_group as $attributes_in_group_id) {

		// 				foreach ($attribute_taxonomies as $key => $value) {

		// 					if($value->attribute_id == $attributes_in_group_id) {
		// 						$slug = $value->attribute_name;
		// 						$attribute_groups_for_compare[$attribute_group->ID][] = 'attr-' . $slug;
		// 					}
		// 				}
		// 			}
		// 		}
		// 	}

		// 	$oldData = $productData;

		// 	foreach ($attribute_groups_for_compare as $attribute_group_for_compare) {
		// 		foreach ($productData as $key => $value) {
		// 			if(in_array($key, $attribute_group_for_compare) ) {
		// 				$productData
		// 			}
		// 		}
		// 	}
		// }

		echo json_encode($productData, JSON_FORCE_OBJECT);
		die();
	}

	private function filter_array(&$array)
	{
	    foreach ( $array as $key => $item ) {
	        is_array ( $item ) && $array [$key] = $this->filter_array ( $item );
	        if (empty ( $array [$key] ))
	            unset ( $array [$key] );
	    }
	    return $array;
	}

	protected function get_product_data($prod, $key)
	{
		global $product;

		if(!is_object($prod)) {
			return false;
		}

		$product = $prod;

		$data = "";
		$product_id = $product->get_id();

		// Image
		if($key == "im") {
	        $imageSize = $this->get_option('dataToCompareImageSize');
	        if(!empty($imageSize)) {
	        	$img = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), $imageSize );
	        } else {
	        	$img = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'full' );
	        }
			$data =  (isset($img[0]) && !empty($img[0])) ?  $img[0] : wc_placeholder_img_src();

		// Title
		} elseif($key == "ti") {
			$data = get_the_title($product_id);

		// Ratings
		} elseif($key == "re") {
			$rating_count = $product->get_rating_count();
			$review_count = $product->get_review_count();
			$average      = $product->get_average_rating();
			$data = wc_get_rating_html($average, $rating_count);

		// Variations
		} elseif($key == "va") {
			if($product->is_type( 'variable' )) {
				$aval_variations = $product->get_available_variations();
				$variation_html = "";
				if(!empty($aval_variations)) {
					foreach ($aval_variations as $variation) {
						$variation_attributes = $variation['attributes'];
						foreach ($variation_attributes as $variation_attribute_key => $variation_attribute) {;
	                        if (strpos($variation_attribute_key, '_pa_')){ // variation is a pre-definted attribute
	                            $variation_attribute_key = substr($variation_attribute_key, 10);
	                            $attr = get_term_by('slug', $variation_attribute, $variation_attribute_key);
	                            $variation_attribute = $attr->name;
	                        } else { // variation is a custom attribute
	                            $attr = maybe_unserialize( get_post_meta( $post->ID, '_product_attributes' ) );

	                            $attr = get_term_by('slug', $variation_attribute, $variation_attribute_key);
	                            $variation_attribute = $attr->name;
	                        }
	                        $attr_label = wc_attribute_label($attr->taxonomy);
	                        $variation_html .= $attr_label . ': ' . $variation_attribute . '<br>';
                        }
					}
					$data = $variation_html;
				}
			}

		// Price
		} elseif($key == "pr") {
			$data = $product->get_price_html();

		// SKU
		} elseif($key == "sk") {
			$data = $product->get_sku();

		// Excerpt (Short Description)
		} elseif($key == "ex") {
			$data = $product->get_short_description();

				$data = do_shortcode($data);

		// Description
		} elseif($key == "de") {
			$data = $product->get_description();

				$data = do_shortcode($data);


		// Dimensions
		} elseif($key == "di") {
			$data = wc_format_dimensions($product->get_dimensions(false));

		// Weight
		} elseif($key == "we") {
			if(!empty($product->get_weight())) {
				$data = $product->get_weight() . get_option('woocommerce_weight_unit');
			}

		// Add to Cart
		} elseif($key == "ca") {
 			ob_start();
			do_action( 'woocommerce_' . $product->get_type() . '_add_to_cart' );
	        $output_string = ob_get_contents();
	        ob_end_clean();
			$data = $output_string;

		// Read More
		} elseif($key == "rm") {
			$url = get_permalink($product_id);
			$data = '<a href="' . $url . '" class="woocommerce-better-compare-read-more btn button btn-default theme-button theme-btn">' . __('Read More', 'woocommerce-better-compare') . '</a>';

		// Get Stock Status
		} elseif($key == "st") {
			$data = $product->get_stock_status();

		// Get Attributes
		} elseif(strpos($key, 'attr') !== false) {

			$attribute_slug = substr($key, 5);
			$attribute_value = $product->get_attribute($attribute_slug);
			if(!empty($attribute_value)) {
				$data = $attribute_value;
			}
		// Get Attribute Group Name
		} elseif(strpos($key, 'group') !== false) {

			$enableGroupedAttributes = $this->get_option('enableGroupedAttributes');

			$group_id = substr($key, 6);
			$attr_found = array();

			$attributes_in_group = get_post_meta($group_id, 'woocommerce_group_attributes_attributes');

			if(is_array($attributes_in_group[0])) {
				$attributes_in_group = $attributes_in_group[0];
			}

			$product_attributes = $product->get_attributes();
			if(!empty($product_attributes) && !empty($attributes_in_group) && $enableGroupedAttributes) {
				foreach ($product_attributes as $product_attribute) {
					$attr_id = $product_attribute->get_id();
					if(in_array($attr_id, $attributes_in_group)){
						$data = '&nbsp;';
						break;
					}
				}
			}

		// Taxonomies
		} elseif(strpos($key, 'tx') !== false) {
			$tax_id = substr($key, -1);
			$taxonomy_name = $this->get_option('dataToCompareTaxonomy' . $tax_id);
			if($taxonomy_name) {
				$data = get_the_term_list($product_id, $taxonomy_name, '', ', ');

				if($this->get_option('dataToCompareTaxonomyNoLinks'. $tax_id)) {
					$data = strip_tags($data);
				}
			}
		// Custom Meta fields
		} elseif(strpos($key, 'mt') !== false) {
			$tax_id = substr($key, -1);
			$meta_key = $this->get_option('dataToCompareMeta' . $tax_id);
			if($meta_key) {
				$data = get_post_meta($product_id, $meta_key, true);
			}
		}
		wp_reset_postdata();
		return $data;
	}

	protected function get_translations()
	{
		$translations = array(
			'im' => '',
			'ti' => 'عنوان',
			're' => 'نظرات',
			'va' => 'متغیرها',
			'pr' => 'قیمت',
			'sk' => 'شناسه کالا',
			'ex' => 'توضیحات کوتاه',
			'de' => 'توضیحات',
			'di' => 'ابعاد',
			'we' => 'وزن',
			'st' => 'موجودی',
			'ca' => '',
			'rm' => '',
			'add' => '<span class="add-to-compare-text">' .'افزودن به لیست مقایسه' . '</span>',
			'max' => 'حداکثر تعداد محصول وارد شده است',
			'remove' => '<span class="remove-from-compare-text">' . 'حذف از لیست مقایسه'. '</span>',
		);

		$atts = wc_get_attribute_taxonomies();
	    if(!empty($atts)) {
	        foreach ($atts as $value) {
	            $translations['attr-' . $value->attribute_name] = __($value->attribute_label);
	        }
	    }

	    // Attribute Groups
	    $args = array( 'posts_per_page' => -1, 'post_type' => 'attribute_group', 'post_status' => 'publish', 'orderby' => 'menu_order', 'suppress_filters' => 0);
	    $attribute_groups = get_posts( $args );

	    if(!empty($attribute_groups)) {
	        foreach ($attribute_groups as $attribute_group) {
	            $translations['group-' . $attribute_group->ID] = __($attribute_group->post_title);
	        }
	    }

		return $translations;
	}

	public function single_product_page()
	{

		if (!$this->get_option('enable')) {
			return false;
		}

		$productPage = '1';
		if($productPage) {
			$productPagePosition = 'woocommerce_after_single_product_summary';
			$productPagePriority = '5';
			add_action($productPagePosition, array($this, 'display_compare_products'), $productPagePriority);
		}
	}

	public function display_compare_products()
	{ /*
		global $product;

		if(!is_object($product)) {
			return;
		}

		$product_categories = $product->get_category_ids();
		if(empty($product_categories)) {
			return;
		}

		$maxProducts = $this->get_option('displayProductPageMaxProducts');

	    $args = array(
		    'post_type'             => 'product',
		    'post_status'           => 'publish',
		    'ignore_sticky_posts'   => 1,
		    'posts_per_page'        => $maxProducts,
		    'post__not_in'        => array( $product->get_id() ),
		    'tax_query'             => array(
		        array(
		            'taxonomy'      => 'product_cat',
		            'field' 		=> 'term_id',
		            'terms'         =>  $product_categories, // 26,
		            'operator'      => 'IN'
		        ),
		        array(
		            'taxonomy'      => 'product_visibility',
		            'field'         => 'slug',
		            'terms'         => 'exclude-from-catalog', // Possibly 'exclude-from-search' too
		            'operator'      => 'NOT IN'
		        )
		    )
		);

	    $args = apply_filters('woocommerce_better_compare_single_product_compare_products_query_args', $args, $product);

		$products = new WP_Query($args);

		if(!isset($products->posts) || empty($products->posts)) {
			return;
		}

		$products = $products->posts;
		array_unshift($products, $product->get_id());

		$html = "";

		$title = $this->get_option('displayProductPageTitle');
		if(!empty($title)) {
			$html .= '<h2 class="woocommerce-compare-single-product-title">' . $title . '</h2>';
		}

		$text = $this->get_option('displayProductPageText');
		if(!empty($text)) {
			$html .= '<p class="woocommerce-compare-single-product-desc">' . $text . '</p>';
		}

		$sliderSlidesToShow = $this->get_option('displayProductPageSliderSlidesToShow');
		$sliderSlidesToScroll = $this->get_option('displayProductPageSliderSlidesToScroll');
		$sliderDots = $this->get_option('displayProductPageSliderDots');
		$sliderArrows = $this->get_option('displayProductPageSliderArrows');
		$sliderInfinite = $this->get_option('displayProductPageSliderInfinite');


		$slick_data = array(
			'slidesToShow' => intval($sliderSlidesToShow),
			'slidesToScroll' => intval($sliderSlidesToScroll),
			'dots' => $sliderDots == "1" ? true : false,
			'arrows' => $sliderArrows == "1" ? true : false,
			'infinite' => $sliderInfinite == "1" ? true : false,
			'responsive' => array(
				array(
					'breakpoint' => 600,
					'settings' => array(
						'slidesToShow' => 2,
						'slidesToScroll' => 1
					)
				),
				array(
					'breakpoint' => 480,
					'settings' => array(
						'slidesToShow' => 2,
						'slidesToScroll' => 1
					)
				),
			),
		);

		$product_data = $this->get_data_to_compare($products);

		$showAttrNameInColumn = $this->get_option('displayProductPageShowAttrNameInColumn');
		$showAttrNameInColumnCSS = $showAttrNameInColumn ? ' has-keys-column' : '';

		$html .= '<div class="single-product-compare ' . $showAttrNameInColumnCSS . '">';

		if(!empty($product_data)) {

			$translations = $this->get_translations();

			$first = true;
			foreach ($product_data as $product_id => $single_product_data) {

				// Attribute in First Column
				if($showAttrNameInColumn && $first) {
					$html .= '<div class="single-product-compare-keys">';
					foreach ($single_product_data as $data_key => $data_value) {
						$html .= '<div class="single-product-compare-key-column ' . (++$count%2 ? "oddd" : "even") . ' single-product-compare-value-' . $data_key . '"><b>' . $translations[$data_key] . '</b></div>';
					}
					$html .= '</div>';

				}

				if($first == true) {
					$html .= '<div id="single-product-compare-products-slick" class="single-product-compare-products-slick" data-slick=' . json_encode($slick_data) . '>';
					$html .= '<div class="single-product-compare-column single-product-compare-column-this-product single-product-compare-column-' . $product_id . '">';
				} else {
					$html .= '<div class="single-product-compare-column single-product-compare-column-' . $product_id . '">';
				}

				$count = 0;
				foreach ($single_product_data as $data_key => $data_value) {

					if($data_key == "im") {
						if(isset($product_data['ti'][$data_key])) {
							$data_value = '<a href="' . get_permalink($product_id) . '"><img src="' . $data_value . '" alt="' . $product_data['ti'][$data_key] . '"></a>';
						} else {
							$data_value = '<a href="' . get_permalink($product_id) . '"><img src="' . $data_value . '" alt=""></a>';
						}
					}
					if($data_key == "im" || $data_key == "ti") {
						if($first == true && $data_key == "ti") {
							$data_value = '<b class="single-product-compare-current-product"> ' . __('Current Product: ') . '</b>' . $data_value;
						}
						$html .= '<div class="single-product-compare-value ' . (++$count%2 ? "oddd" : "even") . ' single-product-compare-value-' . $data_key . '">' . $data_value . '</div>';
					} else {
						if($showAttrNameInColumn) {
							$html .= '<div class="single-product-compare-value ' . (++$count%2 ? "oddd" : "even") . ' single-product-compare-value-' . $data_key . '">' . $data_value . '</div>';
						} else {
							$html .= '<div class="single-product-compare-value ' . (++$count%2 ? "oddd" : "even") . ' single-product-compare-value-' . $data_key . '"><span class="single-product-compare-key">' . $translations[$data_key] . '</span>' . $data_value . '</div>';
						}

						// $html .= '<div class="single-product-compare-value ' . (++$count%2 ? "oddd" : "even") . ' single-product-compare-value-' . $data_key . '"><span class="single-product-compare-key">' . $translations[$data_key] . '</span>' . $data_value . '</div>';
					}

				}
				$html .= '</div>';
				$first = false;
			}
			$html .= '</div>';
		}

		$html .= '</div>';

		echo $html; */
	}

	public function get_data_to_compare($products)
	{
		$product_data = array();

		$data_to_compare = $this->get_option('displayProductPageDataToCompare');
		$notAvailableText = 'در دسترس نمی باشد';
		$data_to_compare = $data_to_compare['enabled'];
		unset($data_to_compare['placebo']);

		foreach ($products as $product) {

			if(is_object($product)) {
				$product_id = $product->ID;
			} else {
				$product_id = $product;
			}

			$product_id = intval($product_id);
			$product = wc_get_product($product_id);

			foreach ($data_to_compare as $key => $value) {

				$output_key = $key;
				if(strpos($key, 'attr') === false && strpos($key, 'tx') === false && strpos($key, 'group') === false && strpos($key, 'mt') === false) {
					$output_key = substr($key, 0, 2);
				}
				$data = $this->get_product_data($product, $key);

				$product_data[$product_id][$output_key] = !empty($data) ? $data : $notAvailableText;
			}
		}

		foreach ($data_to_compare as $key => $value) {
			$temp = array();
			foreach ($product_data as $product_id => $single_product_data_temp) {
				$temp[] = $single_product_data_temp[$key];
			}

	 		if (count(array_unique($temp)) === 1 && end($temp) === $notAvailableText) {
				foreach ($product_data as $product_id => $single_product_data_temp) {
					unset($product_data[$product_id][$key]);
				}

	 		}
		}

		return $product_data;
	}

	public function autocomplete_shortcode()
	{
        $html =
        '<div class="woocommerce-compare-autocomplete">' .
        	'<div class="woocommerce-compare-autocomplete-icon">' .
        		'<i class="fa fa-search"></i>' .
        	'</div>' .
    		'<div class="woocommerce-compare-autocomplete-input">' .
				'<input type="text" name="woocommerce-compare-autocomplete-field" class="woocommerce-compare-autocomplete-field" placeholder="' . __('Search by Product Name or SKU', 'woocommerce-better-compare') . '">' .
			'</div>' .
			'<div class="compare-table-row-clear"></div>' .
        '</div>' .
        '<div class="woocommerce-compare-autocomplete-message">' .
        	__('Press enter to search', 'woocommerce-better-compare') .
        '</div>';

        return $html;
	}


   	public function check_product()
   	{
   		$response = array(
   			'message' => __('No Product found ...', 'woocommerce-quick-view'),
   			'product' => '',
   		);

   		$skuOrProduct = $_POST['skuOrProduct'];

   		if(empty($skuOrProduct)) {
   			die(json_encode($response));
   		}

   		$bySKU = wc_get_product_id_by_sku($skuOrProduct);

   		if(!empty($bySKU)) {
   			$response['message'] = __('Product found!', 'woocommerce-quick-view');
   			$response['product'] = $bySKU;
   		} else {
   			if($this->get_option('popupUseSimpleSearch')) {
	   			$skuOrProduct = sanitize_title_for_query( $skuOrProduct );
		   		$byName = get_page_by_path($skuOrProduct, OBJECT, 'product' );

	   		} else {
	   			$byName = $this->search_product_by_name($skuOrProduct);
	   		}
	   		if(!empty($byName)) {
	   			$response['message'] = __('Product found!', 'woocommerce-quick-view');
	   			$response['product'] = $byName->ID;
	   		}
   		}

   		die(json_encode($response));
   	}

   	protected function search_product_by_name($title)
   	{
	    global $wpdb;
	    $title = esc_sql($title);

	    if(!$title) return;

	    $product = $wpdb->get_results("
	        SELECT * 
	        FROM $wpdb->posts
	        WHERE post_title LIKE '%$title%'
	        AND post_type = 'product' 
	        AND post_status = 'publish'
	        LIMIT 1
	    ");
	    if(isset($product[0])) {
	    	return $product[0];
	    } else {
	    	return false;
	    }
   	}
}
