KIRK.regist("Home.Index");
Home.Index =  function(){

};

Home.Index.prototype = {
    'init': function () {
        $('#search-button').click(function(e){
            this.toSearch();
        }.bind(this));


        document.onkeydown = function(event){
            if(window.event.keyCode==13){
                this.toSearch();
            }
        }.bind(this);


    },
    'toSearch':function(){
        var val = $('#home-search-input').val();
        if(val && val!='undefined'){
            location.href = '/search?key='+$('#home-search-input').val();
        }
    }
};