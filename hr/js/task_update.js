let options = {
    title: "Success!", 
    text: "お疲れ様でした",  
    type: "success",   
    confirmButtonText: "OK",
}


$(function(){
    swal(options).then(function(val){
    if(val){
        // OKボタンが押された処理
        location.href="top.php";
    };
    });
});