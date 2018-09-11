<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Demo extends CI_Controller {

    function __construct(){

       parent::__construct();
       $this->load->model("Direccion_model");

    }

	public function index(){

		$this->load->view('welcome_message');

	}

	public function texturl(){


        //TIEMPO DE EJECUCION DEL METODO
		set_time_limit(0);

      
		$url = "http://192.168.0.60/routing/index.php/routing/soloorden/";

		//METODO PARA LLAMAR A LA LISTA DE CORDENADAS DE LA BASE DE DATOS

        $resultado=$this->Direccion_model->listarCordenadas();

        
        $dato = array();

        //RECORRER LA DATA QUE SE OBTIENE DEL METODO LISTAR CORDENADAS Y LO ALMACENA EN LA VARIABLE DATO
         foreach ($resultado as $lista){

         	if(isset($lista['id'])){
         		array_push($dato, array('id'=>$lista['id'],'lat'=>$lista['lat'],'lon'=>$lista['lon']));
         		
         	}

         }

         //LLAMAR AL METODO PARA CAPTURAR EL PUNTO DE INICIO
         $inicio=$this->Direccion_model->PuntoDeInicio();

         //RECORRER LA DATA DE PUNTO DE INICIO
         foreach ($inicio as $p) {
         	    $id_punto_inicio=$p['id'];
                $latitud=$p['lat'];
                $longitud=$p['lon'];
         }
         


          //PUNTO DE INICIO
         $ini = array('id'=>'ini','lat'=>$latitud,'lon'=>$longitud); 





         //TODO EL ARREGLO ALMACENADO EN LA VARIABLE JSON
	     $json = $dato;

	     	  // echo "<pre>";
         // print_r($json);
         // echo "</pre>";exit;


        

	     //DATA DE PUNTO DE INICIO Y DATO CONVERTIDO A JSON
		 $arr = array("init"=>json_encode($ini),"json"=>json_encode($json));

		  // echo "<pre>";
    //      print_r($arr);
    //      echo "</pre>";exit;
        
        //MANDAR LOS DATOS A UNA API DE ROUTING
 		$res = $this->curl_base($url,null,$arr,null,null,null,null,null);


 		  // echo "<pre>";
     //     var_dump($res);
     //     echo "</pre>";exit;

		 
		//DESYEISANDO
        $decode=json_decode($res);
        // var_dump($decode);exit;

        


        $this->Direccion_model->RegistrarSecuencia($decode,$id_punto_inicio);
        $this->load->view('Ruta/ruta.html');
 
  //         echo "<table border='1' width='850px'>";
		//            echo "<tr>";
		// 		           echo "<td>id</td>";
		// 		           echo "<td>lat</td>";
		// 		           echo "<td>lon</td>";
		// 		           echo "<td>id_node</td>";
		// 		           echo "<td>seq</td>";
		//            echo "</tr>";
  //         foreach ($decode as $valor) {
		//            echo "<tr>";
		// 		           echo "<td>".$valor->id."</td>";
		// 		           echo "<td>".$valor->lat."</td>";
		// 		           echo "<td>".$valor->lon."</td>";
		// 		           echo "<td>".$valor->id_node."</td>";
		// 		           echo "<td>".$valor->seq."</td>";
		//            echo "</tr>";
  //         }
  //         echo "</table>";

	
		// echo "<pre>";
		// print_r($res);
		// echo "</pre>";

	}

	public function curl_base($url,$cookie_jar,$arr,$referer,$useragent,$httpheader,$proxy,$port)
	{
         
		$a = curl_init($url);
		// curl_setopt($a, CURLOPT_VERBOSE, true);
		curl_setopt($a, CURLOPT_POSTFIELDS, $arr);
		curl_setopt($a, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($a, CURLOPT_BINARYTRANSFER,1);
		curl_setopt($a, CURLOPT_FRESH_CONNECT, TRUE);
		curl_setopt($a, CURLOPT_CONNECTTIMEOUT ,2); 
		$b = curl_exec($a);
		// $info = curl_getinfo($a);

		return $b;
		
	}



}

