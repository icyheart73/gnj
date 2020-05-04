<?php
/* OptionTree is not loaded yet, or this is not an admin request */
if ( ! function_exists( 'ot_settings_id' ) || ! is_admin() )
	return false;

/**
 * Get a copy of the saved settings array.
 */
$saved_settings = get_option( 'option_tree_settings', array() );

/**
 * Custom settings array that will eventually be
 * passes to the OptionTree Settings API Class.
 */
$custom_settings = array(
	'sections'        => array(
		array(
			'id'          => 'woocommerce',
			'title'       => 'ووکامرس'
		)
	),
	'settings'        => array(
        array(
            'id'           => 'empty_price',
            'label'        => 'فعالسازی متن دلخواه برای محصولات بدون قیمت',
            'desc'         => 'اگر میخاهید برای محصولاتی که قیمت ندارند به جای قیمت ، متن دلخواهی را نمایش دهید این گزینه را روشن کنید. دقت کنید که قیمت 0 به معنای رایگان بودن محصول می باشد و باید قسمت قیمت را در صفحه ویرایش محصول خالی بگذارید.',
            'std'          => 'on',
            'type'         => 'on-off',
            'section'      => 'woocommerce',
        ),
            array(
                'id'           => 'empty_price_text',
                'label'        => 'متن دلخواه مورد نظرتان را وارد کنید.',
                'desc'         => sprintf('میتوانید از کد HTML در این قسمت استفاده کنید. مثلا میتوانید متن را به صفحه دلخواه لینک کنید و یا آیکون دلخواهی به جای متن نمایش دهید. برای اطلاعات بیشتر روی لینک زیر کلیک کنید %1$s', '<br><a href="#" target="_blank" > نمایش آموزش در سایت گنجه </a>' ),
                'std'          => '<a href="#" target="_blank" > تماس بگیرید </a>',
                'type'         => 'textarea-simple',
                'section'      => 'woocommerce',
                'rows'         => '4',
                'condition'    => 'empty_price:is(on)'
            ),
        array(
            'id'           => 'persian_price',
            'label'        => 'نمایش اعداد فارسی در قیمت ها',
            'desc'         => 'در صورتی که میخاهید اعداد قیمت ها با فونت فارسی (۰ ۱ ۲ ۳ ۴ ۵ ۶ ۷ ۸ ۹) نمایش داده شود این گزینه را فعال کنید. ',
            'std'          => 'on',
            'type'         => 'on-off',
            'section'      => 'woocommerce',
        ),
        array(
            'id'           => 'download_checkout',
            'label'        => 'حذف فیلد های اضافی برای محصولات دانلودی',
            'desc'         => 'در صورتی که در سایت محصولات دانلودی برای فروش دارید میتوانید با فعال کردن این گزینه فیلد های اضافی مثله آدرس و ... را در زمان تسویه حساب برای این محصولات غیر فعال کنید.',
            'std'          => 'on',
            'type'         => 'on-off',
            'section'      => 'woocommerce',
        ),
        array(
            'id'           => 'product_qa',
            'label'        => ' پرسش و پاسخ در صفحه محصول',
            'desc'         => 'در صورتی که این گزینه فعال باشد در صفحه محصول ، تب جدیدی اضافه خواهد شد که کاربران میتوانند در آن صفحه پرسش و پاسخ های مربوط به محصول را مشاهده کنند و پرسش های خود را مطرح کنند. شما میتوانید از این ویژگی به صورت سوالات متداول برای هر محصول هم استفاده کنید و خودتان پرسش های متداول برای هر محصول را اضافه کنید.',
            'std'          => 'on',
            'type'         => 'on-off',
            'section'      => 'woocommerce',
        ),
	)
);

/* settings are not the same update the DB */
if ( $saved_settings !== $custom_settings ) {
	update_option( 'option_tree_settings', $custom_settings );
}
