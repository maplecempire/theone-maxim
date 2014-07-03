<?php

/**
 * paymentGateway actions.
 *
 * @package    sf_sandbox
 * @subpackage paymentGateway
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class paymentGatewayActions extends sfActions
{
    /**
     * Executes index action
     *
     */
    public function executeIndex()
    {
    }

    public function executeSubmit()
    {
        // Print out "OK" to notify us you have received the payment result 
        echo "OK";

        //compare security token
        //$security_code = "paymentasia";
        $security_code = "sayyestomaximtrader";
        If (md5($_POST["orderRef"] . $_POST["successcode"] . $_POST["amount"] . $security_code) == $_POST["token"]) {
            if ($_POST["successcode"] == "0") {
                // Transaction Accepted
                // *** Add the Security Control here, to check the currency, amount with the merchant's order
                // reference from your database, if the order exist then accepted.
                // Update your database for Transaction Accepted and send email or notify your customer .
                echo "success";
            } else {
                // Transaction Rejected
                // Update your database for Transaction Rejected
                echo "rejected";
            }
        }
    }
}
