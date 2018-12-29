KIRK.regist("Admin.Login");
Admin.Login =  function(){

};

Admin.Login.prototype = {
    'init':function(){
        $(document).on('click','#login-ok',function(){
            var $userName=$('#user-name'),
                $pwd=$('#user-pwd');

            if(!$userName.val()) {
                $userName.next().show().find('div').text('请输入账号');
                return;
            }
            if(!$pwd.val()) {
                $pwd.next().show().find('div').text('请输入密码');
                return;
            }
            var params={
                url:'api/login?action=Login',
                type:'post',
                data:{username:$userName.val(),password:$pwd.val()},
                sCallback:function(res){
                    console.log(res);
                    console.log(res.status);
                    if(res.status == 0){
                        window.base.setLocalStorage('token',res.token);
                        // window.location.href = 'index.html';
                        location.href = "/";
                    }
                },
                eCallback:function(e){
                    if(e.status != 0){
                        $('.error-tips').text('帐号或密码错误').show().delay(2000).hide(0);
                    }
                }
            };
            window.base.getData(params);
        });

        $(document).on('focus','.normal-input',function(){
            $('.common-error-tips').hide();
        });

        $(document).on('keydown','.normal-input',function(e){
            var e = event || window.event || arguments.callee.caller.arguments[0];
            if(e && e.keyCode==13){
                $('#login').trigger('click');
            }
        });

    },
};