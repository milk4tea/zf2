<?php
namespace Angular\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Angular\Model\User;
use Angular\Form\UserForm;
use Zend\View\Model\JsonModel;

class UserController extends AbstractRestfulController
{
    protected $userTable;
    
    
    // GET
    public function getList() {
        $results = $this->getUserTable()->fetchAll();
        $data = array();
        foreach($results as $result) {
            $data[] = $result;
        }
        
        return new JsonModel(array('data' => $data));
    }
    
    public function get($id) {
        $user = $this->getUserTable()->getUser($id);
        
        return new JsonModel(array(
            'data' => $user
        ));
    }
    
    // POST
    public function create($data) {
        $form = new UserForm();
        $user = new User();
        $form->setInputFilter($user->getInputFilter());
        $form->setData($data);
        $msg = '';
        if($form->isValid()) {
            $user->exchangeArray($form->getData());
            if($this->getUserTable()->saveUser($user)>0){
                $msg = 'User saved';
            } else {
                $msg = 'User wasn\'t saved';
            }
        } else {
            $msg = 'form invalid';
        }
        
        return new JsonModel(array('data' => $msg));
        //return $this->get($id);
    }
    
    // PUT
    public function update($id, $data) {
        $data['id'] = $id;
        $user = $this->getUserTable()->getUser($id);
        $form = new UserForm();
        $form->bind($user);
        $form->setInputFilter($user->getInputFilter());
        $form->setData($data);
        if($form->isValid()) {
            $id = $this->getUserTable()->saveUser($form->getData());
        }
        
        return $this->get($id);
    }

    // DELETE
    public function delete($id) {

        $msg = '';
        if ($this->getUserTable()->deleteUser($id) > 0) {
            $msg = 'deleted';
        } else {
            $msg = 'noting was deleted';
        }
        
        return new JsonModel(array(
            'data' => $msg,
        ));
    }

    public function getUserTable()
    {
        if(!$this->userTable)  {
            $sm = $this->getServiceLocator();
            $this->userTable = $sm->get('Angular\Model\UserTable');
        }
        return $this->userTable;
    }
}