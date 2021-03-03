<?php


namespace App\Repository;


use App\Entity\FirstComment;

interface FirstCommentRepositoryInterface
{
    /**
     * @param FirstComment $first_comment
     * @return mixed
     */
    public function setCreate(FirstComment $first_comment);
}