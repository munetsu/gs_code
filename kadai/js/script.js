/*----------------------------
* 配列
----------------------------*/
// 問題
const qs = [
    "カメとラクダとサイが買い物をしています。何を買うのでしょうか？",
    "ひっくり返かえると、軽かるくなる動物どうぶつなーんだ？",
    "食べると安心するケーキはなーんだ？",
    "世界の真ん中にいる虫は何？",
    "持つだけで手が震えてしまう家具ってなーんだ？",
    "ボールはボールでも、四角いボールってどんなボール？"
]

// 回答選択肢
const select = [
    ["カメラ","ビデオ","扇風機"],
    ["イルカ","サイ","カエル"],
    ["ホットケーキ","ショートケーキ","パンケーキ"],
    ["てんとう虫","クワガタ","蚊"],
    ["テーブル","椅子","ソファー"],
    ["ラグビーボール","テニスボール","ダンボール"]
]

// 回答
const ans = [1,1,1,3,1,3]

// 回答結果
let result = [];

/*--------------------------------------
* 残り回答時間のアニメーション
--------------------------------------*/

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
    rest = 10; //カウントを元に戻す
        timerID = setInterval(function(){
        if(rest <= 0){
            alert("タイムオーバー");
            clearInterval(timerID);
            save();
            window.location.reload();
        } else {
            countDown();
            $('#resttime').text(`残り時間${rest}秒です`).addClass('motion').removeClass('clearcss');
        }
    },1000);
}

// タイマーストップ
$('#stop').on('click',function(){
    clearInterval(timerID);
    $('.nokori').css("display","none");
});

/*----------------------------
* 関数化
----------------------------*/
let i = 0; //設問数他

/////////////////////////////////////////
// 問題と回答をセットする関数
const set = function(i){
    $('#quest').html(qs[i]);
    $('#toi1').html(select[i][0]);
    $('#toi2').html(select[i][1]);
    $('#toi3').html(select[i][2]);
    $('[name=toi').prop("checked",false); //ラジオボタンのチェックを外す
    startTimer();
}

// 初期セット
set(i);

////////////////////////////////////////
// タイトルに問題数をセットする関数
const title = function(i){
    $('#title').text(`第${i}問目`);
}

// 初期セット
title(i+1); //

////////////////////////////////////////
// クイズ結果を引き出す
// https://qiita.com/phi/items/3b10288b02c87057c006

let  resultArray = function(result){
    let resultArray = 0;
    result.forEach(function(elm){
        resultArray += elm;
    });
    return resultArray;
};



////////////////////////////////////////
//問題数の上限を変数として指定
let finish = 0;
const limit = function(){
    if(i < qs.length){
        title(i+1);
        // タイマーセット
        $('#resttime').removeClass('motion'); 
        $('#resttime').addClass('clearcss'); //タイマー表示を元に戻す
        set(i); //クリック後に実行する関数
    } else {
        alert("全問終了しました");
        clearInterval(timerID); //カウントダウンの重複を防ぐため、今動いているタイマーをリセット
        $('.nokori').css("display","none"); //タイマー部分の表示アウト
        $('#score').append(`<p class="kekka">あなたの正解数は${resultArray(result)}問です</p>`);
        finish = 1; //終了フラグをつける
        save(); //ローカルストレージに保存
        console.log(strage);
    }
};

//最終問題後にクリックした場合の処理
const close = function(){
    $('[name=toi]').on('click',function(){
        if(i == qs.length){
            alert("クイズは終了しています！");
        }
    })
}


/*----------------------------
* 繰り返し文
----------------------------*/
// 授業で実施した内容での処理
$('[name=toi]').on('click',function(){
    // クイズ終了後にクリックされた場合の処理
    if(finish == 1){
        alert("クイズは終了しています");
        return;
    }

    // クイズ中の処理
    if($(this).val() == ans[i]){
        alert("正解です");
        let x = 1;
        result.push(x);
        localStorage.setItem('question'+(i+1),"1");
    } else {
        alert("残念、はずれ");
        let y = 0;
        result.push(y);
        localStorage.setItem('question'+(i+1),"0");
    }
    i++; //問題送り
    limit(); //残問題数の把握
});

/*-------------------------
* ローカルストレージに保存させる
--------------------------*/
/////////////////////////////////////
// 毎回の結果をローカルストレージに保存
let strage = [];

const save = function(){
    loading();
    let string = resultArray(result).toString();
    strage.push({
        "回数":strage.length+1+"回目","結果":string
    });
    let saving = JSON.stringify(strage);
    console.log(saving);
    localStorage.setItem("result",saving);
};

/*-------------------------
* ローカルストレージからデータ抽出
--------------------------*/
//////////////////////////////////////////
//データの有無を確認
const loading = function(){
    let load = localStorage.getItem("result"); //取得
    console.log(load);
    if(!load) {
        return; //データがない場合は終了
    } else {
        strage = JSON.parse(load);
    }
}

/*--------------------------------
* 過去実績を表示させる
---------------------------------*/
$('#historyBtn').on('click',function(){
    loading(); //ローカルストレージ情報を取得
    for(let m=0; m<strage.length; m++){
        // HTML上に表示していく
        let set1 = strage[m].回数
        let set2 = strage[m].結果
        $('#seiseki').append(`<li class="seiseki">${set1}：正解数${set2}問</li>`);
    };
});