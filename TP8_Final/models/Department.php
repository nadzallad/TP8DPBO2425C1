<?php
include_once("DB.php");
class Department extends DB
{
    // Mengambil semua data departemen.
    function getDepartments()
    {
        $query = "SELECT * FROM departments";
        return $this->execute($query);
    }

    
     //Mengambil data departemen berdasarkan ID.
    function getDepartmentById($id)
    {
        $query = "SELECT * FROM departments WHERE department_id = $id";
        return $this->execute($query);
    }

    // Menambahkan data departemen baru.
    function add($data)
    {
        $department_name = $data['department_name'];
        $department_code = $data['department_code'];
        $created_at = $data['created_at'];

        $query = "INSERT INTO departments (department_name, department_code, created_at) 
                  VALUES ('$department_name', '$department_code', '$created_at')";

        return $this->execute($query);
    }
    
    //Mengubah data departemen yang sudah ada.
    function update($id, $data)
    {
        $department_name = $data['department_name'];
        $department_code = $data['department_code'];
        $created_at = $data['created_at'];

        $query = "UPDATE departments SET 
                  department_name = '$department_name', 
                  department_code = '$department_code', 
                  created_at = '$created_at' 
                  WHERE department_id = $id";

        return $this->execute($query);
    }

    //Menghapus data departemen berdasarkan ID.
    function delete($id)
    {
        $query = "DELETE FROM departments WHERE department_id = $id";
        return $this->execute($query);
    }
}