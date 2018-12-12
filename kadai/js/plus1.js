// ランダム関数
const random = function(n){
     let m = Math.ceil( Math.random()* n);
     return m;  
};

    // $(function(){
    //     if(!confirm("クイズ画面に飛びますか？")){
    //         location.href = "login.html";
    //         return;
    //     } else {
    //         // alert("ログイン成功です");
    //         location.href = 'index.html';
    //         return;
    //     }   
    // });

// 新規登録時にログインID・PWをローカルストレージに保存
let login = [];

// ローカルストレージ情報取得関数
const get = function(){
    // ローカルストレージの既存ユーザー情報取得
    let getID = localStorage.getItem("ユーザー情報");
    login = JSON.parse(getID);
};

$('#register').on('click',function(){
    get();

    // 新規登録分
    let id = $('#loginID').val();
    let password = $('#loginPW').val();

    // 空だった場合
    if(!login){
        let first = [];
        first.push({
            ID:id,
            PW:password
        });
        let save = JSON.stringify(first);
        localStorage.setItem("ユーザー情報",save);
    } else {
        login.push({
            ID:id,
            PW:password
        });
        
        let save = JSON.stringify(login);
        localStorage.setItem("ユーザー情報",save);    
    }

    // ページ読み込み
    window.location.href = 'login.html';
});

// ログイン判定
$('#loginbtn').on('click',function(){
    get(); //ローカルストレージ情報取得
    
        if(!login){
            alert("新規登録してください");
        } else {
            for (let k = 0;k<login.length;k++){
                let id = $('#loginID').val();
                let localmemory = login[k].ID;
                // ローカルストレージとの比較
                if(id == localmemory){
                    let password = $('#loginPW').val();
                    let localmemoryPW = login[k].PW;
                    if(password == localmemoryPW){
                        if(!confirm("クイズ画面に飛びますか？")){
                            location.href = "login.html";
                            return false; //aタグの場合、falseを入れる必要あり。buttonタグの場合は、return不要
                        } else {
                            // alert("ログイン成功です");
                            location.href = 'index.html';
                            return false;
                        }   
                    } else {
                        alert("パスワードが異なります");
                        return;
                    }
                }
            }
            alert("ユーザー情報がありません");
        }
});

// 英語でのランダムパスワード作成
let alphabet = ["a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z"];
let randomPass =[];
let pass = "";

const generate = function(){
    for(let g = 0; g<8; g++){
        let set = random(alphabet.length);
        let get = alphabet[set];
        randomPass.push(get);
    };
    pass = randomPass.join(""); //文字列として結合
};

/*------------------------
* 生成PWをHTMLに反映
------------------------*/
$('#pwcreate').on('click',function(){
        for(let t = 0; t< 8; t++){
        generate();
        console.log(pass);
        $('.list').append(`<li class="pwlist">${pass}</li>`);
        randomPass = [];
    };
});

/*-------------------------------------
* ここ以降は、全てplus1.html用のため無視
---------------------------------------*/

// 配列変数 (plus1.html用)
// let array = [];
// for (let i = 1; i <=10 ;i++){
//     let test = random(100); //配列に代入する乱数を発生させる分母を決定
//     console.log("乱数母数"+test);
//     let test2 = random(test); //配列に代入する乱数を決定
//     console.log("配列代入"+test2);
//     array.push(test2); //配列に代入
// };

// $('#test').append(`<p>${array}</p>`);

// /* ----------------------------
// * 音声認識部分
// ------------------------------*/
// let
//     btn = document.getElementById('btn'),
//     info = document.getElementById('info'),

//     // 音声認識の利用
//     speech = new webkitSpeechRecognition();

// // 日本語を設定
// speech.lang = "ja";

// btn.addEventListener('click', function() {

//     // 音声認識が始まった時に行う処理を書く
//     // 音声認識の開始
//     speech.start();

// });

// speech.addEventListener('result', function(event){
//     var text = event.results[0][0].transcript;

//     // 解析された「言葉」を使った処理を書く
//     // 結果をコンソールログに出力
//     console.log(text);
//     if(text === "ひらけごま") {
//         window.open();
//   }
    

// }, false);

// /*---------------------------------
// * 問題の設置
// ---------------------------------*/
// let qs = [
//     "ダミー",
//     "ゲーム",
//     "音楽",
//     "プログラミング",
//     "ビジネス",
//     "経済",
//     "政治",
//     "芸能",
//     "健康",
//     "食事"
// ];

// // 問題をランデムで選択する
// $('#qsbtn').on('click',function(){
//     let selected = random(qs.length);
//     $('.qsno'+selected).addClass('listSelect');
//     let url = $('.qsno'+selected).attr('href');
//     let konkai = qs[selected];
//     alert(`問題は【${konkai}】に決まりました！目指せ全問正解`);
//     window.open(url);
// })