<?php
	
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	foreach($_POST['id'] as $id)
	{
        $rows = get_posts('size', array('parent' => $id));
        if($rows){ $i = 1; ?>
			<div class="form-group">
				<label class="col-sm-2 control-label">&nbsp;</label>
				<div class="col-sm-6">
					<table class="table table-hover table-striped" style="margin-bottom: 0;">
						<tbody>
						<?php foreach($rows as $row){ ?>
							<tr>
								<td width="10%"><input type="checkbox" name="size[]" value="<?=$row->id?>"></td>
								<td width="45%"><?=@$row->title?></td>
								<td width="45%"><input type="text" class="form-control" name="fields[<?=$row->id?>][size]" value=""></td>
							</tr>
						<?php $i++; } ?>
						</tbody>
					</table>
				</div>
			</div>
<?php
		}
	}
}