$( document ).ready(function() {

    $(function() {
        $('#addPostCommentBtn').click(function (e) {
            
            e.preventDefault();
    
            $.ajax({
                type: 'post',
                url: 'addComment.php',
                data: $('#addPostCommentForm').serialize(),
                success: function () {
                    $('#addPostCommentForm')[0].reset();//Clear form
                    var posts = $('#profilePosts');
                    posts.load(document.URL +  ' #profilePosts');//Refresh div with posts
                }
            });
    
        });
    });
});