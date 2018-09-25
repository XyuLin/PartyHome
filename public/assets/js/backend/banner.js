define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'banner/index',
                    add_url: 'banner/add',
                    edit_url: 'banner/edit',
                    del_url: 'banner/del',
                    multi_url: 'banner/multi',
                    table: 'banner',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'weigh',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'descript', title: __('Descript')},
                        {field: 'image', title: __('Image'), formatter: Table.api.formatter.image},
                        {field: 'type', title: __('Type'), searchList: {"1":__('Type 1'),"2":__('Type 2')}, formatter: Table.api.formatter.normal},
                        {field: 'url', title: __('Url'), formatter: Table.api.formatter.url},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'weigh', title: __('Weigh')},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function (form) {
            $("#fachoose-article", form).on('click', function () {
                var that = this;
                var multiple = $(this).data("multiple") ? $(this).data("multiple") : false;
                var mimetype = $(this).data("mimetype") ? $(this).data("mimetype") : '';
                parent.Fast.api.open("article/select?element_id=" + $(this).attr("id") + "&multiple=" + multiple + "&mimetype=" + mimetype, __('Choose'), {
                    callback: function (data) {var button = $("#" + $(that).attr("id"));
                        var maxcount = $(button).data("maxcount");
                        var input_id = $(button).data("input-id") ? $(button).data("input-id") : "";
                        maxcount = typeof maxcount !== "undefined" ? maxcount : 0;
                        if (input_id && data.multiple) {
                            var urlArr = [];
                            var inputObj = $("#" + input_id);
                            var value = $.trim(inputObj.val());
                            if (value !== "") {
                                urlArr.push(inputObj.val());
                            }
                            urlArr.push(data.url)
                            var result = urlArr.join(",");
                            if (maxcount > 0) {
                                var nums = value === '' ? 0 : value.split(/\,/).length;
                                var files = data.url !== "" ? data.url.split(/\,/) : [];
                                var remains = maxcount - nums;
                                if (files.length > remains) {
                                    Toastr.error(__('You can choose up to %d file%s', remains));
                                    return false;
                                }
                            }
                            inputObj.val(result).trigger("change");
                        } else {
                            $("#" + input_id).val(data.url).trigger("change");
                        }
                    }
                });
                return false;
            });
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});