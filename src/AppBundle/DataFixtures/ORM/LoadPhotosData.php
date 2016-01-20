<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Photo;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadPhotosData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $photo = new Photo();
        $photo->setTitle('First');
        $photo->setLink('1111.png');
        $manager->persist($photo);
        $manager->flush();

        $this->addReference('photo', $photo);
    }

    public function getOrder()
    {
        return 1;
    }
}