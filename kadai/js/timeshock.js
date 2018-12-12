$(function(){
    $('#action').on('click',function(){
        $(this).toggleClass('motion');
        // setTimeout(function(){
        //     $('#action').html('<img src="img/timeover.jpg" class="timeover">');
        //     alert("タイムオーバー");
        // }
        // ,10000);
        startTimer();
    });
});

// タイマーセット
let rest = 10; //タイマーの秒数
let timerID; //setInterval用変数

// 残り時間を表示
const countDown = function(){
    rest--; //残り時間を1減らす
}

// タイマースタート関数
let startTimer = function(){
    clearInterval(timerID); //カウントダウンの重複を防ぐため、今動いているタイマーをリセット
    timerID = setInterval(function(){
        if(rest <= 0){
            $('#action').html('<img src="img/timeover.jpg" class="timeover">');
            alert("タイムオーバー");
            clearInterval(timerID);
        } else {
            countDown();
            $('#resttime').text(`残り時間${rest}秒です`);
        }
    },1000);
}