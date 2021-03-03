<?php


namespace App\Controller;

use App\Entity\FirstComment;
use App\Form\FirstCommentType;
use App\Repository\FirstCommentRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class FirstCommentController extends BaseController
{
    /**
    * @var $FirstCommentRepositoryInterface
    */
    public $firstCommentRepository;

    public function __construct(FirstCommentRepositoryInterface $firstCommentRepository)
    {
        $this->firstCommentRepository = $firstCommentRepository;
    }

    /**
     * @Route ("api/comments", name="comments")
     * @param Request $request
     * @return Response
     */
    public function showCommentAction(Request $request)
    {
        $id=$request->get('id');
        $first_comments = $this->getDoctrine()->getRepository(FirstComment::class)->findAll();
        return $this->respond($first_comments);
    }

    /**
     * @Route ("api/comments/create", name="comments_create")
     * @param Request $request
     * @return Response
     */
    public function createCommentAction(Request $request)
    {
        $first_comment = new FirstComment();
        $form = $this->createForm(FirstCommentType::class, $first_comment);
        $form->submit($request->request->all());
        if (!$form->isValid())
        {
            return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }
        $this->firstCommentRepository->setCreate($first_comment);
        return $this->respond($first_comment);
    }
}