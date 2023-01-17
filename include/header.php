<script type="text/javascript" charset="UTF-8" src="//cdn.cookie-script.com/s/831b41f2033b894a0caac64e0dec3cf9.js"></script><!-- start Gist JS code-->
<script>
    (function(d,h,w){var gist=w.gist=w.gist||[];gist.methods=['trackPageView','identify','track','setAppId'];gist.factory=function(t){return function(){var e=Array.prototype.slice.call(arguments);e.unshift(t);gist.push(e);return gist;}};for(var i=0;i<gist.methods.length;i++){var c=gist.methods[i];gist[c]=gist.factory(c)}s=d.createElement('script'),s.src="https://widget.getgist.com",s.async=!0,e=d.getElementsByTagName(h)[0],e.appendChild(s),s.addEventListener('load',function(e){},!1),gist.setAppId("zmafcg9f"),gist.trackPageView()})(document,'head',window);
</script>
<!-- end Gist JS code-->
<?php
//We have two header so you can set per your choice
$header = 1; //place here 1 or 2
if($header>0) {
  require_once('header/header'.$header.'.php');
} else {
  require_once('header/header1.php');
}
?>