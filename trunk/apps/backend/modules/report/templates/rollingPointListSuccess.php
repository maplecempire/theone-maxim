<script type="text/javascript">
var isSubmitAjax = true;
var jform = null;
var datagrid = null;

$(function(){
    $("#dateFrom").datepicker();
    $("#dateTo").datepicker();

    $("#btnSearch").click(function(event){
        event.preventDefault();
        $("#enquiryForm").submit();
    });
});
</script>
<form action="<?php echo url_for("/report/rollingPointList"); ?>" method="post" id="enquiryForm" name="enquiryForm">
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
        <td></td>
        <td></td>
        <td><button id="btnSearch">Search</button></td>
    </tr>
</table>
</form>
<?php echo $rollingPointTable;?>