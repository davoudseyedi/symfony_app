<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $password_encoder)
    {
        $this->password_encoder = $password_encoder;


    }

    public function load(ObjectManager $manager)
    {

        foreach ($this->getUserData() as [$name , $lastname, $email, $password ,$api_key , $roles])
        {
            $user = new User();
            $user->setName($name);
            $user->setLastName($lastname);
            $user->setEmail($email);
            $user->setPassword($this->password_encoder->encodePassword($user,$password));
            $user->setVimeoApiKey($api_key);
            $user->setRoles($roles);
            $manager->persist($user);

        }

        $manager->flush();
    }


    private function getUserData(): array {
        return [
            ['John','Wayne','jw@symf4.loc','passw','hjd8dehdh',['ROLE_ADMIN']],
            ['John','Wayne2','jw2@symf4.loc','passw',null,['ROLE_ADMIN']],
            ['John','Doe','jw33@symf4.loc','passw',null,['ROLE_USER']],
        ];
    }
}
