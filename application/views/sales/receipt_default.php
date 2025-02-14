<div id="receipt_wrapper" style="font-size:<?php echo $this->config->item('receipt_font_size');?>px">
    <!-- Receipt Header -->
    <div id="receipt_header">
        <?php if ($this->config->item('company_logo') != '') { ?>
            <div id="company_name">
                <img id="image" src="<?php echo base_url('uploads/' . $this->config->item('company_logo')); ?>" alt="company_logo" />
            </div>
        <?php } ?>
        
        <?php if ($this->config->item('receipt_show_company_name')) { ?>
            <div id="company_name"><?php echo $this->config->item('company'); ?></div>
        <?php } ?>

		<!-- Barcode -->
		<div id="barcode" >
        <img src='data:image/png;base64,<?php echo $barcode; ?>' /><br>
        <?php echo $sale_id; ?>
    	</div>

        <div id="company_address"><?php echo nl2br($this->config->item('address')); ?></div>
        <div id="company_phone"><?php echo $this->config->item('phone'); ?></div>
        <div id="sale_receipt"><?php echo $this->lang->line('sales_receipt'); ?></div>
        <div id="sale_time"><?php echo $transaction_time; ?></div>
    </div>

    <!-- General Information -->
    <div id="receipt_general_info">
        <?php if (isset($customer)) { ?>
            <div id="customer"><?php echo $this->lang->line('customers_customer') . ": " . $customer; ?></div>
        <?php } ?>
        <div id="sale_id"><?php echo $this->lang->line('sales_id') . ": " . $sale_id; ?></div>

        <?php if (!empty($invoice_number)) { ?>
            <div id="invoice_number"><?php echo $this->lang->line('sales_invoice_number') . ": " . $invoice_number; ?></div>
        <?php } ?>

        <div id="employee"><?php echo $this->lang->line('employees_employee') . ": " . $employee; ?></div>
    </div>

    <!-- Receipt Items Table -->
    <table id="receipt_items">
        <tr>
            <th style="width:40%;"><?php echo $this->lang->line('sales_description_abbrv'); ?></th>
            <th style="width:20%;"><?php echo $this->lang->line('sales_price'); ?></th>
            <th style="width:20%;"><?php echo $this->lang->line('sales_quantity'); ?></th>
            <th style="width:20%;" class="total-value"><?php echo $this->lang->line('sales_total'); ?></th>
            <?php if ($this->config->item('receipt_show_tax_ind')) { ?>
                <th style="width:20%;"></th>
            <?php } ?>
        </tr>
        <?php foreach ($cart as $line => $item) { 
            if ($item['print_option'] == PRINT_YES) { ?>
                <tr style="border-bottom: 1px dashed #000;">
                    <td><?php echo ucfirst($item['name'] . ' ' . $item['attribute_values']); ?></td>
                    <td><?php echo to_currency($item['price']); ?></td>
                    <td><?php echo to_quantity_decimals($item['quantity']); ?></td>
                    <td class="total-value"><?php echo to_currency($item[($this->config->item('receipt_show_total_discount') ? 'total' : 'discounted_total')]); ?></td>
                    <?php if ($this->config->item('receipt_show_tax_ind')) { ?>
                        <td><?php echo $item['taxed_flag']; ?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <?php if ($this->config->item('receipt_show_description')) { ?>
                        <td colspan="2"><?php echo $item['description']; ?></td>
                    <?php }
                    if ($this->config->item('receipt_show_serialnumber')) { ?>
                        <td><?php echo $item['serialnumber']; ?></td>
                    <?php } ?>
                </tr>
                <?php if ($item['discount'] > 0) { ?>
                    <tr style="border-bottom: 1px dashed #000;">
                        <?php if ($item['discount_type'] == FIXED) { ?>
                            <td colspan="3" class="discount"><?php echo to_currency($item['discount']) . " " . $this->lang->line("sales_discount"); ?></td>
                        <?php } elseif ($item['discount_type'] == PERCENT) { ?>
                            <td colspan="3" class="discount"><?php echo to_decimals($item['discount']) . " " . $this->lang->line("sales_discount_included"); ?></td>
                        <?php } ?>
                        <td class="total-value"><?php echo to_currency($item['discounted_total']); ?></td>
                    </tr>
                <?php }
            }
        } ?>
        
        <!-- Subtotal and Discount -->
        <?php if ($this->config->item('receipt_show_total_discount') && $discount > 0) { ?>
            <tr style="border-bottom: 1px dashed #000;">
                <td colspan="3" style='text-align:right;'><?php echo $this->lang->line('sales_sub_total'); ?></td>
                <td style='text-align:right;'><?php echo to_currency($prediscount_subtotal); ?></td>
            </tr>
            <tr>
                <td colspan="3" class="total-value"><?php echo $this->lang->line('sales_customer_discount'); ?>:</td>
                <td class="total-value"><?php echo to_currency($discount * -1); ?></td>
            </tr>
        <?php } ?>

        <!-- Taxes -->
        <?php if ($this->config->item('receipt_show_taxes')) { ?>
            <tr style="border-bottom: 1px dashed #000;">
                <td colspan="3" style='text-align:right;'><?php echo $this->lang->line('sales_sub_total'); ?></td>
                <td style='text-align:right;'><?php echo to_currency($subtotal); ?></td>
            </tr>
            <?php foreach ($taxes as $tax_group_index => $tax) { ?>
                <tr style="border-bottom: 1px dashed #000;">
                    <td colspan="3" class="total-value"><?php echo (float)$tax['tax_rate'] . '% ' . $tax['tax_group']; ?>:</td>
                    <td class="total-value"><?php echo to_currency_tax($tax['sale_tax_amount']); ?></td>
                </tr>
            <?php } ?>
        <?php } ?>

        <!-- Total -->
        <tr style="border-bottom: 1px dashed #000;">
            <td colspan="3" style="text-align:right;"><?php echo $this->lang->line('sales_total'); ?></td>
            <td style="text-align:right;"><?php echo to_currency($total); ?></td>
        </tr>

        <!-- Payment Method and Amount Due -->
        <?php foreach ($payments as $payment_id => $payment) { ?>
            <tr style="border-bottom: 1px dashed #000;">
                <td colspan="3" style="text-align:right;"><?php echo $splitpayment[0]; ?></td>
                <td class="total-value"><?php echo to_currency($payment['payment_amount'] * -1); ?></td>
            </tr>
        <?php } ?>

        <!-- Gift Card Balance -->
        <?php if (isset($cur_giftcard_value) && $show_giftcard_remainder) { ?>
            <tr style="border-bottom: 1px dashed #000;">
                <td colspan="3" style="text-align:right;"><?php echo $this->lang->line('sales_giftcard_balance'); ?></td>
                <td class="total-value"><?php echo to_currency($cur_giftcard_value); ?></td>
            </tr>
        <?php } ?>
        
        <!-- Change Due -->
        <tr style="border-bottom: 1px dashed #000;">
            <td colspan="3" style="text-align:right;"><?php echo $this->lang->line($amount_change >= 0 ? ($only_sale_check ? 'sales_check_balance' : 'sales_change_due') : 'sales_amount_due'); ?></td>
            <td class="total-value"><?php echo to_currency($amount_change); ?></td>
        </tr>
    </table>

    <!-- Sale Return Policy -->
    <div  style="text-align: center; border-top: 1px dashed #000">
        <?php echo nl2br($this->config->item('return_policy')); ?>
    </div>

	<div style="text-align: center; font-weight: bold; border-top: 1px dashed #000">THANK YOU FOR SHOPPING WITH US</div>

	<div style="text-align: center;  border-top: 1px dashed #000">Designed &amp; Developed by <strong>Nevtechzone Solutions Ltd.</strong></div>


    
</div>
