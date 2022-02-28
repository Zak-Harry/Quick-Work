<?php

namespace App\DataFixtures;


use App\Entity\Contract;
use App\Entity\Departement;
use App\Entity\DepartementJob;
use App\Entity\Documentation;
use App\Entity\EffectiveWorkDays;
use App\Entity\Job;
use App\Entity\Payslip;
use App\Entity\Permission;
use App\Entity\PlannedWorkDays;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;
use Doctrine\DBAL\Connection;

class AppFixtures extends Fixture
{

    private $connexion;

    public function __construct(Connection $connexion)
    {
        $this->connexion = $connexion;

    }
    
    // On sépare un peu notre code
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
        $this->connexion->executeQuery('TRUNCATE TABLE permission');
        $this->connexion->executeQuery('TRUNCATE TABLE planned_work_days');
        $this->connexion->executeQuery('TRUNCATE TABLE user');
        
    }

    public function load(ObjectManager $manager): void
    {
        
         // on vide les tables avant de commencer
         $this->truncate();
        
        // mis en place de faker
        $faker = Faker::create('fr_FR');

         // fonction pour générer une heure aléatoire :
         function randHours($minHour, $maxHour) {
            $firstHour = strtotime($minHour);
            $secondHour = strtotime($maxHour);
            return date('h:i', rand($firstHour, $secondHour));
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
        for ($i = 1; $i<= 20; $i++){    
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
        foreach ($departement as $departementName){    
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
        for ($i = 1; $i<= 20; $i++) {
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
        for ($i = 0; $i<= 20; $i++) {
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
       

        /************* Permission *************/
        $permission = ['ROLE_USER', 'ROLE_RH', 'ROLE_MANAGER'];
        $allPermission =[];
        
        foreach ($permission as $permissionName) {
        $newPermission = new Permission();
        $newPermission->setName($permissionName);
        $newPermission->setCreatedAt(new DateTime('now'));
        $allPermission[] = $newPermission;
        $manager->persist($newPermission);
        }

        /************* User *************/
        for ($i = 0; $i<= 20; $i++)
        {
            $newUser = new User();
            $newUser->setFirstname($faker->firstName());
            $newUser->setLastname($faker->lastName());
            $newUser->setPicture('https://boredhumans.b-cdn.net/faces2/'. rand(100, 400).'.jpg');
            $newUser->setEmail($faker->freeEmail());
            $newUser->setEmailpro(strtolower(trim($newUser->getFirstname() .'.'. $newUser->getLastname() . '@oclock.io')));
            $newUser->setPhonenumber($faker->mobileNumber());
            $newUser->setPhonenumberpro($faker->phoneNumber());
            $newUser->setPassword($newUser->getFirstname());
            $newUser->setAddress($faker->Address());
            $newUser->setZipcode($faker->postcode());
            $newUser->setCity($faker->city());
            $newUser->setRib($faker->iban('FR'));
            $newUser->setStatus(true);
            $newUser->setDateOfBirth($faker->dateTimeBetween('-60years', '-20years'));
            $newUser->setCreatedAt(new DateTime('now'));

            /*****Ajout de la permission *****/
            $randomPermission = $allPermission[rand(0, count($allPermission) -1)];
            $newUser->setPermission($randomPermission);

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
            $randomPlanned = $allPlanned[rand(0, count($allPlanned) -1)];
            $newUser->setPlannedWorkDays($randomPlanned);

             /*****Ajout du planning effectué*****/
             $newUser->setEffectiveWorkDays($allEffective[$i]);

    
            $manager->persist($newUser);

        }

        
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);


        $manager->flush();
    }
}
