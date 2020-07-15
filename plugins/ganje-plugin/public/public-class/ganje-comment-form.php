<?php

class Ganje_Commnet_Form
{
    private static $instance = null;
    private $setting;

    public function __construct()
    {
        add_filter('comment_form_field_comment', array($this, 'add_comment_fields'), 10, 1);
        add_action('comment_post', array($this, 'save_comment_review_phone_field'));
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Ganje_Commnet_Form();
        }
        return self::$instance;
    }

    public function get_Settings()
    {
        global $GanjeSetting;
        $this->setting = $GanjeSetting;
    }


    // Add
    function add_comment_fields($field)
    {
        if (is_product()) {
            $field .= '<div class="commnets">';
            //change for to foreach
            for ($i = 1; $i < 5; $i++) {

                $field .= '<div class="range-slider">
                         <label><small>خصوصیت شماره</small> ' . $i . ' </label>
                         <input name="gnj-rev-slider' . $i . '" class="range-slider__range" type="range" value="3" min="1" max="5">
                         <span class="range-slider__value">0</span></div>';

            }

            $field .= '</div>
                        <div> <label>نقاط ضعف</label><input class="rev-class" type="text" name="negative-rev[]">
                        <button class="gnj-btn-add-comment js-icon-form-addn" type="button" style="display: none;"></button></div>
                        <div> <label>نقاط قوت</label> <input class="rev-class" type="text" name="positive-rev[]" >
                        <button class="gnj-btn-add-comment js-icon-form-addp" type="button" style="display: none;"></button></div>
                        <div> <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. </p>';
        }
        return $field;
    }

// Save

    function save_comment_review_phone_field($comment_id)
    {
        for ($i = 1; $i < 5; $i++) {
            if (isset($_POST['gnj-rev-slider' . $i]))
                update_comment_meta($comment_id, 'prop' . $i, esc_attr($_POST['gnj-rev-slider' . $i]));
        }
        $rev_neg = $_POST['negative-rev'];
        $rev_pos = $_POST['positive-rev'];
        foreach ($rev_neg as $rev => $val) {
            update_comment_meta($comment_id, 'negative-rev' . $rev, esc_attr($val));
        }
        foreach ($rev_pos as $rev => $val) {
            update_comment_meta($comment_id, 'positive-rev' . $rev, esc_attr($val));
        }
    }



}

Ganje_Commnet_Form::getInstance();
