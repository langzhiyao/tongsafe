/* 多级选择相关函数，如地区选择，分类选择
 * multi-level selection
 */

/* 地区选择函数 */
function regionInit(divId) {
    var area_id = 0;
    getArea(function(){
        
    $("#" + divId + " > select").change(regionChange); // select的onchange事件
    $("#" + divId + " > input:button[class='edit_region']").click(regionEdit); // 编辑按钮的onclick事件
    });
}
function areaInit(area_select,area_id){//初始化地区
    getArea(function(){
        if(typeof(area_select) == 'object' && nc_a[area_id].length > 0){
            var areas = new Array();
            areas = nc_a[area_id];
            $(area_select).append("<option>-请选择-</option>");
            for (i = 0; i <areas.length; i++){
                $(area_select).append("<option value='" + areas[i][0] + "'>" + areas[i][1] + "</option>");
            }
        }
    });
}
if(typeof(regionChange) != 'function'){//检测是否已经被定义过，防止重写
    function regionChange(){
        // 删除后面的select
        $(this).nextAll("select").remove();
        // 计算当前选中到id和拼起来的name
        var selects = $(this).siblings("select").andSelf();
        var id = '';
        var names = new Array();
        for (i = 0; i < selects.length; i++){
            sel = selects[i];
            if (sel.value > 0){
                id = sel.value;
                name = sel.options[sel.selectedIndex].text;
                names.push(name);
            }
        }
        $(".area_ids").val(id);
        $(".area_name").val(name);
        $(".area_names").val(names.join("\t"));

        if (this.value > 0){//下级地区
            var area_id = this.value;
            if(typeof(nc_a[area_id]) == 'object' && nc_a[area_id].length > 0){//数组存在
                $("<select></select>").change(regionChange).insertAfter(this);
                areaInit($(this).next("select"),area_id);//初始化地区
            }
        }
    }
}
function getArea(callback){
    if(typeof(nc_a) == 'undefined'){//加载地区数据
        var area_scripts_src = '';
        area_scripts_src = $("script[src*='common.js']").attr("src");//取JS目录的地址
        area_scripts_src = area_scripts_src.replace('common.js', 'area_array.js');
        $.getScript(area_scripts_src,function(){
            callback();
            return true;
        });
    } else {
        callback();
    }
}
function regionChange() {
    // 删除后面的select
    $(this).nextAll("select").remove();
    // 计算当前选中到id和拼起来的name
    var selects = $(this).siblings("select").andSelf();
    var id = 0;
    var names = new Array();
    for (i = 0; i < selects.length; i++) {
        sel = selects[i];
        if (sel.value > 0) {
            id = sel.value;
            name = sel.options[sel.selectedIndex].text;
            names.push(name);
        }
    }


    // ajax请求下级地区
    var sid=$("#sid").val();
    if(sid==1||sid==4) {
        if (this.value > 0) {
            var _self = this;
            var url = SITE_URL + 'mobile.view.personal.index.php/Home/Mlselection/index/type/region.html';
            $.getJSON(url, {'pid': this.value}, function (data) {
                if (data.code == 10000) {
                    var dep=data.deep;
                    if (data.deep == 1) {
                        $(".o_provinceid").val(id);
                    } else if (data.deep == 2) {
                        $(".o_cityid").val(id);
                    } else {
                        $(".area_ids").val(id);
                    }

                    $(".area_name").val(name);
                    $(".area_names").val(names.join("\t"));
                    $(".dep").val(dep);
                    if (data.result.length > 0) {
                        $("<select><option>" + '请选择默认' + "</option></select>").change(regionChange).insertAfter(_self);
                        var data = data.result;
                        for (i = 0; i < data.length; i++) {
                            $(_self).next("select").append("<option value='" + data[i].area_id + "'>" + data[i].area_name + "</option>");
                        }
                    }
                }
                else {
                    alert(data.message);
                }
            });
        }
    }else if(sid==3){
        var dep=$("#dep").val();
            if (this.value > 0) {
                var _self = this;
                var url = SITE_URL + 'mobile.view.personal.index.php/Home/Mlselection/index/type/region.html';
                $.getJSON(url, {'pid': this.value}, function (data) {
                    if (data.code == 10000) {
                        var dep=data.deep;
                        if (data.deep == 1) {
                            $(".o_provinceid").val(id);
                        } else if (data.deep == 2) {
                            $(".o_cityid").val(id);
                        } else {
                            $(".area_ids").val(id);
                        }
                        $(".area_name").val(name);
                        $(".area_names").val(names.join("\t"));
                        if(dep==1) {
                            if (data.result.length > 0) {
                                $("<select><option>" + '请选择默认' + "</option></select>").change(regionChange).insertAfter(_self);
                                var data = data.result;
                                for (i = 0; i < data.length; i++) {
                                    $(_self).next("select").append("<option value='" + data[i].area_id + "'>" + data[i].area_name + "</option>");
                                }
                            }
                        }
                    }else {
                        alert(data.message);
                    }
                });
            }


    }else{
        $(".o_provinceid").val(id);
    }

    $(".area_names").val(names.join("\t"));
}

function regionEdit() {
    $(this).siblings("select").show();
    $(this).siblings("span").andSelf().hide();
}

/* 商品分类选择函数 */
function gcategoryInit(divId) {
    $("#" + divId + " > select").get(0).onchange = gcategoryChange; // select的onchange事件
    window.onerror = function () {
        return true;
    }; //屏蔽jquery报错
    $("#" + divId + " .edit_gcategory").click(gcategoryEdit); // 编辑按钮的onclick事件
}

function gcategoryChange() {
    // 删除后面的select
    $(this).nextAll("select").remove();

    // 计算当前选中到id和拼起来的name
    var selects = $(this).siblings("select").andSelf();
    var id = 0;
    var names = new Array();
    for (i = 0; i < selects.length; i++) {
        sel = selects[i];
        if (sel.value > 0) {
            id = sel.value;
            name = sel.options[sel.selectedIndex].text;
            names.push(name);
        }
    }
    $(".mls_id").val(id);
    $(".mls_name").val(name);
    $(".mls_names").val(names.join("\t"));

    // ajax请求下级分类
    if (this.value > 0) {
        var _self = this;
        var url = SITE_URL + 'mobile.view.personal.index.php/Home/Mlselection/index/type/goodsclass.html';
        $.getJSON(url, {'pid': this.value}, function (data) {
            if (data.code == 10000) {
                if (data.result.length > 0) {
                    $("<select><option>" + "请选择默认" + "</option></select>").change(gcategoryChange).insertAfter(_self);
                    var data = data.result;
                    for (i = 0; i < data.length; i++) {
                        $(_self).next("select").append("<option data-explain='" + data[i].commis_rate + "'value='" + data[i].gc_id + "'>" + data[i].gc_name + "</option>");
                    }
                }
            }
            else {
                alert(data.message);
            }
        });
    }
}

function gcategoryEdit() {
    $(this).siblings("select").show();
    $(this).siblings("span").andSelf().remove();
}

//显示一级分类下拉框
function show_gc_1(depth,gc_json){
    var html = '<select name="search_gc[]" id="search_gc_0" nc_type="search_gc" class="querySelect">';;
    html += ('<option value="0">请选择...</option>');
    if(gc_json){
        for(var i in gc_json){
            if(gc_json[i].depth == 1){
                html += ('<option value="'+gc_json[i].gc_id+'">'+gc_json[i].gc_name+'</option>');
            }
        }
    }
    html += '</select>';
    $("#searchgc_td").html(html);
}
//显示子分类下拉框
function show_gc_2(chooseid,gc_json){
    if(gc_json && chooseid > 0){
        var childid = gc_json[chooseid].child;
        if(childid){
            var html = '<select name="search_gc[]" id="search_gc_'+gc_json[chooseid].depth+'" nc_type="search_gc" class="querySelect">';;
            html += ('<option value="0">请选择...</option>');
            var childid_arr = childid.split(",");
            if(childid_arr){
                for(var i in childid_arr){
                    html += ('<option value="'+gc_json[childid_arr[i]].gc_id+'">'+gc_json[childid_arr[i]].gc_name+'</option>');
                }
            }
            html += '</select>';
            $("#searchgc_td").append(html);
        }
    }
}
function init_gcselect(chooseid_json, gc_json) {
    show_gc_1(1, gc_json);
    if (chooseid_json) {
        for (var i in chooseid_json) {
            show_gc_2(chooseid_json[i], gc_json);
            $('#search_gc_' + i).val(chooseid_json[i]);
            $('#choose_gcid').val(chooseid_json[i]);
        }
    }
    //商品分类select绑定事件
    $("[nc_type='search_gc']").on('change', function () {
        $(this).nextAll("[nc_type='search_gc']").remove();
        var chooseid = $(this).val();
        if (chooseid > 0) {
            $("#choose_gcid").val(chooseid);
            show_gc_2(chooseid, gc_json);
        } else {
            chooseid = $(this).prev().val();
            $("#choose_gcid").val(chooseid);
        }
    });
}
