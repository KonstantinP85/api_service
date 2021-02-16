<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepositoryInterface;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends BaseController
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserRepositoryInterface $userRepository, UserService $userService)
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }
    /**
     * @Route ("api/admin/users", name="users")
     * @return Response
     */
    public function indexAction()
    {
        $users = $this->userRepository->getAll();
        return $this->respond($users);
    }

    /**
     * @Route("api/user/create", name="user_create")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function createAction(Request $request)
    {
        $user= new User();
        $form = $this->createForm(UserType::class, $user);
        $form->submit($request->request->all());
        if (!$form->isValid())
        {
            return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }
        $this->userService->handleCreate($user);
        return $this->respond($user);
    }
}