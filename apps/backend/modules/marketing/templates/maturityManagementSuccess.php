<script type="text/javascript">
var isSubmitAjax = true;
var jform = null;
var datagrid = null;

$(function(){
	jform = $("#enquiryForm").validate({
		submitHandler: function(form) {
			if(isSubmitAjax){
				//alert("submit ajax");
				datagrid.fnDraw();
			}else {
				//alert("not submit ajax");
				form.submit();
			}
		}
	});

	datagrid = $("#datagrid").r9jasonDataTable({
		// online1DataTable extra params
		"idTr" : true, // assign <tr id='xxx'> from 1st columns array(aoColumns);
		"extraParam" : function(aoData){ // pass extra params to server
			aoData.push( { "name": "filterDistcode", "value": $("#search_distCode").val()  } );
            aoData.push( { "name": "filterMt4Userame", "value": $("#search_mt4Username").val() } );
            aoData.push( { "name": "filterEmail", "value": $("#search_email").val() } );
            aoData.push( { "name": "filterStatusCode", "value": $("#search_statusCode").val() } );
		},
		"reassignEvent" : function(){ // extra function for reassignEvent when JSON is back from server
			reassignDatagridEventAttr();
		},
		
		// datatables params
		"bLengthChange": true,
		"bFilter": false,
		"bProcessing": true,
		"bServerSide": true,
        "bAutoWidth": false,
        "sScrollX": "100%",
        //"sScrollXInner": "150%",
		"sAjaxSource": "<?php echo url_for('marketingList/maturityAccountList') ?>",
		"sPaginationType": "full_numbers",
        "aaSorting": [
            [2,'asc']
        ],
		"aoColumns": [
              { "sName" : "maturity.notice_id", "bVisible" : false},
              { "sName" : "maturity.notice_id",  "bSortable": false, "fnRender": function ( oObj ) {
                  var idx = 2;
                  $("#dgAddPanel").data("data_" + oObj.aData[0], {
                        notice_id : oObj.aData[0]
                        , dividend_date : oObj.aData[idx++]
                        , distributor_code : oObj.aData[idx++]
                        , mt4_user_name : oObj.aData[idx++]
                        , mt4_balance : oObj.aData[idx++]
                        , status_code : oObj.aData[idx++]
                        , approve_reject_datetime : oObj.aData[idx++]
                        , remark : oObj.aData[idx++]
                        , internal_remark : oObj.aData[idx++]
                        , email : oObj.aData[idx++]
                        , maturity_type : oObj.aData[idx++]
                        , leader : oObj.aData[idx++]
                        , created_on : oObj.aData[idx++]
                        , email_status : oObj.aData[idx++]
                  });
                  var data = $("#dgAddPanel").data("data_" + oObj.aData[0]);
                  if (data.status_code == "PENDING" || data.status_code == "ON HOLD") {
                      return "<a id='actionLink' href='#' title='Action'>Action</a>";
                  }
                  return "";
                }},
              { "sName" : "maturity.dividend_date",  "bSortable": true},
              { "sName" : "dist.distributor_code",  "bSortable": true},
              { "sName" : "maturity.mt4_user_name",  "bSortable": true},
              { "sName" : "maturity.mt4_balance",  "bSortable": true},
              { "sName" : "maturity.status_code",  "bSortable": true},
              { "sName" : "maturity.approve_reject_datetime",  "bSortable": true},
              { "sName" : "maturity.remark",  "bSortable": true},
              { "sName" : "maturity.internal_remark",  "bSortable": true},
              { "sName" : "maturity.email",  "bSortable": true},
              { "sName" : "maturity.maturity_type",  "bSortable": true},
              { "sName" : "leader.distributor_code",  "bSortable": true},
              { "sName" : "maturity.dividend_date",  "bSortable": true},
              { "sName" : "maturity.email_status",  "bSortable": true}
		]
	});

    $("#btnAdd").button({
        text: true
        , icons: {
            primary: 'ui-icon-circle-plus'
        }
    }).click(function(event){
        event.preventDefault();

        $("#dgAddPanelId").val("");
        $("#dgAddPanel").dialog("open");
    });
}); // end $(function())

//all event in detail datagrid need to reassign because, every remote call, the DOM will be restructure again.
function reassignDatagridEventAttr(){
	$("a[id=actionLink]").click(function(event){
		// stop event
		event.preventDefault();

		// event.target is <a> itself, parent() is <td>, while parent().parent() get <tr>
		//var id = alert("id = " +$(event.target).parent().parent().attr("id"));
		var id = $(event.target).parent().parent().attr("id");
        $("#dgAddPanelId").val(id);
        $("#dgAddPanel").dialog("open");
	});
}

</script>

<?php echo form_tag('admin/doLogin', 'id=loginForm') ?>
<div style="padding: 10px; top: 30px; position: absolute; width: 1100px">
<div class="portlet">
    <div class="portlet-header">Maturity Account Management</div>
    <div class="portlet-content">
	<table width="100%" border="0">
		<tr>
			<td>
			<table width="100%">
				<tr>
					<td>
                    <div style="width: 1050px">
					<table class="display" id="datagrid" border="0" width="100%">
                        <thead>
                            <tr>
								<th>id [hidden]</th>
                                <th>&nbsp;</th>
                                <th>Dividend Date</th>
                                <th>Distributor Code</th>
								<th>MT4 ID</th>
								<th>Mt4 Balance</th>
								<th>Status Code</th>
								<th>Approve Reject Date</th>
								<th>Remark</th>
								<th>Internal Remark</th>
								<th>Email</th>
								<th>Maturity Type</th>
								<th>Leader</th>
								<th>Dividend Date</th>
								<th>Email Status</th>
							</tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
								<td><input title="" size="10" type="text" id="search_distCode" value="" class="search_init"/></td>
                                <td><input title="" size="10" type="text" id="search_mt4Username" value="" class="search_init"/></td>
                                <td></td>
                                <td>
                                    <select id="search_statusCode" name="search_statusCode">
                                        <option value="">(Empty)</option>
                                        <option value="<?php echo Globals::STATUS_MATURITY_PENDING; ?>" selected="selected"><?php echo Globals::STATUS_MATURITY_PENDING; ?></option>
                                        <option value="<?php echo Globals::STATUS_MATURITY_RENEW; ?>"><?php echo Globals::STATUS_MATURITY_RENEW; ?></option>
                                        <option value="<?php echo Globals::STATUS_MATURITY_WITHDRAW; ?>"><?php echo Globals::STATUS_MATURITY_WITHDRAW; ?></option>
                                        <option value="<?php echo Globals::STATUS_MATURITY_SUCCESS; ?>"><?php echo Globals::STATUS_MATURITY_SUCCESS; ?></option>
                                        <option value="<?php echo Globals::STATUS_MATURITY_ON_HOLD; ?>"><?php echo Globals::STATUS_MATURITY_ON_HOLD; ?></option>
                                    </select>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><input title="" size="10" type="text" id="search_email" value="" class="search_init"/></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
							</tr>
                        </thead>
                    </table>
                    </div>
					</td>
				</tr>
			</table>
			</td>
		</tr>
	</table>
    </div>
</div>
</div>
<script type="text/javascript">
$(function(){
    $("#dgAddPanel").dialog("destroy");
    $("#dgAddPanel").theoneDialog({
        width:700,
        open: function() {
            populateDgAddPanel();
        },
        close: function() {

        },
        buttons: {
            <?php if ($sf_user->hasCredential(array(AP::AL_READONLY), false)) {
            } else {
            ?>
            "Renew": function() {
                var msg = "Are you sure want to Renew Account?";
                var answer = confirm(msg);
                if (answer){
                    waiting();

                    $.ajax({
                        type : 'POST',
                        url : "<?php echo url_for('finance/doRenewAccount') ?>",
                        dataType : 'json',
                        cache: false,
                        data: {
                            noticeId : $('#dgAddPanelId').val()
                            , cp3Amount : $('#cp3Amount').val()
                            , internalRemark : $('#internalRemark').val()
                            , remark : $('#remark').val()
                            , loanAccount : "N"
                        },
                        success : function(data) {
                            if (data.error) {
                                alert(data.errorMsg);
                            } else {
                                $("#dgAddPanel").dialog('close');
                                datagrid.fnDraw();
                                alert("Account Renew Successfully.");
                            }
                        },
                        error : function(XMLHttpRequest, textStatus, errorThrown) {
                            alert("Server connection error.");
                        }
                    });
                }
            },
            "Renew for loan account": function() {
                var msg = "Are you sure want to Renew for loan account?";
                var answer = confirm(msg);
                if (answer){
                    waiting();

                    $.ajax({
                        type : 'POST',
                        url : "<?php echo url_for('finance/doRenewAccount') ?>",
                        dataType : 'json',
                        cache: false,
                        data: {
                            noticeId : $('#dgAddPanelId').val()
                            , cp3Amount : $('#cp3Amount').val()
                            , internalRemark : $('#internalRemark').val()
                            , remark : $('#remark').val()
                            , loanAccount : "Y"
                        },
                        success : function(data) {
                            if (data.error) {
                                alert(data.errorMsg);
                            } else {
                                $("#dgAddPanel").dialog('close');
                                datagrid.fnDraw();
                                alert("Account Renew Successfully.");
                            }
                        },
                        error : function(XMLHttpRequest, textStatus, errorThrown) {
                            alert("Server connection error.");
                        }
                    });
                }
            },
            "Close Account": function() {
                var msg = "Are you sure want to Close Account?";
                var answer = confirm(msg);
                if (answer){
                    waiting();

                    $.ajax({
                        type : 'POST',
                        url : "<?php echo url_for('finance/doCloseAccount') ?>",
                        dataType : 'json',
                        cache: false,
                        data: {
                            noticeId : $('#dgAddPanelId').val()
                            , cp3Amount : $('#cp3Amount').val()
                            , internalRemark : $('#internalRemark').val()
                            , remark : $('#remark').val()
                        },
                        success : function(data) {
                            if (data.error) {
                                alert(data.errorMsg);
                            } else {
                                $("#dgAddPanel").dialog('close');
                                datagrid.fnDraw();
                                alert("Account Close Successfully.");
                            }
                        },
                        error : function(XMLHttpRequest, textStatus, errorThrown) {
                            alert("Server connection error.");
                        }
                    });
                }
            },
            "Close Account For Loan Account": function() {
                var msg = "Are you sure want to Close Account For Loan Account?";
                var answer = confirm(msg);
                if (answer){
                    waiting();

                    $.ajax({
                        type : 'POST',
                        url : "<?php echo url_for('finance/doCloseAccountForLoanAccount') ?>",
                        dataType : 'json',
                        cache: false,
                        data: {
                            noticeId : $('#dgAddPanelId').val()
                            , cp3Amount : $('#cp3Amount').val()
                            , internalRemark : $('#internalRemark').val()
                            , remark : $('#remark').val()
                        },
                        success : function(data) {
                            if (data.error) {
                                alert(data.errorMsg);
                            } else {
                                $("#dgAddPanel").dialog('close');
                                datagrid.fnDraw();
                                alert("Account Close Successfully.");
                            }
                        },
                        error : function(XMLHttpRequest, textStatus, errorThrown) {
                            alert("Server connection error.");
                        }
                    });
                }
            },
            <?php } ?>
            "ON HOLD": function() {
                var msg = "Are you sure want to ON HOLD this Account?";
                var answer = confirm(msg);
                if (answer){
                    waiting();

                    $.ajax({
                        type : 'POST',
                        url : "<?php echo url_for('finance/doOnHoldAccount') ?>",
                        dataType : 'json',
                        cache: false,
                        data: {
                            noticeId : $('#dgAddPanelId').val()
                            , cp3Amount : $('#cp3Amount').val()
                            , internalRemark : $('#internalRemark').val()
                            , remark : $('#remark').val()
                        },
                        success : function(data) {
                            if (data.error) {
                                alert(data.errorMsg);
                            } else {
                                $("#dgAddPanel").dialog('close');
                                datagrid.fnDraw();
                                alert("Account On Hold Successfully.");
                            }
                        },
                        error : function(XMLHttpRequest, textStatus, errorThrown) {
                            alert("Server connection error.");
                        }
                    });
                }
            },
            Close: function() {
                $(this).dialog('close');
            }
        }
    });

    $('#epointAmount').autoNumeric({
        mDec: 2
    });
    $('#doAction').change(function(event){
        event.preventDefault();
        if ($(this).val() == "deduct_epoint") {
            $("#tr_action").css("background-color", "red");
        } else {
            $("#tr_action").css("background-color", "");
        }
    });
});

function populateDgAddPanel() {
    $("#dgMsg").hide();
    $("#dgAddPanelUserName").attr("readonly", "readonly");
    var data = $("#dgAddPanel").data("data_" + $("#dgAddPanelId").val());
    $("#dgAddPanelDistCode").val(data.distributor_code);
    $("#dgAddPanelmt4_user_name").val(data.mt4_user_name);
    $("#dgAddPanelDividendDate").val(data.dividend_date);
    $("#dgAddPanelMt4Balance").val(data.mt4_balance);
    $("#dgAddPanelMaturityType").val(data.maturity_type);
    $("#dgAddPanelLeader").val(data.leader);
    $("#dgAddPanelEmail").val(data.email);
    //$("#remark").val("TRANSFER FROM COMPANY");
    $("#cp3Amount").val("0").focus().select();
    $(".indicator").show();
    $.ajax({
        type : 'POST',
        url : "<?php echo url_for('finance/enquiryMt4BalanceAndCP') ?>",
        dataType : 'json',
        cache: false,
        data: {
            noticeId : $('#dgAddPanelId').val()
        },
        success : function(data) {
            if (data.error) {
                alert(data.errorMsg);
            } else {
                $(".indicator").hide();
                $("#cp1").val(data.cp1);
                $("#cp2").val(data.cp2);
                $("#cp3").val(data.cp3);
                $("#dgAddPanelMt4Balance").val(data.mt4Balance);
            }
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Server connection error.");
        }
    });
}
</script>
<div id="dgAddPanel" style="display:none; width: 850px" title="Maturity Account Management">
    <input type="hidden" id="dgAddPanelId">
    <table width="100%">
        <tr>
            <td colspan="3">
                <div class="ui-widget" id="dgMsg" style="display:none;">
                </div>
            </td>
        </tr>
    </table>
    <fieldset class="collapsible">
    <legend class="collapsible">Details</legend>
    <table cellpadding="3" cellspacing="3">
        <tr>
            <td width="30%">Distributor Code</td>
            <td>:</td>
            <td><input type="text" id="dgAddPanelDistCode" class="text ui-widget-content ui-corner-all" readonly="readonly" size="25"></td>
            <td>MT4 ID</td>
            <td>:</td>
            <td><input type="text" id="dgAddPanelmt4_user_name" class="text ui-widget-content ui-corner-all" readonly="readonly" size="25"></td>
        </tr>
        <tr>
            <td>Dividend Date</td>
            <td>:</td>
            <td><input type="text" id="dgAddPanelDividendDate" class="text ui-widget-content ui-corner-all" readonly="readonly" size="25"></td>
            <td>Mt4 Balance</td>
            <td>:</td>
            <td><input type="text" id="dgAddPanelMt4Balance" class="text ui-widget-content ui-corner-all" readonly="readonly" size="25"></td>
        </tr>
        <tr>
            <td>Maturity Type</td>
            <td>:</td>
            <td><input type="text" id="dgAddPanelMaturityType" class="text ui-widget-content ui-corner-all" readonly="readonly" size="25"></td>
            <td>Leader</td>
            <td>:</td>
            <td><input type="text" id="dgAddPanelLeader" class="text ui-widget-content ui-corner-all" readonly="readonly" size="25"></td>
        </tr>
        <tr>
            <td>Package value</td>
            <td>:</td>
            <td><input type="text" id="dgAddPanelPackagePrice" class="text ui-widget-content ui-corner-all" readonly="readonly" size="25"></td>
            <td>Email</td>
            <td>:</td>
            <td><input type="text" id="dgAddPanelEmail" class="text ui-widget-content ui-corner-all" readonly="readonly" size="25"></td>
        </tr>

        <tr>
            <td>Transfer CP3</td>
            <td>:</td>
            <td><input name="cp3Amount" id="cp3Amount" class="text ui-widget-content ui-corner-all" size="25"/></td>
            <td style="color: blue; font-weight: bold;">CP1<img src="/images/common/indicator.gif" class="indicator" style="display: none;"></td>
            <td>:</td>
            <td><input name="cp1" id="cp1" class="text ui-widget-content ui-corner-all" size="25" disabled="disabled" style="color: yellow;"/></td>
        </tr>

        <tr>
            <td>Remark</td>
            <td>:</td>
            <td><input name="remark" id="remark" value="RENEW 18 MONTHS MATURITY" class="text ui-widget-content ui-corner-all" size="25"/></td>
            <td style="color: blue; font-weight: bold;">CP2<img src="/images/common/indicator.gif" class="indicator" style="display: none;"></td>
            <td>:</td>
            <td><input name="cp2" id="cp2" class="text ui-widget-content ui-corner-all" size="25" disabled="disabled" style="color: yellow;"/></td>
        </tr>

        <tr>
            <td>Internal Remark</td>
            <td>:</td>
            <td><input name="internalRemark" id="internalRemark" value="RENEW 18 MONTHS MATURITY" class="text ui-widget-content ui-corner-all" size="25"/></td>
            <td style="color: blue; font-weight: bold;">CP3<img src="/images/common/indicator.gif" class="indicator" style="display: none;"></td>
            <td>:</td>
            <td><input name="cp3" id="cp3" class="text ui-widget-content ui-corner-all" size="25" disabled="disabled" style="color: yellow;"/></td>
        </tr>

        <!--<tr>
            <td>Status</td>
            <td>:</td>
            <td>
                <select id="statusCode" name="statusCode">
                    <option value="">(Empty)</option>
                    <option value="<?php /*echo Globals::STATUS_MATURITY_PENDING; */?>"><?php /*echo Globals::STATUS_MATURITY_PENDING; */?></option>
                    <option value="<?php /*echo Globals::STATUS_MATURITY_RENEW; */?>"><?php /*echo Globals::STATUS_MATURITY_RENEW; */?></option>
                    <option value="<?php /*echo Globals::STATUS_MATURITY_WITHDRAW; */?>"><?php /*echo Globals::STATUS_MATURITY_WITHDRAW; */?></option>
                    <option value="<?php /*echo Globals::STATUS_MATURITY_SUCCESS; */?>"><?php /*echo Globals::STATUS_MATURITY_SUCCESS; */?></option>
                </select>
            </td>
        </tr>-->
    </table>
    </fieldset>
</div>
</form>