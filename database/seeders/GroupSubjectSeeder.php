<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\GroupSubject;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class GroupSubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->addGroupSubject("Hefzu",["Hefzu"]);
        $this->addGroupSubject("Nazera",["Quran"]);

        $Subject = ["Arabic" , "Bangla" , "English" , "Math" , "General knowledge"];
        $this->addGroupSubject("Nursery" , $Subject);
        $this->addGroupSubject("Class One" , $Subject );

        $Subject = ["Arabic" , "Bangla" , "English" , "Math" , "Environmental familiarity" , "General knowledge"];
        $this->addGroupSubject("Class Two" , $Subject );

        $Subject = ["Arabic" , "Bangla" , "English" , "Math" , "World identity" , "Science"];
        $this->addGroupSubject("Class Three" , $Subject );
        $this->addGroupSubject("Class Four" , $Subject );
        $this->addGroupSubject("Class Five" , $Subject );
    }

    private function addGroupSubject(string $group , array $subjectNames ){
        $subjects = [];
        $classOne = $this->getGroupId($group);

        foreach ($subjectNames as $name){
            $temp = $this->getSubjectId($name);
            if($temp != 0 ){
                $subjects[] = [
                    "group_id" => $classOne,
                    "subject_id" => $temp,
                ];
            }
        }

        GroupSubject::insert($subjects);
    }

    private function getSubjectId(string $name):int
    {
        $subject = Subject::where("name" , $name)->first();
        return $subject->id ?? 0;
    }

    private function getGroupId(string $name):int
    {
        $group = Group::where("name" , $name)->first();
        return $group->id ?? 0;
    }
}
