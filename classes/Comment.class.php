<?php

class Comment
{
    private $m_comment;
    private $m_userId;
    private $m_postId;

    /**
     * @return mixed
     */
    public function getMComment()
    {
        return $this->m_comment;
    }

    /**
     * @param mixed $m_comment
     */
    public function setMComment($m_comment)
    {
        if ($m_comment=="") {
            throw new Exception("Comment can not be empty");
        }
        $this->m_comment = $m_comment;
    }

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



    public function Upload()
    {
        $conn = Db::getInstance();

        $stmnt = $conn->prepare("insert into comments (comment,postId,userId) values (:comment,:postId,:userId)");
        $stmnt->bindvalue(":comment", $this->m_comment);
        $stmnt->bindvalue(":postId", $this->m_postId);
        $stmnt->bindvalue(":userId", $this->m_userId);
        $stmnt->execute();
    }
}
