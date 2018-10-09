$( document ).ready(function() {

    $(function() {
        $('#addPostBtn').click(function (e) {
            e.preventDefault();
    
            $.ajax({
                type: 'post',
                url: 'addPost.php',
                data: $('#addPostForm').serialize(),
                success: function () {
                    $('#addPostForm')[0].reset();//Clear form
                    var posts = $('#profilePosts');
                    posts.load(document.URL +  ' #profilePosts');//Refresh div with posts
                }
            });
    
        });
    });
});