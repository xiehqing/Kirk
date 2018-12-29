KIRK.regist('Admin.PopFrame');
Admin.PopFrame = function () {

};
Admin.PopFrame.prototype = {
    init: function () {
        // 取消添加爬虫
        $(".cancel").click(function () {
            $(".add-spider-pop-mask").css("display", "none");
            $(".add-spider-point").css("display", "none");
            $(".switchPopView").hide();

        });

        // 确认添加爬虫
        $(".success").click(function () {

            $(".add-spider-pop-mask").css("display", "none");
            $(".add-spider-point").css("display", "none");
            $(".switchPopView").hide();
        });

    },

};

var AdminPopFrame = new Admin.PopFrame();
// AdminPopFrame.initPopView();
AdminPopFrame.init();