<?php

namespace App\Article\Event;

use App\Article\Entity\Article;

class ArticleEvent
{
    /** @var Article $article */
    protected $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * @return Article
     */
    public function getArticle(): Article
    {
        return $this->article;
    }
}
