KIRK.regist('Home.Header');
Home.Header = function () {

};
Home.Header.prototype = {
    init: function () {
        new Vue({
            el: '#global-nav',
            data: {
                userLoggedIn: $('#userName').val().length>0?true:false,
                userName: $('#userName').val(),
                keyInput: ''
            },
            created:function(){
                $('.sq-corner-menu').show();
            },
            methods: {
                toLogIn: function () {
                    location.href = '/user/login';
                },
                toRegister: function () {
                    location.href = '/user/register';
                },
                toLogOut: function () {
                    $.getJSON('/user/login', {
                        'action':'login_out',
                        'timeStamp': new Date().getTime()
                    }, function(){
                        location.href="/";
                    });
                },
                search:function(){
                    if($.trim($('#search-input').val()).length>0){
                        location.href='/search?key='+$.trim($('#search-input').val())
                    }
                }
            }
        });
        document.onkeydown = function(event){
            if(window.event.keyCode==13){
                location.href='/search?key='+$.trim($('#search-input').val())
            }
        }.bind(this);
    }
};
var HomeHeader = new Home.Header();
HomeHeader.init();