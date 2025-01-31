<?php
// Validate required data
$items = $items ?? []; // Default to an empty array if undefined
$total_amount = $total_amount ?? 0;
$amount_paid = $amount_paid ?? 0;
$vat_amount = $vat_amount ?? 0;

// Generate receipt
function generateReceipt($data) {
    $receipt = "Point Of Sale\n";
    $receipt .= "Tel: +254718304854\n";
    $receipt .= "Email: nevtech254@gmail.com\n";
    $receipt .= "Website: http://nevtechzone.com\n";
    $receipt .= "Chemist\n";
    $receipt .= "Served by: " . ($data['served_by'] ?? 'Unknown') . "\n";
    $receipt .= "Order ID: " . ($data['order_id'] ?? 'N/A') . "\n";
    $receipt .= "Date: " . ($data['date'] ?? 'N/A') . "\n";
    $receipt .= "Time: " . ($data['time'] ?? 'N/A') . "\n";
    $receipt .= "--------------------------------\n";

    // Item details
    if (!empty($data['items'])) {
        foreach ($data['items'] as $item) {
            $receipt .= $item['name'] . " - KSh " . number_format($item['price'], 2) . "\n";
        }
    } else {
        $receipt .= "No items found.\n";
    }

    $receipt .= "--------------------------------\n";
    $receipt .= "TOTAL: KSh " . number_format($data['total'], 2) . "\n";
    $receipt .= "Cash: KSh " . number_format($data['cash'], 2) . "\n";
    $receipt .= "CHANGE: KSh " . number_format($data['change'], 2) . "\n";
    $receipt .= "Sales VAT (" . ($data['vat_rate'] ?? 0) . "%): KSh " . number_format($data['vat'], 2) . "\n";
    $receipt .= "--------------------------------\n";
    $receipt .= "Thanks for shopping with us!\n";

    return $receipt;
}

// Prepare receipt data
$receiptData = [
    'order_id' => $order_id ?? 'N/A',
    'date' => $date ?? 'N/A',
    'time' => $time ?? 'N/A',
    'served_by' => $served_by ?? 'N/A',
    'items' => $items,
    'total' => $total_amount,
    'cash' => $amount_paid,
    'change' => $amount_paid - $total_amount,
    'vat' => $vat_amount,
    'vat_rate' => 16, // Hardcoded for now, adjust as needed
];

// Display receipt
echo generateReceipt($receiptData);
?>
