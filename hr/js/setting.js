// 写真変更処理
let photojudge = $('#submit').val();
$('#submit').on('click',function(){
    if(photojudge == 0){
        // 初回クリック
        $('.file').css('display','block');
        photojudge = 1;
    } else {
        $('.file').css('display','none');
        photojudge = 0;
        $('#submit').attr('type','submit');
    }
})

// グラフ処理の関数
// ユーザー情報一覧-> user_all

var ctx = document.getElementById("who").getContext('2d');
var ctx2 = document.getElementById("preview").getContext('2d');

let user_name = [];
let amount = [];
let preview = [];

// 評価を表示する
$('#display').on('click',function(){
    let datestart = $('#datestart').val();
    let dateend = $('#dateend').val();
    
    // ajax処理(WHO)
    $.ajax({
        type:'POST',
        url:'analytics.php',
        data:{
            datestart:datestart,
            dateend:dateend
        },
        datatype:"html",
        success:function(data){
            // $('#who').html(data);
            // return;
            // 集計データ読み込み
            let graph = data;
            
            for(let i = 0;i<graph.length;i++){
                user_name.push(user_all[graph[i]['client_id']-1]);
                amount.push(graph[i]['COUNT(*)']);
                preview.push(graph[i]['AVG(preview)']);
            }

            console.log(amount);

            // console.log(user_name+'/'+amount+'/'+preview);
            // return;
            // 依頼者別
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: user_name,
                datasets: [{
                  label: '依頼者別',
                  data: amount,
                  backgroundColor: "rgba(135, 87, 87, 1)",
                  color: "rgba(146,181,169,1)"
                }]
                },
                //オプションの設定
                options: {
                    //軸の設定
                    scales: {
                        //縦軸の設定
                        yAxes: [{
                            //目盛りの設定
                            ticks: {
                                //開始値を0にする
                                beginAtZero:true,
                            }
                        }]
                    }
                }
            })

            // 依頼者別
            var myChart2 = new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: user_name,
                datasets: [{
                  label: '評価ランク',
                  data: preview,
                  backgroundColor: "rgba(255, 95, 10, 1)",
                  color: "rgba(146,181,169,1)"
                }]
                },
                //オプションの設定
                options: {
                    //軸の設定
                    scales: {
                        //縦軸の設定
                        yAxes: [{
                            //目盛りの設定
                            ticks: {
                                //開始値を0にする
                                beginAtZero:true,
                            }
                        }]
                    }
                }
            })
        },
        error:function(){
            $('#who').html('<div>読み込み失敗です</div>');
        }
    })

    // // ajax処理(preview)
    // $.ajax({
    //     type:'POST',
    //     url:'analytics_preview.php',
    //     data:{
    //         datestart:datestart,
    //         dateend:dateend
    //     },
    //     datatype:"html",
    //     success:function(data){
    //         $('#preview').html(data)
    //     },
    //     error:function(){
    //         $('#preview').html('<div>読み込み失敗です</div>');
    //     }
    // })
})
