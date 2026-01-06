<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PredictionCategory;
use App\Models\Questionnaire;
use App\Models\Question;
use App\Models\QuestionOption;

class PredictionSeeder extends Seeder
{
  public function run(): void
  {
    $job = PredictionCategory::updateOrCreate(
      ['slug' => 'job'],
      ['name' => 'Orientation Job', 'description' => 'Analyse indicative de profil professionnel.']
    );

    $studies = PredictionCategory::updateOrCreate(
      ['slug' => 'etudes'],
      ['name' => 'Parcours d’études', 'description' => 'Aide indicative au choix de parcours.']
    );

    $jobQ = Questionnaire::updateOrCreate(
      ['prediction_category_id' => $job->id, 'version' => 1],
      ['title' => 'Questionnaire Job v1', 'is_active' => true]
    );

    $q1 = Question::updateOrCreate(
      ['questionnaire_id' => $jobQ->id, 'key' => 'risk_tolerance'],
      ['label' => 'Tolérance au risque (1-5)', 'type' => 'scale', 'step' => 1, 'weight' => 2]
    );

    $q2 = Question::updateOrCreate(
      ['questionnaire_id' => $jobQ->id, 'key' => 'work_style'],
      ['label' => 'Style de travail préféré', 'type' => 'choice', 'step' => 1, 'weight' => 2]
    );

    foreach ([
      ['value'=>'team','label'=>'Travail en équipe','score'=>2],
      ['value'=>'solo','label'=>'Travail en autonomie','score'=>2],
      ['value'=>'mixed','label'=>'Mixte','score'=>1],
    ] as $opt) {
      QuestionOption::updateOrCreate(
        ['question_id'=>$q2->id,'value'=>$opt['value']],
        ['label'=>$opt['label'],'score'=>$opt['score']]
      );
    }

    $q3 = Question::updateOrCreate(
      ['questionnaire_id' => $jobQ->id, 'key' => 'domain_interest'],
      ['label' => 'Domaine qui vous attire le plus', 'type' => 'choice', 'step' => 2, 'weight' => 3]
    );

    foreach ([
      ['value'=>'tech','label'=>'Tech / Numérique','score'=>3],
      ['value'=>'health','label'=>'Santé','score'=>3],
      ['value'=>'business','label'=>'Business / Gestion','score'=>3],
      ['value'=>'education','label'=>'Éducation','score'=>2],
    ] as $opt) {
      QuestionOption::updateOrCreate(
        ['question_id'=>$q3->id,'value'=>$opt['value']],
        ['label'=>$opt['label'],'score'=>$opt['score']]
      );
    }
  }
}
