$( document ).ready(function() {
    console.log( "ready!" );

});

$('.like').find('button').click(function(e){
    var button = $(this);
    like(button);
});

function like(button, el) {
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
                if(parseInt(likes[0].innerHTML) <= 0){
                    button.css({
                        backgroundImage: "url(images/wood_1.gif)"
                    });
                }
                else if(parseInt(likes[0].innerHTML) > 0 && parseInt(likes[0].innerHTML) < 10){
                    button.css({
                        backgroundImage: "url(images/wood_2.gif)"
                    });
                }
                else if(parseInt(likes[0].innerHTML) >= 10 && parseInt(likes[0].innerHTML) < 49){
                    button.css({
                        backgroundImage: "url(images/wood_3.gif)"
                    });
                }
                else if(parseInt(likes[0].innerHTML) >= 50){
                    button.css({
                        backgroundImage: "url(images/wood_4.gif)"
                    });
                }
            } else {
                button.removeClass('liked').addClass('unliked');
                likes.text(response+' likes');
                if(parseInt(likes[0].innerHTML) <= 0){
                    button.css({
                        backgroundImage: "url(images/wood_1.gif)"
                    });
                }
                else if(parseInt(likes[0].innerHTML) > 0 && parseInt(likes[0].innerHTML) < 9){
                    button.css({
                        backgroundImage: "url(images/wood_2.gif)"
                    });
                }
                else if(parseInt(likes[0].innerHTML) > 9 && parseInt(likes[0].innerHTML) < 49){
                    button.css({
                        backgroundImage: "url(images/wood_3.gif)"
                    });
                }
                else if(parseInt(likes[0].innerHTML) > 50){
                    button.css({
                        backgroundImage: "url(images/wood_4.gif)"
                    });
                }
            }

        }
    });
}