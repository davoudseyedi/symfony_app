<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\User;
use App\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\DataFixtures\UserFixtures;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->CommentData() as [$content, $user, $video, $created_at]){

            $comment = new Comment();
            $user = $manager->getRepository(User::class)->find($user);
            $video = $manager->getRepository(Video::class)->find($video);

            $comment->setContent($content);
            $comment->setUser($user);
            $comment->setVideo($video);
            $comment->setCreatedAtForFixtures(new \DateTime($created_at));


            $manager->persist($comment);

        }

        $manager->flush();
    }


    private function CommentData(){
        return [
            ['Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque
             ante sollicitudin. Cras purus odio, vestibulum in vulputate at, 
             tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate
              fringilla. Donec lacinia congue felis in faucibus. ',1, 10,'2019-10-08 12:34:45'],
            ['Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque
             ante sollicitudin. Cras purus odio, vestibulum in vulputate at, 
             tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate
              fringilla. Donec lacinia congue felis in faucibus. ',3, 11,'2019-08-08 22:34:45'],
            ['Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque
             ante sollicitudin. Cras purus odio, vestibulum in vulputate at, 
             tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate
              fringilla. Donec lacinia congue felis in faucibus. ',2, 10,'2019-07-08 15:34:45'],
            ['Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque
             ante sollicitudin. Cras purus odio, vestibulum in vulputate at, 
             tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate
              fringilla. Donec lacinia congue felis in faucibus. ',1, 11,'2019-08-08 22:34:45'],
        ];
    }

    public function getDependencies(){
        return array(
            UserFixtures::class
        );
    }
}
