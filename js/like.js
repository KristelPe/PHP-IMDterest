
function like(button) {
    var postId = button.attr("name"); //DUUUUS Dees geeft ni de correcte waarde terug en k weet ni wa k hier nog zou kunnen proberen (￣□￣)
    var likes = button.next();
    var count;

    if (button.hasClass('unliked')) {
        count = 'plus';
    } else {
        count = 'minus';
    }

    $.ajax({
        type: 'post',
        url: 'ajax/like.php',
        data: {postId: postId, count: count},
        success: function (response) {
            if (button.hasClass('unliked')) {
                button.removeClass('unliked').addClass('liked');
                likes.text(response+' likes');
            } else {
                button.removeClass('liked').addClass('unliked');
                likes.text(response+' likes');
            }

        }
    });
}