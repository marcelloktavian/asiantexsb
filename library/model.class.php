<?php
    class Model{
        public $db;
        protected $tableName;

        public function __construct(){
            $this->db = new Database();
        }

        public function model($modelName,$file){
            require_once ROOT.DS.'modules'.DS.$file.DS.'models'.DS.$modelName.'Model.php';
            $className = ucfirst($modelName).'Model';
            $this->$modelName = new $className();
        }

        public function get($params=""){
            $sql = " SELECT * FROM ".$this->$tableName;

            if(is_array($params)){
                if(isset($params['limit'])){
                    $sql .= " LIMIT ".$params['limits'];
                }
            }
            $this->db->query($sql);
            return $this->db->execute()->toObject();
        }

        public function rows(){
            return $this->db->getAll($this->tableName)->numRows();
        }

        public function getWhere($params){
            return $this->db->getWhere($this->tableName,$params)->toObject();
        }

        public function delete($Where = array()){
            return $this->db->delete($this->tableName,$Where);
        }

        public function getJoin($tableJoin,$params,$join = "JOIN", $where = ""){
            $sql = "SELECT * FROM ".$this->tableName;
            if(is_array($tableJoin)){
                foreach ($tableJoin as $table) {
                    $sql .= " ".$join." ".$table." ";
                }
            } else {
                $sql .= " ".$join." ".$tableJoin." ";
            }

            foreach($params as $key=>$value){
                $sql .=" ON ".$key." = ".$value." ";
            }
            if($Where && is_array($Where)){
                $sql .= " ".$key." ='".$value."' ";
                $i++;
                if($i<count($Where)){
                    $sql .=" AND ";
                }
            }
            $this->db->query($sql);

            return $this->db->execute()->toObject();

        }

        public function insert($data = array()){
            $insert = $this->db->insert($this->tableName,$data);
            if($insert){
                return true;
            }

            return false;
        }

        public function update($data = array(),$Where = array()){
            $update = $this->db->update($this->tableName,$data,$Where);
            if($update){
                return true;
            }

            return false;
        }

    }