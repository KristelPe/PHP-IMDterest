<?php

class User
{
    private $m_firstname;
    private $m_lastname;
    private $m_username;
    private $m_email;
    private $m_password;

    /**
     * @return mixed
     */
    public function getMFirstname()
    {
        return $this->m_firstname;
    }

    /**
     * @param mixed $m_firstname
     */
    public function setMFirstname($m_firstname)
    {
        if($m_firstname==""){
            throw new Exception("Name can not be empty");
        }
        $this->m_firstname = $m_firstname;
    }

    /**
     * @return mixed
     */
    public function getMLastname()
    {
        return $this->m_lastname;
    }

    /**
     * @param mixed $m_lastname
     */
    public function setMLastname($m_lastname)
    {
        if($m_lastname==""){
            throw new Exception("Lastname can not be empty");
        }
        $this->m_lastname = $m_lastname;
    }

    /**
     * @return mixed
     */
    public function getMUsername()
    {
        return $this->m_username;
    }

    /**
     * @param mixed $m_username
     */
    public function setMUsername($m_username)
    {
        if($m_username==""){
            throw new Exception("Username can not be empty");
        }
        $this->m_username = $m_username;
    }

    /**
     * @return mixed
     */
    public function getMEmail()
    {
        return $this->m_email;
    }

    /**
     * @param mixed $m_email
     */
    public function setMEmail($m_email)
    {
        if (!filter_var($m_email, FILTER_VALIDATE_EMAIL) || $m_email=="") {
            throw new Exception("Email can not be empty");
        }
        $this->m_email = $m_email;
    }

    /**
     * @return mixed
     */
    public function getMPassword()
    {
        return $this->m_password;
    }

    /**
     * @param mixed $m_password
     */
    public function setMPassword($m_password)
    {
        if (!preg_match("#[0-9]+#", $m_password) || !preg_match("#[a-zA-Z]+#", $m_password) || strlen($m_password) < 6  || $m_password=="") {
            throw new Exception("Password can not be empty");
        }
        $this->m_password = $m_password;
    }

    public function Register(){
        $conn = Db::getInstance();

        $stmnt = $conn->prepare("insert into users (email, firstname, lastname, username, password) values (:email, :firstname, :lastname, :username, :password)");
        $stmnt->bindvalue(":email", $this->m_email);
        $stmnt->bindvalue(":firstname", $this->m_firstname);
        $stmnt->bindvalue(":lastname", $this->m_lastname);
        $stmnt->bindvalue(":username", $this->m_username);
        $stmnt->bindvalue(":password", $this->m_password);
        $res = $stmnt->execute();
        var_dump($res);
    }
}