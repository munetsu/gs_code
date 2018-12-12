// クリックされた時の非同期処理（依頼先選択時）
// $('#recipient').keypress(function(e){
//     if(e.which == 13){
//         $.ajax({
//             type:"POST",
//             url:"name_support.php",
//             data:{
//                 search:$('#recipient').val()
//             },
//             datatype:"html",
//             success: function(data) {
//                 $("#nameList").html(data);
//             }
//         })
//     }
// })

// 検索ボタンをクリックされた時の非同期処理（依頼先選択時）
$('#namesearch').on('click',function(){
    $.ajax({
        type:"POST",
        url:"name_support.php",
        data:{
            search:$('#recipient').val()
        },
        datatype:"html",
        success: function(data) {
            $("#photolist").html(data);
        }
    })
    $('.photolist').removeClass('close');
})

// ユーザーを選択した時の処理
$(document).on('click','.user',function(){
    let username = $(this).text();
    let userno = $(this).children('input').val();
    // console.log(userno);
    $('#recipient').val(username);
    $('#rec_no').val(userno);
    $('.user').remove();
    $('.photolist').addClass('close');
})
  

// 時間を表示させる場合
$('#timebtn').on('click',function(){
    $('#deadtime').css({
        'display':'block',
        'font-size':'16px',
        'width':'150px',
        'text-align':'center'
    });
})

// 送信時の処理
$('#submitbtn').on('click',function(){
    let title = $('#title').val();
    let deadline = $('#deadline').val();
    let name = $('#recipient').val();
    let detail = $('#detail').val();

    if(title == ''){
        $('#title').after('<p style="color:red;margin-top:5px;font-size:12px;" class="errortext">Todo名が記載されていません</p>');
        swal({
                position:'center',
                title: "Error!",   
                text: "Todo名が記載されていません",  
                type: "error",   
                confirmButtonText: "OK"
        });
    }else if(deadline == ''){
        $('#deadline').after('<p style="color:red;margin-top:5px;font-size:12px;" class="errortext">納期が記載されていません</p>');
        swal({
                position:'center',
                title: "Error!",   
                text: "納期が記載されていません",  
                type: "error",   
                confirmButtonText: "OK"
        });
    } else if(name == ''){
        $('#recipient').after('<p style="color:red;margin-top:5px;font-size:12px;" class="errortext">依頼先が記載されていません</p>');
        swal({
                position:'center',
                title: "Error!",   
                text: "依頼先が記載されていません",  
                type: "error",   
                confirmButtonText: "OK"
        });
    } else if(detail == ''){
        $('#detail').after('<p style="color:red;margin-top:5px;font-size:12px;" class="errortext">詳細が記載されていません</p>');
        swal({
                position:'center',
                title: "Error!",   
                text: "詳細が記載されていません",  
                type: "error",   
                confirmButtonText: "OK"
        });
    } else {
        $(task).submit();
    }
})

$('input').focus(function(){
    $('.errortext').remove();
})