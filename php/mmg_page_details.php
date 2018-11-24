<?php wp_enqueue_style('mmg-dd-css'); ?>
<div class="wrap dl-wrap">
	<h1 class="wp-heading-inline">Design Data Details</h1>

	<a href="?page=mmg_design_data" class="page-title-action">Go Back</a>
	<hr class="wp-header-end">
	
	
	<div id="dd-header">
		<div class="dd-box dd-icon icon-user">
			<span class="dd-label">User</span>
			<span class="dd-data">
				<?php echo get_userdata( $data->user_id )->user_login ?>
			</span>
		</div>
		<div class="dd-box dd-icon icon-order">
			<span class="dd-label">Order Number</span>
			<span class="dd-data">
				<a href="<?php echo admin_url('post.php?post=' . $data->order_number .'&action=edit') ?>"><?php echo $data->order_number ?></a>	
			</span>
		</div>
		<div class="dd-box dd-icon icon-sku">
			<span class="dd-label">Product SKU</span>
			<span class="dd-data">
				<?php echo $data->product_sku; ?>
			</span>
		</div>
		<div class="dd-box dd-icon icon-template">
			<span class="dd-label">Design Template</span>
			<span class="dd-data">
				<a href="<?php echo admin_url('admin.php?page=mmg_design_template_add&e=' . $data->design_template ) ?>"><?php echo mmg_design_template_get($data->design_template)->name ?></a>	
			</span>
		</div>
		<div class="dd-box dd-icon icon-snapshot">
			<span class="dd-label">Design Snapshot</span>
			<span class="dd-data">
				<a href="<?php echo admin_url('admin.php?page=mmg_design_snapshots&e=' . $data->design_snapshot ) ?>"><?php echo mmg_design_snapshots_get($data->design_snapshot)->product_name ?></a>
			</span>
		</div>
	</div>


	<div id="dd-json">
		<h2>Data (JSON)</h2>
		<div class="dd-json-data">
			<?php echo mmg_design_data_pretty_json(stripslashes($data->data_json)); ?>
		</div>
	</div>


</div>