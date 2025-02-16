<?php $this->load->view("partial/header"); ?>

<script type="text/javascript">
$(document).ready(function()
{
    $('#filters').on('hidden.bs.select', function(e) {
        table_support.refresh();
    });

    <?php $this->load->view('partial/daterangepicker'); ?>
    
    $("#daterangepicker").on('apply.daterangepicker', function(ev, picker) {
        table_support.refresh();
    });

    <?php $this->load->view('partial/bootstrap_tables_locale'); ?>

    table_support.query_params = function()
    {
        return {
            start_date: start_date,
            end_date: end_date,
            filters: $("#filters").val() || [""]
        }
    };

    table_support.init({
        resource: '<?php echo site_url("repairs"); ?>',
        headers: <?php echo $table_headers; ?>,
        pageSize: <?php echo $this->config->item('lines_per_page'); ?>,
        uniqueId: 'repair_id',
        onLoadSuccess: function(response) {
            if($("#table tbody tr").length > 1) {
                $("#repair_summary").html(response.repair_summary);
                $("#table tbody tr:last td:first").html("");
                $("#table tbody tr:last").css('font-weight', 'bold');
            }
        },
        queryParams: function() {
            return $.extend(arguments[0], table_support.query_params());
        },
        columns: {
            'status': {
                align: 'center'
            }
        }
    });
});
</script>

<?php $this->load->view('partial/print_receipt', array('print_after_sale' => false, 'selected_printer' => 'repairs_printer')); ?>

<div id="title_bar" class="print_hide btn-toolbar">
    <button onclick="javascript:printdoc()" class='btn btn-info btn-sm pull-right'>
        <span class="glyphicon glyphicon-print">&nbsp</span><?php echo $this->lang->line('common_print'); ?>
    </button>
    <?php echo anchor("repairs/create", '<span class="glyphicon glyphicon-wrench">&nbsp</span>' . $this->lang->line('repair_new'), array('class'=>'btn btn-success btn-sm pull-right')); ?>
</div>

<div id="toolbar">
    <div class="pull-left form-inline" role="toolbar">
        <button id="delete" class="btn btn-default btn-sm print_hide">
            <span class="glyphicon glyphicon-trash">&nbsp</span><?php echo $this->lang->line("common_delete"); ?>
        </button>

        <?php echo form_input(array('name'=>'daterangepicker', 'class'=>'form-control input-sm', 'id'=>'daterangepicker')); ?>
        <?php echo form_multiselect('filters[]', $filters, '', array('id'=>'filters', 'data-none-selected-text'=>$this->lang->line('common_none_selected_text'), 'class'=>'selectpicker show-menu-arrow', 'data-selected-text-format'=>'count > 1', 'data-style'=>'btn-default btn-sm', 'data-width'=>'fit')); ?>
    </div>
</div>

<div id="table_holder">
    <table id="table"></table>
</div>

<div id="repair_summary">
</div>

<?php $this->load->view("partial/footer"); ?>