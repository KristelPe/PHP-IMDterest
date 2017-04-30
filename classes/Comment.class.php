<?php

class Comment
{
    private $m_comment;
    private $m_userId;
    private $m_postId;
    private $commentId;

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

    /**
     * @return mixed
     */
    public function getCommentId()
    {
        return $this->commentId;
    }

    /**
     * @param mixed $commentId
     */
    public function setCommentId($commentId)
    {
        $this->commentId = $commentId;
    }





    public function UploadComment()
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
        $selectComments = $conn->prepare("select c.*, c.Id as cid, u.username as username, u.image as img from comments c inner join users u where u.id = c.userid and c.postId = :postId ORDER BY c.Id DESC ");
        $selectComments->bindvalue(":postId", $this->m_postId);
        $selectComments->execute();
        $res = $selectComments->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    public function showSubComments($comment){
        $conn = Db::getInstance();
        $selectSubComments = $conn->prepare("SELECT * FROM sub_comments sb INNER JOIN users u ON u.id = sb.userId WHERE commentId = :commentid");
        $selectSubComments->bindValue(":commentid", $comment);
        $selectSubComments->execute();
        $Subres = $selectSubComments->fetchAll(PDO::FETCH_ASSOC);
        return $Subres;
    }

    public function UploadSubComment()
    {
        $conn = Db::getInstance();


        $stmnt = $conn->prepare("insert into sub_comments (comment,userId,commentId) values (:comment,:userId, :commentId)");
        $stmnt->bindvalue(":comment", $this->m_comment);
        $stmnt->bindvalue(":userId", $this->m_userId);
        $stmnt->bindValue(":commentId",$this->commentId);
        $stmnt->execute();
    }
}
