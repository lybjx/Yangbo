define([], function () {
    //修改上传的接口调用
require(['upload'], function (Upload) {
    var _onUploadResponse = Upload.events.onUploadResponse;
    Upload.events.onUploadResponse = function (response) {
        try {
            var ret = typeof response === 'object' ? response : JSON.parse(response);
            if (ret.hasOwnProperty("code") && ret.hasOwnProperty("data")) {
                return _onUploadResponse.call(this, response);
            } else if (ret.hasOwnProperty("key") && !ret.hasOwnProperty("err_code")) {
                ret.code = 1;
                ret.data = {
                    url: '/' + ret.key
                };
                return _onUploadResponse.call(this, JSON.stringify(ret));
            }
        } catch (e) {
        }
        return _onUploadResponse.call(this, response);

    };
});
window.UEDITOR_HOME_URL = Fast.api.cdnurl("/assets/addons/ueditor/");
require.config({
    paths: {
        'ueditor.config': '../addons/ueditor/ueditor.config',
        'ueditor': '../addons/ueditor/ueditor.all.min',
        'ueditor.zh': '../addons/ueditor/lang/zh-cn/zh-cn',
        'zeroclipboard': '../addons/ueditor/third-party/zeroclipboard/ZeroClipboard.min',
    },
    shim: {
        'ueditor': {
            deps: ['zeroclipboard', 'ueditor.config'],
            exports: 'UE',
            init: function (ZeroClipboard) {
                //导出到全局变量，供ueditor使用
                window.ZeroClipboard = ZeroClipboard;
            },
        },
        'ueditor.zh': ['ueditor']
    }
});
require(['ueditor', 'ueditor.zh'], function (UE, undefined) {
    $(".editor").each(function () {
        var id = $(this).attr("id");
        $(this).removeClass('form-control');
        UE.list[id] = UE.getEditor(id, {
            serverUrl: Fast.api.fixurl('/addons/ueditor/api/'),
            allowDivTransToP: false, //阻止div自动转p标签
            initialFrameWidth: '100%',
            zIndex: 90,
            xssFilterRules: false,
            outputXssFilter: false,
            inputXssFilter: false
        });
    });

});

});