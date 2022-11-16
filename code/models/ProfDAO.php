<?php
require_once (PATH_MODELS.'UserDAO.php');
class ProfDAO extends UserDAO
{
    public function getNames(){
        $res = $this->queryRow("SELECT PRENOMPROF, NOMPROF FROM PROFESSEUR WHERE loginprof = ?",  [$this->_username]);
        return $res;
    }

    public function getModule($ref){
        $data = $this->queryRow("SELECT NOMMODULE 
        FROM MODULE JOIN ENSEIGNER ON MODULE.REFMODULE = ENSEIGNER.REFMODULE
        WHERE LOGINPROF = ? AND MODULE.REFMODULE = ?", [$this->_username, $ref]);
        return $data;
    }
}
?>