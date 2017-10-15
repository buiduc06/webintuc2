<?php 
 
require_once '../../Models/LoaiTin.php';
require_once '../../Models/TinTuc.php';
 
if (isset($_GET['q'])!=TRUE) {

}else{
	$q=intval($_GET['q']);
$getBody7= TinTuc::whereLimit(['idLoaiTin',"$q",'1','2']);
$getbody2=TinTuc::whereLimit(['idLoaiTin',"$q",'2','4']); 
// $getbody3=TinTuc::whereLimit(['idLoaiTin',"$q",'1','2']);  
?>

<div class=td-block-row > 
<?php foreach ($getBody7 as $getBody71) { ?>
<div class=td-block-span6>
<div class="td_module_2 td_module_wrap td-animation-stack">
<div class=td-module-image>
<div class=td-module-thumb><a href="td-post-sanders-gets-respectful-welcome-at-conservative-college/index.html" rel=bookmark title="<?=  $getBody71->TieuDe ?>"><img width=324 height=160 class=entry-thumb src="public/image/tintuc/<?=$getBody71->Hinh ?>" alt="" title="<?=  $getBody71->TieuDe ?>" /></a>
</div> <a href="category/business/politics/index.html" class=td-post-category><?=  $getBody71->GetLoaiTin()->Ten ?></a>
 </div>
<h3 class="entry-title td-module-title"><a href="td-post-sanders-gets-respectful-welcome-at-conservative-college/index.html" rel=bookmark title="<?=  $getBody71->TieuDe ?>e"><?=  $getBody71->TieuDe ?></a></h3>
<div class=td-module-meta-info>
<span class=td-post-author-name><a href="author/admin/index.html"><?=  $getBody71->getTacGia()->name ?></a> <span>-</span> </span> <span class=td-post-date><time class="entry-date updated td-module-date" datetime="2015-09-16T08:57:18+00:00">September 16, 2015</time></span> 
<div class=td-module-comments><a href="td-post-sanders-gets-respectful-welcome-at-conservative-college/index.html#comments">1</a>
</div> 
</div>
<div class=td-excerpt>
<?=  $getBody71->TomTat ?>
 </div>
</div>
</div>

<?php } ?>
</div>
<div class=td-block-row>


<!-- câu lênh lấy ra 2 câu tiếp theo -->
<?php foreach ($getbody2 as $getBody2) { ?>


<div class=td-block-span6>
<div class="td_module_6 td_module_wrap td-animation-stack">
<div class=td-module-thumb>
<a href="td-post-the-secret-to-your-companys-financial-health/index.html" rel=bookmark title="The Secret to Your Company&#8217;s Financial Health"><img class=entry-thumb src="public/image/tintuc/<?=$getBody2->Hinh?>" style="width: 100px;height: 70px;" alt="" title="<?=  $getBody2->TieuDe ?>" /></a></div>
<div class=item-details>
<h3 class="entry-title td-module-title"><a href="td-post-the-secret-to-your-companys-financial-health/index.html" rel=bookmark title="The Secret to Your Company&#8217;s Financial Health"><?=  $getBody2->TieuDe ?></a></h3> <div class=td-module-meta-info>
<span class=td-post-date><time class="entry-date updated td-module-date" datetime="2015-09-16T08:55:16+00:00">September 16, 2015</time></span> </div>
</div>
</div>
</div>
<?php } ?>
 </div>
<div class=td-block-row>



<!-- <?php foreach ($getbody3 as $getBody3) { ?>


<div class=td-block-span6>
<div class="td_module_6 td_module_wrap td-animation-stack">
<div class=td-module-thumb><a href="td-post-boxtrade-lands-50-million-in-another-new-funding-round/index.html" rel=bookmark title="<?=  $getBody3->TieuDe ?>"><img width=100 height=70 class=entry-thumb src="image/tintuc/<?=  $getBody3->Hinh ?>" alt="" title="<?=  $getBody2->TieuDe ?>" /></a></div>
<div class=item-details>
<h3 class="entry-title td-module-title"><a href="td-post-boxtrade-lands-50-million-in-another-new-funding-round/index.html" rel=bookmark title="<?=  $getBody3->TieuDe ?>"><?=  $getBody3->TieuDe ?></a></h3> <div class=td-module-meta-info>
<span class=td-post-date><time class="entry-date updated td-module-date" datetime="2015-09-16T08:50:11+00:00">September 16, 2015</time></span>
</div>
</div>
</div>
</div>
<?php } ?>  -->
<!-- đóng vòng getbody3 -->
 </div>

<?php } ?>