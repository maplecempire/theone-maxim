<?php
use_helper('I18N');
?>

<script type="text/javascript">
var walletDatagrid = null;
var drawType = "<?php echo $doAction;?>";
$(function() {
    /*$('#debitAccountAmount').autoNumeric({
        mDec: 2
    });*/

    $("#registerForm").validate({
        messages : {

        },
        rules : {
            "fullname" : {
                required : true,
                minlength : 2
            },
            "mt4Password" : {
                required : true,
                minlength : 2
            },
            "mt4Username" : {
                required : true,
                minlength : 2
            },
            "email" : {
                required : true
                , email: true
            }
        },
        submitHandler: function(form) {
            waiting();
            $.ajax({
                type : 'POST',
                url : "<?php echo url_for("/marketing/doSendLuckyDraw"); ?>",
                dataType : 'json',
                cache: false,
                data: {
                    fullname : $('#fullname').val()
                    , email : $('#email').val()
                    , mt4Username : $('#mt4Username').val()
                    , mt4Password : $('#mt4Password').val()
                    , optPackage : $('#optPackage').val()
                    , drawType : drawType
                },
                success : function(data) {
                    alert(data.message);
                    walletDatagrid.fnDraw();
                },
                error : function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Your login attempt was not successful. Please try again.");
                }
            });
        },
        success: function(label) {
        }
    });

    $("#btnSubmit").button();
});
</script>

<input type="hidden" id="distId" value="0">
<div style="padding: 10px; top: 30px; position: absolute; width: 1000px">
    <div class="portlet">
        <div class="portlet-header"><?php echo $screenLebel ?></div>
        <div class="portlet-content">
            <div id="divPIPS">
                <form id="registerForm" name="registerForm">
                <table class="display" id="datagridByMonth" border="0" width="100%">

                    <tr>
                        <td class="caption">Full Name</td>
                        <td class="value">
                            <input type="text" name="fullname" id="fullname" value="" size="50">
                        </td>
                    </tr>
                    <tr>
                        <td class="caption">Email</td>
                        <td class="value">
                            <input type="text" name="email" id="email" value="" size="50">
                        </td>
                    </tr>
                    <tr>
                        <td class="caption">MT4 Username</td>
                        <td class="value">
                            <input type="text" name="mt4Username" id="mt4Username" value="" size="50">
                        </td>
                    </tr>
                    <tr>
                        <td class="caption">MT4 Password</td>
                        <td class="value">
                            <input type="text" name="mt4Password" id="mt4Password" value="" size="50">
                        </td>
                    </tr>
                    <tr>
                        <td class="caption" style="width: 25%">Amount</td>
                        <td class="value">
                            <?php if ($doAction == "EVENT") { ?>
                            <select id="optPackage">
                                <option value="100">100</option>
                                <option value="300">300</option>
                                <option value="400">400</option>
                                <option value="500">500</option>
                                <option value="600">600</option>
                                <option value="1,000">1,000</option>
                                <option value="2,000">2,000</option>
                                <option value="3,000">3,000</option>
                                <option value="5,000">5,000</option>
                                <option value="10,000">10,000</option>
                            </select>
                            <?php } else { ?>
                            <select id="optPackage">
                                <option value="100">100</option>
                                <option value="300">300</option>
                                <option value="400">400</option>
                                <option value="500">500</option>
                                <option value="600">600</option>
                                <option value="1,000">1,000</option>
                                <option value="3,000">3,000</option>
                                <option value="5,000">5,000</option>
                                <option value="10,000">10,000</option>
                                <option value="30,000">30,000</option>
                            </select>
                            <?php } ?>
                        </td>
                    </tr>

                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            <button id="btnSubmit"><?php echo __('Submit') ?></button>
                        </td>
                    </tr>
                </table>
                </form>
            </div>
            <script type="text/javascript">

                $(function() {


                    walletDatagrid = $("#walletDatagrid").r9jasonDataTable({
                        // online1DataTable extra params
                        "idTr" : true, // assign <tr id='xxx'> from 1st columns array(aoColumns);
                        "extraParam" : function(aoData) { // pass extra params to server
                            aoData.push({ "name": "filterSearch_email", "value": $("#search_email").val()  });
                            aoData.push({ "name": "filterSearch_mt4Username", "value": $("#search_mt4Username").val()  });
                            aoData.push({ "name": "filterSearch_fullname", "value": $("#search_fullname").val()  });
                            aoData.push({ "name": "filterSearch_drawType", "value": drawType  });
                        },
                        "reassignEvent" : function() { // extra function for reassignEvent when JSON is back from server
                        },

                        // datatables params
                        "bLengthChange": true,
                        "bFilter": false,
                        "bProcessing": true,
                        "bServerSide": true,
                        "bAutoWidth": false,
                        "sAjaxSource": "<?php echo url_for('marketingList/luckydrawList') ?>",
                        "sPaginationType": "full_numbers",
                        "aaSorting": [
                            [0,'desc']
                        ],
                        "aoColumns": [
                            { "sName" : "lucky_id", "bVisible" : false},
                            { "sName" : "created_on",  "bSortable": true},
                            { "sName" : "full_name",  "bSortable": true},
                            { "sName" : "email",  "bSortable": true},
                            { "sName" : "mt4_username",  "bSortable": true},
                            { "sName" : "mt4_password",  "bSortable": true},
                            { "sName" : "amount",  "bSortable": true},
                            { "sName" : "status_code",  "bSortable": true}
                        ]
                    });

                }); // end $(function())

            </script>
            <br>

            <div id="tabs-pipsBonus">
                <table class="display" id="walletDatagrid" border="0" width="100%" cellpadding="0" cellspacing="0">
                    <thead>
                    <tr>
                        <th>id [hidden]</th>
                        <th>Date</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>MT4 Username</th>
                        <th>MT4 Password</th>
                        <th>Amount</th>
                        <th>Status Code</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><input title="" size="10" type="text" id="search_fullname" value="" class="search_init"/></td>
                        <td><input title="" size="10" type="text" id="search_email" value="" class="search_init"/></td>
                        <td><input title="" size="10" type="text" id="search_mt4Username" value="" class="search_init"/></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </thead>
                </table>
            </div>

        </div>
    </div>
</div>