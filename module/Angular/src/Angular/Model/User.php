<?php
 namespace Angular\Model;

 use Zend\InputFilter\InputFilter;
 use Zend\InputFilter\InputFilterAwareInterface;
 use Zend\InputFilter\InputFilterInterface;

 
 class User implements InputFilterAwareInterface
 {
     public $id;
     public $name;
     public $position;
     protected $inputFilter;

     public function exchangeArray($data)
     {
         $this->id     = (!empty($data['id'])) ? $data['id'] : null;
         $this->name = (!empty($data['name'])) ? $data['name'] : null;
         $this->position  = (!empty($data['position'])) ? $data['position'] : null;
     }
     
     public function getArrayCopy()
     {
         return get_object_vars($this);
     }
     
     public function setInputFilter(InputFilterInterface $inputFilter) {
         throw new \Exception("Not used");
     }
     
     public function getInputFilter() {
         if(!$this->inputFilter) {
             $inputFilter = new InputFilter();
             
             $inputFilter->add(array(
                 'name' => 'id',
                 'required' => false,
                 'filters' => array(
                     array('name' => 'Int'),
                 ),
             ));
             
             $inputFilter->add(array(
                 'name'     => 'name',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 100,
                         ),
                     ),
                 ),
             ));

             $inputFilter->add(array(
                 'name'     => 'position',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 100,
                         ),
                     ),
                 ),
             ));

             
             $this->inputFilter = $inputFilter;
                     
         }
         
         return $this->inputFilter;
     }
 }
