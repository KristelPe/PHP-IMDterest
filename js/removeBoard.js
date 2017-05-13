$(".removeBoards").on("click", function(){
    var div = $(this).parent();
    var boardId = $(this).attr('name');
    $.ajax({
        type: "POST",
        url: "ajax/removeBoards.php",
        data: {id: boardId},
        success: function(response) {
            if (response.code == 200) {
                div.remove();
            }
        }
    });

});