<?php
require_once __DIR__ . '/../BaseModel.php';

    class DepartmentModel extends BaseModel{
        protected $departments = 'departments';

        public function index(){
            try{
                $query = "SELECT * FROM {$this->departments} ORDER BY id ASC";
                $stmt = $this->con->prepare($query);
                $stmt->execute();
                $result = $stmt->get_result();
                $departments = [];

                while($row = $result->fetch_assoc()){
                    $departments[] = $row;
                }
                return $departments;
                exit();
            }catch(Exception $e){
                echo "Error fetching departments: " . $e->getMessage();
                return [];
            }
        }

        public function create($data){
            try{
                $query = "INSERT INTO {$this->departments} (department_name) VALUES (?)";
                $stmt = $this->con->prepare($query);

                // Check if prepare() succeeded
                if(!$stmt){
                    throw new Exception("Prepare failed: " . $this->con->error);
                }

                $stmt->bind_param(
                    "s",
                    $data['department_name']
                );

                if(!$stmt->execute()){
                    throw new Exception("Execute failed: " . $stmt->error);
                }
                // Return true on success
                return true;
            }catch(Exception $e){
                echo "Error creating department: " . $e->getMessage();
            }
        }

        public function update($id, $data){
            try{
                $query = "UPDATE {$this->departments} SET department_name = ? WHERE id = ?";
                $stmt = $this->con->prepare($query);

                if(!$stmt){
                    throw new Exception("Prepare failed: " . $this->con->error);
                }

                $stmt->bind_param(
                    "si",
                    $data['department_name'],
                    $id
                );

                if(!$stmt->execute()){
                    throw new Exception("Execute failed: " . $stmt->error);
                }
                return true;
            }catch(Exception $e){
                echo "Error updating department: " . $e->getMessage();
            }
        }

        public function delete($id){
            try{
                $query = "DELETE FROM {$this->departments} WHERE id = ?";
                $stmt = $this->con->prepare($query);

                if(!$stmt){
                    throw new Exception("Prepare failed: " . $this->con->error);
                }

                $stmt->bind_param("i", $id);

                if(!$stmt->execute()){
                    throw new Exception("Execute failed: " . $stmt->error);
                }
                return true;
            }catch(Exception $e){
                echo "Error deleting department: " . $e->getMessage();
            }
        }
    }

?>