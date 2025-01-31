<?php $this->load->view("partial/header"); ?>

<?php
if (isset($error_message)) {
    echo "<div class='alert alert-dismissible alert-danger'>" . $error_message . "</div>";
    exit;
}
?>

<?php if (!empty($customer_email)): ?>
    <script type="text/javascript">
        $(document).ready(function () {
            var send_email = function () {
                $.get('<?php echo site_url() . "/sales/send_receipt/" . $sale_id_num; ?>',
                    function (response) {
                        $.notify({message: response.message}, {type: response.success ? 'success' : 'danger'});
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

<div class="receipt-container">
    <?php
    // Receipt Data
    $receiptData = [
        'order_id' => $sale_id_num,
        'date' => date('d/m/Y', strtotime($transaction_date)),
        'time' => date('H:i:s', strtotime($transaction_date)),
        'served_by' => $this->session->userdata('person_name'),
        'items' => $items,
        'total' => $total_amount,
        'cash' => $amount_paid,
        'change' => $amount_paid - $total_amount,
        'vat' => $vat_amount,
        'vat_rate' => 16, // Assuming 16% VAT
    ];

    // Function to generate receipt
    function generateReceipt($data)
    {
        $receipt = "Point Of Sale\n";
        $receipt .= "Tel: +254718304854\n";
        $receipt .= "Email: nevtech254@gmail.com\n";
        $receipt .= "Website: http://nevtechzone.com\n";
        $receipt .= "Chemist\n";
        $receipt .= "Served by: " . $data['served_by'] . "\n";
        $receipt .= "Order ID: " . $data['order_id'] . "\n";
        $receipt .= "Date: " . $data['date'] . "\n";
        $receipt .= "Time: " . $data['time'] . "\n";
        $receipt .= "--------------------------------\n";

        // Item details
        foreach ($data['items'] as $item) {
            $receipt .= $item['name'] . " - KSh " . number_format($item['price'], 2) . "\n";
        }

        $receipt .= "--------------------------------\n";
        $receipt .= "TOTAL: KSh " . number_format($data['total'], 2) . "\n";
        $receipt .= "Cash: KSh " . number_format($data['cash'], 2) . "\n";
        $receipt .= "CHANGE: KSh " . number_format($data['change'], 2) . "\n";
        $receipt .= "Sales VAT (" . $data['vat_rate'] . "%): KSh " . number_format($data['vat'], 2) . "\n";
        $receipt .= "--------------------------------\n";
        $receipt .= "Thanks for shopping with us!\n";

        return $receipt;
    }

    // Display receipt
    echo nl2br(generateReceipt($receiptData));
    ?>
</div>

<div class="print_hide" id="control_buttons" style="text-align:right">
    <a href="javascript:printdoc();">
        <div class="btn btn-info btn-sm" id="show_print_button">
            <?php echo '<span class="glyphicon glyphicon-print">&nbsp</span>' . $this->lang->line('common_print'); ?>
        </div>
    </a>
    <?php if (!empty($customer_email)): ?>
        <a href="javascript:void(0);">
            <div class="btn btn-info btn-sm" id="show_email_button">
                <?php echo '<span class="glyphicon glyphicon-envelope">&nbsp</span>' . $this->lang->line('sales_send_receipt'); ?>
            </div>
        </a>
    <?php endif; ?>
    <?php echo anchor("sales", '<span class="glyphicon glyphicon-shopping-cart">&nbsp</span>' . $this->lang->line('sales_register'), array('class' => 'btn btn-info btn-sm', 'id' => 'show_sales_button')); ?>
    <?php if ($this->Employee->has_grant('reports_sales', $this->session->userdata('person_id'))): ?>
        <?php echo anchor("sales/manage", '<span class="glyphicon glyphicon-list-alt">&nbsp</span>' . $this->lang->line('sales_takings'), array('class' => 'btn btn-info btn-sm', 'id' => 'show_takings_button')); ?>
    <?php endif; ?>
</div>

<?php $this->load->view("partial/footer"); ?>
