<?php

function getAllTodos($db) {
   $query = mysqli_query($db, "SELECT * FROM todos");
   return $query->fetch_all(1);
}

function createTodo($db, $description, $status) {   
   try {
      $id = "adn2idm3d";
      $result = mysqli_query($db, "INSERT INTO todos (id, description, status) values ('$id', '$description', '$status')");
   
      if ($result) {
         $query = mysqli_query($db, "SELECT * FROM todos WHERE id='$id'");
         return $query->fetch_assoc();
      } else {
         return ["message" => "Gagal menambah todo"];
      }
   } catch (\Throwable $th) {
      return ["message" => "$th"];
   }
}

function updateTodo($db, $id, $description, $status) {
   try {
      $todo = mysqli_query($db, "SELECT * FROM todos WHERE id='$id'");
      if ($todo->num_rows == 0) return ["message" => "Todo tidak ditemukan"];
      
      $result = mysqli_query($db, "UPDATE todos SET description='$description', status='$status' WHERE id='$id'");
      if ($result) {
         $query = mysqli_query($db, "SELECT * FROM todos WHERE id='$id'");
         return $query->fetch_assoc();
      } else {
         return ["message" => "Gagal mengubah todo"];
      }
   } catch (\Throwable $th) {
      return ["message" => "$th"];
   }
}

function deleteTodo($db, $id) {
   try {
      $todo = mysqli_query($db, "SELECT * FROM todos WHERE id='$id'");
      if (!$todo->num_rows) {
         return ["message" => "Todo tidak ditemukan"];
      }
      $result = mysqli_query($db, "DELETE FROM todos WHERE id ='$id'");
      if ($result) {
         return $todo->fetch_assoc();
      } else {
         return ["message" => "Gagal menghapus todo"];
      }
   } catch (\Throwable $th) {
      return ["message" => "$th"];
   }
}