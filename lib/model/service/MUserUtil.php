<?php

/**
 * Class MUserUtil - MobileUserUtil
 */
class MUserUtil
{
    const REQ_MUSER = "muser";
    const REQ_MSECR = "msc";
    const REQ_MSIGN = "msign";
    const REQ_MLANG = "mlang";
    const REQ_MLOG_ID = "m@logid";
    const REQ_MACT = "m@act";
    const SECRET_CODE = "super20maxim!)@(#+*$&%^15";

    private $action;

    function __construct($action)
    {
        $this->action = $action;
    }

    public static function init($action)
    {
        return new MUserUtil($action);
    }

    public function response($redirectUrl, $result = 0, $message = null, $data = null)
    {
        if ($this->isMobileUser()) {
            if (!strlen($message)) {
                if ($result === 1 && $this->action->hasFlash("successMsg")) {
                    $message = $this->action->getFlash("successMsg");
                } elseif ($this->action->hasFlash("errorMsg")) {
                    $message = $this->action->getFlash("errorMsg");
                }
            }

            echo $this->getJson($result, $message, $data);
            return sfView::HEADER_ONLY;
        }

        return $this->action->redirect($redirectUrl);
    }

    public function isMobileUser($autoVerify = false, &$errMsg = null)
    {
        $result = $this->action->getRequestParameter(MUserUtil::REQ_MUSER, false);

        if ($result && $autoVerify) {
            return $this->verifyMobileUser($errMsg);
        }

        return $result;
    }

    public function verifyMobileUser(&$errMsg = null)
    {
        $username = $this->action->getRequestParameter(MUserUtil::REQ_MUSER);
        $secret = $this->action->getRequestParameter(MUserUtil::REQ_MSECR);
        $lang = $this->action->getRequestParameter(MUserUtil::REQ_MLANG, "en");

        if (!$username || !$secret) {
            // Missing required param.
            $errMsg = $this->action->getContext()->getI18N()->__("Invalid action: missing required parameters.");
            return false;
        }

        $c = new Criteria();
        $c->add(AppUserPeer::USERNAME, $username);
        $c->add(AppUserPeer::USER_ROLE, Globals::ROLE_DISTRIBUTOR);
        $existUser = AppUserPeer::doSelectOne($c);

        if (!$existUser) {
            // AppUser not found.
            $errMsg = $this->action->getContext()->getI18N()->__("Invalid user or user not found.");
            return false;
        }

        if (!$this->isSecretValid($username, $existUser->getUserpassword(), $secret)) {
            // MD5 encrypt mismatch.
            $errMsg = $this->action->getContext()->getI18N()->__("Invalid action: security data mismatch.");
            return false;
        }

        if ($existUser->getStatusCode() != Globals::STATUS_ACTIVE) {
            // Account status code is not active.
            $errMsg = $this->action->getContext()->getI18N()->__("Invalid action: account status is not activated.");
            return false;
        }

        $c = new Criteria();
        $c->add(MlmDistributorPeer::USER_ID, $existUser->getUserId());
        $existDist = MlmDistributorPeer::doSelectOne($c);

        if (!$existDist) {
            // Distributor not found.
            $errMsg = $this->action->getContext()->getI18N()->__("Invalid user or user not found.");
            return false;
        }

        if ($existUser->getPasswordExpireDate() != "") {
            $passwordExpire = DateTime::createFromFormat("Y-m-d H:i:s", $existUser->getPasswordExpireDate());
            $now = new DateTime();

            if ($now >= $passwordExpire) {
                $errMsg = $this->action->getContext()->getI18N()->__("Invalid action: account password is expired.");
                return false;
            }
        } else {
            // Password expire date not set yet, force user to update password page.
            $errMsg = $this->action->getContext()->getI18N()->__("Invalid action: account password is expired.");
            return false;
        }

        $leaderId = "";
        $leaderCode = "";
        $leaderArrs = explode(",", Globals::GROUP_LEADER);
        for ($i = 0; $i < count($leaderArrs); $i++) {
            $pos = strrpos($existDist->getTreeStructure(), "|" . $leaderArrs[$i] . "|");
            if ($pos === false) { // note: three equal signs
                // Do nothing.
            } else {
                $dist = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
                if ($dist) {
                    $leaderId = $dist->getDistributorId();
                    $leaderCode = $dist->getDistributorCode();
                }
                break;
            }
        }

        $this->action->getUser()->setAuthenticated(true);
        $this->action->getUser()->addCredential(Globals::PROJECT_NAME . $existUser->getUserRole());
        $this->action->getUser()->setAttribute(Globals::SESSION_DISTID, $existDist->getDistributorId());
        $this->action->getUser()->setAttribute(Globals::SESSION_DISTCODE, $existDist->getDistributorCode());
        $this->action->getUser()->setAttribute(Globals::SESSION_USERID, $existUser->getUserId());
        $this->action->getUser()->setAttribute(Globals::SESSION_USERNAME, $existUser->getUsername());
        $this->action->getUser()->setAttribute(Globals::SESSION_NICKNAME, $existDist->getFullName());
        $this->action->getUser()->setAttribute(Globals::SESSION_USERTYPE, $existUser->getUserRole());
        $this->action->getUser()->setAttribute(Globals::SESSION_USERSTATUS, $existUser->getStatusCode());
        $this->action->getUser()->setAttribute(Globals::SESSION_LEADER_ID, $leaderId);
        $this->action->getUser()->setAttribute(Globals::SESSION_LEADER_CODE, $leaderCode);
        $this->action->getUser()->setCulture($lang);

        return true;
    }

    public function isPostSignatureValid(&$debug = null)
    {
        $msign = $this->action->getRequestParameter(MUserUtil::REQ_MSIGN);

        if (strlen($msign)) {
            $postParam = $this->action->getRequest()->getParameterHolder()->getAll();
//            ksort($postParam);
            $tempstr = "";
            $tempstrk = "";
            $skip = array(MUserUtil::REQ_MSIGN, "module", "action");

            foreach ($postParam as $key => $val) {
                if (!in_array($key, $skip)) {
                    $tempstrk .= $key . "|";
                    $tempstr .= $val;
                }
            }
            $debug = md5($tempstr . MUserUtil::SECRET_CODE) . " | " . $tempstrk;
            return md5($tempstr . MUserUtil::SECRET_CODE) === $msign;
        }

        return false;
    }

    public function getJson($result = 0, $message = null, $data = null)
    {
        if (!$message) {
            $message = "";
        }

        $arr = array(
            "result" => $result,
            "message" => $message
        );

        if (is_array($data)) {
            $arr = array_merge($arr, $data);
        }

        return json_encode($arr);
    }

    public function isSecretValid($username, $password, $clientSecret)
    {
        if ($username && $password && $clientSecret) {
            return md5($username . $password . MUserUtil::SECRET_CODE) === $clientSecret;
        }

        return false;
    }

    public function updateLog($msg = null, $dumpFlash = false)
    {
        if ($logId = $this->action->getUser()->getAttribute(MUserUtil::REQ_MLOG_ID, false)) {
            $msgArr = array();

            if (strlen($msg)) {
                array_push($msgArr, $msg);
            }

            if ($dumpFlash) {
                if ($this->action->hasFlash("successMsg")) {
                    $msg = $this->action->getFlash("successMsg");
                    array_push($msgArr, $msg);
                    $this->action->setFlash("successMsg", $msg); // Recover back flash message.
                }

                if ($this->action->hasFlash("errorMsg")) {
                    $msg = $this->action->getFlash("errorMsg");
                    array_push($msgArr, $msg);
                    $this->action->setFlash("errorMsg", $msg); // Recover back flash message.
                }
            }

            if (count($msgArr)) {
                // Update log only when message is not empty.
                $log = AppMobileLogPeer::retrieveByPK($logId);

                if ($log) {
                    $oldRemark = $log->getRemark();

                    if (strlen($oldRemark)) {
                        array_unshift($msgArr, $log->getRemark()); // Set previous remarks to first position.
                    }

                    $log->setRemark(implode(" | ", $msgArr));
                    $log->setUpdatedBy(Globals::SYSTEM_USER_ID);
                    $log->save();
                }
            }
        }

        return $this;
    }
}