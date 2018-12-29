/**
 * WindowsBase.js
 * @Des:    一些公共的方法
 * @Thinking：   ...
 * @Author: kuan
 * Create on 18-12-27 上午10:05
 */

window.base={
    g_restUrl:'http://admin.kirk.com/',

    getData:function(params){
        if(!params.type){
            params.type='get';
        }

        $.ajax({
            type:params.type,
            url:this.g_restUrl+params.url,
            data:params.data,
            beforeSend: function (XMLHttpRequest) {
                if (params.tokenFlag) {
                    XMLHttpRequest.setRequestHeader('token', this.getLocalStorage('token'));
                }
            },
            success:function(res){
                params.sCallback && params.sCallback(res);
            },
            error:function(res){

                params.eCallback && params.eCallback(res);
            }
        });
    },

    // 将token设置到本地存储中
    setLocalStorage:function(key,val){
        var exp=new Date().getTime()+2*24*60*60*100;  //令牌过期时间
        var obj={
            val:val,
            exp:exp
        };
        localStorage.setItem(key,JSON.stringify(obj));
    },

    // 获取本地存储
    getLocalStorage:function(key){
        var info= localStorage.getItem(key);
        if(info) {
            info = JSON.parse(info);
            if (info.exp > new Date().getTime()) {
                return info.val;
            }
            else{
                this.deleteLocalStorage('token');
            }
        }
        return '';
    },

    // 删除本地存储的token
    deleteLocalStorage:function(key){
        return localStorage.removeItem(key);
    },

    // 删除cookie信息
    deleteCookies:function clearAllCookie() {
        var keys = document.cookie.match(/[^ =;]+(?=\=)/g);
        if(keys) {
            for(var i = keys.length; i--;)
                document.cookie = keys[i] + '=0;expires=' + new Date(0).toUTCString()
        }
        return '';
    },

};