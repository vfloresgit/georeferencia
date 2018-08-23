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
            <td>'.$row->latitud.'</td>
            <td>'.$row->longitud.'</td>
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

  function importExcelEnterprise(){

      try{

        $this->Direccion_model->eliminarRegistros();       

        if(isset($_FILES["file"]["name"])){
           $path=$_FILES["file"]["tmp_name"];
           $object=PHPExcel_IOFactory::load($path);
           foreach ($object->getWorksheetIterator() as $worksheet) {
             $highestRow=$worksheet->getHighestRow();
             $highestColumn = $worksheet->getHighestColumn();
             for($row=2;$row<=$highestRow;$row++){
               // $id=$worksheet->getCellByColumnAndRow(0,$row)->getValue();
               $distrito=$worksheet->getCellByColumnAndRow(1,$row)->getValue();
               $direccion=$worksheet->getCellByColumnAndRow(2,$row)->getValue();
               $departamento=$worksheet->getCellByColumnAndRow(3,$row)->getValue();
               $provincia=$worksheet->getCellByColumnAndRow(4,$row)->getValue();
               $ubigeo=$worksheet->getCellByColumnAndRow(5,$row)->getValue();
               $longitud=$worksheet->getCellByColumnAndRow(6,$row)->getValue();
               $latitud=$worksheet->getCellByColumnAndRow(7,$row)->getValue();
               $data[]=array(
                 'distrito'=>$distrito,
                 'direccion'=>$direccion,
                 'departamento'=>$departamento,
                 'provincia'=>$provincia,
                 'ubigeo'=>$ubigeo,
                 'longitud'=>$longitud,
                 'latitud'=>$latitud
               );
             }

           }
           $this->Direccion_model->insertExcel($data); 
           echo 'Coordenadas importado correctamente!!';
       }

      }catch(Exception $e){
        var_dump($e->getMessage());

      }

  }

}	