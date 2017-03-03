


<?php
if(isset($_POST['update_staff_salary'])) {
	update_user_meta($user->id, 'date_start_work', $_POST['date_start_work']);
	update_user_meta($user->id, 'date_end_work', $_POST['date_end_work']);
	update_user_meta($user->id, 'net_salary', get_set_decimal_db($_POST['net_salary']));
}
$user_meta = get_user_meta($user->id);



if(isset($_POST['add_payment'])) {

}



set_staff_salary($user->id);


?>


<div class="row">
	<div class="col-md-6">

	Toplam Bakiye : <span class="text-success"><?php echo get_set_money($account->balance,true); ?></span>
	<div class="h-20"></div>
	<a href="<?php site_url('admin/payment/detail.php?out'); ?>&type=pay_salary&account_id=<?php echo $user->account_id; ?>&user_type=user" target="_blank" class="btn btn-default"><i class="fa fa-paypal"></i> Ödeme Yap</a>

		

	</div> <!-- /.col-md-6 -->
	<div class="col-md-6">

		<div class="panel panel-default">
			<div class="panel-heading"><h4 class="panel-title">İş Bilgileri</h4></div>
			<div class="panel-body">

				<form name="form_staff_salary" id="form_staff_salary" action="" method="POST">
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label for="date_start_work">İşe Başlama Tarihi</label>
								<input type="text" name="date_start_work" id="date_start_work" class="form-control date" value="<?php echo @$user_meta['date_start_work']; ?>" readonly="">
							</div> <!-- /.form-group -->
						</div> <!-- /.col-md-* -->
						<div class="col-md-3">
							<div class="form-group">
								<label for="date_end_work">İşten Ayrılma Tarihi</label>
								<input type="text" name="date_end_work" id="date_end_work" class="form-control date" value="<?php echo @$user_meta['date_end_work']; ?>" readonly="">
							</div> <!-- /.form-group -->
						</div> <!-- /.col-md-* -->
						<div class="col-md-3">
							<div class="form-group">
								<label for="net_salary">Net Maaş <small class="text-muted">(Aylık)</small></label>
								<input type="text" name="net_salary" id="net_salary" class="form-control money" value="<?php echo @$user_meta['net_salary']; ?>">
							</div> <!-- /.form-group -->
						</div> <!-- /.col-md-* -->
						<div class="col-md-3"> 
							<br />
							<input type="hidden" name="update_staff_salary">
							<button class="btn btn-default"><i class="fa fa-save"></i></button>
						</div> <!-- /.col-md-1 -->
					</div> <!-- /.row -->
				</form>

			</div> <!-- /.panel-body -->
		</div> <!-- /.panel -->

	</div> <!-- /.col-md-6 -->
</div> <!-- /.row -->



<div class="h-20"></div>

<h4 class="content-title title-line">Aylık/Çalışma/Maaş Geçmişi</h4>
<?php
$monthlys = false;
if($q_select = db()->query("SELECT * FROM ".dbname('forms')." WHERE status='1' AND type IN ('salary', 'payment') AND account_id='".$user->account_id."' ORDER BY date ASC, val_1 ASC ")) {
	if($q_select->num_rows) {
		$monthlys = _return_helper('plural_object', $q_select);
	}
}
?>

<?php if($monthlys): ?>
	<table class="table table-bordered table-condensed table-hover dataTable">
		<thead>
			<tr>
				<th width="50">ID</th>
				<th>Tarih</th>
				<th>Açıklama</th>
				<th>Hakediş</th>
				<th>Ödenen</th>
			</tr>
		</thead>
		<?php foreach($monthlys as $monthly): ?>
			<tr>
				<td><a href="salary.php?id=<?php echo $monthly->id; ?>" target="_blank">#<?php echo $monthly->id; ?></a></td>
				<td><?php echo til_get_date($monthly->date, 'datetime'); ?></td>
				<td>
					<?php if($monthly->type == 'payment'): ?>
						Ödeme
					<?php else: ?>
						<?php echo til_get_date($monthly->date, 'str: F Y'); ?> dönem hakediş
					<?php endif; ?>
				</td>
				<td class="text-right"><?php if($monthly->type != 'payment'): ?><?php echo get_set_money($monthly->total, true); ?><?php endif; ?></td>
				<td class="text-right"><?php if($monthly->type == 'payment'): ?><?php echo get_set_money($monthly->total, true); ?><?php endif; ?></td>
			</tr>
		<?php endforeach; ?>
		<tfoot>
			<tr>
				<td colspan="5" class="text-right"><?php echo get_set_money($account->balance, true); ?></td>
			</tr>
		</tfoot>
	</table> <!-- /.table -->
<?php endif; ?>

