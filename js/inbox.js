$(document).ready(function () {
    var chatInterval = 250;
    var $chatOutput = $("#chatOutput");
    var $chatRefresh = $("#chat_refresh");
	var parid=$(this).closest('div').attr('id');
    function retrieveMessages() {
        $chatOutput.html("parid");
    }
	
    $chatRefresh.click(function () {
        retrieveMessages();
    });

    setInterval(function () {
        retrieveMessages();
    }, chatInterval);
});