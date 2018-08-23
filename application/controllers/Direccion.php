<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Direccion extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
    
    $this->load->model('Direccion_model');
		$this->load->library('excel');
	}

	function index(){
		$this->load->view('Direccion/index.php');
	}

	function fetch(){
		$data=$this->Direccion_model->select();
		$output='
        <h3 align="center">Total de datos - '.$data->num_rows().'</h3>
        <table class="table table-striped table-bordered">
         <tr>
         <th>Id</th>
         <th>Latitud</th>
         <th>Longitud</th>
        </tr>
		';
		foreach($data->result() as $row){
			$output.='<tr>
			<td>'.$row->id.'</td>
            <td>'.$row->lat.'</td>
            <td>'.$row->long.'</td>
			</tr>
			';
		}
		$output.='</table>';
		echo $output;
	}

	function import(){

      try{
      	if(isset($_FILES["file"]["name"])){
           $path=$_FILES["file"]["tmp_name"];
           $object=PHPExcel_IOFactory::load($path);
           foreach ($object->getWorksheetIterator() as $worksheet) {
           	 $highestRow=$worksheet->getHighestRow();
             $highestColumn = $worksheet->getHighestColumn();
           	 for($row=2;$row<=$highestRow;$row++){
               // $id=$worksheet->getCellByColumnAndRow(0,$row)->getValue();
               $lat=$worksheet->getCellByColumnAndRow(0,$row)->getValue();
               $long=$worksheet->getCellByColumnAndRow(1,$row)->getValue();
               $data[]=array(
                 'lat'=>$lat,
                 'long'=>$long
               );
           	 }

           }
           $this->Direccion_model->insert($data); 
           echo 'Coordenadas importado correctamente!!';
		   }

      }catch(Exception $e){
      	var_dump($e->getMessage());

      }

	}

}	