<?php $this->load->view("partial/header"); ?>

<h2>Repair Orders</h2>
<table border="1">
    <tr>
        <th>Repair ID</th>
        <th>Customer ID</th>
        <th>Item Name</th>
        <th>Serial Number</th>
        <th>Issue</th>
        <th>Status</th>
        <th>Estimated Cost</th>
        <th>Actual Cost</th>
        <th>Technician</th>
        <th>Created At</th>
        <th>Updated At</th>
    </tr>
    <?php foreach ($repairs as $repair) : ?>
        <tr>
            <td><?php echo $repair['repair_id']; ?></td>
            <td><?php echo $repair['customer_id']; ?></td>
            <td><?php echo $repair['item_name']; ?></td>
            <td><?php echo $repair['serial_number']; ?></td>
            <td><?php echo $repair['issue_description']; ?></td>
            <td><?php echo $repair['status']; ?></td>
            <td><?php echo $repair['estimated_cost']; ?></td>
            <td><?php echo $repair['actual_cost']; ?></td>
            <td><?php echo $repair['technician_id']; ?></td>
            <td><?php echo $repair['created_at']; ?></td>
            <td><?php echo $repair['updated_at']; ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<!--  -->
<?php $this->load->view("partial/footer"); ?>
