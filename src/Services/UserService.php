<?php


namespace App\Services;


use App\Entity\User;
use App\Repository\UserRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;
    /**
     * @var MailerInterface
     */
    private $mailer;

    public function __construct(UserRepositoryInterface $userRepository, UserPasswordEncoderInterface $passwordEncoder, MailerInterface $mailer)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->mailer = $mailer;

    }

    /**
     * @param User $user
     * @return $this
     */
    public function handleCreate(User $user)
    {
        $password = $this->passwordEncoder->encodePassword($user, $user->getPassword());
        $user->setPassword($password);
        $user->setRoles(["ROLE_USER"]);
        $user->setActive();
        $this->userRepository->setCreate($user);
        return $this;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function handleUpdate(User $user)
    {
        $password = $this->passwordEncoder->encodePassword($user, $user->getPassword());
        $user->setPassword($password);
        $this->userRepository->setSave($user);
        return $this;
    }

    /**
     * @param $id
     * @return User|object
     */
    public function getUser($id)
    {
        $user = $this->userRepository->getOne($id);
        if(!$user) {
            throw new NotFoundHttpException('User not found');
        }
        return $user;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function banUser(User $user)
    {
        $user->setBan();
        $this->userRepository->setSave($user);
        return $this;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function unbanUser(User $user)
    {
        $user->setActive();
        $this->userRepository->setSave($user);
        return $this;
    }

    public function sendEmail(MailerInterface $mailer, $text, $user_email)
    {
        $email = (new Email())
            ->from('mailservices@gmail.com')
            ->to($user_email)
            ->subject('Information')
            ->text($text)
            ->html('<p>Some HTML</p>');
        $mailer->send($email);
    }

}