<?php
/**
 * Created by PhpStorm.
 * User: meike
 * Date: 04.09.2018
 * Time: 09:25
 */

namespace App\DataFixtures;


use App\Entity\TodoItem;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TodoAppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $dummyUser1 = new User();
        $dummyUser1->setEmail('test@test.com');
        $dummyUser1->setUserName('tester');
        $dummyUser1->setPassword(password_hash('test_password', PASSWORD_BCRYPT));
        $manager->persist($dummyUser1);

        $dummyUser2 = new User();
        $dummyUser2->setEmail('test1@test.com');
        $dummyUser2->setUserName('tester1');
        $dummyUser2->setPassword(password_hash('test_password1', PASSWORD_BCRYPT));
        $manager->persist($dummyUser2);

        $itemDescriptions_user = array(
            "Buy some veggies",
            "Buy train ticket",
            "Write essays",
            "Call mum",
            "Arrange meeting with Mr X",
            "Water the flowers"
        );

        for ($i = 0; $i < 6; $i++)
        {
            $todoItem = new TodoItem();
            $todoItem->setDescription($itemDescriptions_user[$i]);
            $todoItem->setDueDate(new \DateTime());
            $todoItem->setIsDone(false);
            $todoItem->setOwner($dummyUser1);
            $todoItem->setOwner($i % 2 ? $dummyUser1 : $dummyUser2);

            $manager->persist($todoItem);
        }

        $manager->flush(); //signals to doctrine that all database-options shall be executed
    }
}