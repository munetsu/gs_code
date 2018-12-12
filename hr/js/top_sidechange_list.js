// Todoリスト記載関数
let todoinsert = function(num,area,division){
    let length = num.length;
    if(length <3){
        for(let i = 0;i <length;i++){
            // 残日数計算用
            let dead = num[i]['deadline'];
            dead = dead.replace('-','');
            dead = dead.replace('-','');
            dead = parseInt(dead,10);
            let countdown = dead - date1;

            // ユーザーリストとの照合用
            let listnum = num[i]['recipient_id'];
            listnum = parseInt(listnum,10);
            listnum = listnum - 1;
            let user_num = user_list[listnum];

            // HTMLへの記載用
            let view='';
            view += '<div class="card">';
            view += '<div class="day">';
            view += '<span class="rest">残'+countdown+'日</span>';
            view += '</div>';
            view += '<div>';
            view += '<ul class="ullist">';
            view += '<li><span>Todo名：'+num[i]['name']+'</span></li>';
            view += '<li><span>To：'+user_num+'</span></li>';
            view += '</ul>';
            view += '</div>';
            view += '</div>';
            $('.'+area+'').prepend(view);
        }
        $('.'+area+'').append('<a href="#" class="more" data-value="'+division+'">すべて見る</a>');
    } else {
        for(let i = 0; i<3;i++){
            // 残日数計算用
            let dead = num[i]['deadline'];
            dead = dead.replace('-','');
            dead = dead.replace('-','');
            dead = parseInt(dead,10);
            let countdown = dead - date1;

            // ユーザーリストとの照合用
            let listnum = num[i]['client_id'];
            listnum = parseInt(listnum,10);
            listnum = listnum - 1;
            let user_num = user_list[listnum];

            // HTMLへの記載用
            let view='';
            view += '<div class="card">';
            view += '<div class="day">';
            view += '<span class="rest">残'+countdown+'日</span>';
            view += '</div>'
            view += '<div class="ullist">'
            view += '<ul>';
            view += '<li><span>Todo名：'+num[i]['name']+'</span></li>';
            view += '<li><span>To：'+user_num+'</span></li>';
            view += '</ul>';
            view += '</div>'
            view += '</div>';
            $('.'+area+'').prepend(view);
        }
        $('.'+area+'').append('<a href="#" class="more add" data-value="'+division+'">すべて見る</a>');
    }
}


// HTMLへの書き込み
if(first != 1){
    area = 'first';
    division = 1;
    todoinsert(first, area,division);
}
if(second != 1){
    area = 'second';
    division = 2;
    todoinsert(second,area,division);
}
if(third != 1){
    area = 'third';
    division = 3;
    todoinsert(third, area,division);
}
if(fourth != 1){
    area = 'fourth';
    division = 4;
    todoinsert(fourth ,area,division);
}

// // ajax処理(Todoもっと見るをクリックした処理)
$('.more').on('click',function(){
    let important = $(this).attr('data-value');
    // console.log(important);
    // return false;
    $.ajax({
        type:"POST",
        url:"sidechange_todolist.php",
        data:{
            important:important
        },
        datatype:"html",
        success:function(data){
            $('.main').html(data);
        }
    })
})

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

// タスクのメッセージを送るボタンを押した際
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