// タスクのメッセージを送るボタンを押した際
$(document).on('click','.chat',function(){
    let task_id = $(this).attr('data-value');
    let test = $(this).attr('id');
    localStorage.setItem('task_id',task_id),
    // console.log($(this).parent().prev('form'));
    // $(this).parent().prev('form').submit();
    $("[name="+test+"]").submit(); //動的に作成したものを指定する場合は、属性セレクターを使う
        
        // ajax処理も残しておく
        // $.ajax({
        //     type:"POST",
        //     url:"chat.php",
        //     data:{
        //         task_id:task_id
        //     },
        //     datatype:"html",
        //     success:function(data){
        //         $('.main').html(data);
        //     }
        // })

});

// タスク確認するボタンを押した際
$(document).on('click','.doitnow',function(){
    let task_id = $(this).attr('data-value');
    let id = $(this).attr('id');
            
        //ajax処理も残しておく
        $.ajax({
            type:"POST",
            url:"task_doing.php",
            data:{
                task_id:task_id
            },
            datatype:"html",
            success:function(data){
                $("[id="+id+"]").text(data);
            }
        })
        $("[id="+id+"]").removeClass('doitnow');
        $("[id="+id+"]").addClass('doing');

});