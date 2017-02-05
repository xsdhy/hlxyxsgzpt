<!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>跳转提示</title>
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp"/>
  <link rel="stylesheet" href="__PUBLIC__/assets/css/amazeui.min.css">
  <link rel="stylesheet" href="__PUBLIC__/assets/css/app.css">
</head>
<body>



<div class="am-panel am-panel-default">
  <div class="am-panel-hd">
    <?php if(isset($message)) {?>
    <h3 class="am-panel-title"><?php echo($message); ?></h3>
    <?php }else{?>
    <h3 class="am-panel-title"><?php echo($error); ?></h3>
    <?php }?>
  </div>
  <div class="am-panel-bd">
    <p>页面自动 <a id="href" href="<?php echo($jumpUrl); ?>">跳转</a> 等待时间： <b id="wait"><?php echo($waitSecond); ?></b></p>
  </div>
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
