<?php
require_once (PATH_MODELS.'UserDAO.php');
class ProfDAO extends UserDAO
{
    public function getNames(){
        $res = $this->queryRow("SELECT PRENOMPROF FROM PROFESSEUR WHERE loginprof = ?",  [$this->_username]);
        return $res;
    }
    public function getModule($ref){
        $data = $this->queryRow("SELECT NOMMODULE 
        FROM MODULE JOIN ENSEIGNER ON MODULE.REFMODULE = ENSEIGNER.REFMODULE
        WHERE LOGINPROF = ? AND MODULE.REFMODULE = ?", [$this->_username, $ref]);
        return $data;
    }

    public function getGroups($UE){
        $data = [];
        $result=$this->queryAll("select INTITULEGROUPE
        from GROUPE
        join PARTICIPER using(INTITULEGROUPE)
        where REFMODULE = ?",[$UE]);
        foreach ($result as $line){
            $data[] = $line['INTITULEGROUPE'];
        }
        return $data;
    }
    public function getModules(){
        $result = $this->queryAll("select NOMMODULE,REFMODULE
        from MODULE
        join ENSEIGNER using(REFMODULE)
        where LOGINPROF = ?",[$this->_username]);
        $i = 0;
        foreach ($result as $module){
            $group = $this->getGroups($module['REFMODULE']);
            if ($group){
                $result[$i]['GROUPS'] = $group;
            }
            $i++;
        }
        return $result;
    }
}
?>