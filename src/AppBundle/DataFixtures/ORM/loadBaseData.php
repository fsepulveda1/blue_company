<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Category;
use AppBundle\Entity\Tag;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $categories = ['Alimentos','Electrónica y Computación','Electrodomésticos','Otros'];

        $id = 1;
        foreach($categories as $cat) {
            $category = new Category();
            $category->setId($id);
            $category->setName($cat);
            $manager->persist($category);
            $id ++;
        }

        $manager->flush();
    }
}