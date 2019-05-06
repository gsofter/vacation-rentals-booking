function guests_select_option(e, t) {
    "Homes" == t ? $(e + " option:gt(9)").removeAttr("disabled").show() : (value = $(e).val(), value - 0 > 10 && $(e + " option").removeAttr("selected"), $(e + " option:gt(9)").attr("disabled", !0).hide())
}

function datepicker_hide_on_scroll() {
    $(document).on("click", ".hasDatepicker.ui-datepicker-target", function() {
        $(this).hasClass("hasDatepicker") && ($("#ui-datepicker-div").show(), $(this).datepicker("show"))
    }), $(window).width() > 760 ? datepicker_on_descktop_scroll() : datepicker_on_mobile_scroll()
}

function datepicker_hide() {
    $("#ui-datepicker-div").hide(), $(".hasDatepicker").datepicker("hide"), $(".hasDatepicker, .ui-datepicker-target").blur(), $(".tooltip.fade.top.in").hide()
}

function datepicker_on_mobile_scroll() {
    $(window).on("touchmove", function(e) {
        datepicker_hide()
    }), $(".manage-listing-row-container,.manage-listing-content-wrapper,.modal-content,.contact-modal,.sidebar").on("touchmove", function() {
        datepicker_hide(), $(".ui-datepicker-target").trigger("blur")
    })
}

function datepicker_on_descktop_scroll() {
    $(window).scroll(function(e) {
        datepicker_hide(), $("body").trigger("mousedown")
    }), $(".manage-listing-row-container,.manage-listing-content-wrapper,.modal-content,.contact-modal,.sidebar").scroll(function() {
        datepicker_hide(), $("body").trigger("mousedown")
    })
}

function homeAutocomplete() {
    document.getElementById("location") && (home_autocomplete = new google.maps.places.Autocomplete(document.getElementById("location")), home_autocomplete.addListener("place_changed", trigger_checkin)), document.getElementById("mob-search-location") && (home_mob_autocomplete = new google.maps.places.Autocomplete(document.getElementById("mob-search-location")), google.maps.event.addListener(home_mob_autocomplete, "place_changed", function() {
        var e = $("#mob-search-location").val(),
            t = e.replace(" ", "+");
        window.location.href = APP_URL + "/s?location=" + t
    }))
}

function getTipContainer(e) {
    var t = e;
    return ($(e).is('input[type="checkbox"]') || $(e).is('input[type="radio"]') || $(e).is("select")) && (t = $(e).parents(".control-group").get(0)), t
}

function headerAutocomplete() {
    document.getElementById("header-search-form") && (header_autocomplete = new google.maps.places.Autocomplete(document.getElementById("header-search-form")), google.maps.event.addListener(header_autocomplete, "place_changed", function() {
        $("#header-search-settings").addClass("shown"), $("#header-search-checkin").trigger("click"), $(".webcot-lg-datepicker button").trigger("click")
    })), document.getElementById("header-search-form-mob") && (sm_autocomplete = new google.maps.places.Autocomplete(document.getElementById("header-search-form-mob")), google.maps.event.addListener(sm_autocomplete, "place_changed", function() {
        $("#header-search-form").val($("#header-search-form-mob").val()), $("#modal_checkin").trigger("click")
    }))
}

function trigger_checkin() {
    $("#checkin").trigger("click")
}

function res_menu() {
    $(".sub_menu_header i.fa-bars").click(function() {
        $(".sub_menu_header").toggleClass("open")
    })
}

function ajax_cnt() {
    var e = $("#ajax_header").outerHeight(),
        t = $("#js-manage-listing-footer").outerHeight(),
        a = $("#header").outerHeight(),
        o = $(window).height() - (e + t + a);
    $("#ajax_container").css("cssText", "height : " + o + "px")
}

function height1() {
    if ($(window).width() > 767) var e = $("#js-manage-listing-footer").outerHeight();
    else var e = 0;
    if ($(".tespri").hasClass("fixed")) var t = 0;
    else var t = $("#header").outerHeight();
    var a = $("#ajax_header").outerHeight(),
        o = $(".publish-actions").outerHeight(),
        i = $(window).height(),
        n = i - (e + t + a + o);
    $(".height_adj").css("cssText", "height : " + n + "px !important")
}

function pajinateInit() {
    $(".pajinate").each(function() {
        $(this).pajinate({
            items_per_page: 5,
            item_container_id: ".pajinate-item-container",
            nav_panel_id: ".pagination-nav ul",
            show_first_last: !1,
            wrap_around: !1,
            num_page_links_to_display: 8
        })
    })
}
var home_autocomplete, home_mob_autocomplete, daterangepicker_format = $('meta[name="daterangepicker_format"]').attr("content"),
    datepicker_format = $('meta[name="datepicker_format"]').attr("content"),
    datedisplay_format = $('meta[name="datedisplay_format"]').attr("content"),
    current_refinement = "Homes";
guests_select_option("#modal_guests", current_refinement), guests_select_option("#header-search-guests", current_refinement), $(document).ready(function() {
    $(window).keydown(function(e) {
        return "header-search-form" != e.target.id && (window.location.href == APP_URL + "/login" || window.location.href == APP_URL + "/signup_login" || window.location.href == APP_URL + "/") || (13 != e.keyCode ? ($(".searchbar__location-error").hide(), $(".searchbar__location-error").addClass("hide"), !0) : "" == $("#header-search-form").val() ? ($("#header-search-settings").removeClass("shown"), $(".daterangepicker").hide(), $(".searchbar__location-error").show(), $(".searchbar__location-error").removeClass("hide"), e.preventDefault(), !1) : void 0)
    })
}), $(document).ready(function() {
    $("#header-search-checkin").attr("placeholder", datedisplay_format), $("#header-search-checkout").attr("placeholder", datedisplay_format), $(".holecheck").click(function(e) {
        e.stopPropagation()
    })
}), $(document).mouseup(function(e) {
    var t = $(".header-dropdown");
    t.is(e.target) || 0 !== t.has(e.target).length || t.hide()
}), datepicker_hide_on_scroll(), $(window).resize(function() {
    datepicker_hide_on_scroll()
}), $(".modal-close").click(function() {
    $("body").removeClass("pos-fix"), $("#ui-datepicker-div").hide()
}), $(function() {
    var e = $("[rel~=tooltip]"),
        t = !1,
        a = !1;
    e.unbind("mouseenter").bind("mouseenter", function() {
        if (t = $(this), tip = t.attr("title"), a = $('<div id="tooltip1"></div>'), !tip || "" == tip) return !1;
        t.removeAttr("title"), a.css("opacity", 0).html(tip).appendTo("body");
        var e = function() {
            $(window).width() < 1.5 * a.outerWidth() ? a.css("max-width", $(window).width() / 2) : a.css("max-width", 340);
            var e = t.offset().left + t.outerWidth() / 2 - a.outerWidth() / 2,
                o = t.offset().top - a.outerHeight() - 20;
            if (e < 0 ? (e = t.offset().left + t.outerWidth() / 2 - 20, a.addClass("left")) : a.removeClass("left"), e + a.outerWidth() > $(window).width() ? (e = t.offset().left - a.outerWidth() + t.outerWidth() / 2 + 20, a.addClass("right")) : a.removeClass("right"), o < 0) {
                var o = t.offset().top + t.outerHeight();
                a.addClass("top")
            } else a.removeClass("top");
            a.css({
                left: e,
                top: o
            }).animate({
                top: "+=10",
                opacity: 1
            }, 50)
        };
        e(), $(window).resize(e);
        var o = function() {
            a.animate({
                top: "-=10",
                opacity: 0
            }, 50, function() {
                $(this).remove()
            }), t.attr("title", tip)
        };
        t.unbind("mouseleave").bind("mouseleave", o), a.unbind("click").bind("click", o)
    })
}), $(function() {
    $("#home_slider").responsiveSlides({
        auto: !0,
        pager: !1,
        nav: !1,
        speed: 2e3,
        timeout: 8e3
    }), $("#bottom_slider").responsiveSlides({
        auto: !0,
        pager: !1,
        nav: !0
    })
}), $("#bottom_slider").responsiveSlides({
    auto: !0,
    speed: 500,
    timeout: 4e3,
    pager: !1,
    nav: !0,
    random: !1,
    pause: !1,
    pauseControls: !0,
    prevText: "Previous",
    nextText: "Next",
    maxwidth: "",
    navContainer: "",
    manualControls: "",
    namespace: "bottom_slider",
    before: function() {},
    after: function() {}
}), !0 === $(".manage-listing-row-container").hasClass("has-collapsed-nav") && $("#js-manage-listing-nav").addClass("manage-listing-nav"), $(".search-modal-trigger, #sm-search-field").click(function() {
    $("#search-modal--sm").removeClass("hide"), $("#search-modal--sm").attr("aria-hidden", "false")
}), $(".search-modal-container .modal-close").click(function() {
    $("#search-modal--sm").addClass("hide"), $("#search-modal--sm").attr("aria-hidden", "true")
}), "undefined" == typeof google && (window.location.href = APP_URL + "/in_secure"), homeAutocomplete();
var header_autocomplete, sm_autocomplete, previous_currency, current_url = window.location.href.split("?")[0],
    last_part = current_url.substr(current_url.lastIndexOf("/")),
    last_part1 = current_url.substr(current_url.lastIndexOf("/") + 1);
"/s" != last_part ? headerAutocomplete() : $("#header-search-form-mob").keypress(function(e) {
    13 === e.keyCode && e.preventDefault()
}), start = moment(), $("#header-search-checkin").daterangepicker({
    minDate: start,
    dateLimitMin: {
        days: 1
    },
    autoApply: !0,
    autoUpdateInput: !1,
    locale: {
        format: daterangepicker_format
    }
}), $("#header-search-checkin").on("apply.daterangepicker", function(e, t) {
    startDateInput = $('input[name="checkin"]'), endDateInput = $('input[name="checkout"]'), startDate = t.startDate, endDate = t.endDate, $("#header-search-checkout").data("daterangepicker").setStartDate(startDate), $("#header-search-checkout").data("daterangepicker").setEndDate(endDate), startDateInput.val(startDate.format(daterangepicker_format)), endDateInput.val(endDate.format(daterangepicker_format)), $("#header-search-checkin").val(startDate.format(daterangepicker_format)), $("#header-search-checkout").val(endDate.format(daterangepicker_format))
}), $("#header-search-checkout").daterangepicker({
    minDate: start,
    dateLimitMin: {
        days: 1
    },
    autoApply: !0,
    autoUpdateInput: !1,
    locale: {
        format: daterangepicker_format
    }
}), $("#header-search-checkout").on("apply.daterangepicker", function(e, t) {
    startDateInput = $('input[name="checkin"]'), endDateInput = $('input[name="checkout"]'), startDate = t.startDate, endDate = t.endDate, $("#header-search-checkin").data("daterangepicker").setStartDate(startDate), $("#header-search-checkin").data("daterangepicker").setEndDate(endDate), startDateInput.val(startDate.format(daterangepicker_format)), endDateInput.val(endDate.format(daterangepicker_format)), $("#header-search-checkin").val(startDate.format(daterangepicker_format)), $("#header-search-checkout").val(endDate.format(daterangepicker_format))
}), start = moment(), $("#searchbar-form").submit(function(e) {
    "" == $("#location").val() ? ($(".searchbar__location-error").removeClass("hide"), e.preventDefault()) : $(".searchbar__location-error").addClass("hide")
}), $("#location, #header-location--sm").keyup(function() {
    $(".searchbar__location-error").addClass("hide")
}), $(".search-form").submit(function(e) {
    var t = $('input[name="checkin"]').val(),
        a = $('input[name="checkout"]').val(),
        o = $("#header-search-guests").val(),
        i = "",
        n = "";
    $(".head_room_type").each(function() {
        $(this).is(":checked") && (i += $(this).val() + ",")
    }), $(".head_cat_type").each(function() {
        $(this).is(":checked") && (n += $(this).val() + ",")
    }), i = i.slice(0, -1), n = n.slice(0, -1);
    var r = $("#header-search-form").val().replace(" ", "+");
    window.location.href = APP_URL + "/s?locations=" + r + "&checkin=" + t + "&checkout=" + a + "&guests=" + o + "&room_type=" + i + "&host_experience_category=" + n + "&current_refinement=" + current_refinement, e.preventDefault()
}), $("html").click(function() {
    $("#header-search-settings").removeClass("shown")
}), $(document).on("click", ".menu-item", function() {
    "#" == $(this).attr("href") && $("body").removeClass("pos-fix")
}), $("#header-search-settings").click(function(e) {
    e.stopPropagation()
}), $("#ui-datepicker-div").click(function(e) {
    e.stopPropagation()
}), $(".daterangepicker").click(function(e) {
    e.stopPropagation()
}), $(".searchbar").length && (start = moment(), $("#checkin").datepicker({
    minDate: 0,
    dateFormat: datepicker_format,
    onSelect: function(e, t) {
        $('input[name="checkin"]').val(e);
        var a = $("#checkout").datepicker("getDate"),
            o = $("#checkin").datepicker("getDate");
        o.setDate(o.getDate() + 1), $("#checkout").datepicker("option", "minDate", o), ("" == $("#checkout").val() || o > a) && ($("#checkout").datepicker("setDate", o), $('input[name="checkout"]').val(jQuery.datepicker.formatDate(datepicker_format, o)), setTimeout(function() {
            $("#checkout").datepicker("show")
        }, 20))
    }
}), $("#checkout").datepicker({
    minDate: 1,
    dateFormat: datepicker_format,
    onSelect: function(e, t) {
        var a = $("#checkin").val(),
            o = $("#checkout").val();
        if ($('input[name="checkout"]').val(e), "" == a || "" == o) return a = moment(), o = a.clone().add("1", "days"), $("#checkin").datepicker("setDate", a.toDate()), $('input[name="checkin"]').val(jQuery.datepicker.formatDate(datepicker_format, a.toDate())), $("#checkout").datepicker("option", "minDate", o.toDate()), setTimeout(function() {
            $("#checkin").datepicker("show")
        }, 20), !1
    }
})), app.controller("payment", ["$scope", "$http", function(e, t) {
    $(".cancel-coupon").click(function() {
        $("#billing-table").removeClass("coupon-section-open"), $("#restric_apply").show(), $("#coupon_disabled_message").hide()
    }), $("#apply-coupon").click(function() {
        var e = $(".coupon-code-field").val(),
            a = $("input[name=session_key]").val();
        t.post(APP_URL + "/payments/apply_coupon", {
            coupon_code: e,
            s_key: a
        }).then(function(e) {
            e.data.message ? ($("#coupon_disabled_message").show(), $("#coupon_disabled_message").text(e.data.message), $("#after_apply_remove").hide()) : ($("#coupon_disabled_message").hide(), $("#restric_apply").hide(), $("#after_apply").hide(), $("#after_apply_remove").show(), $("#after_apply_coupon").show(), $("#after_apply_amount").show(), $("#applied_coupen_amount").text(e.data.coupon_amount), $("#payment_total").text(e.data.coupen_applied_total), window.location.reload())
        })
    }), $("#remove_coupon").click(function() {
        t.post(APP_URL + "/payments/remove_coupon", {}).then(function(e) {
            window.location.reload()
        })
    })
}]), $(document).on("change", "#payment-method-select", function() {
    "paypal" == $(this).val() ? ($("#payment-method-cc").hide(), $(".cc").hide(), $("." + $(this).val()).addClass("active"), $("." + $(this).val()).addClass("active"), $("." + $(this).val() + " > .payment-logo").removeClass("inactive")) : ($("#payment-method-cc").show(), $(".cc").show(), $(".paypal").removeClass("active"), $(".paypal > .payment-logo").addClass("inactive")), $('[name="payment_method"]').val($(this).val())
}), $(document).ready(function() {
    setTimeout(function() {
        "paypal" == $("#payment-method-select").val() ? ($("#payment-method-cc").hide(), $(".cc").hide(), $("." + $("#payment-method-select").val()).addClass("active"), $("." + $("#payment-method-select").val()).addClass("active"), $("." + $("#payment-method-select").val() + " > .payment-logo").removeClass("inactive")) : ($("#payment-method-cc").show(), $(".cc").show(), $(".paypal").removeClass("active"), $(".paypal > .payment-logo").addClass("inactive")), $('[name="payment_method"]').val($("#payment-method-select").val())
    }, 1e3)
}), $("#country-select").change(function() {
    $("#billing-country").text($("#country-select option:selected").text()), $('[name="country"]').val($(this).val())
}), $("#billing-country").text($("#country-select option:selected").text()), $('[name="country"]').val($("#country-select option:selected").val()), app.controller("footer", ["$scope", "$http", function(e, t) {
    $("#currency_footer").click(function() {
        previous_currency = this.value
    }).change(function() {
        t.post(APP_URL + "/set_session", {
            currency: $(this).val(),
            previous_currency: previous_currency
        }).then(function(e) {
            location.reload()
        })
    }), $("#language_footer").change(function() {
        t.post(APP_URL + "/set_session", {
            language: $(this).val()
        }).then(function(e) {
            location.reload()
        })
    }), $(".room_status_dropdown").change(function() {
        var e = {};
        e.status = $(this).val();
        var a = $(this).closest("li.listing").find(".global-ajax-form-loader");
        a.show();
        var o = JSON.stringify(e),
            i = $(this).attr("data-room-id");
        t.post("manage-listing/" + i + "/update_rooms", {
            data: o
        }).then(function(t) {
            "Unlisted" == e.status ? ($('[data-room-id="div_' + i + '"] > i').addClass("dot-danger"), $('[data-room-id="div_' + i + '"] > i').removeClass("dot-success")) : "Listed" == e.status && ($('[data-room-id="div_' + i + '"] > i').removeClass("dot-danger"), $('[data-room-id="div_' + i + '"] > i').addClass("dot-success")), a.hide(), location.reload()
        })
    }), $(document).on("click", ".wl-modal-footer__text", function() {
        $(".wl-modal-footer__form").removeClass("hide"), $(".wl-create-link-container").addClass("hide")
    }), $("#send-email").unbind("click").click(function() {
        var e = $("#email-list").val();
        "" != e && t.post("invite/share_email", {
            emails: e
        }).then(function(e) {
            "true" == e.data ? ($("#success_message").fadeIn(800), $("#success_message").fadeOut(), $("#email-list").val("")) : ($("#error_message").fadeIn(800), $("#error_message").fadeOut())
        })
    })
}]), app.controller("payout_preferences", ["$scope", "$http", function(e, t) {
    $("#add-payout-method-button").click(function() {
        $("#payout_popup1").removeClass("hide").attr("aria-hidden", "false")
    }), $("#address").submit(function() {
        var e = '<div class="alert alert-error alert-error alert-header"><a class="close alert-close" href="javascript:void(0);"></a><i class="icon alert-icon icon-alert-alt"></i>';
        return "" == $("#payout_info_payout_address1").val().trim() ? ($("#popup1_flash-container").html(e + $("#blank_address").val() + "</div>"), !1) : "" == $("#payout_info_payout_city").val().trim() ? ($("#popup1_flash-container").html(e + $("#blank_city").val() + "</div>"), !1) : "" == $("#payout_info_payout_zip").val().trim() ? ($("#popup1_flash-container").html(e + $("#blank_post").val() + "</div>"), !1) : null == $("#payout_info_payout_country").val().trim() ? ($("#popup1_flash-container").html(e + $("#blank_country").val() + "</div>"), !1) : ($("#payout_info_payout2_address1").val($("#payout_info_payout_address1").val()), $("#payout_info_payout2_address2").val($("#payout_info_payout_address2").val()), $("#payout_info_payout2_city").val($("#payout_info_payout_city").val()), $("#payout_info_payout2_state").val($("#payout_info_payout_state").val()), $("#payout_info_payout2_zip").val($("#payout_info_payout_zip").val()), $("#payout_info_payout2_country").val($("#payout_info_payout_country").val()), $("#payout_popup1").addClass("hide"), void $("#payout_popup2").removeClass("hide").attr("aria-hidden", "false"))
    }), $("#select-payout-method-submit").click(function() {
        return null == $('[id="payout2_method"]:checked').val() ? ($("#popup2_flash-container").html('<div class="alert alert-error alert-error alert-header"><a class="close alert-close" href="javascript:void(0);"></a><i class="icon alert-icon icon-alert-alt"></i>' + $("#choose_method").val() + "</div>"), !1) : ($("#payout_info_payout3_address1").val($("#payout_info_payout2_address1").val()), $("#payout_info_payout3_address2").val($("#payout_info_payout2_address2").val()), $("#payout_info_payout3_city").val($("#payout_info_payout2_city").val()), $("#payout_info_payout3_state").val($("#payout_info_payout2_state").val()), $("#payout_info_payout3_zip").val($("#payout_info_payout2_zip").val()), $("#payout_info_payout3_country").val($("#payout_info_payout2_country").val()), $("#payout3_method").val($('[id="payout2_method"]:checked').val()), payout_method = $("#payout3_method").val(), "Stripe" == payout_method ? ($("#payout_paypal").submit(), !0) : ($("#payout_popup2").addClass("hide"), void $("#payout_popup3").removeClass("hide").attr("aria-hidden", "false")))
    }), $("#payout_paypal").submit(function() {
        return payout_method = $("#payout3_method").val(), "PayPal" != payout_method || (!!/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($("#paypal_email").val()) || ($("#popup3_flash-container").removeClass("hide"), !1))
    }), $(".panel-close").click(function() {
        $(this).parent().parent().parent().parent().parent().addClass("hide")
    }), $('[id$="_flash-container"]').on("click", ".alert-close", function() {
        $(this).parent().parent().html("")
    })
}]), app.directive("postsPaginationTransaction", function() {
    return {
        restrict: "E",
        template: '<h3 class="status-text text-center" ng-show="loading">{{trans_lang.loading}}...</h3><h3 class="status-text text-center" ng-hide="result.length || loading">{{trans_lang.no_transactions}}</h3><ul class="pagination" ng-show="result.length"><li ng-show="currentPage > 1"><a href="javascript:void(0)" ng-click="pagination_result(type, 1)">&laquo;</a></li><li ng-show="currentPage > 1"><a href="javascript:void(0)" ng-click="pagination_result(type, currentPage-1)">&lsaquo; ' + $("#pagin_prev").val() + ' </a></li><li ng-repeat="i in range" ng-class="{active : currentPage == i}"><a href="javascript:void(0)" ng-click="pagination_result(type, i)">{{i}}</a></li><li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="pagination_result(type, currentPage+1)">' + $("#pagin_next").val() + ' &rsaquo;</a></li><li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="pagination_result(type, totalPages)">&raquo;</a></li></ul>'
    }
}).controller("transaction_history", ["$scope", "$http", function(e, t) {
    e.paid_out = 0, $("li > .tab-item").click(function() {
        var t = $(this).attr("aria-controls");
        "false" == $(this).attr("aria-selected") && ($(".tab-item").attr("aria-selected", "false"), $(this).attr("aria-selected", "true"), $(".tab-panel").hide(), $("#" + t).show()), e.type = t, e.pagination_result(t, 1)
    }), $('[class^="payout-"]').change(function() {
        var t = $(this).parent().parent().parent().parent().attr("id");
        e.type = t, e.pagination_result(t, 1)
    }), e.pagination_result = function(a, o) {
        var i = {};
        i.type = a, i.payout_method = $("#" + i.type + " .payout-method").val(), i.listing = $("#" + i.type + " .payout-listing").val(), i.year = $("#" + i.type + " .payout-year").val(), i.start_month = $("#" + i.type + " .payout-start-month").val(), i.end_month = $("#" + i.type + " .payout-end-month").val();
        var n = JSON.stringify(i);
        null == o && (o = 1), "completed-transactions" == a && (e.completed_csv_param = "type=" + i.type + "&payout_method=" + i.payout_method + "&listing=" + i.listing + "&year=" + i.year + "&start_month=" + i.start_month + "&end_month=" + i.end_month + "&page=" + o), "future-transactions" == a && (e.future_csv_param = "type=" + i.type + "&payout_method=" + i.payout_method + "&listing=" + i.listing + "&page=" + o), e.result_show = !1, e.loading = !0, t.post(APP_URL + "/users/result_transaction_history?page=" + o, {
            data: n
        }).then(function(t) {
            if (e.loading = !1, e.result = t.data.data, 0 != e.result.length) {
                e.result_show = !0, e.totalPages = t.data.last_page, e.currentPage = t.data.current_page, e.type = a;
                for (var o = [], i = 1; i <= t.data.last_page; i++) o.push(i);
                e.range = o;
                var n = 0;
                for (i = 0; i < e.result.length; i++) n += e.result[i].amount;
                e.paid_out = e.result[0].currency_symbol + n
            }
        })
    }, e.pagination_result("completed-transactions", 1)
}]), app.controller("reviews", ["$scope", "$http", function(e, t) {
    $("li > .tab-item").click(function() {
        var e = $(this).attr("aria-controls");
        "false" == $(this).attr("aria-selected") && ($(".tab-item").attr("aria-selected", "false"), $(this).attr("aria-selected", "true"), $(".tab-panel").hide(), $("#" + e).show())
    })
}]), app.controller("reviews_edit_host", ["$scope", "$http", function(e, t) {
    $(".next-facet").click(function() {
        $("#double-blind-copy").addClass("hide"), $("#host-summary").removeClass("hide"), $("#guest").removeClass("hide")
    }), $(".exp_review_submit").click(function() {
        var e = $(this).parent().parent().attr("id"),
            a = {};
        $("#" + e + "-form input, #" + e + " textarea").each(function() {
            "radio" != $(this).attr("type") ? a[$(this).attr("name")] = $(this).val() : $(this).is(":checked") && (a[$(this).attr("name")] = $(this).val())
        });
        var o = $("#reservation_id").val();
        if ("host-summary" == e || "guest" == e) {
            if ("" == $("#review_comments").val()) return $('[for="review_comments"]').show(), $("#review_comments").addClass("invalid"), !1;
            if ($('[for="review_comments"]').hide(), $("#review_comments").removeClass("invalid"), "host-summary" == e) {
                if (!$('[name="rating"]').is(":checked")) return $('[for="review_rating"]').show(), !1;
                $('[for="review_rating"]').hide()
            }
        }
        a.review_id = $("#review_id").val();
        var i = JSON.stringify(a);
        $(".review-container").addClass("loading"), t.post(APP_URL + "/host_experience_reviews/edit/" + o, {
            data: i
        }).then(function(e) {
            $(".review-container").removeClass("loading"), e.data.success && (window.location.href = APP_URL + "/users/reviews")
        })
    }), $(".review_submit").click(function() {
        var e = $(this).parent().parent().attr("id"),
            a = {};
        $("#" + e + "-form input, #" + e + " textarea").each(function() {
            "radio" != $(this).attr("type") ? a[$(this).attr("name")] = $(this).val() : $(this).is(":checked") && (a[$(this).attr("name")] = $(this).val())
        });
        var o = $("#reservation_id").val();
        if ("host-summary" == e || "guest" == e) {
            if ("" == $("#review_comments").val()) return $('[for="review_comments"]').show(), $("#review_comments").addClass("invalid"), !1;
            if ($('[for="review_comments"]').hide(), $("#review_comments").removeClass("invalid"), "host-summary" == e) {
                if (!$('[name="rating"]').is(":checked")) return $('[for="review_rating"]').show(), !1;
                $('[for="review_rating"]').hide()
            }
        }
        a.review_id = $("#review_id").val();
        var i = JSON.stringify(a);
        $(".review-container").addClass("loading"), t.post(APP_URL + "/reviews/edit/" + o, {
            data: i
        }).then(function(t) {
            $(".review-container").removeClass("loading"), t.data.success && ("host-details" != e && "guest" != e || (window.location.href = APP_URL + "/users/reviews"), $("#review_id").val(t.data.review_id), $("#" + e).addClass("hide"), $("#" + e).next().removeClass("hide"))
        })
    })
}]), app.directive("file", function() {
    return {
        scope: {
            file: "="
        },
        link: function(e, t, a) {
            t.bind("change", function(t) {
                var a = t.target.files;
                e.file = a || void 0, e.$apply()
            })
        }
    }
}), app.controller("Tabsh", ["$scope", function(e) {
    e.show = 1, e.tab1 = !0, pajinateInit()
}]), $(".language-link").click(function(e) {
    e.preventDefault(), $("body").addClass("pos-fix"), $(".mini-language").show()
}), $(".login-close-language").click(function(e) {
    $("body").removeClass("pos-fix"), $(".mini-language").hide()
}), $(".top-home").click(function(e) {
    e.stopPropagation()
}), $("#language_save_button").click(function() {
    $("#selected_language").html(""), $(".language_select").each(function() {
        $(this).is(":checked") && $("#selected_language").append('<span class="btn btn-lang space-1">' + $(this).data("name") + '  <a href="javascript:void(0)" class="text-normal" id="remove_language"> <input type="hidden" value=" ' + $(this).val() + '" name="language[]"> <i class="x icon icon-remove" title="Remove from selection"></i></a> </span>'), $(".mini-language").hide(), $("body").removeClass("pos-fix")
    })
}), $(document).on("click", '[id^="remove_language"]', function() {
    $(this).parent().remove()
}), $(document).ready(function() {
    $(document).on("click", ".sidebarbar", function() {
        $(".main_bar").toggleClass("newmain"), $(".het").toggleClass("het1")
    })
}), $(document).scroll(function() {
    if ($(window).width() > 767) return !0;
    $(this).scrollTop() > 100 ? $(".mobover").fadeIn() : $(".mobover").fadeOut()
}), $(document).ready(function() {
    $("#ftb, #ftbm").click(function() {
        $(".home_pro").show(), $(".exp_cat").hide()
    }), $("#ftb1, #ftbm1").click(function() {
        $(".exp_cat").show(), $(".home_pro").hide()
    })
}), lang = $("html").attr("lang"), rtl = !1, "ar" == lang && (rtl = !0), $(document).ready(function() {
    var e = $(".listing-nav-sm");
    $(window).scroll(function() {
        e.stop().animate({
            top: 101 - $(window).scrollTop() + "px"
        }, "slow")
    })
}), $(".mod_cls").click(function() {
    $("body").removeClass("pos-fix3")
}), $(".pop-striped").click(function() {
    $("body").addClass("pos-fix3")
}), $(".panel-close").click(function() {
    $("body").removeClass("pos-fix3")
}), $(".modal-close").click(function() {
    $("body").removeClass("pos-fix3")
}), $(document).ready(function() {
    res_menu()
}), $(document).ready(function() {
    $(".amenities_title a").click(function() {
        $(this).parent().siblings(".amenities_info").toggleClass("active")
    })
}), $(window).scroll(function() {
    ajax_cnt()
}), $(window).resize(function() {
    ajax_cnt()
}), $(document).ready(function() {
    ajax_cnt()
}), setTimeout(function() {
    ajax_cnt()
}, 10), $(document).ready(function() {
    $("#vn-click").click(function() {
        $(this).parent(".morefil").toggleClass("more_plushide")
    }), $(".bottom_show #vn-click").click(function() {
        $(".morefil").toggleClass("more_plushide")
    })
}), $(document).ready(function() {
    $(".chat_box i.chat_toggle.icon-chevron-up").hide(), $(".chat_body").hide(), $(".chat_head").click(function() {
        $(".chat_box i.chat_toggle").toggle(), $(".chat_body").toggle(), $(".chat_box").toggleClass("active"), $(".chat_box").hasClass("active") ? $("body").addClass("non_scrl") : $("body").removeClass("non_scrl")
    })
}), $(document).on("click", "#cancellation-policy-modal-link", function() {
    $("#cancellation-policy-modal").attr("aria-hidden", "false")
}), $(document).on("click", ".panel-close", function() {
    $(".modal").attr("aria-hidden", "true")
}), window.addEventListener("load", function() {
    window.cookieconsent.utils.isMobile = function() {
        return !1
    }, window.cookieconsent.initialise({
        palette: {
            popup: {
                background: "#252e39"
            },
            button: {
                background: "#14a7d0"
            }
        },
        cookie: {
            name: "vacationrentals_privacy_confirm",
            expiryDays: 365,
            path: "/"
        },
        showLink: !1,
        theme: "classic",
        position: "bottom",
        content: {
            message: 'In an effort towards providing our users with the utmost transparency, please review our full <a href="' + APP_URL + '/privacy_policy">privacy policy</a> and user data <a href="' + APP_URL + '/terms_of_service">terms of service</a>.<br> This site also uses cookies to ensure you receive the best experience on our site.'
        },
        window: '<div role="dialog" aria-label="cookieconsent" aria-describedby="cookieconsent:desc" class="cc-window {{classes}}"><div class="cc-container">{{children}}</div></div>'
    })
}), $(window).scroll(function() {
    height1()
}), $(window).resize(function() {
    height1()
}), $(document).ready(function() {
    height1()
}), setTimeout(function() {
    height1()
}, 10), $(document).ready(function() {
    $(".search-modal-trigger, #photos, #photo-gallery, .button_1b5aaxl, .link-reset.burger--sm.header-logo, .vid_pop").click(function() {
        $("body, html").addClass("non_scrl")
    }), $(document).on("click", ".modal-close, #header .nav-mask--sm, .popup", function() {
        $("body, html").removeClass("non_scrl")
    })
}), $(document).ready(function() {
    $(".subnav-item.show-collapsed-nav-link").click(function() {
        $("body").toggleClass("non_scrl")
    })
}), $(document).ready(function() {
    $(".vr_form input, .vr_form select, .vr_form textarea").each(function() {
            var e = getTipContainer(this);
            $(e).tooltipster({
                debug: !1,
                trigger: "custom",
                animation: "grow",
                theme: "tooltipster-shadow",
                maxWidth: 125,
                side: "top",
                multiple: !1,
                timer: 1500,
                autoClose: !0,
                functionPosition: function(e, t, a) {
                    var o = t.geo.origin.offset.right,
                        i = a.size.width;
                    return a.coord.left = o - i, a
                }
            })
        }), $.validator.addMethod("check_dob", function(e, t) {
            var a = e,
                o = a.split("-"),
                i = o[2],
                n = o[1],
                r = o[0],
                s = new Date;
            s.setFullYear(r, n - 1, i - 1);
            var c = new Date;
            return c.setFullYear(c.getFullYear() - 18), c >= s
        }, "You must be over 18 to enter"), $.validator.addMethod("letters_and_spaces_only", function(e, t) {
            return this.optional(t) || /^[a-z\s]+$/i.test(e)
        }, "Only alphabetical characters and spaces"), $.extend(jQuery.validator.messages, {
            required: "Required",
            lettersonly: "Only alphabetical characters A-Z allowed",
            email: "Invalid email format",
            digits: "Only numbers allowed",
            check_dob: "Sorry, you must be 18+ to register"
        }),
        function() {
            var e = $("#phone_number"),
                t = $(".error-msg"),
                a = $(".valid-msg"),
                o = $("#phone_code");
            $.fn.intlTelInput.getCountryData(), e.intlTelInput({
                allowDropdown: !0,
                autoPlaceholder: "aggressive",
                formatOnDisplay: !1,
                geoIpLookup: function(e) {
                    $.get("https://ipinfo.io", function() {}, "jsonp").always(function(t) {
                        var a = t && t.country ? t.country : "";
                        e(a)
                    })
                },
                initialCountry: "auto",
                nationalMode: !0,
                hiddenInput: "phone_full",
                placeholderNumberType: "MOBILE",
                preferredCountries: ["us", "ca", "gb", "it", "de", "mx"],
                separateDialCode: !0,
                utilsScript: APP_URL + "/vendors/intl-tel-input/build/js/utils.js"
            }), e.intlTelInput("getSelectedCountryData").iso2, ! function() {
                o.val() && e.intlTelInput("setCountry", o.val())
            }(), e.on("countrychange", function(e, t) {
                o.val(t.iso2)
            }), o.change(function() {
                e.intlTelInput("setCountry", $(this).val())
            });
            var i = function() {
                e.removeClass("error"), t.addClass("hide"), a.addClass("hide")
            };
            e.blur(function() {
                i(), $.trim(e.val()) && (e.intlTelInput("isValidNumber") ? a.removeClass("hide") : (e.addClass("error"), t.removeClass("hide")))
            })
        }(), $("#login_form").validate({
            rules: {
                email: {
                    required: !0,
                    email: !0
                },
                password: {
                    required: !0
                }
            },
            messages: {
                email: {
                    required: ""
                },
                password: {
                    required: ""
                }
            },
            focusCleanup: !0,
            submitHandler: function(e) {
                e.submit()
            }
        }), $(".password_reset").each(function() {
            $(this).validate({
                rules: {
                    email: {
                        required: !0,
                        email: !0
                    },
                    password: {
                        required: !0
                    }
                },
                messages: {
                    email: {
                        required: ""
                    },
                    password: {
                        required: ""
                    }
                },
                focusCleanup: !0,
                submitHandler: function(e) {
                    e.submit()
                }
            })
        }), $("#set_password_form").validate({
            rules: {
                password: {
                    required: !0,
                    minlength: "6"
                },
                password_confirmation: {
                    required: !0,
                    equalTo: "#new_password"
                }
            },
            messages: {
                password: {
                    required: "",
                    minlength: "Password must be at least 6 characters."
                },
                password_confirmation: {
                    required: "",
                    equalTo: "Your password doesn't match"
                }
            },
            errorPlacement: function(e, t) {
                var a = ($(t), t),
                    o = $(e).text(),
                    i = "";
                a = getTipContainer(t), i = $(a).data("last_error"), $(a).data("last_error", o), "" !== o && o !== i && ($(a).tooltipster("content", o), $(a).tooltipster("open"))
            },
            unhighlight: function(e, t, a) {
                var o = getTipContainer(e);
                $(o).removeClass(t).addClass(a).tooltipster("close")
            },
            submitHandler: function(e) {
                e.submit()
            }
        })
}), $(document).ready(function() {
    $(".login_popup_head, .bck_btn, .login_popup_open").click(function(e) {
        e.preventDefault(), $("body").addClass("pos-fix"), $(".sidebar").addClass("overflow-control"), $(".login_popup").show(), $(".signup_popup").hide(), $(".signup_popup2").hide(), $(".forgot-passward").hide()
    }), $(".login-close, .rm_lg").click(function(e) {
        $("body").removeClass("pos-fix"), $(".sidebar").removeClass("overflow-control"), $(".login_popup, .forgot-passward, .signup_popup, .signup_popup2").hide()
    }), $(".top-home").click(function(e) {
        e.stopPropagation()
    })
}), $(document).ready(function() {
    $(".forgot-password-popup").click(function(e) {
        e.preventDefault(), $("body").addClass("pos-fix"),
            $(".login_popup").hide(), $(".forgot-passward").show()
    }), $(".login-close").click(function(e) {
        $("body").removeClass("pos-fix"), $(".forgot-passward").hide()
    }), $(".top-home").click(function(e) {
        e.stopPropagation()
    })
}), $(document).ready(function() {
    $(".signup_popup_head").click(function(e) {
        e.preventDefault(), $("body").addClass("pos-fix"), $(".sidebar").addClass("overflow-control"), $(".signup_popup").show(), $(".login_popup").hide()
    }), $(".login-close").click(function() {
        $("body").removeClass("pos-fix"), $(".sidebar").removeClass("overflow-control"), $(".signup_popup").hide()
    }), $(".top-home").click(function(e) {
        e.stopPropagation()
    })
}), $(document).ready(function() {
    $(".signup_popup_head2").click(function(e) {
        e.preventDefault(), $("body").addClass("pos-fix"), $(".signup_popup2").show(), $(".signup_popup").hide()
    }), $(".login-close").click(function() {
        $("body").removeClass("pos-fix"), $(".signup_popup2").hide()
    }), $(".top-home").click(function(e) {
        e.stopPropagation()
    }), $(function() {
        $("select.footer-select").select2()
    })
}), $(document).ready(function() {
    $("ul.menu-group li a").click(function() {
        $(".nav--sm").css("visibility", "hidden")
    }), $(".burger--sm").click(function() {
        $(".header--sm .nav--sm").css("visibility", "visible"), $(".makent-header .header--sm .nav-content--sm").css("left", "0", "important")
    }), $(".nav-mask--sm").click(function() {
        $(".header--sm .nav--sm").css("visibility", "hidden"), $(".makent-header .header--sm .nav-content--sm").css("left", "-285px")
    }), $(".nav-mask--sm").click(function() {
        $(".header--sm .nav--sm").css("visibility", "hidden"), $(".makent-header .header--sm .nav-content--sm").css("left", "-285px")
    }), $(document).on("change", "#user_profile_pic", function() {
        $("#ajax_upload_form").submit()
    })
});
var tagSwiper = new Swiper(".tag-swipe.swiper-container", {
        speed: 400,
        spaceBetween: 100,
        centeredSlides: !0,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev"
        }
    }),
    featuredSwiper = new Swiper(".featured-swipe.swiper-container", {
        allowTouchMove: !1
    }),
    listingSwiper = new Swiper(".listing-swipe.swiper-container", {
        slidesPerView: 4,
        spaceBetween: 30,
        breakpoints: {
            320: {
                slidesPerView: 1,
                spaceBetween: 10
            },
            480: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            640: {
                slidesPerView: 3,
                spaceBetween: 30
            }
        }
    }),
    listingSwiperInProfile = new Swiper(".listing-swipe-in-profile.swiper-container", {
        freeMode: !0,
        slidesPerView: 3,
        spaceBetween: 30,
        loop: !0,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev"
        }
    });
tagSwiper.on("slideChange", function(e) {
    featuredSwiper.slideTo(tagSwiper.activeIndex);
    var t = $(".tag-swipe .swiper-slide").eq(tagSwiper.activeIndex).attr("data-id");
    $.ajax({
        url: "fetch_listings_for_tag/" + t,
        type: "GET"
    }).done(function(e) {
        if (e = jQuery.parseJSON(e), "true" == e.success) {
            $(".listing-swipe .swiper-wrapper").html("");
            for (var t = 0; t < e.data.length; t++) $(".listing-swipe .swiper-wrapper").append(e.data[t])
        }
        listingSwiper = new Swiper(".listing-swipe.swiper-container", {
            slidesPerView: 4,
            spaceBetween: 30,
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 10
                },
                480: {
                    slidesPerView: 2,
                    spaceBetween: 20
                },
                640: {
                    slidesPerView: 3,
                    spaceBetween: 30
                }
            }
        })
    })
}), $(document).ready(function() {
    $(".select2").select2()
}), $(document).ready(function() {
    $("input.icheck").iCheck({
        checkboxClass: "icheckbox_square-blue",
        radioClass: "iradio_square-blue"
    })
}), $(function() {
    $("a[href*=#]:not([href=#])").click(function() {
        if (location.pathname.replace(/^\//, "") == this.pathname.replace(/^\//, "") && location.hostname == this.hostname) {
            var e = $(this.hash);
            if (e = e.length ? e : $("[name=" + this.hash.slice(1) + "]"), e.length) return $("html,body").animate({
                scrollTop: e.offset().top
            }, 1e3), !1
        }
    })
}), pajinateInit(), $(document).on("click", ".subscribe-property-btn", function() {
    var e = $(this).data("id"),
        t = $(this).closest(".listing").find(".loading.global-ajax-form-loader");
    t.removeClass("d-none"), $.ajax({
        type: "GET",
        url: APP_URL + "/users/has_verified_phone"
    }).done(function(a) {
        t.addClass("d-none"), "true" == a ? window.location = APP_URL + "/manage-listing/" + e + "/subscribe_property" : ($(".listing-phone-verify-modal").attr("aria-hidden", "false"), $(".listing-phone-verify-modal").data("id", e))
    })
});