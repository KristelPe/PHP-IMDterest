<?php

class UserVerify
{
    private $m_vEmail;
    private $m_vPassword;

    /**
     * @return mixed
     */
    public function getMVEmail()
    {
        return $this->m_vEmail;
    }

    /**
     * @param mixed $m_vEmail
     */
    public function setMVEmail($m_vEmail)
    {
        if ($m_vEmail == ""){
            throw new Exception("Username cannot be empty!");
        }
        $this->m_vEmail = $m_vEmail;
    }

    /**
     * @return mixed
     */
    public function getMVPassword()
    {
        return $this->m_vPassword;
    }

    /**
     * @param mixed $m_vPassword
     */
    public function setMVPassword($m_vPassword)
    {
        if ($m_vPassword == ""){
            throw new Exception("Password cannot be empty!");
        }
        $this->m_vPassword = $m_vPassword;
    }

    public function Verify(){
        // conn (PDO)
        $conn = Db::getInstance();

        // statement: SELECT query
        $statement = $conn->prepare("SELECT * FROM users WHERE email = :email ;");
        $statement->bindValue(":email", $this->m_vEmail);

        // execute statement
        $res = $statement->execute();

        // confirmation
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach( $results as $row ) {
            if (password_verify($this->m_vPassword, $row['password'])) {
                throw new Exception("OOPS looks like you've filled in the wrong username or password");
            } else {
                session_start();
                $_SESSION['email'] = $this->m_vEmail;
            }
        }

        return $res;
    }
}