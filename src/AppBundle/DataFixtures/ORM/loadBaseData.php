<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Category;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $categories = ['Categoría 1','Categoría 2','Categoría 3','Categoría 4'];

        foreach($categories as $cat) {
            $category = new Category();
            $category->setName($cat);
            $manager->persist($category);
        }
        $manager->flush();
    }
}