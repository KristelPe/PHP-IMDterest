<?php

class Reported{
    private $m_userId;
    private $m_postId;

    /**
     * @return mixed
     */
    public function getMUserId()
    {
        return $this->m_userId;
    }

    /**
     * @param mixed $m_userId
     */
    public function setMUserId($m_userId)
    {
        $this->m_userId = $m_userId;
    }

    /**
     * @return mixed
     */
    public function getMPostId()
    {
        return $this->m_postId;
    }

    /**
     * @param mixed $m_postId
     */
    public function setMPostId($m_postId)
    {
        $this->m_postId = $m_postId;
    }

    public function Report(){
        $conn = Db::getInstance();
        $statement = $conn->prepare("select COUNT(*) from reported where postId = :postId and userId = :userId LIMIT 1");
        $statement->bindvalue(":postId", $this->m_postId);
        $statement->bindvalue(":userId", $this->m_userId);
        $statement->execute();

        //$result = $statement->fetch(PDO::FETCH_ASSOC);

        if($statement->fetchColumn()){
            echo "You have already reported this post!";
        }
        else{
            $stmnt = $conn->prepare("insert into reported (postId,userId) values (:postId,:userId)");
            $stmnt->bindvalue(":postId", $this->m_postId);
            $stmnt->bindvalue(":userId", $this->m_userId);
            $stmnt->execute();
            echo "You have successfully reported this post!";
        }



    }
}