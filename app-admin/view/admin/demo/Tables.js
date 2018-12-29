KIRK.regist("Admin.Demo.Tables");
Admin.Demo.Tables =  function(){

};

Admin.Demo.Tables.prototype = {
    'init':function(){

        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });

    }
};