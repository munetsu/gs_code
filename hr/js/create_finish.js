let options = {
    title: "Success!", 
    text: "タスク作成が完了しました",  
    type: "success",   
    confirmButtonText: "OK",
}


$(function(){
    swal(options).then(function(val){
    if(val){
        // OKボタンが押された処理
        location.href="../top.php";
    };
    });
});