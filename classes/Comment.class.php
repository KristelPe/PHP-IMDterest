<?php

class Comment{
    private $m_comment;

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
        $this->m_comment = $m_comment;
    }

    public function Upload(){
        $conn = Db::getInstance();

        $stmnt = $conn->prepare("insert into comments (comment) values (:comment)");
        $stmnt->bindvalue(":comment", $this->m_comment);
        $stmnt->execute();
    }
}