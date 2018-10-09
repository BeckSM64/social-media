$( document ).ready(function() {

    //Refresh conversation every 3 seconds to check for received messages. This whole message system will not scale. But it was fun to build
    var messages = $('#conversationMessages')
    window.setInterval(function () {
        messages.load(document.URL +  ' #conversationMessages');
        //location.reload();
    }, 3000);

    //Ajax call on message submit to send and see the message without refreshing the page
    $(function() {
        $('#sendMessageBtn').click(function (e) {
            e.preventDefault();

            $.ajax({
                type: 'post',
                url: 'sendMessage.php',
                data: $('#sendMessageForm').serialize(),
                success: function () {
                    $('#sendMessageForm')[0].reset();//Clear form
                    location.reload();
                }
            });
    
        });
    });
});