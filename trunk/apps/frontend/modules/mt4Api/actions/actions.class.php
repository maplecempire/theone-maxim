<?php

/**
 * mt4Api actions.
 *
 * @package    sf_sandbox
 * @subpackage mt4Api
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class mt4ApiActions extends sfActions
{
    /**
     * Executes index action
     *
     */
    public function executeIndex()
    {
    }

    public function executeGetBalance()
    {
    }

    public function executeGetaccountinfo()
    {
        $mlm_distributor = MlmDistributorPeer::retrieveByPK(1);

        $encryptionKey = Globals::MT4_ENCRYPTIONKEY;
        $secretHash = Globals::MT4_SECRETHASH;

        $mt4request = new CMT4DataReciver;
        $mt4request->OpenConnection(Globals::MT4_SERVER, Globals::MT4_SERVER_PORT);

        $params = array();
        $params['login'] = "88288828";
        $answerData = $mt4request->MakeRequest("getaccountinfo", $params);

        var_dump($answerData);
        $mt4request->CloseConnection();

        print_r("Done");
        return sfView::HEADER_ONLY;
    }
    public function executeCreateMt4Account()
    {
        $mlm_distributor = MlmDistributorPeer::retrieveByPK(1);

        $encryptionKey = Globals::MT4_ENCRYPTIONKEY;
        $secretHash = Globals::MT4_SECRETHASH;

        $mt4request = new CMT4DataReciver;
        $mt4request->OpenConnection(Globals::MT4_SERVER, Globals::MT4_SERVER_PORT);

        $params['array'] = array();
        $params['group'] = "MX10000";
//        $params['group'] = "KLTEST";
        $params['agent'] = null;
        $params['login'] = "0";
//        $params['country'] = $mlm_distributor->getCountry();
        $params['country'] = "";
        $params['state'] = $mlm_distributor->getState();
        $params['city'] = $mlm_distributor->getLeaderId(); // package price
//        $params['city'] = "";
        $params['address'] = $mlm_distributor->getDistributorCode();
        $params['name'] = $mlm_distributor->getFullName();
        $params['email'] = $mlm_distributor->getEmail();
        $params['password'] = $this->generateMt4Password();
//        $params['password'] = "qwer1234";
        $params['password_investor'] = "123abc";
        $params['password_phone'] = null;
        $params['leverage'] = "100";
        //$params['leverage'] = $this->getRequestParameter('leverage');      2
        $params['zipcode'] = "";
        $params['phone'] = $mlm_distributor->getInitRankCode(); // package price
        $params['id'] = '';
        $params['comment'] = "";
        var_dump($params);
        $answer = $mt4request->MakeRequest("createaccount", $params);

        if ($answer['result'] != 1) {
            var_dump($answer["reason"]);
        }
        else
        {
            $params = array();
			$params['login'] 	= $answer['login'];
			$params['value'] 	= 10000; // above zero for deposits, below zero for withdraws
			$params['comment'] 	= "test balance operation";
            $answer = $mt4request->MakeRequest("changebalance", $params);
            print "<p style='background-color:#EEFFEE'>Account No. <b>".$answer["login"]."</b> credited to balance: ".$_REQUEST['balance'].".</p>";
        }
        $mt4request->CloseConnection();

        print_r("Done");
        return sfView::HEADER_ONLY;
    }

    function generateMt4Password()
    {
        $max_digit = 999999;
        $digit = 6;

        $char = strtoupper(substr(str_shuffle('abcdefghjkmnpqrstuvwxyz'), 0, 4));

        $fcode = rand(0, $max_digit) . "";
        $fcode = str_pad($fcode, $digit, "0", STR_PAD_LEFT);

        return $char.$fcode;
    }
}