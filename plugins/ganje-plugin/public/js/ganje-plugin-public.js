/**
 * Define jQuery
 */
jQuery(function ($) {

    var documentOnReady = {
        // Initialize
        init: function () {
            documentOnReady.calling_order_popup();
            documentOnReady.review_form_popup();
        },


        /**
         * Default options
         */
        calling_order_popup: function () {

            $('#ganje-custom-order-button').on('click', function (event) {
                event.preventDefault();
                Swal.showLoading()

                let prodictSelectedId,
                    productVariantId = $('.variations_form').find('input[name="variation_id"]').val(),
                    productId = $(this).attr('data-value-product-id'),
                    productQty = $('.quantity').find('input[name="quantity"]').val(),
                    dataOut = {};

                // Проверяем ID товара, для вариаций свой, для простых свой.
                if (0 !== productVariantId && typeof productVariantId !== 'undefined') {
                    prodictSelectedId = productVariantId;
                } else {
                    prodictSelectedId = productId;
                }

                // Собираем данные для отправки.
                let data = {
                    id: prodictSelectedId,
                    action: 'ganje_ajax_product_form',
                    nonce: gnj_scripts.nonce,
                    qty: productQty
                };

                // Отправляем запрос.
                let request = $.ajax({
                        url: gnj_scripts.url,
                        data: data,
                        type: 'POST',
                        dataType: 'text',
                        success: function (data) {
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "You won't be able to revert this!",
                                icon: 'info',
                                html: data,
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, delete it!'
                            }).then((result) => {
                                if (result.value) {
                                    var serialized = $('.place_calling_order_form').serialize();
                                    let request = $.ajax({
                                            url: gnj_scripts.url,
                                            data: serialized,
                                            type: 'POST',
                                            dataType: 'text',
                                            success: function (data) {
                                                Swal.fire(
                                                    'Good job!',
                                                    'You clicked the button!',
                                                    'success'
                                                )
                                            },
                                            error: function (data) {
                                                Swal.fire(
                                                    'Good job!',
                                                    'You clicked the button!',
                                                    'error'
                                                )
                                            },

                                        }
                                    );
                                }
                            })
                        },

                    }
                );

                return false;
            });
        },


        review_form_popup: function () {
            var form_html = $('#review_form');
            var rangeSlider = function () {
                var slider = $('.range-slider'),
                    range = $('.range-slider__range'),
                    value = $('.range-slider__value');

                slider.each(function () {

                    value.each(function () {
                        var value = $(this).prev().attr('value');
                        if (value === '1')
                            value = 'بد';
                        if (value === '2')
                            value = 'متوسط';
                        if (value === '3')
                            value = 'خوب';
                        if (value === '4')
                            value = 'خیلی خوب';
                        if (value === '5')
                            value = 'عالی';
                        $(this).html(value);
                    });

                    range.on('input', function () {
                        if ($(this).val() === '1') {
                            $(this).next(value).html('بد');
                        }
                        if ($(this).val() === '2') {
                            $(this).next(value).html('متوسط');
                        }
                        if ($(this).val() === '3') {
                            $(this).next(value).html('خوب');
                        }
                        if ($(this).val() === '4') {
                            $(this).next(value).html('خیلی خوب');
                        }
                        if ($(this).val() === '5') {
                            $(this).next(value).html('عالی');
                        }
                    });
                });
            };

            $('#triger-comment-form').click(function (e) {
                e.preventDefault();
                Swal.fire({
                    scrollbarPadding: false,
                    title: '<strong>HTML <u>example</u></strong>',
                    html:form_html.html(),
                    showConfirmButton : false
                })
                rangeSlider();

                $('.rev-class').on('keydown keyup focusout',function () {

                    if($(this).val() === '') {
                        $(this).next().toggle();
                    }

                });
                $('.js-icon-form-addn').click(function () {
                    var neg_val = $(this).prev().val();
                    $(this).prev().val(' ');
                    $(this).after('<input class="rev-class" type="text" name="negative-rev[]" value="'+neg_val+'">');

                })
                $('.js-icon-form-addp').click(function () {
                    var pos_val = $(this).prev().val();
                    $(this).prev().val(' ');
                    $(this).after(' <input class="rev-class" type="text" name="positive-rev[]" value="'+pos_val+'">');

                })
            })
        }

    }

    $(document).ready(documentOnReady.init);

});

jQuery(document).ready(function ($) {
    var BUTTON = "#mylist_btn_",
        uriAjax = gnj_scripts.url,
        boxList = gnj_scripts.boxList,
        loading_icon = gnj_scripts.loading_icon,
        button = gnj_scripts.button,
        nonce = gnj_scripts.nonce,
        buttonHtml = "";

    function createBtn() {
        0 < $(".js-item-mylist").length &&
        $.get(button, function (source) {

            (buttonHtml = source),
                $(".js-item-mylist").each(function () {
                    var itemId = BUTTON + $(this).data("id"),
                        nameVar = "myListButton" + $(this).data("id"),
                        data = eval(nameVar);
                    renderTemplate(itemId, source, data);
                });

        });

    }

    function showLoading(t) {
        (data = $.parseJSON('{"showLoading": {"icon": "' + loading_icon + '"}}')), renderTemplate(t, buttonHtml, data);
    }

    function renderTemplate(t, a, n) {
        var e = Handlebars.compile(a)(n);
        $(t).html(e);
    }

    "undefined" != typeof myListData &&
    $.get(boxList, function (t) {
        renderTemplate("#myList_list", t, myListData);
    }),

        createBtn(),

        $("body").on("click", ".js-gd-add-mylist", function () {
            var t = $(this).data("postid"),
                a = $(this).data("userid"),
                n = BUTTON + t;
            showLoading(n),
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: uriAjax,
                    data: {action: "gd_add_mylist", itemId: t, userId: a, nonce: nonce}
                }).done(function (t) {
                    renderTemplate(n, buttonHtml, t);
                });
        }),
        $("body").on("click", ".js-gd-remove-mylist", function () {
            var a = $(this).data("postid"),
                t = $(this).data("userid"),
                n = $(this).data("styletarget"),
                e = BUTTON + a;
            showLoading(e),
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: uriAjax,
                    data: {action: "gd_remove_mylist", itemId: a, userId: t, nonce: nonce}
                }).done(function (t) {
                    "mylist" === n
                        ? $("#mylist-" + a)
                            .closest(".gd-mylist-box")
                            .fadeOut(500)
                        : renderTemplate(e, buttonHtml, t);
                });
        });
});
