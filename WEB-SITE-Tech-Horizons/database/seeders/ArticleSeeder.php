<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Theme;
use App\Models\User; // Import the User model
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        // Fetch all themes
        $themes = Theme::all();
        // Fetch a user to associate with the articles
        $user = User::first(); // Get the first user (or any user you want to associate with the articles)

        // Sample articles for each theme
        $articles = [
            [
                'title' => 'Introduction à l\'intelligence artificielle',
                'content' => 'L\'intelligence artificielle (IA) est l\'une des technologies les plus révolutionnaires de notre époque. Elle permet aux machines d\'apprendre, de raisonner et de prendre des décisions de manière autonome. Des assistants virtuels comme Siri et Alexa aux voitures autonomes, l\'IA transforme notre quotidien. Cependant, elle soulève également des questions éthiques, comme la protection des données et l\'impact sur l\'emploi. Dans cet article, nous explorerons les bases de l\'IA, ses applications actuelles et les défis qu\'elle pose.',
                'status' => 'retenu',
                'theme_id' => 1 ,
            ],
            [
                'title' => 'Les applications de l\'IA dans la vie quotidienne',
                'content' => 'L\'IA est omniprésente dans notre vie quotidienne, souvent sans que nous en soyons conscients. Elle est utilisée dans les recommandations de films sur Netflix, les filtres anti-spam de Gmail, et même dans les diagnostics médicaux. Par exemple, l\'IA aide les médecins à détecter des maladies comme le cancer à un stade précoce. Dans le secteur des transports, les voitures autonomes utilisent l\'IA pour naviguer et éviter les accidents. Cet article explore comment l\'IA améliore notre quotidien et ce que l\'avenir nous réserve.',
                'status' => 'retenu',
                'theme_id' => 1 ,
            ],
            [
                'title' => 'Les défis éthiques de l\'IA',
                'content' => 'L\'IA offre de nombreuses opportunités, mais elle pose également des défis éthiques majeurs. La confidentialité des données est l\'un des problèmes les plus pressants. Les algorithmes d\'IA ont besoin de grandes quantités de données pour fonctionner, ce qui soulève des questions sur la manière dont ces données sont collectées et utilisées. De plus, l\'IA peut renforcer les biais existants si les données d\'entraînement sont partiales. Dans cet article, nous examinons les principaux défis éthiques de l\'IA et les solutions potentielles pour les résoudre.',
                'status' => 'retenu',
                'theme_id' => 1 ,
            ],
            [
                'title' => 'Les avantages de l\'Internet des objets',
                'content' => 'L\'Internet des objets (IoT) connecte des milliards d\'appareils à travers le monde, des montres intelligentes aux systèmes de gestion de l\'énergie domestique. Cette connectivité accrue permet une meilleure efficacité énergétique, une automatisation des tâches quotidiennes et une amélioration de la qualité de vie. Par exemple, les maisons intelligentes utilisent l\'IoT pour contrôler l\'éclairage, le chauffage et la sécurité à distance. Cet article explore les avantages de l\'IoT et son impact sur notre vie quotidienne.',
                'status' => 'retenu',
                'theme_id' => 2 ,
            ],
            [
                'title' => 'Les défis de sécurité de l\'IoT',
                'content' => 'Bien que l\'IoT offre de nombreux avantages, il pose également des défis de sécurité importants. Les appareils connectés sont souvent vulnérables aux cyberattaques, ce qui peut compromettre la vie privée des utilisateurs. Par exemple, des caméras de sécurité piratées peuvent être utilisées pour espionner les propriétaires. Dans cet article, nous examinons les principaux risques de sécurité liés à l\'IoT et les mesures que les utilisateurs peuvent prendre pour se protéger.',
                'status' => 'retenu',
                'theme_id' => 2 ,
            ],
            [
                'title' => 'L\'avenir de l\'IoT',
                'content' => 'L\'IoT continue d\'évoluer rapidement, avec l\'avènement de la 5G et des technologies de pointe comme l\'IA. À l\'avenir, nous pouvons nous attendre à une intégration encore plus poussée des appareils connectés dans notre vie quotidienne. Par exemple, les villes intelligentes utiliseront l\'IoT pour optimiser la gestion du trafic, réduire la consommation d\'énergie et améliorer les services publics. Cet article explore les tendances futures de l\'IoT et leur impact potentiel sur la société.',
                'status' => 'retenu',
                'theme_id' => 2 ,
            ],
            [
                'title' => 'Introduction à la cybersécurité',
                'content' => 'La cybersécurité est devenue un enjeu majeur à l\'ère du numérique. Avec l\'augmentation des cyberattaques, il est essentiel de protéger les données sensibles des particuliers et des entreprises. Les techniques de cybersécurité incluent le chiffrement des données, la détection des intrusions et la formation des utilisateurs. Dans cet article, nous explorons les bases de la cybersécurité et les meilleures pratiques pour se protéger en ligne.',
                'status' => 'retenu',
                'theme_id' => 3 ,
            ],
            [
                'title' => 'Les menaces actuelles en cybersécurité',
                'content' => 'Les cybermenaces évoluent constamment, devenant de plus en plus sophistiquées. Les ransomwares, les attaques par phishing et les violations de données sont parmi les menaces les plus courantes. Par exemple, en 2023, une grande entreprise a subi une attaque de ransomware qui a paralysé ses opérations pendant plusieurs jours. Cet article examine les principales menaces en cybersécurité et les mesures que les organisations peuvent prendre pour se protéger.',
                'status' => 'retenu',
                'theme_id' => 3 ,
            ],
            [
                'title' => 'Les meilleures pratiques en cybersécurité',
                'content' => 'Pour se protéger contre les cybermenaces, il est essentiel de suivre les meilleures pratiques en matière de cybersécurité. Cela inclut l\'utilisation de mots de passe forts, la mise à jour régulière des logiciels et la sensibilisation des employés aux risques de sécurité. Par exemple, les entreprises peuvent mettre en place des politiques de sécurité strictes et des formations régulières pour leurs employés. Cet article explore les meilleures pratiques en cybersécurité pour les particuliers et les organisations.',
                'status' => 'retenu',
                'theme_id' => 3 ,
            ],
            [
                'title' => 'Les applications de la réalité virtuelle',
                'content' => 'La réalité virtuelle (VR) est utilisée dans de nombreux domaines, des jeux vidéo à la formation professionnelle. Par exemple, les médecins utilisent la VR pour s\'entraîner à des opérations complexes, tandis que les architectes l\'utilisent pour visualiser des projets en 3D. La VR offre une immersion totale, permettant aux utilisateurs d\'explorer des environnements virtuels de manière réaliste. Cet article explore les applications actuelles de la VR et son potentiel futur.',
                'status' => 'retenu',
                'theme_id' => 4 ,
            ],
            [
                'title' => 'Les limites de la réalité virtuelle',
                'content' => 'Malgré ses nombreux avantages, la réalité virtuelle présente également des limites. Certains utilisateurs peuvent ressentir des effets secondaires comme le mal des transports ou la fatigue oculaire. De plus, le coût élevé des équipements de VR peut limiter son adoption à grande échelle. Dans cet article, nous examinons les principaux défis de la VR et les solutions potentielles pour les surmonter.',
                'status' => 'retenu',
                'theme_id' => 4 ,
            ],
            [
                'title' => 'L\'avenir de la réalité virtuelle',
                'content' => 'La réalité virtuelle continue de se développer, avec des technologies de plus en plus avancées. À l\'avenir, nous pouvons nous attendre à une intégration plus poussée de la VR dans des domaines comme l\'éducation, la santé et le divertissement. Par exemple, les étudiants pourraient utiliser la VR pour explorer des environnements historiques ou scientifiques de manière immersive. Cet article explore les tendances futures de la VR et son impact potentiel sur la société.',
                'status' => 'retenu',
                'theme_id' => 4 ,
            ],
            [
                'title' => 'Introduction à la blockchain',
                'content' => 'La blockchain est une technologie révolutionnaire qui permet des transactions sécurisées et transparentes sans intermédiaire. Elle est surtout connue pour son utilisation dans les cryptomonnaies comme le Bitcoin, mais ses applications vont bien au-delà. Par exemple, la blockchain peut être utilisée pour sécuriser les votes électroniques ou tracer les produits dans une chaîne d\'approvisionnement. Dans cet article, nous explorons les bases de la blockchain et ses applications potentielles.',
                'status' => 'retenu',
                'theme_id' => 5 ,
            ],
            [
                'title' => 'Les applications de la blockchain',
                'content' => 'La blockchain est utilisée dans de nombreux secteurs, de la finance à la logistique. Par exemple, les banques utilisent la blockchain pour accélérer les transactions internationales et réduire les coûts. Dans le secteur de la santé, la blockchain peut être utilisée pour sécuriser les dossiers médicaux. Cet article explore les applications actuelles de la blockchain et son potentiel pour transformer divers secteurs.',
                'status' => 'retenu',
                'theme_id' => 5 ,
            ],
            [
                'title' => 'Les défis de la blockchain',
                'content' => 'Malgré ses nombreux avantages, la blockchain pose également des défis. L\'un des principaux problèmes est l\'évolutivité, car les réseaux blockchain peuvent devenir lents et coûteux à mesure qu\'ils grandissent. De plus, la consommation d\'énergie des blockchains comme Bitcoin est un problème environnemental majeur. Dans cet article, nous examinons les principaux défis de la blockchain et les solutions potentielles pour les surmonter.',
                'status' => 'retenu',
                'theme_id' => 5 ,
            ],
            [
                'title' => 'Le rôle du Big Data dans les entreprises',
                'content' => 'Le Big Data permet aux entreprises de prendre des décisions éclairées en analysant de grandes quantités de données. Par exemple, les entreprises de vente au détail utilisent le Big Data pour personnaliser les recommandations de produits et optimiser les stocks. Dans le secteur de la santé, le Big Data est utilisé pour prédire les épidémies et améliorer les traitements. Cet article explore comment le Big Data transforme les entreprises et les défis qu\'il pose.',
                'status' => 'retenu',
                'theme_id' => 6 ,
            ],
            [
                'title' => 'Les défis du Big Data',
                'content' => 'Le Big Data nécessite des infrastructures de stockage et de traitement puissantes, ce qui peut être coûteux pour les entreprises. De plus, la gestion et l\'analyse de grandes quantités de données posent des défis techniques et éthiques. Par exemple, la protection des données personnelles est un enjeu majeur. Dans cet article, nous examinons les principaux défis du Big Data et les solutions pour les surmonter.',
                'status' => 'retenu',
                'theme_id' => 6 ,
            ],
            [
                'title' => 'L\'avenir du Big Data',
                'content' => 'Le Big Data continue d\'évoluer, avec l\'intégration de technologies comme l\'IA et l\'IoT. À l\'avenir, nous pouvons nous attendre à une analyse encore plus poussée des données, permettant des prédictions plus précises et des décisions plus éclairées. Par exemple, les villes intelligentes utiliseront le Big Data pour optimiser les services publics et réduire la pollution. Cet article explore les tendances futures du Big Data et son impact potentiel sur la société.',
                'status' => 'retenu',
                'theme_id' => 6 ,
            ],
            [
                'title' => 'Les avantages du Cloud Computing',
                'content' => 'Le Cloud Computing offre une flexibilité et une évolutivité accrues aux entreprises. Il permet aux utilisateurs d\'accéder à des ressources informatiques à la demande, sans avoir à investir dans des infrastructures coûteuses. Par exemple, les entreprises peuvent utiliser le cloud pour stocker des données, exécuter des applications et gérer des services. Cet article explore les avantages du Cloud Computing et son impact sur les entreprises.',
                'status' => 'retenu',
                'theme_id' => 7 ,
            ],
            [
                'title' => 'Les défis du Cloud Computing',
                'content' => 'Le Cloud Computing pose des défis en matière de sécurité et de confidentialité. Les données stockées dans le cloud peuvent être vulnérables aux cyberattaques, et les utilisateurs doivent faire confiance aux fournisseurs de services pour protéger leurs informations. De plus, la dépendance au cloud peut poser des problèmes en cas de panne ou de perte de connectivité. Dans cet article, nous examinons les principaux défis du Cloud Computing et les solutions pour les surmonter.',
                'status' => 'retenu',
                'theme_id' => 7 ,
            ],
            [
                'title' => 'L\'avenir du Cloud Computing',
                'content' => 'Le Cloud Computing continuera à se développer, avec des services plus avancés et une intégration accrue avec l\'IA et l\'IoT. À l\'avenir, nous pouvons nous attendre à une adoption encore plus large du cloud, notamment dans les secteurs de la santé et de l\'éducation. Par exemple, les hôpitaux pourraient utiliser le cloud pour stocker et analyser des données médicales en temps réel. Cet article explore les tendances futures du Cloud Computing et son impact potentiel sur la société.',
                'status' => 'retenu',
                'theme_id' => 7 ,
            ],
        ];

        // Assign 3 articles to each theme
        foreach ($themes as $theme) {
            for ($i = 0; $i < 3; $i++) {
                $article = $articles[$theme->id * 3 - 3 + $i]; // Calculate the article index
                Article::create([
                    'title' => $article['title'],
                    'content' => $article['content'],
                    'status' => $article['status'],
                    'theme_id' => $theme->id, // Assign to the current theme
                    'user_id' => $user->id, // Associate the article with the user
                ]);
            }
        }
    }
}