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
         <th>Distrito</th>
         <th>Direccion</th>
         <th>Departamento</th>
         <th>Provincia</th>
         <th>Ubigeo</th>
         <th>Longitud</th>
         <th>Latitud</th>
        </tr>
		';
		foreach($data->result() as $row){
			$output.='<tr>
			<td>'.$row->id.'</td>
      <td>'.$row->distrito.'</td>
      <td>'.$row->direccion.'</td>
      <td>'.$row->departamento.'</td>
      <td>'.$row->provincia.'</td>
      <td>'.$row->ubigeo.'</td>
      <td>'.$row->longitud.'</td>
      <td>'.$row->latitud.'</td>
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

  function ruta(){
    $this->load->view('Ruta/ruta.html');
  }

  function CordenadasSecuenciadas(){

    $data=$this->Direccion_model->CordenadasSecuenciadas();
    echo json_encode($data);

  }

  function exportexcel(){
    $excel=new PHPexcel();
    $excel->setActiveSheetIndex(0);
    $cordenadas=$this->Direccion_model->CordenadasSecuenciadas();
    $column_tabla=array("id","distrito","direccion","departamento","provincia","ubigeo","longitud","latitud","secuencia");
    $column = 0;
    $fila = 3;

    foreach ($column_tabla as $columnas){
      $excel->getActiveSheet()->setCellValueByColumnAndRow($column,2,$columnas);
      $column++;
    }


    foreach ($cordenadas as $datos) {
       $excel->getActiveSheet()->setCellValueByColumnAndRow(0,$fila,$datos["id"]);
       $excel->getActiveSheet()->setCellValueByColumnAndRow(1,$fila,$datos["distrito"]);
       $excel->getActiveSheet()->setCellValueByColumnAndRow(2,$fila,$datos["direccion"]);
       $excel->getActiveSheet()->setCellValueByColumnAndRow(3,$fila,$datos["departamento"]);
       $excel->getActiveSheet()->setCellValueByColumnAndRow(4,$fila,$datos["provincia"]);
       $excel->getActiveSheet()->setCellValueByColumnAndRow(5,$fila,$datos["ubigeo"]);
       $excel->getActiveSheet()->setCellValueByColumnAndRow(6,$fila,$datos["longitud"]);
       $excel->getActiveSheet()->setCellValueByColumnAndRow(7,$fila,$datos["latitud"]);
       $excel->getActiveSheet()->setCellValueByColumnAndRow(8,$fila,$datos["secuencia"]);
       $fila++;
    }
    $excel_hecho=PHPExcel_IOFactory::createWriter($excel,'Excel5');
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment;filename='Secuencia de direcciones.xls'");
    $excel_hecho->save('php://output');
  }


}	