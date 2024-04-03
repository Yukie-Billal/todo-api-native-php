<?php
include "../config/database.php";

include "../todos/todos.controller.php";

header("Content-Type: application/json; charset=UTF-8");
$request_method = $_SERVER['REQUEST_METHOD'];
// echo json_encode($_SERVER);
// return;

switch ($request_method) {
   case "GET":
      echo json_encode(getAllTodos($db));
      break;
   
   case "POST":
      if ($_SERVER["CONTENT_TYPE"] !== "application/json") {
         echo json_encode(["message" => "Body format hanya dapat berupa json"]);
         return;
      }

      $json_input = file_get_contents('php://input');
      $request_body = json_decode($json_input, TRUE);

      if (!isset($request_body['description']) || !isset($request_body['status'])) {
         echo json_encode(["message" => "Body tidak lengkap"]);
         return;
      }
      $json_input = file_get_contents('php://input');
      $request_body = json_decode($json_input, TRUE);
      
      if (!isset($request_body['description']) || !isset($request_body['status'])) {
         echo json_encode(["message" => "Body tidak lengkap"]);
         return;
      }
      echo json_encode(createTodo($db, $request_body['description'], $request_body['status']));
      break;
      
   case "PUT":
      if ($_SERVER['CONTENT_TYPE'] !== "application/json") {
         echo json_encode(["message" => "Body format hanya dapat berupa json"]);
         return;
      }
      $json_input = file_get_contents('php://input');
      $request_body = json_decode($json_input, TRUE);

      if (!isset($request_body['id']) || !isset($request_body['description']) || !isset($request_body['status'])) {
         echo json_encode(["message" => "Body tidak lengkap"]);
         return;
      }
      echo json_encode(updateTodo($db, $request_body['id'], $request_body['description'], $request_body['status']));
      break;

   case "DELETE":
      if ($_SERVER['CONTENT_TYPE'] !== "application/json") {
         echo json_encode(["message" => "Body format hanya dapat berupa json"]);
         return;
      }
      $json_input = file_get_contents('php://input');
      $request_body = json_decode($json_input, TRUE);

      if (!isset($request_body['id'])) {
         echo json_encode(["message" => "Body tidak lengkap"]);
         return;
      }
      echo json_encode(deleteTodo($db, $request_body['id']));
      break;   
   
   default:
      echo json_encode(["message"=>"Invalid request method"]);
}
return;