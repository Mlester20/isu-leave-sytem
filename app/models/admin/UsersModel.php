<?php
require_once __DIR__ . '/../BaseModel.php';

    class UsersModel extends BaseModel{
        protected $users = 'users';

        public function index(){
            try{
                $query = "SELECT id, full_name, email, role, vacation_leave, sick_leave FROM {$this->users}";
                $stmt = $this->con->prepare($query);
                $stmt->execute();
                $result = $stmt->get_result();
                $users = [];

                while($row = $result->fetch_assoc()){
                    $users[] = $row;
                }
                return $users;
            }catch(Exception $e){
                echo "Error fetching users: " . $e->getMessage();
            }
        }

        public function create($data){
            try{
                $query = "INSERT INTO {$this->users} (employee_no, full_name, email, password, role, department, vacation_leave, sick_leave) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->con->prepare($query);
                
                if(!$stmt){
                    throw new Exception("Prepare failed: " . $this->con->error);
                }

                $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
                
                $stmt->bind_param(
                    "ssssssii",
                    $data['employee_no'],
                    $data['full_name'],
                    $data['email'],
                    $hashedPassword,
                    $data['role'],
                    $data['department'],
                    $data['vacation_leave'],
                    $data['sick_leave']
                );

                if(!$stmt->execute()){
                    throw new Exception("Execute failed: " . $stmt->error);
                }

                return true;
            } catch(Exception $e){
                throw $e;
            }
        }

        public function update($id, $data){
            try{
                $query = "UPDATE {$this->users} SET full_name = ?, email = ?, role = ?, department = ?, vacation_leave = ?, sick_leave = ? WHERE id = ?";
                $stmt = $this->con->prepare($query);
                
                if(!$stmt){
                    throw new Exception("Prepare failed: " . $this->con->error);
                }

                $stmt->bind_param(
                    "sssssii",
                    $data['full_name'],
                    $data['email'],
                    $data['role'],
                    $data['department'],
                    $data['vacation_leave'],
                    $data['sick_leave'],
                    $id
                );

                if(!$stmt->execute()){
                    throw new Exception("Execute failed: " . $stmt->error);
                }

                return true;
            } catch(Exception $e){
                throw $e;
            }
        }

        public function delete($id){
            try{
                $query = "DELETE FROM {$this->users} WHERE id = ?";
                $stmt = $this->con->prepare($query);
                
                if(!$stmt){
                    throw new Exception("Prepare failed: " . $this->con->error);
                }

                $stmt->bind_param("i", $id);

                if(!$stmt->execute()){
                    throw new Exception("Execute failed: " . $stmt->error);
                }

                return true;
            } catch(Exception $e){
                throw $e;
            }
        }
    }

?>