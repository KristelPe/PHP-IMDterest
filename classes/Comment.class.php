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

    public function showComments(){
        $conn = Db::getInstance();
        $selectComments = $conn->prepare("select c.*, u.username as username, u.image as img from comments c inner join users u where u.id = c.userid and c.postId = :postid ORDER BY c.Id DESC ");
        $selectComments->bindvalue(":postId", $this->m_postId);
        $selectComments->execute();
        $res = $selectComments->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }
}
