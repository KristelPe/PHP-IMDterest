<?php

/**
 * Created by PhpStorm.
 * User: gebruiker
 * Date: 29/04/2017
 * Time: 17:35
 */
class Scraper
{
    private $link;

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $link
     */
    
    public function SetLink($link)
    {
        $this->link = $link;
    }

    public function ScrapeTitle(){

    }

    public function scrapeImg(){

    }

    public function ScrapeDesc(){

    }

    /*
        $html = file_get_html($p['link']);
        $pagetitle = $html->find('title', 0);
        $image = $html->find('img', 0);

        $pagetitle->plaintext
        $image->src
    */
}