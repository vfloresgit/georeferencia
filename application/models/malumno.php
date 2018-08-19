<?php 
/**
* 
*/
class Malumno extends CI_Model
{
	function __construct(){
		parent::__construct();
	}

    public function listar(){
      $this->db->select('id, lat,long');
      $alumnos = $this->db->get('direccionesxy');
      return $alumnos;       
    }


}
?>