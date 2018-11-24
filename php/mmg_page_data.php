<?php wp_enqueue_style('mmg-dd-css'); ?>
<div class="wrap dl-wrap">
	<h1 class="wp-heading-inline">Design Data</h1>
	<hr class="wp-header-end">
	
	<div class="dl-response"></div>

	<h2 class="screen-reader-text">Filter design data items list</h2>
	
	<div class="wp-filter">
		<form action="" method="get">
			<input type="hidden" name="page" value="<?php echo $_GET['page'] ?>">

			<div class="filter-items">							
				
				<div class="view-switch">
					<a href="<?php mmg_page('m.list') ?>" class="view-list <?php echo ($mode == 'list')? 'current' : '' ?>" id="view-switch-list">
						<span class="screen-reader-text">List View</span>
					</a>
					<a href="<?php mmg_page('m.grid') ?>" class="view-grid <?php echo ($mode == 'grid')? 'current' : '' ?>" id="view-switch-grid">
						<span class="screen-reader-text">Grid View</span>
					</a>
				</div>

				<label for="design-users" class="screen-reader-text">Users</label>
				<select class="sort-design-users" name="sort-design-users" id="design-users">
					<option value="">All Users</option>					
				</select>

			<div class="actions">		
				<label for="design-month" class="screen-reader-text">Month</label>
				<select class="sort-design-month" name="sort-design-month" id="design-month">
					<option value="">All Months</option>	
				</select>
				
				<input type="submit" name="design-data-form" id="post-query-submit" class="button" value="Filter">	
			</div>
		</form>
	</div>

	
	<div class="search-form">
		<label for="media-search-input" class="screen-reader-text">Search Design Data</label>
		<input type="search" placeholder="Search design data items..." id="media-search-input" class="search" name="s" value=""></div>
	</div>

	
	<div class="alignleft actions bulkactions">
		<label for="bulk-action-selector-top" class="screen-reader-text">Select bulk action</label>
		<select name="action" id="bulk-action-selector-top">
			<option value="-1">Bulk Actions</option>
			<option value="delete">Delete</option>
		</select>
		<input type="submit" id="doaction" class="button data-delete-action" value="Apply">
	</div>



	
	<h2 class="screen-reader-text">Design Data List</h2>
	<table class="wp-list-table widefat fixed striped media">


		<thead>
			<tr>
				<td id="cb" class="manage-column column-cb check-column">
					<label class="screen-reader-text" for="cb-select-all-1">Select All</label>
					<input id="cb-select-all-1" type="checkbox">
				</td>

				<th scope="col" id="user" class="manage-column column-primary sortable desc">
					<a href="#">
						<span>User</span>							
					</a>
				</th>
				
				<th scope="col" id="order-number" class="manage-column column-primary sortable desc">
					<a href="#">
						<span>Order Number</span>							
					</a>
				</th>

				<th scope="col" id="product-sku" class="manage-column column-primary sortable desc">
					<a href="#">
						<span>Product SKU</span>							
					</a>
				</th>

				<th scope="col" id="design-template" class="manage-column column-primary sortable desc">
					<a href="#">
						<span>Design Template</span>							
					</a>
				</th>

				<th scope="col" id="design-snapshot" class="manage-column column-primary sortable desc">
					<a href="#">
						<span>Design Snapshot</span>							
					</a>
				</th>

				<th scope="col" id="order-status" class="manage-column column-primary sortable desc">
					<a href="#">
						<span>Order Status</span>							
					</a>
				</th>

				<th scope="col" id="view"></th>								
			</tr>
		</thead>



		<tbody id="the-list">
		<?php foreach( $design_data as $data ): ?>



				<tr class="author-self status-inherit">
					<th scope="row" class="check-column">
						<input type="checkbox" class="dl_checkbox" name="data[]" value="<?php echo $data->id . '::' . $data->name ?>">
					</th>

					<td class="has-row-actions column-primary" data-colname="User">
						<strong>
							<?php echo get_userdata( $data->user_id )->user_login ?>
						</strong>
					</td>

					<td class="title column-title has-row-actions column-primary" data-colname="Order Number">					
						<a href="<?php echo admin_url('post.php?post=' . $data->order_number .'&action=edit') ?>"><?php echo $data->order_number ?></a>					
					</td>


					<td class="title column-title has-row-actions column-primary" data-colname="Product SKU">
						<strong>
							<?php echo $data->product_sku; ?>
						</strong>		
					</td>


					<td class="has-row-actions column-primary" data-colname="Design Template">						
						<a href="<?php echo admin_url('admin.php?page=mmg_design_template_add&e=' . $data->design_template ) ?>"><?php echo mmg_design_template_get($data->design_template)->name ?></a>						
					</td>


					<td class="has-row-actions column-primary" data-colname="Design Snapshot">
						<a href="<?php echo admin_url('admin.php?page=mmg_design_snapshots&e=' . $data->design_snapshot ) ?>"><?php echo mmg_design_snapshots_get($data->design_snapshot)->product_name ?></a>	
					</td>


					<td class="has-row-actions column-primary" data-colname="Order Status">
						<strong>
							<?php echo ucwords( str_replace('-', ' ', $data->order_status) ) ?>
						</strong>	
					</td>

					<td class="has-row-actions column-primary" data-colname="View">
						<a href="?page=mmg_design_data&view=<?php echo $data->code ?>" class="button button-default">View</a>
					</td>
					

				</tr>



			<?php endforeach; ?>
		</tbody>

		<tfoot>
			<tr>
				<td id="cb" class="manage-column column-cb check-column">
					<label class="screen-reader-text" for="cb-select-all-1">Select All</label>
					<input id="cb-select-all-1" type="checkbox">
				</td>

				<th scope="col" id="user" class="manage-column column-primary sortable desc">
					<a href="#">
						<span>User</span>							
					</a>
				</th>
				
				<th scope="col" id="order-number" class="manage-column column-primary sortable desc">
					<a href="#">
						<span>Order Number</span>							
					</a>
				</th>

				<th scope="col" id="product-sku" class="manage-column column-primary sortable desc">
					<a href="#">
						<span>Product SKU</span>							
					</a>
				</th>

				<th scope="col" id="design-template" class="manage-column column-primary sortable desc">
					<a href="#">
						<span>Design Template</span>							
					</a>
				</th>

				<th scope="col" id="design-snapshot" class="manage-column column-primary sortable desc">
					<a href="#">
						<span>Design Snapshot</span>							
					</a>
				</th>

				<th scope="col" id="order-status" class="manage-column column-primary sortable desc">
					<a href="#">
						<span>Order Status</span>							
					</a>
				</th>

				<th scope="col" id="view"></th>				
			</tr>
		</tfoot>

	</table>

	<div class="tablenav bottom">

		<div class="alignleft actions bulkactions">
			<label for="bulk-action-selector-bottom" class="screen-reader-text">Select bulk action</label>
			<select name="action2" id="bulk-action-selector-bottom">
				<option value="-1">Bulk Actions</option>
				<option value="delete">Delete</option>
			</select>

			<input type="submit" id="doaction2" class="button data-delete-action" value="Apply">
		</div>		
	</div>


</div>