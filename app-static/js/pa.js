
/*

 ____ ___ _   _  ____    _    _   _ ____  _____ ____
|  _ \_ _| \ | |/ ___|  / \  | \ | / ___|| ____/ ___|
| |_) | ||  \| | |  _  / _ \ |  \| \___ \|  _|| |
|  __/| || |\  | |_| |/ ___ \| |\  |___) | |__| |___
|_|  |___|_| \_|\____/_/   \_\_| \_|____/|_____\____|


*/var KIRK={regist:function(t,e){e=e||function(){};for(var i=t.split("."),n=window,o=0;o<i.length;o++){if(o!=i.length-1)"undefined"==typeof n[i[o]]&&(n[i[o]]={});else{if("undefined"!=typeof n[i[o]])throw t+"命名空间重复,请修改！";n[i[o]]=e}n=n[i[o]]}},log:function(t){"undefined"==typeof console||console.log(t)},callIndex:0,callBacks:[],addCallback:function(t){var e=++this.callIndex;return this.callBacks[e]=t,e},excuteCallback:function(t){this.callBacks[t]&&this.callBacks[t]()},get_json_cross_domain:function(t,e,i){var n=this.addCallback(i);t+=-1==t.indexOf("?")?"?":"&";for(k in e)t+=k+"="+encodeURIComponent(e[k])+"&";t+="callback="+encodeURIComponent("KIRK.callBacks["+n+"]");var o=document.createElement("script");o.type="text/javascript",o.async=!0,o.src=t,document.body.appendChild(o)},getKeys:function(t){var e=[];for(k in t)e.push(k);return e},copyJson:function(t){var e={};for(k in t)e[k]=t[k];return e},deepCopyJson:function(t,e){if("object"==typeof t){if(t instanceof Array){e||(e=new Array);for(var i=t.length,n=0;i>n;n++)"object"!=typeof t[n]?e[n]=t[n]:(e[n]=t[n]instanceof Array?new Array:new Object,this.deepCopyJson(t[n],e[n]))}else{e||(e=new Object);for(var o in t)"object"!=typeof t[n]?e[o]=t[o]:(e[o]=t[o]instanceof Array?new Array:new Object,this.deepCopyJson(t[o],e[o]))}return e}return t},getCookie:function(t){for(var e=document.cookie.split("; "),i=0;i<e.length;i++){var n=e[i].split("=");if(n[0]==t)return n[1]||""}return""},setCookie:function(t,e,i,n,o,s){var r=new Date;r.setTime(r.getTime()+i),document.cookie=escape(t)+"="+escape(e)+(r?"; expires="+r.toGMTString():"")+(n?"; path="+n:"/")+(o?"; domain="+o:"")+(s?"; secure":"")},getParent:function(t,e,i){t.extend=e,t.extend.apply(t,i),t.extend=null,delete t.extend}};Function.prototype.bind||(Function.prototype.bind=function(t){var e=this;return function(){return e.apply(t,arguments)}}),Array.prototype.each=function(t){for(var e=0;e<this.length;e++)t(e,this[e])},Array.prototype.removeAtIndex=function(t){return this.slice(t,1)},String.prototype.reverse=function(){return this.split("").reverse().join("")},KIRK.regist("EmptyFrame"),EmptyFrame=function(){this.init=function(){}},function(t){"use strict";function e(t){if(t)u[0]=u[16]=u[1]=u[2]=u[3]=u[4]=u[5]=u[6]=u[7]=u[8]=u[9]=u[10]=u[11]=u[12]=u[13]=u[14]=u[15]=0,this.blocks=u,this.buffer8=n;else if(r){var e=new ArrayBuffer(68);this.buffer8=new Uint8Array(e),this.blocks=new Uint32Array(e)}else this.blocks=[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];this.h0=this.h1=this.h2=this.h3=this.start=this.bytes=0,this.finalized=this.hashed=!1,this.first=!0}var i="object"==typeof process&&process.versions&&process.versions.node;i&&(t=global);var n,o=!t.JS_MD5_TEST&&"object"==typeof module&&module.exports,s="function"==typeof define&&define.amd,r=!t.JS_MD5_TEST&&"undefined"!=typeof ArrayBuffer,a="0123456789abcdef".split(""),h=[128,32768,8388608,-2147483648],c=[0,8,16,24],l=["hex","array","digest","buffer","arrayBuffer"],u=[];if(r){var d=new ArrayBuffer(68);n=new Uint8Array(d),u=new Uint32Array(d)}var p=function(t){return function(i){return new e(!0).update(i)[t]()}},f=function(){var t=p("hex");i&&(t=m(t)),t.create=function(){return new e},t.update=function(e){return t.create().update(e)};for(var n=0;n<l.length;++n){var o=l[n];t[o]=p(o)}return t},m=function(e){var i,n;try{if(t.JS_MD5_TEST)throw"JS_MD5_TEST";i=require("crypto"),n=require("buffer").Buffer}catch(o){return console.log(o),e}var s=function(t){if("string"==typeof t)return i.createHash("md5").update(t,"utf8").digest("hex");if(t.constructor==ArrayBuffer)t=new Uint8Array(t);else if(void 0===t.length)return e(t);return i.createHash("md5").update(new n(t)).digest("hex")};return s};e.prototype.update=function(e){if(!this.finalized){var i="string"!=typeof e;i&&e.constructor==t.ArrayBuffer&&(e=new Uint8Array(e));for(var n,o,s=0,a=e.length||0,h=this.blocks,l=this.buffer8;a>s;){if(this.hashed&&(this.hashed=!1,h[0]=h[16],h[16]=h[1]=h[2]=h[3]=h[4]=h[5]=h[6]=h[7]=h[8]=h[9]=h[10]=h[11]=h[12]=h[13]=h[14]=h[15]=0),i)if(r)for(o=this.start;a>s&&64>o;++s)l[o++]=e[s];else for(o=this.start;a>s&&64>o;++s)h[o>>2]|=e[s]<<c[3&o++];else if(r)for(o=this.start;a>s&&64>o;++s)n=e.charCodeAt(s),128>n?l[o++]=n:2048>n?(l[o++]=192|n>>6,l[o++]=128|63&n):55296>n||n>=57344?(l[o++]=224|n>>12,l[o++]=128|63&n>>6,l[o++]=128|63&n):(n=65536+((1023&n)<<10|1023&e.charCodeAt(++s)),l[o++]=240|n>>18,l[o++]=128|63&n>>12,l[o++]=128|63&n>>6,l[o++]=128|63&n);else for(o=this.start;a>s&&64>o;++s)n=e.charCodeAt(s),128>n?h[o>>2]|=n<<c[3&o++]:2048>n?(h[o>>2]|=(192|n>>6)<<c[3&o++],h[o>>2]|=(128|63&n)<<c[3&o++]):55296>n||n>=57344?(h[o>>2]|=(224|n>>12)<<c[3&o++],h[o>>2]|=(128|63&n>>6)<<c[3&o++],h[o>>2]|=(128|63&n)<<c[3&o++]):(n=65536+((1023&n)<<10|1023&e.charCodeAt(++s)),h[o>>2]|=(240|n>>18)<<c[3&o++],h[o>>2]|=(128|63&n>>12)<<c[3&o++],h[o>>2]|=(128|63&n>>6)<<c[3&o++],h[o>>2]|=(128|63&n)<<c[3&o++]);this.lastByteIndex=o,this.bytes+=o-this.start,o>=64?(this.start=o-64,this.hash(),this.hashed=!0):this.start=o}return this}},e.prototype.finalize=function(){if(!this.finalized){this.finalized=!0;var t=this.blocks,e=this.lastByteIndex;t[e>>2]|=h[3&e],e>=56&&(this.hashed||this.hash(),t[0]=t[16],t[16]=t[1]=t[2]=t[3]=t[4]=t[5]=t[6]=t[7]=t[8]=t[9]=t[10]=t[11]=t[12]=t[13]=t[14]=t[15]=0),t[14]=this.bytes<<3,this.hash()}},e.prototype.hash=function(){var t,e,i,n,o,s,r=this.blocks;this.first?(t=r[0]-680876937,t=(t<<7|t>>>25)-271733879<<0,n=(-1732584194^2004318071&t)+r[1]-117830708,n=(n<<12|n>>>20)+t<<0,i=(-271733879^n&(-271733879^t))+r[2]-1126478375,i=(i<<17|i>>>15)+n<<0,e=(t^i&(n^t))+r[3]-1316259209,e=(e<<22|e>>>10)+i<<0):(t=this.h0,e=this.h1,i=this.h2,n=this.h3,t+=(n^e&(i^n))+r[0]-680876936,t=(t<<7|t>>>25)+e<<0,n+=(i^t&(e^i))+r[1]-389564586,n=(n<<12|n>>>20)+t<<0,i+=(e^n&(t^e))+r[2]+606105819,i=(i<<17|i>>>15)+n<<0,e+=(t^i&(n^t))+r[3]-1044525330,e=(e<<22|e>>>10)+i<<0),t+=(n^e&(i^n))+r[4]-176418897,t=(t<<7|t>>>25)+e<<0,n+=(i^t&(e^i))+r[5]+1200080426,n=(n<<12|n>>>20)+t<<0,i+=(e^n&(t^e))+r[6]-1473231341,i=(i<<17|i>>>15)+n<<0,e+=(t^i&(n^t))+r[7]-45705983,e=(e<<22|e>>>10)+i<<0,t+=(n^e&(i^n))+r[8]+1770035416,t=(t<<7|t>>>25)+e<<0,n+=(i^t&(e^i))+r[9]-1958414417,n=(n<<12|n>>>20)+t<<0,i+=(e^n&(t^e))+r[10]-42063,i=(i<<17|i>>>15)+n<<0,e+=(t^i&(n^t))+r[11]-1990404162,e=(e<<22|e>>>10)+i<<0,t+=(n^e&(i^n))+r[12]+1804603682,t=(t<<7|t>>>25)+e<<0,n+=(i^t&(e^i))+r[13]-40341101,n=(n<<12|n>>>20)+t<<0,i+=(e^n&(t^e))+r[14]-1502002290,i=(i<<17|i>>>15)+n<<0,e+=(t^i&(n^t))+r[15]+1236535329,e=(e<<22|e>>>10)+i<<0,t+=(i^n&(e^i))+r[1]-165796510,t=(t<<5|t>>>27)+e<<0,n+=(e^i&(t^e))+r[6]-1069501632,n=(n<<9|n>>>23)+t<<0,i+=(t^e&(n^t))+r[11]+643717713,i=(i<<14|i>>>18)+n<<0,e+=(n^t&(i^n))+r[0]-373897302,e=(e<<20|e>>>12)+i<<0,t+=(i^n&(e^i))+r[5]-701558691,t=(t<<5|t>>>27)+e<<0,n+=(e^i&(t^e))+r[10]+38016083,n=(n<<9|n>>>23)+t<<0,i+=(t^e&(n^t))+r[15]-660478335,i=(i<<14|i>>>18)+n<<0,e+=(n^t&(i^n))+r[4]-405537848,e=(e<<20|e>>>12)+i<<0,t+=(i^n&(e^i))+r[9]+568446438,t=(t<<5|t>>>27)+e<<0,n+=(e^i&(t^e))+r[14]-1019803690,n=(n<<9|n>>>23)+t<<0,i+=(t^e&(n^t))+r[3]-187363961,i=(i<<14|i>>>18)+n<<0,e+=(n^t&(i^n))+r[8]+1163531501,e=(e<<20|e>>>12)+i<<0,t+=(i^n&(e^i))+r[13]-1444681467,t=(t<<5|t>>>27)+e<<0,n+=(e^i&(t^e))+r[2]-51403784,n=(n<<9|n>>>23)+t<<0,i+=(t^e&(n^t))+r[7]+1735328473,i=(i<<14|i>>>18)+n<<0,e+=(n^t&(i^n))+r[12]-1926607734,e=(e<<20|e>>>12)+i<<0,o=e^i,t+=(o^n)+r[5]-378558,t=(t<<4|t>>>28)+e<<0,n+=(o^t)+r[8]-2022574463,n=(n<<11|n>>>21)+t<<0,s=n^t,i+=(s^e)+r[11]+1839030562,i=(i<<16|i>>>16)+n<<0,e+=(s^i)+r[14]-35309556,e=(e<<23|e>>>9)+i<<0,o=e^i,t+=(o^n)+r[1]-1530992060,t=(t<<4|t>>>28)+e<<0,n+=(o^t)+r[4]+1272893353,n=(n<<11|n>>>21)+t<<0,s=n^t,i+=(s^e)+r[7]-155497632,i=(i<<16|i>>>16)+n<<0,e+=(s^i)+r[10]-1094730640,e=(e<<23|e>>>9)+i<<0,o=e^i,t+=(o^n)+r[13]+681279174,t=(t<<4|t>>>28)+e<<0,n+=(o^t)+r[0]-358537222,n=(n<<11|n>>>21)+t<<0,s=n^t,i+=(s^e)+r[3]-722521979,i=(i<<16|i>>>16)+n<<0,e+=(s^i)+r[6]+76029189,e=(e<<23|e>>>9)+i<<0,o=e^i,t+=(o^n)+r[9]-640364487,t=(t<<4|t>>>28)+e<<0,n+=(o^t)+r[12]-421815835,n=(n<<11|n>>>21)+t<<0,s=n^t,i+=(s^e)+r[15]+530742520,i=(i<<16|i>>>16)+n<<0,e+=(s^i)+r[2]-995338651,e=(e<<23|e>>>9)+i<<0,t+=(i^(e|~n))+r[0]-198630844,t=(t<<6|t>>>26)+e<<0,n+=(e^(t|~i))+r[7]+1126891415,n=(n<<10|n>>>22)+t<<0,i+=(t^(n|~e))+r[14]-1416354905,i=(i<<15|i>>>17)+n<<0,e+=(n^(i|~t))+r[5]-57434055,e=(e<<21|e>>>11)+i<<0,t+=(i^(e|~n))+r[12]+1700485571,t=(t<<6|t>>>26)+e<<0,n+=(e^(t|~i))+r[3]-1894986606,n=(n<<10|n>>>22)+t<<0,i+=(t^(n|~e))+r[10]-1051523,i=(i<<15|i>>>17)+n<<0,e+=(n^(i|~t))+r[1]-2054922799,e=(e<<21|e>>>11)+i<<0,t+=(i^(e|~n))+r[8]+1873313359,t=(t<<6|t>>>26)+e<<0,n+=(e^(t|~i))+r[15]-30611744,n=(n<<10|n>>>22)+t<<0,i+=(t^(n|~e))+r[6]-1560198380,i=(i<<15|i>>>17)+n<<0,e+=(n^(i|~t))+r[13]+1309151649,e=(e<<21|e>>>11)+i<<0,t+=(i^(e|~n))+r[4]-145523070,t=(t<<6|t>>>26)+e<<0,n+=(e^(t|~i))+r[11]-1120210379,n=(n<<10|n>>>22)+t<<0,i+=(t^(n|~e))+r[2]+718787259,i=(i<<15|i>>>17)+n<<0,e+=(n^(i|~t))+r[9]-343485551,e=(e<<21|e>>>11)+i<<0,this.first?(this.h0=t+1732584193<<0,this.h1=e-271733879<<0,this.h2=i-1732584194<<0,this.h3=n+271733878<<0,this.first=!1):(this.h0=this.h0+t<<0,this.h1=this.h1+e<<0,this.h2=this.h2+i<<0,this.h3=this.h3+n<<0)},e.prototype.hex=function(){this.finalize();var t=this.h0,e=this.h1,i=this.h2,n=this.h3;return a[15&t>>4]+a[15&t]+a[15&t>>12]+a[15&t>>8]+a[15&t>>20]+a[15&t>>16]+a[15&t>>28]+a[15&t>>24]+a[15&e>>4]+a[15&e]+a[15&e>>12]+a[15&e>>8]+a[15&e>>20]+a[15&e>>16]+a[15&e>>28]+a[15&e>>24]+a[15&i>>4]+a[15&i]+a[15&i>>12]+a[15&i>>8]+a[15&i>>20]+a[15&i>>16]+a[15&i>>28]+a[15&i>>24]+a[15&n>>4]+a[15&n]+a[15&n>>12]+a[15&n>>8]+a[15&n>>20]+a[15&n>>16]+a[15&n>>28]+a[15&n>>24]},e.prototype.toString=e.prototype.hex,e.prototype.digest=function(){this.finalize();var t=this.h0,e=this.h1,i=this.h2,n=this.h3;return[255&t,255&t>>8,255&t>>16,255&t>>24,255&e,255&e>>8,255&e>>16,255&e>>24,255&i,255&i>>8,255&i>>16,255&i>>24,255&n,255&n>>8,255&n>>16,255&n>>24]},e.prototype.array=e.prototype.digest,e.prototype.arrayBuffer=function(){this.finalize();var t=new ArrayBuffer(16),e=new Uint32Array(t);return e[0]=this.h0,e[1]=this.h1,e[2]=this.h2,e[3]=this.h3,t},e.prototype.buffer=e.prototype.arrayBuffer;var g=f();o?module.exports=g:(t.md5=g,s&&define(function(){return g}))}(this),KIRK.regist("Pa.Pa"),Pa.Pa=function(){this.guid="",this.isUserDistanche=20,this.startPoint=null,this.hasSendData=!1,this.code=0},Pa.Pa.KEY_GUID="pa_guid",Pa.Pa.prototype={init:function(){this.initCookie(),this.getCode(),window.addEventListener?window.addEventListener("mousemove",this.checkUserBahavior.bind(this)):document.documentElement.attachEvent("onmousemove",this.checkUserBahavior.bind(this))},getCode:function(){var t=/pa_from\=(\d+)/i.exec(location.href);t&&t.length>=2&&(this.code=t[1])},checkUserBahavior:function(t){if(t=t||window.event,null==this.startPoint)this.startPoint={x:t.x,y:t.y};else{var e=this.getTwoPointDistance(this.startPoint,t);e>this.isUserDistanche&&this.sendData()}},getTwoPointDistance:function(t,e){return Math.sqrt(Math.pow(e.y-t.y,2)+Math.pow(e.x-t.x,2))},sendData:function(){if(!this.hasSendData&&(this.hasSendData=!0,this.code)){var t={url:encodeURIComponent(location.href),referer:encodeURIComponent(document.referrer),guid:this.guid,t:(new Date).getTime(),code:this.code,action:"in"},e="http://pa.pacra.cn/data",i="";for(var n in t)i+=n+"="+t[n]+"&";var o=new Image;o.src=e+"?"+i}},initCookie:function(){this.checkCookieExist()||this.createCookie()},checkCookieExist:function(){var t=KIRK.getCookie(Pa.Pa.KEY_GUID);return t?(this.guid=t,!0):(this.guid="",!1)},createCookie:function(){var t=15768e9,e=md5((new Date).getTime()+"-"+Math.random());KIRK.setCookie(Pa.Pa.KEY_GUID,e,t),this.guid=e}},(new Pa.Pa).init();