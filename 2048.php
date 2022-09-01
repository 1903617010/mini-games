<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>2048</title>
    <style>
        .div_border {
            width: 400px;
            height:600px;
            background-color: #E6C5CE;
            position: absolute;
            top: 100px;
            left:calc(50% - 200px);
        }
        .integral {
            margin:40px 20px;
        }

        .con{
            width: 360px;
            height:360px;
            border: 1px solid #fff;
            margin: 120px 20px 20px;
            display: flex;
            flex-wrap: wrap;
        }

        .div_block {
            width: 80px;
            height: 80px;
            margin: 5px;
            color: #7D4E33;
            font-size: 26px;
            font-weight: 600;
            line-height: 80px;
            text-align: center;
            border-radius: 5px;
            background: #f1f1f1;
        }
    </style>
    <script src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
</head>
<body>
    <div class="div_border">
        <div class="integral">当前积分: <span></span></div>

        <div class="con">

        </div>
    </div>
</body>
<script>
    let integral = 0;
    let block_num = block_number();
    let block_round = block_number(false);
    let same_key = "";
    initialize(true);
    integral_fun(0);
    // 创建起始数组
    function block_number(key=true) {
        let block_number = [];
        if(key) {
            for(let i=0; i<16; i++) {
                block_number[i] = "";
            }
        } else {
            for(let i=0; i<16; i++) {
                block_number.push(i);
            }
        }
        return block_number;
    }

    // 初始化块元素
    function initialize(start = false) {
        if(start) {
            block_num[round(block_round)] = 2;
            block_num[round(block_round)] = 2;
        }
        let con_html = '';
        block_num.forEach(function (item) {
            con_html += `<div class="div_block">${item}</div>`;
        })
        $('.con').html(con_html);
    }


    // 获取初始位置的下标
    function round(arr) {
        let rand = Math.floor( Math.random() * arr.length );
        return arr.splice(rand, 1)[0];
    }

    // 键盘事件监听
    $(document).keydown(function(event){
        switch (event.keyCode) {
            case 37 :
                // 左
                block_left();
                break;
            case 38 :
                // 上
                block_top();
                break;
            case 39 :
                // 右
                block_right();
                break;
            case 40 :
                // 下
                block_bottom();
                break;
            default :
                break;
        }
        if(!new_block()) {
            alert('game over');
        }
        initialize();
    });

    function new_block() {
        let block_null = [];
        block_num.forEach(function(item,i) {
            if(item === "") {
                block_null.push(i);
            }
        });
        if(block_null.length == 0) {
            return 0;
        }
        block_num[block_null[round(block_null)]] = 2;
        return 1;
    }

    function block_left() {
        for(let i=0; i<=3; i++) {
            for (let k=3; k>=0;k--) {
                if(block_num[i*4+k] !== "") {
                    k += same_fun(i*4+k);
                }
            }
            let kk = 1;
            for (let k=0; k<3;k++) {
                if(k+kk > 3) {
                    continue;
                }
                if( block_num[i*4+k] === "" ) {
                    if( block_num[i*4+k+kk] === "" ) {
                        kk++;
                        k--;
                    } else {
                        block_num[i*4+k] = block_num[i*4+k+kk];
                        block_num[i*4+k+kk] = "";
                        kk = 1;
                    }
                }
            }
            same_key = "";
        }
    }

    function block_top() {
        for(let i=0; i<=3; i++) {
            for (let k=3; k>=0;k--) {
                if(block_num[k*4+i] !== "") {
                    k += same_fun(k*4+i);
                }
            }
            let kk = 1;
            for (let k=0; k<3;k++) {
                if(k+kk > 3) {
                    continue;
                }
                if( block_num[k*4+i] === "" ) {
                    if( block_num[(k+kk)*4+i] === "" ) {
                        kk++;
                        k--;
                    } else {
                        block_num[k*4+i] = block_num[(k+kk)*4+i];
                        block_num[(k+kk)*4+i] = "";
                        kk = 1;
                    }
                }
            }
            same_key = "";
        }
    }

    function block_right() {
        for(let i=0; i<=3; i++) {
            for (let k=0; k<=3;k++) {
                if(block_num[i*4+k] !== "") {
                    k += same_fun(i*4+k);
                }
            }
            let kk = 1;
            for (let k=3; k>0;k--) {
                if(k-kk < 0) {
                    continue;
                }
                if( block_num[i*4+k] === "" ) {
                    if( block_num[i*4+k-kk] === "" ) {
                        kk++;
                        k++;
                    } else {
                        block_num[i*4+k] = block_num[i*4+k-kk];
                        block_num[i*4+k-kk] = "";
                        kk = 1;
                    }
                }
            }
            same_key = "";
        }
    }

    function block_bottom() {
        for(let i=0; i<=3; i++) {
            for (let k=3; k>=0;k--) {
                if(block_num[k*4+i] !== "") {
                    k += same_fun(k*4+i);
                }
            }
            let kk = 1;
            for (let k=3; k>0;k--) {
                if(k-kk < 0) {
                    continue;
                }
                if( block_num[k*4+i] === "" ) {
                    if( block_num[(k-kk)*4+i] === "" ) {
                        kk++;
                        k++;
                    } else {
                        block_num[k*4+i] = block_num[(k-kk)*4+i];
                        block_num[(k-kk)*4+i] = "";
                        kk = 1;
                    }
                }
            }
            same_key = "";
        }
    }

    function integral_fun(sum) {
        integral += sum;
        $('.integral span').html(integral);
    }

    function block_mobile(key,l,r) {
        for(let i=l; i<r; i++) {
            for (let k=r; k>-1;k--) {
                if(block_num[i*4+k] !== "") {
                    k += same_fun(i*4+k);
                }
            }
            let kk = 1;
            for (let k=l; k<r;k++) {
                if(kk > 3) {
                    continue;
                }
                if( block_num[i*4+k] === "" ) {
                    if( block_num[i*4+k+kk] === "" ) {
                        kk++;
                        k--;
                    } else {
                        block_num[i*4+k] = block_num[i*4+k+kk];
                        block_num[i*4+k+kk] = "";
                        kk = 1;
                    }
                }
            }
        }
        initialize();
    }

    function same(i,k) {
        block_num[k] += block_num[i];
        block_num[i] = "";
        same_key = "";
        integral_fun(block_num[k]);
    }

    function same_fun(key) {
        if(same_key !== "" && block_num[same_key] === block_num[key]) {
            same(same_key,key);
            return 1;
        }
        same_key = key;
        return 0;
    }
</script>
</html>