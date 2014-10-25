<?php
namespace JhaAdmin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use JhaAdmin\Form\OptionsForm;
use JhaAdmin\Entity\OptionsEntity;

class SettingController extends AbstractActionController
{

    public function indexAction()
    {
        $optionsMapper = $this->getOptinosMapper();
        $options_general = $optionsMapper->getOptionsByType(0);
        $options_mailing = $optionsMapper->getOptionsByType(1);

        $options_discussion = $optionsMapper->getOptionsByType(2);
        $options_reading = $optionsMapper->getOptionsByType(3);
        $options_social = $optionsMapper->getOptionsByType(4);
        
        $optionsForm = new OptionsForm();
        return array(
            'form' => $optionsForm,
            'options_general' => $options_general,
            'options_mailing' => $options_mailing,
            'options_discussion' => $options_discussion,
            'options_reading' => $options_reading,
            'options_social' => $options_social
        );
    }
    
    public function updateAction()
    {
        $request = $this->getRequest();
        if($request->isPost()){
            $data = $request->getPost()->toArray();
            $id = $data['pk'];
            unset($data['pk']);
            if($this->getOptinosMapper()->updateOptionById($data,$id)){
                exit('修改成功');
            }else{
                exit('修改失败');
            }
        }
    }

    public function addAction()
    {
        $request = $this->getRequest();
        $optionsForm = new OptionsForm();
        $optionsEntity = new OptionsEntity();
        $optionsForm->bind($optionsEntity);
        $jsonModel = new JsonModel();
        if ($request->isPost()) {
            $data = $request->getPost();
            $optionsForm->setData($data);
            if ($optionsForm->isValid()) {
                if (! $this->getOptinosMapper()->getOptionByKey($optionsEntity->getKeyname())) {
                    $optionsEntity->setStatus(1);
                    $insertid = $this->getOptinosMapper()->saveOption($optionsEntity);
                    $jsonModel->setVariables(array(
                        'data' => $insertid,
                        'status' => 1,
                        'info' => '添加成功'
                    ));
                } else {
                    $jsonModel->setVariables(array(
                        'data' => null,
                        'status' => 0,
                        'info' => '已存在的记录'
                    ));
                }
            } else {
                $jsonModel->setVariables(array(
                    'data' => null,
                    'status' => 0,
                    'info' => $optionsForm->getMessages()
                ));
            }
            return $jsonModel;
        }
    }

    public function getOptinosMapper()
    {
        return $this->getServiceLocator()->get('table:Options');
    }
}