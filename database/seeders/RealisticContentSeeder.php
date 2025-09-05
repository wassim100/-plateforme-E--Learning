<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Category;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RealisticContentSeeder extends Seeder
{
    public function run(): void
    {
        // 1) Categories
        $categories = [
            ['name' => 'Python', 'description' => 'From fundamentals to advanced topics in Python.'],
            ['name' => 'Java', 'description' => 'Object-oriented programming and enterprise Java.'],
            ['name' => 'Web Development', 'description' => 'Frontend and backend development for the web.'],
            ['name' => 'Data Science', 'description' => 'Data analysis, visualization, and statistics.'],
            ['name' => 'Deep Learning', 'description' => 'Neural networks, CNNs, RNNs, and transformers.'],
            ['name' => 'Artificial Intelligence', 'description' => 'Search, planning, and intelligent agents.'],
            ['name' => 'Databases', 'description' => 'SQL, NoSQL, and data modeling.'],
            ['name' => 'Cloud & DevOps', 'description' => 'Containers, CI/CD, and cloud services.'],
        ];

        $cats = collect();
        foreach ($categories as $c) {
            $cats->push(
                Category::updateOrCreate(
                    ['name' => $c['name']],
                    [
                        'description' => $c['description'],
                        'is_active' => true,
                    ]
                )
            );
        }

        // 2) Helper to copy a public asset into storage/public/courses and return the stored path
        $copyCourseImage = function (string $fileName): ?string {
            $source = public_path('desgin/images/' . $fileName);
            if (!file_exists($source)) {
                return null; // keep image null gracefully
            }
            $targetDir = 'courses';
            $targetName = strtolower(Str::random(6) . '-' . basename($fileName));
            $contents = @file_get_contents($source);
            if ($contents === false) {
                return null;
            }
            Storage::disk('public')->put($targetDir . '/' . $targetName, $contents);
            return $targetDir . '/' . $targetName;
        };

    // 3) Courses dataset (title, category key, price, image file in public/desgin/images)
        $courses = [
            ['title' => 'Introduction à Python', 'cat' => 'python', 'price' => 0, 'image' => 'thumb-1.png'],
            ['title' => 'Python pour la Data Science', 'cat' => 'data-science', 'price' => 39.99, 'image' => 'thumb-2.png'],
            ['title' => 'Java: Les Bases', 'cat' => 'java', 'price' => 19.99, 'image' => 'thumb-3.png'],
            ['title' => 'Java Avancé et Spring', 'cat' => 'java', 'price' => 49.00, 'image' => 'thumb-4.png'],
            ['title' => 'Front-end avec HTML, CSS, JS', 'cat' => 'web-development', 'price' => 0, 'image' => 'thumb-5.png'],
            ['title' => 'Laravel & APIs', 'cat' => 'web-development', 'price' => 29.00, 'image' => 'thumb-6.png'],
            ['title' => 'Bases de Données avec SQL', 'cat' => 'databases', 'price' => 14.90, 'image' => 'thumb-7.png'],
            ['title' => 'Deep Learning avec PyTorch', 'cat' => 'deep-learning', 'price' => 59.00, 'image' => 'thumb-8.png'],
            ['title' => 'Introduction à l’IA', 'cat' => 'artificial-intelligence', 'price' => 9.99, 'image' => 'thumb-9.png'],
            ['title' => 'Docker & Kubernetes', 'cat' => 'cloud-devops', 'price' => 39.00, 'image' => 'post-1-1.png'],
            ['title' => 'AWS pour Débutants', 'cat' => 'cloud-devops', 'price' => 35.00, 'image' => 'post-2-1.png'],
            ['title' => 'NoSQL avec MongoDB', 'cat' => 'databases', 'price' => 24.00, 'image' => 'post-3-1.png'],
        ];

        $createdCourses = collect();
        foreach ($courses as $c) {
            // Map the short key to a category name
            $keyToName = [
                'python' => 'Python',
                'java' => 'Java',
                'web-development' => 'Web Development',
                'data-science' => 'Data Science',
                'deep-learning' => 'Deep Learning',
                'artificial-intelligence' => 'Artificial Intelligence',
                'databases' => 'Databases',
                'cloud-devops' => 'Cloud & DevOps',
            ];
            $categoryName = $keyToName[$c['cat']] ?? $cats->first()->name;
            $category = $cats->firstWhere('name', $categoryName) ?? $cats->first();
            if (!$category) {
                // fallback: default to first category
                $category = $cats->first();
            }
            $storedPath = $copyCourseImage($c['image']);
            $createdCourses->push(
                Course::create([
                    'title' => $c['title'],
                    'description' => 'Un parcours structuré avec exercices, projets et bonnes pratiques pour maîtriser ' . strtolower($category->name) . '.',
                    'price' => $c['price'],
                    'image' => $storedPath,
                    'category_id' => $category->id,
                ])
            );
        }

        // 4) For each course, add one quiz with 5 realistic MCQ questions
        foreach ($createdCourses as $course) {
            $quiz = Quiz::create([
                'title' => 'Quiz: ' . $course->title,
                'description' => 'Vérifiez vos acquis pour le cours « ' . $course->title . ' ».',
                'course_id' => $course->id,
            ]);

            $questions = $this->makeQuestionsForCategory($course->category->name);
            foreach ($questions as $q) {
                $qData = [
                    'quiz_id' => $quiz->id,
                    'type' => 'multiple_choice',
                    'question_text' => $q['text'],
                    'answers' => $q['choices'],
                    'correct_answer' => $q['correct'],
                    'explanation' => $q['explanation'] ?? null,
                    'category' => $course->category->name,
                    'points' => 1,
                    'image' => null,
                ];
                $question = Question::create($qData);

                // Also create Answer rows for visibility in admin
                foreach ($q['choices'] as $key => $text) {
                    Answer::create([
                        'text' => $text,
                        'question_id' => $question->id,
                        'is_correct' => $text === $q['correct'],
                    ]);
                }
            }
        }
    }

    private function makeQuestionsForCategory(string $categoryName): array
    {
        // A few generic but category-leaning questions
        $generic = [
            [
                'text' => 'Quel est le meilleur rythme pour apprendre efficacement ?',
                'choices' => ['A' => 'Étudier chaque jour', 'B' => 'Une fois par mois', 'C' => 'Quand on a le temps', 'D' => 'Jamais'],
                'correct' => 'Étudier chaque jour',
                'explanation' => 'La régularité est clé pour la mémorisation durable.',
            ],
            [
                'text' => 'Quelle pratique améliore le plus la progression ?',
                'choices' => ['A' => 'Lire seulement', 'B' => 'Faire des exercices', 'C' => 'Regarder des vidéos passivement', 'D' => 'Attendre'],
                'correct' => 'Faire des exercices',
            ],
        ];

        $byCat = [
            'python' => [
                [
                    'text' => 'Quelle structure de données Python est mutable et ordonnée ?',
                    'choices' => ['A' => 'Tuple', 'B' => 'List', 'C' => 'String', 'D' => 'Set'],
                    'correct' => 'List',
                ],
                [
                    'text' => 'Quel mot-clé définit une fonction en Python ?',
                    'choices' => ['A' => 'func', 'B' => 'def', 'C' => 'function', 'D' => 'fn'],
                    'correct' => 'def',
                ],
                [
                    'text' => 'Quelle bibliothèque est courante pour la Data Science ?',
                    'choices' => ['A' => 'NumPy', 'B' => 'Requests', 'C' => 'Flask', 'D' => 'Click'],
                    'correct' => 'NumPy',
                ],
            ],
            'java' => [
                [
                    'text' => 'Quel mot-clé empêche l’héritage ?',
                    'choices' => ['A' => 'final', 'B' => 'static', 'C' => 'private', 'D' => 'sealed'],
                    'correct' => 'final',
                ],
                [
                    'text' => 'Quelle machine exécute le bytecode Java ?',
                    'choices' => ['A' => 'CLR', 'B' => 'JVM', 'C' => 'V8', 'D' => 'CPython'],
                    'correct' => 'JVM',
                ],
                [
                    'text' => 'Quel framework est populaire pour le web en Java ?',
                    'choices' => ['A' => 'Spring', 'B' => 'Django', 'C' => 'Rails', 'D' => 'Laravel'],
                    'correct' => 'Spring',
                ],
            ],
            'web-development' => [
                [
                    'text' => 'Quel langage structure le contenu des pages web ?',
                    'choices' => ['A' => 'HTML', 'B' => 'CSS', 'C' => 'JavaScript', 'D' => 'SQL'],
                    'correct' => 'HTML',
                ],
                [
                    'text' => 'Quel langage gère le style ?',
                    'choices' => ['A' => 'HTML', 'B' => 'CSS', 'C' => 'Python', 'D' => 'C++'],
                    'correct' => 'CSS',
                ],
                [
                    'text' => 'Quel protocole sert les pages ?',
                    'choices' => ['A' => 'FTP', 'B' => 'SSH', 'C' => 'HTTP', 'D' => 'SMTP'],
                    'correct' => 'HTTP',
                ],
            ],
            'data-science' => [
                [
                    'text' => 'Quelle étape vient avant le modèle ?',
                    'choices' => ['A' => 'Nettoyage des données', 'B' => 'Déploiement', 'C' => 'Monitoring', 'D' => 'A/B testing'],
                    'correct' => 'Nettoyage des données',
                ],
                [
                    'text' => 'Quelle librairie Python pour la visualisation ?',
                    'choices' => ['A' => 'Matplotlib', 'B' => 'Pip', 'C' => 'Requests', 'D' => 'Black'],
                    'correct' => 'Matplotlib',
                ],
                [
                    'text' => 'Quelle métrique évalue une régression ?',
                    'choices' => ['A' => 'Accuracy', 'B' => 'RMSE', 'C' => 'F1-score', 'D' => 'Recall'],
                    'correct' => 'RMSE',
                ],
            ],
            'deep-learning' => [
                [
                    'text' => 'Quel est un optimiseur courant ?',
                    'choices' => ['A' => 'Adam', 'B' => 'BFS', 'C' => 'Quicksort', 'D' => 'CRC32'],
                    'correct' => 'Adam',
                ],
                [
                    'text' => 'Que signifie CNN ?',
                    'choices' => ['A' => 'Central Neural Network', 'B' => 'Convolutional Neural Network', 'C' => 'Connected Neuron Network', 'D' => 'Conditional Neural Network'],
                    'correct' => 'Convolutional Neural Network',
                ],
                [
                    'text' => 'Technologie clé derrière Transformers ?',
                    'choices' => ['A' => 'Pooling', 'B' => 'BatchNorm', 'C' => 'Attention', 'D' => 'Dropout'],
                    'correct' => 'Attention',
                ],
            ],
            'artificial-intelligence' => [
                [
                    'text' => 'Quel algorithme cherche le chemin le plus court ?',
                    'choices' => ['A' => 'A*', 'B' => 'K-Means', 'C' => 'PCA', 'D' => 'Apriori'],
                    'correct' => 'A*',
                ],
                [
                    'text' => 'Un agent rationnel maximise…',
                    'choices' => ['A' => 'L’entropie', 'B' => 'La récompense', 'C' => 'La latence', 'D' => 'La mémoire'],
                    'correct' => 'La récompense',
                ],
                [
                    'text' => 'Quel domaine étudie l’incertitude ?',
                    'choices' => ['A' => 'Logique floue', 'B' => 'Tri topologique', 'C' => 'Greedy', 'D' => 'Backtracking'],
                    'correct' => 'Logique floue',
                ],
            ],
            'databases' => [
                [
                    'text' => 'Quel langage interroge les bases relationnelles ?',
                    'choices' => ['A' => 'SQL', 'B' => 'HTML', 'C' => 'YAML', 'D' => 'CSS'],
                    'correct' => 'SQL',
                ],
                [
                    'text' => 'Quelle commande ajoute une ligne ?',
                    'choices' => ['A' => 'INSERT', 'B' => 'SELECT', 'C' => 'WHERE', 'D' => 'JOIN'],
                    'correct' => 'INSERT',
                ],
                [
                    'text' => 'MongoDB est un SGBD…',
                    'choices' => ['A' => 'Relationnel', 'B' => 'Clé/Valeur', 'C' => 'Document', 'D' => 'Colonne'],
                    'correct' => 'Document',
                ],
            ],
            'cloud-devops' => [
                [
                    'text' => 'Quel outil gère les conteneurs ?',
                    'choices' => ['A' => 'Kubernetes', 'B' => 'Git', 'C' => 'npm', 'D' => 'Nginx'],
                    'correct' => 'Kubernetes',
                ],
                [
                    'text' => 'Docker packe les applications dans…',
                    'choices' => ['A' => 'VMs', 'B' => 'Conteneurs', 'C' => 'Scripts', 'D' => 'Pipelines'],
                    'correct' => 'Conteneurs',
                ],
                [
                    'text' => 'Que signifie CI/CD ?',
                    'choices' => ['A' => 'Constant Input/Constant Delay', 'B' => 'Continuous Integration/Continuous Delivery', 'C' => 'Compute Instance/Cloud Disk', 'D' => 'Cluster Interface/Config Drive'],
                    'correct' => 'Continuous Integration/Continuous Delivery',
                ],
            ],
        ];

    $key = strtolower(str_replace([' & ', ' '], ['-', '-'], $categoryName));
    $pool = array_merge($byCat[$key] ?? [], $generic);
        // ensure we return 5 questions max
        return array_slice($pool, 0, 5);
    }
}
