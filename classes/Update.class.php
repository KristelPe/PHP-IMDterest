<?php

include_once('User.class.php');

class Update extends User
{
    protected $sessionUser;

    /**
     * @return mixed
     */
    public function getSessionUser()
    {
        return $this->sessionUser;
    }

    /**
     * @param mixed $sessionUser
     */
    public function setSessionUser($sessionUser)
    {
        $this->sessionUser = $sessionUser;
    }

    public function prevUsername(){
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT username FROM users WHERE email = :email");
        $statement->bindvalue(":email", $this->sessionUser);
        $statement->execute();
        $username = $statement->fetchColumn();
        return $username;
    }

    public function prevPassword(){
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT password FROM users WHERE email = :email");
        $statement->bindvalue(":email", $this->sessionUser);
        $statement->execute();
        $password = $statement->fetchColumn();
        return $password;
    }

    public function newUsername($username){
        $conn = Db::getInstance();
        $stmnt = $conn->prepare("UPDATE users SET username = REPLACE(username, '$username', '$this->m_username') WHERE INSTR(username, '$username') > 0;");
        $res = $stmnt->execute();
        return $res;
    }

    public function newPassword($password){
        $conn = Db::getInstance();
        $stmnt = $conn->prepare("UPDATE users SET password = REPLACE(password, '$password', '$this->m_password') WHERE INSTR(password, '$password') > 0;");
        $res = $stmnt->execute();
        return $res;
    }

    public function newEmail($email){
        $conn = Db::getInstance();
        $statement = $conn->prepare("UPDATE users SET email = REPLACE(email, '$email', '$this->m_email') WHERE INSTR(email, '$email') > 0;");
        $res = $statement->execute();
        return $res;
    }

    public function newImg($email, $target_file){
        $conn = Db::getInstance();
        $statement = $conn->prepare("UPDATE users SET image = '$target_file' WHERE email = :email");
        $statement->bindvalue(":email", $email);
        $res = $statement->execute();
        return $res;
    }

    public function userId(){
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT id FROM users WHERE email = :email");
        $statement->bindvalue(":email", $this->sessionUser);
        $statement->execute();
        $userid = $statement->fetchColumn();

        return $userid;
    }
}