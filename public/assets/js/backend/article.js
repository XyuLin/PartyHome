define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {
    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'article/index',
                    add_url: 'article/add',
                    edit_url: 'article/edit',
                    del_url: 'article/del',
                    multi_url: 'article/multi',
                    table: 'article',
                }
            });

            var table = $("#table");

            //在普通搜索渲染后
            table.on('post-common-search.bs.table', function (event, table) {
                var form = $("form", table.$commonsearch);
                $("input[name='classify_id']", form).addClass("selectpage").data("source", "classify/index").data("primaryKey", "id").data("field", "names").data("orderBy", "id desc");
                Form.events.cxselect(form);
                Form.events.selectpage(form);
            });

            //在普通搜索渲染后
            table.on('post-common-search.bs.table', function (event, table) {
                var form = $("form", table.$commonsearch);
                $("input[name='branch_id']", form).addClass("selectpage").data("source", "branch/index").data("primaryKey", "id").data("field", "names").data("orderBy", "id desc");
                Form.events.cxselect(form);
                Form.events.selectpage(form);
            });

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'weigh',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'image', title: __('Image'), formatter: Table.api.formatter.image},
                        {field: 'classify_id', title: __('Classify_id'),visible:false},
                        {field: 'classify_names', title: __('Classify_id'),operate:false},
                        {field: 'branch_id', title: __('Branch_id'),visible:false},
                        {field: 'branch_names', title: __('Branch_id'),operate:false},
                        {field: 'title', title: __('Title')},
                        {field: 'author', title: __('Author')},
                        {field: 'share_url', title: __('Share_url'),operate:false, formatter: Table.api.formatter.url},
                        {field: 'status', title: __('Status'),yes:1,no:0,formatter:Table.api.formatter.toggle},
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
        add: function () {
            $('input[name="row[classify_id]"]').on('change', function () {
                let hideId = document.querySelector('#c-classify_id').value;
                let arr = ['26','33','34','35','36'];
                if($.inArray(hideId,arr) != -1) {
                    $('#c-branch_id_text').val('');
                    $('#branch').show();

                    $('#c-branch_id_text').data("selectPageObject").option.data = "branch/index?id="+hideId;
                }else{
                    $('#branch').hide();
                }
                // console.log(hideId);
            });
            $('#plupload-video').on('click', function () {
                $('#c-videos').click();
            })

            $("#c-videos").change(function () {
                var file = $("#c-videos").val();
                $('#c-video').val(file);
            });
            Controller.api.bindevent();
        },
        edit: function () {
            $('input[name="row[classify_id]"]').on('change', function () {
                let hideId = document.querySelector('#c-classify_id').value;
                var arr = ['26','33','34','35','36'];
                if($.inArray(hideId,arr) != -1) {
                    $('#c-branch_id_text').val('');
                    $('#branch').show();

                    $('#c-branch_id_text').data("selectPageObject").option.data = "branch/index?id="+hideId;
                }else{
                    $('#branch').hide();
                }
                // console.log(hideId);
            });
            $(function () {
                let hideId = document.querySelector('#c-classify_id').value;
                let arr = ['26','33','34','35','36'];
                if($.inArray(hideId,arr) != -1) {
                    // console.log(hideId);
                    // let obj = $()
                    $('#c-branch_id').attr('data-source',"branch/index?id="+hideId);
                }
            });
            Controller.api.bindevent();
        },
        select: function () {
            // 初始化表格参数配置
            Table.api.init({
                search: true,
                advancedSearch: true,
                pagination: true,
                extend: {
                    "index_url": "article/index",
                    'dragsort_url':'',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'image', title: __('Image'), formatter: Table.api.formatter.image},
                        {field: 'classify_id', title: __('Classify_id'),visible:false},
                        {field: 'classify_names', title: __('Classify_id'),operate:false},
                        {field: 'branch_id', title: __('Branch_id'),visible:false},
                        {field: 'branch_names', title: __('Branch_id'),operate:false},
                        {field: 'title', title: __('Title')},
                        // {field: 'share_url', title: __('Share_url')},
                        {field: 'author', title: __('Author')},
                        {
                            field: 'operate', title: __('Operate'), events: {
                                'click .btn-chooseone': function (e, value, row, index) {
                                    var multiple = Backend.api.query('multiple');
                                    multiple = multiple == 'true' ? true : false;

                                    Fast.api.close({url: row.share_url, multiple: false});
                                },
                            }, formatter: function () {
                                return '<a href="javascript:;" class="btn btn-danger btn-chooseone btn-xs"><i class="fa fa-check"></i> ' + __('Choose') + '</a>';
                            }
                        }
                    ]
                ],
                commonSearch: false
            });

            // 为表格绑定事件
            Table.api.bindevent(table);//当内容渲染完成后
        },

        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        },

    };
    return Controller;
});



