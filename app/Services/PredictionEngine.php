<?php 

namespace App\Services;

use App\Models\PredictionRequest;
use App\Models\Question;

class PredictionEngine
{
  public function generate(PredictionRequest $req): array
  {
    $answers = $req->answers()->with('question')->get()->keyBy(fn($a) => $a->question->key);

    $risk = (int)($answers['risk_tolerance']->value ?? 3);
    $workStyle = (string)($answers['work_style']->value ?? 'mixed');
    $domain = (string)($answers['domain_interest']->value ?? 'tech');

    // Score simple
    $score = 0;
    $score += max(1, min(5, $risk)) * 10;
    $score += in_array($workStyle, ['team','solo','mixed'], true) ? 15 : 0;
    $score += 20;

    // Profil
    $profile = match (true) {
      $risk >= 4 => 'Dynamique / orienté opportunités',
      $risk <= 2 => 'Prudent / orienté stabilité',
      default => 'Équilibré',
    };

    $env = match ($workStyle) {
      'team' => 'environnements collaboratifs (équipes, projets transverses)',
      'solo' => 'environnements autonomes (missions individuelles, ownership fort)',
      default => 'environnements mixtes',
    };

    $suggestions = match ($domain) {
      'tech' => ['Développement web', 'Data / BI (niveau débutant)', 'Support/DevOps (selon affinités)'],
      'health' => ['Paramédical', 'Gestion structures de santé', 'Recherche (si parcours long)'],
      'business' => ['Gestion / Comptabilité', 'Marketing digital', 'Vente B2B / Customer Success'],
      'education' => ['Pédagogie', 'Formation pro', 'Ingénierie pédagogique'],
      default => ['Parcours généraliste', 'Approche exploratoire'],
    };

    return [
      'score' => $score,
      'confidence_label' => 'indicatif',
      'result' => [
        'profile' => $profile,
        'work_environment' => $env,
        'suggestions' => $suggestions,
        'next_steps' => [
          'Choisir 1 piste et faire un mini-projet ou stage court.',
          'Identifier 3 compétences clés à travailler sur 30 jours.',
          'Demander un feedback à une personne du domaine.',
        ],
        'disclaimer' => 'Résultat indicatif basé sur vos réponses; ce n’est pas une certitude.'
      ]
    ];
  }
}
