
var  KIRK =  {
    regist:function(className,ClassObject) {
        ClassObject = ClassObject || function(){};
        var path = className.split(".");
        var current = window;
        for(var i=0;i<path.length;i++) {
            if(i!=(path.length-1)) {
                if(typeof current[path[i]]=='undefined') {
                    current[path[i]] = {};
                }
            } else {
                if(typeof current[path[i]] =='undefined') {
                    current[path[i]] = ClassObject;
                } else {
                    throw className+"命名空间重复,请修改！";
                    return false;
                }
            }
            current = current[path[i]];
        }
    },
    log:function(obj) {
        if(typeof console =='undefined') {
            //alert(obj);
        } else {
            console.log(obj);
        }
    },
    callIndex:0,
    callBacks:[],
    addCallback:function(callback){
        var index = ++this.callIndex;
        this.callBacks[index] = callback;
        return index;
    },
    excuteCallback:function(index) {
        if(this.callBacks[index]) {
            this.callBacks[index]();
        }
    },
    get_json_cross_domain:function(url,data,call_back) {
        var index = this.addCallback(call_back);
        if(url.indexOf('?')==-1) {
            url+='?';
        } else {
            url += '&';
        }
        for(k in data) {
            url += (k+'='+encodeURIComponent(data[k])+'&');
        }
        url+='callback='+encodeURIComponent('KIRK.callBacks['+index+']');
        var s = document.createElement('script');
        s.type = 'text/javascript';
        s.async = true;
        s.src = url;
        document.body.appendChild(s);
    },
    getKeys:function(obj){
        var re = [];
        for(k in obj) {
            re.push(k);
        }
        return re;
    },
    //只一层copy
    copyJson:function(json) {
        var newJson = {};
        for(k in json) {
            newJson[k] = json[k];
        }
        return newJson;
    },
    //deepCopy
    deepCopyJson:function(obj,temp) {
        if(typeof(obj)=='object') {
            if(obj instanceof Array ) {
                if(!temp) {
                    temp = new Array();
                }
                var len = obj.length;
                for(var i=0;i<len;i++) {
                    if(typeof obj[i] !='object') {
                        temp[i] = obj[i];
                    } else {
                        if(obj[i] instanceof Array) {
                            temp[i] = new Array();
                        } else {
                            temp[i] = new Object();
                        }
                        this.deepCopyJson(obj[i],temp[i]);
                    }
                }
            } else {
                if(!temp) {
                    temp = new Object();
                }
                for(var k in obj) {
                    if(typeof obj[i] !='object') {
                        temp[k] = obj[k];
                    } else {
                        if(obj[k] instanceof Array) {
                            temp[k] = new Array();
                        } else {
                            temp[k] = new Object();
                        }
                        this.deepCopyJson(obj[k],temp[k]);
                    }
                }
            }
            return temp;
        } else {
            return obj;
        }
    },
    getCookie:function(name) {
        var cookies = document.cookie.split('; ');
        for (var i = 0; i < cookies.length; i++) {
            var info = cookies[i].split('=');
            if (info[0] == name) {
                return info[1] || '';
            }
        }
        return '';
    },
    setCookie:function(cookieName, cookieValue, seconds, path, domain, secure) {
        var expires = new Date();
        expires.setTime(expires.getTime() + seconds);
        document.cookie = escape(cookieName) + '=' + escape(cookieValue)
            + (expires ? '; expires=' + expires.toGMTString() : '')
            + (path ? '; path=' + path : '/')
            + (domain ? '; domain=' + domain : '')
            + (secure ? '; secure' : '');
    },
    getParent:function(instance,parent,arg){
        instance.extend = parent;
        instance.extend.apply(instance,arg);
        instance.extend = null;
        delete instance.extend;
    }
};

if(!Function.prototype.bind) {
    Function.prototype.bind = function (obj) {
        var _this = this;
        return function () {
            return _this.apply(obj, arguments);
        }
    };
}
Array.prototype.each = function(callback) {
    for(var i=0;i<this.length;i++) {
        callback(i,this[i]);
    }
};
Array.prototype.removeAtIndex = function(index) {
    return  this.slice(index,1);
};

String.prototype.reverse = function(){
    return this.split('').reverse().join('');
};
