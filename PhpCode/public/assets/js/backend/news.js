define(['jquery', 'bootstrap', 'backend', 'table', 'form', 'jstree'], function ($, undefined, Backend, Table, Form,undefined) {
//读取选中的条目
    $.jstree.core.prototype.get_all_checked = function (full) {
        var obj = this.get_selected(), i, j;
        for (i = 0, j = obj.length; i < j; i++) {
            obj = obj.concat(this.get_node(obj[i]).parents);
        }
        obj = $.grep(obj, function (v, i, a) {
            return v != '#';
        });
        obj = obj.filter(function (itm, i, a) {
            return i == a.indexOf(itm);
        });
        return full ? $.map(obj, $.proxy(function (i) {
            return this.get_node(i);
        }, this)) : obj;
    };
    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'news/index',
                    add_url: 'news/add',
                    edit_url: 'news/edit',
                    del_url: 'news/del',
                    multi_url: 'news/multi',
                    dragsort_url: 'ajax/weigh',
                    table: 'cms_article',
                }
            });


            var table = $("#table");
            table.on('post-body.bs.table', function (e, json) {
                $("tbody tr[data-index]", this).each(function () {
                    if (parseInt($("td:eq(1)", this).text())) {
                        $("input[type=checkbox]", this).prop("disabled", false);
                    }
                });
            });
            var tableOptions = {
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                escape: false,
                pk: 'id',
                sortName: 'id',
                pagination: true,
                commonSearch: false,
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'title', title: __('title'), align: 'left'},
                        {field: 'abstract', title: __('abstract'), align: 'left'},
                        {field: 'writer', title: __('writer'), align: 'left'},
                        {field: 'sn', title: __('sn')},
                        {field: 'cover_img', title: __('cover_img'), align: 'left', formatter: Table.api.formatter.image},
                        {field: 'status', title: __('status'), operate: false, formatter: Table.api.formatter.status},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: function (value, row, index) {
                            return Table.api.formatter.operate.call(this, value, row, index);
                        }}]
                ]
            };
            // 初始化表格
            table.bootstrapTable(tableOptions);

            // 为表格绑定事件
            Table.api.bindevent(table);

            //绑定TAB事件


            //必须默认触发shown.bs.tab事件
            // $('ul.nav-tabs li.active a[data-toggle="tab"]').trigger("shown.bs.tab");

        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                $(document).on("change", "#c-type", function () {
                    $("#c-pid option[data-type='all']").prop("selected", true);
                    $("#c-pid option").removeClass("hide");
                    $("#c-pid option[data-type!='" + $(this).val() + "'][data-type!='all']").addClass("hide");
                    $("#c-pid").selectpicker("refresh");
                });
                Form.api.bindevent($("form[role=form]"), null, null, function () {
                    if ($("#treeview").size() > 0) {
                        var r = $("#treeview").jstree("get_all_checked");
                        $("input[name='row[categoryids]']").val(r.join(','));
                    }
                    return true;
                });
                $("#treeview").jstree("destroy");
                Controller.api.rendertree(nodeData);
                //全选和展开
                $(document).on("click", "#checkall", function () {
                    console.log($(this));
                    $("#treeview").jstree($(this).prop("checked") ? "check_all" : "uncheck_all");
                });
                $(document).on("click", "#expandall", function () {
                    $("#treeview").jstree($(this).prop("checked") ? "open_all" : "close_all");
                });
                $("select[name='row[categoryids]']").trigger("change");
                $("#treeview").jstree(true).select_node('0_anchor');;
                selected();
            },
            rendertree: function (content) {
                $("#treeview")
                    .on('redraw.jstree', function (e) {
                        $(".layer-footer").attr("domrefresh", Math.random());
                    })
                    .jstree({
                        "themes": {"stripes": true},
                        "checkbox": {
                            "keep_selected_style": false,
                        },
                        "types": {
                            "root": {
                                "icon": "fa fa-folder-open",
                            },
                            "menu": {
                                "icon": "fa fa-folder-open",
                            },
                            "file": {
                                "icon": "fa fa-file-o",
                            }
                        },
                        "plugins": ["checkbox", "types"],
                        "core": {
                            'check_callback': true,
                            "data": content
                        }
                    }).on("ready.jstree", function (event, data) {
                    selected();

                });;
            },

        },

    };

    return Controller;
});