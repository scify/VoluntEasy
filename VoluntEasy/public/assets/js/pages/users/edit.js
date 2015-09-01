//revealing prototype pattern

//we will create a javascript class responsible for
// defining the appropriate handlers for this page
// assigning them to events


window.scify.editHandler = function() {}
window.scify.editHandler.prototype = (function(){

    var initializeTree =  function(){
        $("#tree").jOrgChart({
            chartElement: '#unitsTree',
            multiple: true,
            ulId: "#tree",
            children: true
        });
    };
    var collectUserData =  function(){
        var activeLis = [];
        $("#tree").find("li.active-node").each(function () {
            activeLis.push($(this).attr('data-id'));
        });
        var userUnits = {
            id: $(this).attr('data-user-id'),
            units: activeLis
        };
        console.log(activeLis);
    };
    var handleSaveUser = function () {

        $.ajax({
            url: $("body").attr('data-url') + '/users/units',
            method: 'POST',
            data: collectUserData(),
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            success: function (data) {
                window.location.href = $("body").attr('data-url') + "/users/one/" + data;
            }
        });
    };
    var init = function(){
        initializeTree();
        $("#save").click(handleSaveUser);
    };

    return {
        init : init
    }
})(); //IFY , self invoking anonymous function



//
// prototype pattern
//window.scify.editHandler.prototype.test =  function(){
//    alert("Test");
//    alert(this.red);
//}
//window.scify.editHandler.prototype.initializeTree =  function(){
//    $("#tree").jOrgChart({
//        chartElement: '#unitsTree',
//        multiple: true,
//        ulId: "#tree",
//        children: true
//    });
//}
//window.scify.editHandler.prototype.collectUserData =  function(){
//    var activeLis = [];
//    $("#tree").find("li.active-node").each(function () {
//        activeLis.push($(this).attr('data-id'));
//    });
//    var userUnits = {
//        id: $(this).attr('data-user-id'),
//        units: activeLis
//    };
//    console.log(activeLis);
//}
//window.scify.editHandler.prototype.handleSaveUser = function () {
//
//    $.ajax({
//        url: $("body").attr('data-url') + '/users/units',
//        method: 'POST',
//        data: this.collectUserData(),
//        headers: {
//            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
//        },
//        success: function (data) {
//            window.location.href = $("body").attr('data-url') + "/users/one/" + data;
//        }
//    });
//}
//window.scify.editHandler.prototype.assignEvents = function()
//{
//    this.initializeTree();
//    $("#save").click(this.handleSaveUser);
//}
//
//
//
