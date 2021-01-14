<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('alexandre.peneau@gmail.com');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'Ndombi75!'
        ));
        $birthday = "03-11-1988";
        $desired_length = 30; //or whatever length you want
        $unique = uniqid();

        $your_random_word = substr($unique, 0, $desired_length);
        $user->setIdSubscription($your_random_word);
        $user->setGender(false);
        $user->setBirthdate(new \DateTime($birthday));
        $user->setRoles(array("ROLE_ADMIN"));
        $manager->persist($user);

        $manager->flush();
    }
}
