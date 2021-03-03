<?php


namespace App\Controller;


use App\Entity\Comments;
use App\Form\CommentsType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentsController extends BaseController
{
    /**
     * @Route ("api/comment", name="comment")
     * @return Response
     */
    public function showCommentsAction()
    {
        $comments = $this->getDoctrine()->getRepository(Comments::class)->findAll();
        return $this->respond($comments);
    }

    /**
     * @Route ("api/comment/create", name="comment_create")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function createCommentsAction(Request $request)
    {
        $comments = new Comments();
        $form = $this->createForm(CommentsType::class, $comments);
        $form->submit($request->request->all());
        if (!$form->isValid())
        {
            return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }
        $this->getDoctrine()->getManager()->persist($comments);
        $this->getDoctrine()->getManager()->flush();
        return $this->respond($comments);
    }
}