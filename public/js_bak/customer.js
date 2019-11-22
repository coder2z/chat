$(function () {
    var ws = new WebSocket("ws://"+'chat.zerotsu.cn'+":8282");
    var userId = $(".index_news_r").attr("id");
    var userName = $(".head_right_r").html();
    // var serId = 1;
    // var serName = "蒋武君";
    var serId = $("#serId").val();
    var serName = $("#serName").val();
    ws.onopen = function (e) {
        $('#sendButton').click(function () {
            var inputValue = $(".index_text").html().replace(/&nbsp;/g, "");
            var str = inputValue.replace(/(^\s*)|(\s*$)/g, '');//去除空格;
            str=str.replace(/"/g,"'");
            if (str != "") {
                var message = '{"data":"' + str + '","type":"say","fromId":"' + userId + '","toId":"' + serId + '","fromName":"' + userName + '","toName":"' + serName + '"}';
                let html = `<div class="index_news_r">
                    <div class="index_news_img_r"><img src="img/handPortrail_03.jpg" class="right-suer"></div>
                    <div class="index_border_right"></div>
                    <div class="index_terr_r">
                        <div>${str}</div>
                    </div>
                </div>`;
                if (isJsonString(message)){
                    $('.index_dialog').append(html);
                    ws.send(message);
                    save_message(eval("(" + message+ ")"));
                    $(".index_text").html("");
                }else{
                    alert('输入格式错误！')
                }
            } else {
                $(".index_text").html("");
            }
            $('.index_dialog').animate({scrollTop:10000000000000},0);
        });
        ws.onmessage = function (e) {
            var message = eval("(" + e.data+ ")");
            switch (message.type) {
                case "init":
                    var bind = '{"fromid":"' + userId + '","type":"bind"}';
                    ws.send(bind);
                    break;
                case "text":
                    $('.index_dialog').append(`<div class="index_news">
                    <div class="index_news_img"><img src="img/ser.png" class="user-head"></div>
                    <div class="index_border_left"></div>
                    <div class="index_terr">
                        <div>${message.data}</div>
                    </div>
                </div>`);
                    break;
            }
            $('.index_dialog').animate({scrollTop:10000000000000},0);
        }
    }
});

function save_message(message) {
    $.ajax({
        type: 'post',
        url: '/Service/inputContent',
        data: message,
        dataType: 'json',
        success: function (Data) {
        }
    });
}


function isJsonString(str) {
    try {
        if (typeof JSON.parse(str) == "object") {
            return true;
        }
    } catch(e) {
    }
    return false;

}


