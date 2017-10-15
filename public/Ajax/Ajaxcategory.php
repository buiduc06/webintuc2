<?php 
 
include_once ('../../Models/LoaiTin.php');
include_once ('../../Models/TinTuc.php');

if (isset($_GET['q'])!=TRUE) {

}else{
	$q=intval($_GET['q']);
$page3= TinTuc::sqlbullder(["SELECT * FROM tintuc WHERE id>0 AND idLoaiTin=$q LIMIT 0,10"]);
// $getbody3=TinTuc::whereLimit(['idLoaiTin',"$q",'1','2']);  


?>


<?php foreach ($page3 as $page4 ) {
?>

<div class="td_module_10 td_module_wrap td-animation-stack">
<div class=td-module-thumb>
<a href="page.php?id=<?= $page4->id ?>" rel=bookmark title="<?= $page4->TieuDe ?>">
<img width=218 height=150 class=entry-thumb src="image/tintuc/<?= $page4->Hinh ?>" alt="" title="<?= $page4->TieuDe ?>" /></a></div>
<div class=item-details>
<h3 class="entry-title td-module-title">
<a href="page.php?id=<?= $page4->id ?>" rel=bookmark title="<?= $page4->TieuDe ?>"><?= $page4->TieuDe ?></a></h3>
<div class=td-module-meta-info>
<a href="category.php?id=<?= $page4->GetLoaiTin()->id ?>" class=td-post-category><?= $page4->GetLoaiTin2()->Ten ?></a> <span class=td-post-author-name><a href="author.php?id=<?= $page4->getTacGia()->id ?>"><?= $page4->getTacGia()->name ?></a> <span>-</span> </span> <span class=td-post-date><time class="entry-date updated td-module-date" datetime="2015-09-16T08:57:18+00:00">September 16, 2015</time></span> <div class=td-module-comments>
<a href="../../td-post-sanders-gets-respectful-welcome-at-conservative-college/index.html#comments">1</a></div> </div>
<div class=td-excerpt>
<?= $page4->TomTat ?>...
</div>
</div>
</div>


<?php } ?>
<?php } ?>