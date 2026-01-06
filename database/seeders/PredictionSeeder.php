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

    // Questionnaire Etudes
    $studyQ = Questionnaire::updateOrCreate(
      ['prediction_category_id' => $studies->id, 'version' => 1],
      ['title' => 'Orientation Études v1', 'is_active' => true]
    );

    $sq1 = Question::updateOrCreate(
      ['questionnaire_id' => $studyQ->id, 'key' => 'risk_tolerance'],
      ['label' => 'Préférence pour les études longues', 'type' => 'scale', 'step' => 1, 'weight' => 2]
    );

    $sq2 = Question::updateOrCreate(
      ['questionnaire_id' => $studyQ->id, 'key' => 'work_style'],
      ['label' => 'Profil académique', 'type' => 'choice', 'step' => 1, 'weight' => 2]
    );

    foreach ([
      ['value'=>'team','label'=>'Pratique / Technique','score'=>2],
      ['value'=>'solo','label'=>'Théorique / Recherche','score'=>2],
      ['value'=>'mixed','label'=>'Mixte','score'=>1],
    ] as $opt) {
      QuestionOption::updateOrCreate(
        ['question_id'=>$sq2->id,'value'=>$opt['value']],
        ['label'=>$opt['label'],'score'=>$opt['score']]
      );
    }

    $sq3 = Question::updateOrCreate(
      ['questionnaire_id' => $studyQ->id, 'key' => 'domain_interest'],
      ['label' => 'Domaine d\'intérêt majeur', 'type' => 'choice', 'step' => 2, 'weight' => 3]
    );

    foreach ([
      ['value'=>'tech','label'=>'Ingénierie','score'=>3],
      ['value'=>'health','label'=>'Médecine','score'=>3],
      ['value'=>'business','label'=>'Commerce','score'=>3],
      ['value'=>'education','label'=>'Lettres / Sciences Humaines','score'=>2],
    ] as $opt) {
      QuestionOption::updateOrCreate(
        ['question_id'=>$sq3->id,'value'=>$opt['value']],
        ['label'=>$opt['label'],'score'=>$opt['score']]
      );
    }
  }
}
