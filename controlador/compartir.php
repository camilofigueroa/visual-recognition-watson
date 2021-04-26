<?php
/**
 * autor: Brayan Basallo Soto
 * controlador: sección compartir
 */

$img = $_GET['ruta_img'];
$ruta_img = "https://www.todo-yo.com/xampp-hp/htdocs/watson1/".str_replace( "../", "", $img );

$arreglo = explode( "/", $img );
$img2 = $arreglo[ count( $arreglo ) - 1 ];
$resultados = "";
$error = "";

//echo $img." ".$img2;

$seccion = '../vista/compartir.phtml';
//----------------------------- W A T S O N -- A P I ---------------------

$url = 'https://gateway.watsonplatform.net/visual-recognition/api/v3/classify?version=2018-03-19';
    
//$file = "https://www.todo-yo.com/xampp-hp/htdocs/watson1/images/usuarios/foto_5f4448d2aac24-.jpeg";
$file = $ruta_img;
    
$image_url = "&url=".$file;

//cURL
$ch = curl_init();

    curl_setopt($ch, CURLOPT_USERPWD, 'apikey:jgA_KwDJMrOkJHWU--BKdbmkxTEBOcHtqF54BxaglWE5'); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt($ch, CURLOPT_URL, $url."&images_file=".$file ); //Endpoint URL                
    //curl_setopt($ch, CURLOPT_HEADER, $headers ); //Este headers ofrece más información que el otro formato.
    curl_setopt($ch, CURLOPT_POST, false ); //POST        
    curl_setopt($ch, CURLOPT_POSTFIELDS, $image_url );        

// Execute the cURL command
$result = curl_exec($ch);

// Erro
if (curl_errno($ch))
{
    $error = 'Error: '.curl_error($ch);
}

//var_dump( json_decode( $result )); //Aquí es solo para mostrar el tipo de variable y su contenido.
//20210426 Hay que tener cuidado porque se probó en local y generaba un error. Es porque en local toma imágenes pero no están en el servidor en internet.
    
$objeto = json_decode( $result, true );    //Convierte Json a un arreglo.
    
foreach( $objeto[ "images" ][ 0 ][ "classifiers" ][ 0 ][ "classes" ] as $p )
{
    $resultados .= $p[ "class" ]."<br>";
    $resultados .= $p[ "score" ]."<br>";
}

//---------------------------------------------------------------------
include '../vista/plantilla.phtml';

