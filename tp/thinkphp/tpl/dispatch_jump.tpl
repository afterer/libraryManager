<html>
<head>
  <title>图书馆选座系统</title>
  <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0" />
</head>
 <body>
   

    <div class="successsystem">
        <?php if($code == 1) {?>
            <img src="__STATIC__/images/icogantanhao.png"></div>
        <?php }else{ ?>
            <img src="__STATIC__/images/icogantanhao-sb.png"></div>
        <?php }?>
    </div>
    <p class="prompt_s">
        <?php if($code == 1) {?><?php echo(strip_tags($msg)); ?>
        <?php }else{?>
        <?php echo(strip_tags($msg)); ?>
        <?php }?> ，等待时间：<b id="wait"><?php echo($wait); ?></b>
    </p>

    <div class="systemprompt">
        <a href="<?php echo($url); ?>" id="href">返回上一页</a>
        <a href="#">返回首页</a>
    </div>
<script type="text/javascript">
    (function(){
        var wait = document.getElementById('wait'),href = document.getElementById('href').href;
        var interval = setInterval(function(){
            var time = --wait.innerHTML;
            if(time <= 0) {
                location.href = href;
                clearInterval(interval);
            };
        }, 1000);
    })();

</script>
</body>
</html>
