<?php namespace GanjeAddonsForElementor\Widgets;

use Elementor\Frontend;
use Elementor\Widget_Base;
use InvalidArgumentException;

/**
 * GanjeWidgetBase
 *
 * @author GanjeSoft <hello.ganjesoft@gmail.com>
 * @package GNJE
 */
abstract class GanjeWidgetBase extends Widget_Base {
	/**
	 * @return array
	 */
	function get_categories() {
		return [ 'ganje-elements' ];
	}

	/**
	 * Get categories
	 *
	 * @param string $filter_categories
	 */
	protected function get_categories_for_gnje( $taxonomy, $select = 1 ) {

		$data = array();

		$query = new \WP_Term_Query( array(
			'hide_empty' => true,
			'taxonomy'   => $taxonomy,
		) );
		if ( $select == 1 ) {
			$data['all'] = 'All';
		}

		if ( ! empty( $query->terms ) ) {
			foreach ( $query->terms as $cat ) {
				$data[ $cat->slug ] = $cat->name;
			}
		}

		return $data;
	}

	/**
	 * Get parent categories
	 *
	 * @param string $filter_parent_categories
	 */
	protected function get_parent_categories_for_gnje( $taxonomy, $select = 1 ) {

		$data = array();

		$query = new \WP_Term_Query( array(
			'hide_empty' => true,
			'taxonomy'   => $taxonomy,
			'parent'     => 0
		) );
		if ( $select == 1 ) {
			$data['all'] = 'All';
		}

		if ( ! empty( $query->terms ) ) {
			foreach ( $query->terms as $cat ) {
				$data[ $cat->slug ] = $cat->name;
			}
		}

		return $data;
	}

	/**
	 * Get asset type
	 *
	 * @param string $select asset type
	 *
	 * @return  array
	 */
	protected function get_woo_asset_type_for_gnje( $select = 1 ) {
		if ( $select == 1 ) {
			$asset_type = array(
				'all'          => 'همه',
				'latest'       => 'جدیدترین ها',
				'featured'     =>  'ویژه ها',
				'onsale'       => 'حراج',
				'deal'         => 'آفرهای مدت دار',
				'best-selling' => 'پرفروش ترین ها',
				'toprate'      =>  'با ارزش ترین ها',
			);
		} else {
			$asset_type = array(
				'latest'       => 'جدیدترین ها',
				'featured'     =>  'ویژه ها',
				'onsale'       => 'حراج',
				'deal'         => 'آفرهای مدت دار',
				'best-selling' => 'پرفروش ترین ها',
				'toprate'      =>  'با ارزش ترین ها',
			);
		}

		return $asset_type;
	}

	/**
	 * Get oder by
	 *
	 * @return array oder_by
	 */
	protected function get_woo_order_by_for_gnje() {

		$order_by = array(
			'date'       => 'تاریخ',
			'menu_order' => 'منوی سفارش',
			'title'      => 'عنوان',
			'rand'       => 'تصادفی',
		);

		return $order_by;
	}

	/**
	 * Get oder
	 *
	 * @return array order
	 */
	protected function get_woo_order_for_gnje() {

		$order = array(
			'desc' => 'نزولی',
			'asc'  => 'صعودی',
		);

		return $order;
	}

	/**
	 * Get product
	 *
	 * @param string $post_type is post type
	 *
	 * @return array $results List post data.
	 */
	protected function get_list_posts( $post_type = 'post' ) {
		$args = array(
			'post_type'        => $post_type,
			'suppress_filters' => true,
			'posts_per_page'   => 300,
			'no_found_rows'    => true,
		);

		$the_query = new \WP_Query( $args );
		$results   = [];

		if ( is_array( $the_query->posts ) && count( $the_query->posts ) ) {
			foreach ( $the_query->posts as $post ) {
				$results[ $post->ID ] = sanitize_text_field( $post->post_title );
			}
		}

		return $results;
	}

	/**
	 * Get product deal
	 *
	 * @param string $post_type is post type
	 *
	 * @return array $results List post data.
	 */
	protected function get_list_product_deal() {
		$args                = array(
			'post_type'        => 'product',
			'suppress_filters' => true,
			'posts_per_page'   => 300,
			'no_found_rows'    => true,

		);
		$product_ids_on_sale = wc_get_product_ids_on_sale();
		$args['post__in']    = $product_ids_on_sale;
		$args['meta_query']  = array(
			'relation' => 'AND',
			array(
				'key'     => '_sale_price_dates_to',
				'value'   => time(),
				'compare' => '>'
			)
		);

		$the_query = new \WP_Query( $args );
		$results   = [];

		if ( is_array( $the_query->posts ) && count( $the_query->posts ) ) {
			foreach ( $the_query->posts as $post ) {
				$results[ $post->ID ] = sanitize_text_field( $post->post_title );
			}
		}

		return $results;
	}

	/**
	 * Get list revolution slider
	 *
	 * @return array $revsliders list slider
	 */
	protected function getListRevSlider() {
		//Get list slider
		$slider     = new \RevSlider();
		$arrSliders = $slider->getArrSliders();

		$revsliders = array();

		if ( $arrSliders ) {
			$revsliders['0'] = esc_html__( 'Select slider', 'gnje' );
			foreach ( $arrSliders as $slider ) {
				$revsliders[ $slider->getAlias() ] = $slider->getTitle();
			}
		} else {
			$revsliders['0'] = esc_html__( 'No sliders found', 'gnje' );
		}

		return $revsliders;
	}

	/**
	 * Get view template
	 *
	 * @param string $tpl_name
	 */
	protected function getViewTemplate( $tpl_slug, $tpl_name, $settings = [] ) {
		$located   = '';
		$templates = [];
		$tpl_name  = trim( str_replace( '.php', '', $tpl_name ), DIRECTORY_SEPARATOR );

		if ( ! $settings ) {
			$settings = $this->get_settings_for_display();
		}

		if ( $tpl_name ) {
			$templates[] = 'ganje-addons-for-elementor/templates/' . $tpl_slug . '-' . $tpl_name . '.php';
			$templates[] = 'ganje-addons-for-elementor/templates/' . $tpl_slug . '/' . $tpl_name . '.php';
			$templates[] = 'src/templates/' . $tpl_slug . '-' . $tpl_name . '.php';
			$templates[] = 'src/templates/' . $tpl_slug . '/' . $tpl_name . '.php';
		}

		$templates[] = 'ganje-addons-for-elementor/' . $tpl_slug . '.php';
		$templates[] = 'src/templates/' . $tpl_slug . '.php';

		foreach ( $templates as $template ) {
			if ( file_exists( STYLESHEETPATH . '/' . $template ) ) {
				$located = STYLESHEETPATH . '/' . $template;
				break;
			} elseif ( file_exists( TEMPLATEPATH . '/' . $template ) ) {
				$located = TEMPLATEPATH . '/' . $template;
				break;
			} elseif ( file_exists( WP_PLUGIN_DIR . '/ganje-addons-for-elementor/' . $template ) ) {
				$located = WP_PLUGIN_DIR . '/ganje-addons-for-elementor/' . $template;
				break;
			} else {
				$located = false;
			}
		}

		if ( $located ) {
			include $located;
		} else {
			throw new InvalidArgumentException( sprintf( __( 'Failed to load template with slug "%s" and name "%s".', 'gnje' ), $tpl_slug, $tpl_name ) );
		}
	}

	/**
	 * Get list Image sizes
	 *
	 * @return array image sizes
	 */
	protected function getImgSizes() {
		global $_wp_additional_image_sizes;
		$output    = array();
		$imgs_size = get_intermediate_image_sizes();
		foreach ( $imgs_size as $size ) :
			if ( in_array( $size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) :
				$output[ $size ] = ucwords( str_replace( array( '_', ' - ' ), array(
						' ',
						' '
					), $size ) ) . ' (' . get_option( "{$size}_size_w" ) . 'x' . get_option( "{$size}_size_h" ) . ')';
			elseif ( isset( $_wp_additional_image_sizes[ $size ] ) ) :
				$output[ $size ] = ucwords( str_replace( array( '_', '-' ), array(
						' ',
						' '
					), $size ) ) . ' (' . $_wp_additional_image_sizes[ $size ]['width'] . 'x' . $_wp_additional_image_sizes[ $size ]['height'] . ')';
			endif;
		endforeach;
		$output['full'] = esc_html__( 'Full', 'gnje' );

		return $output;
	}

	/**
	 * Get list Product sub category template
	 *
	 * @param $id parent category id, $selectedSlug selected category slug
	 *
	 * @return string template list sub product categories.
	 */
	protected function getListProductSubCat( $id, $selectedSlug = '' ) {
		$sub_html = '';
		$selected = '';
		$args     = array(
			'hierarchical'     => 1,
			'show_option_none' => '',
			'hide_empty'       => 0,
			'parent'           => $id,
			'taxonomy'         => 'product_cat'
		);
		$subcats  = get_categories( $args );
		if ( count( $subcats ) > 1 ) {
			$sub_html .= '<ul class="gnje-sub-cat">';
			foreach ( $subcats as $sc ) {
				$link = get_term_link( $sc->slug, $sc->taxonomy );
				if ( $selectedSlug == $sc->slug ) {
					$selected = 'gnje-selected';
				}
				$sub_html .= '<li class="gnje-cat-item"><a href="' . $link . '"
                                class="' . esc_attr( $selected ) . '"
                                data-type="product_cat" data-value="' . esc_attr( $sc->slug ) . '"
                                title="' . esc_attr( $sc->name ) . '">' . esc_html( $sc->name ) . '</a></li>';
			}
			$sub_html .= '</ul>';
		}

		return $sub_html;
	}

	/**
	 * Get all pages
	 *
	 * @return array
	 */
	protected function getPages() {
		$pages     = array();
		$all_pages = get_posts( array(
				'posts_per_page' => - 1,
				'post_type'      => 'page',
			)
		);
		if ( ! empty( $all_pages ) && ! is_wp_error( $all_pages ) ) {
			foreach ( $all_pages as $page ) {
				$pages[ $page->ID ] = $page->post_title;
			}
		}

		return $pages;
	}

	/**
	 * Get saved elementor templates
	 *
	 * @return array
	 */
	protected function getSavedElementorTemplates() {
		$tpls  = [];
		$posts = get_posts( [
			'post_type'              => 'elementor_library',
			'posts_per_page'         => - 1,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false
		] );

		if ( ! empty( $posts ) ) {
			foreach ( $posts as $post ) {
				$tpls[ $post->ID ] = $post->post_title;
			}

			return $tpls;
		} else {
			return [];
		}
	}

	/**
	 * Get a saved template content
	 *
	 * @param int $template_id Elementor post ID
	 */
	protected function getTemplateContent( $template_id ) {

		$elementor_frontend = new Frontend;

		$template_content = $elementor_frontend->get_builder_content( $template_id, true );

		return $template_content;
	}

	/**
	 * Display viewer video follow url
	 * @uses Use hook for add to single product
	 * @param @url video url
	 * @param $arg config for video
	 * @return Video button template for show video light box when click to.
	 *
	 * */
	protected function gnje_viewer_video($url,$arg) {
		if ( $url != '' ) {
			$zoo_product_video_url = parse_url( $url );
			if ( $zoo_product_video_url['host'] == 'vimeo.com' ) {
				wp_enqueue_script( 'vimeoapi');
				$zoo_embed_class = 'vimeo-embed';
			}
			if ( $zoo_product_video_url['host'] == 'youtube.com' || $zoo_product_video_url['host'] == 'www.youtube.com' ) {
				wp_enqueue_script( 'youtube-api');
				$zoo_embed_class = 'youtube-embed';
			}
			return '<div class="gnje-viewer-video '.esc_attr($zoo_embed_class).'" data-gnje-config=\''.$arg.'\'>' . wp_oembed_get( $url ) . '</div>';
		}
	}
}
