KIRK.regist("Admin.Index");
Admin.Index =  function(){

};

Admin.Index.prototype = {
    'init':function(){

        this.getLoginCountData()
    },
    // 请求接口获取登录数据
    getLoginCountData:function(){
        var params={
            url:'/',
            type:'post',
            data:{action:'getRandomData'},
            sCallback:function(result){
                var res =JSON.parse(result);
                console.log(res);
                console.log(res.status);
                // 请求成功
                if(res.status == 0){
                    this.setLoginCountData(res.data);
                }
            }.bind(this),
            eCallback:function(e){
                alert("网络异常，请重试!");
            }
        };
        console.log(params);
        window.base.getData(params);
    },

    // 设置登录数据
    setLoginCountData:function (data) {
        Morris.Area({
            element: 'morris-area-chart',
            data: data,
            xkey: ['login_time'],
            ykeys: ['count'],
            labels: ['登录次数'],
            pointSize: 2,
            hideHover: 'auto',
            resize: true
        });
    }
};