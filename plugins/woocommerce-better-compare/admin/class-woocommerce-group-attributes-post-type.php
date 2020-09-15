<?php

class WooCommerce_Group_Attributes_Post_Type {

	public function __construct(){

	}

	public function init()
	{
		$this->register_attribute_group();
	}

	public function register_attribute_group()
	{
		$labels = array(
			'name'                => 'گروه بندی ویژگی ها',
			'singular_name'       => 'گروه بندی ویژگی ها',
			'add_new'             => 'افزودن جدید',
			'add_new_item'        => 'افزودن جدید',
			'edit_item'           => 'ویرایش ویژگی',
			'new_item'            => 'گروه ویژگی جدید',
			'view_item'           => 'نمایش گروه بندی ویژگی',
			'search_items'        =>  'جستجوی گروه بندی',
			'not_found'           => 'گروه بندی ویژگی یافت نشد',
			'not_found_in_trash'  => 'گروه بندی ویژگی در زباله دان یافت نشد',
			'parent_item_colon'   =>  'والد گروه بندی ویژگی:',
			'menu_name'           =>  'گروه بندی ویژگی',
		);

		$args = array(
	      'public' => false,
	      'labels' => $labels,
	      'show_ui' => true,
	      'supports' => array('title'),
	      'show_in_menu' => 'edit.php?post_type=product',
	      'supports' => array('title', 'page-attributes'),
	      'hierarchical' => false,
	    );
	    register_post_type( 'attribute_group', $args );
	}

	function columns_head($columns){
		$output = array();

		$columns['menu_order'] = 'سفارش';

		foreach($columns as $column => $name){

			$output[$column] = $name;

			if($column === 'title'){
				$output['attributes'] = 'ویژگی ها';
			}
		}
		return $output;
	}

	function columns_content($column_name){
		global $post;

		if($column_name == 'menu_order'){
	      	$order = $post->menu_order;
     		echo $order;
		}

		if($column_name !== 'attributes'){
			return;
		}

		$argss = array('type' =>'select_advanced', 'multiple' => true);
		$attribute_groups = get_post_meta($post->ID, 'woocommerce_group_attributes_attributes');
		if(is_array($attribute_groups[0])) {
			$attribute_groups = $attribute_groups[0];
		} else {
			$attribute_groups = $attribute_groups;
		}

		$attribute_taxonomies = wc_get_attribute_taxonomies();

		foreach($attribute_groups as $attribute_group){
			$id = $attribute_group;

			foreach ($attribute_taxonomies as $key => $value) {

				if($value->attribute_id == $id) {
					$name = $value->attribute_label;
				}
			}

			echo "<strong>" . $name . '</strong></br>';
		}
	}

	public function attribute_group_order($query)
	{

		if('attribute_group' != $query->get( 'post_type' )) {
			return false;
		}

 		$query->set( 'orderby', 'menu_order');

	}


    public function add_custom_metaboxes($post_type, $post)
    {
        add_meta_box('wordpress-helpdesk-agent', 'ویژگی ها', array($this, 'attributes'), 'attribute_group', 'normal', 'high');
    }


    public function attributes()
    {
        global $post;

        wp_nonce_field(basename(__FILE__), 'woocommerce_group_attributes_meta_nonce');

        $prefix = 'woocommerce_group_attributes_';

		$image = get_post_meta($post->ID, $prefix . 'image', true);
        $attributes = get_post_meta($post->ID, $prefix . 'attributes');

        if(isset($attributes[0]) && !empty($attributes[0])) {
        	$attributes = $attributes[0];
        } else {
        	$attributes = array();
        }


        // $possibleAttributes = $this->get_possible_attributes();
        $possibleAttributes = wc_get_attribute_taxonomies();

        echo '<label for="' . $prefix . 'attributes">ویژگی ها:</label><br/>';
        $order = "";
        if(!empty($attributes)) {
        	$order = 'data-order="' . implode(',', $attributes) . '"';
        }

        echo '<select name="' . $prefix . 'attributes[]" multiple="multiple" style="height: 100%;" ' . $order . ' size=30>';

        foreach ($possibleAttributes as $possibleAttribute) {
        	$selected = "";
        	if(!empty($attributes)) {
        		foreach ($attributes as $attribute) {
        			echo $attribute;
        			if($attribute == $possibleAttribute->attribute_id) {
        				$selected = 'selected="selected"';
        			}
        		}
        	}
        	echo '<option ' . $selected . 'value="' . $possibleAttribute->attribute_id . '">' . $possibleAttribute->attribute_label . '</option>';
        }
        echo '</select>';

        echo '<br/><br/><label for="' . $prefix . 'image">تصویر:</label><br/>';

        echo '<input name="' . $prefix . 'image" value="' . $image . '" type="url">';

    }


    public function save_custom_metaboxes($post_id, $post)
    {
    	global $woocommerce_group_attributes_options;

    	if($post->post_type !== "attribute_group") {
    		return false;
    	}

        // Is the user allowed to edit the post or page?
        if (!current_user_can('edit_post', $post->ID)) {
            return $post->ID;
        }

        if (!isset($_POST['woocommerce_group_attributes_meta_nonce']) || !wp_verify_nonce($_POST['woocommerce_group_attributes_meta_nonce'], basename(__FILE__))) {
            return false;
        }

        $prefix = 'woocommerce_group_attributes_';
        $attribute_group_meta[$prefix . 'attributes'] = isset($_POST[$prefix . 'attributes']) ? $_POST[$prefix . 'attributes'] : '';
        $attribute_group_meta[$prefix . 'image'] = isset($_POST[$prefix . 'image']) ? $_POST[$prefix . 'image'] : '';

		if($woocommerce_group_attributes_options['multipleAttributesInGroups'] == "0"){

			$args = array( 'posts_per_page' => -1, 'post_type' => 'attribute_group', 'post_status' => 'publish', 'exclude' => $post_id);
			$attribute_groups = get_posts( $args );

			foreach ($attribute_groups as $attribute_group) {
				$attributes_in_group = get_post_meta($attribute_group->ID, $prefix . 'attributes');
				foreach ($attributes_in_group as $attribute_in_group) {
					$already_grouped[] = $attribute_in_group;
				}
			}

			$temp = array();
			foreach ($attribute_group_meta[$prefix . 'attributes'] as $attribute) {

				if(!in_array($attribute, $already_grouped)){
					$temp[$attribute] = $attribute;
				}
			}

			 $attribute_group_meta[$prefix . 'attributes'] = $temp;
		}

        // Add values of $ticket_meta as custom fields
        foreach ($attribute_group_meta as $key => $value) {
            if ($post->post_type == 'revision') {
                return;
            }
            update_post_meta($post->ID, $key, $value);
        }
    }


    public function show_attribute_group_toolbar()
    {
		add_thickbox();

		$attribute_groups = get_posts(array(
			'post_type' => 'attribute_group',
			'post_status' => 'publish',
			'posts_per_page' => -1
		));

		?>

		<p class="toolbar">

			<button type="button" id="load_attribute_group" class="button button-primary" style="float: right;margin: 0 0 0 6px;"><?php _e('بارگذاری','woocommerce-group-attributes'); ?></button>
			<select id="woocommerce_attribute_groups" name="woocommerce_attribute_groups" class="woocommerce_attribute_groups" style="float: right;margin: 0 0 0 6px;">
				<option value="">گروه بندی ویژگی ها</option>
				<?php
				foreach ($attribute_groups as $attribute_group) {
					echo '<option value="' . $attribute_group->ID . '">' . $attribute_group->post_title . '</option>';
				}
				?>
			</select>

			<a href="<?php echo admin_url('edit.php?post_type=attribute_group' ); ?>" class="button" onclick="return confirm('<?php _e('Are you sure you want to navigate away.','woocommerce-group-attributes'); ?>');"><?php _e('مدیریت گروه بندی ویژگی ها','woocommerce-group-attributes'); ?></a>
		</p>
		<?php
    }

    public function get_attributes_by_attribute_group_id()
    {
		global $wpdb;

    	$attribute_group_id = (isset($_POST['attribute_group_id']) && !empty($_POST['attribute_group_id'])) ? $_POST['attribute_group_id'] : "";
    	if(empty($attribute_group_id)) {
    		die('no id given!');
    	}

    	$attributes = get_post_meta($attribute_group_id, 'woocommerce_group_attributes_attributes');
    	// var_dump($attributes);
    	if(!empty($attributes)) {
    		$temp = array();
    		foreach ($attributes[0] as $attribute_id) {

    			$attribute = wc_attribute_taxonomy_name_by_id($attribute_id);

    			$temp[] = array(
    				'taxonomy' => $attribute,
    				'i' => $attribute_id
    			);
    		}
    		$attributes = $temp;
    	}
    	die(json_encode($attributes));
    }

}
