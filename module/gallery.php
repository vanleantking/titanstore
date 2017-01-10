<?php include dirname(__FILE__) .'/header.php'; ?>
<div id="columns">
<?php
	$rowpage = 15;
	$curpage = 2;
	$getpage = empty($_GET['page']) ? 1 : $_GET['page'];
	$offset = ($getpage - 1) * $rowpage;
	
	$sql = "SELECT * FROM post WHERE extension = 'gallery' AND status = 1 ORDER BY created DESC";
	$db->query($sql);
	$num = $db->total();
	
	$sql = $num > 0 ? $sql ." Limit $offset, $rowpage" : $sql;
	$db->query($sql);
	$rows = $db->result();
	
	$paging = form_paging($getpage, $num, $rowpage, $curpage, site_url('gallery'), 1);
	
	if($rows)
	{
		$layout = 'gallery';
		$i = 1;
		foreach($rows as $row)
		{
			include dirname(__FILE__) .'/loop.php';
			$i++;
		}
	}
?>	
	<section><?=$paging?></section>
</div>
<?php include dirname(__FILE__) .'/footer.php'; ?>