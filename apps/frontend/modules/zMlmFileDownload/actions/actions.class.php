<?php
// auto-generated by sfPropelCrud
// date: 2012/06/16 13:52:59
?>
<?php

/**
 * zMlmFileDownload actions.
 *
 * @package    sf_sandbox
 * @subpackage zMlmFileDownload
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 3335 2007-01-23 16:19:56Z fabien $
 */
class zMlmFileDownloadActions extends sfActions
{
  public function executeIndex()
  {
    return $this->forward('zMlmFileDownload', 'list');
  }

  public function executeList()
  {
    $this->mlm_file_downloads = MlmFileDownloadPeer::doSelect(new Criteria());
  }

  public function executeShow()
  {
    $this->mlm_file_download = MlmFileDownloadPeer::retrieveByPk($this->getRequestParameter('file_id'));
    $this->forward404Unless($this->mlm_file_download);
  }

  public function executeCreate()
  {
    $this->mlm_file_download = new MlmFileDownload();

    $this->setTemplate('edit');
  }

  public function executeEdit()
  {
    $this->mlm_file_download = MlmFileDownloadPeer::retrieveByPk($this->getRequestParameter('file_id'));
    $this->forward404Unless($this->mlm_file_download);
  }

  public function executeUpdate()
  {
    if (!$this->getRequestParameter('file_id'))
    {
      $mlm_file_download = new MlmFileDownload();
    }
    else
    {
      $mlm_file_download = MlmFileDownloadPeer::retrieveByPk($this->getRequestParameter('file_id'));
      $this->forward404Unless($mlm_file_download);
    }

    $mlm_file_download->setFileId($this->getRequestParameter('file_id'));
    $mlm_file_download->setFileType($this->getRequestParameter('file_type'));
    $mlm_file_download->setFileSrc($this->getRequestParameter('file_src'));
    $mlm_file_download->setFileName($this->getRequestParameter('file_name'));
    $mlm_file_download->setContentType($this->getRequestParameter('content_type'));
    $mlm_file_download->setStatusCode($this->getRequestParameter('status_code'));
    $mlm_file_download->setRemarks($this->getRequestParameter('remarks'));
    $mlm_file_download->setCreatedBy($this->getRequestParameter('created_by'));
    if ($this->getRequestParameter('created_on'))
    {
      list($d, $m, $y) = sfI18N::getDateForCulture($this->getRequestParameter('created_on'), $this->getUser()->getCulture());
      $mlm_file_download->setCreatedOn("$y-$m-$d");
    }
    $mlm_file_download->setUpdatedBy($this->getRequestParameter('updated_by'));
    if ($this->getRequestParameter('updated_on'))
    {
      list($d, $m, $y) = sfI18N::getDateForCulture($this->getRequestParameter('updated_on'), $this->getUser()->getCulture());
      $mlm_file_download->setUpdatedOn("$y-$m-$d");
    }

    $mlm_file_download->save();

    return $this->redirect('zMlmFileDownload/show?file_id='.$mlm_file_download->getFileId());
  }

  public function executeDelete()
  {
    $mlm_file_download = MlmFileDownloadPeer::retrieveByPk($this->getRequestParameter('file_id'));

    $this->forward404Unless($mlm_file_download);

    $mlm_file_download->delete();

    return $this->redirect('zMlmFileDownload/list');
  }
}
