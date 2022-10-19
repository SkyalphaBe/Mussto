<?php
require_once (PATH_MODELS."DAO.php");
class LoginDAO extends DAO
{
    public function verifyUser(String $login, String $password){
        $result = false;

        ###On essaye les étudiants en premier
        $res = $this->queryRow('SELECT loginEtu, password_hash FROM ETUDIANT WHERE loginEtu = ?', [$login]);
        if ($res){
            if (password_verify($password, $res['password_hash'])){
                $result = 'etu';
            }
        } else {
            ###On essaye les profs
            $res = $this->queryRow('SELECT loginProf, password_hash FROM PROFESSEUR WHERE loginProf = ?', [$login]);
            if ($res) {
                if (password_verify($password, $res['password_hash'])) {
                    $result = 'prof';
                }
            } else {
                ###On essaye les admins
                $res = $this->queryRow('SELECT loginAdmin, password_hash FROM ADMIN WHERE loginadmin = ?', [$login]);
                if ($res) {
                    if (password_verify($password, $res['password_hash'])) {
                        $result = 'admin';
                    }
                }
            }
        }

        return $result;
    }
}