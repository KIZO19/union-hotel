🏨 Union Hôtel - Système de Gestion Intégrée (ERP)

Union Hôtel est une application web de gestion hôtelière complète conçue pour centraliser les opérations administratives, financières et humaines d'un établissement hôtelier.

🚀 Fonctionnalités Principales

👨‍💼 Centre de Contrôle (PDG/Direction)

Monitoring Global : Supervision en temps réel via un tableau de bord dynamique.

KPI Stratégiques : Suivi du taux d'occupation, du chiffre d'affaires journalier et de la présence du personnel.

Alertes Système : Notifications instantanées sur les retards, les anomalies ou les incidents critiques.

👥 Ressources Humaines (RH)

Pointage QR Code : Système de présence moderne utilisant le scan de cartes d'identité professionnelles.

Gestion des Agents : Base de données complète des employés (Identité, Contrats, Départements).

Calcul de Paie : Automatisation du calcul des salaires nets basés sur la présence et les avances.

💰 Finance & Caisse

Trésorerie : Suivi des flux financiers et des encaissements en temps réel.

Gestion des Factures : Module de facturation pour les réceptionnistes et caissiers.

Grand Livre : Journalisation des transactions pour la comptabilité.

🛏️ Opérations Hôtelières

Réservations : Gestion du calendrier des arrivées et départs.

Gestion des Chambres : Suivi des statuts (disponible, occupée, en nettoyage).

🛠️ Stack Technique

Frontend : HTML5, CSS3 (Bootstrap 5), JavaScript (Vanilla/Fetch API), Lucide Icons.

Backend : PHP 8.x (Architecture MVC).

Base de données : MySQL / MariaDB (Utilisation intensive de Vues SQL pour l'optimisation des performances).

Authentification : Système de sessions sécurisé avec gestion des niveaux d'accès (PDG, DG, RH, Comptable, Caissier, Réceptionniste).

📂 Structure du Projet

├── app/
│   ├── controllers/    # Logique métier
│   ├── models/         # Interactions base de données
│   └── views/          # Templates PHP (Layout, Sidebar, Pages)
├── public/
│   ├── css/            # Feuilles de style
│   ├── js/             # Scripts (Monitoring, QR Scan)
│   └── uploads/        # Photos des agents
├── sql/
│   └── create_view.sql # Définition de la vue globale agents
├── index.php           # Routeur principal
└── README.md


⚙️ Installation

Clonage du dépôt :

git clone [https://github.com/votre-repo/union-hotel.git](https://github.com/votre-repo/union-hotel.git)


Configuration Base de données :

Importez le schéma SQL fourni dans votre serveur MySQL.

Exécutez le script create_view.sql pour initialiser la vue globale indispensable au fonctionnement des modules.

Serveur Web :

Configurez votre serveur (Apache/Nginx) pour pointer vers le dossier racine.

Assurez-vous que les extensions PHP pdo_mysql et json sont activées.

🔒 Sécurité

Les mots de passe sont hachés en base de données.

Le niveau d'accès est vérifié à chaque action pour empêcher les accès non autorisés aux données sensibles (notamment les données financières réservées au PDG).

Développé pour l'Union Hôtel Goma - Département Informatique.
