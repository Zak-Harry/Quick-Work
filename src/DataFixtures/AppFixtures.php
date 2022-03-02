<?php

namespace App\DataFixtures;


use App\Entity\Contract;
use App\Entity\Departement;
use App\Entity\DepartementJob;
use App\Entity\Documentation;
use App\Entity\EffectiveWorkDays;
use App\Entity\Job;
use App\Entity\Payslip;
use App\Entity\Role;
use App\Entity\PlannedWorkDays;
use App\Entity\User;
use DateTime;
use DateTimeZone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;
use Doctrine\DBAL\Connection;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $connexion;
    private $hasher;

    public function __construct(Connection $connexion, UserPasswordHasherInterface $hasher)
    {
        $this->connexion = $connexion;
        $this->hasher = $hasher;
    }
    
    // On sépare un peu notre code

    /**
     * @throws Exception
     */
    private function truncate()
    {
        //  on désactive la vérification des FK
        // Sinon les truncate ne fonctionne pas.
        $this->connexion->executeQuery('SET foreign_key_checks = 0');

        // la requete TRUNCATE remet l'auto increment à 1
        $this->connexion->executeQuery('TRUNCATE TABLE contract');
        $this->connexion->executeQuery('TRUNCATE TABLE departement');
        $this->connexion->executeQuery('TRUNCATE TABLE departement_job');
        $this->connexion->executeQuery('TRUNCATE TABLE documentation');
        $this->connexion->executeQuery('TRUNCATE TABLE effective_work_days');
        $this->connexion->executeQuery('TRUNCATE TABLE job');
        $this->connexion->executeQuery('TRUNCATE TABLE payslip');
        $this->connexion->executeQuery('TRUNCATE TABLE role');
        $this->connexion->executeQuery('TRUNCATE TABLE planned_work_days');
        $this->connexion->executeQuery('TRUNCATE TABLE user');
    }

    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        
         // on vide les tables avant de commencer
        $this->truncate();
        
        // mis en place de faker
        $faker = Faker::create('fr_FR');

        // fonction pour générer une heure aléatoire :
        function randHours($minHour, $maxHour)
        {
            $firstHour = strtotime($minHour);
            $secondHour = strtotime($maxHour);
            return date('H:i', rand($firstHour, $secondHour));
        }
 
        // fonction pour supprimer les accents, enlever les espaces et mettre tout en minuscule
        function formatString($string): string
        {
            $search  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
            $replace = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');
            return strtolower(str_replace(' ','',str_replace($search, $replace, $string)));
        }

        /************* Payslip *************/
        $allPayslip = [];
        for ($i = 1; $i<= 200; $i++) {
            $newPayslip = new Payslip();
            $newPayslip->setLink('http://extranet-rh.lexisnexis.fr/wp-content/uploads/Documents/LIRE-UN-BULLETIN-DE-PAIE.pdf');
            $newPayslip->setCreatedAt(new DateTime('now'));
            $allPayslip[] = $newPayslip;
            $manager->persist($newPayslip);
        }

        /************* Documentation *************/
        $allDocumentation = [];
        for ($i = 1; $i<= 80; $i++) {
            $newDocumentation = new Documentation();
            $newDocumentation->setLink('https://www.conseil-constitutionnel.fr/node/3850/pdf');
            $newDocumentation->setCreatedAt(new DateTime('now'));
            $allDocumentation[] = $newDocumentation;
            $manager->persist($newDocumentation);
        }

        /************* Contract *************/
        $allContract = [];
        for ($i = 1; $i<= 80; $i++) {
            $newContract = new Contract();
            $newContract->setLink('https://www.pajemploi.urssaf.fr/pajewebinfo/files/live/sites/pajewebinfo/files/contributed/pdf/employeur_ama/2377-PAJE-CDI-AMA.pdf');
            $newContract->setCreatedAt(new DateTime('now'));
            $allContract[] = $newContract;
            $manager->persist($newContract);
        }

        /************* Job *************/
        $allJob = [];
        $grade = ['Cadre', 'Agent de maitrise', 'autre'];
        for ($i = 1; $i<= 20; $i++) {
            $newJob = new Job();
            $newJob->setName($faker->jobTitle());
            $newJob->setGrade($grade[rand(0, count($grade)-1)]);
            $newJob->setCreatedAt(new DateTime('now'));
            $allJob[] = $newJob;
            $manager->persist($newJob);
        }

        /************* Departement *************/
        $allDepartement = [];
        $departement = ['Ressources Humaines', 'Comptabilité', 'Marketing', 'Informatique', 'Financier'];
        foreach ($departement as $departementName) {
            $newDepartement = new Departement();
            $newDepartement->setName($departementName);
            $newDepartement->setCreatedAt(new DateTime('now'));
            $allDepartement[] = $newDepartement;
            $manager->persist($newDepartement);
        }

        /************* DepartementJob *************/
        $allDepartementJob = [];
        foreach ($allJob as $job) {
            for ($i = 1; $i<= count($allJob); $i++) {
                $newDepartementJob = new DepartementJob;
                $randomJob = $allJob[rand(0, count($allJob) -1)];
                $randomDepartement = $allDepartement[rand(0, count($allDepartement) -1)];
                
                $newDepartementJob->setJob($randomJob);
                $newDepartementJob->setDepartement($randomDepartement);
                $allDepartementJob[] = $newDepartementJob;
                $manager->persist($newDepartementJob);
            }
        }
         
        /************* PlannedWorkDays *************/
        $allPlanned = [];
        for ($i = 1; $i<= 200; $i++) {
            $newPlanned = new PlannedWorkDays;
            $newPlanned->setStartshift(new DateTime(randHours('08:00', '10:00')));
            $newPlanned->setStartlunch(new DateTime(randHours('12:00', '12:30')));
            $newPlanned->setEndlunch(new DateTime(randHours('12:30', '13:30')));
            $newPlanned->setEndshift(new DateTime(randHours('16:30', '18:30')));
            // calcul de la pause déjeuner
            $lunchBreak = new DateTime($newPlanned->getStartlunch()->diff($newPlanned->getEndlunch())->format('%h:%i'));
            //calcul de la journée de travail
            $workDay = new DateTime($newPlanned->getStartshift()->diff($newPlanned->getEndshift())->format('%h:%i'));
            //on peux donc obentir maintenant le nombre d'ehures travaillée dans la journée sans la pause déjeuner
            $newPlanned->setHoursplanned(new DateTime(($workDay)->diff($lunchBreak)->format('%h:%i')));
            $newPlanned->setCreatedAt(new DateTime('now'));
            $allPlanned[] = $newPlanned;

            $manager->persist($newPlanned);
        }

        /************* EffetiveWorkDays *************/
        $allEffective = [];
        for ($i = 0; $i<= 200; $i++) {
            $newEffective = new EffectiveWorkDays;
            $newEffective->setStartlog(new DateTime(randHours('08:00', '10:00')));
            $newEffective->setStartlunch(new DateTime(randHours('12:00', '12:30')));
            $newEffective->setEndlunch(new DateTime(randHours('12:30', '13:30')));
            $newEffective->setEndlog(new DateTime(randHours('16:30', '18:30')));
            // calcul de la pause déjeuner
            $lunchBreak = new DateTime($newEffective->getStartlunch()->diff($newEffective->getEndlunch())->format('%h:%i'));
            //calcul de la journée de travail
            $workDay = new DateTime($newEffective->getStartlog()->diff($newEffective->getEndlog())->format('%h:%i'));
            //on peux donc obentir maintenant le nombre d'ehures travaillée dans la journée sans la pause déjeuner
            $newEffective->setHoursworked(new DateTime(($workDay)->diff($lunchBreak)->format('%h:%i')));
            $newEffective->setCreatedAt(new DateTime('now'));
            $allEffective[] = $newEffective;

            $manager->persist($newEffective);
        }
       

        /************* Role *************/
        $role = ['ROLE_USER', 'ROLE_RH', 'ROLE_MANAGER'];
        $allRole =[];
        
        foreach ($role as $roleName) {
            $newRole = new Role();
            $newRole->setName($roleName);
            $newRole->setCreatedAt(new DateTime('now'));
            $allRole[] = $newRole;
            $manager->persist($newRole);
        }

        /************* User *************/
        for ($i = 0; $i<= 20; $i++) {
            $newUser = new User();
            $newUser->setFirstname($faker->firstName());
            $newUser->setLastname($faker->lastName());
            $newUser->setPicture('https://boredhumans.b-cdn.net/faces2/'. rand(100, 400).'.jpg');
            $newUser->setEmail($faker->freeEmail());
            $newUser->setEmailpro(formatString(($newUser->getFirstname() .'.'. $newUser->getLastname() . '@oclock.io')));
            $newUser->setPhonenumber($faker->mobileNumber());
            $newUser->setPhonenumberpro($faker->phoneNumber());
            $newUser->setAddress($faker->Address());
            $newUser->setZipcode($faker->postcode());
            $newUser->setCity($faker->city());
            $newUser->setRib($faker->iban('FR'));
            $newUser->setStatus(true);
            $newUser->setDateOfBirth($faker->dateTimeBetween('-60years', '-20years'));
            $newUser->setCreatedAt(new DateTime('now'));

            //hashage du password
            // le mdp est le prénom en minuscule sans accent
            $hashedPassword = $this->hasher->hashPassword($newUser,formatString($newUser->getFirstname()));
            $newUser->setPassword($hashedPassword);

            /*****Ajout du role *****/
            $randomRole = $allRole[rand(0, count($allRole) -1)];
            $newUser->setRole($randomRole);

            /*****Ajout du contrat *****/
            // On ajoute de 1 à 3 contrats au hasard pour chaque user
            for ($g = 1; $g <= mt_rand(1, 3); $g++) {
                $randomContract = $allContract[rand(0, count($allContract) -1)];
                $newUser->addContract($randomContract);
            }
             

            /*****Ajout des fiches de paie*****/
            // On ajoute de 1 à 24 fiche de paie au hasard pour chaque user
            for ($g = 1; $g <= mt_rand(1, 24); $g++) {
                $randomPayslip = $allPayslip[rand(0, count($allPayslip) -1)];
                $newUser->addPayslip($randomPayslip);
            }

            /*****Ajout des documentations*****/
            // On ajoute de 1 à 24 documents au hasard pour chaque user
            for ($g = 1; $g <= mt_rand(1, 24); $g++) {
                $randomDocumentation = $allDocumentation[rand(0, count($allDocumentation) -1)];
                $newUser->addDocumentation($randomDocumentation);
            }
             
        
            /*****Ajout de l'emploi*****/
            $randomJob = $allJob[rand(0, count($allJob) -1)];
            $newUser->setJob($randomJob);

            /*****Ajout du département*****/
            $randomDepartement = $allDepartement[rand(0, count($allDepartement) -1)];
            $newUser->setDepartement($randomDepartement);

            /*****Ajout du planning prévu *****/
            // On ajoute de 5 plannings au hasard pour chaque user
            for ($g = 0; $g <= 5; $g++) {
                $newUser->addPlannedWorkDay($allPlanned[$g]);
            }
            
             /*****Ajout du planning effectué *****/
            // On ajoute de 5 plannings au hasard pour chaque user
            for ($g = 0; $g <= 5; $g++) {
                $newUser->addEffectiveWorkDay($allEffective[$g]);
            }

            $manager->persist($newUser);
        }
        $manager-> flush();
    }
    
}
        
