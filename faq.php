<?include("header.php");

//get error messages
$success = form($_GET["success"]);
if($success == 1) {
	$success_message = "您的信件已送出 我們會馬上跟您聯絡";
}
?>
  <?if(!empty($success_message)) {
?>
	<div id="success_message">
	<?echo $success_message?>
	</div>
<?}?>

<div id="mainbar">微‧妙‧的‧緣‧份</div>
<div id="main">
<h1>常見問題</h1>
<p>
如果有問題請<a href="contact.php?height=300" class="thickbox">與我們連絡</a>
</p>
<p>
<span class="question">
微緣的目的是什麼? 
</span>
</p>
<p>
<span class="answer">
利用科技和網路來讓人尋找生活上差一點的緣分，因此命名為『微緣』，雖然找到彼此的機會可能不大，但是暗戀沒地方發洩，也歡迎在『微緣』刊登文章</span>
</p>
<p>
<span class="question">
可是我登了以後沒有用 還是找不到對方 
</span>
</p>
<p>
<span class="answer">
皇天不負苦心人的！只要不放棄繼續努力，繼續在『微緣』刊登文章，總有找到他/她的一天，『微緣』與你同在!!
</span>
</p>
<p>
<span class="question">
我覺得對方不會想認識我，而且在PTT有神人相助，我至少還可以神到他/她的相簿
</span>
</p>
<p>
<span class="answer">
做人怎麼可以妄自菲薄呢?『微緣』相信每個人都有他/她美好的一面，所以『微緣』奉勸大家做人一定要有自信，當然有神人神到相簿很好阿，但是你寧願一輩子在暗地裡看相簿，而放棄跟他/她交朋友的機會嗎?
</span>
</p>

<p>
<span class="question">
機會好小的感覺喲，我幹麻浪費時間呀?
</span>
</p>
<p>
<span class="answer">
說來是小，可是你不試，成功的機率是 0%，但你只要登文章，那機率就是 >0%，而且看看別人的文章，可以幫別人找到人的話，可說是功德一件呢!勝造七級浮屠阿!
</span>
</p>

<p>
<span class="question">
我很需要找到那個人，有什麼辦法可以幫助我趕快找到他/她?
</span>
</p>
<p>
<span class="answer">
那趕快呼朋引伴來『微緣』，一傳十、十傳百，當然找人的機會就越來越大囉!
</span>
</p>

</div>

<?include("ads.php")?>

<?include("footer.php");?>
