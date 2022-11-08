<?php
require_once (PATH_MODELS."DAO.php");
class LoginDAO extends DAO
{
    public function verifyUser(String $login, String $password){
        $result = false;
        ###On essaye les étudiants en premier
        $res = $this->queryRow('SELECT * FROM ETUDIANT WHERE loginEtu = ?', [$login]);

        if ($res){
            if (password_verify($password, $res['PASSWORD_HASH'])){

                $result = [
                    'logged' => 'etu',
                    'login' => $login,
                    'firstname' => $res['PRENOMETU'],
                    'lastname' => $res['NOMETU']];
            }
        } else {
            ###On essaye les profs
            $res = $this->queryRow('SELECT * FROM PROFESSEUR WHERE loginProf = ?', [$login]);
            if ($res) {
                if (password_verify($password, $res['PASSWORD_HASH'])) {
                    $result = [
                        'logged' => 'prof',
                        'login' => $login,
                        'firstname' => $res['PRENOMPROF'],
                        'lastname' => $res['NOMEPROF']];
                }
            } else {
                ###On essaye les admins
                $res = $this->queryRow('SELECT * FROM ADMIN WHERE loginadmin = ?', [$login]);
                if ($res) {
                    if (password_verify($password, $res['PASSWORD_HASH'])) {
                        $result = [
                            'logged' => 'admin',
                            'login' => $login
                        ];
                    }
                }
            }
        }
        return $result;
    }
}