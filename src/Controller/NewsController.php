<?php


namespace App\Controller;


use App\Entity\News;
use App\Form\NewsType;
use App\Repository\NewsRepositoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends BaseController
{
    /**
     * @var NewsRepositoryInterface
     */
    public $newsRepository;

    public function __construct(NewsRepositoryInterface $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }
    /**
     * @Route ("api/news", name="news")
     * @return Response
     */
    public function showNewsAction()
    {
        $news = $this->newsRepository->getAll();
        return $this->respond($news);
    }

    /**
     * @Route ("api/news/{id}", name="news_one")
     * @param Request $request
     * @return Response
     */
    public function showOneNewsAction(Request $request)
    {
        $news = $this->newsRepository->getOne($request->get('id'));
        return $this->respond($news);
    }

    /**
     * @Route ("api/admin/news/create", name="news_create")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function createUserAction(Request $request)
    {
        $news= new News();
        $form = $this->createForm(NewsType::class, $news);
        $form->submit($request->request->all());
        if (!$form->isValid())
        {
            return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }
        $this->newsRepository->setCreate($news);
        return $this->respond($news);
    }


}