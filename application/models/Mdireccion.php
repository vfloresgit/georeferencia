<?php

/**
* 
*/
class Mdireccion extends CI_Model
{
	function select(){
		$this->db->order_by('id','ASC');
		$query=$this->db->get('direccionesxy');
		return $query;
	}
	function insert($data){
		$this->db->insert_batch('direccionesxy',$data);
	}
	function listarCordenadas(){
		
        $this->db->select('id,lat,long');
         $this->db->from('direccionesxy');
         $resultado=$this->db->get();
         


         return $resultado;
        
	}

}
?>
