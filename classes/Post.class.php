<?php

class Post
{
    private $m_title;
    private $m_afbeelding;
    private $m_link;
    private $m_description;
    private $m_userId;

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

    public function Upload(){
        $conn = Db::getInstance();

        $stmnt = $conn->prepare("insert into posts (title, image, description, userId, link) values (:title, :afbeelding, :description, :userId, :link)");
        $stmnt->bindvalue(":title", $this->m_title);
        $stmnt->bindvalue(":afbeelding", $this->m_afbeelding);
        $stmnt->bindvalue(":description", $this->m_description);
        $stmnt->bindvalue(":userId", $this->m_userId);
        $stmnt->bindvalue(":link", $this->m_link);
        $stmnt->execute();
    }
}