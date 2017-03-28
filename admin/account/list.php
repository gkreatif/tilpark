<?php include('../../tilpark.php'); ?>
<?php get_header(); ?>
<?php
add_page_info( 'title', 'Hesap Kartları Listesi' );
add_page_info( 'nav', array('name'=>'Hesap Yönetimi', 'url'=>get_site_url('admin/account/') ) );
add_page_info( 'nav', array('name'=>'Hesap Kartları Listesi') );
?>


<?php

function rastgeleYazi($uzunluk = 10) {
    $karakterler = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $karakterlerUzunlugu = strlen($karakterler);
    $rastgele = '';
    for ($i = 0; $i < $uzunluk; $i++) {
        $rastgele .= $karakterler[mt_rand(0, $karakterlerUzunlugu - 1)];
    }
    return $rastgele;
}




for($i=0; $i<=-100000; $i++) {
	$array=array();
	$array['type'] = 'account';
	$array['name'] = rastgeleYazi(20);
	$array['code'] = rastgeleYazi(20);
	$array['email'] = 'example@tilpark.com';
	$array['gsm'] = '535'.rand(1111111,9999999);
	$array['phone'] = rand(1111111111,9999999999);
	$array['address'] = rastgeleYazi(250);
	$array['tax_home'] = rastgeleYazi(20);
	$array['tax_no'] = rand(1111111111,9999999999);
	add_account($array);
}



?>



<?php 
// ilk liste acilisinde sıralama yapilmasi icin
if(!isset($_GET['orderby_name'])) {
	$_GET['orderby_name'] = 'name';
	$_GET['orderby_type'] = 'ASC'; 
}

$accounts = get_accounts(array('_GET'=>true)); ?>

<div class="panel panel-default panel-table">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-6">
				<h3 class="panel-title">Hesap Kartları</h3>
			</div> <!-- /.col-md-6 -->
			<div class="col-md-6">
				<div class="pull-right">
					
					<?php
						// panel arama
						$arr_s = array();
						$arr_s['s_name'] = 'accounts';
						$arr_s['db-s-where'][] = array('name'=>'Hesap Adı', 'val'=>'name');
						$arr_s['db-s-where'][] = array('name'=>'Hesap Kodu', 'val'=>'code');
						$arr_s['db-s-where'][] = array('name'=>'Cep Telefonu', 'val'=>'gsm');
						$arr_s['db-s-where'][] = array('name'=>'Sabit Telefon', 'val'=>'phone');
						$arr_s['db-s-where'][] = array('name'=>'Şehir - İl', 'val'=>'city');
						$arr_s['db-s-where'][] = array('name'=>'Vergi veya T.C. No', 'val'=>'tax_no');
						search_form_for_panel($arr_s); 
					?>
				

					<!-- Single button -->
					<div class="btn-group btn-icon" data-toggle="tooltip" data-placement="top" title="Pdf">
					  <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    <i class="fa fa-file-pdf-o"></i>
					  </button>
					  <ul class="dropdown-menu dropdown-menu-right">
					  	<li class="dropdown-header"><i class="fa fa-download"></i> PDF AKTAR</li>
					    <li><a href="<?php echo str_replace('list.php', 'export.php', set_url_parameters(array('add'=> array('export'=>'pdf')))); ?>">Aktif Listeyi Aktar</a></li>
					    <li><a href="<?php echo str_replace('list.php', 'export.php', set_url_parameters(array('add'=> array('export'=>'pdf', 'limit'=>'false')))); ?>">Hepsini Aktar <sup class="text-muted">(<?php echo $accounts->num_rows; ?>)</sup></a></li>
					  </ul>
					</div>


					<!-- Single button -->
					<div class="btn-group btn-icon" data-toggle="tooltip" data-placement="top" title="Excel">
					  <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    <i class="fa fa-file-excel-o"></i>
					  </button>
					  <ul class="dropdown-menu dropdown-menu-right">
					  	<li class="dropdown-header"><i class="fa fa-download"></i> EXCEL AKTAR</li>
					    <li><a href="<?php echo str_replace('list.php', 'export.php', set_url_parameters(array('add'=> array('export'=>'excel')))); ?>">Aktif Listeyi Aktar</a></li>
					    <li><a href="<?php echo str_replace('list.php', 'export.php', set_url_parameters(array('add'=> array('export'=>'excel', 'limit'=>'false')))); ?>">Hepsini Aktar <sup class="text-muted">(<?php echo $accounts->num_rows; ?>)</sup></a></li>
					  </ul>
					</div>


					<!-- Single button -->
					<div class="btn-group btn-icon" data-toggle="tooltip" data-placement="top" title="Yazdır">
					  <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    <i class="fa fa-print"></i>
					  </button>
					  <ul class="dropdown-menu dropdown-menu-right">
					  	<li class="dropdown-header"><i class="fa fa-file-o"></i> YAZDIR</li>
					    <li><a href="<?php echo str_replace('list.php', 'export.php', set_url_parameters(array('add'=> array('export'=>'print')))); ?>" target="_blank">Aktif Listeyi Yazır</a></li>
					    <li><a href="<?php echo str_replace('list.php', 'export.php', set_url_parameters(array('add'=> array('export'=>'print', 'limit'=>'false')))); ?>" target="_blank">Hepsini Yazdır <sup class="text-muted">(<?php echo $accounts->num_rows; ?>)</sup></a></li>
					  </ul>
					</div>

				</div>
			</div> <!-- /.col-md-6 -->
		</div> <!-- /.row -->
	</div> <!-- /.panel-heading -->

	<?php if($accounts): ?>
		<table class="table table-hover table-bordered table-condensed table-striped">
			<thead>
				<tr>
					<th>Hesap Adı <?php echo get_table_order_by('name', 'ASC'); ?></th>
					<th>Hesap Kodu <?php echo get_table_order_by('code', 'ASC'); ?></th>
					<th>Cep Telefonu <?php echo get_table_order_by('gsm', 'ASC'); ?></th>
					<th>Sabit Telefon <?php echo get_table_order_by('phone', 'ASC'); ?></th>
					<th>Şehir <?php echo get_table_order_by('city', 'ASC'); ?></th>
					<th>Bakiye <?php echo get_table_order_by('balance', 'ASC'); ?></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($accounts->list as $account): ?>
				<tr>
					<td><a href="detail.php?id=<?php echo $account['id']; ?>"><?php echo $account['name']; ?></a></td>
					<td><?php echo $account['code']; ?></td>
					<td><?php echo $account['gsm']; ?></td>
					<td><?php echo $account['phone']; ?></td>
					<td><?php echo $account['city']; ?></td>
					<td class="text-right"><?php echo get_set_money($account['balance'], true); ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		
		<?php pagination($accounts->num_rows); ?>

	<?php else: ?>
		<div class="not-found">
			<?php print_alert(); ?>
		</div> <!-- /.not-found -->
	<?php endif; ?>

</div> <!-- /.panel -->



<?php get_footer(); ?>