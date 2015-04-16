<?php



namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Book;
use Cocur\Slugify\Slugify;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class LoadBook implements  FixtureInterface{

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em)
    {
        $faker = Factory::create("fr_CA");
        $slug = Slugify::create();
        for ($i=0; $i < 300; $i++) {
            $newBook= new Book();
            $newBook->setTitle($faker->catchPhrase);
            $newBook->setAuthor($faker->name);
            $newBook->setIsbn($faker->ean13);
            $newBook->setDatePublished($faker->dateTimeThisCentury($max = 'now'));
            $newBook->setSummary($faker->realText);
            $newBook->setSlug($slug->slugify($newBook->getTitle()));

            $em->persist($newBook);
        }
        $em->flush();
    }
}