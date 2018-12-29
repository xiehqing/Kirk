KIRK.regist("Admin.Demo.Notifications");
Admin.Demo.Notifications =  function(){

};

Admin.Demo.Notifications.prototype = {
    'init':function(){

        // tooltip demo
        $('.tooltip-demo').tooltip({
            selector: "[data-toggle=tooltip]",
            container: "body"
        });

        // popover demo
        $("[data-toggle=popover]")
            .popover()

    }
};