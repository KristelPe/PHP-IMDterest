document.getElementById('bg').style.display = "none";

$("#followers").click(function(){
    document.getElementById('bg').style.display = "block";

    $.ajax({
        type: 'post',
        url: 'ajax/followers.php',
        success: function (response) {
            document.getElementById('listF').innerHTML = document.getElementById('listF').innerHTML + response;
        }
    });
});

$("#close").click(function() {
    document.getElementById('bg').style.display = "none";
    document.getElementById('listF').innerHTML = "";
});


/**
 * Created by Crystal on 12/05/17.
 */
