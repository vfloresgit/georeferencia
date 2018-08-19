<?php

/**
* 
*/
class Creferencia extends CI_Controller
{
  
  
  function __construct()
  {   
    parent::__construct();
    $this->load->model("malumno");
  }

  public function listar(){
   $contenido=$this->malumno->listar();
      if($contenido==true){
      $data["data"]=$contenido;
   	  $this->load->view("alumno/alumno",$data);
      }
   }

}  
?>