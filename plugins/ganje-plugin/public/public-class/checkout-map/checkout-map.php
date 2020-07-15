<?php


class Ganje_checkout_map
{
    private static $instance = null;
    private $setting;

    public function __construct()
    {
        add_filter('woocommerce_checkout_fields', array($this, 'ganje_add_custom_checkout_field'));
        add_action('wp_footer', array($this, 'load_map_script'), 50);
        add_action("wp_ajax_gnjCityID", array($this,"getCityID"));
        add_action("wp_ajax_nopriv_gnjCityID",array($this,"getCityID"));
        add_action('woocommerce_checkout_update_user_meta', array($this, 'save_map_data_user'), 50 , 2);
        add_action('woocommerce_checkout_update_order_meta', array($this, 'save_map_data_order'), 50 , 1);
        add_action( 'woocommerce_admin_order_data_after_billing_address', array($this,'gnj_checkout_field_display_admin_order_meta'), 10, 1 );


    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Ganje_checkout_map();
        }
        return self::$instance;
    }

    public function get_Settings()
    {
        global $GanjeSetting;
        $this->setting = $GanjeSetting;
    }

    function ganje_add_custom_checkout_field($fields)
    {
        $fields['billing']['mapBtn'] = array(
            'label' => 'MapBtn',
            'type' => 'text',
            'class' => array('map_btn'),
            'priority' => 75,
            'required' => false,
            'default' => 5
        );
        $fields['shipping']['shmapBtn'] = array(
            'label' => 'shippingMapBtn',
            'type' => 'text',
            'class' => array('map_btn'),
            'priority' => 75,
            'required' => false,
            'default' => 1
        );

        $fields['billing']['mapPoints'] = array(
            'id' => 'billingLngLat',
            'label' => 'labelLngLat',
            'type' => 'text',
            'class' => array('hidden'),
            'priority' => 75,
            'required' => false,
        );
        $fields['shipping']['shMapPoints'] = array(
            'id' => 'shippingLngLat',
            'label' => 'labelLngLat',
            'type' => 'text',
            'class' => array('hidden'),
            'priority' => 75,
            'required' => false,
        );


        return $fields;
    }

    public function save_map_data_user($customer_id, $posted)
    {

        update_user_meta($customer_id , 'ulocations' , $posted['mapPoints']);
        update_user_meta($customer_id , 'ulocations2' , $posted['shMapPoints']);
        update_option('op1122',$posted);


    }

    public function save_map_data_order($order_id)
    {

        update_post_meta( $order_id, 'olocations', sanitize_text_field( $_POST['mapPoints'] )) ;
        update_post_meta( $order_id, 'olocations2', sanitize_text_field( $_POST['shMapPoints'] )) ;

    }

    function gnj_checkout_field_display_admin_order_meta($order){

        $mapUrl = 'https://www.google.com/maps/place/' .get_post_meta( $order->get_id(), 'olocations', true ) . ',19z';
        echo  '<div><a target="_blank" href="'.$mapUrl .'" class="button save_order button-primary" ><strong>نمایش بروی نقشه</strong> </a></div>';
        echo '<div><input id="myInput" size="85" type="text" value="'.$mapUrl.'" style="text-align: left;margin-top: 10px;"></div>';

    }

    public function getCityID()
    {
       $query_var_defaults = array(
            'taxonomy'               => 'state_city',
            'name'                   => str_replace(' ', '', $_POST['city_name']),
            'parent'                 => $_POST['parent'],
           'hide_empty' => false,
        );

        $cid = get_terms($query_var_defaults);
        $cid = (array) $cid[0];
        echo $cid['term_id'];

    }



    public function load_map_script()
    {
        if (is_checkout()) { ?>

            <script src="https://www.parsimap.com/js/v3.1.0/parsimap.js?key=ca637e57-a4f1-4ed2-96c9-b4d73143980d"></script>
            <script>
                jQuery(document).ready(function ($) {
                    var state;
                    var city;
                    var map;


                    function getOptId(text) {
                        let id = '';
                        $('#billing_state').find('*').filter(function () {
                            if ($(this).text() === text) {
                                id = $(this).val();
                            }
                        });
                        return id;
                    };

                    function getCityOptId(text ,type) {
                        let data = {
                            'action': 'gnjCityID',
                            'city_name': text,
                            'parent': getOptId(state)
                        }
                        $.ajax({
                            type: "POST", // use $_POST method to submit data
                            url: 'http://localhost/ganje/wp-admin/admin-ajax.php', // where to submit the data
                            data: data,
                            dataType : 'text',
                            success:function(data) {
                                console.log(data/10);
                                $('#'+type+'_city').val(data/10).change();
                            }
                        });
                    };

                    function gnj_state_changed(type, state_id) {

                        let data = {
                            'action': 'mahdiy_load_cities',
                            'state_id': state_id,
                            'type': type
                        };

                        $.post('http://localhost/ganje/wp-admin/admin-ajax.php', data, function (response) {
                            $('select#' + type + '_city').html(response);
                        }).done(function() {
                             getCityOptId(city ,type) ;
                        });
                    };

                    $('p.map_btn').click(function () {
                        var type = $(this).find('input').val();
                        Swal.fire({

                            title: 'انتخاب روی نقشه',
                            html:
                                '<div id="map"></div>\n' +
                                '<div class="center-marker"></div>',
                            onOpen: () => {
                                var container = document.getElementById('map');
                                var mapOptions = {center: [51.68020231581431, 32.7136826316584], zoom: 15};
                                map = new parsimap.Map(container, mapOptions);

                            }
                        }).then((result) => {
                            if (result.value) {
                                let center = map.getCenter();
                                var url = "https://pm1.parsimap.com/comapi.svc/areaInfo/" + center.lat + "/" + center.lng + "/18/1/ca637e57-a4f1-4ed2-96c9-b4d73143980d/1";

                                $.get(url, function (data, status) {
                                    var parse_data = JSON.parse(data)
                                    $.each(parse_data.result, function (i, item) {
                                        if (item.type === 9002)
                                            state = item.title;
                                        console.log('state : ' + state)
                                        if (item.type === 9003)
                                            city = item.title;
                                        console.log('city : ' + city)
                                    });

                                    if (type === '5') {
                                        $('#billingLngLat').val(center.lat+','+center.lng);
                                        $('#billing_state').val(getOptId(state)).change();
                                        gnj_state_changed('billing', getOptId(state));
                                        $('#billing_address_1').val(parse_data.localAddress)
                                    } else if (type === '1') {
                                        $('#shippingLngLat').val(center.lat+','+center.lng);
                                        $('#shipping_state').val(getOptId(state)).change();
                                        gnj_state_changed('shipping', getOptId(state));

                                        $('#shipping_address_1').val(parse_data.localAddress)
                                    }
                                });
                            }
                        })

                    })
                });
            </script>

            <?php
        }
    }



}

Ganje_checkout_map::getInstance();
