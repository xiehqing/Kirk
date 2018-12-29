KIRK.regist('Admin.LeftMenu');
Admin.LeftMenu = function () {

};
Admin.LeftMenu.prototype = {
    init: function () {

        // 点击dashboard触发事件
        $('.admin-dashboard').click(function () {
            location.reload();
        });

        $('.spider-manage-total').click(function () {
            // location.href='/spider/index.html'
            $("#page-wrapper").load(location.href+" #page-wrapper");
            // $("#test-reload").load(location.href+" #test-reload");
        });



        // $(document).ready(function() {//页面加载完成后执行此函数
        //     var tpid=$("#test-reload");
        //     fresh();
        // });
        //
        // function fresh() {
        //     var tpid=$("#test-reload");
        //     //alert(tpid);
        //     $.ajax({
        //         type: "POST",
        //         url: "genxin.do",//请求地址
        //         dataType: 'json',//传输类型
        //         data:"pid=" + tpid,//输出数据
        //         success: function(data) {//服务器返回的值，这里面是你要刷新的东西
        //             var table = $(".table");
        //             table.empty();
        //             table.append("<tr><td>药品ID</td><td>药名</td><td>药品需重</td><td>已取重量</td><td>抓药进度</td></tr>");
        //             $.each(data,function(index,val){//它可以遍历一维数组、多维数组、DOM, JSON 等等格式
        //                 table.append("<tr><td>"+val.mid+"</td><td>"+val.mname+"</td><td>"+val.mweight+"</td><td>"+val.yiqu+"</td><td>"+val.jindu+"</td></tr>");
        //             });
        //         },error:function(){
        //             alert("error");
        //         }
        //     });
        //     setTimeout("fresh()", 1000);//每隔一秒递归调用此函数，实现刷新的功能。
        // }

    },

};


var AdminLeftMenu = new Admin.LeftMenu();
AdminLeftMenu.init();