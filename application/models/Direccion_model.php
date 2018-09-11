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
		$sql="select * from direcciones offset 1";
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
         $sql="select id,longitud as lon,latitud as lat from direcciones offset 1";
         $resultado=$this->db->query($sql);
         return $resultado->result_array();
	}

	function PuntoDeInicio(){
		$sql="select id,longitud as lon,latitud as lat from direcciones limit 1";
        $inicio=$this->db->query($sql);
        return $inicio->result_array();
	}

	function insertExcel($data){
		$this->db->insert_batch('direcciones',$data);
	}
	function eliminarRegistros(){
		$this->db->delete('direcciones');
	}
	function RegistrarSecuencia($decode,$id_punto_inicio){

          foreach ($decode as $valor) {
          	  if ($valor->id == 'ini') {

          	  	$this->db->set('secuencia',$valor->seq);
          	  	$this->db->where('id',$id_punto_inicio);
				$this->db->update('direcciones'); 
          	  }else{
          	  	$this->db->set('secuencia',$valor->seq);
				$this->db->where('id',$valor->id);
				$this->db->update('direcciones'); 
          	  }
          		                 
		  }
	}
	function CordenadasSecuenciadas(){
		$this->db->select('*');
		$this->db->from('direcciones');
		$this->db->order_by('secuencia','ASC');
		$secuencia=$this->db->get();
		return $secuencia->result_array();
	}
}
?>