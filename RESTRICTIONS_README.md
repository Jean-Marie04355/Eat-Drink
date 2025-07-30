# 🔒 Système de Restrictions de Comptes Entrepreneurs

## 📋 Vue d'ensemble

Le système de restrictions permet aux administrateurs de suspendre temporairement ou définitivement les comptes des entrepreneurs pour diverses raisons (comportement inapproprié, non-respect des règles, etc.).

## 🚀 Fonctionnalités

### ✅ **Fonctionnalités principales :**

1. **Création de restrictions** avec durée personnalisable
2. **Types de restrictions** : temporaire, permanente, avertissement
3. **Réactivation manuelle** avant expiration
4. **Prolongation** des restrictions existantes
5. **Notifications automatiques** par email
6. **Nettoyage automatique** des restrictions expirées
7. **Interface d'administration** complète

### 🎯 **Types de restrictions :**

- **Temporaire** : Suspension pour une durée limitée
- **Permanente** : Suspension jusqu'à réactivation manuelle
- **Avertissement** : Restriction légère avec notification

## 🛠️ Installation et Configuration

### 1. **Migration de la base de données**
```bash
php artisan migrate
```

### 2. **Configuration du middleware**
Le middleware `CheckRestrictions` est automatiquement enregistré dans `app/Http/Kernel.php`.

### 3. **Configuration des tâches cron**
Ajoutez cette ligne à votre crontab pour nettoyer automatiquement les restrictions expirées :
```bash
* * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
```

## 📱 Utilisation

### **Interface d'administration :**

1. **Accéder à la page** : `/dashboard/restrictions`
2. **Créer une restriction** :
   - Sélectionner l'entrepreneur
   - Choisir le type de restriction
   - Définir la durée
   - Saisir le motif
3. **Gérer les restrictions** :
   - Réactiver un compte
   - Prolonger une restriction
   - Supprimer une restriction

### **Commandes artisan :**

```bash
# Vérifier les restrictions expirées
php artisan restrictions:check-expired

# Créer des données de test
php artisan db:seed --class=RestrictionSeeder
```

## 🔧 Configuration avancée

### **Modification des messages :**

Les messages de restriction sont personnalisables dans :
- `app/Http/Middleware/CheckRestrictions.php` (message de connexion)
- `app/Notifications/RestrictionNotification.php` (email)

### **Personnalisation des durées :**

Les durées par défaut peuvent être modifiées dans :
- `resources/views/admin/restrictions.blade.php` (interface)
- `app/Http/Controllers/AdminController.php` (validation)

## 📊 Statistiques

Le système fournit des statistiques en temps réel :
- Nombre de comptes restreints
- Comptes actifs
- Restrictions expirant aujourd'hui
- Restrictions créées ce mois

## 🔐 Sécurité

### **Vérifications automatiques :**
- Vérification à chaque connexion
- Nettoyage automatique des restrictions expirées
- Logs des actions d'administration

### **Notifications :**
- Email automatique lors de l'application d'une restriction
- Message détaillé lors de la tentative de connexion
- Informations sur la durée restante

## 🚨 Messages d'erreur

### **Lors de la connexion d'un entrepreneur restreint :**

```
🔒 Votre compte a été temporairement restreint

📋 Motif: [Motif de la restriction]

⚠️ Type de restriction: [Type]

⏰ Votre compte sera réactivé dans [X] jour(s)

📞 Contact: Si vous pensez qu'il s'agit d'une erreur, contactez l'administration.
```

## 📝 Logs

Les actions sont enregistrées dans :
- `storage/logs/restrictions.log` (nettoyage automatique)
- Base de données (historique des restrictions)

## 🔄 Maintenance

### **Nettoyage automatique :**
- Exécuté toutes les heures via cron
- Désactive automatiquement les restrictions expirées
- Enregistre les actions dans les logs

### **Commandes utiles :**
```bash
# Vérifier l'état des restrictions
php artisan restrictions:check-expired

# Voir les logs
tail -f storage/logs/restrictions.log
```

## 🎨 Interface utilisateur

### **Page d'administration :**
- Statistiques en temps réel
- Formulaire de création de restriction
- Liste des restrictions actives
- Actions en lot
- Filtres et recherche

### **Fonctionnalités :**
- ✅ Sélection multiple
- ✅ Filtres avancés
- ✅ Modals pour les actions
- ✅ Notifications en temps réel
- ✅ Design responsive

## 🔧 Dépannage

### **Problèmes courants :**

1. **Restriction non appliquée** :
   - Vérifier que l'utilisateur est un entrepreneur approuvé
   - Contrôler les logs d'erreur

2. **Email non envoyé** :
   - Vérifier la configuration SMTP
   - Contrôler les logs de mail

3. **Nettoyage automatique ne fonctionne pas** :
   - Vérifier la configuration cron
   - Exécuter manuellement la commande

## 📞 Support

Pour toute question ou problème :
1. Vérifier les logs dans `storage/logs/`
2. Consulter la documentation Laravel
3. Contacter l'équipe de développement

---

**Version :** 1.0  
**Dernière mise à jour :** Janvier 2025  
**Auteur :** Équipe EatDrink 