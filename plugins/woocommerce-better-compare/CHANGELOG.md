# Changelog
======
1.3.4
======
- NEW:	Fly Out compare table is now printer friendly:
		- display all data in multiple pages correctly
		- hide / show similar & close button hidden
		- compare bar hidden
		- rows less padding

======
1.3.3
======
- FIX:	Clear All button now also removes IDs from URL Query

======
1.3.2
======
- FIX:	Remove from compare button not changed when 2 buttons on the same page
		and clicked on remove

======
1.3.1
======
- NEW:	Group Attributes Plugin Support
		https://welaunch.io/plugins/woocommerce-group-attributes/
		General > Enable Attribute Group Compatibility
		Then drag group names inside the data to show
- NEW:	Show attribute Name in an own first column instead of above the value
		Single Compare Table > Show Attr Name in first Column 
		Single Product > Show Attr Name in first Column 

======
1.3.0
======
- NEW:	Updated the Design
- NEW:	Centered compare items in the bar
- NEW:	Update default setting options
- NEW:	Added Box Shadow to the Compare Bar

======
1.2.17
======
- FIX:	State Saving building infinite &compare
- FIX:	400 Issue when product not found

======
1.2.16
======
- FIX:	Array to String Conversion issue in Redux Framework
- FIX:	Build State Replace now does not remove existing query strings

======
1.2.15
======
- NEW:	Added a span tag to add & remove buttons for better theme support
- NEW:	Added an option to set loop button position to none
- FIX:	Fixed Responsive View

======
1.2.14
======
- NEW:	Image is linked now
- NEW:	Added flatsome option to single product compare page table
- FIX:	Performance Increase for AJAX call

======
1.2.13
======
- NEW:	Filter for Single Product Compare Products Query Args
		apply_filters('woocommerce_better_compare_single_product_compare_products_query_args', $args, $product);

======
1.2.12
======
- NEW:	Added Support for up to 4 custom Meta Fields
		See data to compare
- NEW:	Filter to hide the add to compare for certain products:
		woocommerce_better_compare_show_add_to_compare_button
		$show_add_to_compare = apply_filters('woocommerce_better_compare_show_add_to_compare_button', true, $product);

======
1.2.11
======
- NEW:	HTML5 Replace State 	
		Compared products will be added to the URL of your site
		to share your comparison in social media for example
		Load order: Cookies > URL
- NEW:	Provided Translations: 
		– da_DK
		– de_DE
		– en_US
		– es_ES
		– fi_FI
		– fr_FR
		– hu_HU
		– it_IT
		– nb_NO
		– nl_NL
		– pl_PL
		– pt_PT
		– ru_RU
		– sk_SK
		– sv_SE
- FIX:	If compare bar open and product added compare bar does not close
- FIX:	Cookie gets saved for 30 days

======
1.2.10
======
- FIX:	Cookie only saved on domain basis

======
1.2.9
======
- FIX:	Better responsive table

======
1.2.8
======
- NEW: 	Short & Long description now render shortcodes automatically
		You can remove shortcodes with plugin settings > data to compare

======
1.2.7
======
- NEW:	Added Custom Taxonomies e.g. product_cat to data to show options
- NEW:	Added Custom Taxonomy Name field
- NEW:	Added Custom Taxonomy Disable link checkbox

======
1.2.6
======
- FIX:	Added FontAwesome to prevent icons from not showing
- FIX:	Close Icon not visible

======
1.2.5
======
- NEW:	Responsive Slick Slider on Single Product Pages
- FIX:	Responsive Table slided 2 items on mobile
- FIX:	Multiple Slick initalizements

======
1.2.4
======
- NEW:	Performance Increase
- NEW:	Image & Product Title are now linked (in bar & widget)
- FIX:	Compare does no longer open on page load
- FIX:	Long Product names not breaking correctly

======
1.2.3
======
- FIX:	Compare Bar Button hides compare table flyout buttons at the bottom

======
1.2.2
======
- NEW:	Set a link on the Compare Now Button to link to a Page
- NEW:	Shortcode for Add to Compare button: woocommerce_better_compare_button
		Accepts parameter "product" with product ID as value
		or no parameter to get product dynamically
- NEW:	Added support for grouped attributes plugin:
		https://codecanyon.net/item/woocommerce-group-attributes/15467980
- FIX:	Removed Draggable feature (too many cross browser issues)
- FIX:	Added more responsive CSS

======
1.2.1
======
- NEW:	you can set own images sizes for compare bar & table

======
1.2.0
======
- NEW:	Autocomplete functionality
		Either use a shortcode or a widget to show an autocomplete form, where
		users can search by sku or product title and add product to compare then
		Demos:
		- Shop Demo (top right in sidebar): https://plugins.db-dzine.com/woocommerce-better-compare/demo/
		- Shortcode: https://plugins.db-dzine.com/woocommerce-better-compare/autocomplete/
- FIX:	Updated Translations
- FIX:	Responsive CSS

======
1.1.9
=====
- FIX: Added reset product data

======
1.1.8
=====
- FIX: Max Products Issue
- FIX: Removed Console logs

======
1.1.7
======
- NEW: Hide Similiarities now hides the complete row
- FIX: Draggable not working

======
1.1.6
======
- NEW: Option for Shop Loop Button positon & hook priority
- NEW: Responsive slider option
- FIX: Compare bar button centered
- FIX: Similarities / Differences not working

======
1.1.5
======
- NEW: Added responsive grid for the overlay compare table
- FIX: Compare bar opens only when more than 2 products are added

======
1.1.4
======
- NEW: Compare bar only opens 2 or more items are added
- NEW: Compare table now closes and do not open the bar again

======
1.1.3
======
- FIX:  Undefined 'ti' index warning

======
1.1.2
======
- NEW:  Enable or disable the draggable function in settings panle
- FIX:  Clear all link opened the compare bar

======
1.1.1
======
- NEW:  Compare bar closes on click compare
- NEW:  Compare bar opens when click on close compare table
- NEW:  Moved highlight simliar & differences in settings panel
- FIX:  JQuery-UI needed
- FIX:  Add to Compare not working when no sidebar or bar was visible

======
1.1.0
======
- NEW:	Compare Sidebar Widget
- NEW:	When no products are set in the shortcode, the
		plugin tries to get products from users cookie
		Example: [woocommerce_better_compare]
- NEW:  Scroll arrows on single product page are now 100% height
- NEW:  Slider for the single compare table
- NEW:  Data rows inside compare table get now equally height
- NEW:  Compare table shortcode now works with Slider
		Example: [woocommerce_better_compare products="380,377" slidesToShow="2"]
- NEW:  You can disable the compare bar in the settings
- FIX:  Admin panel > data to compare tabs have more width
- FIX:  Slug changed & all options etc. to avoid plugin conflicts
- FIX:  Moved all JS / CSS files locally

======
1.0.1
======
- NEW: Show the add to compare on single product pages
- FIX: Draggable issue

======
1.0.0
======
- Inital release