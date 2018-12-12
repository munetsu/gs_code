// Firebaseとの接続するための変数
const newPostRef = firebase.database();

// PHPからのデータを変数化
let talkname = client['todo'];
client = client['name'];
let photo = client['photourl']

// ログインユーザー情報
let lid = loginuser['lid'];
let luser = loginuser['luser'];
let lurl = loginuser['lurl'];

// 入力されたテキストをFirebaseに保存
$('#submit').on('click',function(){
    //トーク名取得
    newPostRef.ref(talkname).push({
        date: date,
        id:lid,
        user: luser,
        url:lurl,
        text: $('#mes').val() //送信テキスト内容取得
    });
    $('#mes').val('');
})

// Firebaseデータ受信処理
$(function(){
    // userinfo();
    let count = 0;
    let textarea = [];
    newPostRef.ref(talkname+'/').on('child_added',function(data){
        let v = data.val();
        // データが空の場合
        if(v ==null){
            return;
        }
        
        let string ="";
            string += '<div class="mblock">';
                string += '<div class="mimage">';
                    string += '<img src="'+v.url+'" class="uimg">';
                string += '</div>';
                string += '<div class="marea">';
                    string += '<div class="mname">';
                        string += '<p>'+v.user+'</p>';
                    string += '</div>';
                    string += '<div class="mtext">';
                        string += '<textarea cols=40 wrap="hard" class="talktext" id="message'+count+'">'+v.text+'</textarea>';
                    string += '</div>';
                string += '</div>';
            string += '</div>';

            $('#chatbody').append(string);

            // 一番下までスクロールする
            $('#chatbody').animate({scrollTop: $('#chatbody')[0].scrollHeight}, 'fast');
            
            // // let test = textarea.push($("[class=talktext]").val());
            // let test = $("[id=message"+count+"]").val();
            // textarea.push(test)
            // // if( textarea.scrollHeight() > textarea.offsetHeight() ){
            // //     textarea.style.height = textarea.scrollHeight+'px';
            // // }
            // console.log(textarea);    
            // count ++;
            // console.log(count)

    });
});



