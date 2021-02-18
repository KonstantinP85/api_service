<?php


namespace App\Services;


use App\Entity\User;
use App\Repository\UserRepositoryInterface;
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

    public function __construct(UserRepositoryInterface $userRepository, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
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

    public function banUser(User $user)
    {
        $user->setBan();
        $this->userRepository->setSave($user);
        return $this;
    }

    public function unbanUser(User $user)
    {
        $user->setActive();
        $this->userRepository->setSave($user);
        return $this;
    }

    public function sendEmail(MailerInterface $mailer)
    {
        $email = (new Email())
            ->from('pavlyukkonstantin85@gmail.com')
            ->to('pavlyukkonstantin85@gmail.com')
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');
        $mailer->send($email);
    }
}