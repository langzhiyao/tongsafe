$(function() {
    template.helper("isEmpty", function(t) {
        for (var a in t) {
            return false
        }
        return true
    });
    template.helper("decodeURIComponent", function(t) {
        return decodeURIComponent(t)
    });
    var t = getCookie("key");
    if (!t) {
        goLogin();return false;
        var a = decodeURIComponent(getCookie("goods_cart"));
        if (a != null) {
            var e = a.split("|")
        } else {
            e = {}
        }
        var r = new Array;
        var o = 0;
        if (e.length > 0) {
            for (var i = 0; i < e.length; i++) {
                var n = e[i].split(",");
                if (isNaN(n[0]) || isNaN(n[1]))
                    continue;
                data = getGoods(n[0], n[1]);
                if ($.isEmptyObject(data))
                    continue;
                if (r.length > 0) {
                    var c = false;
                    for (var s = 0; s < r.length; s++) {
                        if (r[s].store_id == data.store_id) {
                            r[s].goods.push(data);
                            c = true
                        }
                    }
                    if (!c) {
                        var l = {};
                        l.store_id = data.store_id;
                        l.store_name = data.store_name;
                        var a = new Array;
                        a = [data];
                        l.goods = a;
                        r = [l]
                    }
                } else {
                    var l = {};
                    l.store_id = data.store_id;
                    l.store_name = data.store_name;
                    var a = new Array;
                    a = [data];
                    l.goods = a;
                    r = [l]
                }
                o += parseFloat(data.goods_sum)
            }
        }
        var d = {cart_list: r, sum: o.toFixed(2), cart_count: e.length, check_out: false};
        d.WapSiteUrl = WapSiteUrl;
        var u = template.render("cart-list", d);
        $("#cart-list").addClass("no-login");
        if (d.cart_list.length == 0) {
            get_footer()
        }
        $("#cart-list-wp").html(u);
        $(".goto-settlement,.goto-shopping").parent().hide();
        $(".goods-del").click(function() {
            var t = $(this);
            $.sDialog({skin: "red", content: "确认删除吗？", okBtn: true, cancelBtn: true, okFn: function() {
                    var a = t.attr("cart_id");
                    for (var r = 0; r < e.length; r++) {
                        var o = e[r].split(",");
                        if (o[0] == a) {
                            e.splice(r, 1);
                            break
                        }
                    }
                    addCookie("goods_cart", e.join("|"));
                    addCookie("cart_count", e.length);
                    location.reload()
                }})
        });
        $(".minus").click(function() {
            var t = $(this).parents(".cart-litemw-cnt");
            var a = t.attr("cart_id");
            for (var r = 0; r < e.length; r++) {
                var o = e[r].split(",");
                if (o[0] == a) {
                    if (o[1] == 1) {
                        return false
                    }
                    o[1] = parseInt(o[1]) - 1;
                    e[r] = o[0] + "," + o[1];
                    t.find(".buy-num").val(o[1])
                }
            }
            addCookie("goods_cart", e.join("|"))
        });
        $(".add").click(function() {
            var t = $(this).parents(".cart-litemw-cnt");
            var a = t.attr("cart_id");
            for (var r = 0; r < e.length; r++) {
                var o = e[r].split(",");
                if (o[0] == a) {
                    o[1] = parseInt(o[1]) + 1;
                    e[r] = o[0] + "," + o[1];
                    t.find(".buy-num").val(o[1])
                }
            }
            addCookie("goods_cart", e.join("|"))
        })
    } else {
        function p() {
            $.ajax({url: ApiUrl + "/Membercart/cart_list.html", type: "post", dataType: "json", data: {key: t}, success: function(t) {
                    if (checkLogin(t.login)) {
                        if (t.code==200) {
                            if (t.result.cart_list.length == 0) {
                                addCookie("cart_count", 0)
                            }
                            var a = t.result;
                            a.WapSiteUrl = WapSiteUrl;
                            a.check_out = true;
                            template.helper("$getLocalTime", function(t) {
                                var a = new Date(parseInt(t) * 1e3);
                                var e = "";
                                e += a.getFullYear() + "年";
                                e += a.getMonth() + 1 + "月";
                                e += a.getDate() + "日 ";
                                return e
                            });
                            var e = template.render("cart-list", a);
                            if (a.cart_list.length == 0) {
                                get_footer()
                            }
                            $("#cart-list-wp").html(e);
                            $(".goods-del").click(function() {
                                var t = $(this).attr("cart_id");
                                $.sDialog({skin: "red", content: "确认删除吗？", okBtn: true, cancelBtn: true, okFn: function() {
                                        f(t)
                                    }})
                            });
                            $(".minus").click(h);
                            $(".add").click(g);
                            $(".buynum").blur(m);
                            $.animationUp();
                            $(".nctouch-voucher-list").on("click", ".btn", function() {
                                getFreeVoucher($(this).attr("data-tid"))
                            });
                            $(".store-activity").click(function() {
                                $(this).css("height", "auto")
                            })
                        } else {
                            alert(t.message)
                        }
                    }
                }})
        }
        p();
        function f(a) {
            $.ajax({url: ApiUrl + "/Membercart/cart_del.html", type: "post", data: {key: t, cart_id: a}, dataType: "json", success: function(t) {
                    if (checkLogin(t.login)) {
                        if (t.code==200) {
                            p();
                            delCookie("cart_count");
                            getCartCount()
                        } else {
                            alert(t.message)
                        }
                    }
                }})
        }
        function h() {
            var t = this;
            _(t, "minus")
        }
        function g() {
            var t = this;
            _(t, "add")
        }
        function _(a, e) {
            var r = $(a).parents(".cart-litemw-cnt");
            var o = r.attr("cart_id");
            var i = r.find(".buy-num");
            var n = r.find(".goods-price");
            var c = parseInt(i.val());
            var s = 1;
            if (e == "add") {
                s = parseInt(c + 1)
            } else {
                if (c > 1) {
                    s = parseInt(c - 1)
                } else {
                    return false
                }
            }
            $(".pre-loading").removeClass("hide");
            $.ajax({url: ApiUrl + "/Membercart/cart_edit_quantity.html", type: "post", data: {key: t, cart_id: o, quantity: s}, dataType: "json", success: function(t) {
                    if (checkLogin(t.login)) {
                        if (t.code==200) {
                            i.val(s);
                            n.html("￥<em>" + t.result.goods_price + "</em>");
                            calculateTotalPrice()
                        } else {
                            $.sDialog({skin: "red", content: t.message, okBtn: false, cancelBtn: false})
                        }
                        $(".pre-loading").addClass("hide")
                    }
                }})
        }
        $("#cart-list-wp").on("click", ".check-out > a", function() {
            if (!$(this).parent().hasClass("ok")) {
                return false
            }
            var t = [];
            $(".cart-litemw-cnt").each(function() {
                if ($(this).find('input[name="cart_id"]').prop("checked")) {
                    var a = $(this).find('input[name="cart_id"]').val();
                    var e = parseInt($(this).find(".value-box").find("input").val());
                    var r = a + "|" + e;
                    t.push(r)
                }
            });
            var a = t.toString();
            window.location.href = WapSiteUrl + "/tmpl/order/buy_step1.html?ifcart=1&cart_id=" + a
        });
        $.sValid.init({rules: {buynum: "digits"}, messages: {buynum: "请输入正确的数字"}, callback: function(t, a, e) {
                if (t.length > 0) {
                    var r = "";
                    $.map(a, function(t, a) {
                        r += "<p>" + t + "</p>"
                    });
                    $.sDialog({skin: "red", content: r, okBtn: false, cancelBtn: false})
                }
            }});
        function m() {
            $.sValid()
        }}
    $("#cart-list-wp").on("click", ".store_checkbox", function() {
        $(this).parents(".nctouch-cart-container").find('input[name="cart_id"]').prop("checked", $(this).prop("checked"));
        calculateTotalPrice()
    });
    $("#cart-list-wp").on("click", ".all_checkbox", function() {
        $("#cart-list-wp").find('input[type="checkbox"]').prop("checked", $(this).prop("checked"));
        calculateTotalPrice()
    });
    $("#cart-list-wp").on("click", 'input[name="cart_id"]', function() {
        calculateTotalPrice()
    })
});
function calculateTotalPrice() {
    var t = parseFloat("0.00");
    $(".cart-litemw-cnt").each(function() {
        if ($(this).find('input[name="cart_id"]').prop("checked")) {
            t += parseFloat($(this).find(".goods-price").find("em").html()) * parseInt($(this).find(".value-box").find("input").val())
        }
    });
    $(".total-money").find("em").html(t.toFixed(2));
    check_button();
    return true
}
function getGoods(t, a) {
    var e = {};
    $.ajax({type: "get", url: ApiUrl + "/Goods/goods_detail.html?goods_id=" + t, dataType: "json", async: false, success: function(r) {
            if (r.code==100) {
                return false
            }
            var o = r.result.goods_image.split(",");
            e.cart_id = t;
            e.store_id = r.result.store_info.store_id;
            e.store_name = r.result.store_info.store_name;
            e.goods_id = t;
            e.goods_name = r.result.goods_info.goods_name;
            e.goods_price = r.result.goods_info.goods_price;
            e.goods_num = a;
            e.goods_image_url = o[0];
            e.goods_sum = (parseInt(a) * parseFloat(r.result.goods_info.goods_price)).toFixed(2)
        }});
    return e
}
function get_footer() {
    footer = true;
    $.ajax({url: WapSiteUrl + "/js/tmpl/footer.js", dataType: "script"})
}
function check_button() {
    var t = false;
    $('input[name="cart_id"]').each(function() {
        if ($(this).prop("checked")) {
            t = true
        }
    });
    if (t) {
        $(".check-out").addClass("ok")
    } else {
        $(".check-out").removeClass("ok")
    }
}