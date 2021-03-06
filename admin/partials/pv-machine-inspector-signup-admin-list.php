<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link  philadelphiavotes.com
 * @since 1.0.0
 *
 * @package    Pv_Machine_Inspector_Signup
 * @subpackage Pv_Machine_Inspector_Signup/admin/partials
 */

// load rows (gotta load rows before loading paginator).
$rows = $this->list();

// load paginator.
$paginator = &$this->helpers->paginator;
$pagination = $this->models->signups->get_pagination();
$paginator->setup( $this->plugin_name, $pagination, true, true ); // exportable and deletable.
$current_param = '&current=' . $pagination->current;
?>
<div id="pv-list" class="wrap metabox-holder columns-9 pv-metaboxes <?php echo ( 'edit' === $action ) ? 'hidden' : ''; ?>">
	<table class="wp-list-table widefat fixed striped pages">
		<thead>
			<tr>
				<th class="column-id">
		<?php esc_html_e( 'Id', $this->plugin_name ); ?>
				</th>
				<th class="column-precinct">
		<?php esc_html_e( 'Precint', $this->plugin_name ); ?>
				</th>
				<th class="column-title">
		<?php esc_html_e( 'Name', $this->plugin_name ); ?>
				</th>
				<th class="column-rating">
		<?php esc_html_e( 'Phone', $this->plugin_name ); ?>
				</th>
				<th class="column-rating">
		<?php esc_html_e( 'Email', $this->plugin_name ); ?>
				</th>
				<th class="column-title">
		<?php esc_html_e( 'Street Address', $this->plugin_name ); ?>
				</th>
				<th class="column-rating">
		<?php esc_html_e( 'Zip', $this->plugin_name ); ?>
				</th>
				<th class="column-date">
		<?php esc_html_e( 'Date', $this->plugin_name ); ?>
				</th>
				<th class="column-rating">
		<?php esc_html_e( 'Action', $this->plugin_name ); ?>
				</th>
			</tr>
		</thead>
		<tbody>
	<?php
	$n = count( $rows );
	$i = 0;

	foreach ( $rows as $row ) :
		$i++;
		$delete_link = admin_url( 'admin-post.php?action=pvmi_admin_delete&item=' . $row->id . $current_param . '&_wpnonce=' . wp_create_nonce( $this->plugin_name . '_admin_delete' ) );
		$edit_link   = admin_url( 'admin.php?page=' . $this->plugin_name . '&action=edit&item=' . $row->id . $current_param . '&_wpnonce=' . wp_create_nonce( $this->plugin_name . '_admin_edit' ) );
		$fullname    = $row->first_name . ' ' . ( $row->middle_name ? $row->middle_name . ' ' : '' ) . $row->last_name;
		$matches     = '';
		preg_match( '/^(\d{3})(\d{3})(\d{4})$/', $row->phone, $matches );
	?>
			<tr>
				<td>
		<?php echo esc_html( $row->id ); ?>
				</td>
				<td>
		<?php echo sprintf( '%04d', (int) $row->division ); ?>
				</td>
				<td>
					<a href="<?php echo esc_attr( $edit_link ); ?>"><?php echo esc_html( $fullname ); ?></a>
				</td>
				<td>
		<?php echo esc_html( count( $matches ) ? sprintf( '(%d) %d-%d', $matches[1], $matches[2], $matches[3] ) : '' ); ?>
				</td>
				<td>
		<?php echo esc_html( $row->email ); ?>
				</td>
				<td>
		<?php echo esc_html( $row->address1 . ( $row->address2 ? ', ' . $row->address2 : '' ) ); ?>
				</td>
				<td>
		<?php echo esc_html( $row->postcode ); ?>
				</td>
				<td>
		<?php echo esc_html( $row->created ); ?>
				</td>
				<td>
					<div class="row-actions visible">
						<span class="trash"><a href="<?php echo esc_attr( $delete_link ); ?>" class="submitdelete" aria-label="Delete">Delete</a> |</span>
						<span class="edit"><a href="<?php echo esc_attr( $edit_link ); ?>" aria-label="Edit">Edit</a></span>
					</div>
				</td>
			</tr>
	<?php
	endforeach;
	?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="9" class="wrap">
		<?php echo esc_html( $paginator->get_footer() ); ?>
				</td>
			</tr>
		</tfoot>
	</table>
</div>
