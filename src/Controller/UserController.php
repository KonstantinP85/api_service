<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepositoryInterface;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
    public function showUsersAction()
    {
        $users = $this->userRepository->getAll();
        return $this->respond($users);
    }

    /**
     * @Route ("api/admin/user/{id}", name="user")
     * @param Request $request
     * @return Response
     */
    public function showOneUserAction(Request $request)
    {
        $user = $this->userRepository->getOne($request->get('id'));
        return $this->respond($user);
    }

    /**
     * @Route("api/user/create", name="user_create")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function createUserAction(Request $request)
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
        /**
     * @Route ("api/user/{id}/update", name="user_update")
     * @param Request $request
     * @return Response
     */
    public function updateUserAction(Request $request)
    {
        $user = $this->userRepository->getOne($request->get('id'));
        if(!$user) {
            throw new NotFoundHttpException('User not found');
        }
        $form = $this->createForm(UserType::class, $user);
        $form->submit($request->request->all());
        if (!$form->isValid()) {
            return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }
        $this->userService->handleUpdate($user);
        return $this->respond($user);
    }

    /**
     * @Route ("api/user/{id}/delete", name="user_delete")
     * @param Request $request
     * @return Response
     */
    public function deleteUserAction(Request $request)
    {
        $user = $this->userRepository->getOne($request->get('id'));
        if(!$user) {
            throw new NotFoundHttpException('User not found');
        }
        $this->userRepository->setDeleteUser($user);
        return $this->respond(null);
    }

    /** Ban on posting comments
     * @Route ("api/admin/user/{id}/ban", name="user_ban")
     * @param Request $request
     * @return Response
     */
    public function banUserAction(Request $request)
    {
        $user = $this->userRepository->getOne($request->get('id'));
        if(!$user) {
            throw new NotFoundHttpException('User not found');
        }
        $this->userService->banUser($user);
        return $this->respond($user);
    }

    /** Removed the ban on posting comments
     * @Route ("api/admin/user/{id}/unban", name="user_unban")
     * @param Request $request
     * @return Response
     */
    public function unbanUserAction(Request $request)
    {
        $user = $this->userRepository->getOne($request->get('id'));
        if(!$user) {
            throw new NotFoundHttpException('User not found');
        }
        $this->userService->unbanUser($user);
        return $this->respond($user);
    }


}