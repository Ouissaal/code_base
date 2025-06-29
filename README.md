<img src="https://i.imgur.com/oKAKsnH.png" alt="Logo Dirlkhir" />

# Dirlkhir - Une initiative qui peut tout changer

Une plateforme communautaire visant à combler le fossé dans l'accès aux soins de santé en facilitant le don d'argent et de transport ainsi que le don de sang, avec le support de trois langues principales : arabe, français et anglais, permettant à l'utilisateur de choisir facilement la langue qui lui convient, rendant ainsi la plateforme plus inclusive et accessible à toutes les catégories de la société.


Découvrez la plateforme en ligne ici : [springgreen-finch-412957.hostingersite.com](https://springgreen-finch-412957.hostingersite.com/)


## Table des Matières
- [🎯 Objectif](#-objectif)
- [✨ Fonctionnalités](#-fonctionnalités)
- [✨ Avantages](#-Avantages)
- [🛡️ Sécurité](#-sécurité)
- [🌐 Multilinguisme](#-multilinguisme)
- [🚀 Évolutions Futures ](#-Évolutions-Futures)
- [🚀 Technologies Utilisées](#-technologies-utilisées)
- [👩🏻‍💻 À Propos de Moi](#-à-propos-de-moi)



## 🎯 Objectif

Dans notre société, beaucoup de personnes rencontrent de grandes difficultés pour accéder aux soins de santé, notamment pour les dons d'argent, de transport ou de sang. Les obstacles financiers, la distance géographique et le manque d'information créent de réels problèmes.

La plateforme Dirlkhir a été créée pour répondre à ce besoin. Notre objectif est de construire une plateforme simple, sécurisée et facile à utiliser, qui connecte :

Les personnes ayant besoin d'aide financière, de sang ou de moyens de transport

Les patients et personnes à la recherche de sang, avec des donneurs prêts à aider et sauver des vies

Nous souhaitons ainsi faciliter l'accès aux soins et bâtir une communauté solidaire où aucun appel à l'aide n'est ignoré.

## ✨ Fonctionnalités principales de la plateforme Dirlkhir

La plateforme met en relation les personnes dans le besoin (don de sang, aide financière, transport ..) avec des volontaires prêts à aider.

- Meilleur accès aux soins de santé :
Elle aide à surmonter les obstacles financiers, géographiques ou liés au manque d’information.

- Simplicité et sécurité :
Un outil facile à utiliser, conçu pour garantir la confidentialité et la protection des données.

- Réponse aux urgences :
Facilite le don de sang, notamment en cas d’urgence vitale.

- Transport solidaire :
Permet aux patients sans moyens de se rendre à leurs rendez-vous médicaux.

- Communauté multilingue et inclusive :
Accessible en arabe, français et anglais pour atteindre un public plus large.

- Aucun appel ignoré :
Chaque demande d’aide est prise en compte afin que personne ne soit laissé de côté.


- Consultations médicales gratuites (en présentiel ou à distance)
Assurées par des médecins bénévoles pour orienter et accompagner les patients, notamment dans les cas urgents ou nécessitant un soutien psychologique.

- Don d’argent :
Aide financière directe pour couvrir les frais de soins, d’examens ou d’interventions médicales.

- Aide à l’achat de médicaments :
Soutien aux personnes démunies pour se procurer leurs traitements, sous réserve de la présentation d’une ordonnance médicale.



 ## ✨ Avantages de la plateforme Dirlkhir

Nous ne proposons pas seulement une plateforme, mais utilisons les meilleures pratiques technologiques pour garantir qualité, sécurité et performance :

- **Architecture MVC (Modèle-Vue-Contrôleur)** :
  Séparation claire entre la logique métier, l'interface utilisateur et le contrôle, ce qui rend le code organisé et évolutif.
- **Connexion sécurisée avec gestion des sessions** :
  Protection des données personnelles et suivi des opérations pour garantir la transparence.
- **Interface utilisateur responsive et moderne** :
  Conçue avec Bootstrap 5 pour une expérience fluide sur tous types d'appareils.

## 🛡️ Sécurisation
Nous accordons une grande importance à la protection des données et à la sécurité des utilisateurs via :

- **Requêtes préparées (Prepared Statements) avec PDO** :
  Pour se prémunir contre les injections SQL et protéger la base de données.
- **Protection contre les attaques XSS** :
  Assainissement des entrées utilisateurs avec htmlspecialchars pour éviter l'injection de code malveillant.
- **Protection CSRF par tokens dans les formulaires** :
  Assure que seules les opérations autorisées par les utilisateurs connectés sont exécutées.
- **Téléchargement de fichiers sécurisé** :
  Validation stricte des extensions et types de fichiers pour éviter tout exploit.

## 🌐 Multilinguisme
La plateforme Dirlkhir offre la possibilité de choisir entre arabe, français et anglais afin de répondre aux besoins d'une communauté multilingue, avec notamment :

- Sélection de langue simple et intuitive
- Traductions professionnelles et précises


## 🔮Évolutions Futures
La plateforme Dirlkhir est conçue pour évoluer constamment et répondre aux besoins croissants de sa communauté. Parmi les fonctionnalités envisagées pour les prochaines versions :

- **Architecture Microservices** 
Pour une meilleure scalabilité, maintenabilité et performance, nous prévoyons de migrer progressivement vers une architecture basée sur des microservices. Cela permettra :

Une indépendance des modules (gestion des dons, utilisateurs, notifications…)
Un déploiement plus rapide et ciblé
Une tolérance accrue aux pannes


- **Intégration d'un Chatbot Intelligent** 
Mise en place d’un assistant virtuel alimenté par l’IA pour :

Aider les utilisateurs à trouver rapidement ce dont ils ont besoin
Répondre aux questions fréquentes en temps réel
Guider les nouveaux utilisateurs pas à pas dans l’utilisation de la plateforme

- **Application mobile (Android/iOS)** 
Pour améliorer l’accessibilité et l’expérience utilisateur, une application mobile native est également en réflexion.

- **Notifications en temps réel**  
Grâce à WebSocket ou Firebase, pour alerter immédiatement les utilisateurs en cas d’urgence (besoin urgent de sang, nouvelle demande de transport, etc.)

- **Tableau de bord administratif avancé** 
Avec statistiques, suivi des dons, gestion des utilisateurs et alertes de sécurité.


## 🚀 Technologies Utilisées

Le projet est construit sur une stack web classique et robuste, choisie pour sa stabilité et sa structure claire.

-   **Architecture** : **Modèle-Vue-Contrôleur (MVC)**
    -   Ce modèle sépare la logique de l'application, la gestion des données et l'interface utilisateur. Cette séparation conduit à un code plus propre, plus facile à maintenir et facilite le travail d'équipe.
-   **Backend** : **PHP**
-   **Base de données** : **PDO** pour des connexions sécurisées
-   **Frontend** : **HTML**, **CSS**, **JavaScript**, **Bootstrap**
-   **Serveur** : **XAMPP / Apache**

## 👩🏻‍💻 À Propos de Moi

Bonjour ! Je suis Ouissal Bouamar, étudiante en première année passionnée par le développement web à ISTA Taza.

J'ai créé le projet Dirlkhir comme application pratique des techniques de programmation, mais aussi comme moyen de contribuer à résoudre des problèmes réels dans la société. Je crois que la technologie peut rapprocher les gens et faire une vraie différence.

Vous pouvez me retrouver sur :
- **Établissement** : OFPPT ISTA Taza
- **Spécialité** : Développement digital
- **Contact** : [LinkedIn](https://www.linkedin.com/in/ouissal-bouamar) | [GitHub](https://github.com/Ouissaal)

---
<div align="center">
  <p>© 2025 Dirlkhir. Tous droits réservés.</p>
</div>

