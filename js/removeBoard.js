$(".removeBoards").on("click", function(e){

    e.preventDefault();
    var div = $(this).parent();
    var boardId = div.attr('id');
    var string = 'id=' + boardId;
    alert(boardId);
    $.ajax({
        method: "POST",
        url: "ajax/removeBoards.php",
        data: string
    }).done(function (response) {
        if (response.code == 200){
            $("div").remove("#" + response.id);
        }
    });

});