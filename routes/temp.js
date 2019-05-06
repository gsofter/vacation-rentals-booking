function tooltip_init() {
    var e = $("[rel~=tooltip]"),
        a = !1,
        t = !1;
    e.unbind("mouseenter").bind("mouseenter", function() {
        if (a = $(this), tip = a.attr("title"), t = $('<div id="tooltip1"></div>'), !tip || "" == tip) return !1;
        a.removeAttr("title"), t.css("opacity", 0).html(tip).appendTo("body");
        var e = function() {
            $(window).width() < 1.5 * t.outerWidth() ? t.css("max-width", $(window).width() / 2) : t.css("max-width", 340);
            var e = a.offset().left + a.outerWidth() / 2 - t.outerWidth() / 2,
                s = a.offset().top - t.outerHeight() - 20;
            e < 0 ? (e = a.offset().left + a.outerWidth() / 2 - 20, t.addClass("left")) : t.removeClass("left"), e + t.outerWidth() > $(window).width() ? (e = a.offset().left - t.outerWidth() + a.outerWidth() / 2 + 20, t.addClass("right")) : t.removeClass("right"), s < 0 ? (s = a.offset().top + a.outerHeight(), t.addClass("top")) : t.removeClass("top"), t.css({
                left: e,
                top: s
            }).animate({
                top: "+=10",
                opacity: 1
            }, 50)
        };
        e(), $(window).resize(e);
        var s = function() {
            t.animate({
                top: "-=10",
                opacity: 0
            }, 50, function() {
                $(this).remove()
            }), a.attr("title", tip)
        };
        a.unbind("mouseleave").bind("mouseleave", s), t.unbind("click").bind("click", s)
    })
}

function dataTablesTabRedraw() {
    $('a[data-toggle="tab"]').on("shown.bs.tab", function(e) {
        $($.fn.dataTable.tables(!0)).DataTable().columns.adjust().responsive.recalc()
    })
}

function calendar_tables_init() {
    $.fn.dataTable.absoluteOrderNumber("fixed"), $.fn.dataTable.absoluteOrder("fixed"), $("#pricing_price_table").DataTable({
        orderCellsTop: !0,
        info: !1,
        paging: !1,
        searching: !1,
        autoWidth: !1,
        responsive: !0,
        columnDefs: [{
            visible: !1,
            targets: [0, 1]
        }, {
            responsivePriority: 1,
            targets: 2
        }, {
            responsivePriority: 2,
            targets: -1
        }],
        order: [1, "asc"],
        orderFixed: [
            [0, "asc"]
        ]
    });
    $("#base_price_tbl").DataTable({
        info: !1,
        ordering: !1,
        paging: !1,
        searching: !1,
        autoWidth: !1,
        responsive: !0,
        columnDefs: [{
            responsivePriority: 1,
            targets: 0
        }, {
            responsivePriority: 2,
            targets: 1
        }, {
            responsivePriority: 3,
            targets: -1,
            orderable: !1
        }]
    });
    var e = $("#seasonal_price_detail_tbl").DataTable({
            info: !1,
            paging: !0,
            searching: !0,
            lengthChange: !0,
            autoWidth: !1,
            responsive: !0,
            dom: '<"row"<"col-12"rt>><"row"<"col-md-2 col-6"l><"col-md-2 col-6"f><"col-md-7 col-12"<"pagination-container pull-right"p>>>',
            conditionalPaging: {
                style: "fade",
                speed: 500
            },
            columnDefs: [{
                visible: !1,
                targets: 0
            }, {
                responsivePriority: 1,
                targets: 1
            }, {
                responsivePriority: 2,
                targets: 2
            }, {
                responsivePriority: 3,
                targets: -1,
                orderable: !1
            }],
            order: [
                [0, "asc"]
            ],
            language: {
                lengthMenu: "_MENU_"
            }
        }),
        a = $("#reservation_detail_tbl").DataTable({
            info: !1,
            paging: !0,
            searching: !0,
            lengthChange: !0,
            autoWidth: !1,
            responsive: !0,
            conditionalPaging: {
                style: "fade",
                speed: 500
            },
            dom: '<"row"<"col-12"rt>><"row"<"col-md-2 col-6"l><"col-md-2 col-6"f><"col-md-7 col-12"<"pagination-container pull-right"p>>>',
            columnDefs: [{
                visible: !1,
                targets: 0
            }, {
                responsivePriority: 1,
                targets: 1
            }, {
                responsivePriority: 2,
                targets: 2
            }, {
                responsivePriority: 3,
                targets: -1,
                orderable: !1
            }],
            order: [
                [0, "asc"]
            ],
            language: {
                lengthMenu: "_MENU_"
            }
        }),
        t = $("#not_available_dates_tbl").DataTable({
            info: !1,
            paging: !0,
            searching: !0,
            lengthChange: !0,
            autoWidth: !1,
            responsive: !0,
            conditionalPaging: {
                style: "fade",
                speed: 500
            },
            dom: '<"row"<"col-12"rt>><"row"<"col-md-2 col-6"l><"col-md-2 col-6"f><"col-md-7 col-12"<"pagination-container pull-right"p>>>',
            columnDefs: [{
                visible: !1,
                targets: 0
            }, {
                responsivePriority: 1,
                targets: 1
            }, {
                responsivePriority: 2,
                targets: -1,
                orderable: !1
            }],
            order: [
                [0, "asc"]
            ],
            language: {
                lengthMenu: "_MENU_"
            }
        });
    $.fn.dataTable.ext.search.push(function(e, a, t) {
        var s = $("#calendar_dropdown").val(),
            n = s.split("-")[0];
        if ("seasonal_price_detail_tbl" == e.nTable.getAttribute("id")) {
            var i = $("#seasonal_price_table_filter").val();
            if ("all" == i) return !0;
            if ("month" == i) {
                if (a[0].includes(s)) return !0
            } else if ("year" == i && a[0].includes(n)) return !0;
            return !1
        }
        if ("reservation_detail_tbl" == e.nTable.getAttribute("id")) {
            var i = $("#reservation_table_filter").val();
            if ("all" == i) return !0;
            if ("month" == i) {
                if (a[0].includes(s)) return !0
            } else if ("year" == i && a[0].includes(n)) return !0;
            return !1
        }
        if ("not_available_dates_tbl" == e.nTable.getAttribute("id")) {
            var i = $("#not_available_table_filter").val();
            if ("all" == i) return !0;
            if ("month" == i) {
                if (a[0].includes(s)) return !0
            } else if ("year" == i && a[0].includes(n)) return !0;
            return !1
        }
        return !0
    }), $("#seasonal_price_detail_tbl_filter label").html('<select id="seasonal_price_table_filter"><option value="all">Show all</option><option value="month" selected>Current month only</option><option value="year">Current year only</option></select>'), $("#seasonal_price_table_filter").on("change", function() {
        e.draw()
    }), e.draw(), $("#reservation_detail_tbl_filter label").html('<select id="reservation_table_filter"><option value="all">Show all</option><option value="month" selected>Current month only</option><option value="year">Current year only</option></select>'), $("#reservation_table_filter").on("change", function() {
        a.draw()
    }), a.draw(), $("#not_available_dates_tbl_filter label").html('<select id="not_available_table_filter"><option value="all">Show all</option><option value="month" selected>Current month only</option><option value="year">Current year only</option></select>'), $("#not_available_table_filter").on("change", function() {
        t.draw()
    }), t.draw(), 1 == window.mobilecheck() && ($("#seasonal_additional_price").closest(".pricelist").siblings("label").html("Per Extra Guest"), $("#seasonal_week").closest(".pricelist").siblings("label").html("Weekly Price"))
}
var daterangepicker_format = $('meta[name="daterangepicker_format"]').attr("content"),
    datepicker_format = $('meta[name="datepicker_format"]').attr("content"),
    datedisplay_format = $('meta[name="datedisplay_format"]').attr("content");
app.controller("manage_listing", ["$scope", "$http", "$compile", "$filter", function(e, a, t, s) {
    function n() {
        var e = $("#room_id").val();
        a.get(APP_URL + "/users/has_verified_phone", {}).then(function(a) {
            "true" == a.data ? window.location = APP_URL + "/manage-listing/" + e + "/subscribe_property" : ($(".listing-phone-verify-modal").attr("aria-hidden", "false"), $(".listing-phone-verify-modal").data("id", e))
        })
    }

    function i(a) {
        "" != e.name && "" != o() && "en" == a ? ($('[data-track="description"] a div div .transition').removeClass("visible"), $('[data-track="description"] a div div .transition').addClass("hide"), $('[data-track="description"] a div div div .icon-ok-alt').removeClass("hide")) : "" != e.name && o() || "en" != a || ($('[data-track="description"] a div div .transition').removeClass("hide"), $('[data-track="description"] a div div .transition .icon').removeClass("hide"), $('[data-track="description"] a div div div .icon-ok-alt').addClass("hide"), $('[data-track="description"] a div div div .icon-ok-alt').removeClass("visible"))
    }

    function o(a) {
        return a || (a = e.summary), a.replace(/<[^>]+>/g, "").replace(/&nbsp;/gi, "").replace(/\s/g, "").length > 0
    }

    function r() {
        e.summary_len = e.summary.length, e.summary_overflow = e.summary_len > e.summary_limit, e.access_len = e.access.length, e.access_overflow = e.access_len > e.access_limit, e.interaction_len = e.interaction.length, e.interaction_overflow = e.interaction_len > e.interaction_limit, e.notes_len = e.notes.length, e.notes_overflow = e.notes_len > e.notes_limit, e.house_len = e.house_rules.length, e.house_overflow = e.house_len > e.house_limit, e.neighbor_len = e.neighborhood_overview.length, e.neighbor_overflow = e.neighbor_len > e.neighbor_limit, e.transit_len = e.transit.length, e.transit_overflow = e.transit_len > e.transit_limit, e.access_len = e.access.length, e.access_overflow = e.access_len > e.access_limit
    }

    function d(t, s) {
        var n = {};
        n[s] = t;
        var o = $("#current_tab_code").val(),
            r = JSON.stringify(n);
        "summary" == s && ($(".saving-progress h5").text("Saving..."), $(".saving-progress").fadeIn(), a.post("update_rooms", {
            data: r,
            current_tab: o
        }).then(function(a) {
            "true" == a.data.success && ($(".saving-progress h5").text("Saved!"), $(".saving-progress").fadeOut(), $("#steps_count").text(a.data.steps_count), e.steps_count = a.data.steps_count, $("#preview-btn").attr("href", a.data.address_url), i(o))
        }, function(e) {
            "300" == e.status ? window.location = APP_URL + "/login" : "500" == e.status && window.location.reload()
        })), "en" == o && (e.rooms_default_description.name = e.name, e.rooms_default_description.summary = e.summary)
    }

    function l() {
        var a = {};
        return a.space = $('textarea[name="space"]').val(), e.access_overflow || (a.access = $('textarea[name="access"]').val()), e.interaction_overflow || (a.interaction = $('textarea[name="interaction"]').val()), e.notes_overflow || (a.notes = $('textarea[name="notes"]').val()), e.house_overflow || (a.house_rules = $('textarea[name="house_rules"]').val()), e.neighbor_overflow || (a.neighborhood_overview = $('textarea[name="neighborhood_overview"]').val()), e.transit_overflow || (a.transit = $('textarea[name="transit"]').val()), a
    }

    function c(t, s) {
        var n = {};
        n[s] = t;
        var i = JSON.stringify(n);
        $(".saving-progress h5").text("Saving..."), $(".saving-progress").fadeIn(), a.post("update_rooms", {
            data: i
        }).then(function(a) {
            "true" == a.data.success && ($(".saving-progress h5").text("Saved!"), $(".saving-progress").fadeOut(), "" != e.cancel_message ? ($("#steps_count").text(a.data.steps_count), e.steps_count = a.data.steps_count, $('[data-track="terms"] a div div .transition').removeClass("visible"), $('[data-track="terms"] a div div .transition').addClass("hide"), $('[data-track="terms"] a div div div .icon-ok-alt').removeClass("hide")) : ($('[data-track="terms"] a div div .transition').removeClass("hide"), $('[data-track="terms"] a div div div .icon-ok-alt').addClass("hide")))
        })
    }

    function _(s) {
        var n = {};
        s.closest(".nav-item").attr("data-track");
        $("#ajax_container").html('<div class="" id="js-manage-listing-content-container"><div class="manage-listing-content-wrapper" style="height:100%;"><div class="manage-listing-content" id="js-manage-listing-content"><div><div class="row-space-top-6 basics-loading loading"></div></div></div></div></div>'), a.post(s.attr("href").replace("manage-listing", "ajax-manage-listing"), {
            data: n
        }).then(function(a) {
            if ("false" == a.data.success_303) return window.location = APP_URL + "/login", !1;
            $("#ajax_container").html(t(a.data)(e)), e.name = e.rooms_default_description.name, H()
        }, function(e) {
            "300" == e.status && (window.location = APP_URL + "/login")
        });
        var i = window.location.href.split("/"),
            o = $(i).get(-1);
        $("#href_" + o).attr("href", window.location.href);
        var i = s.attr("href").split("/"),
            r = $(i).get(-1);
        e.step = r, window.history.pushState({
            path: s.attr("href")
        }, "", s.attr("href"))
    }

    function u() {
        var e = window.location.href.split("/");
        "location" == $(e).get(-1) && (se = new google.maps.places.Autocomplete(document.getElementById("address_line_1")), se.addListener("place_changed", m))
    }

    function m() {
        e.autocomplete_used = !0, h(se.getPlace())
    }

    function v() {
        return location.protocol + "//" + location.hostname + (location.port && ":" + location.port) + "/"
    }

    function p() {
        function a(e, a) {
            i.setMap(null);
            var t = new google.maps.Marker({
                position: e,
                icon: n.custom1.icon,
                map: a
            });
            i = t, a.panTo(e)
        }
        ie = new google.maps.Geocoder, ne = new google.maps.Map(document.getElementById("map"), {
            center: {
                lat: parseFloat(e.latitude),
                lng: parseFloat(e.longitude)
            },
            zoom: 15,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            disableDefaultUI: !0,
            zoomControl: !0,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.SMALL
            }
        });
        var t = {
                lat: e.latitude,
                lng: e.longitude
            },
            s = v() + "images/",
            n = {
                custom1: {
                    icon: s + "map-pin-unset-placed-bc1892906335b5306390e6bf5aa54386.png"
                }
            },
            i = new google.maps.Marker({
                position: t,
                icon: n.custom1.icon,
                map: ne
            });
        $("<div/>").addClass("verify-map-pin").appendTo(ne.getDiv()).click(function() {}), $("#js-next-btn3").prop("disabled", !1), ne.addListener("dragend", function() {
            a(ne.getCenter(), ne), ie.geocode({
                latLng: ne.getCenter()
            }, function(e, a) {
                a == google.maps.GeocoderStatus.OK && e[0] ? (h(e[0]), $("#js-next-btn3").prop("disabled", !1)) : $("#js-next-btn3").prop("disabled", !0)
            }), $(".verify-map-pin").removeClass("moving"), $(".verify-map-pin").addClass("unset")
        }), ne.addListener("zoom_changed", function() {
            a(i.getPosition(), ne)
        }), ne.addListener("drag", function() {
            $(".verify-map-pin").removeClass("unset"), $(".verify-map-pin").addClass("moving")
        })
    }

    function h(a) {
        $("#js-next-btn").prop("disabled", !1), "street_address" == a.types && (e.location_found = !0);
        var t = {
            locality: "long_name",
            administrative_area_level_1: "long_name",
            country: "short_name",
            postal_code: "short_name"
        };
        $("#city").val(""), $("#state").val(""), $("#country").val(""), $("#address_line_1").val(""), $("#address_line_2").val(""), $("#postal_code").val(""), $("#city").required = !1, $("#state").required = !1, $("#postal_code").required = !1;
        var s = a;
        e.street_number = "";
        for (var n = a.formatted_address, i = n.split(","), o = i.length, r = ["address_line_1", "city", "state", "country"], d = 0; d < o - 1; d++)
            if (i[d] = i[d].trim(), 2 == d && 4 == o) {
                var l = i[d].split(" ");
                $("#" + r[d]).val(l[0]), 2 == l.length && $("#postal_code").val(l[1])
            } else $("#" + r[d]).val(i[d]);
        for (var d = 0; d < s.address_components.length; d++) {
            var c = s.address_components[d].types[0];
            if (t[c]) {
                var _ = s.address_components[d][t[c]];
                if ("street_number" == c && (e.street_number = _), "route" == c) {
                    e.street_number
                }
                "postal_code" == c && $("#postal_code").val(_), "locality" == c && $("#city").val(_), "administrative_area_level_1" == c && $("#state").val(_), "country" == c && $("#country").val(_)
            }
        }
        $("#address_line_1").val();
        e.latitude = ne.getCenter().lat(), e.longitude = ne.getCenter().lng();
        for (var u = [], m = 0, v = ["city", "state", "postal_code"], d = 0; d < 3; d++) {
            var p = "#" + v[d];
            "" != $(p).val() && (u[m++] = v[d]), $(document).on("keyup", p, function() {
                $("#js-next-btn").prop("disabled", !1)
            })
        }
        for (var d = 0; d < u.length; d++) {
            var p = "#" + u[d];
            0 != $(p).val().length && ($(p).required = !0, $(document).on("keyup", p, function() {
                "" == $(this).val() ? $("#js-next-btn").prop("disabled", !0) : $("#js-next-btn").prop("disabled", !1)
            }))
        }
    }

    function f() {
        $(document).on("change", ".upload_photos", function() {
            $("#fileupload").fileupload("add", {
                fileInput: $(this)
            }), $(this).val("")
        });
        var a = APP_URL + "/add_photos/" + $("#room_id").val();
        $(".fileupload").each(function() {
            $(this).fileupload({
                url: a,
                dataType: "json",
                autoUpload: !0,
                acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
                loadImageMaxFileSize: 5e6,
                maxFileSize: 5e6,
                disableImageResize: /Android(?!.*Chrome)|Opera/.test(window.navigator.userAgent),
                previewMaxWidth: 50,
                previewMaxHeight: 50,
                previewCrop: !0,
                dropZone: "",
                messages: {
                    loadImageMaxFileSize: "File exceeds maximum allowed size of 5MB",
                    maxFileSize: "File exceeds maximum allowed size of 5MB"
                }
            }).on("fileuploadadd", function(e, a) {
                a.context = $("<div/>").appendTo("#files"), $.each(a.files, function(e, t) {
                    $("<p/>").append($("<span/>").text(t.name)).appendTo(a.context)
                })
            }).on("fileuploadprocessalways", function(e, a) {
                var t = a.index,
                    s = a.files[t],
                    n = $(a.context.children()[t]);
                s.preview && n.prepend("<br>").prepend(s.preview), s.error ? swal("Whoa Nelly!!!", s.error, "error") : ("false" == $(".upload_photos").attr("on-uploading") && w(), g())
            }).on("fileuploadprogressall", function(e, a) {
                de = parseInt(a.loaded / a.total * 100, 10), de *= .6, oe.animate(de / 100), re.animate(de / 100)
            }).on("fileuploaddone", function(a, t) {
                if (t._response.result.error.error_title) $("#js-photo-grid #js-manage-listing-content-container").remove(), $("#js-photo-grid li.photo-item-container").last().remove(), $(".upload-progress .progressbar_container .progressbar").remove(), $("#js-error .panel-header").text(t._response.result.error.error_title), $("#js-error .panel-body").text(t._response.result.error.error_description), $(".js-delete-photo-confirm").addClass("hide"), $("#js-error").attr("aria-hidden", !1), setTimeout(function() {}, 7500), k();
                else {
                    var s = (100 - de) / b();
                    de += s, oe.animate(de / 100), re.animate(de / 100), 0 == y() && ($("#js-photo-grid #js-manage-listing-content-container").remove(), $("#js-photo-grid li.photo-item-container").last().remove(), $(".upload-progress .progressbar_container .progressbar").remove(), e.$apply(function() {
                        e.photos_list = t._response.result.succresult, $("#photo_count").css("display", "block"), $("#steps_count").text(t._response.result.succresult[0].steps_count), e.steps_count = t._response.result.succresult[0].steps_count
                    }), document.getElementById("upload_photos").value = "", setTimeout(function() {}, 5e3), k())
                }
            }).on("fileuploadfail", function(e, a) {
                $.each(a.files, function(e) {
                    swal("Whoa Nelly!!!", "File upload failed. If at first you don't succeed, try again... Then email support.", "error")
                }), $("#js-photo-grid #js-manage-listing-content-container").remove(), $("#js-photo-grid li.photo-item-container").last().remove(), $(".upload-progress .progressbar_container .progressbar").remove(), k()
            })
        })
    }

    function g() {
        var e = +$(".upload_photos").attr("count-uploaded");
        e++, $(".upload_photos").attr("count-uploaded", e)
    }

    function b() {
        return +$(".upload_photos").attr("count-uploaded")
    }

    function y() {
        var e = +$(".upload_photos").attr("count-uploaded");
        return e--, $(".upload_photos").attr("count-uploaded", e), e
    }

    function k() {
        $(".upload_photos").attr("count-uploaded", 0), $(".upload_photos").attr("on-uploading", "false")
    }

    function w() {
        $("#js-photo-grid #js-photo-grid-placeholder").before('<li class="col-12 col-lg-4 col-md-6 row-space-4 photo-item-container"><div class=" photo-item"><div class="photo-size photo-drag-target js-photo-link"><strong>TEST</strong></div></div></li>');
        $("#js-photo-grid li.photo-item-container").last().append('<div class="manage-listing-progressbar-container" id="js-manage-listing-progressbar-container"><div id="manage-listing-progressbar" class="manage-listing-progressbar" style="z-index:9;height: 8px;"></div></div>'), $(".upload-progress .progressbar_container").append('<div id="progressbar-top" class="progressbar"><div class="manage-listing-progressbar-container" id="js-manage-listing-progressbar-top-container"><div id="manage-listing-progressbar-top" class="manage-listing-progressbar-top" style="z-index:9;height: 8px;"></div></div></div>');
        $("#js-photo-grid li.photo-item-container").last().append('<div class="" id="js-manage-listing-content-container"><div class="manage-listing-content-wrapper" style="height:100%;z-index:9;"><div class="manage-listing-content" id="js-manage-listing-content"><div><div class="row-space-top-6 loading"></div></div></div></div></div>'), oe = new ProgressBar.Line("#manage-listing-progressbar", {
            strokeWidth: 4,
            easing: "easeInOut",
            duration: 1400,
            color: "#FFEA82",
            trailColor: "#eee",
            trailWidth: 1,
            svgStyle: {
                width: "100%",
                height: "100%"
            },
            from: {
                color: "#ED6A5A"
            },
            to: {
                color: "#0ea70e"
            },
            step: function(e, a) {
                a.path.setAttribute("stroke", e.color)
            }
        }), re = new ProgressBar.Line("#manage-listing-progressbar-top", {
            strokeWidth: 4,
            easing: "easeInOut",
            duration: 1400,
            color: "#FFEA82",
            trailColor: "#eee",
            trailWidth: 1,
            svgStyle: {
                width: "100%",
                height: "100%"
            },
            from: {
                color: "#ED6A5A"
            },
            to: {
                color: "#30a76a"
            },
            step: function(e, a) {
                a.path.setAttribute("stroke", e.color)
            }
        }), $(".upload_photos").attr("on-uploading", "true")
    }

    function C() {
        a.get("photos_list", {}).then(function(a) {
            e.photos_list = a.data, a.data.length > 0 && $("#photo_count").css("display", "block")
        })
    }

    function x(e) {
        var t = $("input[name=room_id]").val(),
            s = [];
        $(".base_priceamt .additional_charge_row").each(function() {
            var e = {};
            e.label = $(this).find('input[name^="additional_charge_label"]').val(), e.price = $(this).find('input[name^="additional_charge_price"]').val(), e.price_type = $(this).find('select[name="additional_charge_price_type[]"]').val(), e.calc_type = $(this).find('select[name="additional_charge_calculation_type[]"]').val(), e.guest_opt = $(this).find('select[name="additional_charge_guest_opt[]"]').val(), s.push(e)
        });
        var n = e.attr("data-saving");
        $("." + n + " h5").text("Saving..."), $("." + n).fadeIn(), url = APP_URL + "/update_additional_price", a.post(url, {
            additional_charges: s,
            id: t
        }).then(function(e) {
            "true" == e.data.success ? ($("." + n + " h5").text("Saved!"), $("." + n).fadeOut(), $(".ml-error").addClass("hide")) : "" != e.data.attribute && void 0 != e.data.attribute && ($('[data-error="' + e.data.attribute + '"]').removeClass("hide"), $('[data-error="' + e.data.attribute + '"]').html(e.data.msg), $(".input-prefix").html(e.data.currency_symbol))
        }, function(e) {
            "300" == e.status && (window.location = APP_URL + "/login")
        })
    }

    function j(e) {
        $("#season_form_t").attr("data-mode", "edit"), $("#season_form_t .day_delete").attr("data-name", e.seasonal_name), $("#delete_season_t").removeClass("d-none").addClass("d-block"), $("#cancel_season_t").removeClass("d-none").addClass("d-inline-block"), U(e.seasonal_name)
    }

    function P(e) {
        $("#unavailable_form_t").attr("data-mode", "edit"), $("#unavailable_form_t .day_delete").attr("data-name", e.seasonal_name), $("#delete_unavailable_t").removeClass("d-none").addClass("d-block"), $("#cancel_unavailable_t").removeClass("d-none").addClass("d-inline-block"), R(e.seasonal_name)
    }

    function D(e) {
        $("#reservation_form_t").attr("data-mode", "edit"), $("#reservation_form_t .day_delete").attr("data-name", e.seasonal_name), $("#delete_reservation_t").removeClass("d-none").addClass("d-block"), $("#cancel_reservation_t").removeClass("d-none").addClass("d-inline-block"), $("#reservation_type_t").val(e.source), L(e.seasonal_name);
        var a = $("#reservation_form_t").closest(".c-tab").find(".info-wrapper");
        "Reservation" == e.source && "Reserved" == e.status ? ($("#delete_reservation_t").addClass("d-none").removeClass("d-block"), $("#reservation_checkin_t").attr("disabled", !0), $("#reservation_checkout_t").attr("disabled", !0), a.removeClass("d-none"), a.find(".ib2-info-message").html("You cannot change the dates for this reservation type. Please navigate to the reservation page and cancel the reservation if you'd like to reschedule.")) : a.addClass("d-none")
    }

    function O() {
        L(""), U(""), R("")
    }

    function S(t, s) {
        var n = $("#room_id").val();
        a.post(APP_URL + "/fetch_conflict_unavailable/" + n, {
            date: t
        }).then(function(a) {
            "Calendar" == a.data.source && "Not available" == a.data.status ? (toastr.info("You are now editing an existing blocked date."), $("#unvailable_checkin_t").val(moment(a.data.start_date).format(daterangepicker_format)), $("#unvailable_checkout_t").val(moment(a.data.end_date).format(daterangepicker_format)), $("#formatted_unavailable_checkin_t").val(a.data.start_date), $("#formatted_unavailable_checkout_t").val(a.data.end_date), e.unavailable_data = a.data, e.unavailable_data.edit_seasonal_name = a.data.seasonal_name, "reservation" == s && setTimeout(function() {
                $("#calendar_form_group #prev").click(), setTimeout(function() {
                    $(".c-tabs-nav__link").eq(2).click()
                }, 50)
            }, 50), P(a.data)) : (toastr.info("You are now editing an existing reservation."), $("#reservation_checkin_t").val(moment(a.data.start_date).format(daterangepicker_format)), $("#reservation_checkout_t").val(moment(a.data.end_date).format(daterangepicker_format)), $("#formatted_reservation_checkin_t").val(a.data.start_date), $("#formatted_reservation_checkout_t").val(a.data.end_date), e.rsv_data = a.data, e.rsv_data.edit_seasonal_name = a.data.seasonal_name, "blocked" == s && setTimeout(function() {
                $("#calendar_form_group #prev").click()
            }, 50), D(a.data))
        })
    }

    function A(t) {
        var s = $("#room_id").val();
        a.post(APP_URL + "/fetch_conflict_seasonal/" + s, {
            date: t
        }).then(function(a) {
            toastr.info("You are now editing an existing season."), $("#seasonal_checkin_t").val(moment(a.data.start_date).format(daterangepicker_format)), $("#seasonal_checkout_t").val(moment(a.data.end_date).format(daterangepicker_format)), $("#formatted_seasonal_checkin_t").val(a.data.start_date), $("#formatted_seasonal_checkout_t").val(a.data.end_date), e.season_data = a.data, e.season_data.edit_seasonal_name = a.data.seasonal_name, j(a.data)
        })
    }

    function L(t) {
        var s = $("#reservation_checkin_t").val(),
            n = $("#reservation_checkout_t").val();
        $("#reservation_checkin_t").remove(), $("#formatted_reservation_checkin_t").before('<input type="text"  id="reservation_checkin_t" name="start_date" readonly="readonly" class="checkin text-truncate input-large input-contrast ui-datepicker-target seasonal_checkin">'), $("#reservation_checkout_t").remove(), $("#formatted_reservation_checkout_t").before('<input type="text"  id="reservation_checkout_t" name="end_date" readonly="readonly" class="checkin text-truncate input-large input-contrast ui-datepicker-target seasonal_checkout">'), $("#reservation_checkin_t").val(s), $("#reservation_checkout_t").val(n), X(), a.post("unavailable_calendar", {
            season_name: t
        }).then(function(a) {
            q(a.data), e.reservation_dates_data = a.data
        }, function(e) {
            "300" == e.status ? window.location = APP_URL + "/login" : "500" == e.status && window.location.reload()
        })
    }

    function R(t) {
        var s = $("#unvailable_checkin_t").val(),
            n = $("#unvailable_checkout_t").val();
        $("#unvailable_checkin_t").remove(), $("#formatted_unavailable_checkin_t").before('<input type="text"  id="unvailable_checkin_t" name="start_date" readonly="readonly" class="checkin text-truncate input-large input-contrast ui-datepicker-target seasonal_checkin" >'), $("#unvailable_checkout_t").remove(), $("#formatted_unavailable_checkout_t").before('<input type="text"  id="unvailable_checkout_t" name="end_date" readonly="readonly" class="checkin text-truncate input-large input-contrast ui-datepicker-target seasonal_checkout" >'), $("#unvailable_checkin_t").val(s), $("#unvailable_checkout_t").val(n), X(), a.post("unavailable_calendar", {
            season_name: t
        }).then(function(a) {
            Y(a.data), e.unavailable_dates_data = a.data
        }, function(e) {
            "300" == e.status ? window.location = APP_URL + "/login" : "500" == e.status && window.location.reload()
        })
    }

    function U(t) {
        var s = $("#seasonal_checkin_t").val(),
            n = $("#seasonal_checkout_t").val();
        $("#seasonal_checkin_t").remove(), $("#formatted_seasonal_checkin_t").before('<input type="text"  id="seasonal_checkin_t" name="start_date" readonly="readonly" class="checkin text-truncate input-large input-contrast ui-datepicker-target seasonal_checkin" >'), $("#seasonal_checkout_t").remove(), $("#formatted_seasonal_checkout_t").before('<input type="text"  id="seasonal_checkout_t" name="end_date" readonly="readonly" class="seasonal_checkout checkin text-truncate input-large input-contrast ui-datepicker-target">'), $("#seasonal_checkin_t").val(s), $("#seasonal_checkout_t").val(n), X(), a.post("seasonal_calendar", {
            season_name: t
        }).then(function(a) {
            T(a.data.seasonal_days, a.data.self_days), e.seasonal_dates_data = a.data.seasonal_days, e.seasonal_self_data = a.data.self_days
        }, function(e) {
            "300" == e.status ? window.location = APP_URL + "/login" : "500" == e.status && window.location.reload()
        })
    }

    function T(a, t) {
        $("#seasonal_checkin_t").datepicker({
            minDate: 0,
            dateFormat: datepicker_format,
            beforeShowDay: function(e) {
                var s = jQuery.datepicker.formatDate("yy-mm-dd", e);
                return -1 != a.indexOf(s) ? [-1 != a.indexOf(s), "marked-seasonal"] : -1 != t.indexOf(s) ? [-1 != t.indexOf(s), "marked-self"] : [-1 == a.indexOf(s)]
            },
            onSelect: function(a, t) {
                var s = t.selectedMonth + 1,
                    n = t.selectedYear + "-" + s + "-" + t.selectedDay,
                    i = $(this).closest(".seasonal_price");
                i.find(".formatted_seasonal_checkin").val(n);
                var o = i.find(".seasonal_checkout").datepicker("getDate"),
                    r = $(this).datepicker("getDate");
                if (r.setDate(r.getDate()), i.find(".seasonal_checkout").datepicker("option", "minDate", r), r > o) {
                    var d = r.getDate(),
                        l = r.getMonth() + 1,
                        c = r.getFullYear(),
                        _ = c + "-" + l + "-" + d;
                    i.find(".formatted_seasonal_checkout").val(_)
                }
                var u = moment(a).format("YYYY-MM-DD"); - 1 != e.seasonal_dates_data.indexOf(u) ? A(u) : z()
            }
        }), $("#seasonal_checkout_t").datepicker({
            minDate: 0,
            dateFormat: datepicker_format,
            beforeShow: function(e, a) {
                setTimeout(function() {
                    $(".ui-state-disabled").removeAttr("title"), $(".highlight").not(".ui-state-disabled").tooltip({
                        container: "body"
                    })
                }, 100)
            },
            beforeShowDay: function(e) {
                var s = jQuery.datepicker.formatDate("yy-mm-dd", e);
                return -1 != a.indexOf(s) ? [-1 != a.indexOf(s), "marked-seasonal"] : -1 != t.indexOf(s) ? [-1 != t.indexOf(s), "marked-self"] : [-1 == a.indexOf(s)]
            },
            onSelect: function(a, t) {
                var s = $(this).closest(".seasonal_price"),
                    n = t.selectedMonth + 1,
                    i = t.selectedYear + "-" + n + "-" + t.selectedDay;
                s.find(".formatted_seasonal_checkout").val(i);
                var o = $(".first-day-selected").attr("id");
                o = moment(), d = o.format("YYYY-MM-DD"), checkout = o.clone().add("1", "days");
                var r = $(this).datepicker("getDate");
                if (r.setDate(r.getDate()), s.find(".seasonal_checkin").datepicker("getDate") > r) {
                    s.find(".seasonal_checkin").datepicker("setDate", r);
                    var d = r.getDate(),
                        l = r.getMonth() + 1,
                        c = r.getFullYear(),
                        _ = c + "-" + l + "-" + d;
                    s.find(".formatted_seasonal_checkin").val(_)
                }
                $(this).datepicker("option", "minDate", checkout.toDate());
                var u = moment(a).format("YYYY-MM-DD");
                return -1 != e.seasonal_dates_data.indexOf(u) ? A(u) : z(), !1
            }
        })
    }

    function Y(a) {
        $("#unvailable_checkin_t").datepicker({
            minDate: 0,
            dateFormat: datepicker_format,
            beforeShowDay: function(e) {
                var t, s = jQuery.datepicker.formatDate("yy-mm-dd", e);
                return -1 != a.unavailable_dates.indexOf(s) ? (t = a.unavailable_dates.indexOf(s), [-1 != a.unavailable_dates.indexOf(s), a.day_types[t] + " " + a.day_position[t]]) : -1 != a.self_days.indexOf(s) ? [-1 != a.self_days.indexOf(s), "marked-self"] : [-1 == a.unavailable_dates.indexOf(s)]
            },
            onSelect: function(a, t) {
                var s = t.selectedMonth + 1,
                    n = t.selectedYear + "-" + s + "-" + t.selectedDay,
                    i = $(this).closest(".seasonal_price");
                i.find(".formatted_seasonal_checkin").val(n);
                var o = i.find(".seasonal_checkout").datepicker("getDate"),
                    r = $(this).datepicker("getDate");
                if (r.setDate(r.getDate()), i.find(".seasonal_checkout").datepicker("option", "minDate", r), r > o) {
                    var d = r.getDate(),
                        l = r.getMonth() + 1,
                        c = r.getFullYear(),
                        _ = c + "-" + l + "-" + d;
                    i.find(".formatted_seasonal_checkout").val(_)
                }
                var u = moment(a).format("YYYY-MM-DD"); - 1 != e.unavailable_dates_data.unavailable_dates.indexOf(u) ? S(u, "blocked") : W()
            }
        }), $("#unvailable_checkout_t").datepicker({
            minDate: 0,
            dateFormat: datepicker_format,
            beforeShow: function(e, a) {
                setTimeout(function() {
                    $(".ui-state-disabled").removeAttr("title"), $(".highlight").not(".ui-state-disabled").tooltip({
                        container: "body"
                    })
                }, 100)
            },
            beforeShowDay: function(e) {
                var t, s = jQuery.datepicker.formatDate("yy-mm-dd", e);
                return -1 != a.unavailable_dates.indexOf(s) ? (t = a.unavailable_dates.indexOf(s), [-1 != a.unavailable_dates.indexOf(s), a.day_types[t] + " " + a.day_position[t]]) : -1 != a.self_days.indexOf(s) ? [-1 != a.self_days.indexOf(s), "marked-self"] : [-1 == a.unavailable_dates.indexOf(s)]
            },
            onSelect: function(a, t) {
                var s = $(this).closest(".seasonal_price"),
                    n = t.selectedMonth + 1,
                    i = t.selectedYear + "-" + n + "-" + t.selectedDay;
                s.find(".formatted_seasonal_checkout").val(i);
                var o = $(".first-day-selected").attr("id");
                o = moment(), d = o.format("YYYY-MM-DD"), checkout = o.clone().add("1", "days");
                var r = $(this).datepicker("getDate");
                if (r.setDate(r.getDate()), s.find(".seasonal_checkin").datepicker("getDate") > r) {
                    s.find(".seasonal_checkin").datepicker("setDate", r);
                    var d = r.getDate(),
                        l = r.getMonth() + 1,
                        c = r.getFullYear(),
                        _ = c + "-" + l + "-" + d;
                    s.find(".formatted_seasonal_checkin").val(_)
                }
                $(this).datepicker("option", "minDate", checkout.toDate());
                var u = moment(a).format("YYYY-MM-DD");
                return -1 != e.unavailable_dates_data.unavailable_dates.indexOf(u) ? S(u, "blocked") : W(), !1
            }
        })
    }

    function q(a) {
        $("#reservation_checkin_t").datepicker({
            minDate: 0,
            dateFormat: datepicker_format,
            beforeShowDay: function(e) {
                var t, s = jQuery.datepicker.formatDate("yy-mm-dd", e);
                return -1 != a.unavailable_dates.indexOf(s) ? (t = a.unavailable_dates.indexOf(s), [-1 != a.unavailable_dates.indexOf(s), a.day_types[t] + " " + a.day_position[t]]) : -1 != a.self_days.indexOf(s) ? [-1 != a.self_days.indexOf(s), "marked-self"] : [-1 == a.unavailable_dates.indexOf(s)]
            },
            onSelect: function(a, t) {
                var s = t.selectedMonth + 1,
                    n = t.selectedYear + "-" + s + "-" + t.selectedDay,
                    i = $(this).closest(".seasonal_price");
                i.find(".formatted_seasonal_checkin").val(n);
                var o = $(this).datepicker("getDate"),
                    r = i.find(".seasonal_checkout").datepicker("getDate");
                if (o.setDate(o.getDate() + 1), i.find(".seasonal_checkout").datepicker("option", "minDate", o), o > r) {
                    var d = o.getDate(),
                        l = o.getMonth() + 1,
                        c = o.getFullYear(),
                        _ = c + "-" + l + "-" + d;
                    i.find(".formatted_seasonal_checkout").val(_)
                }
                var u = moment(a).format("YYYY-MM-DD"),
                    m = e.reservation_dates_data.unavailable_dates.indexOf(u);
                if (-1 != m) {
                    var v = e.reservation_dates_data.day_position[m],
                        p = e.reservation_dates_data.day_types[m];
                    "blocked" == p ? S(u, "reservation") : "reservation" == p && (-1 == v.indexOf("checkout") ? S(u, "reservation") : B())
                } else B()
            }
        }).on("click", function() {}), $("#reservation_checkout_t").datepicker({
            minDate: 0,
            dateFormat: datepicker_format,
            beforeShow: function(e, a) {
                setTimeout(function() {
                    $(".ui-state-disabled").removeAttr("title"), $(".highlight").not(".ui-state-disabled").tooltip({
                        container: "body"
                    })
                }, 100)
            },
            beforeShowDay: function(e) {
                var t, s = jQuery.datepicker.formatDate("yy-mm-dd", e);
                return -1 != a.unavailable_dates.indexOf(s) ? (t = a.unavailable_dates.indexOf(s), [-1 != a.unavailable_dates.indexOf(s), a.day_types[t] + " " + a.day_position[t]]) : -1 != a.self_days.indexOf(s) ? [-1 != a.self_days.indexOf(s), "marked-self"] : [-1 == a.unavailable_dates.indexOf(s)]
            },
            onSelect: function(a, t) {
                var s = $(this).closest(".seasonal_price"),
                    n = t.selectedMonth + 1,
                    i = t.selectedYear + "-" + n + "-" + t.selectedDay;
                s.find(".formatted_seasonal_checkout").val(i);
                var o = $(".first-day-selected").attr("id");
                o = moment(), d = o.format("YYYY-MM-DD"), checkout = o.clone().add("1", "days");
                var r = $(this).datepicker("getDate");
                if (r.setDate(r.getDate() - 1), s.find(".seasonal_checkin").datepicker("getDate") > r) {
                    s.find(".seasonal_checkin").datepicker("setDate", r);
                    var d = r.getDate(),
                        l = r.getMonth() + 1,
                        c = r.getFullYear(),
                        _ = c + "-" + l + "-" + d;
                    s.find(".formatted_seasonal_checkin").val(_)
                }
                $(this).datepicker("option", "minDate", checkout.toDate());
                var u = moment(a).format("YYYY-MM-DD"),
                    m = e.reservation_dates_data.unavailable_dates.indexOf(u);
                if (-1 != m) {
                    var v = e.reservation_dates_data.day_position[m],
                        p = e.reservation_dates_data.day_types[m];
                    "blocked" == p ? S(u, "reservation") : "reservation" == p && (-1 == v.indexOf("checkin") ? S(u, "reservation") : B())
                } else B();
                return !1
            }
        })
    }

    function M(e) {
        function a() {
            if (!o) {
                o = !0, c.style.display = "none";
                for (var e = 0; e < d.length; e++) {
                    t(d[e], e)
                }
                u && n(d[m])
            }
        }

        function t(e, a) {
            e.addEventListener("click", function(e) {
                e.preventDefault(), s(a)
            })
        }

        function s(e) {
            e >= 0 && e != m && e <= d.length && (d[m].classList.remove("is-active"), d[e].classList.add("is-active"), l[m].classList.remove("is-active"), l[e].classList.add("is-active"), u && n(d[e]), m = e, 0 == e ? J() : 1 == e ? E() : 2 == e && G())
        }

        function n(e) {
            u.style.left = e.offsetLeft + "px", u.style.width = e.offsetWidth + "px"
        }
        var i = document.querySelector(e.el),
            o = !1,
            r = i.querySelector(".c-tabs-nav"),
            d = i.querySelectorAll(".c-tabs-nav__link"),
            l = i.querySelectorAll(".c-tab"),
            c = r.querySelector("#prev"),
            _ = r.querySelector("#next"),
            u = !!e.marker && function() {
                var e = document.createElement("div");
                return e.classList.add("c-tab-nav-marker"), r.appendChild(e), e
            }(),
            m = 1;
        return _.addEventListener("click", function(e) {
            for (var a = 0; a < d.length; a++) {
                var t = d[a];
                t.style.display = a < 3 ? "none" : "inline-block"
            }
            this.style.display = "none", c.style.display = "inline-block", s(3)
        }), c.addEventListener("click", function(e) {
            for (var a = 0; a < d.length; a++) {
                var t = d[a];
                t.style.display = a < 3 ? "inline-block" : "none"
            }
            this.style.display = "none", _.style.display = "inline-block", s(0)
        }), {
            init: a,
            goToTab: s
        }
    }

    function N() {
        var e = window.location.href.split("/"); - 1 != $(e).get(-1).indexOf("calendar") && new M({
            el: "#calendar_form_tabs",
            marker: !0
        }).init()
    }

    function I() {
        $(".seasonal_checkin").datepicker({
            minDate: 0,
            dateFormat: datepicker_format,
            onSelect: function(e, a) {
                var t = a.selectedMonth + 1,
                    s = a.selectedYear + "-" + t + "-" + a.selectedDay,
                    n = $(this).closest(".seasonal_price");
                n.find(".formatted_seasonal_checkin").val(s);
                var i = $(this).datepicker("getDate");
                i.setDate(i.getDate() + 1), n.find(".seasonal_checkout").datepicker("option", "minDate", i);
                var o = i.getDate(),
                    r = i.getMonth() + 1,
                    d = i.getFullYear(),
                    l = d + "-" + r + "-" + o;
                n.find(".formatted_seasonal_checkout").val(l)
            }
        }), $(".seasonal_checkout").datepicker({
            minDate: 0,
            dateFormat: datepicker_format,
            beforeShow: function(e, a) {
                setTimeout(function() {
                    $(".ui-state-disabled").removeAttr("title"), $(".highlight").not(".ui-state-disabled").tooltip({
                        container: "body"
                    })
                }, 100)
            },
            onSelect: function(e, a) {
                var t = $(this).closest(".seasonal_price"),
                    s = a.selectedMonth + 1,
                    n = a.selectedYear + "-" + s + "-" + a.selectedDay;
                t.find(".formatted_seasonal_checkout").val(n);
                var i = $(".first-day-selected").attr("id");
                i = moment(), checkin_date = i.format("YYYY-MM-DD"), checkout = i.clone().add("1", "days");
                var o = $(this).datepicker("getDate");
                return o.setDate(o.getDate() - 1), t.find(".seasonal_checkin").datepicker("getDate") > o && t.find(".seasonal_checkin").datepicker("setDate", o), $(this).datepicker("option", "minDate", checkout.toDate()), !1
            }
        }), $(".all-slides").sortable({
            axis: "x,y",
            revert: !0,
            scroll: !1,
            placeholder: "sortable-placeholder",
            cursor: "move",
            tolerance: "pointer",
            start: function() {
                $(".all-slides").addClass("sorting")
            },
            stop: function() {
                $(".all-slides").addClass("sort-stop").removeClass("sorting"), setTimeout(function() {
                    $(".all-slides").removeClass("sort-stop")
                }, 310), e.change_photo_order()
            }
        })
    }

    function F() {
        $(".selected").length >= 1 && (K(), $(".seasonal_checkin").val(moment($(".first-day-selected").attr("id")).format(daterangepicker_format)), $(".seasonal_checkout").val(moment($(".last-day-selected").attr("id")).format(daterangepicker_format)), $(".formatted_seasonal_checkin").val($(".first-day-selected").attr("id")), $(".formatted_seasonal_checkout").val($(".last-day-selected").attr("id")), 1 == $(".selected").length && ($(".seasonal_checkout").val(moment($(".last-day-selected").attr("id")).add(1, "days").format(daterangepicker_format)), $(".formatted_seasonal_checkout").val($(".seasonal_checkout").val())), $("#calendar_form_group").addClass("show"), setTimeout(function() {
            $("#calendar_form_group #prev").click()
        }, 50), $(".header--sm.show-sm").addClass("zindex"), $("body").addClass("pos-fix3"))
    }

    function B() {
        if ("" != $("#reservation_checkin_t").val() && "" != $("#reservation_checkout_t").val() && "" != $("#formatted_reservation_checkin_t").val() && "" != $("#formatted_reservation_checkout_t").val()) {
            var t = $("input[name=room_id]").val();
            a.post(APP_URL + "/check_reservation_conflict_req/" + t, {
                room_id: t,
                edit_seasonal_name: e.rsv_data.edit_seasonal_name,
                start_date: $("#formatted_reservation_checkin_t").val(),
                end_date: $("#formatted_reservation_checkout_t").val()
            }).then(function(e) {
                "false" == e.data.success && pe.showErrors(e.data.errors)
            })
        }
    }

    function J() {
        "" == e.rsv_data.edit_seasonal_name && "" != $("#formatted_reservation_checkin_t").val() && "" != $("#formatted_reservation_checkout_t").val() && B()
    }

    function z() {
        if ("" != $("#seasonal_checkin_t").val() && "" != $("#seasonal_checkout_t").val() && "" != $("#formatted_seasonal_checkin_t").val() && "" != $("#formatted_seasonal_checkout_t").val()) {
            var t = $("input[name=room_id]").val(),
                s = {};
            s.room_id = t, s.edit_seasonal_name = e.season_data.edit_seasonal_name, s.start_date = $("#formatted_seasonal_checkin_t").val(), s.end_date = $("#formatted_seasonal_checkout_t").val(), a.post(APP_URL + "/check_seasonal_conflict_req/" + t, {
                data: s
            }).then(function(e) {
                "false" == e.data.success && he.showErrors(e.data.errors)
            })
        }
    }

    function E() {
        "" == e.season_data.edit_seasonal_name && "" != $("#formatted_seasonal_checkin_t").val() && "" != $("#formatted_seasonal_checkout_t").val() && z()
    }

    function W() {
        if ("" != $("#unvailable_checkin_t").val() && "" != $("#unvailable_checkout_t").val() && "" != $("#formatted_unavailable_checkin_t").val() && "" != $("#formatted_unavailable_checkout_t").val()) {
            var t = $("input[name=room_id]").val(),
                s = {};
            s.room_id = t, s.edit_seasonal_name = e.unavailable_data.edit_seasonal_name, s.start_date = $("#formatted_unavailable_checkin_t").val(), s.end_date = $("#formatted_unavailable_checkout_t").val(), a.post(APP_URL + "/check_unavailable_conflict_req/" + t, {
                data: s
            }).then(function(e) {
                "false" == e.data.success && fe.showErrors(e.data.errors)
            })
        }
    }

    function G() {
        "" == e.unavailable_data.edit_seasonal_name && "" != $("#formatted_unavailable_checkin_t") && "" != $("#formatted_unavailable_checkout_t") && W()
    }

    function Q(e) {
        var a = e;
        return ($(e).is('input[type="checkbox"]') || $(e).is('input[type="radio"]') || $(e).is("select")) && (a = $(e).parents(".control-group").get(0)), a
    }

    function H() {
        I(), O(), N(), X(), calendar_tables_init(), tooltip_init(), f(), dataTablesTabRedraw()
    }

    function X() {
        $("#calendar_form_tabs input, #calendar_form_tabs select, #calendar_form_tabs textarea").each(function() {
            var e = Q(this);
            $(e).tooltipster({
                trigger: "custom",
                animation: "grow",
                theme: "tooltipster-shadow",
                maxWidth: 125,
                side: "top",
                multiple: !1,
                timer: 1500,
                autoClose: !0,
                debug: !1,
                functionPosition: function(e, a, t) {
                    var s = a.geo.origin.offset.right,
                        n = t.size.width;
                    return t.coord.left = s - n, t
                }
            })
        }), pe = $("#reservation_form_t").validate({
            rules: {
                start_date: {
                    required: !0
                },
                end_date: {
                    required: !0
                },
                seasonal_name: {
                    required: !0
                },
                price: {
                    required: !0,
                    number: !0
                },
                guests: {
                    required: !0,
                    number: !0,
                    min: 1
                }
            },
            messages: {
                start_date: {
                    required: ""
                },
                end_date: {
                    required: ""
                },
                seasonal_name: {
                    required: ""
                },
                price: {
                    required: ""
                },
                guests: {
                    required: "",
                    number: "This field should be number.",
                    min: "This value must be greater than 1."
                }
            },
            errorPlacement: function(e, a) {
                var t = ($(a), a),
                    s = $(e).text(),
                    n = "";
                t = Q(a), n = $(t).data("last_error"), $(t).data("last_error", s), "" !== s && s != n && ($(t).tooltipster("content", s), $(t).tooltipster("open"))
            },
            unhighlight: function(e, a, t) {
                var s = Q(e);
                $(s).removeClass(a).addClass(t).tooltipster("close")
            },
            submitHandler: function(t) {
                var s = e.rsv_data.room_id;
                e.rsv_data.start_date = $("#formatted_reservation_checkin_t").val(), e.rsv_data.end_date = $("#formatted_reservation_checkout_t").val(), e.rsv_data.reservation_type = $("#reservation_type_t").val();
                var n = $("#reservation_form_t").closest(".c-tab").find(".loading.global-ajax-form-loader");
                n.removeClass("d-none"), a.post(APP_URL + "/check_season_name/" + s, {
                    season_name: e.rsv_data.seasonal_name,
                    edit_season_name: e.rsv_data.edit_seasonal_name
                }).then(function(t) {
                    "Already Name" == t.data.status ? (n.addClass("d-none"), pe.showErrors({
                        seasonal_name: "Season name Already used"
                    })) : a.post(APP_URL + "/save_reservation/" + s, {
                        start_date: e.rsv_data.start_date,
                        end_date: e.rsv_data.end_date,
                        seasonal_name: e.rsv_data.seasonal_name,
                        edit_seasonal_name: e.rsv_data.edit_seasonal_name,
                        notes: e.rsv_data.notes,
                        reservation_source: e.rsv_data.reservation_type,
                        price: e.rsv_data.price,
                        guests: e.rsv_data.guests
                    }).then(function(e) {
                        n.addClass("d-none"), "false" == e.data.success ? pe.showErrors(e.data.errors) : (toastr.success("Reservation has been saved successfully."), window.location = APP_URL + "/manage-listing/" + s + "/calendar")
                    })
                })
            }
        }), he = $("#season_form_t").validate({
            debug: !0,
            rules: {
                start_date: {
                    required: !0
                },
                end_date: {
                    required: !0
                },
                seasonal_name: {
                    required: !0
                },
                price: {
                    required: !0,
                    number: !0
                },
                additional_guest: {
                    number: !0
                },
                week: {
                    number: !0
                },
                month: {
                    number: !0
                },
                weekend: {
                    number: !0
                },
                minimum_stay: {
                    required: !0,
                    min: 1,
                    integer: !0
                }
            },
            messages: {
                start_date: {
                    required: ""
                },
                end_date: {
                    required: ""
                },
                seasonal_name: {
                    required: ""
                },
                price: {
                    required: ""
                },
                additional_guest: {
                    number: "This field should be number."
                },
                week: {
                    number: "This field should be number."
                },
                month: {
                    number: "This field should be number."
                },
                weekend: {
                    number: "This field should be number."
                },
                minimum_stay: {
                    required: "",
                    min: "This value must be greater than 1.",
                    integer: "This field should be integer."
                }
            },
            errorPlacement: function(e, a) {
                var t = ($(a), a),
                    s = $(e).text(),
                    n = "";
                t = Q(a), n = $(t).data("last_error"), $(t).data("last_error", s), "" !== s && s != n && ($(t).tooltipster("content", s), $(t).tooltipster("open"))
            },
            unhighlight: function(e, a, t) {
                var s = Q(e);
                $(s).removeClass(a).addClass(t).tooltipster("close")
            },
            submitHandler: function(t) {
                var s = e.season_data.room_id;
                e.season_data.start_date = $("#formatted_seasonal_checkin_t").val(), e.season_data.end_date = $("#formatted_seasonal_checkout_t").val();
                var n = $("#season_form_t").closest(".c-tab").find(".loading.global-ajax-form-loader");
                n.removeClass("d-none"), a.post(APP_URL + "/check_season_name/" + s, {
                    season_name: e.season_data.seasonal_name,
                    edit_season_name: e.season_data.edit_seasonal_name
                }).then(function(t) {
                    "Already Name" == t.data.status ? (n.addClass("d-none"), he.showErrors({
                        seasonal_name: "Season name Already used"
                    })) : a.post(APP_URL + "/save_seasonal_price/" + s, {
                        data: e.season_data
                    }).then(function(e) {
                        n.addClass("d-none"), "false" == e.data.success ? he.showErrors(e.data.errors) : (toastr.success("Season has been saved successfully."), window.location = APP_URL + "/manage-listing/" + s + "/calendar")
                    })
                })
            }
        }), fe = $("#unavailable_form_t").validate({
            debug: !0,
            rules: {
                start_date: {
                    required: !0
                },
                end_date: {
                    required: !0
                },
                seasonal_name: {
                    required: !0
                }
            },
            messages: {
                start_date: {
                    required: ""
                },
                end_date: {
                    required: ""
                },
                seasonal_name: {
                    required: ""
                }
            },
            errorPlacement: function(e, a) {
                var t = ($(a), a),
                    s = $(e).text(),
                    n = "";
                t = Q(a), n = $(t).data("last_error"), $(t).data("last_error", s), "" !== s && s != n && ($(t).tooltipster("content", s), $(t).tooltipster("open"))
            },
            unhighlight: function(e, a, t) {
                var s = Q(e);
                $(s).removeClass(a).addClass(t).tooltipster("close")
            },
            submitHandler: function(t) {
                var s = e.unavailable_data.room_id;
                e.unavailable_data.start_date = $("#formatted_unavailable_checkin_t").val(), e.unavailable_data.end_date = $("#formatted_unavailable_checkout_t").val();
                var n = $("#unavailable_form_t").closest(".c-tab").find(".loading.global-ajax-form-loader");
                n.removeClass("d-none"), a.post(APP_URL + "/check_season_name/" + s, {
                    season_name: e.unavailable_data.seasonal_name,
                    edit_season_name: e.unavailable_data.edit_seasonal_name
                }).then(function(t) {
                    "Already Name" == t.data.status ? (n.addClass("d-none"), fe.showErrors({
                        seasonal_name: "Season name Already used"
                    })) : a.post(APP_URL + "/save_unavailable_dates/" + s, {
                        data: e.unavailable_data
                    }).then(function(e) {
                        n.addClass("d-none"), "false" == e.data.success ? fe.showErrors(e.data.errors) : (toastr.success("Blocked date range has been saved successfully."), window.location = APP_URL + "/manage-listing/" + s + "/calendar")
                    })
                })
            }
        })
    }

    function K() {
        $(".seasonal_checkin").val(""), $(".seasonal_checkout").val(""), $(".formatted_seasonal_checkin").val(""), $(".formatted_seasonal_checkout").val(""), e.rsv_data.seasonal_name = "", e.rsv_data.edit_seasonal_name = "", e.rsv_data.notes = "", e.season_data.seasonal_name = "", e.season_data.edit_seasonal_name = "", e.season_data.price = 0, e.season_data.additional_guest = 0, e.season_data.week = 0, e.season_data.month = 0, e.season_data.weekend = 0, e.season_data.minimum_stay = 0, e.unavailable_data.seasonal_name = "", e.unavailable_data.edit_seasonal_name = "", $(".day_cancel").addClass("d-none").removeClass("d-inline-block"), $("#reservation_type_t").val("Calendar"), $("#calendar_form_group input.error").removeClass("error")
    }

    function Z() {
        $("#calendar_form_group").removeClass("show"), $("#calendar_form_tabs form").each(function(e) {
            if ("edit" == $(this).attr("data-mode")) {
                $(this).attr("data-mode", "create");
                var a = $(this).attr("id");
                "reservation_form_t" == a ? L("") : "season_form_t" == a ? U("") : "unavailable_form_t" == a && R("")
            }
        }), $("#calendar_form_tabs form").attr("data-mode", "create"), e.rsv_data.edit_seasonal_name = "", e.season_data.edit_seasonal_name = "", e.unavailable_data.edit_seasonal_name = "", $("#calendar_form_tabs .day_delete").addClass("d-none").removeClass("d-block"), $("#calendar_form_tabs .day_cancel").addClass("d-none").removeClass("d-inline-block"), $(".c-tab").find(".info-wrapper").addClass("d-none")
    }

    function V() {
        L(""), $("#reservation_form_t").attr("data-mode", "create"), $("#reservation_form_t .seasonal_checkin").val(""), $("#reservation_form_t .seasonal_checkout").val(""), $("#reservation_form_t .formatted_seasonal_checkin").val(""), $("#reservation_form_t .formatted_seasonal_checkout").val(""), e.rsv_data.seasonal_name = "", e.rsv_data.edit_seasonal_name = "", e.rsv_data.notes = "", $("#reservation_form_t").closest(".c-tab").find(".info-wrapper").addClass("d-none"), $("#reservation_form_t .day_delete").addClass("d-none").removeClass("d-block"), $("#reservation_form_t .day_cancel").addClass("d-none").removeClass("d-inline-block")
    }

    function ee() {
        R(""), $("#unavailable_form_t").attr("data-mode", "create"), $("#unavailable_form_t .seasonal_checkin").val(""), $("#unavailable_form_t .seasonal_checkout").val(""), $("#unavailable_form_t .formatted_seasonal_checkin").val(""), $("#unavailable_form_t .formatted_seasonal_checkout").val(""), e.unavailable_data.seasonal_name = "", e.unavailable_data.edit_seasonal_name = "", $("#unavailable_form_t").closest(".c-tab").find(".info-wrapper").addClass("d-none"), $("#unavailable_form_t .day_delete").addClass("d-none").removeClass("d-block"), $("#unavailable_form_t .day_cancel").addClass("d-none").removeClass("d-inline-block")
    }

    function ae() {
        U(""), $("#season_form_t").attr("data-mode", "create"), $("#season_form_t .seasonal_checkin").val(""), $("#season_form_t .seasonal_checkout").val(""), $("#season_form_t .formatted_seasonal_checkin").val(""), $("#season_form_t .formatted_seasonal_checkout").val(""), e.season_data.seasonal_name = "", e.season_data.edit_seasonal_name = "", e.season_data.price = 0, e.season_data.additional_guest = 0, e.season_data.week = 0, e.season_data.month = 0, e.season_data.weekend = 0, e.season_data.minimum_stay = 0, $("#season_form_t").closest(".c-tab").find(".info-wrapper").addClass("d-none"), $("#season_form_t .day_delete").addClass("d-none").removeClass("d-block"), $("#season_form_t .day_cancel").addClass("d-none").removeClass("d-inline-block")
    }
    e.text_length_calc = function(e) {
        return tag_free_text = e ? String(e).replace(/<[^>]+>/gm, "") : "", tag_free_text.length
    }, $(document).on("click", "#add_language", function() {
        $("#add_language_des").show(), $(".description_form").hide(), $(".tab-item").attr("aria-selected", "false"), $("#write-description-button").prop("disabled", !0), a.post("get_all_language", {}).then(function(a) {
            e.all_language = a.data
        })
    }), $(document).on("click", "#delete_language", function() {
        var t = $("#current_tab_code").val();
        a.post("delete_language", {
            current_tab: t
        }).then(function(s) {
            a.post("lan_description", {}).then(function(a) {
                e.lan_description = a.data, t = $("#current_tab_code").val("en")
            }), e.getdescription("en")
        })
    }), $(document).on("change", "#language-select", function() {
        $("#write-description-button").prop("disabled", !1)
    }), a.post("lan_description", {}).then(function(a) {
        e.lan_description = a.data
    }), a.post("get_all_language", {}).then(function(a) {
        e.all_language = a.data
    }), a.post("get_description", {
        lan_code: "en"
    }).then(function(a) {
        e.cancel_message = a.data[0].cancel_message, e.name = a.data[0].name, e.summary = a.data[0].summary, e.space = a.data[0].rooms_description.space, e.access = a.data[0].rooms_description.access, e.interaction = a.data[0].rooms_description.interaction, e.notes = a.data[0].rooms_description.notes, e.house_rules = a.data[0].rooms_description.house_rules, e.neighborhood_overview = a.data[0].rooms_description.neighborhood_overview, e.transit = a.data[0].rooms_description.transit, null === e.cancel_message && (e.cancel_message = ""), null === e.name && (e.name = ""), null === e.summary && (e.summary = ""), null === e.space && (e.space = ""), null === e.access && (e.access = ""), null === e.interaction && (e.interaction = ""), null === e.notes && (e.notes = ""), null === e.house_rules && (e.house_rules = ""), null === e.neighborhood_overview && (e.neighborhood_overview = ""), null === e.transit && (e.transit = ""), r()
    }), e.getdescription = function(t) {
        var t = t;
        a.post("get_description", {
            lan_code: t
        }).then(function(a) {
            if ("en" != t ? (e.cancel_message = a.data[0].cancel_message, e.name = a.data[0].name, e.summary = a.data[0].summary, e.space = a.data[0].space, e.access = a.data[0].access, e.interaction = a.data[0].interaction, e.notes = a.data[0].notes, e.house_rules = a.data[0].house_rules, e.neighborhood_overview = a.data[0].neighborhood_overview, e.transit = a.data[0].transit, r()) : (e.name = a.data[0].name, e.summary = a.data[0].summary, e.space = a.data[0].rooms_description.space, e.access = a.data[0].rooms_description.access, e.interaction = a.data[0].rooms_description.interaction, e.notes = a.data[0].rooms_description.notes, e.house_rules = a.data[0].rooms_description.house_rules, e.neighborhood_overview = a.data[0].rooms_description.neighborhood_overview, e.transit = a.data[0].rooms_description.transit, r()), a.data[0].lang_code) {
                var s = $("#" + a.data[0].lang_code).attr("aria-selected");
                $("#current_tab_code").val(a.data[0].lang_code), $("#delete_language").show()
            } else {
                var s = $("#en").attr("aria-selected");
                a.data[0].lang_code = "en", $("#current_tab_code").val(a.data[0].lang_code), $("#delete_language").hide()
            }
            "false" == s && ($(".tab-item").attr("aria-selected", "false"), $("#" + a.data[0].lang_code).attr("aria-selected", "true")), $("#add_language_des").hide(), $(".description_form").show()
        })
    }, e.addlanguageRow = function() {
        var t = $("#language-select").val();
        $("#current_tab_code").val(t), a.post("add_description", {
            lan_code: t
        }).then(function(t) {
            e.name = t.data[0].name, e.summary = t.data[0].summary, e.space = t.data[0].space, e.access = t.data[0].access, e.interaction = t.data[0].interaction, e.notes = t.data[0].notes, e.house_rules = t.data[0].house_rules, e.neighborhood_overview = t.data[0].neighborhood_overview, e.transit = t.data[0].transit, r(), $("#write-description-button").prop("disabled", !0), a.post("lan_description", {}).then(function(a) {
                e.lan_description = a.data, $("#add_language_des").hide(), $(".description_form").show(), $(".multiple-description-tabs").show(), $("#delete_language").show();
                var t = a.data[0].lan_id - 1;
                $(".tab-item").attr("aria-selected", "false"), setTimeout(function() {
                    $("#" + a.data[t].lan_code).attr("aria-selected", "true")
                }, 100)
            }), $("#language-select").prop("selectedIndex", 0)
        })
    }, jQuery(document).ready(function(e) {
        window.history && e(window).on("popstate", function() {
            var a = window.location.href.split("/"),
                t = e(a).get(-1);
            e("#href_" + t).attr("href", window.location.href), e("#href_" + t).trigger("click")
        })
    }), $(document).on("click", '[data-track="welcome_modal_finish_listing"]', function() {
        var e = {};
        e.started = "Yes";
        var t = JSON.stringify(e);
        a.post("update_rooms", {
            data: t
        }).then(function(e) {
            $(".welcome-new-host-modal").attr("aria-hidden", "true")
        }, function(e) {
            "300" == e.status ? window.location = APP_URL + "/login" : "500" == e.status && window.location.reload()
        })
    }), $(document).on("click", ".listing-submit-modal button.js-finish", function() {
        $(".listing-submit-modal").attr("aria-hidden", "true");
        var e = $(".listing-submit-modal").find("#rooms_id").val();
        window.location = APP_URL + "/manage-listing/" + e + "/subscribe_property"
    }), $(document).on("click", ".listing-submit-modal button.js-cancel", function() {
        $(".listing-submit-modal").attr("aria-hidden", "true"), window.location = APP_URL + "/rooms"
    }), $(document).on("click", '[data-track="welcome_modal_publish"]', function() {
        var e = {};
        e.started = "Yes";
        var t = JSON.stringify(e),
            s = $(this).attr("data-href");
        a.post("update_rooms", {
            data: t
        }).then(function(e) {
            $(".welcome-new-host-modal").attr("aria-hidden", "true")
        }, function(e) {
            "300" == e.status ? window.location = APP_URL + "/login" : "500" == e.status && (window.location = s)
        })
    }), $(document).on("change", '[id^="basics-select-"], [id^="select-"]', function() {
        var t = {};
        t[$(this).attr("name")] = $(this).val();
        var s = JSON.stringify(t),
            n = $(this).attr("data-saving");
        $("." + n + " h5").text("Saving..."), $("." + n).fadeIn(), a.post("update_rooms", {
            data: s
        }).then(function(a) {
            if ("true" == a.data.success && ($("." + n + " h5").text("Saved!"), $("." + n).fadeOut(), $("#steps_count").text(a.data.steps_count), e.steps_count = a.data.steps_count), "" != a.data.redirect && void 0 != a.data.redirect && (window.location = a.data.redirect), "" != e.beds && "" != e.bedrooms && "" != e.bathrooms && "" != e.bed_type) {
                var t = n.substring(0, n.length - 1);
                $('[data-track="' + t + '"] a div div .transition').removeClass("visible"), $('[data-track="' + t + '"] a div div .transition').addClass("hide"), $('[data-track="' + t + '"] a div div .pull-right .nav-icon').removeClass("hide")
            }
        }, function(e) {
            "300" == e.status ? window.location = APP_URL + "/login" : "500" == e.status && window.location.reload()
        }), "beds" == $(this).attr("name") && "" != $(this).val() && $("#beds_show").show()
    }), $(document).on("change", '[id^="plans-select-"]', function() {
        var t = {};
        t[$(this).attr("name")] = $(this).val();
        var s = JSON.stringify(t),
            n = $(this).attr("data-saving");
        $("." + n + " h5").text("Saving..."), $("." + n).fadeIn(), a.post("update_rooms", {
            data: s
        }).then(function(a) {
            if ("true" == a.data.success && ($("." + n + " h5").text("Saved!"), $("." + n).fadeOut(), $("#steps_count").text(a.data.steps_count), e.steps_count = a.data.steps_count, 0 == a.data.steps_count && $("#listing_publish_btn").prop("disabled", !1)), "" != a.data.redirect && void 0 != a.data.redirect && (window.location = a.data.redirect), "" != e.plan_type) {
                var t = n.substring(0, n.length - 1);
                $('[data-track="' + t + '"] a div div .transition').removeClass("visible"), $('[data-track="' + t + '"] a div div .transition').addClass("hide"), $('[data-track="' + t + '"] a div div .pull-right .nav-icon').removeClass("hide")
            }
        }, function(e) {
            "300" == e.status ? window.location = APP_URL + "/login" : "500" == e.status && window.location.reload()
        }), "beds" == $(this).attr("name") && "" != $(this).val() && $("#beds_show").show()
    }), $(document).on("click", "#listing_publish_btn", function() {
        console.log("publish");
        var e, t = {};
        $(this).data("message"), $(this).data("action");
        a.post("get_description", {
            lan_code: "en"
        }).then(function(s) {
            e = "1" == s.data[0].approved_status ? "Listed" : "Unlisted", t.status = e;
            var i = JSON.stringify(t);
            a.post("update_rooms", {
                data: i
            }).then(function(a) {
                "true" == a.data.success && ("Listed" == e ? window.location = APP_URL + "/rooms" : n()), "" != a.data.redirect && void 0 != a.data.redirect && (window.location = a.data.redirect)
            }, function(e) {
                "300" == e.status ? window.location = APP_URL + "/login" : "500" == e.status && window.location.reload()
            })
        })
    }), $(document).on("click", "#js-publish-button .js-list-space-button", n), $(document).on("click", "#listing_draft_btn", function() {
        var e = {};
        e.status = "Draft";
        var t = JSON.stringify(e);
        a.post("update_rooms", {
            data: t
        }).then(function(e) {
            "true" == e.data.success && swal({
                title: "Are you sure?",
                text: "You don't want to publish your listing now?",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
                cancelButtonText: "No"
            }).then(function(t) {
                t.value ? 0 == e.data.steps_count ? a.get(APP_URL + "/users/has_verified_phone", {}).then(function(a) {
                    "true" == a.data ? window.location = APP_URL + "/manage-listing/" + e.data.room_id + "/subscribe_property" : $(".listing-phone-verify-modal").attr("aria-hidden", "false")
                }) : swal({
                    title: "Warning",
                    text: "Please finish  all steps of this listing.",
                    type: "warning"
                }) : "cancel" == t.dismiss && (window.location = APP_URL + "/rooms")
            }), "" != e.data.redirect && void 0 != e.data.redirect && (window.location = e.data.redirect)
        }, function(e) {
            "300" == e.status ? window.location = APP_URL + "/login" : "500" == e.status && window.location.reload()
        })
    }), $(document).on("blur", "#video", function() {
        var t = {};
        t[$(this).attr("name")] = $(this).val();
        var s = JSON.stringify(t);
        $("#video_error").fadeOut(), $(".saving-progress h5").text("Saving..."), $(".saving-progress").fadeIn(), a.post("update_rooms", {
            data: s
        }).then(function(a) {
            "true" == a.data.success ? ($(".saving-progress h5").text("Saved!"), $(".saving-progress").fadeOut(), e.video = a.data.video, $("#rooms_video_preview").parent().removeClass("hide"), $("#rooms_video_preview").attr("src", a.data.video)) : ($(".saving-progress").fadeOut(), $("#video_error").fadeIn())
        }, function(e) {
            "300" == e.status ? window.location = APP_URL + "/login" : "500" == e.status && window.location.reload()
        })
    }), $(document).on("click", "#remove_rooms_video", function() {
        $(this).attr("data-saving");
        $(".saving-progress h5").text("Removing..."), $(".saving-progress").fadeIn(), a.post("remove_video").then(function(a) {
            "true" == a.data.success && ($(".saving-progress h5").text("Removed!"), $(".saving-progress").fadeOut(), $("#video").val(""), $("#rooms_video_preview").parent().addClass("hide"), $("#rooms_video_preview").attr("src", ""), e.video = a.data.video)
        })
    }), $(document).on("blur", 'input[name="name"]', function() {
        var t = {};
        t[$(this).attr("name")] = $(this).val();
        var s = $("#current_tab_code").val(),
            n = JSON.stringify(t);
        $(".saving-progress h5").text("Saving..."), $(".saving-progress").fadeIn(), "en" == s && ($(".name_required_msg").addClass("hide"), $(".name_required").removeClass("invalid")), a.post("update_rooms", {
            data: n,
            current_tab: s
        }).then(function(a) {
            "true" == a.data.success && ($(".saving-progress h5").text("Saved!"), $(".saving-progress").fadeOut(), $("#steps_count").text(a.data.steps_count), e.steps_count = a.data.steps_count, $("#preview-btn").attr("href", a.data.address_url), "" == e.name && ($(".name_required_msg").removeClass("hide"), $(".name_required").addClass("invalid")), i(s))
        }, function(e) {
            "300" == e.status ? window.location = APP_URL + "/login" : e.status
        }), "en" == s && (e.rooms_default_description.name = e.name, e.rooms_default_description.summary = e.summary)
    });
    var te = "undo redo | bold italic underline | numlist bullist outdent indent";
    e.summary_tinymceOptions = {
        height: 50,
        menubar: !1,
        plugins: "lists paste",
        toolbar: te,
        paste_as_text: !0,
        init_instance_callback: function(a) {
            a.on("blur", function(a) {
                o() ? $(".summary_required_msg").addClass("hide") : $(".summary_required_msg").removeClass("hide"), e.summary_overflow || d(e.summary, "summary")
            }), a.on("GetContent", function(a) {
                o(a.content) && $(".summary_required_msg").addClass("hide"), e.summary_len = a.content.length, a.content.length > e.summary_limit ? e.summary_overflow = !0 : e.summary_overflow = !1
            })
        }
    }, e.space_tinymceOptions = {
        height: 50,
        menubar: !1,
        plugins: "lists paste",
        toolbar: te,
        paste_as_text: !0
    }, e.access_tinymceOptions = {
        height: 50,
        menubar: !1,
        plugins: "lists paste",
        toolbar: te,
        paste_as_text: !0,
        init_instance_callback: function(a) {
            a.on("GetContent", function(a) {
                e.access_len = a.content.length, a.content.length > e.access_limit ? e.access_overflow = !0 : e.access_overflow = !1
            })
        }
    }, e.interaction_tinymceOptions = {
        height: 50,
        menubar: !1,
        plugins: "lists paste",
        toolbar: te,
        paste_as_text: !0,
        init_instance_callback: function(a) {
            a.on("GetContent", function(a) {
                e.interaction_len = a.content.length, a.content.length > e.interaction_limit ? e.interaction_overflow = !0 : e.interaction_overflow = !1
            })
        }
    }, e.notes_tinymceOptions = {
        height: 50,
        menubar: !1,
        plugins: "lists paste",
        toolbar: te,
        paste_as_text: !0,
        init_instance_callback: function(a) {
            a.on("GetContent", function(a) {
                e.notes_len = a.content.length, a.content.length > e.notes_limit ? e.notes_overflow = !0 : e.notes_overflow = !1
            })
        }
    }, e.house_rules_tinymceOptions = {
        height: 50,
        menubar: !1,
        plugins: "lists paste",
        toolbar: te,
        paste_as_text: !0,
        init_instance_callback: function(a) {
            a.on("GetContent", function(a) {
                e.house_len = a.content.length, a.content.length > e.house_limit ? e.house_overflow = !0 : e.house_overflow = !1
            })
        }
    }, e.neighborhood_overview_tinymceOptions = {
        height: 50,
        menubar: !1,
        plugins: "lists paste",
        toolbar: te,
        paste_as_text: !0,
        init_instance_callback: function(a) {
            a.on("GetContent", function(a) {
                e.neighbor_len = a.content.length, a.content.length > e.neighbor_limit ? e.neighbor_overflow = !0 : e.neighbor_overflow = !1
            })
        }
    }, e.transit_tinymceOptions = {
        height: 50,
        menubar: !1,
        plugins: "lists paste",
        toolbar: te,
        paste_as_text: !0,
        init_instance_callback: function(a) {
            a.on("GetContent", function(a) {
                e.transit_len = a.content.length, a.content.length > e.transit_limit ? e.transit_overflow = !0 : e.transit_overflow = !1
            })
        }
    }, e.cancel_message_tinymceOptions = {
        height: 50,
        menubar: !1,
        plugins: "lists paste",
        toolbar: te,
        paste_as_text: !0,
        init_instance_callback: function(a) {
            a.on("blur", function(a) {
                c(e.cancel_message, "cancel_message")
            })
        }
    }, e.save_descriptions = function(t) {
        var s = $("." + t).attr("data-href"),
            n = {},
            i = $("#current_tab_code").val();
        setTimeout(function() {
            n = l();
            var t = JSON.stringify(n);
            $(".saving-progress h5").text("Saving..."), $(".help-panel-saving").fadeIn(), $(".help-panel-neigh-saving").fadeIn(), a.post("update_description", {
                data: t,
                current_tab: i
            }).then(function(e) {
                window.location = s
            });
            var o = {};
            o.name = $('input[name="name"]').val(), o.summary = e.summary;
            var r = ($("#current_tab_code").val(), JSON.stringify(o));
            $(".saving-progress h5").text("Saving..."), $(".saving-progress").fadeIn(), a.post("update_rooms", {
                data: r,
                current_tab1: i
            }).then(function(e) {
                window.location = s
            })
        }, 500)
    }, e.save_cancel_message = function(t) {
        var s = $("." + t).attr("data-href"),
            n = {};
        setTimeout(function() {
            n.cancel_message = $('textarea[name="cancel_message"]').val();
            var t = JSON.stringify(n);
            $(".saving-progress h5").text("Saving..."), $(".help-panel-saving").fadeIn(), $(".help-panel-neigh-saving").fadeIn(), a.post("update_rooms", {
                data: t
            }).then(function(a) {
                "true" == a.data.success && ($(".saving-progress h5").text("Saved!"), $(".saving-progress").fadeOut(), "" != e.cancel_message ? ($("#steps_count").text(a.data.steps_count), e.steps_count = a.data.steps_count, $('[data-track="terms"] a div div .transition').removeClass("visible"), $('[data-track="terms"] a div div .transition').addClass("hide"), $('[data-track="terms"] a div div div .icon-ok-alt').removeClass("hide")) : ($('[data-track="terms"] a div div .transition').removeClass("hide"), $('[data-track="terms"] a div div div .icon-ok-alt').addClass("hide"))), window.location = s
            })
        }, 500)
    }, $(document).on("click", "#js-write-more", function() {
        $(".write_more_p").hide(), $("#js-section-details").show(), $("#js-section-details_2").show()
    }), $(document).on("click", ".nav-item a, .next_step a, #calendar_edit_cancel", function() {
        if ("" != $(this).attr("href")) {
            var t = window.location.href.split("/"),
                s = $(t).get(-1);
            if ("description" == s) {
                var n = {},
                    i = $("#current_tab_code").val(),
                    o = $(this).attr("id");
                setTimeout(function() {
                    n = l();
                    var t = JSON.stringify(n);
                    $(".saving-progress h5").text("Saving..."), $(".help-panel-saving").fadeIn(), $(".help-panel-neigh-saving").fadeIn(), a.post("update_description", {
                        data: t,
                        current_tab: i
                    }).then(function(e) {
                        _($("#" + o))
                    });
                    var s = {};
                    s.name = $('input[name="name"]').val(), s.summary = e.summary;
                    var r = ($("#current_tab_code").val(), JSON.stringify(s));
                    $(".saving-progress h5").text("Saving..."), $(".saving-progress").fadeIn(), a.post("update_rooms", {
                        data: r,
                        current_tab1: i
                    }).then(function(e) {})
                }, 500)
            } else if ("terms" == s) {
                var n = {},
                    o = $(this).attr("id");
                $(".saving-progress h5").text("Saving..."), $(".saving-progress").fadeIn(), setTimeout(function() {
                    n.cancel_message = $('textarea[name="cancel_message"]').val();
                    var t = JSON.stringify(n);
                    a.post("update_rooms", {
                        data: t
                    }).then(function(a) {
                        "true" == a.data.success && ($(".saving-progress h5").text("Saved!"), $(".saving-progress").fadeOut(), "" != e.cancel_message ? ($("#steps_count").text(a.data.steps_count), e.steps_count = a.data.steps_count, $('[data-track="terms"] a div div .transition').removeClass("visible"),
                            $('[data-track="terms"] a div div .transition').addClass("hide"), $('[data-track="terms"] a div div div .icon-ok-alt').removeClass("hide")) : ($('[data-track="terms"] a div div .transition').removeClass("hide"), $('[data-track="terms"] a div div div .icon-ok-alt').addClass("hide"))), _($("#" + o))
                    })
                }, 500)
            } else _($(this));
            return !1
        }
    }), $(document).on("click", "#show_long_term", function() {
        $("#js-long-term-prices").removeClass("hide"), $("#js-set-long-term-prices").addClass("hide")
    }), $(document).on("click", "#js-add-address, #js-edit-address", function() {
        var s = {};
        e.autocomplete_used = !1, s.country = e.country, s.address_line_1 = e.address_line_1, s.address_line_2 = e.address_line_2, s.city = e.city, s.state = e.state, s.postal_code = e.postal_code, s.latitude = e.latitude, s.longitude = e.longitude;
        var n = JSON.stringify(s);
        $("#js-address-container").addClass("enter_address"), $("#address-flow-view .modal").fadeIn(), $("#address-flow-view .modal").attr("aria-hidden", "false"), a.post(window.location.href.replace("manage-listing", "enter_address"), {
            data: n
        }).then(function(a) {
            $("#js-address-container").html(t(a.data)(e)), u()
        })
    }), $(document).on("click", "#js-add-bedrooms, #js-edit-bedrooms", function() {
        var s = $(this).attr("data-bed-id");
        void 0 !== s && null !== s || (s = 0), $("#js-bedroom-bathroom-container").addClass("enter_address"), $("#edit-bedrooms-bathrooms .modal").fadeIn(), $("#edit-bedrooms-bathrooms .modal").attr("aria-hidden", "false"), a.post(window.location.href.replace("manage-listing", "add_bedroom"), {
            data: {
                bed_id: s
            }
        }).then(function(a) {
            $("#js-bedroom-bathroom-container").html(t(a.data)(e))
        })
    }), $(document).on("click", "#js-add-bathrooms, #js-edit-bathrooms", function() {
        var s = $(this).attr("data-bath-id");
        void 0 !== s && null !== s || (s = 0), $("#js-bedroom-bathroom-container").addClass("enter_address"), $("#edit-bedrooms-bathrooms .modal").fadeIn(), $("#edit-bedrooms-bathrooms .modal").attr("aria-hidden", "false"), a.post(window.location.href.replace("manage-listing", "add_bathroom"), {
            data: {
                bath_id: s
            }
        }).then(function(a) {
            $("#js-bedroom-bathroom-container").html(t(a.data)(e))
        })
    }), e.none_checked = !1, e.empty_bathroom_name = !1, e.empty_bathroom_type = !1, $(document).on("change", "#editbathroomsForm .checkbox_check", function() {
        1 == $(this).prop("checked") && (e.none_checked = !1, e.$apply())
    }), $(document).on("change", "select[name=bathroom_type]", function() {
        "" != $(this).find(":selected").val() && (e.empty_bathroom_type = !1, e.$apply())
    }), $(document).on("input", "input[name=bathroom_name]", function() {
        e.empty_bathroom_name = !1, e.$apply()
    }), $(document).on("click", "#bathroomsubmit", function() {
        var t = $("input[name=bathroom_name]").val(),
            s = $("input[name=id]").val(),
            n = $("select[name=bathroom_type]").find(":selected").text(),
            i = $("input[name=room_id]").val(),
            o = new Array;
        if ($('input[name="bathfeature[]"]:checked').each(function() {
                o.push(this.value)
            }), e.empty_bathroom_name = "" == t, e.empty_bathroom_type = "" == $("select[name=bathroom_type]").find(":selected").val(), e.none_checked = 0 == o.length, e.empty_bathroom_name || e.empty_bathroom_type || e.none_checked) return e.$apply(), !1;
        url = APP_URL + "/saveOrUpdate_bathroom";
        $("form#editbathroomsForm").parent().append('<div class="loading global-ajax-form-loader"></div>'), $("#bathroomsubmit").prop("disabled", !0), a.post(url, {
            id: s,
            bthnm: t,
            bthty: n,
            room_id: i,
            bathfet: o
        }).then(function(a) {
            "fail" === a.data.validator ? ($("form#editbathroomsForm").parent().find(".global-ajax-form-loader").remove(), $("#bathroomsubmit").prop("disabled", !1), e.bathroom_validation_failed = !0, setTimeout(function() {
                e.bathroom_validation_failed = !1, e.$apply()
            }, 5e3), e.bathroom_validation_errors = a.data.errors) : window.location.reload()
        })
    }), $(".deletebedrooms").click(function(e) {
        var a = $(this).attr("data-bed-id"),
            t = $(this).attr("data-room-id");
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this Bedroom!",
            type: "warning",
            showCancelButton: !0,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then(function(e) {
            e.value && $.ajax({
                type: "POST",
                url: APP_URL + "/delete_bedroom",
                data: {
                    bedid: a,
                    room_id: t
                },
                beforeSend: function() {},
                success: function(e) {
                    swal("Deleted!", "Your bedroom has been deleted.", "success"), window.location.reload()
                }
            })
        })
    }), $(".deletebathrooms").click(function(e) {
        var a = $(this).attr("data-bath-id"),
            t = $(this).attr("data-room-id");
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this Bathroom!",
            type: "warning",
            showCancelButton: !0,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then(function(e) {
            e.value && $.ajax({
                type: "POST",
                url: APP_URL + "/delete_bathroom",
                data: {
                    bathid: a,
                    room_id: t
                },
                beforeSend: function() {},
                success: function(e) {
                    swal("Deleted!", "Your bathroom has been deleted.", "success"), window.location.reload()
                }
            })
        })
    }), e.none_selected = !1, e.empty_bedroom_name = !1, $(document).on("change", "#editbedroomsForm select.rjcontrol", function() {
        0 != $(this).val() && (e.none_selected = !1, e.$apply())
    }), $(document).on("input", "input[name=bedroom_name]", function() {
        e.empty_bedroom_name = !1, e.$apply()
    }), $(document).on("click", "#bedroom_submit", function() {
        var t = $("input[name=bedroom_name]").val(),
            s = $("input[name=room_id]").val(),
            n = $("input[name=id]").val(),
            i = $("select[name=noof_king]").find(":selected").text(),
            o = $("select[name=nooqueen]").find(":selected").text(),
            r = $("select[name=noofdouble]").find(":selected").text(),
            d = $("select[name=twinsingle]").find(":selected").text(),
            l = $("select[name=bunkbed]").find(":selected").text(),
            c = $("select[name=nochildbed]").find(":selected").text(),
            _ = $("select[name=nosleepsofa]").find(":selected").text(),
            u = $("select[name=murphy]").find(":selected").text(),
            m = $("select[name=babycrib]").find(":selected").text();
        if (e.empty_bedroom_name = "" == t, e.none_selected = 0 == i && 0 == o && 0 == r && 0 == d && 0 == l && 0 == c && 0 == _ && 0 == u && 0 == m, "" == t || e.none_selected) return e.$apply(), !1;
        url = APP_URL + "/saveOrUpdate_bedroom";
        $("form#editbedroomsForm").parent().append('<div class="loading global-ajax-form-loader"></div>'), $("#bedroom_submit").prop("disabled", !0), a.post(url, {
            id: n,
            bedroom_name: t,
            room_id: s,
            noof_king: i,
            nooqueen: o,
            noofdouble: r,
            twinsingle: d,
            bunkbed: l,
            nochildbed: c,
            nosleepsofa: _,
            murphy: u,
            babycrib: m
        }).then(function(a) {
            "fail" === a.data.validator ? ($("form#editbedroomsForm").parent().find(".global-ajax-form-loader").remove(), $("#bedroom_submit").prop("disabled", !1), e.bedroom_validation_failed = !0, setTimeout(function() {
                e.bedroom_validation_failed = !1, e.$apply()
            }, 5e3), e.bedroom_validation_errors = a.data.errors) : window.location.reload()
        })
    }), $(document).on("click", "#js-next-btn", function() {
        var s = {};
        s.country = e.country = $("#country").val(), s.address_line_1 = e.address_line_1 = $("#address_line_1").val(), s.address_line_2 = e.address_line_2 = $("#address_line_2").val(), s.city = e.city = $("#city").val(), s.state = e.state = $("#state").val(), s.postal_code = e.postal_code = $("#postal_code").val(), s.latitude = e.latitude, s.longitude = e.longitude;
        var n = JSON.stringify(s);
        e.autocomplete_used || (e.location_found = !0), $("#js-address-container .panel").addClass("loading");
        var i = new google.maps.Geocoder;
        address = e.address_line_1 + ", " + e.address_line_2 + ", " + e.city + ", " + e.state + ", " + e.country + ", " + e.postal_code, i.geocode({
            address: address
        }, function(s, i) {
            i == google.maps.GeocoderStatus.OK && (e.latitude = s[0].geometry.location.lat(), e.longitude = s[0].geometry.location.lng(), result = s[0], "street_address" == result.types || "premise" == result.types ? (e.location_found = !0, e.autocomplete_used = !0) : (e.location_found = !1, e.autocomplete_used = !1)), a.post(window.location.href.replace("manage-listing", "location_not_found"), {
                data: n
            }).then(function(a) {
                $("#js-address-container .panel").removeClass("loading"), $("#js-address-container").addClass("location_not_found"), $("#js-address-container").html(t(a.data)(e))
            })
        })
    }), $(document).on("click", "#js-next-btn2", function() {
        var s = {};
        s.country = e.country, s.address_line_1 = e.address_line_1, s.address_line_2 = e.address_line_2, s.city = e.city, s.state = e.state, s.postal_code = e.postal_code, s.latitude = e.latitude, s.longitude = e.longitude;
        var n = JSON.stringify(s);
        $("#js-address-container .panel").addClass("loading"), a.post(window.location.href.replace("manage-listing", "verify_location"), {
            data: n
        }).then(function(a) {
            $("#js-address-container .panel").removeClass("loading"), $("#js-address-container").addClass("location_not_found"), $("#js-address-container").html(t(a.data)(e)), setTimeout(function() {
                p()
            }, 100)
        })
    }), $(document).on("mouseover", '[id^="amenity-tooltip"]', function() {
        var e = $(this).data("id");
        $("#ame-tooltip-" + e).show()
    }), $(document).on("mouseout", '[id^="amenity-tooltip"]', function() {
        $('[id^="ame-tooltip"]').hide()
    }), $(document).on("click", "#js-next-btn3", function() {
        var t = {};
        t.country = e.country = $("#country").val(), t.address_line_1 = e.address_line_1 = $("#address_line_1").val(), t.address_line_2 = e.address_line_2 = $("#address_line_2").val(), t.city = e.city = $("#city").val(), t.state = e.state = $("#state").val(), t.postal_code = e.postal_code = $("#postal_code").val(), t.latitude = e.latitude, t.longitude = e.longitude;
        var s = JSON.stringify(t);
        $("#js-address-container .panel:first").addClass("loading"), a.post(window.location.href.replace("manage-listing", "finish_address"), {
            data: s
        }).then(function(a) {
            $("#js-address-container .panel").removeClass("loading"), $(".location-map-container-v2").removeClass("empty-map"), $(".location-map-pin-v2").removeClass("moving"), $(".location-map-pin-v2").addClass("set"), $(".address-static-map img").remove(), $(".address-static-map").append('<img style="width:100%; height:275px;" src="https://maps.googleapis.com/maps/api/staticmap?size=570x275&amp;center=' + a.data.latitude + "," + a.data.longitude + "&amp;zoom=15&amp;maptype=roadmap&amp;sensor=false&key=" + map_key + "&amp;markers=icon:" + APP_URL + "/images/map-pin-set-3460214b477748232858bedae3955d81.png%7C" + a.data.latitude + "," + a.data.longitude + '">'), $(".panel-body .text-center").remove(), $(".panel-body address").removeClass("hide"), $(".panel-body .js-edit-address-link").removeClass("hide");
            var t = "" != a.data.address_line_2 ? " / " + a.data.address_line_2 : "";
            $(".panel-body address span:nth-child(1)").text(a.data.address_line_1 + t), $(".panel-body address span:nth-child(2)").text(a.data.city + " " + a.data.state), $(".panel-body address span:nth-child(3)").text(a.data.postal_code), $(".panel-body address span:nth-child(4)").text(a.data.country_name), $('[data-track="location"] a div div .transition').removeClass("visible"), $('[data-track="location"] a div div .transition').addClass("hide"), $('[data-track="location"] a div div div .icon-ok-alt').removeClass("hide"), $("#address-flow-view .modal").fadeOut(), $("#address-flow-view .modal").attr("aria-hidden", "true"), $("#steps_count").text(a.data.steps_count), e.steps_count = a.data.steps_count, $("#preview-btn").attr("href", a.data.address_url), e.location_found = !1, $("#js-add-address").addClass("hide"), $("#address_view").removeClass("hide"), $("#js-edit-address").removeClass("hide")
        })
    }), $(document).on("click", '.modal-close, [data-behavior="modal-close"], .panel-close', function() {
        $(".modal").attr("aria-hidden", !0), $(".tooltip").css("opacity", "0"), $(".tooltip").attr("aria-hidden", "true"), $(".modal").attr("aria-hidden", "true")
    }), u(), e.location_found = !1, e.autocomplete_used = !1;
    var se;
    $("#address-flow-view .modal").scroll(function() {
        $(".pac-container").hide()
    }), $(document).on("keyup", "#city", function() {
        "" == $(this).val() ? $("#js-next-btn").prop("disabled", !0) : $("#js-next-btn").prop("disabled", !1)
    }), $(document).on("keyup", "#state", function() {
        "" == $(this).val() ? $("#js-next-btn").prop("disabled", !0) : $("#js-next-btn").prop("disabled", !1)
    }), $(document).on("keyup", "#postal_code", function() {
        "" == $(this).val() ? $("#js-next-btn").prop("disabled", !0) : $("#js-next-btn").prop("disabled", !1)
    });
    var ne, ie;
    $(document).on("click", '[name="amenities"]', function() {
        var e = "";
        $('[name="amenities"]').each(function() {
            1 == $(this).prop("checked") && (e = e + $(this).val() + ",")
        });
        var t = $(this).attr("data-saving");
        $("." + t + " h5").text("Saving..."), $("." + t).fadeIn(), a.post("update_amenities", {
            data: e
        }).then(function(e) {
            "true" == e.data.success ? ($("." + t + " h5").text("Saved!"), $("." + t).fadeOut()) : "" != e.data.redirect && void 0 != e.data.redirect && (window.location = e.data.redirect)
        }, function(e) {
            "300" == e.status && (window.location = APP_URL + "/login")
        })
    }), $(document).on("click", "#photo-uploader", function() {
        "false" == $("#upload_photos").attr("on-uploading") && $("#upload_photos").trigger("click")
    }), $(document).on("click", "#js-photo-grid-placeholder", function() {
        $("#upload_photos2").trigger("click")
    }), e.featured_image = function(t, s, n) {
        "Yes" != n && a.post("featured_image", {
            id: $("#room_id").val(),
            photo_id: s
        }).then(function(a) {
            e.photos_list = a.data
        }, function(e) {
            "300" == e.status && (window.location = APP_URL + "/login")
        })
    };
    var oe, re, de;
    e.delete_photo = function(a, t, s, n) {
        $("#js-error .panel-header").text(s), $("#js-error .panel-body").text(n), $(".js-delete-photo-confirm").removeClass("hide"), $("#js-error").attr("aria-hidden", !1), $(".js-delete-photo-confirm").attr("data-id", t);
        var i = e.photos_list.indexOf(a);
        $(".js-delete-photo-confirm").attr("data-index", i)
    }, $(document).on("click", ".js-delete-photo-confirm", function() {
        var t = $(this).attr("data-index");
        a.post("delete_photo", {
            photo_id: $(this).attr("data-id")
        }).then(function(a) {
            "true" == a.data.success ? (e.photos_list.splice(t, 1), $("#js-error").attr("aria-hidden", !0), $("#steps_count").text(a.data.steps_count), e.steps_count = a.data.steps_count) : "" != a.data.redirect && void 0 != a.data.redirect && (window.location = a.data.redirect), void 0 != e.photos_list && (0 != e.photos_list.length ? ($('[data-track="photos"] a div div .transition').removeClass("visible"), $('[data-track="photos"] a div div .transition').addClass("hide"), $('[data-track="photos"] a div div div .icon-ok-alt').removeClass("hide")) : ($('[data-track="photos"] a div div .transition').removeClass("hide"), $('[data-track="photos"] a div div div .icon-ok-alt').addClass("hide")))
        }, function(e) {
            "300" == e.status && (window.location = APP_URL + "/login")
        })
    }), e.$watch("photos_list", function(a) {
        void 0 != e.photos_list && (0 != e.photos_list.length ? ($('[data-track="photos"] a div div .transition').removeClass("visible"), $('[data-track="photos"] a div div .transition').addClass("hide"), $('[data-track="photos"] a div div div .icon-ok-alt').removeClass("hide")) : ($('[data-track="photos"] a div div .transition').removeClass("hide"), $('[data-track="photos"] a div div div .icon-ok-alt').addClass("hide")))
    }), e.$watch("steps_count", function(a) {
        void 0 != e.steps_count && (rooms_status = $("#room_status").val(), 0 == e.steps_count ? ($("#finish_step").hide(), $(".js-steps-remaining").addClass("hide"), $(".js-steps-remaining").removeClass("show"), rooms_status || ($(".listing-nav-sm").addClass("collapsed"), $("body").addClass("non_scrl")), $(".js-list-space-button").css("display", "inline-block"), $("#js-list-space-tooltip").attr("aria-hidden", "false"), setTimeout(function() {
            $("#js-list-space-tooltip").attr("aria-hidden", "true")
        }, 3e3), $("#js-list-space-tooltip").css({
            opacity: "1"
        }), $("#js-list-space-tooltip").removeClass("animated").addClass("animated")) : ($("#finish_step").show(), $(".js-steps-remaining").removeClass("hide"), $(".js-steps-remaining").addClass("show"), rooms_status || ($(".listing-nav-sm").removeClass("collapsed"), $("body").removeClass("non_scrl")), $(".js-list-space-button").css("display", "none"), $("#js-list-space-tooltip").attr("aria-hidden", "true"), $("#js-list-space-tooltip").css({
            opacity: "0"
        })))
    }), e.change_photo_order = function() {
        var e = $("input[name='hidden_image[]']").map(function() {
            return $(this).val()
        }).get();
        a.post("change_photo_order", {
            id: $("#room_id").val(),
            image_id: e
        }).then(function(e) {}, function(e) {})
    }, e.keyup_highlights = function(t, s, n) {
        a.post("photo_highlights", {
            photo_id: t,
            data: s
        }).then(function(a) {
            "false" == a.data.success ? e.photos_list[n].error = a.data.msg : "false" == a.data.success && (e.photos_list[n].error = ""), "" != a.data.redirect && void 0 != a.data.redirect && (window.location = a.data.redirect)
        })
    }, $("#href_photos").click(function() {
        C(), $("#js-manage-listing-nav").removeClass("manage-listing-nav"), $("#js-manage-listing-nav").addClass("pos-abs"), $("#ajax_container").addClass("mar-left-cont")
    }), $(document).on("change", '[id^="price-select-"]', function() {
        if ("price-select-currency_code" != $(this).attr("id") && (!$.isNumeric($(this).val()) || $(this).val() < 0 || "" == $(this).val())) return !1;
        var t = {};
        t[$(this).attr("name")] = $(this).val(), t.night = $("#price-night").val(), t.currency_code = $("#price-select-currency_code").val();
        var s = JSON.stringify(t),
            n = $(this).attr("data-saving");
        $("." + n + " h5").text("Saving..."), $("." + n).fadeIn(), a.post("update_price", {
            data: s
        }).then(function(a) {
            "true" == a.data.success ? (a.data.night_price && $("#price-night").val(a.data.night_price), $('[data-error="price"]').text(""), $("#price-week").val() < a.data.min_amt ? ($('[data-error="week"]').removeClass("hide"), $('[data-error="week"]').html(a.data.msg)) : ($('[data-error="week"]').addClass("hide"), $('[data-error="week"]').text("")), $("#price-month").val() < a.data.min_amt ? ($('[data-error="month"]').removeClass("hide"), $('[data-error="month"]').html(a.data.msg)) : ($('[data-error="month"]').addClass("hide"), $('[data-error="month"]').text("")), $('[data-error="weekly_price"]').text(""), $('[data-error="monthly_price"]').text(""), $(".input-prefix").html(a.data.currency_symbol), $("." + n + " h5").text("Saved!"), $("." + n).fadeOut(), $("#steps_count").text(a.data.steps_count), e.steps_count = a.data.steps_count, $(".ml-error").addClass("hide")) : ("" != a.data.redirect && void 0 != a.data.redirect && (window.location = a.data.redirect), $(".input-prefix").html(a.data.currency_symbol), $('[data-error="price"]').html(a.data.msg), $("." + n).fadeOut(), "" != a.data.attribute && void 0 != a.data.attribute && ($('[data-error="' + a.data.attribute + '"]').html(""), $('[data-error="' + a.data.attribute + '"]').removeClass("hide"), $('[data-error="' + a.data.attribute + '"]').html(a.data.msg), $(".input-prefix").html(a.data.currency_symbol)))
        }, function(e) {
            "300" == e.status && (window.location = APP_URL + "/login")
        })
    }), e.$watch("tax", function(a) {
        e.tax_invalid = !1, "" != a && (isNaN(a) || !angular.isNumber(+a) || a < 0) && (e.tax_invalid = !0)
    }), $(document).on("blur", "#autosavetax", function() {
        if (!$.isNumeric($(this).val()) || $(this).val() < 0 || "" == $(this).val()) return !1;
        var t = {};
        t[$(this).attr("name")] = $(this).val(), t.currency_code = $("#price-select-currency_code").val();
        var s = JSON.stringify(t),
            n = $(this).attr("data-saving");
        $("." + n + " h5").text("Saving..."), $("." + n).fadeIn(), a.post("update_price", {
            data: s
        }).then(function(a) {
            "true" == a.data.success ? ($('[data-error="price"]').text(""), $(".input-prefix").html(a.data.currency_symbol), $("." + n + " h5").text("Saved!"), $("." + n).fadeOut(), $("#steps_count").text(a.data.steps_count), e.steps_count = a.data.steps_count, $(".ml-error").addClass("hide")) : "" != a.data.attribute && void 0 != a.data.attribute && ($('[data-error="' + a.data.attribute + '"]').removeClass("hide"), $('[data-error="' + a.data.attribute + '"]').html(a.data.msg), $(".input-prefix").html(a.data.currency_symbol))
        }, function(e) {
            "300" == e.status && (window.location = APP_URL + "/login")
        })
    }), $(document).on("blur", "input#price-max-guests", function() {
        var e = {};
        e.accommodates = $(this).val();
        var t = JSON.stringify(e),
            s = $(this).attr("data-saving");
        $("." + s + " h5").text("Saving..."), a.post("update_rooms", {
            data: t
        }).then(function(e) {
            "true" == e.data.success && $("." + s + " h5").text("Saved!")
        }, function(e) {
            "300" == e.status ? window.location = APP_URL + "/login" : "500" == e.status && window.location.reload()
        })
    }), $(document).on("blur", '.autosubmit-text[id^="price-"]', function() {
        if (!$.isNumeric($(this).val()) || $(this).val() < 0 || "" == $(this).val()) return !1;
        var t = {};
        t[$(this).attr("name")] = $(this).val(), this_val = Math.round($(this).val()), $(this).val(this_val), t.currency_code = $("#price-select-currency_code").val(), "additional_guest" == $(this).attr("name") && (t.guests = $("#price-select-guests_included").val());
        var s = JSON.stringify(t),
            n = $(this).attr("data-saving"),
            i = "price";
        "night" != $(this).attr("name") && (i = $(this).attr("name")), $("." + n + " h5").text("Saving..."), 0 != $("#price-night").val() ? ($("." + n).fadeIn(), a.post("update_price", {
            data: s
        }).then(function(a) {
            "true" == a.data.success ? ($('[data-error="' + i + '"]').text(""), $(".input-prefix").html(a.data.currency_symbol), $("." + n + " h5").text("Saved!"), $("." + n).fadeOut(), $("#steps_count").text(a.data.steps_count), e.steps_count = a.data.steps_count, $("#update_night_price").text($("#price-night").val()), $("#update_week_price").text($("#price-week").val()), $("#update_month_price").text($("#price-month").val()), "0" != $("#price-minimum_stay").val() && "" != $("#price-minimum_stay").val() ? $("#update_minimum_stay").text($("#price-minimum_stay").val() + " Night") : $("#update_minimum_stay").text("-"), $(".input-prefix1").html(a.data.currency_symbol), $(".ml-error").addClass("hide")) : ("" != a.data.redirect && void 0 != a.data.redirect && (window.location = a.data.redirect), "" != a.data.attribute && void 0 != a.data.attribute ? ($('[data-error="' + a.data.attribute + '"]').html(""), $('[data-error="' + a.data.attribute + '"]').removeClass("hide"), $('[data-error="' + a.data.attribute + '"]').html(a.data.msg), $(".input-prefix").html(a.data.currency_symbol)) : $('[data-error="price"]').html(a.data.msg), $("." + n).fadeOut()), 0 != $("#price-night").val() && ($("#price-night-old").val($("#price-night").val()), a.data.msg || ($('[data-track="pricing"] a div div .transition').removeClass("visible"), $('[data-track="pricing"] a div div .transition').addClass("hide"), $('[data-track="pricing"] a div div div .icon-ok-alt').removeClass("hide")))
        }, function(e) {
            "300" == e.status && (window.location = APP_URL + "/login")
        })) : 0 == $("#price-night-old").val() ? ($("#price-night").val($("#price-night-old").val()), $('[data-track="pricing"] a div div .transition').removeClass("hide"), $('[data-track="pricing"] a div div div .icon-ok-alt').addClass("hide")) : ($("#price-night").val($("#price-night-old").val()), $('[data-track="pricing"] a div div .transition').removeClass("visible"), $('[data-track="pricing"] a div div .transition').addClass("hide"), $('[data-track="pricing"] a div div div .icon-ok-alt').removeClass("hide"))
    }), $(document).on("input", 'input[name^="additional_charge_label"]', function() {
        var e = $(this).closest(".additional_charge_row");
        $(this).closest(".base_priceamt");
        if ("" == $(this).val()) e.attr("valid_ok", !1), $(this).addClass("invalid");
        else {
            $(this).removeClass("invalid");
            var a = e.find('input[name^="additional_charge_price"]').val();
            $.isNumeric(a) && a > 0 ? e.attr("valid_ok", !0) : e.attr("valid_ok", !1)
        }
    }), $(document).on("input", 'input[name^="additional_charge_price"]', function() {
        var e = $(this).closest(".additional_charge_row");
        !$.isNumeric($(this).val()) || $(this).val() < 0 || "" == $(this).val() ? (e.attr("valid_ok", !1), $(this).addClass("invalid")) : ($(this).removeClass("invalid"), "" != e.find('input[name^="additional_charge_label"]').val() ? e.attr("valid_ok", !0) : e.attr("valid_ok", !1))
    }), $(document).on("change", 'input[name^="additional_charge_label"], input[name^="additional_charge_price"], select[name^="additional_charge_price_type[]"], select[name^="additional_charge_calculation_type[]"], select[name^="additional_charge_guest_opt[]"]', function() {
        var e = $(this).closest(".base_priceamt").find(".additional_charge_row"),
            a = !0;
        if (e.each(function(e, t) {
                if ("false" == $(this).attr("valid_ok")) return a = !1, !1
            }), 0 == a) return !1;
        x($(this))
    }), $(".add-more-additional_charge").click(function() {
        var e = $(".copy-fields-additional_charge").html();
        $(".after-add-more-additional_charge").after(e)
    }), $("body").on("click", ".remove-additional_charge", function() {
        $(this).parents(".additional_charge_row").remove(), x($(this))
    }), $(document).on("click", "#save_additional_charge", function() {
        var e = $(".copy-fields-additional_charge").html();
        $(".after-add-more-additional_charge").after(e), tooltip_init()
    }), $(document).on("click", "#remove_additional_charge", function() {
        $(this).parents(".additional_charge_row").remove()
    }), $(document).on("change", '[id$="_checkbox"]', function() {
        if (0 == $(this).prop("checked")) {
            var t = {},
                s = $(this).attr("id"),
                n = '[data-checkbox-id="' + s + '"] > div > div > div > input';
            $(n).val(""), "price_for_extra_person_checkbox" == s && ($('[data-checkbox-id="' + s + '"] > div > div > #guests-included-select > div > select').val(1), t[$('[data-checkbox-id="' + s + '"] > div > div > #guests-included-select > div > select').attr("name")] = 0), t[$(n).attr("name")] = $(n).val(), t.currency_code = $("#price-select-currency_code").val();
            var i = JSON.stringify(t),
                o = $(n).attr("data-saving");
            $("." + o + " h5").text("Saving..."), $("." + o).fadeIn(), a.post("update_price", {
                data: i
            }).then(function(a) {
                "true" == a.data.success && ($(".input-prefix").html(a.data.currency_symbol), $("." + o + " h5").text("Saved!"), $("." + o).fadeOut(), $("#steps_count").text(a.data.steps_count), e.steps_count = a.data.steps_count)
            }, function(e) {
                "300" == e.status && (window.location = APP_URL + "/login")
            })
        }
    }), $(document).on("click", '[id^="available-"]', function() {
        var t = {},
            s = $(this).attr("data-slug");
        t.calendar_type = s.charAt(0).toUpperCase() + s.slice(1);
        var n = JSON.stringify(t);
        $(".saving-progress h5").text("Saving..."), $(".saving-progress").fadeIn(), a.post("update_rooms", {
            data: n
        }).then(function(a) {
            "true" == a.data.success ? (e.selected_calendar = s, $('[data-slug="' + s + '"]').addClass("selected"), $(".saving-progress h5").text("Saved!"), $(".saving-progress").fadeOut(), $("#steps_count").text(a.data.steps_count), e.steps_count = a.data.steps_count) : "" != a.data.redirect && void 0 != a.data.redirect && (window.location = a.data.redirect), $('[data-track="calendar"] a div div .transition').removeClass("visible"), $('[data-track="calendar"] a div div .transition').addClass("hide"), $('[data-track="calendar"] a div div .pull-right .nav-icon').removeClass("hide")
        }, function(e) {
            "300" == e.status ? window.location = APP_URL + "/login" : "500" == e.status && window.location.reload()
        })
    }), $(document).on("mouseover", '[id^="available-"]', function() {
        $('[id^="available-"]').removeClass("selected")
    }), $(document).on("mouseout", '[id^="available-"]', function() {
        $('[id="available-' + e.selected_calendar + '"]').addClass("selected")
    });
    var le = window.location.href.split("/");
    e.step = $(le).get(-1), C(), $(document).on("click", "#finish_step", function() {
        a.get("rooms_steps_status", {}).then(function(e) {
            for (var a in e.data)
                if ("0" == e.data[a]) return angular.element("#href_" + a).trigger("click"), !1
        })
    }), $(document).on("click", "#js-list-space-button", function() {
        var t = {};
        t.status = "Listed";
        var s = JSON.stringify(t);
        a.post("update_rooms", {
            data: s
        }).then(function(t) {
            a.get("rooms_data", {}).then(function(a) {
                $("#symbol_finish").html(a.data.symbol), e.popup_photo_name = a.data.photo_name, e.popup_night = a.data.night, e.popup_room_name = a.data.name, $(".room_name_popup").attr("href", a.data.address_url), e.popup_room_type_name = a.data.room_type_name, e.popup_property_type_name = a.data.property_type_name, e.popup_state = a.data.state, e.popup_country = a.data.country_name, $(".finish-modal").attr("aria-hidden", "false"), $(".finish-modal").removeClass("hide")
            })
        }, function(e) {
            "300" == e.status ? window.location = APP_URL + "/login" : "500" == e.status && window.location.reload()
        })
    }), $(document).on("click", "#collapsed-nav", function() {
        $("#js-manage-listing-nav").hasClass("collapsed") ? $("#js-manage-listing-nav").removeClass("collapsed") : $("#js-manage-listing-nav").addClass("collapsed")
    }), $(document).on("click", ".month-nav", function() {
        var s = $(this).attr("data-month"),
            n = $(this).attr("data-year"),
            i = {};
        i.month = s, i.year = n;
        var o = JSON.stringify(i);
        return $(".ui-datepicker-backdrop").removeClass("hide"), $(".spinner-next-to-month-nav").addClass("loading"), a.post($(this).attr("href").replace("manage-listing", "ajax-manage-listing"), {
            data: o
        }).then(function(a) {
            $("#ajax_container").html(t(a.data)(e)), $(".spinner-next-to-month-nav").removeClass("loading"), $(".ui-datepicker-backdrop").addClass("hide"), H()
        }), !1
    }), $(document).on("change", "#calendar_dropdown", function() {
        var s = $(this).val(),
            n = s.split("-")[0],
            i = s.split("-")[1],
            o = {};
        o.month = i, o.year = n;
        var r = JSON.stringify(o);
        return $(".ui-datepicker-backdrop").removeClass("hide"), $(".spinner-next-to-month-nav").addClass("loading"), a.post($(this).attr("data-href").replace("manage-listing", "ajax-manage-listing"), {
            data: r
        }).then(function(a) {
            $(".ui-datepicker-backdrop").addClass("hide"), $(".spinner-next-to-month-nav").removeClass("loading"), $("#ajax_container").html(t(a.data)(e)), H()
        }), !1
    }), $(document).on("click", ".tile", function() {
        if (1 != window.mobilecheck())
            if ($(this).hasClass("other-day-selected") || $(this).hasClass("selected") || $(this).hasClass("tile-previous")) $(this).hasClass("selected") || ($(".first-day-selected").removeClass("first-day-selected"), $(".last-day-selected").removeClass("last-day-selected"), $(".selected").removeClass("selected"), $(".tile-selection-container").remove(), $(".tile-selection-handle").parent().remove(), $(".other-day-selected").removeClass("other-day-selected"), $(".calendar-edit-form").addClass("hide"));
            else {
                var e = $(this).attr("id");
                $("#" + e).addClass("first-day-selected last-day-selected selected"), $('<div class="tile-selection-container"><div class="tile-selection"></div></div>').insertBefore("#" + e + "> .date");
                var a = ($(this).index(), $(this).position().top + 36),
                    t = $(this).position().left - 5,
                    s = a + 5,
                    n = t + 85;
                $(".days-container").append('<div><div style="left:' + t + "px;top:" + a + 'px;" class="tile-selection-handle tile-handle-left"><div class="tile-selection-handle__inner"><span class="tile-selection-handle__ridge"></span><span class="tile-selection-handle__ridge"></span><span class="tile-selection-handle__ridge"></span></div></div></div><div><div style="left: ' + n + "px; top: " + s + 'px;" class="tile-selection-handle tile-handle-right"><div class="tile-selection-handle__inner"><span class="tile-selection-handle__ridge"></span><span class="tile-selection-handle__ridge"></span><span class="tile-selection-handle__ridge"></span></div></div></div>'), $(".tile").each(function() {
                    e != $(this).attr("id") && $(this).addClass("other-day-selected")
                }), F()
            }
    }), $("#mobile_create_season_btn").css("cursor", "pointer"), $(document).on("click", "#mobile_create_season_btn", function() {
        $("body").css("overflow", "hidden"), $(".manage-listing-footer").hide(), $(".import_calander").hide(), $(".allow_calander").show(), $("#season_name").val(""), $("#unavailable_time").removeClass("new_save"), $("#available_time").addClass("new_save"), $("#season_name").removeClass("not-available-flag"), $("#seasonal_status").val("Available"), $(".ses_block").show(), $(".allow_calander").attr("enable-switching-status", !0)
    });
    var ce = !1;
    $(document).on("mousedown", ".tile-selection-handle, .tile", function() {
        ce = !0
    }), $(document).on("mouseup", ".tile-selection-handle, .tile", function() {
        _e = 0;
        var e = $(".selected").last().attr("id"),
            a = $(".selected").first().attr("id");
        $("*").removeClass("first-day-selected last-day-selected"), $(".selected").first().addClass("first-day-selected"), $(".selected").last().addClass("last-day-selected");
        var t = $("#" + e).position(),
            s = $("#" + a).position();
        if (void 0 != t && void 0 != s) {
            var n = s.top + 35,
                i = s.left - 5,
                o = t.top + 40,
                r = t.left + 80;
            $(".days-container > div > .tile-selection-handle:last").remove(), $(".days-container > div > .tile-selection-handle:first").remove(), $(".days-container").append('<div><div style="left:' + i + "px;top:" + n + 'px;" class="tile-selection-handle tile-handle-left"><div class="tile-selection-handle__inner"><span class="tile-selection-handle__ridge"></span><span class="tile-selection-handle__ridge"></span><span class="tile-selection-handle__ridge"></span></div></div></div><div><div style="left: ' + r + "px; top: " + o + 'px;" class="tile-selection-handle tile-handle-right"><div class="tile-selection-handle__inner"><span class="tile-selection-handle__ridge"></span><span class="tile-selection-handle__ridge"></span><span class="tile-selection-handle__ridge"></span></div></div></div>'), 1 == ce && F()
        }
        ce = !1
    });
    var _e = 0,
        ue = "";
    $(document).on("mousedown", ".tile-selection-handle", function() {
        _e = 1, ue = $(this).hasClass("tile-handle-left") ? "left" : "right"
    });
    var me = 0,
        ve = 0;
    $(document).on("mouseover", ".tile", function(e) {
        if (e.pageX > me && "right" == ue)
            if (1 != _e || $(this).hasClass("tile-previous")) $(this).hasClass("tile-previous") && $(this).trigger("mouseup");
            else {
                var a = $(this).attr("id");
                $("#" + a).removeClass("other-day-selected"), $("#" + a).addClass("selected"), $("#" + $(this).attr("id") + " > div").hasClass("tile-selection-container") || $('<div class="tile-selection-container"><div class="tile-selection"></div></div>').insertBefore("#" + $(this).attr("id") + "> .date");
                var t = $(".selected").last().index(),
                    s = $(".selected").first().index();
                $("*").removeClass("first-day-selected last-day-selected"), $(".selected").first().addClass("first-day-selected"), $(".selected").last().addClass("last-day-selected");
                for (var n = s + 1; n <= t; n++) {
                    var i = $(".days-container > .list-unstyled > li:nth-child(" + n + ")").attr("class");
                    if (0 != i.includes("tile-previous")) return !1;
                    var a = $(".days-container > .list-unstyled > li:nth-child(" + n + ")").attr("id");
                    $("#" + a).addClass("selected"), $("#" + a).removeClass("other-day-selected"), $("#" + a + " > div").hasClass("tile-selection-container") || $('<div class="tile-selection-container"><div class="tile-selection"></div></div>').insertBefore("#" + a + "> .date")
                }
            } else if (e.pageX < me && "right" == ue) {
            if (1 != _e || $(this).hasClass("tile-previous")) $(this).hasClass("tile-previous") && $(this).trigger("mouseup");
            else {
                var a = $(".days-container > .list-unstyled > li:nth-child(" + $(this).index() + ")").next().next().attr("id"),
                    o = $(".days-container > .list-unstyled > li:nth-child(" + $(this).index() + ")").next().attr("id");
                $("*").removeClass("first-day-selected last-day-selected"), $(".selected").first().addClass("first-day-selected"), $(".selected").last().addClass("last-day-selected"), $("#" + a).removeClass("selected"), $("#" + a).addClass("other-day-selected"), $(this).removeClass("selected"), $(this).addClass("other-day-selected"), $("#" + o + " > div.tile-selection-container").remove()
            }
            0 == $(".selected").length && (_e = 0, $(".tile").each(function() {
                $(this).removeClass("other-day-selected last-day-selected first-day-selected"), $(".tile-selection-container").remove(), $(".tile-selection-handle").remove()
            }))
        }
        if (e.pageX > me && "left" == ue)
            if (1 != _e || $(this).hasClass("tile-previous")) $(this).hasClass("tile-previous") && $(this).trigger("mouseup");
            else {
                var a = $(".days-container > .list-unstyled > li:nth-child(" + $(this).index() + ")").attr("id"),
                    o = $(".days-container > .list-unstyled > li:nth-child(" + $(this).index() + ")").attr("id");
                $("*").removeClass("first-day-selected last-day-selected"), $(".selected").first().addClass("first-day-selected"), $(".selected").last().addClass("last-day-selected"), $("#" + a).removeClass("selected"), $("#" + a).addClass("other-day-selected"), $(this).removeClass("selected"), $(this).addClass("other-day-selected"), $("#" + o + " > div.tile-selection-container").remove()
            } else if (e.pageX < me && "left" == ue) {
            if (1 != _e || $(this).hasClass("tile-previous")) $(this).hasClass("tile-previous") && $(this).trigger("mouseup");
            else {
                var a = $(".days-container > .list-unstyled > li:nth-child(" + $(this).index() + ")").next().next().attr("id"),
                    o = $(".days-container > .list-unstyled > li:nth-child(" + $(this).index() + ")").next().attr("id");
                $("#" + a).addClass("selected"), $("#" + a).removeClass("other-day-selected"), $(this).addClass("selected"), $(this).removeClass("other-day-selected");
                for (var t = $(".selected").last().index(), s = $(".selected").first().index(), n = s + 1; n <= t; n++) {
                    var i = $(".days-container > .list-unstyled > li:nth-child(" + n + ")").attr("class");
                    if (0 != i.includes("tile-previous")) return !1;
                    var a = $(".days-container > .list-unstyled > li:nth-child(" + n + ")").attr("id");
                    $("#" + a).addClass("selected"), $("#" + a).removeClass("other-day-selected"), $("#" + a + " > div").hasClass("tile-selection-container") || $('<div class="tile-selection-container"><div class="tile-selection"></div></div>').insertBefore("#" + a + "> .date"), $("#" + a).removeClass("first-day-selected last-day-selected")
                }
                $("*").removeClass("first-day-selected last-day-selected"), $(".selected").first().addClass("first-day-selected"), $(".selected").last().addClass("last-day-selected"), $("#" + a + " > div").hasClass("tile-selection-container") || $('<div class="tile-selection-container"><div class="tile-selection"></div></div>').insertBefore("#" + a + "> .date")
            }
            0 == $(".selected").length && (_e = 0, $(".tile").each(function() {
                $(this).removeClass("other-day-selected last-day-selected first-day-selected"), $(".tile-selection-container").remove(), $(".tile-selection-handle").remove()
            }))
        }
        if (e.pageY > ve && "right" == ue)
            if (1 != _e || $(this).hasClass("tile-previous")) $(this).hasClass("tile-previous") && $(this).trigger("mouseup");
            else {
                var a = $(this).attr("id");
                $("#" + a).removeClass("other-day-selected"), $("#" + a).addClass("selected"), $("#" + $(this).attr("id") + " > div").hasClass("tile-selection-container") || $('<div class="tile-selection-container"><div class="tile-selection"></div></div>').insertBefore("#" + $(this).attr("id") + "> .date");
                var t = $(".selected").last().index(),
                    s = $(".selected").first().index();
                $("*").removeClass("first-day-selected last-day-selected"), $(".selected").first().addClass("first-day-selected"), $(".selected").last().addClass("last-day-selected");
                for (var n = s + 1; n <= t; n++) {
                    var i = $(".days-container > .list-unstyled > li:nth-child(" + n + ")").attr("class");
                    if (0 != i.includes("tile-previous")) return !1;
                    var a = $(".days-container > .list-unstyled > li:nth-child(" + n + ")").attr("id");
                    $("#" + a).addClass("selected"), $("#" + a).removeClass("other-day-selected"), $("#" + a + " > div").hasClass("tile-selection-container") || $('<div class="tile-selection-container"><div class="tile-selection"></div></div>').insertBefore("#" + a + "> .date")
                }
            }
        if (e.pageY < ve && "right" == ue)
            if (1 != _e || $(this).hasClass("tile-previous")) $(this).hasClass("tile-previous") && $(this).trigger("mouseup");
            else if (!$(this).hasClass("selected")) {
            var a = $(this).attr("id"),
                t = $(this).index(),
                s = $(".selected").first().index();
            $(".selected").addClass("other-day-selected"), $(".selected").removeClass("selected");
            for (var n = s + 1; n <= t + 1; n++)
                for (var n = ($(".days-container > .list-unstyled > li:nth-child(" + n + ")").attr("class"), s + 1); n <= t + 1; n++) {
                    var i = $(".days-container > .list-unstyled > li:nth-child(" + n + ")").attr("class");
                    if (0 != i.includes("tile-previous")) return !1;
                    var a = $(".days-container > .list-unstyled > li:nth-child(" + n + ")").attr("id");
                    $("#" + a).addClass("selected"), $("#" + a).removeClass("other-day-selected"), $("#" + a + " > div").hasClass("tile-selection-container") || $('<div class="tile-selection-container"><div class="tile-selection"></div></div>').insertBefore("#" + a + "> .date")
                }
            $("*").removeClass("first-day-selected last-day-selected"), $(".selected").first().addClass("first-day-selected"), $(".selected").last().addClass("last-day-selected")
        }
        if (e.pageY < ve && "left" == ue)
            if (1 != _e || $(this).hasClass("tile-previous")) $(this).hasClass("tile-previous") && $(this).trigger("mouseup");
            else {
                var a = $(this).attr("id");
                $("#" + a).removeClass("other-day-selected"), $("#" + a).addClass("selected"), $("#" + $(this).attr("id") + " > div").hasClass("tile-selection-container") || $('<div class="tile-selection-container"><div class="tile-selection"></div></div>').insertBefore("#" + $(this).attr("id") + "> .date");
                var t = $(".selected").last().index(),
                    s = $(".selected").first().index();
                $("*").removeClass("first-day-selected last-day-selected"), $(".selected").first().addClass("first-day-selected"), $(".selected").last().addClass("last-day-selected");
                for (var n = s + 1; n <= t; n++) {
                    var i = $(".days-container > .list-unstyled > li:nth-child(" + n + ")").attr("class");
                    if (0 != i.includes("tile-previous")) return !1;
                    var a = $(".days-container > .list-unstyled > li:nth-child(" + n + ")").attr("id");
                    $("#" + a).addClass("selected"), $("#" + a).removeClass("other-day-selected"), $("#" + a + " > div").hasClass("tile-selection-container") || $('<div class="tile-selection-container"><div class="tile-selection"></div></div>').insertBefore("#" + a + "> .date")
                }
            }
        if (e.pageY > ve && "left" == ue)
            if (1 != _e || $(this).hasClass("tile-previous")) $(this).hasClass("tile-previous") && $(this).trigger("mouseup");
            else if (!$(this).hasClass("selected")) {
            var a = $(this).attr("id"),
                s = $(this).index(),
                t = $(".selected").last().index();
            $(".selected").addClass("other-day-selected"), $(".selected").removeClass("selected");
            for (var n = s + 1; n <= t + 1; n++) {
                var i = $(".days-container > .list-unstyled > li:nth-child(" + n + ")").attr("class");
                if (0 != i.includes("tile-previous")) return !1;
                var a = $(".days-container > .list-unstyled > li:nth-child(" + n + ")").attr("id");
                $("#" + a).addClass("selected"), $("#" + a).removeClass("other-day-selected"), $("#" + a + " > div").hasClass("tile-selection-container") || $('<div class="tile-selection-container"><div class="tile-selection"></div></div>').insertBefore("#" + a + "> .date")
            }
            $("*").removeClass("first-day-selected last-day-selected"), $(".selected").first().addClass("first-day-selected"), $(".selected").last().addClass("last-day-selected")
        }
        me = e.pageX, ve = e.pageY
    }), $(document).on("click", '[data-behavior="modal-close"]', function() {
        $(".contact-modal").addClass("hide"), $(".contact-modal").attr("aria-hidden", "true")
    }), $("#seasonal_price,#seasonal_minimum_stay,#seasonal_week,#seasonal_month,#seasonal_weekend,#seasonal_additional_price").keypress(function(e) {
        if (8 != e.which && 0 != e.which && (e.which < 48 || e.which > 57)) return !1
    }), $(document).on("keyup", "#season_name", function() {
        if ($("#season_name").hasClass("loaded")) return !1;
        var e = $("#room_id").val(),
            t = $("#season_name").val(),
            s = $("#edit_season_name").val();
        a.post(APP_URL + "/check_season_name/" + e, {
            season_name: t,
            edit_season_name: s
        }).then(function(e) {
            "Already Name" == e.data.status ? $("#err_msg").css("display", "block") : $("#err_msg").css("display", "none")
        })
    }), $(document).on("click", "#season_name,#price,#minimum_stay", function() {
        $("#season_name").css("border", "1px solid #ccc"), $("#seasonal_price").css("border", "1px solid #ccc"), $("#seasonal_minimum_stay").css("border", "1px solid #ccc")
    }), $(document).on("click", ".delete_seasonal", function() {
        var e = $("#room_id").val(),
            t = $(this).attr("data-name"),
            s = $("#season_form_t").closest(".c-tab").find(".loading.global-ajax-form-loader");
        s.removeClass("d-none"), a.post(APP_URL + "/delete_seasonal/" + e, {
            season_name: t
        }).then(function(a) {
            s.addClass("d-none"), toastr.success("Season has been deleted successfully."), window.location = APP_URL + "/manage-listing/" + e + "/calendar"
        })
    }), $(document).on("click", ".delete_not_available", function() {
        var e = $("#room_id").val(),
            t = $(this).attr("data-name"),
            s = $("#unavailable_form_t").closest(".c-tab").find(".loading.global-ajax-form-loader");
        s.removeClass("d-none"), a.post(APP_URL + "/delete_not_available_days/" + e, {
            season_name: t
        }).then(function(a) {
            s.addClass("d-none"), toastr.success("Blocked date range has been deleted successfully."), window.location = APP_URL + "/manage-listing/" + e + "/calendar"
        })
    }), $(document).on("click", ".delete_reservation", function() {
        var e = $("#room_id").val(),
            t = $(this).attr("data-name"),
            s = $("#reservation_form_t").closest(".c-tab").find(".loading.global-ajax-form-loader");
        s.removeClass("d-none"), a.post(APP_URL + "/delete_reservation/" + e, {
            season_name: t
        }).then(function(a) {
            s.addClass("d-none"), "true" == a.data.success ? (toastr.success("Reservation has been deleted successfully."), window.location = APP_URL + "/manage-listing/" + e + "/calendar") : toastr.warning("This reseration should not be removed!")
        })
    }), $(document).on("click", ".edit_seasonal", function() {
        var t = $("#room_id").val(),
            s = $(this).attr("data-name");
        a.post(APP_URL + "/fetch_seasonal/" + t, {
            season_name: s
        }).then(function(a) {
            $("#seasonal_checkin_t").val(moment(a.data.start_date).format(daterangepicker_format)), $("#seasonal_checkout_t").val(moment(a.data.end_date).format(daterangepicker_format)), $("#formatted_seasonal_checkin_t").val(a.data.start_date), $("#formatted_seasonal_checkout_t").val(a.data.end_date), e.season_data = a.data, e.season_data.edit_seasonal_name = a.data.seasonal_name, $("#calendar_form_group").addClass("show"), setTimeout(function() {
                $("#calendar_form_group #prev").click(), setTimeout(function() {
                    $(".c-tabs-nav__link").eq(1).click()
                }, 50)
            }, 50), j(a.data)
        })
    }), $(document).on("click", ".edit_unavailable", function() {
        $("#unavailable_form_t").attr("data-mode", "edit"), $("#delete_unavailable_t").removeClass("d-none").addClass("d-block");
        var t = $("#room_id").val(),
            s = $(this).attr("data-name");
        a.post(APP_URL + "/fetch_unavailable/" + t, {
            season_name: s
        }).then(function(a) {
            $("#unvailable_checkin_t").val(moment(a.data.start_date).format(daterangepicker_format)), $("#unvailable_checkout_t").val(moment(a.data.end_date).format(daterangepicker_format)), $("#formatted_unavailable_checkin_t").val(a.data.start_date), $("#formatted_unavailable_checkout_t").val(a.data.end_date), e.unavailable_data = a.data, e.unavailable_data.edit_seasonal_name = a.data.seasonal_name, $("#calendar_form_group").addClass("show"), setTimeout(function() {
                $("#calendar_form_group #prev").click(), setTimeout(function() {
                    $(".c-tabs-nav__link").eq(2).click()
                }, 50)
            }, 50), P(a.data)
        })
    }), $(document).on("click", ".edit_reservation", function() {
        $("#reservation_form_t").attr("data-mode", "edit"), $("#delete_reservation_t").removeClass("d-none").addClass("d-block");
        var t = $("#room_id").val(),
            s = $(this).attr("data-name"),
            n = $(this).attr("data-type");
        a.post(APP_URL + "/fetch_reservation/" + t, {
            season_name: s
        }).then(function(a) {
            $("#reservation_checkin_t").val(moment(a.data.start_date).format(daterangepicker_format)), $("#reservation_checkout_t").val(moment(a.data.end_date).format(daterangepicker_format)), $("#formatted_reservation_checkin_t").val(a.data.start_date), $("#formatted_reservation_checkout_t").val(a.data.end_date), $("#reservation_type_t").val(n), e.rsv_data = a.data, e.rsv_data.edit_seasonal_name = a.data.seasonal_name, $("#calendar_form_group").addClass("show"), setTimeout(function() {
                $("#calendar_form_group #prev").click()
            }, 50), D(a.data)
        })
    }), $(document).on("click", ".day_delete", function() {
        $("body").css("overflow", "auto"), $(".manage-listing-footer").show(), $(".import_calander").show(), $(".allow_calander").hide(), $(".header--sm.show-sm").removeClass("zindex"), $("#edit_season_name").val(""), $(".selected").length > 1 && $(".tile").removeClass("selected")
    }), $(document).ready(function() {
        H(), toastr.options.closeButton = !0
    });
    var pe, he, fe;
    e.calendar_edit_submit = function(s) {
        e.calendar_edit_price = $(".get_price ").val() - 0, a.post("calendar_edit", {
            status: e.segment_status,
            start_date: $("#calendar-start").val(),
            end_date: $("#calendar-end").val(),
            price: e.calendar_edit_price,
            notes: e.notes
        }).then(function(n) {
            e.notes = "";
            var i = $("#calendar_dropdown").val(),
                o = i.split("-")[0],
                r = i.split("-")[1],
                d = {};
            d.month = r, d.year = o;
            var l = JSON.stringify(d);
            return $(".ui-datepicker-backdrop").removeClass("hide"), $(".spinner-next-to-month-nav").addClass("loading"), a.post(s.replace("manage-listing", "ajax-manage-listing"), {
                data: l
            }).then(function(a) {
                $(".ui-datepicker-backdrop").addClass("hide"), $(".spinner-next-to-month-nav").removeClass("loading"), $("#ajax_container").html(t(a.data)(e))
            }), !1
        }, function(e) {
            "300" == e.status && (window.location = APP_URL + "/login")
        })
    }, $(document).on("change", "#availability-dropdown > div > select", function() {
        var e = {};
        e.status = $(this).val();
        var t = JSON.stringify(e);
        a.post("update_rooms", {
            data: t
        }).then(function(a) {
            "Unlisted" == e.status ? ($("#availability-dropdown > i").addClass("dot-danger"), $("#availability-dropdown > i").removeClass("dot-success")) : "Listed" == e.status && ($("#availability-dropdown > i").removeClass("dot-danger"), $("#availability-dropdown > i").addClass("dot-success"))
        }, function(e) {
            "300" == e.status ? window.location = APP_URL + "/login" : "500" == e.status && window.location.reload()
        })
    }), $(document).on("click", "#export_button", function() {
        $("#export_popup").attr("aria-hidden", "false")
    }), $(document).on("click", "#import_button", function() {
        $("#import_popup").attr("aria-hidden", "false")
    }), $(".cancel_feed_btn").on("click", function() {
        $("#req_type").val("cancel"), $("#feed_import_form").submit()
    }), $("#save_feed_btn").on("click", function() {
        $("#req_type").val("save"), $("#feed_import_form").submit()
    }), $("#feed_import_form").on("submit", function() {
        return $("#import_popup .global-ajax-form-loader").css("visibility", "visible"), $("#feed_import_btn").prop("disabled", !0), $("#cancel_feed_btn").prop("disabled", !0), $("#save_feed_btn").prop("disabled", !0), !0
    }), e.booking_select = function(e) {
        var t = {};
        t.booking_type = e;
        var s = JSON.stringify(t);
        a.post("update_rooms", {
            data: s
        }).then(function(a) {
            "true" == a.data.success && ($("#before_select").addClass("hide"), $("#" + e).removeClass("hide"))
        }, function(e) {
            "300" == e.status ? window.location = APP_URL + "/login" : "500" == e.status && window.location.reload()
        })
    }, e.booking_change = function(e) {
        var t = {};
        t.booking_type = "";
        var s = JSON.stringify(t);
        a.post("update_rooms", {
            data: s
        }).then(function(a) {
            "true" == a.data.success && ($("#before_select").removeClass("hide"), $("#" + e).addClass("hide"))
        }, function(e) {
            "300" == e.status ? window.location = APP_URL + "/login" : "500" == e.status && window.location.reload()
        })
    }, e.add_price_rule = function(a) {
        "length_of_stay" == a ? (new_period = e.length_of_stay_period_select, e.length_of_stay_items.push({
            period: new_period - 0
        }), e.length_of_stay_period_select = "") : "early_bird" == a ? e.early_bird_items.push({
            period: ""
        }) : "last_min" == a && e.last_min_items.push({
            period: ""
        })
    }, e.remove_price_rule = function(t, s) {
        "length_of_stay" == t ? (item = e.length_of_stay_items[s], e.length_of_stay_items.splice(s, 1), errors = e.ls_errors) : "early_bird" == t ? (item = e.early_bird_items[s], e.early_bird_items.splice(s, 1), errors = e.eb_errors) : "last_min" == t && (item = e.last_min_items[s], e.last_min_items.splice(s, 1), errors = e.lm_errors), errors[s] = [], "" != item.id && item.id && ($("#js-" + t + "_wrapper").addClass("loading"), a.post("delete_price_rule/" + item.id, {}).then(function(e) {
            $("#js-" + t + "_wrapper").removeClass("loading")
        }))
    }, e.add_additional_charge = function() {
        e.additional_charge_items.push({
            period: ""
        })
    }, e.remove_additional_charge = function(t) {
        item = e.additional_charge_items[t], e.additional_charge_items.splice(t, 1), errors = e.lm_errors, errors[t] = [], "" != item.id && item.id && ($("#js-additional_charge_items_wrapper").addClass("loading"), a.post("delete_price_rule/" + item.id, {}).then(function(e) {
            $("#js-additional_charge_items_wrapper").removeClass("loading")
        }))
    }, e.delete_ical = function(e, t) {
        $(".new_box").show(), a.post(APP_URL + "/calendar/ical_delete/" + t + "/" + e, {}).then(function(e) {
            window.location.reload()
        })
    }, e.length_of_stay_option_avaialble = function(a) {
        var t = s("filter")(e.length_of_stay_items, {
                period: a
            }, !0),
            n = s("filter")(e.length_of_stay_items, {
                period: "" + a
            }, !0);
        return !t.length && !n.length
    }, $(document).on("change", ".ls_period, .ls_discount", function() {
        index = $(this).attr("data-index"), e.update_price_rules("length_of_stay", index)
    }), $(document).on("change", ".eb_period, .eb_discount", function() {
        index = $(this).attr("data-index"), e.update_price_rules("early_bird", index)
    }), $(document).on("change", ".lm_period, .lm_discount", function() {
        index = $(this).attr("data-index"), e.update_price_rules("last_min", index)
    }), e.update_price_rules = function(t, s) {
        if ("length_of_stay" == t ? (rules = e.length_of_stay_items, errors = e.ls_errors) : "early_bird" == t ? (rules = e.early_bird_items, errors = e.eb_errors) : "last_min" == t && (rules = e.last_min_items, errors = e.lm_errors), data = rules[s], void 0 == data.discount) return !1;
        $("#js-" + t + "-rm-btn-" + s).attr("disabled", "disabled"), $(".price_rules-" + t + "-saving h5").text(e.saving_text), $(".price_rules-" + t + "-saving").fadeIn(), a.post("update_price_rules/" + t, {
            data: data
        }).then(function(a) {
            "true" != a.data.success ? errors[s] = a.data.errors : (errors[s] = [], rules[s].id = a.data.id), $(".price_rules-" + t + "-saving h5").text(e.saved_text), $(".price_rules-" + t + "-saving").fadeOut(), $("#js-" + t + "-rm-btn-" + s).removeAttr("disabled")
        })
    }, e.remove_availability_rule = function(t) {
        item = e.availability_rules[t], type = "availability_rules", "" != item.id && item.id && ($("#" + type + "_wrapper").addClass("loading"), a.post("delete_availability_rule/" + item.id, {}).then(function(e) {
            $("#" + type + "_wrapper").removeClass("loading")
        })), e.availability_rules.splice(t, 1)
    }, e.edit_availability_rule = function(a) {
        item = e.availability_rules[a], $("#calendar-rules-custom").removeClass("hide"), $("#calendar-rules-custom").addClass("show"), e.availability_rule_item = angular.copy(item), e.availability_rule_item.type = "prev", e.availability_rule_item.start_date = e.availability_rule_item.start_date_formatted, e.availability_rule_item.end_date = e.availability_rule_item.end_date_formatted, e.$$phase || e.$apply(), e.availability_datepickers()
    }, e.availability_rules_type_change = function() {
        rule = e.availability_rule_item, "custom" != rule.type && (this_elem = $("#availability_rule_item_type option:selected"), start_date = this_elem.attr("data-start_date"), end_date = this_elem.attr("data-end_date"), e.availability_rule_item.start_date = start_date, e.availability_rule_item.end_date = end_date)
    }, e.availability_datepickers = function() {
        var a = $("#availability_rules_start_date"),
            t = $("#availability_rules_end_date");
        a.datepicker({
            minDate: 0,
            dateFormat: datepicker_format,
            onSelect: function(s, n) {
                var i = a.datepicker("getDate");
                i.setDate(i.getDate() + 1), t.datepicker("option", "minDate", i), e.availability_rule_item.start_date = a.val()
            }
        }), t.datepicker({
            minDate: 1,
            dateFormat: datepicker_format,
            onSelect: function(a, s) {
                t.datepicker("getDate");
                e.availability_rule_item.end_date = t.val()
            }
        })
    }, e.copy_data = function(e) {
        return angular.copy(e)
    }, $(document).ready(function() {
        e.availability_datepickers()
    }), $(document).on("click", "#js-calendar-settings-btn", function() {
        $("#reservation_type_t").val("Calendar"), $("#calendar_form_group").addClass("show"), setTimeout(function() {
            $("#calendar_form_group #prev").click()
        }, 50), K()
    }), $(document).on("click", "#js-close-calendar-settings-btn", function() {
        Z()
    }), $("#cancel_reservation_t").on("click", V), $("#cancel_unavailable_t").on("click", ee), $("#cancel_season_t").on("click", ae), $(document).on("click", "#js-add-availability-rule-link", function() {
        $("#calendar-rules-custom").removeClass("hide"), $("#calendar-rules-custom").addClass("show"), e.availability_rule_item = {
            type: "",
            start_date: "",
            end_date: "",
            start_date_formatted: "",
            end_date_formatted: ""
        }, e.$$phase || e.$apply(), e.availability_datepickers()
    }), $(document).on("click", "#js-close-availability-rule-btn, #js-cancel-availability-rule-btn", function() {
        $("#calendar-rules-custom").removeClass("show"), $("#calendar-rules-custom").addClass("hide")
    }), $(document).on("change", ".reservation_settings_inputs", function() {
        data = {}, $(".reservation_settings_inputs").each(function(e, a) {
            field = $(a), data[field.attr("name")] = field.val()
        }), $(".reservation_settings-saving h5").text(e.saving_text), $(".reservation_settings-saving").fadeIn(), a.post("update_reservation_settings", data).then(function(a) {
            "true" != a.data.success ? e.rs_errors = a.data.errors : e.rs_errors = [], $(".reservation_settings-saving h5").text(e.saved_text), $(".reservation_settings-saving").fadeOut()
        })
    }), e.update_availability_rule = function() {
        data = {
            availability_rule_item: e.availability_rule_item
        }, $("#availability_rule_item_wrapper, #availability_rules_wrapper").addClass("loading"), a.post("update_availability_rule", data).then(function(a) {
            "true" != a.data.success ? e.ar_errors = a.data.errors : (e.ar_errors = [], e.availability_rules = a.data.availability_rules, $("#js-close-availability-rule-btn").trigger("click"), $("#calendar-rules-custom").addClass("hide")), $("#availability_rule_item_wrapper, #availability_rules_wrapper").removeClass("loading")
        })
    }
}]), app.directive("limitTo", [function() {
    return {
        restrict: "A",
        link: function(e, a, t) {
            var s = parseInt(t.limitTo);
            angular.element(a).on("keypress", function(e) {
                var a = window.event ? e.keyCode : e.which;
                if (this.value.length == s) {
                    if (8 == e.keyCode || 46 == e.keyCode || 37 == e.keyCode || 39 == e.keyCode) return !0;
                    e.preventDefault()
                } else {
                    if (8 == e.keyCode || 46 == e.keyCode || 37 == e.keyCode || 39 == e.keyCode) return !0;
                    (a < 48 || a > 57) && e.preventDefault()
                }
            })
        }
    }
}]), $(document).on("click", "#write-description-button", function() {
    $("#write-description-button").attr("disabled", !0)
});
var pathname = document.getElementById("href_calendar").href;
$(location).attr("href") == pathname && ($(".listing-nav-sm").removeClass("collapsed"), $("body").removeClass("non_scrl")), $(".list-nav-link a").click(function() {
    $(".listing-nav-sm").removeClass("collapsed"), $("body").removeClass("non_scrl")
}), window.setInterval(function() {
    $(".listing-nav-sm").hasClass("collapsed") ? $("body").addClass("non_scrl") : $("body").removeClass("non_scrl")
}, 10), $("#href_pricing").click(function() {
    $("#js-manage-listing-nav").removeClass("manage-listing-nav"), $("#js-manage-listing-nav").addClass("pos-abs"), $("#ajax_container").addClass("mar-left-cont")
}), $("#href_terms").click(function() {
    $("#js-manage-listing-nav").removeClass("manage-listing-nav"), $("#js-manage-listing-nav").addClass("pos-abs"), $("#ajax_container").addClass("mar-left-cont")
}), $("#remove-manage").click(function() {
    $("#js-manage-listing-nav").removeClass("manage-listing-nav"), $("#js-manage-listing-nav").addClass("pos-abs"), $("#ajax_container").addClass("mar-left-cont")
}), $("#href_booking").click(function() {
    $("#js-manage-listing-nav").removeClass("manage-listing-nav"), $("#js-manage-listing-nav").addClass("pos-abs"), $("#ajax_container").addClass("mar-left-cont")
}), $("#href_basics").click(function() {
    $("#js-manage-listing-nav").removeClass("manage-listing-nav"), $("#js-manage-listing-nav").addClass("pos-abs"), $("#ajax_container").addClass("mar-left-cont")
}), $("#href_plans").click(function() {
    $("#js-manage-listing-nav").removeClass("manage-listing-nav"), $("#js-manage-listing-nav").addClass("pos-abs"), $("#ajax_container").addClass("mar-left-cont")
}), $("#href_description").click(function() {
    $("#js-manage-listing-nav").removeClass("manage-listing-nav"), $("#js-manage-listing-nav").addClass("pos-abs"), $("#ajax_container").addClass("mar-left-cont")
}), $("#href_location").click(function() {
    $("#js-manage-listing-nav").removeClass("manage-listing-nav"), $("#js-manage-listing-nav").addClass("pos-abs"), $("#ajax_container").addClass("mar-left-cont")
}), $("#href_amenities").click(function() {
    $("#js-manage-listing-nav").removeClass("manage-listing-nav"), $("#js-manage-listing-nav").addClass("pos-abs"), $("#ajax_container").addClass("mar-left-cont")
}), $("#href_details").click(function() {
    $("#js-manage-listing-nav").removeClass("manage-listing-nav"), $("#js-manage-listing-nav").addClass("pos-abs"), $("#ajax_container").addClass("mar-left-cont")
}), $("#href_guidebook").click(function() {
    $("#js-manage-listing-nav").removeClass("manage-listing-nav"), $("#js-manage-listing-nav").addClass("pos-abs"), $("#ajax_container").addClass("mar-left-cont")
}), $("#href_calendar").click(function() {
    $("#js-manage-listing-nav").removeClass("manage-listing-nav"), $("#js-manage-listing-nav").addClass("pos-abs"), $("#ajax_container").addClass("mar-left-cont")
}), $(document).on("click", ".slide-toggle", function() {
    $(".new_box").show(100)
}), $(document).on("click", ".close_imp", function() {
    $(".new_box").hide(100)
}), $(document).ready(function() {
    $("#amenitie_pet").click(function() {
        $(".pets_desc").removeClass("hide")
    })
}), $(document).ready(function() {
    $("#amenitie_pet1").click(function() {
        $(".pets_desc").addClass("hide")
    })
}), $(document).on("click", "#available_time", function() {
    "true" == $(".allow_calander").attr("enable-switching-status") && ($(".available_time").removeClass("new_save"), $("#seasonal_status").val("Available"), $("#season_name").removeClass("not-available-flag"), $(this).addClass("new_save"), $(".ses_block").show())
}), $(document).on("click", "#unavailable_time", function() {
    $(".available_time").removeClass("new_save"), $("#season_name").addClass("not-available-flag"), $(this).addClass("new_save"), $("#seasonal_status").val("Not available"), $(".ses_block").hide()
}), $(document).on("click", ".dec_close", function() {
    $(".contact-modal").addClass("hide"), $("body").removeClass("pos-fix3"), $(".selected").length > 1 && $(".tile").removeClass("selected")
}), $(document).on("click", ".view-more", function() {
    var e = $(this).closest(".additional_charge_row");
    "hiden" == $(this).attr("data-state") ? ($(this).attr("data-state", "shown"), $(this).html("- Less"), e.find(".extra-field").removeClass("d-none")) : ($(this).attr("data-state", "hiden"), $(this).html("+ More"), e.find(".extra-field").addClass("d-none"))
}), $(document).ready(function() {
    setInterval(function() {
        $(".tespri").hasClass("fixed") ? $(".allow_calander").addClass("new_allow") : $(".allow_calander").removeClass("new_allow")
    }, 1e3)
}), $(document).ready(function() {
    $("#calendar_pricing_tabs a").click(function(e) {
        e.preventDefault(), $(this).tab("show")
    }), dataTablesTabRedraw()
}), $(document).on("mouseover", ".info_detail", function() {
    $(this).siblings(".reservation-details").fadeIn()
}), $(document).on("mouseout", ".info_detail", function() {
    $(".reservation-details").fadeOut()
}), $(document).on("mouseover", ".reservation-details", function() {
    $(this).stop(!0, !0).show()
}), $(document).on("mouseout", ".reservation-details", function() {
    $(this).stop(!0, !0).fadeOut()
}), $(document).on("click", ".info_detail", function() {
    0 != window.mobilecheck() && $(this).siblings(".reservation-details").fadeIn()
}), window.mobilecheck = function() {
    var e = !1;
    return function(a) {
        (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) && (e = !0)
    }(navigator.userAgent || navigator.vendor || window.opera), e
};