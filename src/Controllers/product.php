<?php 

use Slim\Http\Request; //namespace 
use Slim\Http\Response; //namespace 

//include productsProc.php file
include __DIR__ . '/../function/productProc.php';

//read products request
$app->get('/product', function (Request $request, Response $response, array $arg){ 
return $this->response->withJson(array('data' => 'success'), 200); 
});

//read productTest request 2
$app->get('/productTest', function (Request $request, Response $response, array $arg){ 
return $this->response->withJson(array('data' => 'DATA HAS SUCCESSFUL IN!'), 200); 
});



//request table product by condition
$app->get('/product/[{id}]', function ($request, $response, $args){
    $productId = $args['id'];
    if (!is_numeric($productId)) {
        return $this->response->withJson(array('error' => 'numeric paremeter required'), 422);
    }

    $data = getProduct($this->db,$productId);
    if (empty($data)) {
        return $this->response->withJson(array('error' => 'no data'), 404);
    }

    return $this->response->withJson(array('data' => $data), 200);
});


//request table product by condition name
$app->get('/producttest/[{name}]', function ($request, $response, $args){
    $productName = $args['name'];
    if (!is_string($productName)) {
        return $this->response->withJson(array('error' => 'string paremeter required'), 422);
    }

    $data = getProducttest($this->db,$productName);
    if (empty($data)) {
        return $this->response->withJson(array('error' => 'no data'), 404);
    }

    return $this->response->withJson(array('data' => $data), 200);
});

//post at Postman (updated code)
$app -> post ('/InsertProduct', function (Request $request, Response $response, array $args) 
    {
        $form_data=$request->getParsedBody();
        $data = createProduct ($this->db, $form_data);
        if (empty($data)) {
        return $this ->response->withJson (array('error' => 'NO DATA INSERTED'), 484);
    }
        return $this ->response->withJson (array('data' => 'DATA INSERT SUCCESSFULL'), 200);
});

//delete row 
$app->delete('/products/del/[{id}]', function ($request, $response, $args){ 
$productId = $args['id']; 
if (!is_numeric($productId)) {
return $this->response->withJson(array('error' => 'numeric paremeter required'), 422); } 
$data = deleteProduct($this->db,$productId); 
if (empty($data)) { 
return $this->response->withJson(array($productId=> 'is successfully deleted'), 202);}; 
});

//delete row by name
$app->delete('/producttest/del/[{name}]', function ($request, $response, $args){ 
    $productName = $args['name']; 
    if (!is_string($productName)) {
    return $this->response->withJson(array('error' => 'string paremeter required'), 422); } 
    $data = deleteProducttest($this->db,$productName); 
    if (empty($data)) { 
    return $this->response->withJson(array($productName=> 'is successfully deleted YAY!'), 202);}; 
    });



//put table products
$app->put('/products/put/[{id}]', function ($request, $response, $args){
$productId = $args['id'];
$date = date("Y-m-j h:i:s");

if (!is_numeric($productId)) {
return $this->response->withJson(array('error' => 'numeric paremeter required'), 422);
}
$form_dat=$request->getParsedBody();

$data=updateProduct($this->db,$form_dat,$productId,$date);
if ($data <=0)

return $this->response->withJson(array('data' => 'successfully updated'), 200);});

//put table products by name
$app->put('/producttest/put/[{name}]', function ($request, $response, $args){
    $productName = $args['name'];
    $date = date("Y-m-j h:i:s");
    
    if (!is_string($productName)) {
    return $this->response->withJson(array('error' => 'string paremeter required'), 422);
    }
    $form_dat=$request->getParsedBody();
    
    $data=updateProducttest($this->db,$form_dat,$productName,$date);
    //if ($data <=0)
    
    return $this->response->withJson(array('data' => 'successfully updated CONGRATS!'), 200);
});

