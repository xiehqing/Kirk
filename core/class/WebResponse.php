<?php

kirk_require_class('Response');
kirk_require_class('UrlBuilder');
class WebResponse extends Response{
    public function not_found() {
        Header("HTTP/1.1 404 Not Found");
        echo '<html><body align="center" style="padding-top: 200px;">哎呀你访问的页面不存在</body></html>';
        return false;
    }
}
