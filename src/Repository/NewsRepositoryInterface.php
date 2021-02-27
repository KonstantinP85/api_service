<?php


namespace App\Repository;


use App\Entity\News;

interface NewsRepositoryInterface
{
    /**
     * @param News $news
     * @return mixed
     */
    public function setCreate(News $news);

    /**
     * @param News $news
     * @return mixed
     */
    public function setSave(News $news);

    /**
     * @param int $newsId
     * @return object
     */
    public function getOne(int $newsId): object;

    /**
     * @return array
     */
    public function getAll(): array;

    /**
     * @param News $news
     * @return object
     */
    public function setUpdateNews(News $news): object;

    /**
     * @param News $news
     */
    public function setDeleteNews(News $news);
}