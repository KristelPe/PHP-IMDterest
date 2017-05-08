$('input.checkbox').click(function(){
    var $checker = $('input[type=checkbox]');
    if ($checker.filter(':checked').length > 5){
        this.checked = false;
        if(this.checked = true) {
            this.checked = false;
            $(this).next().removeClass("selected");
        }
    } else{
        if($(this).is(':checked')) {
            $(this).next().addClass("selected");
        } else{
            $(this).next().removeClass("selected");
        }
    }

    var diff = 5 - $checker.filter(':checked').length;
    var posts;
    if (diff == 1){
        posts = " post";
    } else {
        posts = " posts";
    }

    if(diff == 0 ){
        $('h1').text('Great!');
        $('h2').text("Let's set up your homefeed");
    } else {
        $('h1').text('Like '+ diff + " more" +  posts);
    }

    document.getElementById('count').value = $checker.filter(':checked').length;
});