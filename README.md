# Eat&Drink

## Contexte  
Plateforme web pour gérer l'événement culinaire Eat&Drink : inscriptions des exposants et présentation des produits.

## Objectifs  
- Application web complète avec authentification et rôles  
- Gestion CRUD des stands et produits  
- Interface publique pour consulter les exposants et passer commande  

## Fonctionnalités principales  
- Inscription et approbation des entrepreneurs  
- Tableau de bord pour administrateur et entrepreneurs  
- Gestion des produits (ajout, modification, suppression)  
- Vitrine publique des stands et produits  
- Système de commande simple  

## Modèle de données (extrait)  
- Utilisateurs (id, nom_entreprise, email, rôle, mot_de_passe)  
- Stands (id, nom_stand, description, utilisateur_id)  
- Produits (id, nom, description, prix, stand_id)  
- Commandes (id, stand_id, détails, date)  

## Équipe – Groupe 7  
- ZANNOU Floriane (Cheffe de projet)  
- ISSOUMA Nafissatou (front-end)
- OKOTCHE Jean-Marie (back-end)
