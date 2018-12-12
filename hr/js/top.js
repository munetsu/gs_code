// ヘッダ部分のアコーディオン
$('.sideicon').on('click',function(){
    $('.hide').slideToggle();
});


// ナビ部分のマウスホバー処理
$('.menuicon').hover(function(){
    $(this).next('span').css('display','block');
},function(){
    $(this).next('span').css('display','none');
});


