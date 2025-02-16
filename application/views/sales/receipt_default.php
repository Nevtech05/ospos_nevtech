<div id="receipt_wrapper" style="font-size:<?php echo $this->config->item('receipt_font_size');?>px">
    <!-- Receipt Header -->
    <div id="receipt_header">
        <?php if ($this->config->item('company_logo') != '') { ?>
            <div id="company_logo">
                <img id="image" src="<?php echo base_url('uploads/' . $this->config->item('company_logo')); ?>" alt="company_logo" />
            </div>
        <?php } ?>
        
        <?php if ($this->config->item('receipt_show_company_name')) { ?>
            <div id="company_name"><?php echo $this->config->item('company'); ?></div>
        <?php } ?>

        <!-- Barcode -->
        <div id="barcode">
            <img src='data:image/png;base64,<?php echo $barcode; ?>' /><br>
            <?php echo $sale_id; ?>
        </div>

        <div id="company_address"><?php echo nl2br($this->config->item('address')); ?></div>
        <div id="company_phone"><?php echo $this->config->item('phone'); ?></div>
        <div id="sale_receipt"><?php echo $this->lang->line('sales_receipt'); ?></div>
        <div id="sale_time"><?php echo $transaction_time; ?></div>
    </div>

    <hr style="border-top: 1px dashed #000;">

    <!-- Customer & Employee Info -->
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

    <hr style="border-top: 1px dashed #000;">

    <!-- Receipt Items Table -->
    <table id="receipt_items">
        <tr>
            <th style="width:40%;"><?php echo $this->lang->line('sales_description_abbrv'); ?></th>
            <th style="width:20%;"><?php echo $this->lang->line('sales_price'); ?></th>
            <th style="width:20%;"><?php echo $this->lang->line('sales_quantity'); ?></th>
            <th style="width:20%;" class="total-value"><?php echo $this->lang->line('sales_total'); ?></th>
        </tr>
        <?php foreach ($cart as $item) { ?>
            <tr>
                <td><?php echo ucfirst($item['name']); ?></td>
                <td><?php echo to_currency($item['price']); ?></td>
                <td><?php echo to_quantity_decimals($item['quantity']); ?></td>
                <td class="total-value"><?php echo to_currency($item['total']); ?></td>
            </tr>
        <?php } ?>
    </table>

    <hr style="border-top: 1px dashed #000;">

    <!-- 🔥 Summary Section -->
    <div id="summary_section">
        <table style="width:100%;">
            <tr>
                <td style="text-align:left;">Subtotal:</td>
                <td style="text-align:right;"><?php echo to_currency($subtotal); ?></td>
            </tr>
            
            <?php foreach ($taxes as $tax) { ?>
                <tr>
                    <td style="text-align:left;"><?php echo (float)$tax['tax_rate'] . '% VAT'; ?></td>
                    <td style="text-align:right;"><?php echo to_currency($tax['sale_tax_amount']); ?></td>
                </tr>
            <?php } ?>
            
            <tr>
                <td style="text-align:left; font-weight:bold;">Total Amount:</td>
                <td style="text-align:right; font-weight:bold;"><?php echo to_currency($total); ?></td>
            </tr>
            
            <?php foreach ($payments as $payment) { ?>
                <tr>
                    <td style="text-align:left;">Payment Type:</td>
                    <td style="text-align:right;"><?php echo $payment['payment_type']; ?></td>
                </tr>
                <tr>
                    <td style="text-align:left;">Amount Paid:</td>
                    <td style="text-align:right;"><?php echo to_currency($payment['payment_amount'] * -1); ?></td>
                </tr>
            <?php } ?>

            <tr>
                <td style="text-align:left; font-weight:bold;">
                    <?php echo ($amount_change >= 0) ? 'Change Due:' : 'Amount Due:'; ?>
                </td>
                <td style="text-align:right; font-weight:bold;"><?php echo to_currency($amount_change); ?></td>
            </tr>
        </table>
    </div>

    <hr style="border-top: 1px dashed #000;">

    <!-- Sale Return Policy -->
    <div id="return_policy" style="text-align: center;">
        <?php echo nl2br($this->config->item('return_policy')); ?>
    </div>

    <hr style="border-top: 1px dashed #000;">

    <div style="text-align: center; font-weight: bold;">THANK YOU FOR SHOPPING WITH US</div>
    <div style="text-align: center;">Designed & Developed by <strong>Nevtechzone Solutions Ltd.</strong></div>
</div>
