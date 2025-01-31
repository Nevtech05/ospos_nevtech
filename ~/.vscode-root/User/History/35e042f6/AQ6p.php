<?php $this->load->view("partial/header"); ?>

<?php if (isset($error_message)): ?>
	<div class="alert alert-dismissible alert-danger">
		<?php echo $error_message; ?>
	</div>
	<?php exit; ?>
<?php endif; ?>

<?php if (!empty($customer_email)): ?>
	<script type="text/javascript">
		$(document).ready(function() {
			var send_email = function() {
				$.get('<?php echo site_url() . "/sales/send_receipt/" . $sale_id_num; ?>',
					function(response) {
						$.notify({ message: response.message }, { type: response.success ? 'success' : 'danger' });
					}, 'json'
				);
			};

			$("#show_email_button").click(send_email);

			<?php if (!empty($email_receipt)): ?>
				send_email();
			<?php endif; ?>
		});
	</script>
<?php endif; ?>

<?php 
// Print receipt
$this->load->view('partial/print_receipt', array(
	'print_after_sale' => $print_after_sale,
	'selected_printer' => 'receipt_printer'
)); 
?>

<div class="print_hide" id="control_buttons" style="text-align: right; margin-top: 20px;">
	<!-- Print Button -->
	<a href="javascript:printdoc();" class="btn btn-primary btn-sm" id="show_print_button">
		<i class="glyphicon glyphicon-print"></i> <?php echo $this->lang->line('common_print'); ?>
	</a>

	<!-- Email Receipt Button -->
	<?php if (!empty($customer_email)): ?>
		<a href="javascript:void(0);" class="btn btn-success btn-sm" id="show_email_button">
			<i class="glyphicon glyphicon-envelope"></i> <?php echo $this->lang->line('sales_send_receipt'); ?>
		</a>
	<?php endif; ?>

	<!-- Back to Sales Register Button -->
	<?php echo anchor("sales", 
		'<i class="glyphicon glyphicon-shopping-cart"></i> ' . $this->lang->line('sales_register'), 
		array('class' => 'btn btn-info btn-sm', 'id' => 'show_sales_button')
	); ?>

	<!-- Sales Takings Button (if permission granted) -->
	<?php if ($this->Employee->has_grant('reports_sales', $this->session->userdata('person_id'))): ?>
		<?php echo anchor("sales/manage", 
			'<i class="glyphicon glyphicon-list-alt"></i> ' . $this->lang->line('sales_takings'), 
			array('class' => 'btn btn-warning btn-sm', 'id' => 'show_takings_button')
		); ?>
	<?php endif; ?>
</div>

<!-- Receipt Template -->
<?php $this->load->view("sales/" . $this->config->item('receipt_template')); ?>

<?php $this->load->view("partial/footer"); ?>
