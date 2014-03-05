<style type="text/css">

</style>

<script type="text/javascript">
var isSubmitAjax = true;
var jform = null;
var datagrid = null;

$(function(){
    $("#dateFrom").datepicker();
    $("#dateTo").datepicker();

    $("#btnSearch").click(function(event){
        event.preventDefault();
        if ($("#memberId").val() == "") {
            alert("Member ID is required");
            return false;
        }

        waiting();
        $("#enquiryForm").submit();
    });
});
</script>
<form action="<?php echo url_for("/report/doIndividualTraderSales"); ?>" method="post" id="enquiryForm" name="enquiryForm">

<br>
<?php if ($sf_flash->has('successMsg')): ?>
<div class="ui-widget">
    <div style="margin-top: 20px; padding: 0 .7em;" class="ui-state-highlight ui-corner-all">
        <p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-info"></span>
            <strong><?php echo $sf_flash->get('successMsg') ?></strong></p>
    </div>
</div>
<?php endif; ?>
<?php if ($sf_flash->has('errorMsg')): ?>
<div class="ui-widget">
    <div style="margin-top: 20px; padding: 0 .7em;" class="ui-state-error ui-corner-all">
        <p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span>
            <strong><?php echo $sf_flash->get('errorMsg') ?></strong></p>
    </div>
</div>
<?php endif; ?>
<br>
<table width="100%">
    <tr>
        <td width="100">Date From</td>
        <td width="1">:</td>
        <td><input id="dateFrom" name="dateFrom" size="20" value="<?php echo $dateFrom;?>"></td>
    </tr>
    <tr>
        <td>Date To</td>
        <td>:</td>
        <td><input id="dateTo" name="dateTo" size="20" value="<?php echo $dateTo;?>"></td>
    </tr>
    <tr>
        <td>Member ID</td>
        <td>:</td>
        <td><input id="memberId" name="memberId" size="20" value="<?php echo $memberId;?>"></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td><button id="btnSearch">Search</button></td>
    </tr>
</table>
</form>

<table class="resultTable" width="90%" cellpadding="3" cellspacing="3">
    <tr style="background-color: #CCCCFF; padding: 2px; text-align: left;">
        <td></td>
        <td>Member Id</td>
        <td>Full Name</td>
        <td>Amount</td>
        <td>Email</td>
        <td>Contact Number</td>
        <td>Country</td>
        <td>Leader</td>
        <td>Created On</td>
    </tr>

    <?php
    $idx = 1;
    foreach ($resultArray as $arr) { ?>
    <tr style="background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;">
        <td><?php echo $idx++; ?></td>
        <td><?php echo $arr['distributor_code'] ?></td>
        <td><?php echo $arr['full_name'] ?></td>
        <td><?php echo number_format($arr['SUB_TOTAL'],2) ?></td>
        <td><?php echo $arr['email'] ?></td>
        <td><?php echo $arr['contact'] ?></td>
        <td><?php echo $arr['country'] ?></td>
        <td><?php echo $arr['LEADER'] ?></td>
        <td><?php echo $arr['created_on'] ?></td>
    </tr>
    <?php
    }
        ?>
</table>

    <br>
<?php if ($resultArray) { ?>
<!--<h2>List of sales</h2>

<table class="resultTable" width="90%" cellpadding="3" cellspacing="3">
    <tr style="background-color: #CCCCFF; padding: 2px; text-align: left;">
        <td></td>
        <td>Member Id</td>
        <td>Full Name</td>
        <td>Package Amount</td>
    </tr>

</table>-->
<?php } ?>
