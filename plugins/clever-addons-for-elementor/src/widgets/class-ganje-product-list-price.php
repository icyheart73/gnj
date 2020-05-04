<?php
namespace CleverAddonsForElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
/**
 * GanjeProductListPrice
 *
 * @author CleverSoft <hello.cleversoft@gmail.com>
 * @package CAFE
 */
if (class_exists('WooCommerce')):
    final class GanjeProductListPrice extends CleverWidgetBase
    {
        /**
         * @return string
         */
        public $admin_editor_js;
        function get_name()
        {
            return 'ganje-product-price-list';
        }

        /**
         * @return string
         */
        function get_title()
        {
            return 'لیست قیمت گنجه';
        }

        /**
         * @return string
         */
        function get_icon()
        {
            return 'cs-font clever-icon-carousel';
        }
        public function editor_js() {
            echo $this->admin_editor_js ;
        }
        /**
         * Retrieve the list of scripts the image carousel widget depended on.
         *
         * Used to set scripts dependencies required to run the widget.
         *
         * @since 1.3.0
         * @access public
         *
         * @return array Widget scripts dependencies.
         */
        public function get_script_depends()
        {
            return ['swiper', 'swiper-script'];
        }
        /**
         * Register controls
         */
        protected function _register_controls()
        {
            $this->start_controls_section(
                'section_title', [
                'label' => 'عنوان'
            ]);

            $this->add_control('title', [
                'label'		    => 'عنوان',
                'type'		    => Controls_Manager::TEXT,
                'default'       => 'محصولات تیمچه',
            ]);

            $this->end_controls_section();

            $this->start_controls_section(
                'section_filter', [
                'label' => 'فیلتر',
            ]);

            $this->add_control('filter_categories', [
                'label'         => 'دسته بندی ها',
                'description'   => __('', 'cafe'),
                'type'          => Controls_Manager::SELECT2,
                'default'       => '',
                'multiple'      => true,
                'options'       => $this->get_categories_for_cafe('product_cat', 2 ),
            ]);

            $this->add_control('asset_type', [
                'label'         => 'فیلتر محصولات :',
                'description'   => __('', 'cafe'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'all',
                'options'       => $this->get_woo_asset_type_for_cafe(),
            ]);
            $this->add_control('orderby', [
                'label'         => 'مرتب سازی بر اساس :',
                'description'   => __('', 'cafe'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'date',
                'options'       => $this->get_woo_order_by_for_cafe(),
            ]);
            $this->add_control('order', [
                'label'         => 'ترتیب',
                'description'   => __('', 'cafe'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'desc',
                'options'       => $this->get_woo_order_for_cafe(),
            ]);
            $this->add_control('max_height', [
                'label'         => 'محدود کردن ارتفاع',
                'type'          => Controls_Manager::SWITCHER,
                'label_on' => 'محدود',
                'label_off' => 'نامحدود',
                'return_value' => 'yes',
                'default' => 'no',
            ]);
            $this->add_control('max_height_size', [
                'label'		    => 'ارتفاع را بر مبنای px وارد کنید',
                'type'		    => Controls_Manager::TEXT,
                'condition' => [
                    'max_height' => 'yes'
                ],
            ]);

            $this->end_controls_section();

            $this->start_controls_section(
                'normal_style_settings', [
                'label' => 'طرح بندی',
                'tab' => Controls_Manager::TAB_STYLE,
            ]);

            $this->add_control('title_color', [
                'label' => 'رنگ عنوان',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cafe-title' => 'color: {{VALUE}};'
                ]
            ]);
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'selector' => '{{WRAPPER}} .cafe-title',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                ]
            );
            $this->add_control('title_background', [
                'label' => 'رنگ پس زمینه متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cafe-title' => 'background: {{VALUE}};'
                ]
            ]);


            $this->end_controls_section();

        }

        /**
         * Load style
         */
        public function get_style_depends()
        {
            return ['cafe-style'];
        }

        public function get_product( $ID ) {

            $product = wc_get_product( $ID );

            if ( !is_wp_error( $product ) ) {

                $title         = $product->get_title();
                $link          = $product->get_permalink();
                $thumbnail     = $product->get_image();

                if ( $product->is_type( 'variable' ) ) {

                    $variations = $product->get_available_variations();
                    ?>

                    <tr data-id="<?= $ID ?>">

                        <td class="td-product-index"></td>
                        <td class="td-product-thump"><?= $thumbnail; ?></td>
                        <td class="td-product-title"><a href="<?= $link ?>" target="_blank"><?= $title; ?></a>
                            <table>
                                <?php foreach ($variations as $variation) {
                                    $variation_title = '';
                                    foreach ($variation['attributes'] as $var => $value) {
                                        $variation_title .= $value.' ';
                                    }
                                    ?>
                        <tr>
                            <td><?= $variation_title; ?></td>
                        </tr>
                        <?php
                                } ?>

                            </table>
                        </td>
                        <td> &nbsp;
                            <table>
                                <?php foreach ($variations as $variation) {
                                    $VID = $variation['variation_id']; ?>
                                    <tr>
                                        <td><?= intval( get_post_meta( $VID, '_tcw_old_price', true ) ) ? : $variation['display_regular_price']; ?></td>
                                    </tr>
                                <?php } ?>

                            </table>
                        </td>
                        <td> &nbsp;
                            <table>
                                <?php foreach ($variations as $variation) { ?>
                                    <tr>
                                        <td><?= $variation['display_price']; ?></td>
                                    </tr>
                                <?php } ?>

                            </table>
                        </td>
                        <td> &nbsp;<table>
                                <?php foreach ($variations as $variation) {
                                    $VID = $variation['variation_id'];
                                    $vold_price = absint(intval( get_post_meta( $VID, '_tcw_old_price', true ) ) ? : $variation['display_regular_price']);
                                    $vdiff = absint($vold_price - $variation['display_price']);
                                    ?>
                                    <tr>
                                        <td><?= $vdiff; ?></td>
                                    </tr>
                                <?php } ?>

                            </table>
                        </td>
                        <td> &nbsp;
                            <table>
                                <?php if (!empty($ID_var) && is_array($ID_var)) ?>
                                <?php foreach ($variations as $variation) {
                                    $vstatus = 'increase';
                                    $vstatus_title = 'افزایش قیمت';
                                    $VID = $variation['variation_id'];
                                    $vold_price = absint(intval( get_post_meta( $VID, '_tcw_old_price', true ) ) ? : $variation['display_regular_price']);
                                    $vstatus_icon = '<img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjI0cHgiIGhlaWdodD0iMjRweCIgdmlld0JveD0iMCAwIDQ0NC44MTkgNDQ0LjgxOSIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNDQ0LjgxOSA0NDQuODE5OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CjxnPgoJPHBhdGggZD0iTTQzMy45NjgsMjc4LjY1N0wyNDguMzg3LDkyLjc5Yy03LjQxOS03LjA0NC0xNi4wOC0xMC41NjYtMjUuOTc3LTEwLjU2NmMtMTAuMDg4LDAtMTguNjUyLDMuNTIxLTI1LjY5NywxMC41NjYgICBMMTAuODQ4LDI3OC42NTdDMy42MTUsMjg1Ljg4NywwLDI5NC41NDksMCwzMDQuNjM3YzAsMTAuMjgsMy42MTksMTguODQzLDEwLjg0OCwyNS42OTNsMjEuNDExLDIxLjQxMyAgIGM2Ljg1NCw3LjIzLDE1LjQyLDEwLjg1MiwyNS42OTcsMTAuODUyYzEwLjI3OCwwLDE4Ljg0Mi0zLjYyMSwyNS42OTctMTAuODUyTDIyMi40MSwyMTMuMjcxTDM2MS4xNjgsMzUxLjc0ICAgYzYuODQ4LDcuMjI4LDE1LjQxMywxMC44NTIsMjUuNywxMC44NTJjMTAuMDgyLDAsMTguNzQ3LTMuNjI0LDI1Ljk3NS0xMC44NTJsMjEuNDA5LTIxLjQxMiAgIGM3LjA0My03LjA0MywxMC41NjctMTUuNjA4LDEwLjU2Ny0yNS42OTNDNDQ0LjgxOSwyOTQuNTQ1LDQ0MS4yMDUsMjg1Ljg4NCw0MzMuOTY4LDI3OC42NTd6IiBmaWxsPSIjNGNhZjdlIi8+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" />';
                                    if ($variation['display_price']< $vold_price) {
                                        $vstatus = 'decrease';
                                        $vstatus_title = 'کاهش قیمت';
                                        $vstatus_icon = '<img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjI0cHgiIGhlaWdodD0iMjRweCIgdmlld0JveD0iMCAwIDQ0NC44MTkgNDQ0LjgxOSIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNDQ0LjgxOSA0NDQuODE5OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CjxnPgoJPHBhdGggZD0iTTQzNC4yNTIsMTE0LjIwM2wtMjEuNDA5LTIxLjQxNmMtNy40MTktNy4wNC0xNi4wODQtMTAuNTYxLTI1Ljk3NS0xMC41NjFjLTEwLjA5NSwwLTE4LjY1NywzLjUyMS0yNS43LDEwLjU2MSAgIEwyMjIuNDEsMjMxLjU0OUw4My42NTMsOTIuNzkxYy03LjA0Mi03LjA0LTE1LjYwNi0xMC41NjEtMjUuNjk3LTEwLjU2MWMtOS44OTYsMC0xOC41NTksMy41MjEtMjUuOTc5LDEwLjU2MWwtMjEuMTI4LDIxLjQxNiAgIEMzLjYxNSwxMjEuNDM2LDAsMTMwLjA5OSwwLDE0MC4xODhjMCwxMC4yNzcsMy42MTksMTguODQyLDEwLjg0OCwyNS42OTNsMTg1Ljg2NCwxODUuODY1YzYuODU1LDcuMjMsMTUuNDE2LDEwLjg0OCwyNS42OTcsMTAuODQ4ICAgYzEwLjA4OCwwLDE4Ljc1LTMuNjE3LDI1Ljk3Ny0xMC44NDhsMTg1Ljg2NS0xODUuODY1YzcuMDQzLTcuMDQ0LDEwLjU2Ny0xNS42MDgsMTAuNTY3LTI1LjY5MyAgIEM0NDQuODE5LDEzMC4yODcsNDQxLjI5NSwxMjEuNjI5LDQzNC4yNTIsMTE0LjIwM3oiIGZpbGw9IiNmZjYzN2QiLz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K" />';
                                    } elseif ($vold_price === $variation['display_price']) {
                                        $vdiff = '---';
                                        $vstatus = 'unchanged';
                                        $vstatus_title = 'بدون تغییر';
                                        $vstatus_icon = '---';
                                    }
                                    $status_icon = '<span data-toggle="tooltip" title="' . $vstatus_title . '">' . $vstatus_icon . '</span>';
                                    ?>
                                    <tr>
                                        <td><?= $vstatus_icon; ?></td>
                                    </tr>
                                <?php } ?>

                            </table>
                        </td>

                    </tr>

                    <?php

                } else {

                    $regular_price = intval( $product->get_regular_price() );
                    $sale_price    = intval( $product->get_sale_price() );
                    $new_price     = empty( $sale_price ) ? $regular_price : $sale_price;
                    $old_price     = intval( get_post_meta( $ID, '_tcw_old_price', true ) ) ? : $regular_price;
                    $diff          = absint( $new_price - $old_price );
                    // $status        = '<i class="fa fa-arrow-up"></i>';
                    $status       = 'increase';
                    $status_title = 'افزایش قیمت';
                    $status_icon  = '<img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjI0cHgiIGhlaWdodD0iMjRweCIgdmlld0JveD0iMCAwIDQ0NC44MTkgNDQ0LjgxOSIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNDQ0LjgxOSA0NDQuODE5OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CjxnPgoJPHBhdGggZD0iTTQzMy45NjgsMjc4LjY1N0wyNDguMzg3LDkyLjc5Yy03LjQxOS03LjA0NC0xNi4wOC0xMC41NjYtMjUuOTc3LTEwLjU2NmMtMTAuMDg4LDAtMTguNjUyLDMuNTIxLTI1LjY5NywxMC41NjYgICBMMTAuODQ4LDI3OC42NTdDMy42MTUsMjg1Ljg4NywwLDI5NC41NDksMCwzMDQuNjM3YzAsMTAuMjgsMy42MTksMTguODQzLDEwLjg0OCwyNS42OTNsMjEuNDExLDIxLjQxMyAgIGM2Ljg1NCw3LjIzLDE1LjQyLDEwLjg1MiwyNS42OTcsMTAuODUyYzEwLjI3OCwwLDE4Ljg0Mi0zLjYyMSwyNS42OTctMTAuODUyTDIyMi40MSwyMTMuMjcxTDM2MS4xNjgsMzUxLjc0ICAgYzYuODQ4LDcuMjI4LDE1LjQxMywxMC44NTIsMjUuNywxMC44NTJjMTAuMDgyLDAsMTguNzQ3LTMuNjI0LDI1Ljk3NS0xMC44NTJsMjEuNDA5LTIxLjQxMiAgIGM3LjA0My03LjA0MywxMC41NjctMTUuNjA4LDEwLjU2Ny0yNS42OTNDNDQ0LjgxOSwyOTQuNTQ1LDQ0MS4yMDUsMjg1Ljg4NCw0MzMuOTY4LDI3OC42NTd6IiBmaWxsPSIjNGNhZjdlIi8+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" />';
                    if ( $new_price < $old_price ) {
                        $status       = 'decrease';
                        $status_title = 'کاهش قیمت';
                        $status_icon  = '<img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjI0cHgiIGhlaWdodD0iMjRweCIgdmlld0JveD0iMCAwIDQ0NC44MTkgNDQ0LjgxOSIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNDQ0LjgxOSA0NDQuODE5OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CjxnPgoJPHBhdGggZD0iTTQzNC4yNTIsMTE0LjIwM2wtMjEuNDA5LTIxLjQxNmMtNy40MTktNy4wNC0xNi4wODQtMTAuNTYxLTI1Ljk3NS0xMC41NjFjLTEwLjA5NSwwLTE4LjY1NywzLjUyMS0yNS43LDEwLjU2MSAgIEwyMjIuNDEsMjMxLjU0OUw4My42NTMsOTIuNzkxYy03LjA0Mi03LjA0LTE1LjYwNi0xMC41NjEtMjUuNjk3LTEwLjU2MWMtOS44OTYsMC0xOC41NTksMy41MjEtMjUuOTc5LDEwLjU2MWwtMjEuMTI4LDIxLjQxNiAgIEMzLjYxNSwxMjEuNDM2LDAsMTMwLjA5OSwwLDE0MC4xODhjMCwxMC4yNzcsMy42MTksMTguODQyLDEwLjg0OCwyNS42OTNsMTg1Ljg2NCwxODUuODY1YzYuODU1LDcuMjMsMTUuNDE2LDEwLjg0OCwyNS42OTcsMTAuODQ4ICAgYzEwLjA4OCwwLDE4Ljc1LTMuNjE3LDI1Ljk3Ny0xMC44NDhsMTg1Ljg2NS0xODUuODY1YzcuMDQzLTcuMDQ0LDEwLjU2Ny0xNS42MDgsMTAuNTY3LTI1LjY5MyAgIEM0NDQuODE5LDEzMC4yODcsNDQxLjI5NSwxMjEuNjI5LDQzNC4yNTIsMTE0LjIwM3oiIGZpbGw9IiNmZjYzN2QiLz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K" />';
                    } elseif ( $old_price === $new_price ) {
                        $diff         = '---';
                        $status       = 'unchanged';
                        $status_title = 'بدون تغییر';
                        $status_icon  = '---';
                    }

                    $status_icon = '<span data-toggle="tooltip" title="' . $status_title . '">' . $status_icon . '</span>';
                    ?>
                    <tr data-id="<?= $ID ?>">
                        <td class="td-product-index"></td>
                        <td class="td-product-thump"><?= $thumbnail; ?></td>
                        <td class="td-product-title"><a href="<?= $link ?>" target="_blank"><?= $title; ?></a><?php if ( is_admin() ): ?><br>
                                <div class="row-actions">
                                <span class="edit"><a href="<?= get_edit_post_link( $ID ) ?>">ویرایش</a> | </span>
                                </div><?php endif; ?>
                        </td>
                        <td class="td-product-old-price"><?= $old_price; ?></td>
                        <td class="td-product-new-price"><?= $new_price; ?></td>
                        <td class="td-product-price-change"><?= $diff; ?></td>
                        <td class="td-product-status text-center"><?= $status_icon; ?></td>
                    </tr>
                    <?php
                }

            }

        }
        /**
         * Render
         */
        protected function render()
        {
// default settings
            $settings = array_merge([
                'title'                 => '',
                'filter_categories'     => '',
                'product_ids'           => '',
                'asset_type'            => 'all',
                'orderby'               => 'date',
                'order'                 => 'desc',
                'posts_per_page'        => 6,
                'slides_to_show'        => 4,
                'speed'                 => 5000,
                'scroll'                => 1,
                'autoplay'              => 'true',
                'show_pag'              => 'true',
                'show_nav'              => 'true',
                'nav_position'          => 'middle-nav',

            ], $this->get_settings_for_display());

            $this->add_inline_editing_attributes('title');

            $this->add_render_attribute('title', 'class', 'cafe-title');

            $this->getViewTemplate('template', 'product-price-list', $settings);

        }

    }
endif;
