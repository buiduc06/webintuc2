
<?php 
 
include_once ('../../Models/LoaiTin.php');
include_once ('../../Models/TinTuc.php'); 
if (isset($_GET['qa'])!=TRUE) {

}else{
	$q=intval($_GET['qa']);
// $VanHoa10 =TinTuc::where(['idLoaiTin',"$q"]);
$VanHoa10 =TinTuc::whereAndwhereLimit(['id','>','0','idLoaiTin',"$q",'1','10'])
// $VanHoa10 = New BaseModel();
// $conn=$VanHoa10->getConnect();
// $queryBuilder="SELECT * FROM tintuc WHERE id>0 AND idLoaiTin=$q LIMIT 0,10";
// $stmt=$conn->prepare($queryBuilder);
// $stmt->execute();
// $VanHoa10=$stmt->fetchall();
// $getbody3=TinTuc::whereLimit(['idLoaiTin',"$q",'1','2']);  
?>

<?php foreach ($VanHoa10 as $VanHoa11) {
 ?>

<div class=td-block-span12>
<div class="td_module_10 td_module_wrap td-animation-stack">
<div class=td-module-thumb><a href="td-post-apple-tv-is-finally-changing-the-living-room/index.html" rel=bookmark title="<?= $VanHoa11->TieuDe ?>">
<img class=entry-thumb src="public/image/tintuc/<?= $VanHoa11->Hinh ?>" style="width: 218px;height: 150px" alt="" title="<?= $VanHoa11->TieuDe ?>" /></a></div>

<div class=item-details>
<h3 class="entry-title td-module-title">
<a href="#" rel=bookmark title="<?= $VanHoa11->TieuDe ?>"><?= $VanHoa11->TieuDe ?></a></h3>
<div class=td-module-meta-info>
<a href="category/tech/entertainment/index.html" class=td-post-category><?= $VanHoa11->GetLoaiTin2()->Ten ?></a> <span class=td-post-author-name><a href="author/admin/index.html">duc developer</a> <span>-</span> </span> <span class=td-post-date><time class="entry-date updated td-module-date" datetime="2015-09-16T08:52:00+00:00">September 16, 2015</time></span> <div class=td-module-comments><a href="td-post-apple-tv-is-finally-changing-the-living-room/index.html#respond">0</a></div> </div>
<div class=td-excerpt>
<?= $VanHoa11->TomTat ?></div>
</div>
</div>
</div>

<?php } ?>

<?php } ?>