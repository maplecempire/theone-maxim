<?php
/**
 * member actions.
 *
 * @package    sf_sandbox
 * @subpackage member
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class memberActions extends sfActions
{
    public function executeVerifyActivePlacementDistId()
    {
        $sponsorId = $this->getRequestParameter('sponsorId');
        $placementDistId = $this->getRequestParameter('placementDistId');

        //$array = explode(',', Globals::STATUS_ACTIVE.",".Globals::STATUS_PENDING);
        $c = new Criteria();
        $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $placementDistId);
        $c->add(MlmDistributorPeer::PLACEMENT_TREE_STRUCTURE, "%".$sponsorId."%", Criteria::LIKE);
        $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        $existUser = MlmDistributorPeer::doSelectOne($c);

        $arr = "";
        if ($existUser) {
            //if ($existUser->getDistributorId() <> $this->getUser()->getAttribute(Globals::SESSION_DISTID)) {
            $arr = array(
                'userId' => $existUser->getDistributorId(),
                'userName' => $existUser->getDistributorCode(),
                'fullname' => $existUser->getFullName(),
                'nickname' => $existUser->getNickname()
            );
            //}
        }

        echo json_encode($arr);
        return sfView::HEADER_ONLY;
    }
    public function executePurchasePackageViaTree()
    {
        $uplineDistCode = $this->getRequestParameter('distcode');
        $position = $this->getRequestParameter('position');

        $c = new Criteria();
        $packageDBs = MlmPackagePeer::doSelect($c);

        $this->systemCurrency = $this->getAppSetting(Globals::SETTING_SYSTEM_CURRENCY);
        $this->pointAvailable = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);
        $this->packageDBs = $packageDBs;

        $this->uplineDistCode = $uplineDistCode;
        $this->position = $position;
    }
    public function executePurchasePackageViaTree2()
    {
        $this->uplineDistCode = $this->getRequestParameter('uplineDistCode');
        $this->position = $this->getRequestParameter('position');
        //var_dump($this->getRequestParameter('uplineDistCode'));
        if ($this->getRequestParameter('pid') <> "") {
            $ledgerEPointBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);
            $selectedPackage = MlmPackagePeer::retrieveByPK($this->getRequestParameter('pid'));
            $this->forward404Unless($selectedPackage);

            $amountNeeded = $selectedPackage->getPrice();

            $existDist = MlmDistributorPeer::retrieveByPK($this->getRequestParameter('sponsorId', $this->getUser()->getAttribute(Globals::SESSION_DISTID)));
            $this->forward404Unless($existDist);
            $this->sponsorId = $existDist->getDistributorCode();
            $this->sponsorName = $existDist->getFullName();

            if ($amountNeeded > $ledgerEPointBalance) {
                $this->setFlash('errorMsg', "In-sufficient CP1 amount");
                return $this->redirect('/member/purchasePackageViaTree');
            }

            $this->selectedPackage = $selectedPackage;
            $this->productCode = $this->getRequestParameter('productCode');
        } else {
            return $this->redirect('/member/purchasePackageViaTree');
        }
    }
    public function executeUpgradePackageViaTree()
    {
        $distCode = $this->getRequestParameter('distcode');
        $c = new Criteria();
        $c->addAscendingOrderByColumn(MlmPackagePeer::PRICE);
        $packageDBs = MlmPackagePeer::doSelect($c);

        $c = new Criteria();
        $c->addDescendingOrderByColumn(MlmPackagePeer::PRICE);
        $highestPackageDB = MlmPackagePeer::doSelectOne($c);

        $c = new Criteria();
        $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $distCode);
        $distDB = MlmDistributorPeer::doSelectOne($c);
        $this->forward404Unless($distDB);

        $distPackage = MlmPackagePeer::retrieveByPK($distDB->getRankId());

        $this->systemCurrency = $this->getAppSetting(Globals::SETTING_SYSTEM_CURRENCY);
        $this->pointAvailable = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);
        $this->packageDBs = $packageDBs;
        $this->distPackage = $distPackage;
        $this->distDB = $distDB;
        $this->highestPackageDB = $highestPackageDB;
        $this->distCode = $distCode;
    }
    public function executeUnderMaintenance()
    {
    }
    public function executeExchange()
    {
    }
    public function executeDailyFxGuide()
    {
    }
    public function executeFundManagementReport()
    {
    }
    public function executeMaximExecutorReport()
    {
    }
    public function executeForgetPassword()
    {
        if ($this->getRequestParameter('email') && $this->getRequestParameter('username')) {
            $email = $this->getRequestParameter('email');
            $username = $this->getRequestParameter('username');

            $this->email = $email;
            $this->username = $username;

            $c = new Criteria();
            $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $username);
            $c->add(MlmDistributorPeer::EMAIL, $email);
            $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
            $existDistributor = MlmDistributorPeer::doSelectOne($c);

            if ($existDistributor) {
                $c = new Criteria();
                $c->add(AppUserPeer::USERNAME, $username);
                $c->add(AppUserPeer::USER_ROLE, Globals::ROLE_DISTRIBUTOR);
                $c->add(AppUserPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
                $existUser = AppUserPeer::doSelectOne($c);

                if ($existUser) {
                    /****************************/
                    /*****  Send email **********/
                    /****************************/
                    $password = $existUser->getUserpassword();

                    $subject = $this->getContext()->getI18N()->__("Password requested for maximtrader.com", null, 'email');
                    $body = $this->getContext()->getI18N()->__("Dear %1%", array('%1%' => $existDistributor->getNickname()), 'email') . ",<p><p>
                    <p>" . $this->getContext()->getI18N()->__("Your login password for maximtrader.com. ", null, 'email') . "</p>
                    <p><b>" . $this->getContext()->getI18N()->__("Login ID", null) . ": " . $username . "</b>
                    <p><b>" . $this->getContext()->getI18N()->__("Password", null) . ": " . $password . "</b>";

                    $sendMailService = new SendMailService();
                    $sendMailService->sendForgetPassword($existDistributor, $subject, $body);

                    $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Password already sent to your email account. Please check your inbox."));
                } else {
                    $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Email is not matching to your username."));
                }
            } else {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Email is not matching to your username."));
            }
            return $this->redirect('/member/forgetPassword');
        }
    }

    public function executeInitData()
    {
        var_dump($_SERVER['HTTP_HOST']);
        print_r("Done");
        return sfView::HEADER_ONLY;
    }

    public function executePrintBankInformation()
    {
        $purchaseId = $this->getRequestParameter('p');

        $c = new Criteria();
        $c->add(MlmDistEpointPurchasePeer::PURCHASE_ID, $purchaseId);
        $c->add(MlmDistEpointPurchasePeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $distPackagePurchase = MlmDistEpointPurchasePeer::doSelectOne($c);

        if ($distPackagePurchase) {
            $this->purchaseId = $distPackagePurchase->getPurchaseId();
            $this->amount = $distPackagePurchase->getAmount();
            $this->paymentReference = $distPackagePurchase->getPaymentReference();
        }
        $this->tradingCurrencyOnMT4 = "USD";
        $this->bankName = $this->getAppSetting(Globals::SETTING_BANK_NAME);
        $this->bankSwiftCode = $this->getAppSetting(Globals::SETTING_BANK_SWIFT_CODE);
        $this->bankAccountHolder = $this->getAppSetting(Globals::SETTING_BANK_ACCOUNT_HOLDER);
        $this->bankAccountNumber = $this->getAppSetting(Globals::SETTING_BANK_ACCOUNT_NUMBER);
        $this->cityOfBank = $this->getAppSetting(Globals::SETTING_CITY_OF_BANK);
        $this->countryOfBank = $this->getAppSetting(Globals::SETTING_COUNTRY_OF_BANK);
        $this->systemCurrency = $this->getAppSetting(Globals::SETTING_SYSTEM_CURRENCY);
    }

    public function executeIndex()
    {
        return $this->redirect('/member/summary');
    }

    public function executePackagePurchaseViaBankTransfer() {
        $c = new Criteria();
        $c->addDescendingOrderByColumn(MlmPackagePeer::PRICE);
        $packages = MlmPackagePeer::doSelect($c);

        $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->forward404Unless($distDB);
        $this->packages = $packages;
        $this->distDB = $distDB;

        if ($this->getRequestParameter('packageTypeId') != "" && $this->getRequest()->getFileName('bankSlip') != '') {
            $packageDB = MlmPackagePeer::retrieveByPk($this->getRequestParameter('packageTypeId'));
            $this->forward404Unless($packageDB);

            $uploadedFilename = $this->getRequest()->getFileName('bankSlip');
            $ext = explode(".", $this->getRequest()->getFileName('bankSlip'));
            $extensionName = $ext[count($ext) - 1];

            $filename = date("Ymd")."_".$distDB->getDistributorCode()."_".rand(1000,9999).".".$extensionName;
            $this->getRequest()->moveFile('bankSlip', sfConfig::get('sf_upload_dir') . '/bankslip/' . $filename);

            $mlmDistPackagePurchase = new MlmDistPackagePurchase();
            $mlmDistPackagePurchase->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            $mlmDistPackagePurchase->setRankId($packageDB->getPackageId());
            $mlmDistPackagePurchase->setRankCode($packageDB->getPackageName());
            $mlmDistPackagePurchase->setInitRankId($packageDB->getPackageId());
            $mlmDistPackagePurchase->setInitRankCode($packageDB->getPackageName());
            $mlmDistPackagePurchase->setAmount($packageDB->getPrice());
            $mlmDistPackagePurchase->setTransactionType(Globals::PURCHASE_PACKAGE_BANK_TRANSFER);
            $mlmDistPackagePurchase->setImageSrc($_SERVER['HTTP_HOST']."/uploads/bankslip/".$filename);
            $mlmDistPackagePurchase->setStatusCode(Globals::STATUS_PENDING);
            //$mlmDistPackagePurchase->setRemarks($this->getRequestParameter('remarks'));
            $mlmDistPackagePurchase->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlmDistPackagePurchase->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));

            $mlmDistPackagePurchase->save();

            $distDB->setStatusCode(Globals::STATUS_PAYMENT_PENDING);
            $distDB->save();
            $this->setFlash('successMsg', "Your requests has been submitted.");
            return $this->redirect('/member/summary');
        }
    }

    public function executeEpointPurchase() {
        $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->forward404Unless($distDB);
        $this->distDB = $distDB;

        $this->tradingCurrencyOnMT4 = "USD";
        $this->bankName = $this->getAppSetting(Globals::SETTING_BANK_NAME);
        $this->bankSwiftCode = $this->getAppSetting(Globals::SETTING_BANK_SWIFT_CODE);
        $this->bankAccountHolder = $this->getAppSetting(Globals::SETTING_BANK_ACCOUNT_HOLDER);
        $this->bankAccountNumber = $this->getAppSetting(Globals::SETTING_BANK_ACCOUNT_NUMBER);
        $this->cityOfBank = $this->getAppSetting(Globals::SETTING_CITY_OF_BANK);
        $this->countryOfBank = $this->getAppSetting(Globals::SETTING_COUNTRY_OF_BANK);
        $this->systemCurrency = $this->getAppSetting(Globals::SETTING_SYSTEM_CURRENCY);

        if ($this->getRequestParameter('epointAmount') != "") {
            $amount = $this->getRequestParameter('epointAmount');
            $paymentReference = $this->generatePaymentReference();

            $mlmDistEpointPurchase = new MlmDistEpointPurchase();
            $mlmDistEpointPurchase->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            $mlmDistEpointPurchase->setAmount($amount);
            $mlmDistEpointPurchase->setPaymentReference($paymentReference);
            $mlmDistEpointPurchase->setTransactionType(Globals::PURCHASE_EPOINT_BANK_TRANSFER);
            $mlmDistEpointPurchase->setStatusCode(Globals::STATUS_PENDING);
            $mlmDistEpointPurchase->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlmDistEpointPurchase->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));

            $mlmDistEpointPurchase->save();

            $mlmDistEpointPurchase->setPaymentReference($mlmDistEpointPurchase->getPurchaseId());
            $mlmDistEpointPurchase->save();

            $paymentReference = $mlmDistEpointPurchase->getPaymentReference();

            $this->setFlash('purchaseId', $mlmDistEpointPurchase->getPurchaseId());
            $this->setFlash('amount', $amount);
            $this->setFlash('paymentReference', $paymentReference);
            $this->setFlash('successMsg', "Your requests has been submitted, to complete the funding, please proceed to remit the payment to the account, with details as indicated below:");
            return $this->redirect('/member/epointPurchase');
        }
    }

    public function executeDoUploadFile() {
        if ($this->getRequest()->getFileName('bankPassBook') != '') {
            $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            $this->forward404Unless($distDB);

            $uploadedFilename = $this->getRequest()->getFileName('bankPassBook');
            $ext = explode(".", $this->getRequest()->getFileName('bankPassBook'));
            $extensionName = $ext[count($ext) - 1];

            $filename = "bankPassBook_".date("Ymd")."_".$distDB->getDistributorCode()."_".rand(1000,9999).".".$extensionName;
            $this->getRequest()->moveFile('bankPassBook', sfConfig::get('sf_upload_dir') . '/bank_pass_book/' . $filename);

            $distDB->setFileBankPassBook($filename);
            $distDB->save();

            $this->setFlash('successMsg', "Upload successful.");
        }
        if ($this->getRequest()->getFileName('proofOfResidence') != '') {
            $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            $this->forward404Unless($distDB);

            $uploadedFilename = $this->getRequest()->getFileName('proofOfResidence');
            $ext = explode(".", $this->getRequest()->getFileName('proofOfResidence'));
            $extensionName = $ext[count($ext) - 1];

            $filename = "proofOfResidence_".date("Ymd")."_".$distDB->getDistributorCode()."_".rand(1000,9999).".".$extensionName;
            $this->getRequest()->moveFile('proofOfResidence', sfConfig::get('sf_upload_dir') . '/proof_of_residence/' . $filename);

            $distDB->setFileProofOfResidence($filename);
            $distDB->save();

            $this->setFlash('successMsg', "Upload successful.");
        }
        if ($this->getRequest()->getFileName('nric') != '') {
            $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            $this->forward404Unless($distDB);

            $uploadedFilename = $this->getRequest()->getFileName('nric');
            $ext = explode(".", $this->getRequest()->getFileName('nric'));
            $extensionName = $ext[count($ext) - 1];

            $filename = "nric_".date("Ymd")."_".$distDB->getDistributorCode()."_".rand(1000,9999).".".$extensionName;
            $this->getRequest()->moveFile('nric', sfConfig::get('sf_upload_dir') . '/nric/' . $filename);

            $distDB->setFileNric($filename);
            $distDB->save();

            $this->setFlash('successMsg', "Upload successful.");
        }
        return $this->redirect('/member/viewProfile');
    }

    public function executeUploadBankReceipt() {
        if ($this->getRequestParameter('purchaseId') != "" && $this->getRequest()->getFileName('bankSlip') != '') {
            $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            $this->forward404Unless($distDB);
            $this->distDB = $distDB;

            $uploadedFilename = $this->getRequest()->getFileName('bankSlip');
            $ext = explode(".", $this->getRequest()->getFileName('bankSlip'));
            $extensionName = $ext[count($ext) - 1];

            $filename = date("Ymd")."_".$distDB->getDistributorCode()."_".rand(1000,9999).".".$extensionName;
            $this->getRequest()->moveFile('bankSlip', sfConfig::get('sf_upload_dir') . '/bankslip/' . $filename);

            $mlmDistEpointPurchase = MlmDistEpointPurchasePeer::retrieveByPK($this->getRequestParameter('purchaseId'));
            $mlmDistEpointPurchase->setImageSrc("http://".$_SERVER['HTTP_HOST']."/uploads/bankslip/".$filename);
            $mlmDistEpointPurchase->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));

            $mlmDistEpointPurchase->save();

            $this->setFlash('banksuccessMsg', "Bank receipt upload successful.");
            return $this->redirect('/member/epointPurchase');
        }
    }

    public function executeUpdateTermCondition() {
        $mlm_distributor = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->forward404Unless($mlm_distributor);

        $mlm_distributor->setTermCondition(Globals::YES);
        $mlm_distributor->save();
        return $this->redirect('/member/summary');
    }

    public function executeRegister()
    {
        $char = strtoupper(substr(str_shuffle('abcdefghjkmnpqrstuvwxyz'), 0, 2));
        // Concatenate the random string onto the random numbers
        // The font 'Anorexia' doesn't have a character for '8', so the numbers will only go up to 7
        // '0' is left out to avoid confusion with 'O'

        $str = rand(1, 7) . rand(1, 7) . $char;
        $this->getUser()->setAttribute(Globals::SYSTEM_CAPTCHA_ID, $str);
    }

    public function executeMemberRegistration()
    {
        $c = new Criteria();
        $packageDBs = MlmPackagePeer::doSelect($c);

        $this->systemCurrency = $this->getAppSetting(Globals::SETTING_SYSTEM_CURRENCY);
        $this->pointAvailable = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);
        $this->packageDBs = $packageDBs;
    }
    public function executeMemberRegistration2()
    {
        //if ($this->getRequestParameter('transactionPassword') <> "" && $this->getRequestParameter('pid') <> "") {
        if ($this->getRequestParameter('pid') <> "") {
            /*$tbl_user = AppUserPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_USERID));
            if ($tbl_user->getUserpassword2() <> $this->getRequestParameter('transactionPassword')) {
                $this->setFlash('errorMsg', "Invalid Security password");
                return $this->redirect('/member/memberRegistration');
            }*/

            $ledgerEPointBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);
            $selectedPackage = MlmPackagePeer::retrieveByPK($this->getRequestParameter('pid'));
            $this->forward404Unless($selectedPackage);

            $amountNeeded = $selectedPackage->getPrice();
            if ($amountNeeded > $ledgerEPointBalance) {
                $this->setFlash('errorMsg', "In-sufficient CP1 amount");
                return $this->redirect('/member/memberRegistration');
            }
            $this->selectedPackage = $selectedPackage;
            $this->productCode = $this->getRequestParameter('productCode');
        } else {
            return $this->redirect('/member/memberRegistration');
        }
    }

    public function executeRegisterInfo()
    {
        if (!$this->getUser()->hasAttribute(Globals::SESSION_USERNAME)) {
            return $this->redirect('/member/register');
        }
    }

    public function executeUpdateProfile()
    {
        $mlm_distributor = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->forward404Unless($mlm_distributor);

        //$mlm_distributor->setNickname($this->getRequestParameter('nickName'));
        //$mlm_distributor->setFullName($this->getRequestParameter('fullname'));
        $mlm_distributor->setIc($this->getRequestParameter('ic'));
        if ($this->getRequestParameter('country') == 'China') {
            $mlm_distributor->setCountry('China (PRC)');
        } else {
            $mlm_distributor->setCountry($this->getRequestParameter('country'));
        }
        $mlm_distributor->setAddress($this->getRequestParameter('address'));
        $mlm_distributor->setAddress2($this->getRequestParameter('address2'));
        $mlm_distributor->setCity($this->getRequestParameter('city'));
        $mlm_distributor->setState($this->getRequestParameter('state'));
        $mlm_distributor->setPostcode($this->getRequestParameter('zip'));
        $mlm_distributor->setEmail($this->getRequestParameter('email'));
        $mlm_distributor->setAlternateEmail($this->getRequestParameter('alt_email'));
        $mlm_distributor->setContact($this->getRequestParameter('contactNumber'));
        $mlm_distributor->setGender($this->getRequestParameter('gender'));
        if ($this->getRequestParameter('dob')) {
            list($d, $m, $y) = sfI18N::getDateForCulture($this->getRequestParameter('dob'), $this->getUser()->getCulture());
            $mlm_distributor->setDob("$y-$m-$d");
        }
        //$mlm_distributor->setBankName($this->getRequestParameter('bankName'));
        //$mlm_distributor->setBankAccNo($this->getRequestParameter('bankNo'));
        //$mlm_distributor->setBankHolderName($this->getRequestParameter('bankHolder'));
        $mlm_distributor->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_distributor->save();

        $this->setFlash('successMsg', "Profile update successfully");

        return $this->redirect('/member/viewProfile');
    }

    public function executeUpdateBankInformation()
    {
        $mlm_distributor = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->forward404Unless($mlm_distributor);

        $mlm_distributor->setBankName($this->getRequestParameter('bankName'));
        $mlm_distributor->setBankAccNo($this->getRequestParameter('bankAccNo'));
        $mlm_distributor->setBankHolderName($this->getRequestParameter('bankHolderName'));
        $mlm_distributor->setBankSwiftCode($this->getRequestParameter('bankSwiftCode'));
        $mlm_distributor->setVisaDebitCard($this->getRequestParameter('visaDebitCard'));
        $mlm_distributor->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_distributor->save();

        $this->setFlash('successMsg', "Bank Account Information update successfully");

        //return $this->redirect('/member/viewBankInformation');
        return $this->redirect('/member/viewProfile');
    }

    public function executeDoRegister()
    {
        require_once('recaptchalib.php');
        $privatekey = "6LfhJtYSAAAAALocUxn6PpgfoWCFjRquNFOSRFdb";
        $resp = recaptcha_check_answer ($privatekey,
                                    $_SERVER["REMOTE_ADDR"],
                                    $_POST["recaptcha_challenge_field"],
                                    $_POST["recaptcha_response_field"]);

        if (!$resp->is_valid) {
            $this->setFlash('errorMsg', "The CAPTCHA wasn't entered correctly. Go back and try it again.");
            return $this->redirect('home/login');
        }

        //$fcode = $this->generateFcode($this->getRequestParameter('country'));
        $fcode = $this->getRequestParameter('userName');
        $password = $this->getRequestParameter('userpassword');

        $c = new Criteria();
        $c->add(AppUserPeer::USERNAME, $fcode);
        $exist = AppUserPeer::doSelectOne($c);
        //$this->forward404Unless(!$exist);
        $parentId = $this->getDistributorIdByCode($this->getRequestParameter('sponsorId'));
        $this->forward404Unless($parentId <> 0);

        //******************* upline distributor ID
        $uplineDistDB = $this->getDistributorInformation($this->getRequestParameter('sponsorId'));
        $this->forward404Unless($uplineDistDB);

        $treeStructure = $uplineDistDB->getTreeStructure() . "|" . $fcode . "|";
        $treeLevel = $uplineDistDB->getTreeLevel() + 1;

        $app_user = new AppUser();
        $app_user->setUsername($fcode);
        $app_user->setKeepPassword($password);
        $app_user->setUserpassword($password);
        $app_user->setKeepPassword2($password);
        $app_user->setUserpassword2($password);
        $app_user->setUserRole(Globals::ROLE_DISTRIBUTOR);
        $app_user->setStatusCode(Globals::STATUS_PENDING);
        $app_user->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $app_user->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $app_user->save();

        // ****************************
        $mlm_distributor = new MlmDistributor();
        $mlm_distributor->setDistributorCode($fcode);
        $mlm_distributor->setUserId($app_user->getUserId());
        $mlm_distributor->setStatusCode(Globals::STATUS_PENDING);
        $mlm_distributor->setFullName($this->getRequestParameter('fullname'));
        $mlm_distributor->setNickname($fcode);
        $mlm_distributor->setIc($this->getRequestParameter('ic'));
        if ($this->getRequestParameter('country') == 'China') {
            $mlm_distributor->setCountry('China (PRC)');
        } else {
            $mlm_distributor->setCountry($this->getRequestParameter('country'));
        }
        $mlm_distributor->setAddress($this->getRequestParameter('address'));
        $mlm_distributor->setAddress2($this->getRequestParameter('address2'));
        $mlm_distributor->setCity($this->getRequestParameter('city'));
        $mlm_distributor->setState($this->getRequestParameter('state'));
        $mlm_distributor->setPostcode($this->getRequestParameter('zip'));
        $mlm_distributor->setEmail($this->getRequestParameter('email'));
        $mlm_distributor->setAlternateEmail($this->getRequestParameter('alt_email'));
        $mlm_distributor->setContact($this->getRequestParameter('contactNumber'));
        $mlm_distributor->setGender($this->getRequestParameter('gender'));
        if ($this->getRequestParameter('dob')) {
            list($d, $m, $y) = sfI18N::getDateForCulture($this->getRequestParameter('dob'), $this->getUser()->getCulture());
            $mlm_distributor->setDob("$y-$m-$d");
        }
        $mlm_distributor->setBankName($this->getRequestParameter('bankName'));
        $mlm_distributor->setBankAccNo($this->getRequestParameter('bankAccountNo'));
        $mlm_distributor->setBankHolderName($this->getRequestParameter('bankHolderName'));

        $mlm_distributor->setTreeLevel($treeLevel);
        $mlm_distributor->setTreeStructure($treeStructure);
        $mlm_distributor->setUplineDistId($uplineDistDB->getDistributorId());
        $mlm_distributor->setUplineDistCode($uplineDistDB->getDistributorCode());

        $mlm_distributor->setLeverage($this->getRequestParameter('leverage'));
        $mlm_distributor->setSpread($this->getRequestParameter('spread'));
        $mlm_distributor->setDepositCurrency($this->getRequestParameter('deposit_currency'));
        $mlm_distributor->setDepositAmount($this->getRequestParameter('deposit_amount'));
        $mlm_distributor->setSignName($this->getRequestParameter('sign_name'));
        $mlm_distributor->setSignDate(date("Y/m/d h:i:s A"));
        $mlm_distributor->setTermCondition($this->getRequestParameter('term_condition'));

        if ($this->getRequestParameter('productCode') == "fxgold") {
            $mlm_distributor->setProductMte("Y");
        }
        if ($this->getRequestParameter('productCode') == "mte") {
            $mlm_distributor->setProductFxgold("Y");
        }

        $mlm_distributor->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_distributor->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_distributor->save();

        $this->getUser()->setAttribute(Globals::SESSION_USERNAME, $fcode);

        /****************************/
        /*****  Send email **********/
        /****************************/
        /*error_reporting(E_STRICT);

        date_default_timezone_set(date_default_timezone_get());

        include_once('class.phpmailer.php');

        $subject = $this->getContext()->getI18N()->__("Vital Universe Group Registration email notification", null, 'email');
        $body = $this->getContext()->getI18N()->__("Dear %1%", array('%1%' => $mlm_distributor->getNickname()), 'email') . ",<p><p>

        <p>" . $this->getContext()->getI18N()->__("Your registration request has been successfully sent to Vital Universe Group", null, 'email') . "</p>
        <p><b>" . $this->getContext()->getI18N()->__("Trader ID", null) . ": " . $fcode . "</b>
        <p><b>" . $this->getContext()->getI18N()->__("Password", null) . ": " . $password . "</b>";

        $mail = new PHPMailer();
        $mail->IsMail(); // telling the class to use SMTP
        $mail->Host = Mails::EMAIL_HOST; // SMTP server
        $mail->Sender = Mails::EMAIL_FROM_NOREPLY;
        $mail->From = Mails::EMAIL_FROM_NOREPLY;
        $mail->FromName = Mails::EMAIL_FROM_NOREPLY_NAME;
        $mail->Subject = $subject;
        $mail->CharSet="utf-8";

        $text_body = $body;

        $mail->Body = $body;
        $mail->AltBody = $text_body;
        $mail->AddAddress($mlm_distributor->getEmail(), $mlm_distributor->getNickname());
        $mail->AddBCC("r9projecthost@gmail.com", "jason");

        if (!$mail->Send()) {
            echo $mail->ErrorInfo;
        }*/
        return $this->redirect('/member/registerInfo');
    }

    public function executeDoMemberRegistration()
    {
        $fcode = $this->getRequestParameter('userName');
        $password = $this->getRequestParameter('userpassword');
        $packageId = $this->getRequestParameter('packageId');
        $position = $this->getRequestParameter('position1');

        $con = Propel::getConnection(MlmDistributorPeer::DATABASE_NAME);
        try {
            $con->begin();
            //******************* upline distributor ID
            $uplineDistCode = $this->getRequestParameter('sponsorId');

            $c = new Criteria();
            $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $uplineDistCode);
            $c->add(MlmDistributorPeer::PLACEMENT_TREE_STRUCTURE, "%".$this->getUser()->getAttribute(Globals::SESSION_USERNAME)."%", Criteria::LIKE);
            $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
            $uplineDistDB = MlmDistributorPeer::doSelectOne($c);
            $this->forward404Unless($uplineDistDB);

            $uplineDistId = $uplineDistDB->getDistributorId();
            $treeStructure = $uplineDistDB->getTreeStructure() . "|" . $fcode . "|";
            $treeLevel = $uplineDistDB->getTreeLevel() + 1;

            $app_user = new AppUser();
            $app_user->setUsername($fcode);
            $app_user->setKeepPassword($password);
            $app_user->setUserpassword($password);
            $app_user->setKeepPassword2($password);
            $app_user->setUserpassword2($password);
            $app_user->setUserRole(Globals::ROLE_DISTRIBUTOR);
            $app_user->setStatusCode(Globals::STATUS_ACTIVE);
            $app_user->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $app_user->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $app_user->save();

            // ****************************
            $packageDB = MlmPackagePeer::retrieveByPK($packageId);
            $this->forward404Unless($packageDB);

            $mlm_distributor = new MlmDistributor();
            $mlm_distributor->setDistributorCode($fcode);
            $mlm_distributor->setUserId($app_user->getUserId());
            $mlm_distributor->setStatusCode(Globals::STATUS_ACTIVE);
            $mlm_distributor->setFullName($this->getRequestParameter('fullname'));
            $mlm_distributor->setNickname($fcode);
            $mlm_distributor->setIc($this->getRequestParameter('ic'));
            if ($this->getRequestParameter('country') == 'China') {
                $mlm_distributor->setCountry('China (PRC)');
            } else {
                $mlm_distributor->setCountry($this->getRequestParameter('country'));
            }
            $mlm_distributor->setAddress($this->getRequestParameter('address'));
            $mlm_distributor->setAddress2($this->getRequestParameter('address2'));
            $mlm_distributor->setCity($this->getRequestParameter('city'));
            $mlm_distributor->setState($this->getRequestParameter('state'));
            $mlm_distributor->setPostcode($this->getRequestParameter('zip'));
            $mlm_distributor->setEmail($this->getRequestParameter('email'));
            $mlm_distributor->setAlternateEmail($this->getRequestParameter('alt_email'));
            $mlm_distributor->setContact($this->getRequestParameter('contactNumber'));
            $mlm_distributor->setGender($this->getRequestParameter('gender'));
            if ($this->getRequestParameter('dob')) {
                list($d, $m, $y) = sfI18N::getDateForCulture($this->getRequestParameter('dob'), $this->getUser()->getCulture());
                $mlm_distributor->setDob("$y-$m-$d");
            }
            $mlm_distributor->setBankName($this->getRequestParameter('bankName'));
            $mlm_distributor->setBankAccNo($this->getRequestParameter('bankAccountNo'));
            $mlm_distributor->setBankHolderName($this->getRequestParameter('bankHolderName'));

            $mlm_distributor->setTreeLevel($treeLevel);
            $mlm_distributor->setTreeStructure($treeStructure);
            $mlm_distributor->setUplineDistId($uplineDistDB->getDistributorId());
            $mlm_distributor->setUplineDistCode($uplineDistDB->getDistributorCode());

            $mlm_distributor->setLeverage($this->getRequestParameter('leverage'));
            $mlm_distributor->setSpread($this->getRequestParameter('spread'));
            $mlm_distributor->setDepositCurrency($this->getRequestParameter('deposit_currency'));
            $mlm_distributor->setDepositAmount($this->getRequestParameter('deposit_amount'));
            $mlm_distributor->setSignName($this->getRequestParameter('sign_name'));
            $mlm_distributor->setSignDate(date("Y/m/d h:i:s A"));
            $mlm_distributor->setTermCondition($this->getRequestParameter('term_condition'));

            $mlm_distributor->setRankId($packageDB->getPackageId());
            $mlm_distributor->setRankCode($packageDB->getPackageName());
            $mlm_distributor->setInitRankId($packageDB->getPackageId());
            $mlm_distributor->setInitRankCode($packageDB->getPackageName());
            $mlm_distributor->setStatusCode(Globals::STATUS_ACTIVE);
            $mlm_distributor->setPackagePurchaseFlag("Y");
            $mlm_distributor->setActiveDatetime(date("Y/m/d h:i:s A"));
            $mlm_distributor->setActivatedBy($this->getUser()->getAttribute(Globals::SESSION_DISTID));

            if ($this->getRequestParameter('productCode') == "fxgold") {
                $mlm_distributor->setProductMte("Y");
            }
            if ($this->getRequestParameter('productCode') == "mte") {
                $mlm_distributor->setProductFxgold("Y");
            }

            $mlm_distributor->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_distributor->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_distributor->save();

            $sponsorId = $mlm_distributor->getDistributorId();
            /* ****************************************************
             * get distributor last account ledger epoint balance
             * ***************************************************/
            $sponsorAccountBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);

            /**************************************/
            /*  Direct REFERRAL Bonus For Upline
            /**************************************/
            if ($uplineDistDB->getIsIb() == Globals::YES) {
                $directSponsorPercentage = $uplineDistDB->getIbCommission() * 100;
                $directSponsorBonusAmount = $directSponsorPercentage * $packageDB->getPrice() / 100;
            } else {
                $uplineDistPackage = MlmPackagePeer::retrieveByPK($uplineDistDB->getRankId());
                $directSponsorPercentage = $uplineDistPackage->getCommission();
                $directSponsorBonusAmount = $directSponsorPercentage * $packageDB->getPrice() / 100;
            }
            $totalBonusPayOut = $directSponsorPercentage;

            $this->doSaveAccount($sponsorId, Globals::ACCOUNT_TYPE_ECASH, 0, 0, Globals::ACCOUNT_LEDGER_ACTION_REGISTER, "");
            $this->doSaveAccount($sponsorId, Globals::ACCOUNT_TYPE_EPOINT, 0, 0, Globals::ACCOUNT_LEDGER_ACTION_REGISTER, "");

            /* ****************************************************
             * Update upline distributor account
             * ***************************************************/
            $sponsorAccountBalance = $sponsorAccountBalance - $packageDB->getPrice();

            $mlm_account_ledger = new MlmAccountLedger();
            $mlm_account_ledger->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
            $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_REGISTER);
            $mlm_account_ledger->setRemark("PACKAGE PURCHASE (".$packageDB->getPackageName().")");
            $mlm_account_ledger->setCredit(0);
            $mlm_account_ledger->setDebit($packageDB->getPrice());
            $mlm_account_ledger->setBalance($sponsorAccountBalance);
            $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->save();

            $this->revalidateAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);

            /******************************/
            /*  Direct Sponsor Bonus
            /******************************/
            $firstForDRB = true;
            while ($totalBonusPayOut <= Globals::TOTAL_BONUS_PAYOUT) {
                $distAccountEcashBalance = $this->getAccountBalance($uplineDistId, Globals::ACCOUNT_TYPE_ECASH);

                $mlm_account_ledger = new MlmAccountLedger();
                $mlm_account_ledger->setDistId($uplineDistId);
                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_DRB);
                $mlm_account_ledger->setRemark("PACKAGE PURCHASE (".$packageDB->getPackageName().") ".$directSponsorPercentage."% (" . $mlm_distributor->getDistributorCode() . ")");
                $mlm_account_ledger->setCredit($directSponsorBonusAmount);
                $mlm_account_ledger->setDebit(0);
                $mlm_account_ledger->setBalance($distAccountEcashBalance + $directSponsorBonusAmount);
                $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->save();

                $this->revalidateAccount($uplineDistId, Globals::ACCOUNT_TYPE_ECASH);

                /******************************/
                /*  Commission
                /******************************/
                $c = new Criteria();
                $c->add(MlmDistCommissionPeer::DIST_ID, $uplineDistId);
                $c->add(MlmDistCommissionPeer::COMMISSION_TYPE, Globals::COMMISSION_TYPE_DRB);
                $sponsorDistCommissionDB = MlmDistCommissionPeer::doSelectOne($c);

                $commissionBalance = 0;
                if (!$sponsorDistCommissionDB) {
                    $sponsorDistCommissionDB = new MlmDistCommission();
                    $sponsorDistCommissionDB->setDistId($uplineDistId);
                    $sponsorDistCommissionDB->setCommissionType(Globals::COMMISSION_TYPE_DRB);
                    $sponsorDistCommissionDB->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                } else {
                    $commissionBalance = $sponsorDistCommissionDB->getBalance();
                }
                $sponsorDistCommissionDB->setBalance($commissionBalance + $directSponsorBonusAmount);
                $sponsorDistCommissionDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $sponsorDistCommissionDB->save();

                $c = new Criteria();
                $c->add(MlmDistCommissionLedgerPeer::DIST_ID, $uplineDistId);
                $c->add(MlmDistCommissionLedgerPeer::COMMISSION_TYPE, Globals::COMMISSION_TYPE_DRB);
                $c->addDescendingOrderByColumn(MlmDistCommissionLedgerPeer::CREATED_ON);
                $sponsorDistCommissionLedgerDB = MlmDistCommissionLedgerPeer::doSelectOne($c);

                $dsbBalance = 0;
                if ($sponsorDistCommissionLedgerDB)
                    $dsbBalance = $sponsorDistCommissionLedgerDB->getBalance();

                $sponsorDistCommissionledger = new MlmDistCommissionLedger();
                $sponsorDistCommissionledger->setDistId($uplineDistId);
                $sponsorDistCommissionledger->setCommissionType(Globals::COMMISSION_TYPE_DRB);
                $sponsorDistCommissionledger->setTransactionType(Globals::COMMISSION_LEDGER_REGISTER);
                $sponsorDistCommissionledger->setCredit($directSponsorBonusAmount);
                $sponsorDistCommissionledger->setDebit(0);
                $sponsorDistCommissionledger->setStatusCode(Globals::STATUS_PENDING);
                $sponsorDistCommissionledger->setBalance($dsbBalance + $directSponsorBonusAmount);
                if ($firstForDRB == true) {
                    $sponsorDistCommissionledger->setRemark("DRB FOR PACKAGE PURCHASE ".$directSponsorPercentage."% (".$packageDB->getPackageName().") for ".$mlm_distributor->getDistributorCode());
                    $firstForDRB = false;
                } else {
                    $sponsorDistCommissionledger->setRemark("GRB FOR PACKAGE PURCHASE ".$directSponsorPercentage."% (".$packageDB->getPackageName().") for ".$mlm_distributor->getDistributorCode());
                }
                $sponsorDistCommissionledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $sponsorDistCommissionledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $sponsorDistCommissionledger->save();

                $this->revalidateCommission($uplineDistId, Globals::COMMISSION_TYPE_DRB);
                //var_dump("==>1");
                if ($totalBonusPayOut < Globals::TOTAL_BONUS_PAYOUT) {
                    //var_dump("==>2");
                    $checkCommission = true;
                    $uplineDistId = $uplineDistDB->getUplineDistId();


                    while ($checkCommission == true) {
                        //var_dump("==>3**".$uplineDistId);
                        if ($uplineDistId == null || $uplineDistId == 0) {
                            $totalBonusPayOut = Globals::TOTAL_BONUS_PAYOUT ;
                            break;
                        }
                        $uplineDistDB = MlmDistributorPeer::retrieveByPK($uplineDistId);

                        //var_dump("==>3$$".$uplineDistId);
                        if ($uplineDistDB) {
                            if ($uplineDistDB->getIsIb() == Globals::YES) {
                                /*if ($uplineDistDB->getIbRankId() != null) {
                                    $uplineDistPackage = MlmIbPackagePeer::retrieveByPK($uplineDistDB->getIbRankId());
                                } else {
                                    $uplineDistPackage = MlmPackagePeer::retrieveByPK($uplineDistDB->getRankId());
                                }*/
                                $directSponsorPercentage = $uplineDistDB->getIbCommission() * 100;

                                if ($directSponsorPercentage > $totalBonusPayOut) {
                                    //var_dump("==>6");
                                    $directSponsorPercentage = $directSponsorPercentage - $totalBonusPayOut;
                                    $totalBonusPayOut += $directSponsorPercentage;
                                    if ($totalBonusPayOut > Globals::TOTAL_BONUS_PAYOUT) {
                                        //var_dump("==>7");
                                        $directSponsorPercentage = $directSponsorPercentage - ($totalBonusPayOut - Globals::TOTAL_BONUS_PAYOUT);
                                    }
                                } else {
                                    //var_dump("==>8");
                                    $uplineDistId = $uplineDistDB->getUplineDistId();
                                    continue;
                                }
                            } else {
                                $uplineDistId = $uplineDistDB->getUplineDistId();
                                continue;
                            }
                            $directSponsorBonusAmount = $directSponsorPercentage * $packageDB->getPrice() / 100;
                            $checkCommission == false;
                            break;
                        } else {
                            $totalBonusPayOut = Globals::TOTAL_BONUS_PAYOUT;
                            break;
                        }

                        //var_dump("==>9");
                    }
                } else {
                    break;
                    //var_dump("==>^^");
                }
            }

            /****************************/
            /*****  Send email **********/
            /****************************/
            /*error_reporting(E_STRICT);

            date_default_timezone_set(date_default_timezone_get());

            include_once('class.phpmailer.php');

            $subject = $this->getContext()->getI18N()->__("Vital Universe Group Registration email notification", null, 'email');
            $body = $this->getContext()->getI18N()->__("Dear %1%", array('%1%' => $mlm_distributor->getNickname()), 'email') . ",<p><p>

            <p>" . $this->getContext()->getI18N()->__("Your registration request has been successfully sent to Vital Universe Group", null, 'email') . "</p>
            <p><b>" . $this->getContext()->getI18N()->__("Trader ID", null) . ": " . $fcode . "</b>
            <p><b>" . $this->getContext()->getI18N()->__("Password", null) . ": " . $password . "</b>";

            $mail = new PHPMailer();
            $mail->IsMail(); // telling the class to use SMTP
            $mail->Host = Mails::EMAIL_HOST; // SMTP server
            $mail->Sender = Mails::EMAIL_FROM_NOREPLY;
            $mail->From = Mails::EMAIL_FROM_NOREPLY;
            $mail->FromName = Mails::EMAIL_FROM_NOREPLY_NAME;
            $mail->Subject = $subject;
            $mail->CharSet="utf-8";

            $text_body = $body;

            $mail->Body = $body;
            $mail->AltBody = $text_body;
            $mail->AddAddress($mlm_distributor->getEmail(), $mlm_distributor->getNickname());
            $mail->AddBCC("r9projecthost@gmail.com", "jason");

            if (!$mail->Send()) {
                echo $mail->ErrorInfo;
            }*/
            // **********************************************************************************************
            // *****************************         tree placement          **********************
            // **********************************************************************************************
            $uplineDistCode = $this->getRequestParameter('uplineDistCode');
            $treePosition = $this->getRequestParameter('treePosition');
            $placementType = $this->getRequestParameter('placementType'); // 1 = auto, 0 = manual
            $placementDistCode = $this->getRequestParameter('placementDistId'); // 1 = auto, 0 = manual
            if ($position == 1 || $position == 2 || $treePosition != ""){
                $uplinePosition = "";

                if ($treePosition != "") {
                    if ($treePosition == "left") {
                        $uplinePosition = Globals::PLACEMENT_LEFT;
                    } else if ($treePosition == "right") {
                        $uplinePosition = Globals::PLACEMENT_RIGHT;
                    }
                } else {
                    if ($position == 1) {
                        $uplinePosition = Globals::PLACEMENT_LEFT;
                    } else if ($position == 2) {
                        $uplinePosition = Globals::PLACEMENT_RIGHT;
                    }
                }

                $placementSuccessful = false;

                if ($uplineDistCode != "") {
                    $c = new Criteria();
                    $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $uplineDistCode);
                    $uplineDistDB = MlmDistributorPeer::doSelectOne($c);
                } else {
                    if ($placementType == 0) {
                        $c = new Criteria();
                        $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $placementDistCode);
                        $uplineDistDB = MlmDistributorPeer::doSelectOne($c);

                        $uplineDistId = $uplineDistDB->getDistributorId();
                    } else {
                        $uplineDistCode = $this->getRequestParameter('sponsorId', $this->getUser()->getAttribute(Globals::SESSION_USERNAME));
                        $c = new Criteria();
                        $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $uplineDistCode);
                        $uplineDistDB = MlmDistributorPeer::doSelectOne($c);

                        $uplineDistId = $uplineDistDB->getDistributorId();
                    }

                    while ($placementSuccessful == false) {
                        if ($placementSuccessful == true)
                            break;
                        //var_dump("uplineDistId=".$uplineDistId);
                        $c = new Criteria();
                        $c->add(MlmDistributorPeer::TREE_UPLINE_DIST_ID, $uplineDistId);
                        $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
                        $c->add(MlmDistributorPeer::PLACEMENT_POSITION, $uplinePosition);
                        $downlineDistDB = MlmDistributorPeer::doSelectOne($c);

                        if ($downlineDistDB) {
                            $uplineDistId = $downlineDistDB->getDistributorId();
                        } else {
                            //var_dump("====NO===".$uplineDistId);
                            $uplineDistDB = MlmDistributorPeer::retrieveByPk($uplineDistId);

                            //var_dump($uplineDistDB);
                            $placementSuccessful = true;
                            break;
                        }
                    }
                }
                //var_dump("result:::".$uplineDistId);
                //var_dump($uplineDistDB);
                //exit();
                $treeStructure = $uplineDistDB->getPlacementTreeStructure() . "|" . $mlm_distributor->getDistributorCode() . "|";
                $treeLevel = $uplineDistDB->getPlacementTreeLevel() + 1;

                $mlm_distributor->setPlacementDatetime(date("Y/m/d h:i:s A"));
                $mlm_distributor->setPlacementPosition($uplinePosition);
                //$mlm_distributor->setUplineDistId($uplineDistDB->getDistributorId());
                //$mlm_distributor->setUplineDistCode($uplineDistDB->getDistributorCode());
                $mlm_distributor->setPlacementTreeStructure($treeStructure);
                $mlm_distributor->setPlacementTreeLevel($treeLevel);
                $mlm_distributor->setTreeUplineDistId($uplineDistDB->getDistributorId());
                $mlm_distributor->setTreeUplineDistCode($uplineDistDB->getDistributorCode());
                $mlm_distributor->save();

                $sponsoredPackageDB = MlmPackagePeer::retrieveByPK($mlm_distributor->getRankId());
                $this->forward404Unless($sponsoredPackageDB);
                $pairingPoint = $sponsoredPackageDB->getPrice();

                // recalculate Total left and total right for $uplineDistDB
                $arrs = explode("|", $uplineDistDB->getPlacementTreeStructure());
                for ($x = count($arrs); $x > 0; $x--) {
                    if ($arrs[$x] == "") {
                        continue;
                    }
                    $uplineDistDB = $this->getDistributorInformation($arrs[$x]);
                    if ($uplineDistDB) {
                        $totalLeft = $this->getTotalPosition($arrs[$x], Globals::PLACEMENT_LEFT);
                        $totalRight = $this->getTotalPosition($arrs[$x], Globals::PLACEMENT_RIGHT);
                        $uplineDistDB->setTotalLeft($totalLeft);
                        $uplineDistDB->setTotalRight($totalRight);
                        $uplineDistDB->save();
                    }
                }

                /******************************/
                /*  store Pairing points
                /******************************/
                if ($mlm_distributor->getTreeUplineDistId() != 0 && $mlm_distributor->getTreeUplineDistCode() != null) {
                    $level = 0;
                    $uplineDistDB = MlmDistributorPeer::retrieveByPk($mlm_distributor->getTreeUplineDistId());
                    $sponsoredDistributorCode = $mlm_distributor->getDistributorCode();
                    while ($level < 100) {
                        //var_dump($uplineDistDB->getUplineDistId());
                        //var_dump($uplineDistDB->getUplineDistCode());
                        //print_r("<br>");
                        $c = new Criteria();
                        $c->add(MlmDistPairingPeer::DIST_ID, $uplineDistDB->getDistributorId());
                        $sponsorDistPairingDB = MlmDistPairingPeer::doSelectOne($c);

                        $addToLeft = 0;
                        $addToRight = 0;
                        $leftBalance = 0;
                        $rightBalance = 0;
                        if (!$sponsorDistPairingDB) {
                            $sponsorDistPairingDB = new MlmDistPairing();
                            $sponsorDistPairingDB->setDistId($uplineDistDB->getDistributorId());

                            $packageDB = MlmPackagePeer::retrieveByPK($uplineDistDB->getRankId());
                            $this->forward404Unless($packageDB);

                            $sponsorDistPairingDB->setLeftBalance($leftBalance);
                            $sponsorDistPairingDB->setRightBalance($rightBalance);
                            $sponsorDistPairingDB->setFlushLimit($packageDB->getDailyMaxPairing());
                            $sponsorDistPairingDB->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        } else {
                            $leftBalance = $sponsorDistPairingDB->getLeftBalance();
                            $rightBalance = $sponsorDistPairingDB->getRightBalance();
                        }
                        $sponsorDistPairingDB->setLeftBalance($leftBalance + $addToLeft);
                        $sponsorDistPairingDB->setRightBalance($rightBalance + $addToRight);
                        $sponsorDistPairingDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $sponsorDistPairingDB->save();

                        $c = new Criteria();
                        $c->add(MlmDistPairingLedgerPeer::DIST_ID, $uplineDistDB->getDistributorId());
                        $c->add(MlmDistPairingLedgerPeer::LEFT_RIGHT, $uplinePosition);
                        $c->addDescendingOrderByColumn(MlmDistPairingLedgerPeer::CREATED_ON);
                        $sponsorDistPairingLedgerDB = MlmDistPairingLedgerPeer::doSelectOne($c);

                        $legBalance = 0;
                        if ($sponsorDistPairingLedgerDB) {
                            $legBalance = $sponsorDistPairingLedgerDB->getBalance();
                        }

                        $sponsorDistPairingledger = new MlmDistPairingLedger();
                        $sponsorDistPairingledger->setDistId($uplineDistDB->getDistributorId());
                        $sponsorDistPairingledger->setLeftRight($uplinePosition);
                        $sponsorDistPairingledger->setTransactionType(Globals::PAIRING_LEDGER_REGISTER);
                        $sponsorDistPairingledger->setCredit($pairingPoint);
                        $sponsorDistPairingledger->setDebit(0);
                        $sponsorDistPairingledger->setBalance($legBalance + $pairingPoint);
                        $sponsorDistPairingledger->setRemark("PAIRING POINT AMOUNT (" . $sponsoredDistributorCode . ")");
                        $sponsorDistPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $sponsorDistPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $sponsorDistPairingledger->save();

                        $this->revalidatePairing($uplineDistDB->getDistributorId(), $uplinePosition);

                        if ($uplineDistDB->getTreeUplineDistId() == 0 || $uplineDistDB->getTreeUplineDistCode() == null) {
                            break;
                        }

                        $uplinePosition = $uplineDistDB->getPlacementPosition();
                        $uplineDistDB = MlmDistributorPeer::retrieveByPk($uplineDistDB->getTreeUplineDistId());
                        $level++;
                    }
                }
            }
        $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }
        if ($position == 0){
            $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Member Registered Successfully. Please manual do placement now."));
            return $this->redirect('/member/placementTree');
            //return $this->redirect('/member/placementTree?distcode=' . $mlm_distributor->getUplineDistCode());
        } else if ($position == 1 || $position == 2 || $treePosition != ""){
            $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Member Registered Successfully."));
            return $this->redirect('/member/placementTree?distcode=' . $mlm_distributor->getTreeUplineDistCode());
        }
        return $this->redirect('/member/summary');
    }

    // **********************************************************************************************
    // *****************************         For broker registeration          **********************
    // **********************************************************************************************
    function generateFcode()
    {
        $max_digit = 999999999;
        $digit = 9;

        while (true) {
            $fcode = rand(0, $max_digit) . "";
            $fcode = str_pad($fcode, $digit, "0", STR_PAD_LEFT);

            $c = new Criteria();
            $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $fcode);
            $existDist = MlmDistributorPeer::doSelectOne($c);

            if (!$existDist) {
                break;
            }
        }
        return $fcode;
    }
    public function executeOpenDemoAccount()
    {
        $error = false;
        $errorMsg = "";

        if (!$this->getRequestParameter('email')) {
            $error = true;
            $errorMsg = "Email is required.";
        } else if (!$this->getRequestParameter('requesterName')) {
            $error = true;
            $errorMsg = "Requester Name is required.";
        } else {
            $mlmMt4DemoRequest = new MlmMt4DemoRequest();
            $mlmMt4DemoRequest->setFullName( $this->getRequestParameter('requesterName'));
            $mlmMt4DemoRequest->setEmail($this->getRequestParameter('email'));
            $mlmMt4DemoRequest->setCountry($this->getRequestParameter('country'));
            $mlmMt4DemoRequest->setPhoneNumber($this->getRequestParameter('phoneNumber'));
            $mlmMt4DemoRequest->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlmMt4DemoRequest->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlmMt4DemoRequest->save();
        }

        $arr = array(
            'error' => $error,
            'errorMsg' => $errorMsg
        );

        echo json_encode($arr);
    }
    public function executeOpenLiveAccount()
    {
        $error = false;
        $errorMsg = "";

        /*require_once('recaptchalib.php');
        $privatekey = "6LfhJtYSAAAAALocUxn6PpgfoWCFjRquNFOSRFdb";
        $resp = recaptcha_check_answer ($privatekey,
                                    $_SERVER["REMOTE_ADDR"],
                                    $_POST["recaptcha_challenge_field"],
                                    $_POST["recaptcha_response_field"]);

        if (!$resp->is_valid) {
            $error = true;
            $errorMsg = "The CAPTCHA wasn't entered correctly. Go back and try it again.";*/
        if (!$this->getRequestParameter('referralId')) {
            $error = true;
            $errorMsg = "Referral ID is required.";
        } else {
            $uplineDistDB = $this->getDistributorInformation($this->getRequestParameter('referralId'));
            if (!$uplineDistDB) {
                $error = true;
                $errorMsg = "Invalid referral ID.";
            } else {
                //$fcode = $this->getRequestParameter('userName');
                //$password = $this->getRequestParameter('userpassword');
                $fcode = $this->generateFcode();
                $password = "";

                //******************* upline distributor ID
                //$treeStructure = $uplineDistDB->getTreeStructure() . "|" . $fcode . "|";
                //$treeLevel = $uplineDistDB->getTreeLevel() + 1;
                $treeStructure = "";
                $treeLevel = 0;

                // ****************************
                $mlm_distributor = new MlmDistributor();
                $mlm_distributor->setDistributorCode($fcode);
                $mlm_distributor->setUserId(Globals::SYSTEM_BROKER_ID);
                $mlm_distributor->setStatusCode(Globals::STATUS_PENDING);
                $mlm_distributor->setFullName($this->getRequestParameter('fullname'));
                $mlm_distributor->setNickname($fcode);
                $mlm_distributor->setIc($this->getRequestParameter('ic'));
                if ($this->getRequestParameter('country') == 'China') {
                    $mlm_distributor->setCountry('China (PRC)');
                } else {
                    $mlm_distributor->setCountry($this->getRequestParameter('country'));
                }
                $mlm_distributor->setAddress($this->getRequestParameter('address'));
                $mlm_distributor->setAddress2($this->getRequestParameter('address2'));
                $mlm_distributor->setCity($this->getRequestParameter('city'));
                $mlm_distributor->setState($this->getRequestParameter('state'));
                $mlm_distributor->setPostcode($this->getRequestParameter('zip'));
                $mlm_distributor->setEmail($this->getRequestParameter('email'));
                $mlm_distributor->setAlternateEmail($this->getRequestParameter('alt_email'));
                $mlm_distributor->setContact($this->getRequestParameter('contactNumber'));
                $mlm_distributor->setGender($this->getRequestParameter('gender'));
                if ($this->getRequestParameter('dob')) {
                    list($d, $m, $y) = sfI18N::getDateForCulture($this->getRequestParameter('dob'), $this->getUser()->getCulture());
                    $mlm_distributor->setDob("$y-$m-$d");
                }
                $mlm_distributor->setBankName($this->getRequestParameter('bankName'));
                $mlm_distributor->setBankAccNo($this->getRequestParameter('bankAccountNo'));
                $mlm_distributor->setBankHolderName($this->getRequestParameter('bankHolderName'));

                $mlm_distributor->setTreeLevel($treeLevel);
                $mlm_distributor->setTreeStructure($treeStructure);
                $mlm_distributor->setUplineDistId($uplineDistDB->getDistributorId());
                $mlm_distributor->setUplineDistCode($uplineDistDB->getDistributorCode());

                $mlm_distributor->setLeverage($this->getRequestParameter('leverage'));
                $mlm_distributor->setSpread($this->getRequestParameter('spread'));
                $mlm_distributor->setDepositCurrency($this->getRequestParameter('deposit_currency'));
                $mlm_distributor->setDepositAmount($this->getRequestParameter('deposit_amount'));
                $mlm_distributor->setSignName($this->getRequestParameter('sign_name'));
                $mlm_distributor->setSignDate(date("Y/m/d h:i:s A"));
                $mlm_distributor->setTermCondition($this->getRequestParameter('term_condition'));
                $mlm_distributor->setExcludedStructure("Y");

                $mlm_distributor->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_BROKER_ID));
                $mlm_distributor->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_BROKER_ID));
                $mlm_distributor->save();
            }
        }
        //print_r("error:".$error.",errorMsg:".$errorMsg);
        $arr = array(
            'error' => $error,
            'errorMsg' => $errorMsg
        );

        echo json_encode($arr);
        /****************************/
        /*****  Send email **********/
        /****************************/
        /*error_reporting(E_STRICT);

        date_default_timezone_set(date_default_timezone_get());

        include_once('class.phpmailer.php');

        $subject = $this->getContext()->getI18N()->__("Vital Universe Group Registration email notification", null, 'email');
        $body = $this->getContext()->getI18N()->__("Dear %1%", array('%1%' => $mlm_distributor->getNickname()), 'email') . ",<p><p>

        <p>" . $this->getContext()->getI18N()->__("Your registration request has been successfully sent to Vital Universe Group", null, 'email') . "</p>
        <p><b>" . $this->getContext()->getI18N()->__("Trader ID", null) . ": " . $fcode . "</b>
        <p><b>" . $this->getContext()->getI18N()->__("Password", null) . ": " . $password . "</b>";

        $mail = new PHPMailer();
        $mail->IsMail(); // telling the class to use SMTP
        $mail->Host = Mails::EMAIL_HOST; // SMTP server
        $mail->Sender = Mails::EMAIL_FROM_NOREPLY;
        $mail->From = Mails::EMAIL_FROM_NOREPLY;
        $mail->FromName = Mails::EMAIL_FROM_NOREPLY_NAME;
        $mail->Subject = $subject;
        $mail->CharSet="utf-8";

        $text_body = $body;

        $mail->Body = $body;
        $mail->AltBody = $text_body;
        $mail->AddAddress($mlm_distributor->getEmail(), $mlm_distributor->getNickname());
        $mail->AddBCC("r9projecthost@gmail.com", "jason");

        if (!$mail->Send()) {
            echo $mail->ErrorInfo;
        }*/
        return sfView::HEADER_ONLY;
    }
    // **********************************************************************************************
    // *******************   ~ end      For broker registeration       end ~   **********************
    // **********************************************************************************************

    public function executeVerifySponsorId()
    {
        $sponsorId = $this->getRequestParameter('sponsorId');

        $array = explode(',', Globals::STATUS_ACTIVE.",".Globals::STATUS_PENDING);
        $c = new Criteria();
        $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $sponsorId);
        $c->add(MlmDistributorPeer::STATUS_CODE, $array, Criteria::IN);
        $existUser = MlmDistributorPeer::doSelectOne($c);

        $arr = "";
        if ($existUser) {
            //if ($existUser->getDistributorId() <> $this->getUser()->getAttribute(Globals::SESSION_DISTID)) {
            $arr = array(
                'userId' => $existUser->getDistributorId(),
                'userName' => $existUser->getDistributorCode(),
                'fullname' => $existUser->getFullName(),
                'nickname' => $existUser->getNickname()
            );
            //}
        }

        echo json_encode($arr);
        return sfView::HEADER_ONLY;
    }

    function generatePaymentReference()
    {
        $max_digit = 9999999999;
        $digit = 12;

        while (true) {
            $fcode = rand(1000000000, $max_digit) . "";
            //$fcode = str_pad($fcode, $digit, "0", STR_PAD_LEFT);
            /*
            for ($x=0; $x < ($digit - strlen($fcode)); $x++) {
                $fcode = "0".$fcode;
            }
			*/
            $c = new Criteria();
            $c->add(MlmDistEpointPurchasePeer::PAYMENT_REFERENCE, $fcode);
            $existCode = MlmDistEpointPurchasePeer::doSelectOne($c);

            if (!$existCode) {
                break;
            }
        }
        return $fcode;
    }

    public function executeVerifyActiveSponsorId()
    {
        $sponsorId = $this->getRequestParameter('sponsorId');

        //$array = explode(',', Globals::STATUS_ACTIVE.",".Globals::STATUS_PENDING);
        $c = new Criteria();
        $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $sponsorId);
        $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        $existUser = MlmDistributorPeer::doSelectOne($c);

        $arr = "";
        if ($existUser) {
            //if ($existUser->getDistributorId() <> $this->getUser()->getAttribute(Globals::SESSION_DISTID)) {
            $arr = array(
                'userId' => $existUser->getDistributorId(),
                'userName' => $existUser->getDistributorCode(),
                'fullname' => $existUser->getFullName(),
                'nickname' => $existUser->getNickname()
            );
            //}
        }

        echo json_encode($arr);
        return sfView::HEADER_ONLY;
    }

    public function executeFetchPackage()
    {
        $c = new Criteria();
        $c->add(MlmAccountPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_EPOINT);
        $c->add(MlmAccountPeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $account = MlmAccountPeer::doSelectOne($c);

        $c = new Criteria();
        $c->add(MlmAccountPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_ECASH);
        $c->add(MlmAccountPeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $ecashAccount = MlmAccountPeer::doSelectOne($c);

        $arr = array(
            'packageId' => 0,
            'point' => 0,
            'ecash' => 0,
            'package' => ""
        );
        if (($account) && ($ecashAccount)) {
            $max = $ecashAccount->getBalance();

            if ($account->getBalance() > $ecashAccount->getBalance())
                $max = $account->getBalance();

            $c = new Criteria();
            //$c->add(MlmPackagePeer::PRICE, $max, Criteria::LESS_EQUAL);
            if ($this->getRequestParameter('publicPurchase') == "") {
                $c->add(MlmPackagePeer::PUBLIC_PURCHASE, Globals::YES);
            } else {
                $c->add(MlmPackagePeer::PUBLIC_PURCHASE, $this->getRequestParameter('publicPurchase'));
            }

            $c->addDescendingOrderByColumn(MlmPackagePeer::PRICE);

            $packages = MlmPackagePeer::doSelect($c);

            $packageArray = array();
            $count = 0;
            foreach ($packages as $package) {
                $packageArray[$count]["packageId"] = $package->getPackageId();
                $packageArray[$count]["name"] = $this->getContext()->getI18N()->__($package->getPackageName());
                $packageArray[$count]["price"] = $package->getPrice();
                $count++;
            }

            $arr = array(
                'point' => $account->getBalance(),
                'ecash' => $ecashAccount->getBalance(),
                'package' => $packageArray
            );
        }

        echo json_encode($arr);
        return sfView::HEADER_ONLY;
    }

    public function executeFetchTopupPackage()
    {
        $c = new Criteria();
        $c->add(MlmAccountPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_EPOINT);
        $c->add(MlmAccountPeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $account = MlmAccountPeer::doSelectOne($c);

        $c = new Criteria();
        $c->add(MlmAccountPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_ECASH);
        $c->add(MlmAccountPeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $ecashAccount = MlmAccountPeer::doSelectOne($c);

        $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->forward404Unless($distDB);

        $distPackage = MlmPackagePeer::retrieveByPK($distDB->getRankId());
        $currentPackageAmount = $distPackage->getPrice();

        if ($currentPackageAmount == null)
            $currentPackageAmount = 99999999;

        $arr = array(
            'packageId' => 0,
            'point' => 0,
            'ecash' => 0,
            'package' => ""
        );
        if (($account) && ($ecashAccount)) {
            $totalEcash = $ecashAccount->getBalance() + $currentPackageAmount;
            $totalEpoint = $account->getBalance() + $currentPackageAmount;

            $max = $totalEcash;

            if ($totalEpoint > $totalEcash)
                $max = $totalEpoint;

            $c = new Criteria();
            $c->add(MlmPackagePeer::PRICE, $max, Criteria::LESS_EQUAL);
            $c->addAnd(MlmPackagePeer::PRICE, $currentPackageAmount, Criteria::GREATER_THAN);
            $c->addAnd(MlmPackagePeer::PRICE, null, Criteria::ISNOTNULL);

            if ($this->getRequestParameter('publicPurchase') == "") {
                $c->add(MlmPackagePeer::PUBLIC_PURCHASE, Globals::YES);
            } else {
                $c->add(MlmPackagePeer::PUBLIC_PURCHASE, $this->getRequestParameter('publicPurchase'));
            }

            $c->addDescendingOrderByColumn(MlmPackagePeer::PRICE);

            $packages = MlmPackagePeer::doSelect($c);

            $packageArray = array();
            $count = 0;
            foreach ($packages as $package) {
                $packageArray[$count]["packageId"] = $package->getPackageId();
                $packageArray[$count]["name"] = $this->getContext()->getI18N()->__($package->getPackageName());
                $packageArray[$count]["price"] = $package->getPrice() - $currentPackageAmount;
                $count++;
            }

            $arr = array(
                'point' => $totalEpoint,
                'ecash' => $totalEcash,
                'package' => $packageArray
            );
        }

        echo json_encode($arr);
        return sfView::HEADER_ONLY;
    }

    public function executeSummary()
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::UPLINE_DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $c->addAnd(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_PENDING);
        $this->pendingDistributors = MlmDistributorPeer::doSelect($c);

        $c = new Criteria();
        $c->add(MlmAnnouncementPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        $c->addDescendingOrderByColumn(MlmAnnouncementPeer::CREATED_ON);
        $c->setLimit(10);
        $this->announcements = MlmAnnouncementPeer::doSelect($c);

        $distributor = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->forward404Unless($distributor);

        $ecash = 0;
        $epoint = 0;
        $maintenancePoint = 0;
        $totalNetworks = 0;
        $ranking = "";
        $mt4Id = "";
        $currencyCode = "";

        $c = new Criteria();
        $c->add(AppSettingPeer::SETTING_PARAMETER, Globals::SETTING_SYSTEM_CURRENCY);
        $settingDB = AppSettingPeer::doSelectOne($c);
        if ($settingDB) {
            $currencyCode = $settingDB->getSettingValue();
        }
        if ($distributor) {
            $existUser = AppUserPeer::retrieveByPK($distributor->getUserId());

            if ($existUser) {
                $lastLogin = $existUser->getLastLoginDatetime();
            }

            $ranking = $distributor->getRankCode();

            $c = new Criteria();
            $c->add(MlmDistMt4Peer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
            $distMt4s = MlmDistMt4Peer::doSelect($c);

            foreach ($distMt4s as $distMt4) {
                if ($mt4Id != "")
                    $mt4Id .= ",";
                $mt4Id .= $distMt4->getMt4UserName();
            }

            $ecash = $this->getAccountBalance($distributor->getDistributorId(), Globals::ACCOUNT_TYPE_ECASH);
            $epoint = $this->getAccountBalance($distributor->getDistributorId(), Globals::ACCOUNT_TYPE_EPOINT);
            $maintenancePoint = $this->getAccountBalance($distributor->getDistributorId(), Globals::ACCOUNT_TYPE_MAINTENANCE);

            $c = new Criteria();
            $c->add(MlmDistributorPeer::TREE_STRUCTURE, "%".$distributor->getDistributorCode()."%", Criteria::LIKE);
            $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
            $totalNetworks = MlmDistributorPeer::doCount($c);
        }

        $this->ecash = $ecash;
        $this->epoint = $epoint;
        $this->totalNetworks = $totalNetworks;
        $this->ranking = $ranking;
        $this->mt4Id = $mt4Id;
        $this->distMt4s = $distMt4s;
        $this->colorArr = $this->getRankColorArr();
        $this->currencyCode = $currencyCode;
        $this->distributor = $distributor;
        $this->lastLogin = $lastLogin;
        $this->maintenancePoint = $maintenancePoint;
    }

    public function executeAnnouncementList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        /******   total records  *******/
        $c = new Criteria();
        $c->add(MlmAnnouncementPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        $totalRecords = MlmAnnouncementPeer::doCount($c);

        /******   total filtered records  *******/
        /*if ($this->getRequestParameter('filterAction') != "") {
            $c->addAnd(MlmAnnouncementPeer::TRANSACTION_TYPE, "%" . $this->getRequestParameter('filterAction') . "%", Criteria::LIKE);
        }*/
        $totalFilteredRecords = MlmAnnouncementPeer::doCount($c);

        /******   sorting  *******/
        for ($i = 0; $i < intval($this->getRequestParameter('iSortingCols')); $i++)
        {
            if ($this->getRequestParameter('bSortable_' . intval($this->getRequestParameter('iSortCol_' . $i))) == "true") {
                if ("asc" == $this->getRequestParameter('sSortDir_' . $i)) {
                    $c->addAscendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                } else {
                    $c->addDescendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                }
            }
        }

        /******   pagination  *******/
        $pager = new sfPropelPager('MlmAnnouncement', $limit);
        $pager->setCriteria($c);
        $pager->setPage(($offset / $limit) + 1);
        $pager->init();

        foreach ($pager->getResults() as $result) {
            $title = $result->getTitle();
            $createdOn = $result->getCreatedOn();

            if ($this->getUser()->getCulture() == "cn") {
                $title = $result->getTitleCn();
                $createdOn = $result->getCreatedOn();
            }
            $arr[] = array(
                $result->getAnnouncementId(),
                $title,
                $createdOn
            );
        }

        $output = array(
            "sEcho" => intval($sEcho),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalFilteredRecords,
            "aaData" => $arr
        );
        echo json_encode($output);

        return sfView::HEADER_ONLY;
    }

    public function executeBonusDetailList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        /******   total records  *******/
        $c = new Criteria();
        $c->add(MlmDistCommissionLedgerPeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        //$c->add(MlmDistCommissionLedgerPeer::COMMISSION_TYPE, Globals::ACCOUNT_LEDGER_ACTION_DRB);
        $c->add(MlmDistCommissionLedgerPeer::COMMISSION_TYPE, $this->getRequestParameter('filterBonusType'));
        $totalRecords = MlmDistCommissionLedgerPeer::doCount($c);

        /******   total filtered records  *******/
        if ($this->getRequestParameter('filterMonth') != "" && $this->getRequestParameter('filterYear') != "") {
            $dateUtil = new DateUtil();
            $month = $this->getRequestParameter('filterMonth');
            $year = $this->getRequestParameter('filterYear');
            $d = $dateUtil->getMonth($month, $year);

            $firstOfMonth = date('Y-m-j', $d["first_of_month"]) . " 00:00:00";
            $lastOfMonth = date('Y-m-j', $d["last_of_month"]) . " 23:59:59";

            $c->add(MlmDistCommissionLedgerPeer::CREATED_ON, $firstOfMonth, Criteria::GREATER_EQUAL);
            $c->addAnd(MlmDistCommissionLedgerPeer::CREATED_ON, $lastOfMonth, Criteria::LESS_EQUAL);
        }

        $totalFilteredRecords = MlmDistCommissionLedgerPeer::doCount($c);

        /******   sorting  *******/
        for ($i = 0; $i < intval($this->getRequestParameter('iSortingCols')); $i++)
        {
            if ($this->getRequestParameter('bSortable_' . intval($this->getRequestParameter('iSortCol_' . $i))) == "true") {
                if ("asc" == $this->getRequestParameter('sSortDir_' . $i)) {
                    $c->addAscendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                } else {
                    $c->addDescendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                }
            }
        }

        /******   pagination  *******/
        $pager = new sfPropelPager('MlmDistCommissionLedger', $limit);
        $pager->setCriteria($c);
        $pager->setPage(($offset / $limit) + 1);
        $pager->init();

        foreach ($pager->getResults() as $result) {
            $extraRemark = "";
            if (Globals::STATUS_COMPLETE == $result->getStatusCode()) {
                $dateString = $result->getUpdatedOn();
                $dateArr = explode(" ", $dateString);
                $extraRemark = "Successful credited into MT4 Fund (".$dateArr[0].")";
            }
            $arr[] = array(
                $result->getCommissionId() == null ? "0" : $result->getCommissionId(),
                $result->getCreatedOn() == null ? "" : $result->getCreatedOn(),
                $result->getCommissionType() == null ? ""
                        : $this->getContext()->getI18N()->__($result->getCommissionType()),
                $result->getCredit() == null ? "0" : number_format($result->getCredit(), 2),
                $result->getDebit() == null ? "0" : number_format($result->getDebit(), 2),
                $result->getRemark() == null ? "" : $result->getRemark(),
                $extraRemark
            );
        }

        $output = array(
            "sEcho" => intval($sEcho),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalFilteredRecords,
            "aaData" => $arr
        );
        echo json_encode($output);

        return sfView::HEADER_ONLY;
    }

    public function executeDelete()
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::UPLINE_DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $c->addAnd(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_PENDING);
        $c->addAnd(MlmDistributorPeer::DISTRIBUTOR_ID, $this->getRequestParameter('distid'));
        $mlmDistributor = MlmDistributorPeer::doSelectOne($c);
        $this->forward404Unless($mlmDistributor);

        $mlmDistributor->setStatusCode(Globals::STATUS_CANCEL);
        $mlmDistributor->save();

        $appUser = AppUserPeer::retrieveByPk($mlmDistributor->getUserId());
        $this->forward404Unless($appUser);
        $appUser->setStatusCode(Globals::STATUS_CANCEL);
        $appUser->save();

        return $this->redirect('/member/summary');
    }

    public function executeVerifyTransactionPassword()
    {
        $array = explode(',', Globals::STATUS_ACTIVE.",".Globals::STATUS_PENDING);
        $c = new Criteria();
        $c->add(AppUserPeer::USER_ID, $this->getUser()->getAttribute(Globals::SESSION_USERID));
        $c->add(AppUserPeer::USERPASSWORD2, $this->getRequestParameter('transactionPassword'));
        $c->add(AppUserPeer::USER_ROLE, Globals::ROLE_DISTRIBUTOR);
        //$c->add(AppUserPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        $c->add(AppUserPeer::STATUS_CODE, $array, Criteria::IN);

        $existUser = AppUserPeer::doSelectOne($c);

        if ($existUser) {
            echo 'true';
        } else {
            echo 'false';
        }

        return sfView::HEADER_ONLY;
    }

    public function executeActivateMember()
    {
        $sponsorId = $this->getRequestParameter('sponsorId');
        //$sponsorId = $this->getUser()->getAttribute(Globals::SESSION_DISTID);
        $transactionPassword = $this->getRequestParameter('transactionPassword');
        $packageId = $this->getRequestParameter('packageId');
        $paymentType = "epoint";
        //$paymentType = $this->getRequestParameter('paymentType');
        $error = false;
        $errorMsg = "";

        //$array = explode(',', Globals::STATUS_ACTIVE.",".Globals::STATUS_PENDING);
        $c = new Criteria();
        $c->add(AppUserPeer::USER_ID, $this->getUser()->getAttribute(Globals::SESSION_USERID));
        $c->add(AppUserPeer::USERPASSWORD2, $transactionPassword);
        $c->add(AppUserPeer::USER_ROLE, Globals::ROLE_DISTRIBUTOR);
        $c->add(AppUserPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        //$c->add(MlmDistributorPeer::STATUS_CODE, $array, Criteria::IN);

        $existUser = AppUserPeer::doSelectOne($c);
        if (!$existUser) {
            $error = true;
            $errorMsg = "Invalid Security Password.";
        }

        $packageDB = null;
        if (!$error) {
            $packageDB = MlmPackagePeer::retrieveByPK($packageId);
            $this->forward404Unless($packageDB);
            if (!$packageDB) {
                $error = true;
                $errorMsg = "Invalid Package.";
            }
        }

        if (!$error) {
            if ("epoint" == $paymentType) {
                $balance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);
                if ($balance < $packageDB->getPrice()) {
                    $error = true;
                    $errorMsg = "Insufficient CP1.";
                }
            } else if ("ecash" == $paymentType) {
                $balance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ECASH);
                if ($balance < $packageDB->getPrice()) {
                    $error = true;
                    $errorMsg = "Insufficient CP2.";
                }
            } else {
                $error = true;
                $errorMsg = "Invalid Action.";
            }
        }

        if (!$error) {
            $distDB = MlmDistributorPeer::retrieveByPK($sponsorId);
            $this->doActivateAccount($distDB->getUplineDistId(), $sponsorId, $packageId, $paymentType);
        }
        $arr = array(
            'error' => $error
        , 'errorMsg' => $errorMsg
        );
        echo json_encode($arr);
        return sfView::HEADER_ONLY;
    }

    public function executePlacementTree()
    {
        if ($this->getRequestParameter('doAction') == "save") {
            $uplineDistCode = $this->getRequestParameter('uplineDistCode');
            $uplinePosition = $this->getRequestParameter('uplinePosition');
            $sponsorDistId = $this->getRequestParameter('sponsorDistId');

            $uplineDistDB = $this->getDistributorInformation($uplineDistCode);
            $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            $sponsorDB = MlmDistributorPeer::retrieveByPk($sponsorDistId);
            $this->forward404Unless($distDB);
            $this->forward404Unless($sponsorDB);

            $treeStructure = $uplineDistDB->getPlacementTreeStructure() . "|" . $sponsorDB->getDistributorCode() . "|";
            $treeLevel = $uplineDistDB->getPlacementTreeLevel() + 1;

            $sponsorDB->setPlacementDatetime(date("Y/m/d h:i:s A"));
            $sponsorDB->setPlacementPosition($uplinePosition);
            //$sponsorDB->setUplineDistId($uplineDistDB->getDistributorId());
            //$sponsorDB->setUplineDistCode($uplineDistDB->getDistributorCode());
            $sponsorDB->setPlacementTreeStructure($treeStructure);
            $sponsorDB->setPlacementTreeLevel($treeLevel);
            $sponsorDB->setTreeUplineDistId($uplineDistDB->getDistributorId());
            $sponsorDB->setTreeUplineDistCode($uplineDistDB->getDistributorCode());
            $sponsorDB->save();

            $sponsoredPackageDB = MlmPackagePeer::retrieveByPK($sponsorDB->getRankId());
            $this->forward404Unless($sponsoredPackageDB);
            $pairingPoint = $sponsoredPackageDB->getPrice();

            // recalculate Total left and total right for $uplineDistDB
            $arrs = explode("|", $uplineDistDB->getPlacementTreeStructure());
            for ($x = count($arrs); $x > 0; $x--) {
                if ($arrs[$x] == "") {
                    continue;
                }
                $uplineDistDB = $this->getDistributorInformation($arrs[$x]);
                $this->forward404Unless($uplineDistDB);
                $totalLeft = $this->getTotalPosition($arrs[$x], Globals::PLACEMENT_LEFT);
                $totalRight = $this->getTotalPosition($arrs[$x], Globals::PLACEMENT_RIGHT);
                $uplineDistDB->setTotalLeft($totalLeft);
                $uplineDistDB->setTotalRight($totalRight);
                $uplineDistDB->save();
            }

            /******************************/
            /*  store Pairing points
            /******************************/
            if ($sponsorDB->getTreeUplineDistId() != 0 && $sponsorDB->getTreeUplineDistCode() != null) {
                $level = 0;
                $uplineDistDB = MlmDistributorPeer::retrieveByPk($sponsorDB->getTreeUplineDistId());
                $sponsoredDistributorCode = $sponsorDB->getDistributorCode();
                while ($level < 100) {
                    //var_dump($uplineDistDB->getUplineDistId());
                    //var_dump($uplineDistDB->getUplineDistCode());
                    //print_r("<br>");
                    $c = new Criteria();
                    $c->add(MlmDistPairingPeer::DIST_ID, $uplineDistDB->getDistributorId());
                    $sponsorDistPairingDB = MlmDistPairingPeer::doSelectOne($c);

                    $addToLeft = 0;
                    $addToRight = 0;
                    $leftBalance = 0;
                    $rightBalance = 0;
                    if (!$sponsorDistPairingDB) {
                        $sponsorDistPairingDB = new MlmDistPairing();
                        $sponsorDistPairingDB->setDistId($uplineDistDB->getDistributorId());

                        $packageDB = MlmPackagePeer::retrieveByPK($uplineDistDB->getRankId());
                        $this->forward404Unless($packageDB);

                        $sponsorDistPairingDB->setLeftBalance($leftBalance);
                        $sponsorDistPairingDB->setRightBalance($rightBalance);
                        $sponsorDistPairingDB->setFlushLimit($packageDB->getDailyMaxPairing());
                        $sponsorDistPairingDB->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    } else {
                        $leftBalance = $sponsorDistPairingDB->getLeftBalance();
                        $rightBalance = $sponsorDistPairingDB->getRightBalance();
                    }
                    $sponsorDistPairingDB->setLeftBalance($leftBalance + $addToLeft);
                    $sponsorDistPairingDB->setRightBalance($rightBalance + $addToRight);
                    $sponsorDistPairingDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $sponsorDistPairingDB->save();

                    $c = new Criteria();
                    $c->add(MlmDistPairingLedgerPeer::DIST_ID, $uplineDistDB->getDistributorId());
                    $c->add(MlmDistPairingLedgerPeer::LEFT_RIGHT, $uplinePosition);
                    $c->addDescendingOrderByColumn(MlmDistPairingLedgerPeer::CREATED_ON);
                    $sponsorDistPairingLedgerDB = MlmDistPairingLedgerPeer::doSelectOne($c);

                    $legBalance = 0;
                    if ($sponsorDistPairingLedgerDB) {
                        $legBalance = $sponsorDistPairingLedgerDB->getBalance();
                    }

                    $sponsorDistPairingledger = new MlmDistPairingLedger();
                    $sponsorDistPairingledger->setDistId($uplineDistDB->getDistributorId());
                    $sponsorDistPairingledger->setLeftRight($uplinePosition);
                    $sponsorDistPairingledger->setTransactionType(Globals::PAIRING_LEDGER_REGISTER);
                    $sponsorDistPairingledger->setCredit($pairingPoint);
                    $sponsorDistPairingledger->setDebit(0);
                    $sponsorDistPairingledger->setBalance($legBalance + $pairingPoint);
                    $sponsorDistPairingledger->setRemark("PAIRING POINT AMOUNT (" . $sponsoredDistributorCode . ")");
                    $sponsorDistPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $sponsorDistPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $sponsorDistPairingledger->save();

                    $this->revalidatePairing($uplineDistDB->getDistributorId(), $uplinePosition);

                    if ($uplineDistDB->getTreeUplineDistId() == 0 || $uplineDistDB->getTreeUplineDistCode() == null) {
                        break;
                    }

                    $uplinePosition = $uplineDistDB->getPlacementPosition();
                    $uplineDistDB = MlmDistributorPeer::retrieveByPk($uplineDistDB->getTreeUplineDistId());
                    $level++;
                }
            }
            /******************************/
            /*  Pairing             ~ END ~
            /******************************/
            return $this->redirect('/member/placementTree?distcode=' . $this->getRequestParameter('distcode', $this->getUser()->getAttribute(Globals::SESSION_USERNAME)));
        }
        $distcode = $this->getRequestParameter('distcode', $this->getUser()->getAttribute(Globals::SESSION_USERNAME));
        $pageDirection = $this->getRequestParameter('p', "");

        $this->pageDirection = $pageDirection;
        $anode = array();
        //      0
        //  1       2
        //3   4   5   6

        $c = new Criteria();
        $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $distcode);
        $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        $c->add(MlmDistributorPeer::PLACEMENT_TREE_STRUCTURE, "%|" . $this->getUser()->getAttribute(Globals::SESSION_USERNAME) . "|%", Criteria::LIKE);
        $distDB = MlmDistributorPeer::doSelectOne($c);

        if (!$distDB) {
            $this->errorSearch = true;
            $c = new Criteria();
            $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $this->getUser()->getAttribute(Globals::SESSION_USERNAME));
            $distDB = MlmDistributorPeer::doSelectOne($c);
        }

        $leftOnePlacement = $this->getPlacementDistributorInformation($distDB->getDistributorId(), Globals::PLACEMENT_LEFT);
        $rightTwoPlacement = $this->getPlacementDistributorInformation($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT);
        $anode[0]["distCode"] = $distDB->getDistributorCode();
        $anode[0]["_self"] = $distDB;
        $anode[0]["_left"] = $leftOnePlacement;
        $anode[0]["_right"] = $rightTwoPlacement;
        $anode[0]["_available"] = false;
        $anode[0]["_left_this_month_sales"] = $this->getThisMonthSales($distDB->getDistributorId(), Globals::PLACEMENT_LEFT);
        $anode[0]["_right_this_month_sales"] = $this->getThisMonthSales($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT);
        $anode[0]["_dist_pairing_ledger"] = $this->queryDistPairing($distDB->getDistributorId());
        $anode[0]["_accumulate_left"] = $this->getAccumulateGroupBvs($distDB->getDistributorId(), Globals::PLACEMENT_LEFT);
        $anode[0]["_accumulate_right"] = $this->getAccumulateGroupBvs($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT);
        $anode[0]["_today_left"] = $this->getTodaySales($distDB->getDistributorId(), Globals::PLACEMENT_LEFT);
        $anode[0]["_today_right"] = $this->getTodaySales($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT);
        $anode[0]["_carry_left"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_LEFT, null) - $anode[0]["_today_left"];
        $anode[0]["_carry_right"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT, null) - $anode[0]["_today_right"];
        $anode[0]["_sales_left"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_LEFT, null);
        $anode[0]["_sales_right"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT, null);

        if ($leftOnePlacement == null) {
            $anode[1]["distCode"] = "";
            $anode[1]["_self"] = new MlmDistributor();
            $anode[1]["_left"] = null;
            $anode[1]["_right"] = null;
            $anode[1]["_available"] = true;
            $anode[1]["_left_this_month_sales"] = null;
            $anode[1]["_right_this_month_sales"] = null;
            $anode[1]["_dist_pairing_ledger"] = null;
            $anode[1]["_accumulate_left"] = null;
            $anode[1]["_accumulate_right"] = null;
            $anode[1]["_today_left"] = null;
            $anode[1]["_today_right"] = null;
            $anode[1]["_carry_left"] = null;
            $anode[1]["_carry_right"] = null;
            $anode[1]["_sales_left"] = null;
            $anode[1]["_sales_right"] = null;

            $anode[3]["distCode"] = "";
            $anode[3]["_self"] = new MlmDistributor();
            $anode[3]["_left"] = null;
            $anode[3]["_right"] = null;
            $anode[3]["_available"] = false;
            $anode[3]["_left_this_month_sales"] = null;
            $anode[3]["_right_this_month_sales"] = null;
            $anode[3]["_dist_pairing_ledger"] = null;
            $anode[3]["_accumulate_left"] = null;
            $anode[3]["_accumulate_right"] = null;
            $anode[3]["_today_left"] = null;
            $anode[3]["_today_right"] = null;
            $anode[3]["_carry_left"] = null;
            $anode[3]["_carry_right"] = null;
            $anode[3]["_sales_left"] = null;
            $anode[3]["_sales_right"] = null;

            $anode[4]["distCode"] = "";
            $anode[4]["_self"] = new MlmDistributor();
            $anode[4]["_left"] = null;
            $anode[4]["_right"] = null;
            $anode[4]["_available"] = false;
            $anode[4]["_left_this_month_sales"] = null;
            $anode[4]["_right_this_month_sales"] = null;
            $anode[4]["_dist_pairing_ledger"] = null;
            $anode[4]["_accumulate_left"] = null;
            $anode[4]["_accumulate_right"] = null;
            $anode[4]["_today_left"] = null;
            $anode[4]["_today_right"] = null;
            $anode[4]["_carry_left"] = null;
            $anode[4]["_carry_right"] = null;
            $anode[4]["_sales_left"] = null;
            $anode[4]["_sales_right"] = null;
        } else {
            $distDB = $this->getDistributorInformation($leftOnePlacement->getDistributorCode());
            $leftThreePlacement = $this->getPlacementDistributorInformation($distDB->getDistributorId(), Globals::PLACEMENT_LEFT);
            $rightFourPlacement = $this->getPlacementDistributorInformation($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT);

            $anode[1]["distCode"] = $leftOnePlacement->getDistributorCode();
            $anode[1]["_self"] = $distDB;
            $anode[1]["_left"] = $leftThreePlacement;
            $anode[1]["_right"] = $rightFourPlacement;
            $anode[1]["_available"] = false;
            $anode[1]["_left_this_month_sales"] = $this->getThisMonthSales($leftOnePlacement->getDistributorId(), Globals::PLACEMENT_LEFT);
            $anode[1]["_right_this_month_sales"] = $this->getThisMonthSales($leftOnePlacement->getDistributorId(), Globals::PLACEMENT_RIGHT);
            $anode[1]["_dist_pairing_ledger"] = $this->queryDistPairing($leftOnePlacement->getDistributorId());
            $anode[1]["_accumulate_left"] = $this->getAccumulateGroupBvs($leftOnePlacement->getDistributorId(), Globals::PLACEMENT_LEFT);
            $anode[1]["_accumulate_right"] = $this->getAccumulateGroupBvs($leftOnePlacement->getDistributorId(), Globals::PLACEMENT_RIGHT);
            $anode[1]["_today_left"] = $this->getTodaySales($distDB->getDistributorId(), Globals::PLACEMENT_LEFT);
            $anode[1]["_today_right"] = $this->getTodaySales($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT);
            $anode[1]["_carry_left"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_LEFT, null) - $anode[1]["_today_left"];
            $anode[1]["_carry_right"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT, null) - $anode[1]["_today_right"];
            $anode[1]["_sales_left"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_LEFT, null);
            $anode[1]["_sales_right"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT, null);

            if ($leftThreePlacement == null) {
                $anode[3]["distCode"] = "";
                $anode[3]["_self"] = new MlmDistributor();
                $anode[3]["_left"] = null;
                $anode[3]["_right"] = null;
                $anode[3]["_available"] = true;
                $anode[3]["_left_this_month_sales"] = null;
                $anode[3]["_right_this_month_sales"] = null;
                $anode[3]["_dist_pairing_ledger"] = null;
                $anode[3]["_accumulate_left"] = null;
                $anode[3]["_accumulate_right"] = null;
                $anode[3]["_today_left"] = null;
                $anode[3]["_today_right"] = null;
                $anode[3]["_carry_left"] = null;
                $anode[3]["_carry_right"] = null;
                $anode[3]["_sales_left"] = null;
                $anode[3]["_sales_right"] = null;
            } else {
                $distDB = $this->getDistributorInformation($leftThreePlacement->getDistributorCode());
                $anode[3]["distCode"] = $leftThreePlacement->getDistributorCode();
                $anode[3]["_self"] = $distDB;
                $anode[3]["_left"] = null;
                $anode[3]["_right"] = null;
                $anode[3]["_available"] = false;
                $anode[3]["_left_this_month_sales"] = $this->getThisMonthSales($leftThreePlacement->getDistributorId(), Globals::PLACEMENT_LEFT);
                $anode[3]["_right_this_month_sales"] = $this->getThisMonthSales($leftThreePlacement->getDistributorId(), Globals::PLACEMENT_RIGHT);
                $anode[3]["_dist_pairing_ledger"] = $this->queryDistPairing($leftThreePlacement->getDistributorId());
                $anode[3]["_accumulate_left"] = $this->getAccumulateGroupBvs($leftThreePlacement->getDistributorId(), Globals::PLACEMENT_LEFT);
                $anode[3]["_accumulate_right"] = $this->getAccumulateGroupBvs($leftThreePlacement->getDistributorId(), Globals::PLACEMENT_RIGHT);
                $anode[3]["_today_left"] = $this->getTodaySales($distDB->getDistributorId(), Globals::PLACEMENT_LEFT);
                $anode[3]["_today_right"] = $this->getTodaySales($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT);
                $anode[3]["_carry_left"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_LEFT, null) - $anode[3]["_today_left"];
                $anode[3]["_carry_right"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT, null) - $anode[3]["_today_right"];
                $anode[3]["_sales_left"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_LEFT, null);
                $anode[3]["_sales_right"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT, null);
            }
            if ($rightFourPlacement == null) {
                $anode[4]["distCode"] = "";
                $anode[4]["_self"] = new MlmDistributor();
                $anode[4]["_left"] = null;
                $anode[4]["_right"] = null;
                $anode[4]["_available"] = true;
                $anode[4]["_left_this_month_sales"] = null;
                $anode[4]["_right_this_month_sales"] = null;
                $anode[4]["_dist_pairing_ledger"] = null;
                $anode[4]["_accumulate_left"] = null;
                $anode[4]["_accumulate_right"] = null;
                $anode[4]["_today_left"] = null;
                $anode[4]["_today_right"] = null;
                $anode[4]["_carry_left"] = null;
                $anode[4]["_carry_right"] = null;
                $anode[4]["_sales_left"] = null;
                $anode[4]["_sales_right"] = null;
            } else {
                $distDB = $this->getDistributorInformation($rightFourPlacement->getDistributorCode());
                $anode[4]["distCode"] = $rightFourPlacement->getDistributorCode();
                $anode[4]["_self"] = $distDB;
                $anode[4]["_left"] = null;
                $anode[4]["_right"] = null;
                $anode[4]["_available"] = false;
                $anode[4]["_left_this_month_sales"] = $this->getThisMonthSales($rightFourPlacement->getDistributorId(), Globals::PLACEMENT_LEFT);
                $anode[4]["_right_this_month_sales"] = $this->getThisMonthSales($rightFourPlacement->getDistributorId(), Globals::PLACEMENT_RIGHT);
                $anode[4]["_dist_pairing_ledger"] = $this->queryDistPairing($rightFourPlacement->getDistributorId());
                $anode[4]["_accumulate_left"] = $this->getAccumulateGroupBvs($rightFourPlacement->getDistributorId(), Globals::PLACEMENT_LEFT);
                $anode[4]["_accumulate_right"] = $this->getAccumulateGroupBvs($rightFourPlacement->getDistributorId(), Globals::PLACEMENT_RIGHT);
                $anode[4]["_today_left"] = $this->getTodaySales($distDB->getDistributorId(), Globals::PLACEMENT_LEFT);
                $anode[4]["_today_right"] = $this->getTodaySales($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT);
                $anode[4]["_carry_left"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_LEFT, null) - $anode[4]["_today_left"];
                $anode[4]["_carry_right"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT, null) - $anode[4]["_today_right"];
                $anode[4]["_sales_left"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_LEFT, null);
                $anode[4]["_sales_right"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT, null);
            }
        }
        if ($rightTwoPlacement == null) {
            $anode[2]["distCode"] = "";
            $anode[2]["_self"] = new MlmDistributor();
            $anode[2]["_left"] = null;
            $anode[2]["_right"] = null;
            $anode[2]["_available"] = true;
            $anode[2]["_left_this_month_sales"] = null;
            $anode[2]["_right_this_month_sales"] = null;
            $anode[2]["_dist_pairing_ledger"] = null;
            $anode[2]["_accumulate_left"] = null;
            $anode[2]["_accumulate_right"] = null;
            $anode[2]["_today_left"] = null;
            $anode[2]["_today_right"] = null;
            $anode[2]["_carry_left"] = null;
            $anode[2]["_carry_right"] = null;
            $anode[2]["_sales_left"] = null;
            $anode[2]["_sales_right"] = null;

            $anode[5]["distCode"] = "";
            $anode[5]["_self"] = new MlmDistributor();
            $anode[5]["_left"] = null;
            $anode[5]["_right"] = null;
            $anode[5]["_available"] = false;
            $anode[5]["_left_this_month_sales"] = null;
            $anode[5]["_right_this_month_sales"] = null;
            $anode[5]["_dist_pairing_ledger"] = null;
            $anode[5]["_accumulate_left"] = null;
            $anode[5]["_accumulate_right"] = null;
            $anode[5]["_today_left"] = null;
            $anode[5]["_today_right"] = null;
            $anode[5]["_carry_left"] = null;
            $anode[5]["_carry_right"] = null;
            $anode[5]["_sales_left"] = null;
            $anode[5]["_sales_right"] = null;

            $anode[6]["distCode"] = "";
            $anode[6]["_self"] = new MlmDistributor();
            $anode[6]["_left"] = null;
            $anode[6]["_right"] = null;
            $anode[6]["_available"] = false;
            $anode[6]["_left_this_month_sales"] = null;
            $anode[6]["_right_this_month_sales"] = null;
            $anode[6]["_dist_pairing_ledger"] = null;
            $anode[6]["_accumulate_left"] = null;
            $anode[6]["_accumulate_right"] = null;
            $anode[6]["_today_left"] = null;
            $anode[6]["_today_right"] = null;
            $anode[6]["_carry_left"] = null;
            $anode[6]["_carry_right"] = null;
            $anode[6]["_sales_left"] = null;
            $anode[6]["_sales_right"] = null;
        } else {
            $distDB = $this->getDistributorInformation($rightTwoPlacement->getDistributorCode());
            $leftFivePlacement = $this->getPlacementDistributorInformation($distDB->getDistributorId(), Globals::PLACEMENT_LEFT);
            $rightSixPlacement = $this->getPlacementDistributorInformation($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT);

            $anode[2]["distCode"] = $rightTwoPlacement->getDistributorCode();
            $anode[2]["_self"] = $distDB;
            $anode[2]["_left"] = $leftFivePlacement;
            $anode[2]["_right"] = $rightSixPlacement;
            $anode[2]["_available"] = false;
            $anode[2]["_left_this_month_sales"] = $this->getThisMonthSales($rightTwoPlacement->getDistributorId(), Globals::PLACEMENT_LEFT);
            $anode[2]["_right_this_month_sales"] = $this->getThisMonthSales($rightTwoPlacement->getDistributorId(), Globals::PLACEMENT_RIGHT);
            $anode[2]["_dist_pairing_ledger"] = $this->queryDistPairing($rightTwoPlacement->getDistributorId());
            $anode[2]["_accumulate_left"] = $this->getAccumulateGroupBvs($rightTwoPlacement->getDistributorId(), Globals::PLACEMENT_LEFT);
            $anode[2]["_accumulate_right"] = $this->getAccumulateGroupBvs($rightTwoPlacement->getDistributorId(), Globals::PLACEMENT_RIGHT);
            $anode[2]["_today_left"] = $this->getTodaySales($distDB->getDistributorId(), Globals::PLACEMENT_LEFT);
            $anode[2]["_today_right"] = $this->getTodaySales($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT);
            $anode[2]["_carry_left"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_LEFT, null) - $anode[2]["_today_left"];
            $anode[2]["_carry_right"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT, null) - $anode[2]["_today_right"];
            $anode[2]["_sales_left"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_LEFT, null);
            $anode[2]["_sales_right"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT, null);


            if ($leftFivePlacement == null) {
                $anode[5]["distCode"] = "";
                $anode[5]["_self"] = new MlmDistributor();
                $anode[5]["_left"] = null;
                $anode[5]["_right"] = null;
                $anode[5]["_available"] = true;
                $anode[5]["_left_this_month_sales"] = null;
                $anode[5]["_right_this_month_sales"] = null;
                $anode[5]["_dist_pairing_ledger"] = null;
                $anode[5]["_accumulate_left"] = null;
                $anode[5]["_accumulate_right"] = null;
                $anode[5]["_today_left"] = null;
                $anode[5]["_today_right"] = null;
                $anode[5]["_carry_left"] = null;
                $anode[5]["_carry_right"] = null;
                $anode[5]["_sales_left"] = null;
                $anode[5]["_sales_right"] = null;
            } else {
                $distDB = $this->getDistributorInformation($leftFivePlacement->getDistributorCode());
                $anode[5]["distCode"] = $leftFivePlacement->getDistributorCode();
                $anode[5]["_self"] = $distDB;
                $anode[5]["_left"] = null;
                $anode[5]["_right"] = null;
                $anode[5]["_available"] = false;
                $anode[5]["_left_this_month_sales"] = $this->getThisMonthSales($leftFivePlacement->getDistributorId(), Globals::PLACEMENT_LEFT);
                $anode[5]["_right_this_month_sales"] = $this->getThisMonthSales($leftFivePlacement->getDistributorId(), Globals::PLACEMENT_RIGHT);
                $anode[5]["_dist_pairing_ledger"] = $this->queryDistPairing($leftFivePlacement->getDistributorId());
                $anode[5]["_accumulate_left"] = $this->getAccumulateGroupBvs($leftFivePlacement->getDistributorId(), Globals::PLACEMENT_LEFT);
                $anode[5]["_accumulate_right"] = $this->getAccumulateGroupBvs($leftFivePlacement->getDistributorId(), Globals::PLACEMENT_RIGHT);
                $anode[5]["_today_left"] = $this->getTodaySales($distDB->getDistributorId(), Globals::PLACEMENT_LEFT);
                $anode[5]["_today_right"] = $this->getTodaySales($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT);
                $anode[5]["_carry_left"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_LEFT, null) - $anode[5]["_today_left"];
                $anode[5]["_carry_right"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT, null) - $anode[5]["_today_right"];
                $anode[5]["_sales_left"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_LEFT, null);
                $anode[5]["_sales_right"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT, null);
            }
            if ($rightSixPlacement == null) {
                $anode[6]["distCode"] = "";
                $anode[6]["_self"] = new MlmDistributor();
                $anode[6]["_left"] = null;
                $anode[6]["_right"] = null;
                $anode[6]["_available"] = true;
                $anode[6]["_left_this_month_sales"] = null;
                $anode[6]["_right_this_month_sales"] = null;
                $anode[6]["_dist_pairing_ledger"] = null;
                $anode[6]["_accumulate_left"] = null;
                $anode[6]["_accumulate_right"] = null;
                $anode[6]["_today_left"] = null;
                $anode[6]["_today_right"] = null;
                $anode[6]["_carry_left"] = null;
                $anode[6]["_carry_right"] = null;
                $anode[6]["_sales_left"] = null;
                $anode[6]["_sales_right"] = null;
            } else {
                $distDB = $this->getDistributorInformation($rightSixPlacement->getDistributorCode());
                $anode[6]["distCode"] = $rightSixPlacement->getDistributorCode();
                $anode[6]["_self"] = $distDB;
                $anode[6]["_left"] = null;
                $anode[6]["_right"] = null;
                $anode[6]["_available"] = false;
                $anode[6]["_left_this_month_sales"] = $this->getThisMonthSales($rightSixPlacement->getDistributorId(), Globals::PLACEMENT_LEFT);
                $anode[6]["_right_this_month_sales"] = $this->getThisMonthSales($rightSixPlacement->getDistributorId(), Globals::PLACEMENT_RIGHT);
                $anode[6]["_dist_pairing_ledger"] = $this->queryDistPairing($rightSixPlacement->getDistributorId());
                $anode[6]["_accumulate_left"] = $this->getAccumulateGroupBvs($rightSixPlacement->getDistributorId(), Globals::PLACEMENT_LEFT);
                $anode[6]["_accumulate_right"] = $this->getAccumulateGroupBvs($rightSixPlacement->getDistributorId(), Globals::PLACEMENT_RIGHT);
                $anode[6]["_today_left"] = $this->getTodaySales($distDB->getDistributorId(), Globals::PLACEMENT_LEFT);
                $anode[6]["_today_right"] = $this->getTodaySales($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT);
                $anode[6]["_carry_left"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_LEFT, null) - $anode[6]["_today_left"];
                $anode[6]["_carry_right"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT, null) - $anode[6]["_today_right"];
                $anode[6]["_sales_left"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_LEFT, null);
                $anode[6]["_sales_right"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT, null);
            }
        }

        $this->distcode = $distcode;
        $this->anode = $anode;
        $this->colorArr = $this->getRankColorArr();

        $isTop = false;
        if (strtoupper($distcode) == strtoupper($this->getUser()->getAttribute(Globals::SESSION_USERNAME))) {
            $isTop = true;
        }
        $this->isTop = $isTop;

        if ($pageDirection == "stat") {
            $this->setTemplate('placementTreeStat');
        }
    }

    public function executePendingMemberList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        /******   total records  *******/
        $c = new Criteria();
        $c->add(MlmDistributorPeer::UPLINE_DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        $c->add(MlmDistributorPeer::PLACEMENT_TREE_LEVEL, null, Criteria::ISNULL);
        $c->add(MlmDistributorPeer::TREE_UPLINE_DIST_ID, null, Criteria::ISNULL);
        $c->add(MlmDistributorPeer::PLACEMENT_TREE_STRUCTURE, null, Criteria::ISNULL);
        $totalRecords = MlmDistributorPeer::doCount($c);

        /******   total filtered records  *******/
        if ($this->getRequestParameter('filterFullname') != "") {
            $c->addAnd(MlmDistributorPeer::FULL_NAME, "%" . $this->getRequestParameter('filterFullname') . "%", Criteria::LIKE);
        }
        if ($this->getRequestParameter('filterNickname') != "") {
            $c->addAnd(MlmDistributorPeer::NICKNAME, "%" . $this->getRequestParameter('filterNickname') . "%", Criteria::LIKE);
        }
        $totalFilteredRecords = MlmDistributorPeer::doCount($c);

        /******   sorting  *******/
        for ($i = 0; $i < intval($this->getRequestParameter('iSortingCols')); $i++)
        {
            if ($this->getRequestParameter('bSortable_' . intval($this->getRequestParameter('iSortCol_' . $i))) == "true") {
                if ("asc" == $this->getRequestParameter('sSortDir_' . $i)) {
                    $c->addAscendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                } else {
                    $c->addDescendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                }
            }
        }

        /******   pagination  *******/
        $pager = new sfPropelPager('MlmDistributor', $limit);
        $pager->setCriteria($c);
        $pager->setPage(($offset / $limit) + 1);
        $pager->init();

        foreach ($pager->getResults() as $result) {
            $arr[] = array(
                $result->getDistributorId() == null ? "" : $result->getDistributorId(),
                $result->getDistributorId() == null ? "" : $result->getDistributorId(),
                $result->getCreatedOn() == null ? "" : $result->getActiveDatetime(),
                $result->getDistributorCode() == null ? "" : $result->getDistributorCode(),
                $result->getFullName() == null ? "" : $result->getFullName(),
                $result->getNickname() == null ? "" : $result->getNickname(),
                $result->getIc() == null ? "" : $result->getIc(),
                $result->getRankCode() == null ? "" : $result->getRankCode(),
            );
        }
        $output = array(
            "sEcho" => intval($sEcho),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalFilteredRecords,
            "aaData" => $arr
        );
        echo json_encode($output);

        return sfView::HEADER_ONLY;
    }

    public function executeTransferEcash()
    {
        $ledgerAccountBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ECASH);
        $this->ledgerAccountBalance = $ledgerAccountBalance;

        $processFee = 0;
        /*$c = new Criteria();
        $c->add(AppSettingPeer::SETTING_PARAMETER, Globals::SETTING_TRANSFER_PROCESS_FEE);
        $settingDB = AppSettingPeer::doSelectOne($c);
        if ($settingDB) {
            $processFee = $settingDB->getSettingValue();
        }*/
        $this->processFee = $processFee;

        if ($this->getRequestParameter('sponsorId') <> "" && $this->getRequestParameter('ecashAmount') > 0 && $this->getRequestParameter('transactionPassword') <> "") {
            $appUser = AppUserPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_USERID));

            if (($this->getRequestParameter('ecashAmount') + $processFee) > $ledgerAccountBalance) {

                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("In-sufficient MT4 Credit Amount"));

            } elseif (strtoupper($appUser->getUserPassword2()) <> strtoupper($this->getRequestParameter('transactionPassword'))) {

                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Security password"));

            } elseif (strtoupper($this->getRequestParameter('sponsorId')) == $this->getUser()->getAttribute(Globals::SESSION_USERNAME)) {

                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("You are not allow to transfer to own account."));

            } elseif ($this->getRequestParameter('sponsorId') <> "" && $this->getRequestParameter('ecashAmount') > 0) {

                $c = new Criteria();
                $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $this->getRequestParameter('sponsorId'));
                $existDist = MlmDistributorPeer::doSelectOne($c);

                $c = new Criteria();
                $c->add(MlmAccountPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_ECASH);
                $c->addAnd(MlmAccountPeer::DIST_ID, $existDist->getDistributorId());
                $toAccount = MlmAccountPeer::doSelectOne($c);

                $toId = $existDist->getDistributorId();
                $toCode = $existDist->getDistributorCode();
                $toName = $existDist->getNickname();
                $toBalance = $toAccount->getBalance();
                $fromId = $this->getUser()->getAttribute(Globals::SESSION_DISTID);
                $fromCode = $this->getUser()->getAttribute(Globals::SESSION_USERNAME);
                $fromName = $this->getUser()->getAttribute(Globals::SESSION_NICKNAME);
                $fromBalance = $ledgerAccountBalance;

                $mlm_account_ledger = new MlmAccountLedger();
                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                $mlm_account_ledger->setDistId($fromId);
                $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_TO);
                $mlm_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_TO . " " . $toCode . " (" . $toName . ")");
                $mlm_account_ledger->setCredit(0);
                $mlm_account_ledger->setDebit($this->getRequestParameter('ecashAmount'));
                $mlm_account_ledger->setBalance($fromBalance - $this->getRequestParameter('ecashAmount'));
                $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->save();

                $this->revalidateAccount($fromId, Globals::ACCOUNT_TYPE_ECASH);

                $tbl_account_ledger = new MlmAccountLedger();
                $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                $tbl_account_ledger->setDistId($toId);
                $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_FROM);
                $tbl_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_FROM . " " . $fromCode . " (" . $fromName . ")");
                $tbl_account_ledger->setCredit($this->getRequestParameter('ecashAmount'));
                $tbl_account_ledger->setDebit(0);
                $tbl_account_ledger->setBalance($toBalance + $this->getRequestParameter('ecashAmount'));
                $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->save();

                $this->revalidateAccount($toId, Globals::ACCOUNT_TYPE_ECASH);

                // ******       processing fees      ****************
                /*$tbl_account_ledger = new MlmAccountLedger();
                $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                $tbl_account_ledger->setDistId($fromId);
                $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_PROCESS_CHARGE);
                $tbl_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_TO . " " . $toCode . " (" . $toName . ") PROCESS CHARGES");
                $tbl_account_ledger->setCredit(0);
                $tbl_account_ledger->setDebit($processFee);
                $tbl_account_ledger->setBalance($fromBalance - ($this->getRequestParameter('ecashAmount') + $processFee));
                $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->save();

                $this->revalidateAccount($fromId, Globals::ACCOUNT_TYPE_ECASH);*/

                // ******       company account      ****************
                /*$c = new Criteria();
                $c->add(MlmAccountPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_ECASH);
                $c->addAnd(MlmAccountPeer::DIST_ID, Globals::SYSTEM_COMPANY_DIST_ID);
                $companyAccount = MlmAccountPeer::doSelectOne($c);

                $tbl_account_ledger = new MlmAccountLedger();
                $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                $tbl_account_ledger->setDistId(Globals::SYSTEM_COMPANY_DIST_ID);
                $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER);
                $tbl_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_PROCESS_CHARGE . " " . $fromCode . " -> " . $toCode);
                $tbl_account_ledger->setCredit($processFee);
                $tbl_account_ledger->setDebit(0);
                $tbl_account_ledger->setBalance($companyAccount->getBalance() + $processFee);
                $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->save();

                $this->revalidateAccount(Globals::SYSTEM_COMPANY_DIST_ID, Globals::ACCOUNT_TYPE_ECASH);*/

                $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Transfer success"));

                return $this->redirect('/member/transferEcash');
            }
        }
    }

    public function executeTransferEpoint()
    {
        $ledgerAccountBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);
        $this->ledgerAccountBalance = $ledgerAccountBalance;

        $processFee = 0;
        /*$c = new Criteria();
        $c->add(AppSettingPeer::SETTING_PARAMETER, Globals::SETTING_TRANSFER_PROCESS_FEE);
        $settingDB = AppSettingPeer::doSelectOne($c);
        if ($settingDB) {
            $processFee = $settingDB->getSettingValue();
        }*/
        $this->processFee = $processFee;

        if ($this->getRequestParameter('sponsorId') <> "" && $this->getRequestParameter('epointAmount') > 0 && $this->getRequestParameter('transactionPassword') <> "") {
            $appUser = AppUserPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_USERID));

            if (($this->getRequestParameter('epointAmount') + $processFee) > $ledgerAccountBalance) {

                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("In-sufficient CP1"));

            } elseif (strtoupper($appUser->getUserPassword2()) <> strtoupper($this->getRequestParameter('transactionPassword'))) {

                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Security password"));

            } elseif (strtoupper($this->getRequestParameter('sponsorId')) == $this->getUser()->getAttribute(Globals::SESSION_USERNAME)) {

                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("You are not allow to transfer to own account."));

            } elseif ($this->getRequestParameter('sponsorId') <> "" && $this->getRequestParameter('epointAmount') > 0) {

                $c = new Criteria();
                $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $this->getRequestParameter('sponsorId'));
                $existDist = MlmDistributorPeer::doSelectOne($c);

                $c = new Criteria();
                $c->add(MlmAccountPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_EPOINT);
                $c->addAnd(MlmAccountPeer::DIST_ID, $existDist->getDistributorId());
                $toAccount = MlmAccountPeer::doSelectOne($c);

                if (!$toAccount) {
                    $toAccount = new MlmAccount();

                    $toAccount->setDistId($existDist->getDistributorId());
                    $toAccount->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                    $toAccount->setBalance(0);
                    $toAccount->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $toAccount->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $toAccount->save();
                }

                $toId = $existDist->getDistributorId();
                $toCode = $existDist->getDistributorCode();
                $toName = $existDist->getNickname();
                $toBalance = $toAccount->getBalance();
                $fromId = $this->getUser()->getAttribute(Globals::SESSION_DISTID);
                $fromCode = $this->getUser()->getAttribute(Globals::SESSION_USERNAME);
                $fromName = $this->getUser()->getAttribute(Globals::SESSION_NICKNAME);
                $fromBalance = $ledgerAccountBalance;

                $mlm_account_ledger = new MlmAccountLedger();
                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                $mlm_account_ledger->setDistId($fromId);
                $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_TO);
                $mlm_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_TO . " " . $toCode . " (" . $toName . ")");
                $mlm_account_ledger->setCredit(0);
                $mlm_account_ledger->setDebit($this->getRequestParameter('epointAmount'));
                $mlm_account_ledger->setBalance($fromBalance - $this->getRequestParameter('epointAmount'));
                $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->save();

                $this->revalidateAccount($fromId, Globals::ACCOUNT_TYPE_EPOINT);

                $tbl_account_ledger = new MlmAccountLedger();
                $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                $tbl_account_ledger->setDistId($toId);
                $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_FROM);
                $tbl_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_FROM . " " . $fromCode . " (" . $fromName . ")");
                $tbl_account_ledger->setCredit($this->getRequestParameter('epointAmount'));
                $tbl_account_ledger->setDebit(0);
                $tbl_account_ledger->setBalance($toBalance + $this->getRequestParameter('epointAmount'));
                $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->save();

                $this->revalidateAccount($toId, Globals::ACCOUNT_TYPE_EPOINT);

                // ******       processing fees      ****************
                /*$tbl_account_ledger = new MlmAccountLedger();
                $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                $tbl_account_ledger->setDistId($fromId);
                $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_PROCESS_CHARGE);
                $tbl_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_TO . " " . $toCode . " (" . $toName . ") PROCESS CHARGES");
                $tbl_account_ledger->setCredit(0);
                $tbl_account_ledger->setDebit($processFee);
                $tbl_account_ledger->setBalance($fromBalance - ($this->getRequestParameter('ecashAmount') + $processFee));
                $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->save();

                $this->revalidateAccount($fromId, Globals::ACCOUNT_TYPE_ECASH);*/

                // ******       company account      ****************
                /*$c = new Criteria();
                $c->add(MlmAccountPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_EPOINT);
                $c->addAnd(MlmAccountPeer::DIST_ID, Globals::SYSTEM_COMPANY_DIST_ID);
                $companyAccount = MlmAccountPeer::doSelectOne($c);

                $tbl_account_ledger = new MlmAccountLedger();
                $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                $tbl_account_ledger->setDistId(Globals::SYSTEM_COMPANY_DIST_ID);
                $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER);
                $tbl_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_PROCESS_CHARGE . " " . $fromCode . " -> " . $toCode);
                $tbl_account_ledger->setCredit($processFee);
                $tbl_account_ledger->setDebit(0);
                $tbl_account_ledger->setBalance($companyAccount->getBalance() + $processFee);
                $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->save();

                $this->revalidateAccount(Globals::SYSTEM_COMPANY_DIST_ID, Globals::ACCOUNT_TYPE_EPOINT);*/

                $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Transfer success"));

                return $this->redirect('/member/transferEpoint');
            }
        }
    }

    public function executeEcashLog()
    {
    }
    public function executeEpointLog()
    {
    }
    public function executeMaintenanceLog()
    {
    }

    public function executeFetchAnnouncementById()
    {
        $arr = "";
        if ($this->getRequestParameter('announcementId') <> "") {
            $announcement = MlmAnnouncementPeer::retrieveByPk($this->getRequestParameter('announcementId'));

            if ($announcement) {
                $title = $announcement->getTitle();
                $content = $announcement->getContent();
                if ($this->getUser()->getCulture() == 'cn') {
                    $title = $announcement->getTitleCn();
                    $content = $announcement->getContentCn();
                }
                $arr = array(
                    'title' => $title,
                    'content' => $content
                );
            }
        }

        echo json_encode($arr);
        return sfView::HEADER_ONLY;
    }

    public function executeLoginPassword()
    {
        if ($this->getRequestParameter('oldPassword')) {
            $c = new Criteria();
            $c->add(AppUserPeer::USER_ID, $this->getUser()->getAttribute(Globals::SESSION_USERID));
            $c->add(AppUserPeer::USERPASSWORD, $this->getRequestParameter('oldPassword'));
            $exist = AppUserPeer::doSelectOne($c);

            if (!$exist) {
                $this->setFlash('errorMsg', "Old password is not valid.");
            } else {
                $exist->setUserpassword($this->getRequestParameter('newPassword'));
                $exist->setKeepPassword($this->getRequestParameter('newPassword'));
                $exist->save();
                $this->setFlash('successMsg', "Password updated");
            }
            //return $this->redirect('/member/loginPassword');
        }
        return $this->redirect('/member/viewProfile');
    }

    public function executeTransactionPassword()
    {
        if ($this->getRequestParameter('oldSecurityPassword')) {
            $c = new Criteria();
            $c->add(AppUserPeer::USER_ID, $this->getUser()->getAttribute(Globals::SESSION_USERID));
            $c->add(AppUserPeer::USERPASSWORD2, $this->getRequestParameter('oldSecurityPassword'));
            $exist = AppUserPeer::doSelectOne($c);

            if (!$exist) {
                $this->setFlash('errorMsg', "Old Security password is not valid.");
            } else {
                $exist->setUserpassword2($this->getRequestParameter('newSecurityPassword'));
                $exist->setKeepPassword2($this->getRequestParameter('newSecurityPassword'));
                $exist->save();
                $this->setFlash('successMsg', "Security Password updated");
            }
            //return $this->redirect('/member/transactionPassword');
        }
        return $this->redirect('/member/viewProfile');
    }

    public function executeAnnouncement()
    {
    }

    public function executeSponsorTree()
    {
        $id = $this->getUser()->getAttribute(Globals::SESSION_DISTID);
        $distinfo = MlmDistributorPeer::retrieveByPk($id);
        $this->distinfo = $distinfo;
        $this->hasChild = $this->checkHasChild($distinfo->getDistributorId());

        /*********************/
        /* Search Function
         * ********************/
        $fullName = $this->getRequestParameter('fullName');
        $arrTree = array();

        if ($fullName != "") {
            $c = new Criteria();
            $c->add(MlmDistributorPeer::FULL_NAME, $fullName);
            $c->addAnd(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
            $distinfo = MlmDistributorPeer::doSelectOne($c);

            if (!$distinfo) {
                $this->setFlash('errorMsg', "Username is not exist.");
                return $this->redirect('/member/sponsorTree');
            }

            $this->distinfo = $distinfo;
            $this->hasChild = $this->checkHasChild($distinfo->getDistributorId());
        }
        $this->headColor = $this->getRankColor($distinfo->getRankId());
        $this->arrTree = $arrTree;
        $this->fullName = $fullName;
    }
    public function executeSponsorTree_old()
    {
//        $id = $this->getUser()->getAttribute(Globals::SESSION_DISTID);
//        $distinfo = MlmDistributorPeer::retrieveByPk($id);
//        $this->distinfo = $distinfo;
//        $this->hasChild = $this->checkHasChild($distinfo->getDistributorId());

        /*######################################################################*/
        $id = $this->getUser()->getAttribute(Globals::SESSION_DISTID);
        $distinfo = MlmDistributorPeer::retrieveByPk($id);
        $this->doSearch = false;
        $this->distinfo = $distinfo;
        $this->hasChild = $this->checkHasChild($distinfo->getDistributorId());

        /*********************/
        /* Search Function
         * ********************/
        $fullName = $this->getRequestParameter('fullName');
        $arrTree = array();

        if ($fullName != "") {
            $this->doSearch = true;

            $c = new Criteria();
            $c->add(MlmDistributorPeer::FULL_NAME, $fullName);
            $c->addAnd(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
            $searchDist = MlmDistributorPeer::doSelectOne($c);

            if ($searchDist) {
                $parentId = $id;

                $searchDistArr = array();
                $arrs = explode("|", $searchDist->getTreeStructure());
                $idx = 0;
                for ($x = 0; $x < count($arrs); $x++) {
                    if ($arrs[$x] == "") {
                        continue;
                    }
                    $dist = $this->getDistributorInformation($arrs[$x]);
                    $searchDistArr[$idx]["code"] = $arrs[$x];
                    $searchDistArr[$idx]["hasChildren"] = $this->checkHasChild($dist->getDistributorId());
                    $searchDistArr[$idx]["text"] = "<span class='gen_id'>" . $dist->getDistributorCode() . "</span> <span class='gen_active'>" . $dist->getFullname() . "</span> Joined " . date('Y-m-d', strtotime($dist->getCreatedOn())) . " " . $dist->getRankCode();
                    $searchDistArr[$idx]["id"] = $dist->getDistributorId();

                    /************ sibling ************/
                    $c = new Criteria();
                    $c->add(MlmDistributorPeer::UPLINE_DIST_CODE, $dist->getUplineDistCode());
                    $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $arrs[$x], Criteria::NOT_EQUAL);
                    $siblingDists = MlmDistributorPeer::doSelect($c);
                    //var_dump(count($siblingDists));
                    $siblingDistArr = array();
                    $siblingIdx = 0;
                    foreach ($siblingDists as $siblingDist)
                    {
                        /*var_dump($siblingDist->getDistributorCode());
                        var_dump($arrs[$x]);
                        var_dump("<br>");*/
                        if ($arrs[$x] == $siblingDist->getDistributorCode())
                            continue;
                        $siblingDistArr[$siblingIdx]["code"] = $siblingDist->getDistributorCode();
                        $siblingDistArr[$siblingIdx]["hasChildren"] = $this->checkHasChild($siblingDist->getDistributorId());
                        $siblingDistArr[$siblingIdx]["text"] = "<span class='gen_id'>" . $siblingDist->getDistributorCode() . "</span> <span class='gen_active'>" . $siblingDist->getFullname() . "</span> Joined " . date('Y-m-d', strtotime($siblingDist->getCreatedOn())) . " " . $siblingDist->getRankCode();
                        $siblingDistArr[$siblingIdx]["id"] = $siblingDist->getDistributorId();

                        $siblingIdx++;
                    }
                    $searchDistArr[$idx]["sibling"] = $siblingDistArr;
                    $idx++;
                }

                $c = new Criteria();
                $c->add(MlmDistributorPeer::UPLINE_DIST_ID, $parentId);
                $c->addAnd(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
                $dists = MlmDistributorPeer::doSelect($c);

                $idx = 0;
                foreach ($dists as $dist)
                {
                    $arrTree[$idx]["text"] = "<span class='gen_id'>" . $dist->getDistributorCode() . "</span> <span class='gen_active'>" . $dist->getFullname() . "</span> Joined " . date('Y-m-d', strtotime($dist->getCreatedOn())) . " " . $dist->getRankCode();
                    // $arrTree[$idx]["text"] = "<span class='gen_img'><img src='http://www.eslfreedom.com/js/jqtree/images/node70.gif'></span><span class='gen_id'>Olga</span><span class='gen_active'>1300805</span>  <span class='gen_name'>Diamond - A</span><span class='gen_active'>Activated 01/01/1970</span> <span class='gen_jdate'>Joined 31/08/2011</span>";
                    $arrTree[$idx]["id"] = $dist->getDistributorId();
                    $arrTree[$idx]["code"] = $dist->getDistributorCode();
                    $arrTree[$idx]["hasChildren"] = $this->checkHasChild($dist->getDistributorId());
                    $idx++;
                }

                $this->searchDist = $searchDist;
                $this->searchDistArr = $searchDistArr;
            }
        }
        $this->arrTree = $arrTree;
        $this->fullName = $fullName;
        $this->colorArr = $this->getRankColorArr();
    }

    public function executeManipulateSponsorTree()
    {
        $parentId = $this->getRequestParameter('root');
        $arrTree = array();
        $html = "";
        if ($parentId != "") {
            $c = new Criteria();
            $c->add(MlmDistributorPeer::UPLINE_DIST_ID, $parentId);
            $c->addAnd(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
            $dists = MlmDistributorPeer::doSelect($c);

            $idx = 0;
            $count = count($dists);
            foreach ($dists as $dist)
            {
                $idx++;
                $hasChild = $this->checkHasChild($dist->getDistributorId());

                $treeLine = "tree-controller-lplus-line";
                $treeLine2 = "tree-controller-lplus-right";
                $treeLineNoChild = "tree-controller-t-line";
                $treeLineNoChild2 = "tree-controller-t-right";
                $treeControllerWrap = "tree-controller-wrap";
                $img = "<img class='tree-plus-button' src='/css/network/plus.png'>";
                if ($idx == $count) {
                    $treeLineNoChild = "tree-controller-l-line";
                    $treeLineNoChild2 = "tree-controller-l-right";
                    $treeControllerWrap = "tree-controller-l-wrap";
                }

                if ($hasChild) {
                } else {
                    $img = "";
                    $treeLine = $treeLineNoChild;
                    $treeLine2 = $treeLineNoChild2;
                }

                $headColor = $this->getRankColor($dist->getRankId());
                $html .= "<div class='".$treeControllerWrap."'>
                        <div class='controller-node-con'>
                            <div class='tree-controller ".$treeLine."'>
                                <div class='tree-controller-in ".$treeLine2."'>
                                    ".$img."
                                </div>
                            </div>
                            <div class='node-info-raw' id='node-id-".$dist->getDistributorId()."'>
                                <div class='node-info'>
                                    <span class='user-rank'><img
                                            src='/css/network/".$headColor."_head.png'></span>
                                    <span class='user-id'>".$dist->getDistributorCode()."</span>
                                    <span class='user-joined'>".$this->getContext()->getI18N()->__("Joined")." ".date('Y-m-d', strtotime($dist->getActiveDatetime()))."</span>
                                    <span class='user-joined'>".$this->getContext()->getI18N()->__($dist->getRankCode())."</span>
                                </div>
                            </div>
                        </div>";
                if ($hasChild) {
                    $html .= "<div id='node-wrapper-".$dist->getDistributorId()."' class='ajax-more'></div>";
                }
                $html .= "</div>";
            }
        }


        //echo json_encode($arrTree);
        echo $html;
        return sfView::HEADER_ONLY;
    }

    public function executeManipulateSponsorTree_old()
    {
        $parentId = $this->getRequestParameter('root');
        $arrTree = array();
        if ($parentId != "") {
            $c = new Criteria();
            $c->add(MlmDistributorPeer::UPLINE_DIST_ID, $parentId);
            $c->addAnd(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
            $dists = MlmDistributorPeer::doSelect($c);

            $idx = 0;
            $colorArr = $this->getRankColorArr();

            foreach ($dists as $dist)
            {
                $arrTree[$idx]["text"] = "<span class='user-rank'><img src='/css/maxim/tree/".$colorArr[$dist->getRankId()]."_head.png'></span><span class='user-id'>".$dist->getDistributorCode() . "</span><span class='user-joined'>" . $dist->getFullName() . "</span><span class='user-joined'> Joined " . date('Y-m-d', strtotime($dist->getActiveDatetime())). "</span><span class='user-joined'>" . $dist->getRankCode()."</span>";
                $arrTree[$idx]["id"] = $dist->getDistributorId();
                $arrTree[$idx]["hasChildren"] = $this->checkHasChild($dist->getDistributorId());
                $idx++;
            }
        }


        echo json_encode($arrTree);
        return sfView::HEADER_ONLY;
    }

    public function executeEcashWithdrawal()
    {
        $ledgerAccountBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ECASH);
        $this->ledgerAccountBalance = $ledgerAccountBalance;

        $withdrawAmount = $this->getRequestParameter('ecashAmount');
        $processFee = 0;
        //$processFee = $this->getRequestParameter('ecashAmount') * 5 / 100;

        if ($this->getRequestParameter('ecashAmount') > 0 && $this->getRequestParameter('transactionPassword') <> "") {
            $tbl_user = AppUserPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_USERID));

            if ($withdrawAmount > $ledgerAccountBalance) {
                $this->setFlash('errorMsg', "In-sufficient CP2");

            } elseif (strtoupper($tbl_user->getUserpassword2()) <> strtoupper($this->getRequestParameter('transactionPassword'))) {
                $this->setFlash('errorMsg', "Invalid Security password");

            } elseif ($withdrawAmount > 0) {
                $tbl_account_ledger = new MlmAccountLedger();
                $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                $tbl_account_ledger->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
                $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_WITHDRAWAL);
                $tbl_account_ledger->setCredit(0);
                $tbl_account_ledger->setDebit($this->getRequestParameter('ecashAmount'));
                $tbl_account_ledger->setBalance($ledgerAccountBalance - $this->getRequestParameter('ecashAmount'));
                $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->save();

                $this->revalidateAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ECASH);

                // ******       company account      ****************
                $companyEcashBalance = $this->getAccountBalance(Globals::SYSTEM_COMPANY_DIST_ID, Globals::ACCOUNT_TYPE_ECASH);

                $tbl_account_ledger = new MlmAccountLedger();
                $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                $tbl_account_ledger->setDistId(Globals::SYSTEM_COMPANY_DIST_ID);
                $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_WITHDRAWAL);
                $tbl_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_WITHDRAWAL . " " . $this->getUser()->getAttribute(Globals::SESSION_USERNAME));
                $tbl_account_ledger->setCredit($processFee);
                $tbl_account_ledger->setDebit(0);
                $tbl_account_ledger->setBalance($companyEcashBalance + $processFee);
                $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->save();

                $this->revalidateAccount(Globals::SYSTEM_COMPANY_DIST_ID, Globals::ACCOUNT_TYPE_ECASH);


                $tbl_ecash_withdraw = new MlmEcashWithdraw();
                $tbl_ecash_withdraw->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
                $tbl_ecash_withdraw->setDeduct($withdrawAmount);
                $tbl_ecash_withdraw->setAmount($withdrawAmount - $processFee);
                $tbl_ecash_withdraw->setStatusCode(Globals::WITHDRAWAL_PENDING);
                $tbl_ecash_withdraw->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_ecash_withdraw->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_ecash_withdraw->save();

                $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Your CP2 withdrawal has been submitted."));

                return $this->redirect('/member/ecashWithdrawal');
            }
        }
    }

    public function executeMt4Withdrawal()
    {
        //$usdToMyr = 3.4;
        $usdToMyr = 1;
        $handlingCharge = 4;
        $handlingChargeInUsd = 40;

        /*$c = new Criteria();
        $c->add(AppSettingPeer::SETTING_PARAMETER, Globals::SETTING_USD_TO_MYR);
        $settingDB = AppSettingPeer::doSelectOne($c);
        if ($settingDB) {
            $usdToMyr = $settingDB->getSettingValue();
        }*/
        $this->usdToMyr = $usdToMyr;

        $c = new Criteria();
        $c->add(AppSettingPeer::SETTING_PARAMETER, Globals::SETTING_MT4_HANDLING_FEE);
        $settingDB = AppSettingPeer::doSelectOne($c);
        if ($settingDB) {
            $handlingCharge = $settingDB->getSettingValue();
        }
        $this->handlingCharge = $handlingCharge;

        $c = new Criteria();
        $c->add(AppSettingPeer::SETTING_PARAMETER, Globals::SETTING_MT4_HANDLING_FEE_USD);
        $settingDB = AppSettingPeer::doSelectOne($c);
        if ($settingDB) {
            $handlingChargeInUsd = $settingDB->getSettingValue();
        }
        $this->handlingChargeInUsd = $handlingChargeInUsd;

        $distributorDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->distributorDB = $distributorDB;

        $c = new Criteria();
        $c->add(MlmDistMt4Peer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $distMt4DBs = MlmDistMt4Peer::doSelect($c);
        $this->distMt4DBs = $distMt4DBs;

        if ($this->getRequestParameter('mt4Amount') > 0 && $this->getRequestParameter('transactionPassword') <> "" && $this->getRequestParameter('paymentType') <> "") {
            $tbl_user = AppUserPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_USERID));

            if (strtoupper($tbl_user->getUserpassword2()) <> strtoupper($this->getRequestParameter('transactionPassword'))) {
                $this->setFlash('errorMsg', "Invalid Security password");

            } else if (!$this->getRequestParameter('mt4Id')) {
                $this->setFlash('errorMsg', "Invalid MT4 ID.");

            } else {
                $paymentType = $this->getRequestParameter('paymentType');
                $usdAmount = $this->getRequestParameter('mt4Amount');
                $mt4Id = $this->getRequestParameter('mt4Id');

                $mt4Withdraw = new MlmMt4Withdraw();
                $mt4Withdraw->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
                $mt4Withdraw->setMt4UserName($mt4Id);
                $mt4Withdraw->setStatusCode(Globals::WITHDRAWAL_PENDING);

                $minHandlingFee = 0;
                $myrAmount = 0;
                $handlingFee = 0;
                $currencyCode = "USD";
                $grandAmount = 0;

                /*if ($paymentType == "BANK") {
                    $currencyCode = "MYR";

                    $usdCurrency = $usdToMyr;
                    $minHandlingFee = $handlingChargeInUsd * $usdCurrency;
                    $myrAmount = $usdAmount * $usdCurrency;
                    $handlingFee = floor($myrAmount * $usdCurrency / 100);
                    if ($handlingFee < $minHandlingFee)
                        $handlingFee = $minHandlingFee;

                    $grandAmount = $myrAmount - $handlingFee;

                    $mt4Withdraw->setAmountRequested($myrAmount);
                    $mt4Withdraw->setRemarks("MT4 Fund :".$usdAmount);
                } elseif ($paymentType == "VISA") {*/
                    $currencyCode = "USD";

                    $minHandlingFee = floor($usdAmount * $handlingCharge / 100);
                    if ($minHandlingFee < $handlingChargeInUsd)
                        $handlingFee = $handlingChargeInUsd;
                    else
                        $handlingFee = $minHandlingFee;

                    $grandAmount = $usdAmount - $handlingFee;

                    $mt4Withdraw->setAmountRequested($usdAmount);
                //}

                $mt4Withdraw->setHandlingFee($handlingFee);
                $mt4Withdraw->setGrandAmount($grandAmount);
                $mt4Withdraw->setPaymentType($paymentType);
                $mt4Withdraw->setCurrencyCode($currencyCode);

                $mt4Withdraw->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mt4Withdraw->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mt4Withdraw->save();

                $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Your MT4 withdrawal has been submitted."));

                return $this->redirect('/member/mt4Withdrawal');
            }
        }
    }

    public function executeReloadTopup()
    {
        $usdToMyr = 3.4;
        $c = new Criteria();
        $c->add(AppSettingPeer::SETTING_PARAMETER, Globals::SETTING_USD_TO_MYR);
        $settingDB = AppSettingPeer::doSelectOne($c);
        if ($settingDB) {
            $usdToMyr = $settingDB->getSettingValue();
        }
        $this->usdToMyr = $usdToMyr;

        $ledgerEpointBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);
        $this->ledgerEpointBalance = $ledgerEpointBalance;

        $distributorDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->distributorDB = $distributorDB;

        $c = new Criteria();
        $c->add(MlmDistMt4Peer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $distMt4DBs = MlmDistMt4Peer::doSelect($c);
        $this->distMt4DBs = $distMt4DBs;

        $mt4Amount = $this->getRequestParameter('mt4Amount');
        //$pointNeeded = $this->getRequestParameter('mt4Amount') * $usdToMyr;
        $pointNeeded = $this->getRequestParameter('mt4Amount');
        $mt4UserName = $this->getRequestParameter('mt4UserName', "");

        $this->systemCurrency = $this->getAppSetting(Globals::SETTING_SYSTEM_CURRENCY);

        if ($mt4Amount > 0 && $this->getRequestParameter('transactionPassword') <> "") {
            $tbl_user = AppUserPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_USERID));

            if ($pointNeeded > $ledgerEpointBalance) {
                $this->setFlash('errorMsg', "In-sufficient CP1");

            } elseif (strtoupper($tbl_user->getUserpassword2()) <> strtoupper($this->getRequestParameter('transactionPassword'))) {
                $this->setFlash('errorMsg', "Invalid Security password");

            } elseif ($mt4UserName == "") {
                $this->setFlash('errorMsg', "Invalid MT4 ID.");

            } else {
                $tbl_account_ledger = new MlmAccountLedger();
                $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                $tbl_account_ledger->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
                $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_TOPUP_MT4);
                $tbl_account_ledger->setCredit(0);
                $tbl_account_ledger->setDebit($pointNeeded);
                $tbl_account_ledger->setBalance($ledgerEpointBalance - $pointNeeded);
                $tbl_account_ledger->setRemark("MT4 Fund :".$mt4Amount);
                //$tbl_account_ledger->setRemark("MT4 Fund :".$mt4Amount.", CONVERSION RATE :".$usdToMyr);
                $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->save();

                $this->revalidateAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);

                $mlmMt4ReloadFund = new MlmMt4ReloadFund();
                $mlmMt4ReloadFund->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
                $mlmMt4ReloadFund->setMt4UserName($mt4UserName);
                $mlmMt4ReloadFund->setAmount($this->getRequestParameter('mt4Amount'));
                $mlmMt4ReloadFund->setStatusCode(Globals::STATUS_PENDING);
                $mlmMt4ReloadFund->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlmMt4ReloadFund->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlmMt4ReloadFund->save();

                $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Your MT4 Fund Reload has been submitted."));

                return $this->redirect('/member/reloadTopup');
            }
        }
    }

    public function executeBdetails()
    {
        $this->bonus = $this->getRequestParameter('bonus');

        $c = new Criteria();
        $c->add(TblMemberCommPeer::F_DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $c->addAnd(TblMemberCommPeer::F_TYPE, $this->getRequestParameter('bonus'));

        $this->TblBonus = TblMemberCommPeer::doSelect($c);
    }

    public function executeBonusDetails()
    {
        $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->forward404Unless($distDB);

        $joinDate = $distDB->getActiveDatetime();

        $dsb = $this->getCommissionBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::COMMISSION_TYPE_DRB);
        $pipsBonus = $this->getCommissionBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::COMMISSION_TYPE_PIPS_BONUS);
        $creditRefunds = $this->getCommissionBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::COMMISSION_TYPE_CREDIT_REFUND);
        $fundManagements = $this->getCommissionBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::COMMISSION_TYPE_FUND_MANAGEMENT);
        $pairingBonus = $this->getCommissionBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::COMMISSION_TYPE_GDB);

        $this->dsb = number_format($dsb, 2);
        $this->pipsBonus = number_format($pipsBonus, 2);
        $this->creditRefund = number_format($creditRefunds, 2);
        $this->fundManagement = number_format($fundManagements, 2);
        $this->pairingBonus = number_format($pairingBonus, 2);

//        $this->total = number_format($dsb, 2);
        $this->total = number_format($dsb + $pipsBonus + $creditRefunds + $fundManagements + $pairingBonus, 2);

        /* *************************
         *  PIPS DETAIL
         * **************************/
        $currentMonth = date('m');
        $currentYear = date('Y');

        $anode = array();

        $idx = 0;
        if ($joinDate != null) {
            $joinMonth = date('m', strtotime($joinDate));
            $joinYear = date('Y', strtotime($joinDate));
            for ($x = intval($joinYear); $x <= intval($currentYear); $x++) {
                for ($i = intval($joinMonth); $i <= intval($currentMonth); $i++) {
                    $anode[$idx]["year"] = $x;
                    $anode[$idx]["month"] = $i;
                    $anode[$idx]["pips_bonus"] = $this->getPipsBonusDetailByMonth($distDB->getDistributorId(), $i, $x, null);
                    $anode[$idx]["credit_refund"] = $this->getCreditRefundDetailByMonth($distDB->getDistributorId(), $i, $x, null);
                    $anode[$idx]["fund_dividend"] = $this->getFundDividendDetailByMonth($distDB->getDistributorId(), $i, $x, null);
                    $anode[$idx]["rb_bonus"] = $this->getRbDetailByMonth($distDB->getDistributorId(), $i, $x);
                    $anode[$idx]["paring_bonus"] = $this->getPairingDetailByMonth($distDB->getDistributorId(), $i, $x);
                    $idx++;
                }
            }
        }
        $this->anode = $anode;
    }

    public function executeProfile()
    {
    }

    public function executeRegistration()
    {
    }

    public function executeVerifyNickName()
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::NICKNAME, $this->getRequestParameter('nickName'));
        $exist = MlmDistributorPeer::doSelectOne($c);

        if ($exist) {
            echo 'false';
        } else {
            echo 'true';
        }

        return sfView::HEADER_ONLY;
    }

    public function executeVerifyUserName()
    {
        $c = new Criteria();
        $c->add(AppUserPeer::USERNAME, $this->getRequestParameter('userName'));
        $exist = AppUserPeer::doSelectOne($c);

        if ($exist) {
            echo 'false';
        } else {
            echo 'true';
        }

        return sfView::HEADER_ONLY;
    }

    public function executeVerifyFullName()
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::FULL_NAME, $this->getRequestParameter('fullname'));
        $exist = MlmDistributorPeer::doSelectOne($c);

        if ($exist) {
            echo 'false';
        } else {
            echo 'true';
        }

        return sfView::HEADER_ONLY;
    }

    public function executeViewProfile()
    {
        $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->forward404Unless($distDB);

        $c = new Criteria();
        $c->add(MlmDistributorPeer::DISTRIBUTOR_ID, $distDB->getUplineDistId());
        $sponsor = MlmDistributorPeer::doSelectOne($c);
        if (!$sponsor) {
            $sponsor = new MlmDistributor();
        }

        $this->sponsor = $sponsor;
        $this->distDB = $distDB;
    }
    public function executeViewBankInformation()
    {
        $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->forward404Unless($distDB);

        $this->distDB = $distDB;
        $this->setTemplate('bankInformation');
    }

    public function executeDailyBonus()
    {
        $con = Propel::getConnection(MlmDailyBonusLogPeer::DATABASE_NAME);
        try {
            $con->begin();

            print_r("Start<br>");
            $c = new Criteria();
            $c->add(MlmDailyBonusLogPeer::BONUS_TYPE, Globals::DAILY_BONUS_LOG_TYPE_DAILY);
            $c->addDescendingOrderByColumn(MlmDailyBonusLogPeer::BONUS_DATE);
            $mlmDistPairingDBs = MlmDailyBonusLogPeer::doSelectOne($c);
            print_r("Fetch Daily Bonus Log<br>");

            $dateUtil = new DateUtil();
            $currentDate = $dateUtil->formatDate("Y-m-d", date("Y-m-d"));
            print_r("currentDate=".$currentDate."<br>");

            if ($mlmDistPairingDBs) {
                $bonusDate = $dateUtil->formatDate("Y-m-d", $mlmDistPairingDBs->getBonusDate());
                print_r("bonusDate=".$bonusDate."<br>");

                $level = 0;
                while ($level < 10) {
                    print_r("level start ".$level."<br><br>");
                    if ($bonusDate == $currentDate) {
                        print_r("break<br>");
                        break;
                    }

                    $c = new Criteria();
                    //$c->add(MlmDistPairingPeer::DIST_ID, 476);
                    $mlmDistPairingDBs = MlmDistPairingPeer::doSelect($c);
                    foreach ($mlmDistPairingDBs as $mlmDistPairingDB) {
                        $distId = $mlmDistPairingDB->getDistId();
                        //$flushLimit = $mlmDistPairingDB->getFlushLimit() - $this->getDsbAmount($distId, $bonusDate);
                        $flushLimit = $mlmDistPairingDB->getFlushLimit();
                        print_r("DistId ".$distId."<br>");

                        if ($mlmDistPairingDB->getLeftBalance() > 0 && $mlmDistPairingDB->getRightBalance() > 0) {
                            print_r("Start Calculate bonus:".$bonusDate."<br>");
                            // requery for paring ledger
                            $leftBalance = $this->findPairingLedgers($distId, Globals::PLACEMENT_LEFT, $bonusDate);
                            $rightBalance = $this->findPairingLedgers($distId, Globals::PLACEMENT_RIGHT, $bonusDate);
                            $minBalance = $leftBalance;
                            if ($rightBalance < $leftBalance) {
                                $minBalance = $rightBalance;
                            }
                            print_r("leftBalance ".$leftBalance."<br>");
                            print_r("rightBalance ".$rightBalance."<br>");
                            print_r("minBalance ".$minBalance."<br>");
                            if ($leftBalance > 0 && $rightBalance > 0) {
                                $this->updateDistPairingLeader($distId, Globals::PLACEMENT_LEFT, $minBalance);
                                $this->updateDistPairingLeader($distId, Globals::PLACEMENT_RIGHT, $minBalance);

                                // start paring bonus
                                $distributorDB = MlmDistributorPeer::retrieveByPK($distId);
                                $packageDB = MlmPackagePeer::retrieveByPK($distributorDB->getRankId());

                                $pairingPercentage = $packageDB->getPairingBonus();
                                $pairingBonusAmount = $minBalance * $pairingPercentage / 100;
                                print_r("pairingBonusAmount =".$pairingBonusAmount."<br>");
                                $flushAmount = 0;
                                if ($pairingBonusAmount > $flushLimit) {
                                    $flushAmount = $pairingBonusAmount - $flushLimit;
                                }

                                /******************************/
                                /*  Commission
                                /******************************/
                                $c = new Criteria();
                                $c->add(MlmDistCommissionPeer::DIST_ID, $distId);
                                $c->add(MlmDistCommissionPeer::COMMISSION_TYPE, Globals::COMMISSION_TYPE_GDB);
                                $sponsorDistCommissionDB = MlmDistCommissionPeer::doSelectOne($c);

                                $commissionBalance = 0;
                                if (!$sponsorDistCommissionDB) {
                                    $sponsorDistCommissionDB = new MlmDistCommission();
                                    $sponsorDistCommissionDB->setDistId($distId);
                                    $sponsorDistCommissionDB->setCommissionType(Globals::COMMISSION_TYPE_GDB);
                                    $sponsorDistCommissionDB->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                } else {
                                    $commissionBalance = $sponsorDistCommissionDB->getBalance();
                                }
                                $sponsorDistCommissionDB->setBalance($commissionBalance + $pairingBonusAmount);
                                $sponsorDistCommissionDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $sponsorDistCommissionDB->save();

                                $c = new Criteria();
                                $c->add(MlmDistCommissionLedgerPeer::DIST_ID, $distId);
                                $c->add(MlmDistCommissionLedgerPeer::COMMISSION_TYPE, Globals::COMMISSION_TYPE_GDB);
                                $c->addDescendingOrderByColumn(MlmDistCommissionLedgerPeer::CREATED_ON);
                                $sponsorDistCommissionLedgerDB = MlmDistCommissionLedgerPeer::doSelectOne($c);

                                $gdbBalance = 0;
                                if ($sponsorDistCommissionLedgerDB)
                                    $gdbBalance = $sponsorDistCommissionLedgerDB->getBalance();

                                /******************************/
                                /*  Account
                                /******************************/
                                $distAccountEcashBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_ECASH);

                                // pairing amount
                                $ecashBalance = $distAccountEcashBalance + $pairingBonusAmount;
                                $mlm_account_ledger = new MlmAccountLedger();
                                $mlm_account_ledger->setDistId($distId);
                                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                                $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_GDB);
                                $mlm_account_ledger->setRemark("GROUP PAIRING BONUS AMOUNT (" . $bonusDate . ")");
                                $mlm_account_ledger->setCredit($pairingBonusAmount);
                                $mlm_account_ledger->setDebit(0);
                                $mlm_account_ledger->setBalance($ecashBalance);
                                $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $mlm_account_ledger->save();

                                //commission
                                $commissionBalance = $gdbBalance + $pairingBonusAmount;
                                $sponsorDistCommissionledger = new MlmDistCommissionLedger();
                                $sponsorDistCommissionledger->setDistId($distId);
                                $sponsorDistCommissionledger->setCommissionType(Globals::COMMISSION_TYPE_GDB);
                                $sponsorDistCommissionledger->setTransactionType(Globals::COMMISSION_LEDGER_PAIRED);
                                $sponsorDistCommissionledger->setCredit($pairingBonusAmount);
                                $sponsorDistCommissionledger->setDebit(0);
                                $sponsorDistCommissionledger->setBalance($commissionBalance);
                                $sponsorDistCommissionledger->setStatusCode(Globals::STATUS_PENDING);
                                $sponsorDistCommissionledger->setRemark("GROUP PAIRING AMOUNT (" . $bonusDate . ")");
                                $sponsorDistCommissionledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $sponsorDistCommissionledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $sponsorDistCommissionledger->save();

                                // flush amount
                                if ($flushAmount != 0) {
                                    $ecashBalance = $ecashBalance - $flushAmount;
                                    $mlm_account_ledger = new MlmAccountLedger();
                                    $mlm_account_ledger->setDistId($distId);
                                    $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                                    $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_GDB);
                                    $mlm_account_ledger->setRemark("FLUSH " . $pairingBonusAmount . " (" . $bonusDate . ")");
                                    $mlm_account_ledger->setCredit(0);
                                    $mlm_account_ledger->setDebit($flushAmount);
                                    $mlm_account_ledger->setBalance($ecashBalance);
                                    $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $mlm_account_ledger->save();

                                    $commissionBalance = $commissionBalance - $flushAmount;
                                    $sponsorDistCommissionledger = new MlmDistCommissionLedger();
                                    $sponsorDistCommissionledger->setDistId($distId);
                                    $sponsorDistCommissionledger->setCommissionType(Globals::COMMISSION_TYPE_GDB);
                                    $sponsorDistCommissionledger->setTransactionType(Globals::COMMISSION_LEDGER_PAIRED);
                                    $sponsorDistCommissionledger->setCredit(0);
                                    $sponsorDistCommissionledger->setDebit($flushAmount);
                                    $sponsorDistCommissionledger->setBalance($commissionBalance);
                                    $sponsorDistCommissionledger->setStatusCode(Globals::STATUS_PENDING);
                                    $sponsorDistCommissionledger->setRemark("FLUSH " . $pairingBonusAmount . " (" . $bonusDate . ")");
                                    $sponsorDistCommissionledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $sponsorDistCommissionledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $sponsorDistCommissionledger->save();

                                    $pairingBonusAmount = $flushAmount;
                                }

                                $maintenanceBalance = $pairingBonusAmount * Globals::BONUS_MAINTENANCE_PERCENTAGE;
                                $ecashBalance = $ecashBalance - $maintenanceBalance;
                                $maintenanceEcashAccountLedger = new MlmAccountLedger();
                                $maintenanceEcashAccountLedger->setDistId($distId);
                                $maintenanceEcashAccountLedger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                                $maintenanceEcashAccountLedger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_MAINTENANCE);
                                $maintenanceEcashAccountLedger->setRemark("MAINTENANCE BALANCE (" . $bonusDate . ")");
                                $maintenanceEcashAccountLedger->setCredit(0);
                                $maintenanceEcashAccountLedger->setDebit($maintenanceBalance);
                                $maintenanceEcashAccountLedger->setBalance($ecashBalance);
                                $maintenanceEcashAccountLedger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $maintenanceEcashAccountLedger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $maintenanceEcashAccountLedger->save();

                                $this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_ECASH);

                                $commissionBalance = $commissionBalance - $maintenanceBalance;
                                $sponsorDistCommissionledger = new MlmDistCommissionLedger();
                                $sponsorDistCommissionledger->setDistId($distId);
                                $sponsorDistCommissionledger->setCommissionType(Globals::COMMISSION_TYPE_GDB);
                                $sponsorDistCommissionledger->setTransactionType(Globals::COMMISSION_LEDGER_PAIRED);
                                $sponsorDistCommissionledger->setCredit(0);
                                $sponsorDistCommissionledger->setDebit($maintenanceBalance);
                                $sponsorDistCommissionledger->setBalance($commissionBalance);
                                $sponsorDistCommissionledger->setRemark("MAINTENANCE BALANCE (" . $bonusDate . ")");
                                $sponsorDistCommissionledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $sponsorDistCommissionledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $sponsorDistCommissionledger->save();

                                $this->revalidateCommission($distId, Globals::COMMISSION_TYPE_GDB);
                                /******************************/
                                /*  Maintenance
                                /******************************/
                                /*$c = new Criteria();
                                $c->add(MlmAccountLedgerPeer::DIST_ID, $distId);
                                $c->add(MlmAccountLedgerPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_MAINTENANCE);
                                $c->addDescendingOrderByColumn(MlmAccountLedgerPeer::CREATED_ON);
                                $accountLedgerDB = MlmAccountLedgerPeer::doSelectOne($c);
                                $this->forward404Unless($accountLedgerDB);
                                $distAccountMaintenanceBalance = $accountLedgerDB->getBalance();*/
                                $distAccountMaintenanceBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_MAINTENANCE);

                                $maintenanceAccountLedger = new MlmAccountLedger();
                                $maintenanceAccountLedger->setDistId($distId);
                                $maintenanceAccountLedger->setAccountType(Globals::ACCOUNT_TYPE_MAINTENANCE);
                                $maintenanceAccountLedger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_GDB);
                                $maintenanceAccountLedger->setRemark("PAIRING BALANCE " . number_format($pairingBonusAmount, 2) . " (" . $bonusDate . ")");
                                $maintenanceAccountLedger->setCredit($maintenanceBalance);
                                $maintenanceAccountLedger->setDebit(0);
                                $maintenanceAccountLedger->setBalance($distAccountMaintenanceBalance + $maintenanceBalance);
                                $maintenanceAccountLedger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $maintenanceAccountLedger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $maintenanceAccountLedger->save();

                                $this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_MAINTENANCE);
                            }
                        }
                    }

                    $bonusDate = $dateUtil->formatDate("Y-m-d", $dateUtil->addDate($bonusDate, 1, 0, 0));
                    $mlm_daily_bonus_log = new MlmDailyBonusLog();
                    $mlm_daily_bonus_log->setAccessIp($this->getRequest()->getHttpHeader('addr','remote'));
                    $mlm_daily_bonus_log->setBonusType(Globals::DAILY_BONUS_LOG_TYPE_DAILY);
                    $mlm_daily_bonus_log->setBonusDate($bonusDate);
                    $mlm_daily_bonus_log->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_daily_bonus_log->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_daily_bonus_log->save();
                    $level++;
                }
            }
            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }
        print_r("Done");
        return sfView::HEADER_ONLY;
    }

    public function executeDownloadMt4()
    {
        $response = $this->getResponse();
        $response->clearHttpHeaders();
        $response->addCacheControlHttpHeader('Cache-control','must-revalidate, post-check=0, pre-check=0');
        $response->setContentType('application/exe');
        $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
        $response->setHttpHeader('Content-Disposition','attachment; filename=Maxim4Setup.exe', TRUE);
        $response->sendHttpHeaders();
        readfile(sfConfig::get('sf_upload_dir')."/Maxim4Setup.exe");
        return sfView::NONE;
    }

    public function executeConvertEcashToEpoint()
    {
        $ledgerAccountBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ECASH);
        $this->ledgerAccountBalance = $ledgerAccountBalance;

        $epointAmount = $this->getRequestParameter('epointAmount');

        if ($this->getRequestParameter('epointAmount') > 0 && $this->getRequestParameter('transactionPassword') <> "") {
            $tbl_user = AppUserPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_USERID));

            if ($epointAmount > $ledgerAccountBalance) {
                $this->setFlash('errorMsg', "In-sufficient CP2");

            } elseif (strtoupper($tbl_user->getUserpassword2()) <> strtoupper($this->getRequestParameter('transactionPassword'))) {
                $this->setFlash('errorMsg', "Invalid Security password");

            } elseif ($epointAmount > 0) {
                $ledgerEPointBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);

                $tbl_account_ledger = new MlmAccountLedger();
                $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                $tbl_account_ledger->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
                $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_CONVERT_EPOINT);
                $tbl_account_ledger->setCredit(0);
                $tbl_account_ledger->setDebit($epointAmount);
                $tbl_account_ledger->setBalance($ledgerAccountBalance - $epointAmount);
                $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->save();

                $tbl_account_ledger = new MlmAccountLedger();
                $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                $tbl_account_ledger->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
                $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_CONVERT);
                $tbl_account_ledger->setCredit($epointAmount);
                $tbl_account_ledger->setDebit(0);
                $tbl_account_ledger->setBalance($ledgerEPointBalance + $epointAmount);
                $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->save();

                $this->revalidateAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ECASH);
                $this->revalidateAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);

                $this->setFlash('successMsg', $this->getContext()->getI18N()->__("CP2 convert to CP1 successful."));

                return $this->redirect('/member/convertEcashToEpoint');
            }
        }
    }

    public function executePurchasePackage()
    {
        $pendingDistId = $this->getRequestParameter('p');

        $c = new Criteria();

        $c->add(MlmDistributorPeer::DISTRIBUTOR_ID, $pendingDistId);
        $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_PENDING);
        $pendingDistDB = MlmDistributorPeer::doSelectOne($c);
        $this->forward404Unless($pendingDistDB);

        $c = new Criteria();
        $packageDBs = MlmPackagePeer::doSelect($c);

        $this->systemCurrency = $this->getAppSetting(Globals::SETTING_SYSTEM_CURRENCY);
        $this->pointAvailable = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);
        $this->pendingDistDB = $pendingDistDB;
        $this->packageDBs = $packageDBs;
    }

    public function executePackageUpgrade()
    {
        //if ($this->getRequestParameter('packageTypeSelected') <> "" && $this->getRequestParameter('transactionPassword') <> "" && $this->getRequestParameter('topupPackageTypePaymentType') <> "") {
        if ($this->getRequestParameter('transactionPassword') <> "" && $this->getRequestParameter('pid') <> "") {
            $ledgerECashBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ECASH);
            $ledgerEPointBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);

            $distDB = null;
            $distId = null;
            if ($this->getRequestParameter('distCode') != "") {
                $c = new Criteria();
                $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $this->getRequestParameter('distCode'));
                $distDB = MlmDistributorPeer::doSelectOne($c);
            } else {
                $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            }
            $this->forward404Unless($distDB);
            $distId = $distDB->getDistributorId();

            $distPackage = MlmPackagePeer::retrieveByPK($distDB->getRankId());
            $currentPackageAmount = $distPackage->getPrice();

            $selectedPackage = MlmPackagePeer::retrieveByPK($this->getRequestParameter('pid'));

            $amountNeeded = 9999999;
            //$paymentType = $this->getRequestParameter('topupPackageTypePaymentType');
            $paymentType = "epoint";

            $tbl_user = AppUserPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_USERID));
            if ($paymentType == 'ecash') {
//                $amountNeeded = $selectedPackage->getPrice() - $currentPackageAmount;
                $amountNeeded = $selectedPackage->getPrice();
            } else if ($paymentType == "epoint") {
//                $amountNeeded = $selectedPackage->getPrice() -  $currentPackageAmount;
                $amountNeeded = $selectedPackage->getPrice();
            }
            if ($amountNeeded > $ledgerECashBalance && $paymentType == "ecash") {
                $this->setFlash('errorMsg', "In-sufficient MT4 Credit amount");

            } else if ($amountNeeded > $ledgerEPointBalance && $paymentType == "epoint") {
                $this->setFlash('errorMsg', "In-sufficient CP1 amount");

            } else if (strtoupper($tbl_user->getUserpassword2()) <> strtoupper($this->getRequestParameter('transactionPassword'))) {
                $this->setFlash('errorMsg', "Invalid Security password");

            } else {
                $tbl_account_ledger = new MlmAccountLedger();
                $tbl_account_ledger->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
                $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_PACKAGE_UPGRADE);
                $tbl_account_ledger->setCredit(0);

                if ($paymentType == "ecash") {
                    $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                    $tbl_account_ledger->setBalance($ledgerECashBalance - $amountNeeded);
                } elseif ($paymentType == "epoint") {
                    $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                    $tbl_account_ledger->setBalance($ledgerEPointBalance - $amountNeeded);
                }
                $tbl_account_ledger->setDebit($amountNeeded);
                $tbl_account_ledger->setRemark("PACKAGE UPGRADED FROM ".$distPackage->getPackageName()." => ".$selectedPackage->getPackageName());
                $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->save();

                if ($paymentType == "ecash") {
                    $this->revalidateAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ECASH);
                } elseif ($paymentType == "epoint") {
                    $this->revalidateAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);
                }

                // ******       company account      ****************
                $mlmPackageUpgradeHistory = new MlmPackageUpgradeHistory();
                $mlmPackageUpgradeHistory->setDistId($distId);
                $mlmPackageUpgradeHistory->setTransactionCode(Globals::ACCOUNT_LEDGER_ACTION_PACKAGE_UPGRADE);
                $mlmPackageUpgradeHistory->setAmount($amountNeeded);
                $mlmPackageUpgradeHistory->setPackageId($selectedPackage->getPackageId());
                $mlmPackageUpgradeHistory->setStatusCode(Globals::STATUS_ACTIVE);
                $mlmPackageUpgradeHistory->setRemarks("PACKAGE UPGRADED FROM ".$distPackage->getPackageName()." => ".$selectedPackage->getPackageName());
                $mlmPackageUpgradeHistory->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlmPackageUpgradeHistory->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlmPackageUpgradeHistory->save();

                $distDB->setRankId($selectedPackage->getPackageId());
                $distDB->setRankCode($selectedPackage->getPackageName());
                $distDB->save();

                /**************************************/
                /*  Direct REFERRAL Bonus For Upline
                /**************************************/
                $uplineDistId = $distDB->getUplineDistId();
                $uplineDistDB = MlmDistributorPeer::retrieveByPK($uplineDistId);
                if ($uplineDistDB) {
                    //if ($uplineDistDB->getIbRankId() != null) {
                    if ($uplineDistDB->getIsIb() == Globals::YES) {
                        $directSponsorPercentage = $uplineDistDB->getIbCommission() * 100;
                        $directSponsorBonusAmount = $directSponsorPercentage * $amountNeeded / 100;
                    } else {
                        $uplineDistPackage = MlmPackagePeer::retrieveByPK($uplineDistDB->getRankId());
                        $directSponsorPercentage = $uplineDistPackage->getCommission();
                        $directSponsorBonusAmount = $directSponsorPercentage * $amountNeeded / 100;
                    }
                    $totalBonusPayOut = $directSponsorPercentage;

                    /******************************/
                    /*  store Pairing points
                    /******************************/
                    $pairingPoint = $amountNeeded;
                    $uplinePosition = $distDB->getPlacementPosition();
                    if ($distDB->getTreeUplineDistId() != 0 && $distDB->getTreeUplineDistCode() != null) {
                        $level = 0;
                        $uplineDistDB = MlmDistributorPeer::retrieveByPk($distDB->getTreeUplineDistId());
                        $sponsoredDistributorCode = $distDB->getDistributorCode();
                        while ($level < 100) {
                            //var_dump($uplineDistDB->getUplineDistId());
                            //var_dump($uplineDistDB->getUplineDistCode());
                            //print_r("<br>");
                            $c = new Criteria();
                            $c->add(MlmDistPairingPeer::DIST_ID, $uplineDistDB->getDistributorId());
                            $sponsorDistPairingDB = MlmDistPairingPeer::doSelectOne($c);

                            $addToLeft = 0;
                            $addToRight = 0;
                            $leftBalance = 0;
                            $rightBalance = 0;
                            if (!$sponsorDistPairingDB) {
                                $sponsorDistPairingDB = new MlmDistPairing();
                                $sponsorDistPairingDB->setDistId($uplineDistDB->getDistributorId());

                                $packageDB = MlmPackagePeer::retrieveByPK($uplineDistDB->getRankId());
                                $this->forward404Unless($packageDB);

                                $sponsorDistPairingDB->setLeftBalance($leftBalance);
                                $sponsorDistPairingDB->setRightBalance($rightBalance);
                                $sponsorDistPairingDB->setFlushLimit($packageDB->getDailyMaxPairing());
                                $sponsorDistPairingDB->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            } else {
                                $leftBalance = $sponsorDistPairingDB->getLeftBalance();
                                $rightBalance = $sponsorDistPairingDB->getRightBalance();
                            }
                            $sponsorDistPairingDB->setLeftBalance($leftBalance + $addToLeft);
                            $sponsorDistPairingDB->setRightBalance($rightBalance + $addToRight);
                            $sponsorDistPairingDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistPairingDB->save();

                            $c = new Criteria();
                            $c->add(MlmDistPairingLedgerPeer::DIST_ID, $uplineDistDB->getDistributorId());
                            $c->add(MlmDistPairingLedgerPeer::LEFT_RIGHT, $uplinePosition);
                            $c->addDescendingOrderByColumn(MlmDistPairingLedgerPeer::CREATED_ON);
                            $sponsorDistPairingLedgerDB = MlmDistPairingLedgerPeer::doSelectOne($c);

                            $legBalance = 0;
                            if ($sponsorDistPairingLedgerDB) {
                                $legBalance = $sponsorDistPairingLedgerDB->getBalance();
                            }

                            $sponsorDistPairingledger = new MlmDistPairingLedger();
                            $sponsorDistPairingledger->setDistId($uplineDistDB->getDistributorId());
                            $sponsorDistPairingledger->setLeftRight($uplinePosition);
                            $sponsorDistPairingledger->setTransactionType(Globals::PAIRING_LEDGER_REGISTER);
                            $sponsorDistPairingledger->setCredit($pairingPoint);
                            $sponsorDistPairingledger->setDebit(0);
                            $sponsorDistPairingledger->setBalance($legBalance + $pairingPoint);
                            $sponsorDistPairingledger->setRemark("PAIRING POINT AMOUNT (" . $sponsoredDistributorCode . ")");
                            $sponsorDistPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistPairingledger->save();

                            $this->revalidatePairing($uplineDistDB->getDistributorId(), $uplinePosition);

                            if ($uplineDistDB->getTreeUplineDistId() == 0 || $uplineDistDB->getTreeUplineDistCode() == null) {
                                break;
                            }

                            $uplinePosition = $uplineDistDB->getPlacementPosition();
                            $uplineDistDB = MlmDistributorPeer::retrieveByPk($uplineDistDB->getTreeUplineDistId());
                            $level++;
                        }
                    }
                    /******************************/
                    /*  Direct Sponsor Bonus
                    /******************************/
                    $firstForDRB = true;
                    while ($totalBonusPayOut <= Globals::TOTAL_BONUS_PAYOUT) {
                        $distAccountEcashBalance = $this->getAccountBalance($uplineDistId, Globals::ACCOUNT_TYPE_ECASH);

                        $mlm_account_ledger = new MlmAccountLedger();
                        $mlm_account_ledger->setDistId($uplineDistId);
                        $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                        $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_DRB);
                        $mlm_account_ledger->setRemark("PACKAGE UPGRADE ".$directSponsorPercentage."% for " . $distDB->getDistributorCode() . " (" .$distPackage->getPackageName()." => ".$selectedPackage->getPackageName().")");
                        $mlm_account_ledger->setCredit($directSponsorBonusAmount);
                        $mlm_account_ledger->setDebit(0);
                        $mlm_account_ledger->setBalance($distAccountEcashBalance + $directSponsorBonusAmount);
                        $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_account_ledger->save();

                        $this->revalidateAccount($uplineDistId, Globals::ACCOUNT_TYPE_ECASH);

                        /******************************/
                        /*  Commission
                        /******************************/
                        $c = new Criteria();
                        $c->add(MlmDistCommissionPeer::DIST_ID, $uplineDistId);
                        $c->add(MlmDistCommissionPeer::COMMISSION_TYPE, Globals::COMMISSION_TYPE_DRB);
                        $sponsorDistCommissionDB = MlmDistCommissionPeer::doSelectOne($c);

                        $commissionBalance = 0;
                        if (!$sponsorDistCommissionDB) {
                            $sponsorDistCommissionDB = new MlmDistCommission();
                            $sponsorDistCommissionDB->setDistId($uplineDistId);
                            $sponsorDistCommissionDB->setCommissionType(Globals::COMMISSION_TYPE_DRB);
                            $sponsorDistCommissionDB->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        } else {
                            $commissionBalance = $sponsorDistCommissionDB->getBalance();
                        }
                        $sponsorDistCommissionDB->setBalance($commissionBalance + $directSponsorBonusAmount);
                        $sponsorDistCommissionDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $sponsorDistCommissionDB->save();

                        $c = new Criteria();
                        $c->add(MlmDistCommissionLedgerPeer::DIST_ID, $uplineDistId);
                        $c->add(MlmDistCommissionLedgerPeer::COMMISSION_TYPE, Globals::COMMISSION_TYPE_DRB);
                        $c->addDescendingOrderByColumn(MlmDistCommissionLedgerPeer::CREATED_ON);
                        $sponsorDistCommissionLedgerDB = MlmDistCommissionLedgerPeer::doSelectOne($c);

                        $dsbBalance = 0;
                        if ($sponsorDistCommissionLedgerDB)
                            $dsbBalance = $sponsorDistCommissionLedgerDB->getBalance();

                        $sponsorDistCommissionledger = new MlmDistCommissionLedger();
                        $sponsorDistCommissionledger->setDistId($uplineDistId);
                        $sponsorDistCommissionledger->setCommissionType(Globals::COMMISSION_TYPE_DRB);
                        $sponsorDistCommissionledger->setTransactionType(Globals::COMMISSION_LEDGER_UPGRADE);
                        $sponsorDistCommissionledger->setCredit($directSponsorBonusAmount);
                        $sponsorDistCommissionledger->setDebit(0);
                        $sponsorDistCommissionledger->setStatusCode(Globals::STATUS_PENDING);
                        $sponsorDistCommissionledger->setBalance($dsbBalance + $directSponsorBonusAmount);
                        //$sponsorDistCommissionledger->setRemark("PACKAGE UPGRADE BONUS AMOUNT ".$directSponsorPercentage."% (" . $distDB->getDistributorCode() . "-" . $distDB->getMt4UserName() . ")");
                        if ($firstForDRB == true) {
                            $sponsorDistCommissionledger->setRemark("DRB FOR PACKAGE UPGRADE ".$directSponsorPercentage."% (" .$distPackage->getPackageName()."=>".$selectedPackage->getPackageName().") for " . $distDB->getDistributorCode());
                            $firstForDRB = false;
                        } else {
                            $sponsorDistCommissionledger->setRemark("GRB FOR PACKAGE UPGRADE ".$directSponsorPercentage."% (" .$distPackage->getPackageName()."=>".$selectedPackage->getPackageName().") for " . $distDB->getDistributorCode());
                        }
                        $sponsorDistCommissionledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $sponsorDistCommissionledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $sponsorDistCommissionledger->save();

                        $this->revalidateCommission($uplineDistId, Globals::COMMISSION_TYPE_DRB);
                        //var_dump("==>1");
                        if ($totalBonusPayOut < Globals::TOTAL_BONUS_PAYOUT) {
                            //var_dump("==>2");
                            $checkCommission = true;
                            $uplineDistId = $uplineDistDB->getUplineDistId();

                            while ($checkCommission == true) {
                                //var_dump("==>3**".$uplineDistId);
                                if ($uplineDistId == null || $uplineDistId == 0) {
                                    $totalBonusPayOut = Globals::TOTAL_BONUS_PAYOUT;
                                    break;
                                }
                                $uplineDistDB = MlmDistributorPeer::retrieveByPK($uplineDistId);

                                //var_dump("==>3$$".$uplineDistId);
                                $this->forward404Unless($uplineDistDB);
                                //var_dump("==>4");
                                if ($uplineDistDB->getIsIb() == Globals::YES) {
                                    /*if ($uplineDistDB->getIbRankId() != null) {
                                        $uplineDistPackage = MlmIbPackagePeer::retrieveByPK($uplineDistDB->getIbRankId());
                                    } else {
                                        $uplineDistPackage = MlmPackagePeer::retrieveByPK($uplineDistDB->getRankId());
                                    }*/
                                    //$directSponsorPercentage = $uplineDistPackage->getCommission();
                                    $directSponsorPercentage = $uplineDistDB->getIbCommission() * 100;
                                    if ($directSponsorPercentage > $totalBonusPayOut) {
                                        //var_dump("==>6");
                                        $directSponsorPercentage = $directSponsorPercentage - $totalBonusPayOut;
                                        $totalBonusPayOut += $directSponsorPercentage;
                                        if ($totalBonusPayOut > Globals::TOTAL_BONUS_PAYOUT) {
                                            //var_dump("==>7");
                                            $directSponsorPercentage = $directSponsorPercentage - ($totalBonusPayOut - Globals::TOTAL_BONUS_PAYOUT);
                                        }
                                    } else {
                                        //var_dump("==>8");
                                        $uplineDistId = $uplineDistDB->getUplineDistId();
                                        continue;
                                    }
                                } else {
                                    $uplineDistId = $uplineDistDB->getUplineDistId();
                                    continue;
                                }
                                $directSponsorBonusAmount = $directSponsorPercentage * $amountNeeded / 100;
                                $checkCommission == false;
                                break;
                                //var_dump("==>9");
                            }
                        } else {
                            break;
                            //var_dump("==>^^");
                        }
                    }
                }


                $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Package upgraded successful."));

                return $this->redirect('/member/packageUpgrade');
            }
        } else {
            $c = new Criteria();
            $c->addAscendingOrderByColumn(MlmPackagePeer::PRICE);
            $packageDBs = MlmPackagePeer::doSelect($c);

            $c = new Criteria();
            $c->addDescendingOrderByColumn(MlmPackagePeer::PRICE);
            $highestPackageDB = MlmPackagePeer::doSelectOne($c);

            $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            $this->forward404Unless($distDB);

            $distPackage = MlmPackagePeer::retrieveByPK($distDB->getRankId());

            $this->systemCurrency = $this->getAppSetting(Globals::SETTING_SYSTEM_CURRENCY);
            $this->pointAvailable = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);
            $this->packageDBs = $packageDBs;
            $this->distPackage = $distPackage;
            $this->distDB = $distDB;
            $this->highestPackageDB = $highestPackageDB;
        }
    }

    /************************************************************************************************************************
     * function
     ************************************************************************************************************************/
    function getDistributorIdByCode($sponsorCode)
    {
        $userId = 0;

        $c = new Criteria();
        $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $sponsorCode);
        $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        $existUser = MlmDistributorPeer::doSelectOne($c);

        if ($existUser) {
            $userId = $existUser->getDistributorId();
        }

        return $userId;
    }

    function revalidateAccount($distributorId, $accountType)
    {
        $balance = $this->getAccountBalance($distributorId, $accountType);

        $c = new Criteria();
        $c->add(MlmAccountPeer::ACCOUNT_TYPE, $accountType);
        $c->add(MlmAccountPeer::DIST_ID, $distributorId);
        $tbl_account = MlmAccountPeer::doSelectOne($c);

        if (!$tbl_account) {
            $tbl_account = new MlmAccount();
            $tbl_account->setDistId($distributorId);
            $tbl_account->setAccountType($accountType);
        }

        $tbl_account->setBalance($balance);
        $tbl_account->save();
    }

    function revalidateCommission($distributorId, $commissionType)
    {
        $balance = $this->getCommissionBalance($distributorId, $commissionType);

        $c = new Criteria();
        $c->add(MlmDistCommissionPeer::COMMISSION_TYPE, $commissionType);
        $c->add(MlmDistCommissionPeer::DIST_ID, $distributorId);
        $tbl_account = MlmDistCommissionPeer::doSelectOne($c);

        if (!$tbl_account) {
            $tbl_account = new MlmDistCommission();
            $tbl_account->setDistId($distributorId);
            $tbl_account->setCommissionType($commissionType);
        }

        $tbl_account->setBalance($balance);
        $tbl_account->save();
    }

    function getCommissionBalance($distributorId, $commissionType)
    {
        $query = "SELECT SUM(credit-debit) AS SUB_TOTAL FROM mlm_dist_commission_ledger WHERE dist_id = " . $distributorId . " AND commission_type = '" . $commissionType . "'";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        if ($resultset->next()) {
            $arr = $resultset->getRow();
            if ($arr["SUB_TOTAL"] != null) {
                return $arr["SUB_TOTAL"];
            } else {
                return 0;
            }
        }
        return 0;
    }

    function revalidatePairing($distributorId, $leftRight)
    {
        $balance = $this->getPairingBalance($distributorId, $leftRight);

        $c = new Criteria();
        $c->add(MlmDistPairingPeer::DIST_ID, $distributorId);
        $tbl_account = MlmDistPairingPeer::doSelectOne($c);

        if (!$tbl_account) {
            $tbl_account = new MlmDistPairing();
            $tbl_account->setDistId($distributorId);
            $tbl_account->setLeftBalance(0);
            $tbl_account->setRightBalance(0);
        }
        if (Globals::PLACEMENT_LEFT == $leftRight) {
            $tbl_account->setLeftBalance($balance);
        } else if (Globals::PLACEMENT_RIGHT == $leftRight) {
            $tbl_account->setRightBalance($balance);
        }

        $tbl_account->save();
    }

    function getPairingBalance($distributorId, $leftRight)
    {
        $query = "SELECT SUM(credit-debit) AS SUB_TOTAL FROM mlm_dist_pairing_ledger WHERE dist_id = " . $distributorId . " AND left_right = '" . $leftRight . "'";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        $count = 0;
        if ($resultset->next()) {
            $arr = $resultset->getRow();
            if ($arr["SUB_TOTAL"] != null) {
                return $arr["SUB_TOTAL"];
            } else {
                return 0;
            }
        }
        return 0;
    }

    function getAccountBalance($distributorId, $accountType)
    {
        $query = "SELECT SUM(credit-debit) AS SUB_TOTAL FROM mlm_account_ledger WHERE dist_id = " . $distributorId . " AND account_type = '" . $accountType . "'";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        if ($resultset->next()) {
            $arr = $resultset->getRow();
            if ($arr["SUB_TOTAL"] != null) {
                return $arr["SUB_TOTAL"];
            } else {
                return 0;
            }
        }
        return 0;
    }

    function format2decimal($d)
    {
        return ceil($d * 100) / 100;
    }

    function checkHasChild($distId)
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::UPLINE_DIST_ID, $distId);
        $c->addAnd(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        $list = MlmDistributorPeer::doSelect($c);
        if ($list) {
            return true;
        }
        return false;
    }

    function doActivateAccount($uplineDistId, $sponsorId, $packageId, $paymentType)
    {
        $packageDB = MlmPackagePeer::retrieveByPK($packageId);
        $this->forward404Unless($packageDB);
        $packageAmount = $packageDB->getPrice();

        /* ****************************************************
         * get distributor last account ledger epoint balance
         * ***************************************************/
        $c = new Criteria();
        $c->add(MlmAccountLedgerPeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        if ("epoint" == $paymentType) {
            $c->add(MlmAccountLedgerPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_EPOINT);
        } else if ("ecash" == $paymentType) {
            $c->add(MlmAccountLedgerPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_ECASH);
        }
        $c->addDescendingOrderByColumn(MlmAccountLedgerPeer::CREATED_ON);
        $accountLedgerDB = MlmAccountLedgerPeer::doSelectOne($c);
        if (!$accountLedgerDB) {
            $accountLedgerDB = new MlmAccountLedger();
            $accountLedgerDB->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            $accountLedgerDB->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
            $accountLedgerDB->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_REGISTER);
            $accountLedgerDB->setRemark("");
            $accountLedgerDB->setCredit(0);
            $accountLedgerDB->setDebit(0);
            $accountLedgerDB->setBalance(0);
            $accountLedgerDB->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $accountLedgerDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $accountLedgerDB->save();
        }

        $sponsorAccountBalance = $accountLedgerDB->getBalance();

        /* ****************************************************
         * get sponsored distributor and user
         * ***************************************************/
        $c = new Criteria();
        $c->add(MlmDistributorPeer::DISTRIBUTOR_ID, $sponsorId);
        $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_PENDING);
        $sponsoredDistDB = MlmDistributorPeer::doSelectOne($c);
        $this->forward404Unless($sponsoredDistDB);

        $userDB = AppUserPeer::retrieveByPK($sponsoredDistDB->getUserId());
        $this->forward404Unless($userDB);

        /* ****************************************************
         * update sponsored distributor and user
         * ***************************************************/
        $sponsoredDistDB->setRankId($packageDB->getPackageId());
        $sponsoredDistDB->setRankCode($packageDB->getPackageName());
        $sponsoredDistDB->setInitRankId($packageDB->getPackageId());
        $sponsoredDistDB->setInitRankCode($packageDB->getPackageName());
        $sponsoredDistDB->setStatusCode(Globals::STATUS_ACTIVE);
        $sponsoredDistDB->setPackagePurchaseFlag("Y");
        $sponsoredDistDB->setActiveDatetime(date("Y/m/d h:i:s A"));
        $sponsoredDistDB->setActivatedBy($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $sponsoredDistDB->save();

        $userDB->setStatusCode(Globals::STATUS_ACTIVE);
        $userDB->save();

        /**************************************/
        /*  Direct REFERRAL Bonus For Upline
        /**************************************/
        $uplineDistDB = MlmDistributorPeer::retrieveByPK($uplineDistId);
        if ($uplineDistDB) {
            //if ($uplineDistDB->getIbRankId() != null) {
            if ($uplineDistDB->getIsIb() == Globals::YES) {
                $directSponsorPercentage = $uplineDistDB->getIbCommission() * 100;
                $directSponsorBonusAmount = $directSponsorPercentage * $packageDB->getPrice() / 100;
            } else {
                $uplineDistPackage = MlmPackagePeer::retrieveByPK($uplineDistDB->getRankId());
                $directSponsorPercentage = $uplineDistPackage->getCommission();
                $directSponsorBonusAmount = $directSponsorPercentage * $packageDB->getPrice() / 100;
            }
            $totalBonusPayOut = $directSponsorPercentage;

            $this->doSaveAccount($sponsorId, Globals::ACCOUNT_TYPE_ECASH, 0, 0, Globals::ACCOUNT_LEDGER_ACTION_REGISTER, "");
            $this->doSaveAccount($sponsorId, Globals::ACCOUNT_TYPE_EPOINT, 0, 0, Globals::ACCOUNT_LEDGER_ACTION_REGISTER, "");
            /* ****************************************************
           * Update upline distributor account
           * ***************************************************/
            $sponsorAccountBalance = $sponsorAccountBalance - $packageDB->getPrice();

            $mlm_account_ledger = new MlmAccountLedger();
            $mlm_account_ledger->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            if ("epoint" == $paymentType) {
                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
            } else if ("ecash" == $paymentType) {
                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
            }
            $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_REGISTER);
            $mlm_account_ledger->setRemark("PACKAGE PURCHASE (".$packageDB->getPackageName().")");
            $mlm_account_ledger->setCredit(0);
            $mlm_account_ledger->setDebit($packageDB->getPrice());
            $mlm_account_ledger->setBalance($sponsorAccountBalance);
            $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->save();

            if ("epoint" == $paymentType) {
                $this->revalidateAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);
            } else if ("ecash" == $paymentType) {
                $this->revalidateAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ECASH);
            }

            /******************************/
            /*  Direct Sponsor Bonus
            /******************************/
            $firstForDRB = true;
            while ($totalBonusPayOut <= Globals::TOTAL_BONUS_PAYOUT) {
                $distAccountEcashBalance = $this->getAccountBalance($uplineDistId, Globals::ACCOUNT_TYPE_ECASH);

                $mlm_account_ledger = new MlmAccountLedger();
                $mlm_account_ledger->setDistId($uplineDistId);
                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_DRB);
                $mlm_account_ledger->setRemark("PACKAGE PURCHASE (".$packageDB->getPackageName().") ".$directSponsorPercentage."% (" . $sponsoredDistDB->getDistributorCode() . ")");
                $mlm_account_ledger->setCredit($directSponsorBonusAmount);
                $mlm_account_ledger->setDebit(0);
                $mlm_account_ledger->setBalance($distAccountEcashBalance + $directSponsorBonusAmount);
                $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->save();

                $this->revalidateAccount($uplineDistId, Globals::ACCOUNT_TYPE_ECASH);

                /******************************/
                /*  Commission
                /******************************/
                $c = new Criteria();
                $c->add(MlmDistCommissionPeer::DIST_ID, $uplineDistId);
                $c->add(MlmDistCommissionPeer::COMMISSION_TYPE, Globals::COMMISSION_TYPE_DRB);
                $sponsorDistCommissionDB = MlmDistCommissionPeer::doSelectOne($c);

                $commissionBalance = 0;
                if (!$sponsorDistCommissionDB) {
                    $sponsorDistCommissionDB = new MlmDistCommission();
                    $sponsorDistCommissionDB->setDistId($uplineDistId);
                    $sponsorDistCommissionDB->setCommissionType(Globals::COMMISSION_TYPE_DRB);
                    $sponsorDistCommissionDB->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                } else {
                    $commissionBalance = $sponsorDistCommissionDB->getBalance();
                }
                $sponsorDistCommissionDB->setBalance($commissionBalance + $directSponsorBonusAmount);
                $sponsorDistCommissionDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $sponsorDistCommissionDB->save();

                $c = new Criteria();
                $c->add(MlmDistCommissionLedgerPeer::DIST_ID, $uplineDistId);
                $c->add(MlmDistCommissionLedgerPeer::COMMISSION_TYPE, Globals::COMMISSION_TYPE_DRB);
                $c->addDescendingOrderByColumn(MlmDistCommissionLedgerPeer::CREATED_ON);
                $sponsorDistCommissionLedgerDB = MlmDistCommissionLedgerPeer::doSelectOne($c);

                $dsbBalance = 0;
                if ($sponsorDistCommissionLedgerDB)
                    $dsbBalance = $sponsorDistCommissionLedgerDB->getBalance();

                $sponsorDistCommissionledger = new MlmDistCommissionLedger();
                $sponsorDistCommissionledger->setDistId($uplineDistId);
                $sponsorDistCommissionledger->setCommissionType(Globals::COMMISSION_TYPE_DRB);
                $sponsorDistCommissionledger->setTransactionType(Globals::COMMISSION_LEDGER_REGISTER);
                $sponsorDistCommissionledger->setCredit($directSponsorBonusAmount);
                $sponsorDistCommissionledger->setDebit(0);
                $sponsorDistCommissionledger->setStatusCode(Globals::STATUS_PENDING);
                $sponsorDistCommissionledger->setBalance($dsbBalance + $directSponsorBonusAmount);
                if ($firstForDRB == true) {
                    $sponsorDistCommissionledger->setRemark("DRB FOR PACKAGE PURCHASE ".$directSponsorPercentage."% (".$packageDB->getPackageName().") for ".$sponsoredDistDB->getDistributorCode());
                    $firstForDRB = false;
                } else {
                    $sponsorDistCommissionledger->setRemark("GRB FOR PACKAGE PURCHASE ".$directSponsorPercentage."% (".$packageDB->getPackageName().") for ".$sponsoredDistDB->getDistributorCode());
                }
                $sponsorDistCommissionledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $sponsorDistCommissionledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $sponsorDistCommissionledger->save();

                $this->revalidateCommission($uplineDistId, Globals::COMMISSION_TYPE_DRB);
                //var_dump("==>1");
                if ($totalBonusPayOut < Globals::TOTAL_BONUS_PAYOUT) {
                    //var_dump("==>2");
                    $checkCommission = true;
                    $uplineDistId = $uplineDistDB->getUplineDistId();
                    while ($checkCommission == true) {
                        //var_dump("==>3**".$uplineDistId);
                        $uplineDistDB = MlmDistributorPeer::retrieveByPK($uplineDistId);

                        //var_dump("==>3$$".$uplineDistId);
                        $this->forward404Unless($uplineDistDB);

                        if ($uplineDistDB->getIsIb() == Globals::YES) {
                            /*if ($uplineDistDB->getIbRankId() != null) {
                                $uplineDistPackage = MlmIbPackagePeer::retrieveByPK($uplineDistDB->getIbRankId());
                            } else {
                                $uplineDistPackage = MlmPackagePeer::retrieveByPK($uplineDistDB->getRankId());
                            }*/
                            $directSponsorPercentage = $uplineDistDB->getIbCommission() * 100;

                            if ($directSponsorPercentage > $totalBonusPayOut) {
                                //var_dump("==>6");
                                $directSponsorPercentage = $directSponsorPercentage - $totalBonusPayOut;
                                $totalBonusPayOut += $directSponsorPercentage;
                                if ($totalBonusPayOut > Globals::TOTAL_BONUS_PAYOUT) {
                                    //var_dump("==>7");
                                    $directSponsorPercentage = $directSponsorPercentage - ($totalBonusPayOut - Globals::TOTAL_BONUS_PAYOUT);
                                }
                            } else {
                                //var_dump("==>8");
                                $uplineDistId = $uplineDistDB->getUplineDistId();
                                continue;
                            }
                        } else {
                            $uplineDistId = $uplineDistDB->getUplineDistId();
                            continue;
                        }
                        $directSponsorBonusAmount = $directSponsorPercentage * $packageDB->getPrice() / 100;
                        $checkCommission == false;
                        break;
                        //var_dump("==>9");
                    }
                } else {
                    break;
                    //var_dump("==>^^");
                }
            }
        }

    }

    function getAppSetting($parameter)
    {
        $result = "";
        $c = new Criteria();
        $c->add(AppSettingPeer::SETTING_PARAMETER, $parameter);
        $settingDB = AppSettingPeer::doSelectOne($c);
        if ($settingDB) {
            $result = $settingDB->getSettingValue();
        }
        return $result;
    }

    function doSaveAccount($distId, $accountType, $credit, $debit, $transactionType, $remarks)
    {
        $c = new Criteria();
        $c->add(MlmAccountPeer::ACCOUNT_TYPE, $accountType);
        $c->add(MlmAccountPeer::DIST_ID, $distId);
        $mlm_account = MlmAccountPeer::doSelectOne($c);

        if (!$mlm_account) {
            $mlm_account = new MlmAccount();

            $mlm_account->setDistId($distId);
            $mlm_account->setAccountType($accountType);
            $mlm_account->setBalance($credit - $debit);
            $mlm_account->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account->save();

            $mlm_account_ledger = new MlmAccountLedger();
            $mlm_account_ledger->setDistId($distId);
            $mlm_account_ledger->setAccountType($accountType);
            $mlm_account_ledger->setTransactionType($transactionType);
            $mlm_account_ledger->setRemark($remarks);
            $mlm_account_ledger->setCredit($credit);
            $mlm_account_ledger->setDebit($debit);
            $mlm_account_ledger->setBalance($credit - $debit);
            $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->save();
        }
    }

    function getDistributorInformation($distCode)
    {
        $c = new Criteria();

        $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $distCode);
        $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        $distDB = MlmDistributorPeer::doSelectOne($c);
        $this->forward404Unless($distDB);

        return $distDB;
    }

    function getPlacementDistributorInformation($uplineDistId, $placeLocation)
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::TREE_UPLINE_DIST_ID, $uplineDistId);
        $c->add(MlmDistributorPeer::PLACEMENT_POSITION, $placeLocation);
        $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);

        $placeDB = MlmDistributorPeer::doSelectOne($c);
        return $placeDB;
    }

    function getTotalPosition($distCode, $position)
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::PLACEMENT_POSITION, $position);
        $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $distCode, Criteria::NOT_EQUAL);
        $c->add(MlmDistributorPeer::PLACEMENT_TREE_STRUCTURE, "%|" . $distCode . "|%", Criteria::LIKE);
        $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);

        $totalDis = MlmDistributorPeer::doCount($c);
        return $totalDis;
    }

    function queryDistPairing($distributorId)
    {
        $c = new Criteria();
        $c->add(MlmDistPairingPeer::DIST_ID, $distributorId);
        $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        $mlmDist = MlmDistPairingPeer::doSelectOne($c);
        if (!$mlmDist) {
            $distDB = MlmDistributorPeer::retrieveByPK($distributorId);
            $distPairingDB = new MlmDistPairing();
            $distPairingDB->setDistId($distributorId);

            $packageDB = MlmPackagePeer::retrieveByPK($distDB->getRankId());
            $this->forward404Unless($packageDB);

            $distPairingDB->setLeftBalance(0);
            $distPairingDB->setRightBalance(0);
            $distPairingDB->setFlushLimit($packageDB->getDailyMaxPairing());
            $distPairingDB->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $distPairingDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $distPairingDB->save();
            return $distPairingDB;
        }
        return $mlmDist;
    }

    function getThisMonthSales($distributorId, $position)
    {
        $dateUtil = new DateUtil();

        $d = $dateUtil->getMonth();
        $firstOfMonth = date('Y-m-j', $d["first_of_month"]) . " 00:00:00";
        $lastOfMonth = date('Y-m-j', $d["last_of_month"]) . " 23:59:59";

        $query = "SELECT SUM(credit-debit) AS SUB_TOTAL FROM mlm_dist_pairing_ledger WHERE dist_id = " . $distributorId
                 . " AND left_right = '" . $position . "'"
                 . " AND transaction_type = '" . Globals::PAIRING_LEDGER_REGISTER . "'"
                 . " AND created_on >= '" . $firstOfMonth . "' AND created_on <= '" . $lastOfMonth . "'";

        //var_dump($query);
        //exit();
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        if ($resultset->next()) {
            $arr = $resultset->getRow();
            if ($arr["SUB_TOTAL"] != null) {
                return $arr["SUB_TOTAL"];
            } else {
                return 0;
            }
        }
        return 0;
    }

    function findPairingLedgers($distributorId, $position, $date)
    {
        $query = "SELECT SUM(credit-debit) AS SUB_TOTAL FROM mlm_dist_pairing_ledger WHERE dist_id = " . $distributorId
                 . " AND left_right = '" . $position . "'";

        if ($date != null) {
            $query .= " AND created_on <= '" . $date . " 23:59:59'";
        }
        //var_dump($query);
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        if ($resultset->next()) {
            $arr = $resultset->getRow();
            if ($arr["SUB_TOTAL"] != null) {
                return $arr["SUB_TOTAL"];
            } else {
                return 0;
            }
        }
        return 0;
    }

    function getDsbAmount($distributorId, $date)
    {
        $query = "SELECT SUM(credit) AS SUB_TOTAL FROM mlm_dist_commission_ledger WHERE dist_id = " . $distributorId
                 . " AND commission_type = '" . Globals::ACCOUNT_LEDGER_ACTION_DRB . "'";

        $query .= " AND created_on >= '" . $date . " 00:00:00'";
        $query .= " AND created_on <= '" . $date . " 23:59:59'";

        //var_dump($query);
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        if ($resultset->next()) {
            $arr = $resultset->getRow();
            if ($arr["SUB_TOTAL"] != null) {
                return $arr["SUB_TOTAL"];
            } else {
                return 0;
            }
        }
        return 0;
    }

    function updateDistPairingLeader($distId, $position, $debit, $remark="PAIRED", $transactionType=Globals::PAIRING_LEDGER_PAIRED)
    {
        $c = new Criteria();
        $c->add(MlmDistPairingLedgerPeer::DIST_ID, $distId);
        $c->add(MlmDistPairingLedgerPeer::LEFT_RIGHT, $position);
        $c->addDescendingOrderByColumn(MlmDistPairingLedgerPeer::CREATED_ON);
        $sponsorDistPairingLedgerDB = MlmDistPairingLedgerPeer::doSelectOne($c);

        $legBalance = 0;
        if ($sponsorDistPairingLedgerDB) {
            $legBalance = $sponsorDistPairingLedgerDB->getBalance();
        }

        // update pairing balance
        $distPairingledger = new MlmDistPairingLedger();
        $distPairingledger->setDistId($distId);
        $distPairingledger->setLeftRight($position);
        $distPairingledger->setTransactionType($transactionType);
        $distPairingledger->setCredit(0);
        $distPairingledger->setDebit($debit);
        $distPairingledger->setBalance($legBalance - $debit);
        $distPairingledger->setRemark($remark);
        $distPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $distPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $distPairingledger->save();

        $this->revalidatePairing($distId, $position);
    }

    function flushDistPairingLeader($distId, $position, $minBalance, $remark)
    {
        $distPairingledger = new MlmDistPairingLedger();
        $distPairingledger->setDistId($distId);
        $distPairingledger->setLeftRight($position);
        $distPairingledger->setTransactionType(Globals::PAIRING_LEDGER_FLUSH);
        $distPairingledger->setCredit(0);
        $distPairingledger->setDebit($minBalance);
        $distPairingledger->setBalance(0);
        $distPairingledger->setRemark($remark);
        $distPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $distPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $distPairingledger->save();

        $this->revalidatePairing($distId, $position);
    }

    function getPipsBonusDetailByMonth($distributorId, $month, $year, $fileId)
    {
        //$dateUtil = new DateUtil();

        //$d = $dateUtil->getMonth($month, $year);
        //$firstOfMonth = date('Y-m-j', $d["first_of_month"]) . " 00:00:00";
        //$lastOfMonth = date('Y-m-j', $d["last_of_month"]) . " 23:59:59";

        $query = "SELECT SUM(bonus.credit-bonus.debit) AS SUB_TOTAL FROM mlm_dist_commission_ledger bonus
                LEFT JOIN mlm_pip_csv csv ON csv.pip_id = bonus.ref_id
                        WHERE 1=1 "
                 . " AND bonus.commission_type = '" . Globals::COMMISSION_TYPE_PIPS_BONUS . "'"
                 . " AND bonus.transaction_type = '" . Globals::COMMISSION_LEDGER_PIPS_GAIN . "'"
                 . " AND csv.month_traded = '" . $month . "' AND csv.year_traded = '" . $year . "'";
                 //. " AND bonus.created_on >= '" . $firstOfMonth . "' AND bonus.created_on <= '" . $lastOfMonth . "'";

        if ($fileId != null) {
            $query = $query." csv.file_id = ".$fileId;
        }
        if ($distributorId != null) {
            $query = $query." AND bonus.dist_id = ".$distributorId;
        }
        //var_dump($query);

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        if ($resultset->next()) {
            $arr = $resultset->getRow();
            if ($arr["SUB_TOTAL"] != null) {
                return $arr["SUB_TOTAL"];
            } else {
                return 0;
            }
        }
        return 0;
    }

    function getRbDetailByMonth($distributorId, $month, $year)
    {
        $dateUtil = new DateUtil();

        $d = $dateUtil->getMonth($month, $year);
        $firstOfMonth = date('Y-m-j', $d["first_of_month"]) . " 00:00:00";
        $lastOfMonth = date('Y-m-j', $d["last_of_month"]) . " 23:59:59";

        $query = "SELECT SUM(bonus.credit-bonus.debit) AS SUB_TOTAL FROM mlm_dist_commission_ledger bonus
                        WHERE 1=1 "
                 . " AND bonus.commission_type = '" . Globals::COMMISSION_TYPE_DRB . "'"
                 . " AND bonus.created_on >= '" . $firstOfMonth . "' AND bonus.created_on <= '" . $lastOfMonth . "'";

        if ($distributorId != null) {
            $query = $query." AND bonus.dist_id = ".$distributorId;
        }
        //var_dump($query);

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        if ($resultset->next()) {
            $arr = $resultset->getRow();
            if ($arr["SUB_TOTAL"] != null) {
                return $arr["SUB_TOTAL"];
            } else {
                return 0;
            }
        }
        return 0;
    }

    function getPairingDetailByMonth($distributorId, $month, $year)
    {
        $dateUtil = new DateUtil();

        $d = $dateUtil->getMonth($month, $year);
        $firstOfMonth = date('Y-m-j', $d["first_of_month"]) . " 00:00:00";
        $lastOfMonth = date('Y-m-j', $d["last_of_month"]) . " 23:59:59";

        $query = "SELECT SUM(bonus.credit-bonus.debit) AS SUB_TOTAL FROM mlm_dist_commission_ledger bonus
                        WHERE 1=1 "
                 . " AND bonus.commission_type = '" . Globals::COMMISSION_TYPE_GDB . "'"
                 . " AND bonus.created_on >= '" . $firstOfMonth . "' AND bonus.created_on <= '" . $lastOfMonth . "'";

        if ($distributorId != null) {
            $query = $query." AND bonus.dist_id = ".$distributorId;
        }
        //var_dump($query);

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        if ($resultset->next()) {
            $arr = $resultset->getRow();
            if ($arr["SUB_TOTAL"] != null) {
                return $arr["SUB_TOTAL"];
            } else {
                return 0;
            }
        }
        return 0;
    }

    function getCreditRefundDetailByMonth($distributorId, $month, $year, $fileId)
    {
        //$dateUtil = new DateUtil();

        //$d = $dateUtil->getMonth($month, $year);
        //$firstOfMonth = date('Y-m-j', $d["first_of_month"]) . " 00:00:00";
        //$lastOfMonth = date('Y-m-j', $d["last_of_month"]) . " 23:59:59";

        $query = "SELECT SUM(bonus.credit-bonus.debit) AS SUB_TOTAL FROM mlm_dist_commission_ledger bonus
                LEFT JOIN mlm_pip_csv csv ON csv.pip_id = bonus.ref_id
                        WHERE 1=1 "
                 . " AND bonus.commission_type = '" . Globals::COMMISSION_TYPE_CREDIT_REFUND . "'"
                 . " AND csv.month_traded = '" . $month . "' AND csv.year_traded = '" . $year . "'";
                 //. " AND bonus.created_on >= '" . $firstOfMonth . "' AND bonus.created_on <= '" . $lastOfMonth . "'";

        if ($fileId != null) {
            $query = $query." csv.file_id = ".$fileId;
        }
        if ($distributorId != null) {
            $query = $query." AND bonus.dist_id = ".$distributorId;
        }
        //var_dump($query);

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        if ($resultset->next()) {
            $arr = $resultset->getRow();
            if ($arr["SUB_TOTAL"] != null) {
                return $arr["SUB_TOTAL"];
            } else {
                return 0;
            }
        }
        return 0;
    }

    function getFundDividendDetailByMonth($distributorId, $month, $year, $fileId)
    {
        $query = "SELECT SUM(bonus.credit-bonus.debit) AS SUB_TOTAL FROM mlm_dist_commission_ledger bonus
                LEFT JOIN mlm_pip_csv csv ON csv.pip_id = bonus.ref_id
                        WHERE 1=1 "
                 . " AND bonus.commission_type = '" . Globals::COMMISSION_TYPE_FUND_MANAGEMENT . "'"
                 . " AND csv.month_traded = '" . $month . "' AND csv.year_traded = '" . $year . "'";
                 //. " AND bonus.created_on >= '" . $firstOfMonth . "' AND bonus.created_on <= '" . $lastOfMonth . "'";

        if ($fileId != null) {
            $query = $query." csv.file_id = ".$fileId;
        }
        if ($distributorId != null) {
            $query = $query." AND bonus.dist_id = ".$distributorId;
        }
        //var_dump($query);

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        if ($resultset->next()) {
            $arr = $resultset->getRow();
            if ($arr["SUB_TOTAL"] != null) {
                return $arr["SUB_TOTAL"];
            } else {
                return 0;
            }
        }
        return 0;
    }

    function getRankColor($packageId)
    {
        $color = "blue";

        $package = MlmPackagePeer::retrieveByPK($packageId);
        if ($package) {
            $color = $package->getColor();
        }

        return $color;
    }
    function getRankColorArr()
    {
        $packageArray = array();
        $c = new Criteria();
        $packages = MlmPackagePeer::doSelect($c);
        foreach ($packages as $package) {
            $packageArray[$package->getPackageId()] = $package->getColor();
        }

        return $packageArray;
    }

function getAccumulateGroupBvs($distributorId, $position)
    {
        $dateUtil = new DateUtil();

        $d = $dateUtil->getMonth();
        $firstOfMonth = date('Y-m-j', $d["first_of_month"]) . " 00:00:00";
        $lastOfMonth = date('Y-m-j', $d["last_of_month"]) . " 23:59:59";

        $query = "SELECT SUM(credit) AS SUB_TOTAL FROM mlm_dist_pairing_ledger WHERE dist_id = " . $distributorId
                 . " AND left_right = '" . $position . "'"
                 . " AND transaction_type = '" . Globals::PAIRING_LEDGER_REGISTER . "'";

        //var_dump($query);
        //exit();
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        if ($resultset->next()) {
            $arr = $resultset->getRow();
            if ($arr["SUB_TOTAL"] != null) {
                return $arr["SUB_TOTAL"];
            } else {
                return 0;
            }
        }
        return 0;
    }

    function getTodaySales($distributorId, $position)
    {
        $dateUtil = new DateUtil();

        $d = $dateUtil->getMonth();
        $firstOfMonth = date('Y-m-j') . " 00:00:00";
        $lastOfMonth = date('Y-m-j') . " 23:59:59";

        $query = "SELECT SUM(credit) AS SUB_TOTAL FROM mlm_dist_pairing_ledger WHERE dist_id = " . $distributorId
                 . " AND left_right = '" . $position . "'"
                 . " AND transaction_type = '" . Globals::PAIRING_LEDGER_REGISTER . "'"
                 . " AND created_on >= '" . $firstOfMonth . "' AND created_on <= '" . $lastOfMonth . "'";

        //var_dump($query);
        //exit();
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        if ($resultset->next()) {
            $arr = $resultset->getRow();
            if ($arr["SUB_TOTAL"] != null) {
                return $arr["SUB_TOTAL"];
            } else {
                return 0;
            }
        }
        return 0;
    }
}