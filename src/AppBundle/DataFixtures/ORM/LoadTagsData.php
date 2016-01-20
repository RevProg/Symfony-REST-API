<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Tag;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadTagsData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $tag = new Tag();
        $tag->setName('Photo');
        $manager->persist($tag);

        $anotherTag = new Tag();
        $anotherTag->setName('Second');
        $manager->persist($anotherTag);

        $photo = $this->getReference('photo');
        $photo->addTag($tag);
        $photo->addTag($anotherTag);

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}