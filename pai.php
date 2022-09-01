<?php
$pai = array_merge(range(1,9),range(1,9));
shuffle($pai);
$count = count($pai);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>翻牌</title>
    <style>
        .box {
            width:150px;
            height:180px;
            background:#a1cfff;
            margin:10px;
            text-align: center;
            line-height: 180px;
            font-size: 24px;
            display: inline-block;
            position: relative;
            transition: all 1s;
            /* 这个必须要写，否则子盒子的3D效果显示不出来。 */
            transform-style: preserve-3d;
        }

        .pai{
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .null{
            background-color: #fea000;
            z-index:1;
        }

        .val{
            background-color: #0baefd;
            transform: rotateY(180deg)
        }

        .pai_show{
            transform: rotateY(180deg);
        }
    </style>
    <script src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
</head>
<body style="background-color: #f1f1f1;">
<div style="width:80%;height: 80%;margin:10%">
    <?php for($i=0;$i<$count;$i++){ ?>
        <div class="box">
            <div class="pai val"><?php echo($pai[$i])  ?></div>
            <div class="pai null"></div>
        </div>
    <?php } ?>
</div>
</body>
<script>
    let dis_index = [];
    let com = 0;
    $('.box').click(function () {
        let that = $(this);
        // 如果是背面则调用模式一/二
        if(that.attr('dis') != 1){
            // 展示
            pai_show(that);
            // 数组处理
            setTimeout(function () {
                m1(that);
            },1000)
        }
    })

    function pai_show(that) {
        that.addClass("pai_show");
        that.attr({'dis':1});
    }

    function m1(that) {
        switch (dis_index.length) {
            case 0 :
                dis_index.push(that.index());
                break;
            case 1 :
                dis_index.push(that.index());
                compare();
                if(com) {
                    pai_hidden();
                } else {
                    pai_restore();
                }
                dis_index = [];
                break;
            default :
                pai_restore();
                dis_index = [];
                m1(that);
                break;
        }
    }

    function compare() {
        let dis1 = $('.box').eq(dis_index[0]).children('.val').html();
        let dis2 = $('.box').eq(dis_index[1]).children('.val').html();

        if(dis1 == dis2) {
            com = 1;
        } else {
            com = 0;
        }
    }

    function pai_hidden() {
        dis_index.forEach(function (item,i) {
            $('.box').eq(item).children().hide();
        })

    }

    function pai_restore() {
        dis_index.forEach(function (item,i) {
            $('.box').eq(item).removeClass('pai_show');
            $('.box').eq(item).attr({'dis':0});
        })
    }
</script>
</html>
