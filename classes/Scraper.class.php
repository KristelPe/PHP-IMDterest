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
        $html = file_get_html($this->link);
        if ($html->find('title', 0)){
            $pagetitle = $html->find('title', 0);
            return $pagetitle->plaintext;
        }else{
            return "No Title Found!";
        }
    }

    public function scrapeImg(){
        $html = file_get_html($this->link);
        if ($html->find('img', 0)){
            $image = $html->find('img', 0);
            return $image->src;
        }else{
            return "No Image Found!";
        }
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