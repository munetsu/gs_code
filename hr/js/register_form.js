// メールアドレス形式確認
let address = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

// メールアドレス入力後にチェック
$(function(){
    $('#mail').blur(function(){
        if(!$(this).val().match(address)){
            $(this).after('<p style="color:red;margin-top:5px;font-size:12px;" id="mailerror">メールアドレスの形式が異なります</p>');
        }
    }).focus(function(){
        $('#mailerror').remove();
    })
})


$('#submit').on('click',function(){
    let ad = $('#mail').val();
    let pw = $('#pw1').val();
    let pw2 = $('#pw2').val();
    $('#passerror').remove();
    if(pw != pw2){
        $('#pw2').after('<p style="color:red;margin-top:5px;font-size:12px;" id="passerror">パスワードが異なります</p>');
        swal({
                position:'center',
                title: "Error!",   
                text: "パスワードが異なっています",  
                type: "error",   
                confirmButtonText: "OK"
        });
        $('#pw1').val('');
        $('#pw2').val('');
        return false;
    }else if(ad == ''){
        swal({
            position:'center',
            title: "Error!",   
            text: "アドレスが未記入です",  
            type: "error",   
            confirmButtonText: "OK"
        });
        return false;
    }
})

