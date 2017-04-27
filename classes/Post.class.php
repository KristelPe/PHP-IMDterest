<?php

class Post
{
    private $m_title;
    private $m_afbeelding;
    private $m_link;
    private $m_description;
    private $m_userId;
    private $m_board;
    private $m_postId;

    /**
     * @return mixed
     */
    public function getMBoard()
    {
        return $this->m_board;
    }

    /**
     * @param mixed $m_board
     */
    public function setMBoard($m_board)
    {
        $this->m_board = $m_board;
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
    public function getMTitle()
    {
        return $this->m_title;
    }

    /**
     * @param mixed $m_title
     */
    public function setMTitle($m_title)
    {
        $this->m_title = $m_title;
    }

    /**
     * @return mixed
     */
    public function getMAfbeelding()
    {
        return $this->m_afbeelding;
    }

    /**
     * @param mixed $m_afbeelding
     */
    public function setMAfbeelding($m_afbeelding)
    {
        $this->m_afbeelding = $m_afbeelding;
    }


    /**
     * @return mixed
     */
    public function getMLink()
    {
        return $this->m_link;
    }

    /**
     * @param mixed $m_link
     */
    public function setMLink($m_link)
    {
        $this->m_link = $m_link;
    }

    /**
     * @return mixed
     */
    public function getMDescription()
    {
        return $this->m_description;
    }

    /**
     * @param mixed $m_description
     */
    public function setMDescription($m_description)
    {
        $this->m_description = $m_description;
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
        $stmnt = $conn->prepare("
          insert into posts (title, userId, image, description, link, board, date) 
          values (:title, :userId, :afbeelding, :description, :link, :board, :date)");
        $stmnt->bindvalue(":userId", $this->m_userId);
        $stmnt->bindvalue(":title", $this->m_title);
        $stmnt->bindvalue(":afbeelding", $this->m_afbeelding);
        $stmnt->bindvalue(":description", $this->m_description);
        $stmnt->bindvalue(":link", $this->m_link);
        $stmnt->bindvalue(":board", $this->m_board);
        $stmnt->bindvalue(":date", date('Y-m-d'));
        $stmnt->execute();
    }

    public function Report()
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("select COUNT(*) from reported where postId = :postId and userId = :userId LIMIT 1");
        $statement->bindvalue(":postId", $this->m_postId);
        $statement->bindvalue(":userId", $this->m_userId);
        $statement->execute();

        //$result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($statement->fetchColumn()) {
            echo "You have already reported this post!";
        } else {
            $stmnt = $conn->prepare("insert into reported (postId,userId) values (:postId,:userId)");
            $stmnt->bindvalue(":postId", $this->m_postId);
            $stmnt->bindvalue(":userId", $this->m_userId);
            $stmnt->execute();
            echo "You have successfully reported this post!";
        }
    }
}
