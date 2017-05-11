
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
                if(response > 1){
                    liked.body.style.backgroundImage = "url(../images/wood_2.gif)";
                }
                else if(response > 10){
                    liked.body.style.backgroundImage = "url(../images/wood_3.gif)";
                }
                else if(response > 50){
                    liked.body.style.backgroundImage = "url(../images/wood_4.gif)";
                }
            } else {
                button.removeClass('liked').addClass('unliked');
                likes.text(response+' likes');
                if(response > 1){
                    unliked.body.style.backgroundImage = "url(../images/wood_2.gif)";
                }
                else if(response > 10){
                    unliked.body.style.backgroundImage = "url(../images/wood_3.gif)";
                }
                else if(response > 50){
                    unliked.body.style.backgroundImage = "url(../images/wood_4.gif)";
                }
            }

        }
    });
}