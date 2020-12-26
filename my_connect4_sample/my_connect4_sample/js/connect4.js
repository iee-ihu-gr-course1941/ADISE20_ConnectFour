(document).ready(function(){
    var player = 1;
    var winner = 0;
    var colors = {};
    colors[-1] = "yellow";
    colors[1] = "red";
    var count = 0;

    $(".button").each(function(){
        $(this).attr("id", count);
        $(this).attr("data-player", 0);
        count++;

        $(this).click(function(){

            if(isValid($(this).attr("id"))){
                $(this).css("background-color", colors[player]);
                $(this).attr("data-player", player);

                player = -1;
            }
        });
    });

    function isValid(n){
        var id = parseInt(n);

        if($("#" + id).attr("data-player") === "0") {
            if(id >= 35){
                return true;
            }
            if($("#" + (id + 7)).attr("data-player") !== 0) {
                return true;
            }

        }

        return false;
    }
});