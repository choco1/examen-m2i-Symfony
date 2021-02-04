<?php

namespace App\DataFixtures;

use App\Entity\Competence;
use App\Entity\Stagiaire;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;

class AppFixtures extends Fixture
{

    private $passwordEncoder;


    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {

        $faker = Faker\Factory::create("fr_FR");

        $user = new User();
        $user->setEmail('najwa.ciesielczyk@gmail.com');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'najwa1234'));
        $user->setRoles(['ROLE_ADMIN']);
        $this->addReference('user-0', $user);
        $manager->persist($user);

        $manager->flush();


        for($i = 1; $i < 15; $i++){
            $user = new User();
            $user->setEmail($faker->email);
            $user->setPassword($this->passwordEncoder->encodePassword($user, '12345678'));
            $user->setRoles(['ROLE_USER']);
            $this->addReference('user-'.$i, $user);

            $manager->persist($user);
        }

        for($i = 0; $i < 5; $i++){
            $competence = new Competence();
            $competence->setName($faker->title);

            $manager->persist($competence);
            $this->addReference('competence-'.$i, $competence);
        }


        for($i = 0; $i < 30; $i++){
            $stagiaire = new Stagiaire();
            $stagiaire->setName($faker->name);
            $stagiaire->setCreatedAt(new \DateTime());
            $stagiaire->setBirthday(null);
            for($j = 0; $j <10; $j++){
            $stagiaire->setPhone($faker->numberBetween(0, 9));
            }
            for($n = 0; $n <10; $n++){
                $stagiaire->setPhone($faker->numberBetween(0, 4));
            }
            for($a = 0; $a <4; $n++){
                $stagiaire->addCompetence($this->getReference('competence-'.rand(0, 3)));
            }
            $manager->persist($stagiaire);
            $this->addReference('stagiaire-'.$i, $stagiaire);

            $manager->persist($stagiaire);
        }

        $manager->flush();
    }
}
