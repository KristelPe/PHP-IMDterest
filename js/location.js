var longitude = null;
var latitude = null;
var pos = null;
var key = 'AIzaSyCVmqwrRWfWWtZFEgJnXrgXNO5sIyIkhVU';
$("#generateLocation").click(function () {
navigator.geolocation.getCurrentPosition(function(position) {
    latitude = parseFloat((position.coords.latitude).toFixed(6));
    longitude = parseFloat((position.coords.longitude).toFixed(6));
    pos = '=' + latitude + ',' + longitude;
    var url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng' + pos + '&key=' + key;

        $.ajax({
            url: url,
            type: 'GET',
            success: function (result) {
                addressObj = result.results[1].formatted_address;
                $("#location").attr("value",addressObj);

            }
        })
    });
});
