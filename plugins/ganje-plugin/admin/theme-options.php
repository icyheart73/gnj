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
		),
        array(
            'id'          => 'single_product',
            'title'       =>'صفحه محصول'
        ),
        array(
            'id'          => 'otp_tab',
            'title'       => 'ورود با موبایل'
        ),
        array(
            'id'          => 'sharing_product',
            'title'       =>'اشتراک گذاری'
        ),
        array(
            'id'          => 'calling_order',
            'title'       =>'سفارش تلفنی'
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
        /* end section woocommerce */
        array(
            'id'           => 'free_price',
            'label'        => 'فعالسازی برچسب دلخواه برای محصولات رایگان',
            'desc'         => 'اگر می خواهید برای محصولاتی که رایگان هستند به جای قیمت ، برچسب دلخواهی را نمایش دهید این گزینه را روشن کنید. دقت کنید که قیمت 0 به معنای رایگان بودن محصول می باشد ',
            'std'          => 'on',
            'type'         => 'on-off',
            'section'      => 'single_product',
        ),
        array(
            'id'           => 'free_price_text',
            'label'        => 'برچسب دلخواه مورد نظرتان را وارد کنید.',
            'desc'         => sprintf('میتوانید از کد HTML در این قسمت استفاده کنید. مثلا میتوانید متن را به صفحه دلخواه لینک کنید و یا آیکون دلخواهی به جای متن نمایش دهید. برای اطلاعات بیشتر روی لینک زیر کلیک کنید %1$s', '<br><a href="#" target="_blank" > نمایش آموزش در سایت گنجه </a>' ),
            'std'          => '<a href="#" target="_blank" > رایگان </a>',
            'type'         => 'textarea-simple',
            'section'      => 'single_product',
            'rows'         => '4',
            'condition'    => 'free_price:is(on)'
        ),
        array(
            'id'           => 'product_count',
            'label'        => 'فعالسازی نمایش تعداد فروش',
            'desc'         => '',
            'std'          => 'on',
            'type'         => 'on-off',
            'section'      => 'single_product',
        ),
        array(
            'id'           => 'related_product',
            'label'        => 'فعالسازی نمایش محصولات مرتبط',
            'desc'         => ' ',
            'std'          => 'on',
            'type'         => 'on-off',
            'section'      => 'single_product',
        ),
        array(
            'id'          => 'related_product_count',
            'label'       => 'تعداد محصولات مرتبط',
            'desc'        => '',
            'type'        => 'numeric-slider',
            'section'     => 'single_product',
            'min_max_step'=> '4,16,1',
            'condition'    => 'related_product:is(on)'
        ),
        array(
            'id'           => 'product_instock',
            'label'        => 'عدم نمایش محصولات ناموجود',
            'desc'         => '',
            'std'          => 'on',
            'type'         => 'on-off',
            'section'      => 'single_product',
            'condition'    => 'related_product:is(on)'
        ),
        array(
            'id'          => 'related_option',
            'label'       =>  'مرتبط بر اساس',
            'desc'        =>  '',
            'type'        => 'checkbox',
            'section'     => 'single_product',
            'condition'    => 'related_product:is(on)',
            'choices'     => array(
                array(
                    'value'       => 'category',
                    'label'       => 'دسته بندی',
                ),
                array(
                    'value'       => 'tag',
                    'label'       =>  'برچسب',
                )
            )
        ),
        array(
            'id'           => 'share_product',
            'label'        => 'فعال سازی اشتراک گذاری محصول',
            'desc'         => ' ',
            'std'          => 'on',
            'type'         => 'on-off',
            'section'      => 'sharing_product',
        ),
        array(
            'id'           => 'share_email_product',
            'label'        => 'فعال سازی اشتراک گذاری محصول با ایمیل',
            'desc'         => ' ',
            'std'          => 'on',
            'type'         => 'on-off',
            'section'      => 'sharing_product',
            'condition'    => 'share_product:is(on)',
        ),
        array(
            'id'           => 'share_sms_product',
            'label'        => 'فعال سازی اشتراک گذاری محصول با پیامک',
            'desc'         => ' ',
            'std'          => 'on',
            'type'         => 'on-off',
            'section'      => 'sharing_product',
            'condition'    => 'share_product:is(on)',
        ),
//////////////////////////////////calling order
        array(
            'id'           => 'calling_order_status',
            'label'        => 'فعال سازی سفارش تلفنی',
            'desc'         => ' ',
            'std'          => 'on',
            'type'         => 'on-off',
            'section'      => 'calling_order',
        ),
        array(
            'id'           => 'calling_button_label',
            'label'        => 'برچسب دکمه',
            'desc'         => 'برچسب دلخواه مورد نظرتان برای دکمه تماس تلفنی را وارد کنید.',
            'type'         => 'text',
            'section'      => 'calling_order',
            'rows'         => '1',
            'condition'    => 'calling_order_status:is(on)'
        ),
        /* end section single_product */
        array(
            'id'           => 'otp',
            'label'        => 'فعال سازی ورود و ثبت نام با موبایل',
            'desc'         => 'با فعال کردن این گزینه ، در فرم ثبت نام و لاگین ، به حای ایمیل ، فیلد شماره موبایل نمایش داده میشود و کاربر میتواند با استفاده از شماره تلفن همراه ثبت نام کند.',
            'std'          => 'on',
            'type'         => 'on-off',
            'section'      => 'otp_tab',
        ),
        array(
            'id'           => 'otp_verification',
            'label'        => 'فعال کردن تایید شماره موبایل',
            'desc'         => 'اگر این گزینه فعال باشد به شماره تلفن کاربر کد یکبار مصرف ارسال شده و کاربر با وارد کردن آن کد در سایت ، صحت شماره خود را تایید میکند.',
            'std'          => 'on',
            'type'         => 'on-off',
            'section'      => 'otp_tab',
        ),

	)
);

/* settings are not the same update the DB */
if ( $saved_settings !== $custom_settings ) {
	update_option( 'option_tree_settings', $custom_settings );
}
