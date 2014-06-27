

<?php 

	$parameters = array(
					'sign_type'           =>   $_REQUEST['sign_type'],
					'service_version'     =>   $_REQUEST['service_version'],
					'trade_state'         =>   $_REQUEST['trade_state'],
					'pay_info'            =>   $_REQUEST['pay_info'],
					'partner'             =>   $_REQUEST['partner'],
					'order_money'         =>   $_REQUEST['order_money'],
					'fee_type'            =>   $_REQUEST['fee_type'],
					'transaction_id'      =>   $_REQUEST['transaction_id'],
					'out_trade_no'        =>   $_REQUEST['out_trade_no'],
					'attach'              =>   $_REQUEST['attach'],
					'time_end'            =>   $_REQUEST['time_end'],
					'key'                 =>   '3ec05ef3979fb5c9a87e8166ec2d0d2b',
				);
				
		foreach ($parameters as $key => $value){
			if(isset($value))
				$preStr .= $key.'='.$value.'&';
		}
		
		$preStr = substr($preStr, 0, strlen($returnStr)-1);
		
		
		//die($preStr);
		
		$sign = strtoupper(md5($preStr));
		//die($sign.'---------'.$_GET['sign']);
		if($_REQUEST['trade_state']=='0'){
			if($sign==$_REQUEST['sign']){
				echo 'success';
			}else{
				echo 'fail';
			}
		}else{
			die('fail:  '.$_GET['trade_state']);
		}
?>