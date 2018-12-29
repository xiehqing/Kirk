KIRK.regist('Admin.TopHeader');
Admin.TopHeader = function () {

};

Admin.TopHeader.prototype = {
    init: function () {
        if(!window.base.getLocalStorage('token')){
            window.location.href = '/login/';
        }

        /*退出*/
        $(document).on('click','#login-out',function(){
            window.base.deleteLocalStorage('token');
            window.base.deleteCookies();
            window.location.href = '/login/';
        });
    }
};

var AdminTopHeader = new Admin.TopHeader();
$(document).ready(function () {
    AdminTopHeader.init();
});

