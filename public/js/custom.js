function setclick(post_id){
	var _token   = $('meta[name="csrf-token"]').attr('content');
		$.ajax({
			type:'POST',
			url:'/posts/setclick',
			data:{_token: _token, post_id:post_id},
			success:function(data){
				$('#click' + post_id).text(data.count_likes_posts);
			}
		});			
	return false;
}