! function(t) {
    Upfront = {
        post: function(e, a) {
            return t.post(ajaxurl, e, function() {}, a ? a : "json")
        }
    }, t(document).on("click", "#upfront_reset_cache", function(e) {
        e.preventDefault(), $this = t(this), $this.addClass("loading"), Upfront.post({
            action: "upfront_reset_cache"
        }).done(function(t) {
            $this.removeClass("loading")
        }).fail(function(t) {
            $this.removeClass("loading")
        })
    }), t(document).on("change", ".upfront-layouts-list", function(e) {
        $button = t("#upfront_reset_layout"), "0" === t(this).val() ? $button.attr("disabled", !0) : $button.attr("disabled", !1)
    }), t(document).on("click", "#upfront_reset_layout", function(e) {
        e.preventDefault();
        var a = t(this),
            o = t(".upfront-layouts-list"),
            n = o.val(),
            i = t(".upfront-layouts-list option[value='" + n + "']").html(),
            d = t(this).data("dev"),
            r = t("#upfront_reset_include_global").is(":checked") ? 1 : 0,
            c = window.confirm(Upfront_Data.l10n.sure_to_reset_layout.replace("{layout}", i));
        c === !0 && (a.addClass("loading"), Upfront.post({
            action: "upfront_reset_layout",
            layout: n,
            is_dev: d,
            include_global: r
        }).done(function(t) {
            a.removeClass("loading"), o.find("option").length >= 2 && (o.find("option[value=" + n + "]").remove(), o.val(0), a.attr("disabled", !0))
        }).fail(function(t) {
            a.removeClass("loading")
        }))
    }), t(document).on("click", "#upfront_reset_theme", function(e) {
        e.preventDefault();
        var a = t(this),
            o = window.confirm(Upfront_Data.l10n.sure_to_reset_theme);
        o === !0 && (a.addClass("loading"), Upfront.post({
            action: "upfront_reset_all_from_db"
        }).done(function(t) {
            a.removeClass("loading")
        }).fail(function(t) {
            a.removeClass("loading")
        }))
    }), t(document).on("click", "#upfront_save_under_construction", function(e) {
        e.preventDefault();
        var a = t(this),
            o = t("#upfront_under_construction").is(":checked"),
            n = o ? 1 : 0;
        a.addClass("loading"), Upfront.post({
            action: "upfront_site_under_construction",
            enable_maintenance: n
        }).done(function(t) {
            a.removeClass("loading"), window.location.reload()
        }).fail(function(t) {
            a.removeClass("loading")
        })
    }), t(document).on("change", "#upfront_under_construction", function(e) {
        var a = t(this),
            o = 1 == parseInt(a.data("current"), 10),
            n = a.is(":checked");
        o !== n ? t("#upfront_save_under_construction").removeAttr("disabled") : t("#upfront_save_under_construction").attr("disabled", "disabled")
    })
}(jQuery),
function(t, e) {
    function a(e) {
        var a = [];
        return t('[data-capability_id="' + e + '"] [data-role_id]').each(function() {
            var e = t(this);
            a.push({
                role: e.attr("data-role_id"),
                able: !!e.find(":checked").length
            })
        }), a
    }

    function o(e) {
        var a = ' [data-role_id="' + e + '"]',
            o = t('[data-capability_id="responsive_mode"]' + a).add('[data-capability_id="singlepost_layout_mode"]' + a).add('[data-capability_id="singlepage_layout_mode"]' + a).add('[data-capability_id="home_layout_mode"]' + a).add('[data-capability_id="archive_layout_mode"]' + a).add('[data-capability_id="modify_element_presets"]' + a).add('[data-capability_id="delete_element_presets"]' + a).add('[data-capability_id="switch_element_presets"]' + a);
        return o
    }

    function n() {
        var e = a("boot_upfront");
        t.each(e, function(e, a) {
            if (!(a || {}).role) return !0;
            if ((a || {}).able) return !0;
            var o = t('[data-role_id="' + a.role + '"]'),
                n = o.find(":checkbox");
            n.each(function() {
                var e = t(this);
                return !!(e.attr("name") || "").match(/\[boot_upfront\]/) || void e.attr("checked", !1).closest(".upfront_toggle").addClass("hide")
            })
        })
    }

    function i() {
        var e = a("switch_element_presets");
        t.each(e, function(e, a) {
            if (!(a || {}).role) return !0;
            if ((a || {}).able) return !0;
            var o = t('[data-capability_id="modify_element_presets"] [data-role_id="' + a.role + '"]').add('[data-capability_id="delete_element_presets"] [data-role_id="' + a.role + '"]'),
                n = o.find(":checkbox");
            n.each(function() {
                var e = t(this);
                e.attr("checked", !1).closest(".upfront_toggle").addClass("hide")
            })
        })
    }

    function d() {
        var e = a("layout_mode");
        t.each(e, function(e, a) {
            if (!(a || {}).role) return !0;
            if ((a || {}).able) return !0;
            var n = o(a.role),
                i = n.find(":checkbox");
            i.each(function() {
                t(this).attr("checked", !1).closest(".upfront_toggle").addClass("hide")
            })
        })
    }

    function r() {
        var e = a("create_post_page");
        t.each(e, function(e, a) {
            if (!(a || {}).role) return !0;
            if ((a || {}).able) return !0;
            var o = t('[data-capability_id="edit_posts"] [data-role_id="' + a.role + '"]'),
                n = o.find(":checkbox");
            n.each(function() {
                var e = t(this);
                e.attr("checked", !1).closest(".upfront_toggle").addClass("hide")
            })
        })
    }

    function c() {
        var e = a("edit_posts");
        t.each(e, function(e, a) {
            if (!(a || {}).role) return !0;
            if ((a || {}).able) return !0;
            var o = t('[data-capability_id="edit_others_posts"] [data-role_id="' + a.role + '"]'),
                n = o.find(":checkbox");
            n.each(function() {
                var e = t(this);
                e.attr("checked", !1).closest(".upfront_toggle").addClass("hide")
            })
        })
    }

    function l() {
        n(), i(), d(), r(), c()
    }

    function s(e) {
        var a = t(this),
            o = a.is(":checked"),
            n = a.closest("[data-role_id]").attr("data-role_id"),
            i = t('[data-capability_id] [data-role_id="' + n + '"] .upfront_toggle');
        i.each(function() {
            var e = t(this);
            return !!e.find('[name*="boot_upfront"]').length || void(o ? e.removeClass("hide") : e.addClass("hide"))
        }), l()
    }

    function u(e) {
        var a = t(this),
            o = a.closest("[data-role_id]").attr("data-role_id"),
            n = t('[data-capability_id="modify_element_presets"] [data-role_id="' + o + '"]').add('[data-capability_id="delete_element_presets"] [data-role_id="' + o + '"]');
        n.find(":checkbox").attr("checked", !1), a.is(":checked") ? n.find(".upfront_toggle").removeClass("hide") : n.find(".upfront_toggle").addClass("hide")
    }

    function _() {
        var e = t(this),
            a = e.closest("[data-role_id]").attr("data-role_id"),
            n = o(a);
        n.find(":checkbox").attr("checked", !1), e.is(":checked") ? n.find(".upfront_toggle").removeClass("hide") : n.find(".upfront_toggle").addClass("hide"), l()
    }

    function f() {
        var e = t(this),
            a = e.closest("[data-role_id]").attr("data-role_id"),
            o = t('[data-capability_id="edit_posts"] [data-role_id="' + a + '"]');
        o.find(":checkbox").attr("checked", !1), e.is(":checked") ? o.find(".upfront_toggle").removeClass("hide") : o.find(".upfront_toggle").addClass("hide"), l()
    }

    function p() {
        var e = t(this),
            a = e.closest("[data-role_id]").attr("data-role_id"),
            o = t('[data-capability_id="edit_others_posts"] [data-role_id="' + a + '"]');
        o.find(":checkbox").attr("checked", !1), e.is(":checked") ? o.find(".upfront_toggle").removeClass("hide") : o.find(".upfront_toggle").addClass("hide")
    }

    function h() {
        t(document).on("change", '[data-capability_id="boot_upfront"] :checkbox', s), t(document).on("change", '[data-capability_id="switch_element_presets"] :checkbox', u), t(document).on("change", '[data-capability_id="layout_mode"] :checkbox', _), t(document).on("change", '[data-capability_id="create_post_page"] :checkbox', f), t(document).on("change", '[data-capability_id="edit_posts"] :checkbox', p)
    }

    function g() {
        return !!t("body").is(".wp-admin") && (!!t("#upfront_user_restrictions_listing").length && (l(), void h()))
    }
    t(g)
}(jQuery),
function(t) {
    function e() {
        return !!t("body").is(".wp-admin") && (!!t(".inside.changelog").length && (t('.changelog .navigation a[href="#more"]').on("click", function(e) {
            return e && e.preventDefault && e.preventDefault(), e && e.stopPropagation && e.stopPropagation(), t(".changelog .previous").toggle(), !1
        }), void t('.changelog a[href="#toggle"]').on("click", function(e) {
            e && e.preventDefault && e.preventDefault(), e && e.stopPropagation && e.stopPropagation();
            var a, o = t(this),
                n = o.parent().next("ul.extra");
            return !!n.length && (n.is(":visible") ? (a = o.attr("data-contracted"), n.hide()) : (a = o.attr("data-expanded"), n.show()), o.text(a), !1)
        })))
    }
    t(e)
}(jQuery);