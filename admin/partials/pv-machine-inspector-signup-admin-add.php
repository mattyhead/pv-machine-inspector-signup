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

$select = &$this->helpers->select;

$select->setup( 'region', 'PA' );
$select->get_combo_data( 'state' );
?>
<div id="pv-add" class="wrap metabox-holder columns-2 pv-metaboxes hidden">
	<h2><?php esc_attr_e( 'Add a new Machine Inspector Signup', $this->plugin_name ); ?></h2>
	<form class="validate" method="post" name="machine_inspector_add" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<table class="form-table">
			<tbody>
				<tr class="form-field form-required">
					<th scope="row"><label for="first_name"><?php esc_html_e( 'First Name', $this->plugin_name ); ?><span class="description"> (required)</span></label></th>
					<td><input required id="first_name" name="first_name" type="text" value=""></td>
				</tr>
				<tr class="form-field">
					<th scope="row"><label for="middle_name"><?php esc_html_e( 'Middle Name', $this->plugin_name ); ?> <span class="description"></span></label></th>
					<td><input id="middle_name" name="middle_name" type="text" value=""></td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="last_name"><?php esc_html_e( 'Last Name', $this->plugin_name ); ?><span class="description"> (required)</span></label></th>
					<td><input required id="last_name" name="last_name" type="text" value=""></td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="address1"><?php esc_html_e( 'Address', $this->plugin_name ); ?><span class="description"> (required)</span></label></th>
					<td><input required id="address1" name="address1" type="text" value=""></td>
				</tr>
				<tr class="form-field">
					<th scope="row"><label for="address2">(<?php esc_html_e( 'Continued', $this->plugin_name ); ?>) <span class="description"></span></label></th>
					<td><input id="address2" name="address2" type="text" value=""></td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="city"><?php esc_html_e( 'City', $this->plugin_name ); ?><span class="description"> (required)</span></label></th>
					<td><input required id="city" name="city" type="text" value="Philadelphia"></td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="postcode"><?php esc_html_e( 'Zip', $this->plugin_name ); ?><span class="description"> (required)</span></label></th>
					<td><input id="postcode" name="postcode" type="text" value=""></td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="region"><?php esc_html_e( 'Region', $this->plugin_name ); ?><span class="description"> (required)</span></label></th>
					<td><?php echo $select->get_html(); ?></td>
				</tr>
				<tr class="form-field">
					<th scope="row"><label for="email"><?php esc_html_e( 'Email', $this->plugin_name ); ?> <span class="description"></span></label></th>
					<td><input id="email" name="email" type="email" value=""></td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="phone"><?php esc_html_e( 'Phone', $this->plugin_name ); ?><span class="description"> (required)</span></label></th>
					<td><input required id="phone" name="phone" type="text" value=""></td>
				</tr>
			</tbody>
		</table>
		<p class="submit">
			<input name="action" value="pvmi_admin_create" type="hidden">
			<input name="current" value="<?php echo esc_attr( $pagination->current ); ?>" type="hidden">
	<?php wp_nonce_field( $this->plugin_name . '_admin_create', $this->plugin_name . '_admin_create_nonce' ); ?>
	<?php submit_button( __( 'Add', $this->plugin_name ), 'primary', 'submit', true ); ?>
		</p>
	</form>
</div>
