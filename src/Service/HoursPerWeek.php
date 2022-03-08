<?php 

namespace App\Service;

use App\Entity\User;

Class HoursPerWeek 
{
   /**
     * Calculate total hours Planned per Week
     *
     * @return string
     */
    public function hoursPerWeek(User $user)
    {
        // function pour calculer le total de heures de la semaine
        function hoursToSeconds($duration){
            $array_duration=explode(":",$duration);
            $seconds=3600*$array_duration[0]+60*$array_duration[1];
            return $seconds;
        }

        function totalHours($seconds){
            $s=$seconds % 60; //reste de la division en minutes => secondes
            $m1=($seconds-$s) / 60; //minutes totales
            $m=$m1 % 60;//reste de la division en heures => minutes
            $h=($m1-$m) / 60; //heures
            $resultat=$h."h".$m;
            return $resultat;
        }

        // on récupère tout les totaux d'heures par jour
        foreach($user->getPlannedWorkDays() as $user) {
            $workHours[] =$user->getHoursplanned();
        }

        // on transforme les heures en secondes puis on additionne toutes les secondes et on les retransforme en heures et minutes.
        for($i = 0; $i<count($workHours); $i++) {
            $arraySecond[] = hoursToSeconds($workHours[$i]->format('H:i'));
            $totalHoursWeek = totalHours(array_sum($arraySecond));
        } 

        return $totalHoursWeek;
        
    }

    
}