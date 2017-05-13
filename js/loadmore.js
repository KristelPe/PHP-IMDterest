$(document).ready(function(){
    $("#more").click(function(){
        loadmore();
    });
});

function loadmore() {
    var searchq = document.getElementById('searchq').value;
    var val = document.getElementById("result_no").value;
    $.ajax({
        type: 'post',
        url: 'ajax/loadMore.php',
        data: {     getresult:val, searchq: searchq   },
        success: function (response) {
            if (response == "empty"){
                $("#more").text("There are no more posts")
            } else {
                var content = document.getElementById("items");
                content.innerHTML = content.innerHTML + response;
                // LIMIT + 20
                document.getElementById("result_no").value = Number(val) + 20;
            }
        }
    });
}
