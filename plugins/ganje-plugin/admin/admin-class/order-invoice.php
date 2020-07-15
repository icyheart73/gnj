<?php
class Ganje_invoice{
    private static $instance = null;
    private $setting;
    public function __construct() {
        add_filter( 'manage_edit-shop_order_columns',array($this, 'gnj_shop_order_column'), 20 );
        add_action( 'manage_shop_order_posts_custom_column' ,array($this, 'gnj_orders_list_column_content'), 20, 2 );
        add_action("wp_ajax_gnj_invoice_print", array($this,"print_invovice_order"));
        add_action("wp_ajax_nopriv_gnj_invoice_print",array($this,"print_invoice_order"));

    }
    public function get_Settings() {
        global $GanjeSetting;
        $this->setting = $GanjeSetting;
    }
    public static function getInstance() {
        if (self::$instance == null)  {
            self::$instance = new Ganje_invoice();
        }
        return self::$instance;
    }

    public function gnj_shop_order_column($columns)
    {
        $reordered_columns = array();
        // Inserting columns to a specific location
        foreach( $columns as $key => $column){
            $reordered_columns[$key] = $column;
            if( $key ==  'order_status' ){
                // Inserting after "Status" column
                $reordered_columns['gnj-column1'] = 'فاکتور';
            }
        }
        return $reordered_columns;
    }

    public function gnj_orders_list_column_content( $column, $order_id )
    {

        if ($column == 'gnj-column1') {
            echo '<div><a id="gnj_invoice" class="gnj_invoice" href="http://localhost/ganje/invoice/?id='.$order_id.'" ><img class="gnj-tooltip " title="نمایش فاکتور"  src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE5LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB2aWV3Qm94PSIwIDAgNTEyIDUxMiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTEyIDUxMjsiIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPGc+DQoJPGc+DQoJCTxwYXRoIGQ9Ik00MDEuMDk1LDM4Ljg1MUwzNDguNjgzLDguNjQ4TDI5Ni4yNywzOC44NTFMMjQzLjg1OCw4LjY0OGwtNTIuNDEzLDMwLjIwMkwxMjQuMDIxLDB2NDAyLjYwOWgtODAuNTR2NTQuMTENCgkJCUM0My40ODEsNDg3LjIwMiw2OC4yOCw1MTIsOTguNzYzLDUxMmgzMTQuNDc1YzMwLjQ4MiwwLDU1LjI4Mi0yNC43OTgsNTUuMjgyLTU1LjI4MVYwTDQwMS4wOTUsMzguODUxeiBNOTguNzYzLDQ4MS45NzgNCgkJCWMtMTMuOTI4LDAtMjUuMjYtMTEuMzMtMjUuMjYtMjUuMjU5di0yNC4wODhoMjg0LjQ1M3YyNC4wODhjMCw5LjA5NCwyLjIwOSwxNy42ODQsNi4xMTUsMjUuMjU5SDk4Ljc2M3ogTTQxMy4yMzcsNDgxLjk3OA0KCQkJYy0xMy45MjcsMC0yNS4yNTktMTEuMzMtMjUuMjU5LTI1LjI1OXYtNTQuMTFIMTU0LjA0M1Y1MS45NDhsMzcuNDAxLDIxLjU1MWw1Mi40MTMtMzAuMmw1Mi40MTMsMzAuMmw1Mi40MTMtMzAuMjAxbDUyLjQxMywzMC4yMDENCgkJCWwzNy40MDItMjEuNTUxdjQwNC43NzFoMEM0MzguNDk3LDQ3MC42NDgsNDI3LjE2Niw0ODEuOTc4LDQxMy4yMzcsNDgxLjk3OHoiLz4NCgk8L2c+DQo8L2c+DQo8Zz4NCgk8Zz4NCgkJPHJlY3QgeD0iMTg0LjA2NiIgeT0iMTM1LjQ5IiB3aWR0aD0iMjI0LjQwNSIgaGVpZ2h0PSIzMC4wMjIiLz4NCgk8L2c+DQo8L2c+DQo8Zz4NCgk8Zz4NCgkJPHJlY3QgeD0iMTg0LjA2NiIgeT0iMTkyLjc0MiIgd2lkdGg9IjIyNC40MDUiIGhlaWdodD0iMzAuMDIyIi8+DQoJPC9nPg0KPC9nPg0KPGc+DQoJPGc+DQoJCTxyZWN0IHg9IjE4NC4wNjYiIHk9IjI0OS45OTQiIHdpZHRoPSIxMTIuMjAzIiBoZWlnaHQ9IjMwLjAyMiIvPg0KCTwvZz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjwvc3ZnPg0K" /></a> ';
            echo '<a id="gnj_invoice_label" ><img class="gnj-tooltip" title="برچسب پستی" src="data:image/svg+xml;base64,PHN2ZyBpZD0iQ2FwYV8xIiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IDAgMCA1MTIgNTEyIiBoZWlnaHQ9IjUxMiIgdmlld0JveD0iMCAwIDUxMiA1MTIiIHdpZHRoPSI1MTIiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGc+PHBhdGggZD0ibTEzNiA1MTJoMjQwYzI0LjgxMyAwIDQ1LTIwLjE4NyA0NS00NXYtMjkyLjE0N2MwLTIwLjAzMy03LjgwMS0zOC44NjctMjEuOTY3LTUzLjAzMy0uMDM4LS4wMzktMTExLjI3NS0xMDguODc1LTExMS4yNzUtMTA4Ljg3NS04LjM4MS04LjM0OC0xOS42NTYtMTIuOTQ1LTMxLjc1OC0xMi45NDVoLTkwYy00MS4zNTUgMC03NSAzMy42NDUtNzUgNzUgMCAxOS4xNDUgNy4yMiAzNi42MyAxOS4wNjkgNDkuODk3LTEyLjMyMyAxMy43NjEtMTkuMDY5IDMxLjMzOC0xOS4wNjkgNDkuOTU2djI5Mi4xNDdjMCAyNC44MTMgMjAuMTg3IDQ1IDQ1IDQ1em0yNDEuODcyLTM2OC45MTVjOC40NjYgOC40OTMgMTMuMTI4IDE5Ljc3MyAxMy4xMjggMzEuNzY4djI5Mi4xNDdjMCA4LjI3MS02LjcyOSAxNS0xNSAxNWgtMjQwYy04LjI3MSAwLTE1LTYuNzI5LTE1LTE1di0yOTIuMTQ3YzAtMTEuOTk1IDQuNjYyLTIzLjI3NCAxMy4xMjgtMzEuNzY4bC4xNDktLjE0NmM5LjY0MiA0LjUyIDIwLjM4OSA3LjA2MSAzMS43MjMgNy4wNTFoNDcuNThjLTEuNjY1IDQuNzA1LTIuNTggOS43NTItMi41OCAxNS4wMSAwIDI0LjgxMyAyMC4xODcgNDUgNDUgNDVzNDUtMjAuMTg3IDQ1LTQ1LTIwLjE4Ny00NS00NS00NWgtOTBjLTIuNTk0IDAtNS4xMzItLjIzMy03LjYwNy0uNjU2IDAgMCA4Ni45NjItODUuMDg2IDg3LTg1LjEyNSAzLjQ4OC0zLjQ4NyA3LjY5My00LjIxOSAxMC42MDctNC4yMTlzNy4xMTkuNzMyIDEwLjYwNiA0LjIxOWMuMDM5LjAzOSAxMTEuMjY2IDEwOC44NjYgMTExLjI2NiAxMDguODY2em0tMTA2Ljg3MiAyMS45MTVjMCA4LjI3MS02LjcyOSAxNS0xNSAxNXMtMTUtNi43MjktMTUtMTUgNi43MjktMTUgMTUtMTUgMTUgNi43MjkgMTUgMTV6bS0xMDUtMTM1aDQwLjgxMWwtNzUuMzg5IDczLjc2MmMtNi41MDMtNy44MDUtMTAuNDIyLTE3LjgzMy0xMC40MjItMjguNzYyIDAtMjQuODEzIDIwLjE4Ny00NSA0NS00NXoiLz48cGF0aCBkPSJtMzE2IDM5MWgtMTIwYy04LjI4NCAwLTE1IDYuNzE2LTE1IDE1czYuNzE2IDE1IDE1IDE1aDEyMGM4LjI4NCAwIDE1LTYuNzE2IDE1LTE1cy02LjcxNi0xNS0xNS0xNXoiLz48cGF0aCBkPSJtMTgxIDM0NmMwIDguMjg0IDYuNzE2IDE1IDE1IDE1aDEyMGM4LjI4NCAwIDE1LTYuNzE2IDE1LTE1cy02LjcxNi0xNS0xNS0xNWgtMTIwYy04LjI4NCAwLTE1IDYuNzE2LTE1IDE1eiIvPjwvZz48L3N2Zz4=" /></a><div> ';
            echo '<script>jQuery(function ($) { $(".gnj-tooltip").tipTip()})</script>';
        }
    }



    public function print_invoice_order(){



    }
}
Ganje_invoice::getInstance();
