<?php
/**
* 
*/
class Direccion_model extends CI_Model
{
	function select(){
		// $this->db->order_by('id','ASC');
		// $query=$this->db->get('direccionesxy');
		// return $query;
		$sql="select * from direccionesxy offset 1";
		$query = $this->db->query($sql);
		return $query;
	}

	function insert($data){
		$this->db->insert_batch('direccionesxy',$data);
	}

	function listarCordenadas(){
        // $this->db->select('id,lat,long as lon');
        //  $this->db->from('direccionesxy');
        //  $resultado=$this->db->get();
        //  return $resultado->result_array();
         $sql="select id,lat,long as lon from direccionesxy offset 1";
         $resultado=$this->db->query($sql);
         return $resultado->result_array();
	}

	function PuntoDeInicio(){
		$sql="select lat,long as lon from direccionesxy limit 1";
         $inicio=$this->db->query($sql);
         return $inicio->result_array();
	}
}
?>