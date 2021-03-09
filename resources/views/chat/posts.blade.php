@extends('layouts.app')
@section('content')
            <div class="content">
                <div class="title m-b-md">
                    Посты
                </div>
               <hr>
			   @foreach ($posts as $post)
			<div style="border: 1px solid rgba(0,0,0,0.25);border-radius:2px; padding:10px;box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);">			 
                <p>{!! $post->data !!}</p>
           <p>{{ $post->created_at }}</p>
		   
		     <a href="<?=url("/postupdate/$post->id")?>"><i class="fas fa-edit mr-1"></i></a>
			 <td><a href="<?=url("/postchat/$post->id")?>"><i class="fas green fa-envelope mr-1"></i></a></td>
			  <span onclick="trash(<?=$post->id?>)"><i class="fas fa-trash mr-1"></i></span> 
			  </div>
			   <hr><br><br>	
			   @endforeach			   
			   <!--    <form method="POST" action="/chat/message">-->
				<form onsubmit="return false;" action="/posts/add" method="POST">
				    {{ csrf_field() }}        
				    <div id="body" class="col-12">
                    	</div><hr>					
						<div id="toolbar">
						<button class="ql-bold"></button>
						<button class="ql-italic"></button>
						<button class="emojiButton icon-smiley"><img src="https://twemoji.maxcdn.com/2/svg/1f603.svg"></button>
						<button class="ql-video"></button>
						<button class="ql-image"></button>
						<button class="ql-underline"></button>
						<button class="ql-strike"></button>
						<button class="ql-link"></button>
						<button class="ql-size"></button>
						</div><hr>
						<select class="form-control" name="category_id" id="category_id">
							<?php foreach ($categories as $category) :?>
							<option value="<?=$category->id?>"><?=$category->name?></option>
							<?php endforeach; ?>
						</select><hr>
						<input type="checkbox" name="isComments" id="isComments" value="1">Разрешить коментарии<br><hr>						
                   <input autofocus type="submit" id="posts" class="save-data" value="Отправить">
               </form>
            </div>
        </div>
		</div>  
	 <script>
        $(document).ready(function () {
			
			
	
		var myEditor = new Quill("#body", {
  modules: {
    toolbar: document.getElementById("toolbar")
  },
  placeholder: "Печатайте...",
  theme: "snow" // or 'bubble'
});
			
	const insertEmoji = function() {
  let editorSelection = myEditor.getSelection();
  const cursorPosition = editorSelection && editorSelection.index ? editorSelection.index : 0;
  myEditor.insertEmbed(cursorPosition, "emoji", 'icon icon-smiley');
  myEditor.setSelection(cursorPosition + 1);
};
document.querySelector(".emojiButton").addEventListener("click", insertEmoji);		
			
			
			
                    var options = {
            	modules: {
                toolbar: [
                  ['bold', 'italic', 'underline', 'strike',],
                  ['blockquote', 'code-block'],
                  ['link', 'image', 'video', 'formula', 'size'],
                  [{ 'size': ['small', false, 'large', 'huge'] }],
                  [{ 'script': 'sub'}, { 'script': 'super' }], 
                  [{ 'color': [] }, { 'background': [] }],  
                  [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    [{ 'align': [] }],
                     ['clean'],
                       [{ 'indent': '-1'}, { 'indent': '+1' }], 
                  [{ list: 'ordered' }, { list: 'bullet' }],
['customControl'],



                ]
              },
			  handlers: {
        'customControl': () => { document.getElementById("toolbar") }
      },
			  
              placeholder: 'Введите сообщение',
              theme: 'snow'
            };
   const Embed = Quill.import("blots/embed");
   
   
   class EmojiBlot extends Embed {
  static create(classes) {
    let node = super.create();
    classes.split(" ").forEach(iconClass => {
      node.classList.add(iconClass);
    });
    return node;
  }

  static formats(node) {
    let format = {};
    if (node.hasAttribute("class")) {
      format.class = node.getAttribute("class");
    }
    return format;
  }

  static value(node) {
    return node.getAttribute("class");
  }

  format(name, value) {
    if (name === "class") {
      if (value) {
        this.domNode.setAttribute(name, value);
      } else {
        this.domNode.removeAttribute(name, value);
      }
    } else {
      super.format(name, value);
    }
  }
}
   
   
   
   
   EmojiBlot.blotName = "emoji";
EmojiBlot.tagName = "img";
Quill.register({
  "formats/emoji": EmojiBlot
});
   
   
     //       var editor = new Quill('#body', options);  
			
  
			
			
			  // const insertEmoji = function() {
  // let editorSelection = editor.getSelection(); 
  // const cursorPosition = editorSelection && editorSelection.index ? editorSelection.index : 0;
  // editor.insertEmbed(cursorPosition, "emoji", 'icon icon-smiley');
  // editor.setSelection(cursorPosition + 1);
// };

  $(".emojiButton").click(function(){ 
	  insertEmoji;
  });
			
            $("#posts").bind("click", function () { 
				   
				if ($('#isComments').is(':checked')){
					var isComments = 1; 
				} else {
					var isComments = 0; 
				}  

				var category_id = $('#category_id').val();
				var _token   = $('meta[name="csrf-token"]').attr('content');
				var justHtml = myEditor.root.innerHTML;
             
                    $.ajax({
                    url: "/posts/add",
                    type: "POST",
                    data: ({
							_token: _token,
							isComments:isComments,
							category_id:category_id,
							data: justHtml
					}),
						dataType: "html",
						success: function (data) { 
						window.location.reload();
							if (data == "True") {
								swal("Успешно", "Имя блога зарегистрировано", "success");
								setTimeout(function () {
								window.location.reload();
								}, 3000);				
							} else if (data == "False") {
								swal("Ошибка", "Имя блога не зарегистрировано", "error");
							}					
						}
					})
         
            });
            
          
			
			
		
		
		
		});
		

			function trash(id){			
					  swal({
					  title: 'Вы уверены?',
					  text: "Удалить?",
					  type: 'warning',
					   icon: "success",
					  showCancelButton: true,
					  confirmButtonColor: '#3085d6',
					  cancelButtonColor: '#d33',
					  confirmButtonText: 'Yes, delete it!'
					}).then(function(res) {
						if(res){
							 var _token   = $('meta[name="csrf-token"]').attr('content');
							  $.ajax({
									type: 'POST',
											url:'/posts/delete',
									data:{_token: _token, id:id},				   
									success: function (data) 
									{
										if(data.msg)
										{
											  swal(
												'Удалено',
												'',
												'success'
											  );
											  
											  setTimeout(function() {window.location.reload();}, 2000);
										}  
									}
								})
						}
					})
				return false;
			}

		

			
                var socket = io(':6050'),
				channel = 'chat:message';
               // /*
               // socket.on('message', function(data){
                   // console.log('Messagae', data);
               // }).on('news', function(data){
                   // console.log(data);
               // });
              // */
              
			  socket.on('connect', function(){
				  socket.emit('subscribe', channel);
			  });
			  
			  socket.on('error', function(error){
				  console.warn('Error', error);
			  });
			  
			   socket.on('message', function(message){
                   console.info(message);
               });
			  
			  
              function appendChat(data, id){
				  
			//	  $('#signal' + id).css("background", "green");
				  
			  if (!data.is_admin) {
					$('#signal' + data.autor).css("background", "green");
					$('#balls').css("display", "block");
				  }	 



				 
if (data.autor == id) {
	/*
	$('.chat').append(
				$('<li></li>').text(data.autor  + ' - ' + data.content )

				); 
				*/
				
	
	
	
	
var date = new Date();

	var str_date = date.getFullYear() + '-' + date.getMonth() + '-' + date.getDate() + ' ' +date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds();
				
	
		
				var dark = '';
				var time_ = 'time-right';
				var right_ = '';
					var photo = '/public/image/222.jpg';
			if (data.is_admin) {
				 dark = 'darker';
				 time_= 'time-left';
				 var right_ = 'class="right"';
				 	var photo = '/public/image/photo3.jpg';
			}	
				
	$('.chat').append(
	
	$('<li></li>').html(
				'<li>   <div class="container ' +dark+ '"><img src="' +photo+ '" alt="Avatar" ' + right_ + '>'+
'<p>' + data.content + '</p>'+
  '<span class="' + time_ + '">' + str_date + '</span>'+
'</div></li>')
); 
						
}
				




              };
                   
				   

				   
				
				   
				   
     
              /*
               socket.on("chat:message", function(data){
             //         appendChat(data);
		//		  console.log(data);
               });
              */
// $(document).ready(function(){
	// $('#ff').click(function(){


     // var content = $("#content").val();
        // var autor = $("#autor").val();
   // var _token   = $('meta[name="csrf-token"]').attr('content');

	// $.ajax({
              // type:'POST',
              // url:'/chat/message',
      // //   data:{_token: _token, autor:autor, content:content},
              // success:function(data){

// //console.log(data);
				
              // }
           // });
// });
// });


	         
	var t =  function (){
				
 
        var content = $("#content").val();
        var autor = $("#autor").val();
   var _token   = $('meta[name="csrf-token"]').attr('content');
     
           
				   
 
				   
 $.ajax({
              type:'POST',
              url:'/chat/message',
         data:{_token: _token, autor:autor, content:content, is_admin:1},
              success:function(data){

//console.log(data);
				
              }
           });
		   
		//   return false;
	  };
				   
             socket.on("chat:message", function(data){
                      appendChat(data, id);
		//		  console.log(data);
               });
              
           </script>
        	
@endsection