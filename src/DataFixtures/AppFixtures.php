<?php

namespace App\DataFixtures;

use App\Entity\News;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\UserPassportInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $generator =  Faker\Factory::create("fr_FR");
        for($i =0; $i < 20; $i++)
        {
            $user = new User();
            $password = $this->encoder->encodePassword($user, 'password');
            $user
                ->setFirstName($generator->firstName())
                ->setLastName($generator->lastName)
                ->setEmail($generator->email)
                ->setPassword($password);
             $manager->persist($user);
             for($j = 0; $j < rand (10,50); $j++){
                 $news = new News();
                 $news
                 ->setTitle($generator->sentence)
                 ->setContent($generator->text()) 
                 ->setStatus(
                     $generator->randomElement(['DRAFT', 'PUBLISHED', 'DELETED'])
                 )
                 ->setCreatedAt($generator->dateTimeBetween('-1 year', 'now'))
                 ->setUser($user);
                $manager->persist($news);
            }
        }
        $manager->flush();
    }
}
