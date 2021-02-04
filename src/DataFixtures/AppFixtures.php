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

        for($j = 0; $j < 5; $j++){
            $competence = new Competence();
            $competence->setName($faker->title);

            $manager->persist($competence);
            $this->addReference('competence-'.$j, $competence);
        }


        for($n = 0; $n < 30; $n++){
            $stagiaire = new Stagiaire();
            $stagiaire->setName($faker->name);
            $stagiaire->setCreatedAt(new \DateTime());
            $stagiaire->setBirthday(null);
            $stagiaire->setPhone($faker->phoneNumber);
            $stagiaire->setCodePostal($faker->numberBetween(round(0, 6)));
            for($a = 0; $a <4; $a++){
                $stagiaire->addCompetence($this->getReference('competence-'.rand(0, 3)));
            }
            $manager->persist($stagiaire);
            $this->addReference('stagiaire-'.$n, $stagiaire);

            $manager->persist($stagiaire);
        }

        $manager->flush();
    }
}
