// setCookie('key','7f0120cf2b6e5626e24df64cddc163f9')
function getQueryString(e) {
    var t = new RegExp("(^|&)" + e + "=([^&]*)(&|$)");
    var a = window.location.search.substr(1).match(t);
    if (a != null) return a[2];
    return ""
}
function addCookie(e, t, a) {
    var n = e + "=" + escape(t) + "; path=/";
    if (a > 0) {
        var r = new Date;
        r.setTime(r.getTime() + a * 3600 * 1e3);
        n = n + ";expires=" + r.toGMTString()
    }
    document.cookie = n
}
function setCookie(name, value, days) {
    var exp = new Date();
    exp.setTime(exp.getTime() + days * 24 * 60 * 60 * 1000);
    var arr = document.cookie.match(new RegExp("(^| )" + name + "=([^;]*)(;|$)"));
    document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString();
}
function getCookie(e) {
    var t = document.cookie;
    var a = t.split("; ");
    for (var n = 0; n < a.length; n++) {
        var r = a[n].split("=");
        if (r[0] == e) return unescape(r[1])
    }
    return null
}
function delCookie(e) {
    var t = new Date;
    t.setTime(t.getTime() - 1);
    var a = getCookie(e);
    if (a != null) document.cookie = e + "=" + a + "; path=/;expires=" + t.toGMTString()
}
function checkLogin(e) {
    if (e == 0) {
        // location.href = WapSiteUrl + "/tmpl/member/index.html";
        goLogin();
        return false
    } else {
        return true
    }
}
function contains(e, t) {
    var a = e.length;
    while (a--) {
        if (e[a] === t) {
            return true
        }
    }
    return false
}
function buildUrl(e, t) {
    switch (e) {
    case "keyword":
        return WapSiteUrl + "/tmpl/product_list.html?keyword=" + encodeURIComponent(t);
    case "special":
        return WapSiteUrl + "/special.html?special_id=" + t;
    case "goods":
        return WapSiteUrl + "/tmpl/product_detail.html?goods_id=" + t;
    case "url":
        return t
    }
    return WapSiteUrl
}
function errorTipsShow(e) {
    $(".error-tips").html(e).show();
    setTimeout(function() {
        errorTipsHide()
    },
    3e3)
}
function errorTipsHide() {
    $(".error-tips").html("").hide()
}
function writeClear(e) {
    if (e.val().length > 0) {
        e.parent().addClass("write")
    } else {
        e.parent().removeClass("write")
    }
    btnCheck(e.parents("form"))
}
function btnCheck(e) {
    var t = true;
    e.find("input").each(function() {
        if ($(this).hasClass("no-follow")) {
            return
        }
        if ($(this).val().length == 0) {
            t = false
        }
    });
    if (t) {
        e.find(".btn").parent().addClass("ok")
    } else {
        e.find(".btn").parent().removeClass("ok")
    }
}
function getSearchName() {
    var e = decodeURIComponent(getQueryString("keyword"));
    if (e == "") {
        if (getCookie("deft_key_value") == null) {
            $.getJSON(ApiUrl + "/Index/search_hot_info.html",
            function(e) {
                var t = e.result.hot_info;
                if (typeof t.name != "undefined") {
                    $("#keyword").attr("placeholder", t.name);
                    $("#keyword").html(t.name);
                    addCookie("deft_key_name", t.name, 1);
                    addCookie("deft_key_value", t.value, 1)
                } else {
                    addCookie("deft_key_name", "", 1);
                    addCookie("deft_key_value", "", 1)
                }
            })
        } else {
            $("#keyword").attr("placeholder", getCookie("deft_key_name"));
            $("#keyword").html(getCookie("deft_key_name"))
        }
    }
}
function getFreeVoucher(e) {
    var t = getCookie("key");
    if (!t) {
        checkLogin(0);
        return
    }
    $.ajax({
        type: "post",
        url: ApiUrl + "/Membervoucher/voucher_point.html",
        data: {
            tid: e,
            key: t
        },
        dataType: "json",
        success: function(e) {
            checkLogin(e.login);
            var t = "领取成功";
            var a = "green";
            if (e.code=='100') {
                t = "领取失败：" + e.message;
                a = "red"
            }
            $.sDialog({
                skin: a,
                content: t,
                okBtn: false,
                cancelBtn: false
            })
        }
    })
}
function updateCookieCart(e) {
    var t = decodeURIComponent(getCookie("goods_cart"));
    if (t) {
        $.ajax({
            type: "post",
            url: ApiUrl + "/Membercart/cart_batchadd.html",
            data: {
                key: e,
                cartlist: t
            },
            dataType: "json",
            async: false
        });
        delCookie("goods_cart")
    }
}
function getCartCount(e, t) {
    var a = 0;
	delCookie("cart_count")
    if (getCookie("key") !== null && getCookie("cart_count") === null) {
        var e = getCookie("key");
        $.ajax({
            type: "post",
            url: ApiUrl + "/Membercart/cart_count.html",
            data: {
                key: e
            },
            dataType: "json",
            async: false,
            success: function(e) {
                if (typeof e.result.cart_count != "undefined") {
                    addCookie("cart_count", e.result.cart_count, t);
                    a = e.result.cart_count
                }
            }
        })
    } else {
        a = getCookie("cart_count")
    }
    if (a > 0 && $(".nctouch-nav-menu").has(".cart").length > 0) {
        $(".nctouch-nav-menu").has(".cart").find(".cart").parents("li").find("sup").show();
        $("#header-nav").find("sup").show()
    }
}
function getChatCount() {
    if ($("#header").find(".message").length > 0) {
        var e = getCookie("key");
        if (e !== null) {
            $.getJSON(ApiUrl + "/Memberchat/get_msg_count.html", {
                key: e
            },
            function(e) {
                if (e.code == '200') {
                    $("#header").find(".message").parent().find("sup").show();
                    $("#header-nav").find("sup").show()
                }
            })
        }
        $("#header").find(".message").parent().click(function() {
            window.location.href = WapSiteUrl + "/tmpl/member/chat_list.html"
        })
    }
}
$(function() {
    $(".input-del").click(function() {
        $(this).parent().removeClass("write").find("input").val("");
        btnCheck($(this).parents("form"))
    });
    $("body").on("click", "label",
    function() {
        if ($(this).has('input[type="radio"]').length > 0) {
            $(this).addClass("checked").siblings().removeAttr("class").find('input[type="radio"]').removeAttr("checked")
        } else if ($(this).has('[type="checkbox"]')) {
            if ($(this).find('input[type="checkbox"]').prop("checked")) {
                $(this).addClass("checked")
            } else {
                $(this).removeClass("checked")
            }
        }
    });
    if ($("body").hasClass("scroller-body")) {
        new IScroll(".scroller-body", {
            mouseWheel: true,
            click: true
        })
    }
    $("#header").on("click", "#header-nav",
    function() {
        if ($(".nctouch-nav-layout").hasClass("show")) {
            $(".nctouch-nav-layout").removeClass("show")
        } else {
            $(".nctouch-nav-layout").addClass("show")
        }
    });
    $("#header").on("click", ".nctouch-nav-layout",
    function() {
        $(".nctouch-nav-layout").removeClass("show")
    });
    $(document).scroll(function() {
        $(".nctouch-nav-layout").removeClass("show")
    });
    //getSearchName();
    getCartCount();
    getChatCount();
    $(document).scroll(function() {
        e()
    });
    $(".fix-block-r,footer").on("click", ".gotop",
    function() {
        btn = $(this)[0];
        this.timer = setInterval(function() {
            $(window).scrollTop(Math.floor($(window).scrollTop() * .8));
            if ($(window).scrollTop() == 0) clearInterval(btn.timer, e)
        },
        10)
    });
    function e() {
        $(window).scrollTop() == 0 ? $("#goTopBtn").addClass("hide") : $("#goTopBtn").removeClass("hide")
    }
}); (function($) {
    $.extend($, {
        scrollTransparent: function(e) {
            var t = {
                valve: "#header",
                scrollHeight: 50
            };
            var e = $.extend({},
            t, e);
            function a() {
                $(window).scroll(function() {
                    if ($(window).scrollTop() <= e.scrollHeight) {
                        $(e.valve).addClass("transparent").removeClass("posf")
                    } else {
                        $(e.valve).addClass("posf").removeClass("transparent")
                    }
                })
            }
            return this.each(function() {
                a()
            })()
        },
        areaSelected: function(options) {
            var defaults = {
                success: function(e) {}
            };
            var options = $.extend({},
            defaults, options);
            var ASID = 0;
            var ASID_1 = 0;
            var ASID_2 = 0;
            var ASID_3 = 0;
            var ASNAME = "";
            var ASINFO = "";
            var ASDEEP = 1;
            var ASINIT = true;
            function _init() {
                if ($("#areaSelected").length > 0) {
                    $("#areaSelected").remove()
                }
                var e = '<div id="areaSelected">' + '<div class="nctouch-full-mask left">' + '<div class="nctouch-full-mask-bg"></div>' + '<div class="nctouch-full-mask-block">' + '<div class="header">' + '<div class="header-wrap">' + '<div class="header-l"><a href="javascript:void(0);"><i class="back"></i></a></div>' + '<div class="header-title">' + "<h1>选择地区</h1>" + "</div>" + '<div class="header-r"><a href="javascript:void(0);"><i class="close"></i></a></div>' + "</div>" + "</div>" + '<div class="nctouch-main-layout">' + '<div class="nctouch-single-nav">' + '<ul id="filtrate_ul" class="area">' + '<li class="selected"><a href="javascript:void(0);">一级地区</a></li>' + '<li><a href="javascript:void(0);" >二级地区</a></li>' + '<li><a href="javascript:void(0);" >三级地区</a></li>' + "</ul>" + "</div>" + '<div class="nctouch-main-layout-a"><ul class="nctouch-default-list"></ul></div>' + "</div>" + "</div>" + "</div>" + "</div>";
                $("body").append(e);
                _getAreaList();
                _bindEvent();
                _close()
            }
            function _getAreaList() {
                $.ajax({
                    type: "get",
                    url: ApiUrl + "/Area/area_list.html",
                    data: {
                        area_id: ASID
                    },
                    dataType: "json",
                    async: false,
                    success: function(e) {
                        if (e.result.area_list.length == 0) {
                            _finish();
                            return false
                        }
                        if (ASINIT) {
                            ASINIT = false
                        } else {
                            ASDEEP++
                        }
                        $("#areaSelected").find("#filtrate_ul").find("li").eq(ASDEEP - 1).addClass("selected").siblings().removeClass("selected");
                        checkLogin(e.login);
                        var t = e.result;
                        var a = "";
                        for (var n = 0; n < t.area_list.length; n++) {
                            a += '<li><a href="javascript:void(0);" data-id="' + t.area_list[n].area_id + '" data-name="' + t.area_list[n].area_name + '"><h4>' + t.area_list[n].area_name + '</h4><span class="arrow-r"></span> </a></li>'
                        }
                        $("#areaSelected").find(".nctouch-default-list").html(a);
                        if (typeof myScrollArea == "undefined") {
                            if (typeof IScroll == "undefined") {
                                $.ajax({
                                    url: WapSiteUrl + "/js/iscroll.js",
                                    dataType: "script",
                                    async: false
                                })
                            }
                            myScrollArea = new IScroll("#areaSelected .nctouch-main-layout-a", {
                                mouseWheel: true,
                                click: true
                            })
                        } else {
                            myScrollArea.refresh()
                        }
                    }
                });
                return false
            }
            function _bindEvent() {
                $("#areaSelected").find(".nctouch-default-list").off("click", "li > a");
                $("#areaSelected").find(".nctouch-default-list").on("click", "li > a",
                function() {
                    ASID = $(this).attr("data-id");
                    eval("ASID_" + ASDEEP + "=$(this).attr('data-id')");
                    ASNAME = $(this).attr("data-name");
                    ASINFO += ASNAME + " ";
                    var _li = $("#areaSelected").find("#filtrate_ul").find("li").eq(ASDEEP);
                    _li.prev().find("a").attr({
                        "data-id": ASID,
                        "data-name": ASNAME
                    }).html(ASNAME);
                    if (ASDEEP == 3) {
                        _finish();
                        return false
                    }
                    _getAreaList()
                });
                $("#areaSelected").find("#filtrate_ul").off("click", "li > a");
                $("#areaSelected").find("#filtrate_ul").on("click", "li > a",
                function() {
                    if ($(this).parent().index() >= $("#areaSelected").find("#filtrate_ul").find(".selected").index()) {
                        return false
                    }
                    ASID = $(this).parent().prev().find("a").attr("data-id");
                    ASNAME = $(this).parent().prev().find("a").attr("data-name");
                    ASDEEP = $(this).parent().index();
                    ASINFO = "";
                    for (var e = 0; e < $("#areaSelected").find("#filtrate_ul").find("a").length; e++) {
                        if (e < ASDEEP) {
                            ASINFO += $("#areaSelected").find("#filtrate_ul").find("a").eq(e).attr("data-name") + " "
                        } else {
                            var t = "";
                            switch (e) {
                            case 0:
                                t = "一级地区";
                                break;
                            case 1:
                                t = "二级地区";
                                break;
                            case 2:
                                t = "三级地区";
                                break
                            }
                            $("#areaSelected").find("#filtrate_ul").find("a").eq(e).html(t)
                        }
                    }
                    _getAreaList()
                })
            }
            function _finish() {
                var e = {
                    area_id: ASID,
                    area_id_1: ASID_1,
                    area_id_2: ASID_2,
                    area_id_3: ASID_3,
                    area_name: ASNAME,
                    area_info: ASINFO
                };
                options.success.call("success", e);
                if (!ASINIT) {
                    $("#areaSelected").find(".nctouch-full-mask").addClass("right").removeClass("left")
                }
                return false
            }
            function _close() {
                $("#areaSelected").find(".header-l").off("click", "a");
                $("#areaSelected").find(".header-l").on("click", "a",
                function() {
                    $("#areaSelected").find(".nctouch-full-mask").addClass("right").removeClass("left")
                });
                return false
            }
            return this.each(function() {
                return _init()
            })()
        },
        addressSelected: function(options) {
            var defaults = {
                success: function(e) {}
            };
            var options = $.extend({},
            defaults, options);
            var MAP='';
            var LOCAL='';
            var ADDRESS = "";
            var LNG = "";
            var LAT = '';
            function _init() {
                if ($("#addressSelected").length > 0) {
                    $("#addressSelected").remove()
                }
                var e = '<div id="addressSelected">' + '<div class="nctouch-full-mask left">' + '<div class="nctouch-full-mask-bg"></div>' + '<div class="nctouch-full-mask-block">' + '<div class="header">' + '<div class="header-wrap">' + '<div class="header-l"><a href="javascript:void(0);"><i class="back"></i></a></div>' + '<div class="header-title">' + "<h1>选择地址</h1>" + "</div>" + '<div class="header-r"><a href="javascript:void(0);"><i class="close"></i></a></div>' + "</div>" + "</div>"+ '<div class="map_content">' + '<div class="location_name"><input type="text" id="map_keywords" placeholder="小区、写字楼、学校"><span class="icon_search"></span></div>' + '<div id="allmap">' + "</div>" +'<div id="r-result"></div>'+ "</div>" + "</div>" + "</div>" + "</div>";
                $("body").append(e);
                _getMap();
                _bindEvent();
                _close()
            }
            function _getMap() {
                MAP = new BMap.Map("allmap");
                var lng = getCookie("longitude");
                var lat = getCookie("latitude");
             
                if (!lng && !lat) {
                var geolocation = new BMap.Geolocation();
                geolocation.getCurrentPosition(function (r) {
                    if (this.getStatus() == BMAP_STATUS_SUCCESS) {
                        var lng = r.point.lng;
                        var lat = r.point.lat;
                        var point = new BMap.Point(lng, lat);
                        MAP.centerAndZoom(point, 16);
                        MAP.addControl(new BMap.NavigationControl());
                        MAP.enableScrollWheelZoom();    
                        var marker = new BMap.Marker(point);  // 创建标注
                        MAP.addOverlay(marker);              // 将标注添加到地图中
                        marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
//                        LNG = lng;
//                        LAT = lat;

                    } else {
                        alert('failed' + this.getStatus());
                    }
                }, {enableHighAccuracy: true});
                }else{
                	var point = new BMap.Point(lng, lat);
                	MAP.centerAndZoom(point, 16);
                    MAP.addControl(new BMap.NavigationControl());
                    MAP.enableScrollWheelZoom();    
                    var marker = new BMap.Marker(point);  // 创建标注
                    MAP.addOverlay(marker);              // 将标注添加到地图中
                    marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
                }
                MAP.addEventListener("click", function(e){
//                    alert(e.point.lng + ", " + e.point.lat);
                    MAP.clearOverlays();  //清除标注  或者可以把market 放入数组
                    var point = new BMap.Point(e.point.lng , e.point.lat);
                    var marker = new BMap.Marker(point);
                    MAP.addOverlay(marker);
                    marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
//                    
//                    LNG = e.point.lng;
//                    LAT = e.point.lat;
                });
                var options = {
                        onSearchComplete: function(results){
                                // 判断状态是否正确
                                if (LOCAL.getStatus() == BMAP_STATUS_SUCCESS){
                                        var s = [];
                                        for (var i = 0; i < results.getCurrentNumPois(); i ++){
                                                s.push('<p class="address_list_wrap" data-lng="'+results.getPoi(i).point.lng+'" data-lat="'+results.getPoi(i).point.lat+'" data-address="'+results.getPoi(i).address+'"><span class="address_mt">'+results.getPoi(i).title + "</span><br><span class='address_mc'> " + results.getPoi(i).address+'</span></p>');
                                        }
                                        if(results.getCurrentNumPois()>0){

                                            MAP.clearOverlays();  //清除标注  或者可以把market 放入数组
                                            var point = new BMap.Point(results.getPoi(0).point.lng , results.getPoi(0).point.lat);
                                            var marker = new BMap.Marker(point);
                                            MAP.centerAndZoom(point, 16);
                                            MAP.addOverlay(marker);
                                            marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画

//                                            LNG = results.getPoi(0).point.lng;
//                                            LAT = results.getPoi(0).point.lat;
                                            document.getElementById("r-result").innerHTML = s.join("");

                                        }
                                        
                                }
                        }
                };
                LOCAL = new BMap.LocalSearch(MAP, options);
                return false
            }
            function _bindEvent() {
                $("#addressSelected").find(".location_name").off("keyup", "#map_keywords");
                $("#addressSelected").find(".location_name").on("keyup", "#map_keywords",
                function() {
                    LOCAL.search($('#map_keywords').val());
                });
                $("#addressSelected").find("#r-result").off("click", ".address_list_wrap");
                $("#addressSelected").find("#r-result").on("click", ".address_list_wrap",
                function() {
                    var e = {
                        address: $(this).attr('data-address'),
                        lng: $(this).attr('data-lng'),
                        lat: $(this).attr('data-lat')
                    };
                    options.success.call("success", e);
                    $("#addressSelected").find(".nctouch-full-mask").addClass("right").removeClass("left")
                    return false
                });
            }
            function _close() {
                $("#addressSelected").find(".header-l").off("click", "a");
                $("#addressSelected").find(".header-l").on("click", "a",
                function() {
                    $("#addressSelected").find(".nctouch-full-mask").addClass("right").removeClass("left")
                });
                return false
            }
            return this.each(function() {
                return _init()
            })()
        },
        animationLeft: function(e) {
            var t = {
                valve: ".animation-left",
                wrapper: ".nctouch-full-mask",
                scroll: ""
            };
            var e = $.extend({},
            t, e);
            function a() {
                $(e.valve).click(function() {
                    $(e.wrapper).removeClass("hide").removeClass("right").addClass("left");
                    if (e.scroll != "") {
                        if (typeof myScrollAnimationLeft == "undefined") {
                            if (typeof IScroll == "undefined") {
                                $.ajax({
                                    url: WapSiteUrl + "/js/iscroll.js",
                                    dataType: "script",
                                    async: false
                                })
                            }
                            myScrollAnimationLeft = new IScroll(e.scroll, {
                                mouseWheel: true,
                                click: true
                            })
                        } else {
                            myScrollAnimationLeft.refresh()
                        }
                    }
                });
                $(e.wrapper).on("click", ".header-l > a",
                function() {
                    $(e.wrapper).addClass("right").removeClass("left")
                })
            }
            return this.each(function() {
                a()
            })()
        },
        animationUp: function(e) {
            var t = {
                valve: ".animation-up",
                wrapper: ".nctouch-bottom-mask",
                scroll: ".nctouch-bottom-mask-rolling",
                start: function() {},
                close: function() {}
            };
            var e = $.extend({},
            t, e);
            function a() {
                e.start.call("start");
                $(e.wrapper).removeClass("down").addClass("up");
                if (e.scroll != "") {
                    if (typeof myScrollAnimationUp == "undefined") {
                        if (typeof IScroll == "undefined") {
                            $.ajax({
                                url: WapSiteUrl + "/js/iscroll.js",
                                dataType: "script",
                                async: false
                            })
                        }
                        myScrollAnimationUp = new IScroll(e.scroll, {
                            mouseWheel: true,
                            click: true
                        })
                    } else {
                        myScrollAnimationUp.refresh()
                    }
                }
            }
            return this.each(function() {
                if (e.valve != "") {
                    $(e.valve).on("click",
                    function() {
                        a()
                    })
                } else {
                    a()
                }
                $(e.wrapper).on("click", ".nctouch-bottom-mask-bg,.nctouch-bottom-mask-close",
                function() {
                    $(e.wrapper).addClass("down").removeClass("up");
                    e.close.call("close")
                })
            })()
        }
    })
})(Zepto);
$.fn.ajaxUploadImage = function(e) {
    var t = {
        url: "",
        data: {},
        start: function() {},
        success: function() {}
    };
    var e = $.extend({},
    t, e);
    var a;
    function n() {
        if (a === null || a === undefined) {
            alert("请选择您要上传的文件！");
            return false
        }
        return true
    }
    return this.each(function() {
        $(this).on("change",
        function() {
            var t = $(this);
            e.start.call("start", t);
            a = t.prop("files")[0];
            if (!n) return false;
            try {
                var r = new XMLHttpRequest;
                r.open("post", e.url, true);
                r.setRequestHeader("X-Requested-With", "XMLHttpRequest");
                r.onreadystatechange = function() {
                    if (r.readyState == 4) {
                        returnDate = $.parseJSON(r.responseText);
                        e.success.call("success", t, returnDate)
                    }
                };
                var i = new FormData;
                for (k in e.data) {
                    i.append(k, e.data[k])
                }
                i.append(t.attr("name"), a);
                result = r.send(i)
            } catch(o) {
                console.log(o);
                alert(o)
            }
        })
    })
};
function loadSeccode() {
    $("#codeimage").attr("src", ApiUrl + "/Seccode/makecode.html")
}
function favoriteStore(e) {
    var t = getCookie("key");
    if (!t) {
        checkLogin(0);
        return
    }
    if (e <= 0) {
        $.sDialog({
            skin: "green",
            content: "参数错误",
            okBtn: false,
            cancelBtn: false
        });
        return false
    }
    var a = false;
    $.ajax({
        type: "post",
        url: ApiUrl + "/Memberfavoritesstore/favorites_add.html",
        data: {
            key: t,
            store_id: e
        },
        dataType: "json",
        async: false,
        success: function(e) {
            if (e.code==200) {
                a = true
            } else {
                $.sDialog({
                    skin: "red",
                    content: e.message,
                    okBtn: false,
                    cancelBtn: false
                })
            }
        }
    });
    return a
}
function dropFavoriteStore(e) {
    var t = getCookie("key");
    if (!t) {
        checkLogin(0);
        return
    }
    if (e <= 0) {
        $.sDialog({
            skin: "green",
            content: "参数错误",
            okBtn: false,
            cancelBtn: false
        });
        return false
    }
    var a = false;
    $.ajax({
        type: "post",
        url: ApiUrl + "/Memberfavoritesstore/favorites_del.html",
        data: {
            key: t,
            store_id: e
        },
        dataType: "json",
        async: false,
        success: function(e) {
            if (e.code=200) {
                a = true
            } else {
                $.sDialog({
                    skin: "red",
                    content: e.message,
                    okBtn: false,
                    cancelBtn: false
                })
            }
        }
    });
    return a
}
function favoriteGoods(e) {
    var t = getCookie("key");
    if (!t) {
        checkLogin(0);
        return
    }
    if (e <= 0) {
        $.sDialog({
            skin: "green",
            content: "参数错误",
            okBtn: false,
            cancelBtn: false
        });
        return false
    }
    var a = false;
    $.ajax({
        type: "post",
        url: ApiUrl + "/Memberfavorites/favorites_add.html",
        data: {
            key: t,
            goods_id: e
        },
        dataType: "json",
        async: false,
        success: function(e) {
            if (e.code == 200) {
                a = true
            } else {
                $.sDialog({
                    skin: "red",
                    content: e.message,
                    okBtn: false,
                    cancelBtn: false
                })
            }
        }
    });
    return a
}
function dropFavoriteGoods(e) {
    var t = getCookie("key");
    if (!t) {
        checkLogin(0);
        return
    }
    if (e <= 0) {
        $.sDialog({
            skin: "green",
            content: "参数错误",
            okBtn: false,
            cancelBtn: false
        });
        return false
    }
    var a = false;
    $.ajax({
        type: "post",
        url: ApiUrl + "/Memberfavorites/favorites_del.html",
        data: {
            key: t,
            fav_id: e
        },
        dataType: "json",
        async: false,
        success: function(e) {
            if (e.code == 200) {
                a = true
            } else {
                $.sDialog({
                    skin: "red",
                    content: e.message,
                    okBtn: false,
                    cancelBtn: false
                })
            }
        }
    });
    return a
}
function loadCss(e) {
    var t = document.createElement("link");
    t.setAttribute("type", "text/css");
    t.setAttribute("href", e);
    t.setAttribute("href", e);
    t.setAttribute("rel", "stylesheet");
    css_id = document.getElementById("auto_css_id");
    if (css_id) {
        document.getElementsByTagName("head")[0].removeChild(css_id)
    }
    document.getElementsByTagName("head")[0].appendChild(t)
}
function loadJs(e) {
    var t = document.createElement("script");
    t.setAttribute("type", "text/javascript");
    t.setAttribute("src", e);
    t.setAttribute("id", "auto_script_id");
    script_id = document.getElementById("auto_script_id");
    if (script_id) {
        document.getElementsByTagName("head")[0].removeChild(script_id)
    }
    document.getElementsByTagName("head")[0].appendChild(t)
}


//返回函数
function historyback() {
    if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)) { //判断iPhone|iPad|iPod|iOS
        // window.webkit.messageHandlers.backClick();
        // window.webkit.messageHandlers.backClick.postMessage();
        window.webkit.messageHandlers.backClick.postMessage('back!!');
    } else if (/(Android)/i.test(navigator.userAgent)) { //判断Android
        Android.backToApp();
    } else { //pc
        window.history.back(-1);
    };
}

function layout(){
    if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)) { //判断iPhone|iPad|iPod|iOS
        window.webkit.messageHandlers.outClick.postMessage('back!!');
    } else if (/(Android)/i.test(navigator.userAgent)) { //判断Android
        Android.outClick();
    } else { //pc
    };
}

function goLogin(){
    if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)) { //判断iPhone|iPad|iPod|iOS
        window.webkit.messageHandlers.loginClick.postMessage('back!!');
    } else if (/(Android)/i.test(navigator.userAgent)) { //判断Android
        Android.loginClick();
    } else { //pc
    };
}

function common_url($name){
    var e = getCookie('key');
    if(!e || e == 'null'){
        goLogin();return false;
    }else{
        if($name == 'search'){
            window.location.href='search.html';
        }else if($name == 'cart'){
            window.location.href='cart_list.html?ago=1';
        }else if($name == 'favorite'){
            window.location.href='member/favorites.html?ago=1';
        }else if($name == 'order'){
            window.location.href='member/order_list.html?ago=1';
        }else if($name == 'address'){
            window.location.href='member/address_list.html?ago=1';
        }
    }

}

function member_url($name){
    var e = getCookie('key');
    if(!e || e == 'null'){
        goLogin();return false;
    }else{
        if($name == 'search'){
            window.location.href='../search.html';
        }else if($name == 'cart'){
            window.location.href='../cart_list.html?ago=1';
        }else if($name == 'favorite'){
            window.location.href='../member/favorites.html?ago=1';
        }else if($name == 'order'){
            window.location.href='../member/order_list.html?ago=1';
        }else if($name == 'address'){
            window.location.href='../member/address_list.html?ago=1';
        }
    }

}

function ago_back(){
     ago = GetQueryString('ago');
    if(ago==null){
        historyback();
    }else{
        window.history.back(-1);
    }

}
function GetQueryString(name)
{
    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if(r!=null)return  unescape(r[2]); return null;
}

function payTo(){
    location.href=WapSiteUrl+'/tmpl/member/order_list.html?ago=1';
}