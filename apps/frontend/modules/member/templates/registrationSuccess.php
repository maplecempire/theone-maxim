<?php include('scripts.php'); ?>
	<style type="text/css">
    .login_t72 td {
        white-space: nowrap;
    }
    .login_t72 td {
        color: #BEBEBE;
        vertical-align: top;
    }
    .fullname {
        color: #ffffff;
        vertical-align: top;
        font-weight: bold;
    }
    .login_t74 {
        text-align: right;
        white-space: nowrap;
    }
    .login_t72 tr {
        height: 30px;
        vertical-align: top;
    }
    
    </style>

    <script type="text/javascript">
        $(function() {
            $("#dob").val("").datepicker({
                dayNamesMin: "<dayNamesMin>"
                , monthNamesShort: "<monthNamesShort>"
            });
            $("#registerForm").validate({
                messages : {
                    confirmPassword: {
                        equalTo: "<?php echo __('Please enter the same password as above') ?>"
                    },
                    captcha: "<br><?php echo __('Correct captcha is required') ?>",
                    nickName: {
                        remote: "<?php echo __('Alias already in use') ?>."
                    }
                },
                rules : {
                    "captcha" : {
                        required: true,
                        remote: "/captcha/process"
                    },
                    "sponsorId" : {
                        required: true,
                        minlength : 8
                    },
                    "userpassword" : {
                        required : true,
                        minlength : 3
                    },
                    "confirmPassword" : {
                        required : true,
                        minlength : 3,
                        equalTo: "#userpassword"
                    },
                    "fullname" : {
                        required : true,
                        minlength : 3
                    },
                    "nickName" : {
                        required : true,
                        minlength : 3,
                        remote: "/member/verifyNickName"
                    },
                    "ic" : {
                        required : true,
                        minlength : 3
                    },
                    "address" : {
                        required : true,
                        minlength : 3
                    },
                    "postcode" : {
                        required : true,
                        minlength : 3
                    },
                    "email" : {
                        required : true
                        , email: true
                    },
                    "contactNumber" : {
                        required : true
                        , minlength : 10
                    },
                    "dob" : {
                        required : true
                    }
                },
                submitHandler: function(form) {
                    $("#chkTerm").removeClass("error");

                    if ($("#chkTerm").attr("checked") != "checked") {
                        $("#chkTerm").addClass("error");
                        alert("<?php echo __('Please accept our Terms & Conditions and Privacy Policy') ?>.");
                        return false;
                    }
                    if ($.trim($('#sponsorId').val()) == "") {
                        alert("<?php echo __('Referrer ID cannot be blank') ?>.");
                        $('#sponsorId').focus();
                    } else {
                        waiting();
                        $.ajax({
                            type : 'POST',
                            url : "/member/verifySponsorId",
                            dataType : 'json',
                            cache: false,
                            data: {
                                sponsorId : $('#sponsorId').val()
                            },
                            success : function(data) {
                                waiting();
                                if (data == null || data == "") {
                                    alert("<?php echo __('Invalid Referrer ID') ?>");
                                    $('#sponsorId').focus();
                                    $("#sponsorName").html("");
                                } else {
                                    form.submit();
                                }
                            },
                            error : function(XMLHttpRequest, textStatus, errorThrown) {
                                alert("Your login attempt was not successful. Please try again.");
                            }
                        });
                    }
                },
                success: function(label) {
                    //label.addClass("valid").text("Valid captcha!")
                }
            });
          
            $("#sponsorId").change(function(){
                if ($.trim($('#sponsorId').val()) != "") {
                    verifySponsorId();
                }
            });
        });

        function verifySponsorId() {
            waiting();
            $.ajax({
                type : 'POST',
                url : "/member/verifySponsorId",
                dataType : 'json',
                cache: false,
                data: {
                    sponsorId : $('#sponsorId').val()
                },
                success : function(data) {
                    if (data == null || data == "") {
                        alert("<?php echo __('Invalid Member ID.') ?>");
                        $('#sponsorId').focus();
                        $("#sponsorName").html("");
                    } else {
                        $.unblockUI();
                        $("#sponsorName").html(data.userName);
                    }
                },
                error : function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Your login attempt was not successful. Please try again.");
                }
            });
        }
    </script>
    

<form action="/member/doRegistration" method="post" id="registerForm" class="cmxform">
<table cellpadding="0" cellspacing="5" align="center" border="0">
<tr>
<td>
    <table cellspacing="5" cellpadding="0" width="50%">
        <tr>
            <td class="login_t74">
                <span id="Label4"><font color='white'><?php echo __('Referrer ID') ?></font></span>
            </td>
            <td width="400px">
                <input name="sponsorId" type="text" id="sponsorId" tabindex="1" class="login_t73" />
            </td>
        </tr>
        <tr>
            <td class="login_t74">
				<span id="Label25"><font color='white'><?php echo __('Referrer Name') ?></font></span>
            </td>
            <td>
                <span id="sponsorName" class="fullname"></span>
            </td>
        </tr>
        <tr class="login_t80">
            <td class="login_t74" valign="top">
                <span id="Label5"><font color='white'><?php echo __('Set Password') ?></font></span>
            </td>

            <td>
                <input name="userpassword" type="password" id="userpassword" tabindex="2" class="login_t73"/>
            </td>
        </tr>

        <tr>
            <td class="login_t74">
                <span id="Label10"><font color='white'><?php echo __('Confirm Password') ?></font></span>
            </td>
            <td>
                <input name="confirmPassword" type="password" id="confirmPassword" tabindex="3"
                       class="login_t73"/>

            </td>
        </tr>
        <tr>
            <td class="login_t74">
                <span id="Label13"><font color='white'><?php echo __('Full Name') ?></font></span>
            </td>
            <td>
                <input name="fullname" type="text" id="fullname" tabindex="4" class="login_t73"/>
            </td>
        </tr>
        <tr>
            <td class="login_t74">
                <span id="LabelNickName"><font color='white'><?php echo __('Alias') ?></font></span>
            </td>
            <td>
                <input name="nickName" type="text" id="nickName" tabindex="5" class="login_t73" />
            </td>
        </tr>
        <tr>
            <td class="login_t74">

                <span id="Label15"><font color='white'><?php echo __('Passport/ID Card No.') ?></font></span>
            </td>
            <td>
                <input name="ic" type="text" id="ic" tabindex="7" class="login_t73"/></td>
        </tr>
    </table>
</td>
<td>
<table cellspacing="5" cellpadding="0">

<tr>
<td class="login_t74">
    <span id="Label6"><font color='white'><?php echo __('Country') ?></font></span>
</td>
<td>
<?php //echo select_country_tag('country', 'MY');

$countrycodes = array();
array_push($countrycodes,'Afghanistan@93@'.__('Afghanistan'));
array_push($countrycodes,'Albania@355@'.__('Albania'));
array_push($countrycodes,'Algeria@213@'.__('Algeria'));
array_push($countrycodes,'American Samoa@684@'.__('American Samoa'));
array_push($countrycodes,'Andorra@376@'.__('Andorra'));
array_push($countrycodes,'Argentina@54@'.__('Argentina'));
array_push($countrycodes,'Armenia@374@'.__('Armenia'));
array_push($countrycodes,'Aruba@297@'.__('Aruba'));
array_push($countrycodes,'Ascension Land@247@'.__('Ascension Land'));
array_push($countrycodes,'Australia@61@'.__('Australia'));
array_push($countrycodes,'Austria@43@'.__('Austria'));
array_push($countrycodes,'Azerbaijan@994@'.__('Azerbaijan'));
array_push($countrycodes,'Bahrain@973@'.__('Bahrain'));
array_push($countrycodes,'Belgium@32@'.__('Belgium'));
array_push($countrycodes,'Belize@501@'.__('Belize'));
array_push($countrycodes,'Benin@229@'.__('Benin'));
array_push($countrycodes,'Bhutan@975@'.__('Bhutan'));
array_push($countrycodes,'Bolivia@591@'.__('Bolivia'));
array_push($countrycodes,'Bosnia@387@'.__('Bosnia'));
array_push($countrycodes,'Botswana@267@'.__('Botswana'));
array_push($countrycodes,'Brazil@55@'.__('Brazil'));
array_push($countrycodes,'Brunei@673@'.__('Brunei'));
array_push($countrycodes,'Bulgaria@359@'.__('Bulgaria'));
array_push($countrycodes,'Burkina Faso@226@'.__('Burkina Faso'));
array_push($countrycodes,'Burundi@257@'.__('Burundi'));
array_push($countrycodes,'Cambodia@855@'.__('Cambodia'));
array_push($countrycodes,'Cameron@237@'.__('Cameron'));
array_push($countrycodes,'Canada@1@'.__('Canada'));
array_push($countrycodes,'Chad@235@'.__('Chad'));
array_push($countrycodes,'Chile@56@'.__('Chile'));
array_push($countrycodes,'China (PRC)@86@'.__('China (PRC)'));
array_push($countrycodes,'Colombia@57@'.__('Colombia'));
array_push($countrycodes,'Costa Rica@506@'.__('Costa Rica'));
array_push($countrycodes,'Croatia@385@'.__('Croatia'));
array_push($countrycodes,'Cuba@53@'.__('Cuba'));
array_push($countrycodes,'Cyprus@357@'.__('Cyprus'));
array_push($countrycodes,'Czech Republic@420@'.__('Czech Republic'));
array_push($countrycodes,'Denmark@45@'.__('Denmark'));
array_push($countrycodes,'Deigo Garicia@246@'.__('Deigo Garicia'));
array_push($countrycodes,'Djibouti@253@'.__('Djibouti'));
array_push($countrycodes,'Ecuador@593@'.__('Ecuador'));
array_push($countrycodes,'Egypt@20@'.__('Egypt'));
array_push($countrycodes,'El Salvador@503@'.__('El Salvador'));
array_push($countrycodes,'Equatorial Guinea@24@'.__('Equatorial Guinea'));
array_push($countrycodes,'Eritrea@291@'.__('Eritrea'));
array_push($countrycodes,'Estonia@372@'.__('Estonia'));
array_push($countrycodes,'Ethiopia@251@'.__('Ethiopia'));
array_push($countrycodes,'Faeroe Islands@298@'.__('Faeroe Islands'));
array_push($countrycodes,'Falkland Islands@500@'.__('Falkland Islands'));
array_push($countrycodes,'Fiji Islands@679@'.__('Fiji Islands'));
array_push($countrycodes,'Finland@358@'.__('Finland'));
array_push($countrycodes,'France@33@'.__('France'));
array_push($countrycodes,'French Antilles@596@'.__('French Antilles'));
array_push($countrycodes,'French Guiana@594@'.__('French Guiana'));
array_push($countrycodes,'French Polynesia@689@'.__('French Polynesia'));
array_push($countrycodes,'Gabon@241@'.__('Gabon'));
array_push($countrycodes,'Gambia@220@'.__('Gambia'));
array_push($countrycodes,'Georgia@995@'.__('Georgia'));
array_push($countrycodes,'Germany@49@'.__('Germany'));
array_push($countrycodes,'Ghana@233@'.__('Ghana'));
array_push($countrycodes,'Gibraltar@350@'.__('Gibraltar'));
array_push($countrycodes,'Greece@30@'.__('Greece'));
array_push($countrycodes,'Greenland@299@'.__('Greenland'));
array_push($countrycodes,'Guinea-Bissau@245@'.__('Guinea-Bissau'));
array_push($countrycodes,'Guinea (PRP)@224@'.__('Guinea (PRP)'));
array_push($countrycodes,'HongKong@852@'.__('HongKong'));
array_push($countrycodes,'Hungary@36@'.__('Hungary'));
array_push($countrycodes,'Iceland@353@'.__('Iceland'));
array_push($countrycodes,'Indonesia@62@'.__('Indonesia'));
array_push($countrycodes,'Islands@682@'.__('Islands'));
array_push($countrycodes,'Israel@972@'.__('Israel'));
array_push($countrycodes,'Italy@39@'.__('Italy'));
array_push($countrycodes,'Jamaica@1876@'.__('Jamaica'));
array_push($countrycodes,'Japan@81@'.__('Japan'));
array_push($countrycodes,'Jordan@962@'.__('Jordan'));
array_push($countrycodes,'Kazakhsthan@7@'.__('Kazakhsthan'));
array_push($countrycodes,'Kenya@254@'.__('Kenya'));
array_push($countrycodes,'Kiribati@686@'.__('Kiribati'));
array_push($countrycodes,'Korea North@850@'.__('Korea North'));
array_push($countrycodes,'Korea South@82@'.__('Korea South'));
array_push($countrycodes,'Kuwait@965@'.__('Kuwait'));
array_push($countrycodes,'Laos@856@'.__('Laos'));
array_push($countrycodes,'Latvia@371@'.__('Latvia'));
array_push($countrycodes,'Lebanon@961@'.__('Lebanon'));
array_push($countrycodes,'Lesotho@266@'.__('Lesotho'));
array_push($countrycodes,'Liberia@231@'.__('Liberia'));
array_push($countrycodes,'Libya@218@'.__('Libya'));
array_push($countrycodes,'Liechtenstein@423@'.__('Liechtenstein'));
array_push($countrycodes,'Lithuania@370@'.__('Lithuania'));
array_push($countrycodes,'Luxembourg@352@'.__('Luxembourg'));
array_push($countrycodes,'Macau@853@'.__('Macau'));
array_push($countrycodes,'Macedonia@389@'.__('Macedonia'));
array_push($countrycodes,'Madagascar@261@'.__('Madagascar'));
array_push($countrycodes,'Malawi@265@'.__('Malawi'));
array_push($countrycodes,'Malaysia@60@'.__('Malaysia'));
array_push($countrycodes,'Maldives@960@'.__('Maldives'));
array_push($countrycodes,'Mali Republic@223@'.__('Mali Republic'));
array_push($countrycodes,'Malta@356@'.__('Malta'));
array_push($countrycodes,'Martinique@596@'.__('Martinique'));
array_push($countrycodes,'Maurutania@222@'.__('Maurutania'));
array_push($countrycodes,'Mauritius@230@'.__('Mauritius'));
array_push($countrycodes,'Mexico@52@'.__('Mexico'));
array_push($countrycodes,'Mongolia@976@'.__('Mongolia'));
array_push($countrycodes,'Morocco@212@'.__('Morocco'));
array_push($countrycodes,'Mozambique@258@'.__('Mozambique'));
array_push($countrycodes,'Myanmar@95@'.__('Myanmar'));
array_push($countrycodes,'Namibia@264@'.__('Namibia'));
array_push($countrycodes,'Nauru@674@'.__('Nauru'));
array_push($countrycodes,'Nepal@977@'.__('Nepal'));
array_push($countrycodes,'Netherlands@31@'.__('Netherlands'));
array_push($countrycodes,'New Zealand@64@'.__('New Zealand'));
array_push($countrycodes,'Nicaragua@505@'.__('Nicaragua'));
array_push($countrycodes,'Niger@227@'.__('Niger'));
array_push($countrycodes,'Nigeria@234@'.__('Nigeria'));
array_push($countrycodes,'Niue@683@'.__('Niue'));
array_push($countrycodes,'Norfolk Island@672@'.__('Norfolk Island'));
array_push($countrycodes,'Norway@47@'.__('Norway'));
array_push($countrycodes,'Oman@968@'.__('Oman'));
array_push($countrycodes,'Pakistan@92@'.__('Pakistan'));
array_push($countrycodes,'Palau@680@'.__('Palau'));
array_push($countrycodes,'Palestine@970@'.__('Palestine'));
array_push($countrycodes,'Panama@507@'.__('Panama'));
array_push($countrycodes,'Paraguay@595@'.__('Paraguay'));
array_push($countrycodes,'Peru@51@'.__('Peru'));
array_push($countrycodes,'Philippines@63@'.__('Philippines'));
array_push($countrycodes,'Poland@48@'.__('Poland'));
array_push($countrycodes,'Portugal@351@'.__('Portugal'));
array_push($countrycodes,'Qatar@974@'.__('Qatar'));
array_push($countrycodes,'Reunion Island@262@'.__('Reunion Island'));
array_push($countrycodes,'Romania@40@'.__('Romania'));
array_push($countrycodes,'Russia@7@'.__('Russia'));
array_push($countrycodes,'Rwanda@250@'.__('Rwanda'));
array_push($countrycodes,'San Marino@378@'.__('San Marino'));
array_push($countrycodes,'Saudi Arabia@9666@'.__('Saudi Arabia'));
array_push($countrycodes,'Senegal@221@'.__('Senegal'));
array_push($countrycodes,'Serbia@381@'.__('Serbia'));
array_push($countrycodes,'Seychelles Islands@248@'.__('Seychelles Islands'));
array_push($countrycodes,'Sierra Leone@232@'.__('Sierra Leone'));
array_push($countrycodes,'Singapore@65@'.__('Singapore'));
array_push($countrycodes,'Slovak Republic@421@'.__('Slovak Republic'));
array_push($countrycodes,'Slovenia@386@'.__('Slovenia'));
array_push($countrycodes,'Solomon Islands@677@'.__('Solomon Islands'));
array_push($countrycodes,'South Africa@27@'.__('South Africa'));
array_push($countrycodes,'Spain@34@'.__('Spain'));
array_push($countrycodes,'Sri Lanka@94@'.__('Sri Lanka'));
array_push($countrycodes,'Sudan@249@'.__('Sudan'));
array_push($countrycodes,'Suriname@597@'.__('Suriname'));
array_push($countrycodes,'Swaziland@268@'.__('Swaziland'));
array_push($countrycodes,'Sweden@46@'.__('Sweden'));
array_push($countrycodes,'Switzerland@41@'.__('Switzerland'));
array_push($countrycodes,'Syria@963@'.__('Syria'));
array_push($countrycodes,'Taiwan@886@'.__('Taiwan'));
array_push($countrycodes,'Tajikistan@992@'.__('Tajikistan'));
array_push($countrycodes,'Tanzania@255@'.__('Tanzania'));
array_push($countrycodes,'Thailand@66@'.__('Thailand'));
array_push($countrycodes,'Toto@228@'.__('Toto'));
array_push($countrycodes,'Tonga Islands@676@'.__('Tonga Islands'));
array_push($countrycodes,'Tunisia@216@'.__('Tunisia'));
array_push($countrycodes,'Turkey@90@'.__('Turkey'));
array_push($countrycodes,'Turkmenistan@993@'.__('Turkmenistan'));
array_push($countrycodes,'Tuvalu@688@'.__('Tuvalu'));
array_push($countrycodes,'Uganda@256@'.__('Uganda'));
array_push($countrycodes,'Ukraine@380@'.__('Ukraine'));
array_push($countrycodes,'UAE@971@'.__('UAE'));
array_push($countrycodes,'United Kingdom@44@'.__('United Kingdom'));
array_push($countrycodes,'USA@1@'.__('USA'));
array_push($countrycodes,'Uruguay@598@'.__('Uruguay'));
array_push($countrycodes,'Uzbekistan@998@'.__('Uzbekistan'));
array_push($countrycodes,'Vanuatu@678@'.__('Vanuatu'));
array_push($countrycodes,'Vatican City@39@'.__('Vatican City'));
array_push($countrycodes,'Venezuela@58@'.__('Venezuela'));
array_push($countrycodes,'Vietnam@84@'.__('Vietnam'));
array_push($countrycodes,'Western Samoa@685@'.__('Western Samoa'));
array_push($countrycodes,'Yemen@967@'.__('Yemen'));
array_push($countrycodes,'Yugoslavia@381@'.__('Yugoslavia'));
array_push($countrycodes,'Zambia@260@'.__('Zambia'));
array_push($countrycodes,'Zanzibar@255@'.__('Zanzibar'));
array_push($countrycodes,'Zimbabwe@263@'.__('Zimbabwe'));

echo "<select name='country' id='country'>";
foreach ($countrycodes as $countrycode) {
	$position = explode('@', $countrycode);
  	$name = $position[2];
  	$code = $position[0];
  	
  	echo "<option value=".$code.">".$name."</option>";
}
echo "</select>";
?>
</td>
</tr>
<tr>
    <td class="login_t74">
        <span id="Label7"><font color='white'><?php echo __('Address') ?></font></span>
    </td>
    <td>
        <input name="address" type="text" id="address" tabindex="11" class="login_t73"/>
</td>

</tr>
<tr>
    <td class="login_t74">
        <span id="Label17"><font color='white'><?php echo __('Postal Code') ?></font></span>
    </td>
    <td>
        <input name="postcode" type="text" id="postcode" tabindex="12" class="login_t73"/>
    </td>
</tr>
<tr class="login_t80">
    <td class="login_t74" valign="top">
        <span id="Label18"><font color='white'><?php echo __('Email') ?></font></span>
    </td>
    <td>
        <input name="email" type="text" id="email" tabindex="13" class="login_t73"/>
    </td>
</tr>
<tr class="login_t80">
    <td class="login_t74" valign="top">

        <span id="Label19"><font color='white'><?php echo __('Contact No.') ?></font></span>
    </td>
    <td>
        <input name="contactNumber" type="text" id="contactNumber" tabindex="14" class="bp_05"/>
    </td>
</tr>
<tr>
    <td class="login_t74" style="padding-top: 5px;">
        <span id="Label14"><font color='white'><?php echo __('Gender') ?></font></span>
    </td>

    <td>
        <table id="RadioButtonListSex" border="0">
            <tr>
                <td><input id="rdoGender_0" type="radio" name="gender" value="M"
                           checked="checked"/><label for="rdoGender_0"><font color='white'><?php echo __('Male') ?></font></label></td>
                <td><input id="rdoGender_1" type="radio" name="gender" value="F"/><label
                        for="rdoGender_1"><font color='white'><?php echo __('Female') ?></font></label></td>
            </tr>
        </table>
    </td>
</tr>

<tr>
    <td class="login_t74">
        <span id="Label1"><font color='white'><?php echo __('Date of Birth') ?></font></span>
    </td>
    <td>
        <input name="dob" type="text" id="dob" tabindex="14" class="bp_05"/>
    </td>
</tr>
</table>
</td>
</tr>
</table>
<table cellpadding="0" cellspacing="5" width="80%" align="center" border="0">
    <tr height="80">
        <td colspan="4" align="center" height="30">
            <input id="chkTerm" type="checkbox" name="chkTerm"/><span
                id="Label2"><font color='white'><?php echo __('I have read and agreed to the') ?> </span><a id="HyperLink3" href="#" style="color: #e29521"><font color='white'><?php echo __('Terms & Conditions') ?></a>
            <span id="Label8"><font color='white'><?php echo __('and') ?> </span><a id="HyperLink4" href="#" style="color: #e29521"><font color='white'><?php echo __('Privacy Policy') ?></a>.
        </td>

    </tr>
    <tr>
        <td colspan="4" align="center">
            <input type="submit" name="Button1" value="<?php echo __('Register') ?>" language="javascript" id="btnRegister" tabindex="17" class="login_t75"/>
            
            <div id="ValidationSummary1" style="color:Red;width:200px;display:none;">
            </div>
        </td>
    </tr>
</table>

</form>