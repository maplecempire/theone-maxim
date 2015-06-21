<?php include('scripts.php'); ?>

<script type="text/javascript" language="javascript">
$(function() {
    $("#csForm").validate({
        messages : {
            transactionPassword: {
                remote: "Security Password is not valid."
            }
        },
        rules : {
            "transactionPassword" : {
                required : true
                , remote: "/member/verifyTransactionPassword"
            }
            , "contactNoEmail" : {
                required : true
            }
            , "title" : {
                required : true
            }
            , "category" : {
                required : true
            }
        },
        submitHandler: function(form) {
            waiting();
            form.submit();
        }
    });
});

tinyMCE.init({
    // General options
    mode : "exact",
    elements : "message",
    theme : "simple",
    width: "100%"
});
</script>

<table cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td><br></td>
    </tr>
    <tr>
        <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('CS Center') ?></span></td>
    </tr>
    <tr>
        <td><br>
                <?php if ($sf_flash->has('successMsg')): ?>
                <div class="ui-widget">
                    <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
                         class="ui-state-highlight ui-corner-all">
                        <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                                                      class="ui-icon ui-icon-info"></span>
                            <strong><?php echo $sf_flash->get('successMsg') ?></strong></p>
                    </div>
                </div>
                <?php endif; ?>
            <?php if ($sf_flash->has('errorMsg')): ?>
                <div class="ui-widget">
                    <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
                         class="ui-state-error ui-corner-all">
                        <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                                                      class="ui-icon ui-icon-alert"></span>
                            <strong><?php echo $sf_flash->get('errorMsg') ?></strong></p>
                    </div>
                </div>
                <?php endif; ?>

        </td>
    </tr>
    <tr>
        <td>
            <form action="/member/doCustomerEnquiry" id="csForm" name="csForm" method="post">
            <table cellspacing="0" cellpadding="0" class="tbl_form">
                <colgroup>
                    <col width="1%">
                    <col width="30%">
                    <col width="69%">
                    <col width="1%">
                </colgroup>
                <tbody>
                <tr>
                    <th class="tbl_header_left">
                        <div class="border_left_grey">&nbsp;</div>
                    </th>
                    <th colspan="2"><?php echo __('Customer Enquiry') ?></th>
                    <th class="tbl_header_right">
                        <div class="border_right_grey">&nbsp;</div>
                    </th>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Username'); ?></td>
                    <td><b><?php echo $username; ?></b></td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td>
                        <?php echo __('Contact Number / Email') ?>
                    </td>
                    <td>
                        <input name="contactNoEmail" id="contactNoEmail" size="50" value="<?php echo $contactNoEmail; ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td>
                        <?php echo __('Category') ?>
                    </td>
                    <td>
                        <select name='category' id='category'>
                        	<option value=''><?php echo __('Please Select Category') ?></option>
<!--                        	<option value='Genealogy'>--><?php //echo __('Genealogy') ?><!--</option>-->
                        	<option value='User Profile/Credentials'><?php echo __('User Profile/Credentials') ?></option>
                        	<option value='Deposit/CP Points'><?php echo __('Deposit/CP Points') ?></option>
                        	<option value='Investment Returns/Bonuses'><?php echo __('Investment Returns/Bonuses') ?></option>
                        	<option value='MT4 Withdrawal/Reload/Trading'><?php echo __('MT4 Withdrawal/Reload/Trading') ?></option>
                        	<option value='Withdrawal Issues'><?php echo __('Withdrawal Issues') ?></option>
                        	<option value='Contract Maturity'><?php echo __('Contract Maturity') ?></option>
                        	<option value='Maxim Visa Card'><?php echo __('Maxim Visa Card') ?></option>
                        	<option value='Events/Promotions'><?php echo __('Events/Promotions') ?></option>
                        	<option value='Decline Auto Swap'><?php echo __('Decline Auto Swap') ?></option>
                        	<option value='Others'><?php echo __('Others') ?></option>
                        </select>
                        <br>
                        <?php echo __('For legal enquiries, please reach Legal Watch in Member Area.') ?>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td>
                        <?php echo __('Subject') ?>
                    </td>
                    <td>
                        <input name="title" id="title" size="50" value="<?php echo $title; ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td>
                        <?php echo __('Message') ?>
                    </td>
                    <td>
                        <textarea rows="3" cols="3" id="message" name="message"><?php echo $message; ?></textarea>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td>
                        <?php echo __('Security Password'); ?>
                    </td>
                    <td>
                        <input name="transactionPassword" type="password" id="transactionPassword"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td></td>
                    <td align="right">
                        <button id="btnTransfer"><?php echo __('Submit') ?></button>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                </tbody>
            </table>
        </form>

        <div class="info_bottom_bg"></div>
        <div class="clear"></div>
        <br>
        <script type="text/javascript" language="javascript">
        var datagrid = null;
        $(function() {
            datagrid = $("#datagrid").r9jasonDataTable({
                // online1DataTable extra params
                "idTr" : true, // assign <tr id='xxx'> from 1st columns array(aoColumns);
                "extraParam" : function(aoData) { // pass extra params to server
                },
                "reassignEvent" : function() { // extra function for reassignEvent when JSON is back from server
                    reassignDatagridEventAttr();
                },

                // datatables params
                "bLengthChange": true,
                "bFilter": false,
                "bProcessing": true,
                "bServerSide": true,
                "bAutoWidth": false,
                "sAjaxSource": "/business/customerEnquiryList",
                "sPaginationType": "full_numbers",
                "aaSorting": [
                    [1,'desc']
                ],
                "aoColumns": [
                    { "sName" : "enquiry_id", "bVisible" : false,  "bSortable": true},
                    { "sName" : "updated_on", "bVisible" : true,  "bSortable": true},
                    { "sName" : "title",  "bSortable": true},
                    { "sName" : "admin_updated",  "bSortable": true},
                    { "sName" : "distributor_read",  "bVisible": true, "fnRender": function ( oObj ) {
                        if (oObj.aData[4] == "Read") {
                            return "<a href='/member/customerEnquiryDetail?enquiryId=" + oObj.aData[0] + "'>Read</a>";
                        } else if (oObj.aData[4] == "Unread") {
                            return "<a href='/member/customerEnquiryDetail?enquiryId=" + oObj.aData[0] + "' style='color:#0088CF'>Unread</a>";
                        }
                    }}
                ]
            });
        }); // end function

        function reassignDatagridEventAttr() {
        }
    </script>

    <table cellspacing="0" cellpadding="0" class="tbl_form">
            <colgroup>
                <col width="1%">
                <col width="30%">
                <col width="69%">
                <col width="1%">
            </colgroup>
            <tbody>
            <tr>
                <th class="tbl_header_left">
                    <div class="border_left_grey">&nbsp;</div>
                </th>
                <th><?php echo __('Enquiry History') ?></th>
                <th class="tbl_content_right"></th>
                <th class="tbl_header_right">
                    <div class="border_right_grey">&nbsp;</div>
                </th>
            </tr>
            </tbody>
        </table>
        <br>

        <table class="display" id="datagrid" border="0" width="100%">
            <thead>
            <tr>
                <th></th>
                <th><?php echo __('Date') ?></th>
                <th><?php echo __('Subject') ?></th>
                <th><?php echo __('Last Reply') ?></th>
                <th><?php echo __('Read / Unread') ?></th>
            </tr>
            </thead>
        </table>
        </td>
    </tr>
    </tbody>
</table>