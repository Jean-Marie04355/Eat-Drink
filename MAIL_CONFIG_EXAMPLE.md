# 📧 Configuration Email - EatDrink

## 🔧 Configuration Gmail SMTP

### **Étapes pour configurer Gmail :**

1. **Activez l'authentification à 2 facteurs** sur votre compte Google
2. **Générez un mot de passe d'application** :
   - Allez dans les paramètres de votre compte Google
   - Sécurité → Authentification à 2 facteurs
   - Mots de passe d'application → Générer
   - Sélectionnez "Autre" et nommez-le "EatDrink"
   - Copiez le mot de passe généré (16 caractères)

3. **Ajoutez ces lignes à votre fichier `.env`** :

```env
# Configuration Email Gmail
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=oktcjean@gmail.com
MAIL_PASSWORD=votre_mot_de_passe_d_application_ici
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=oktcjean@gmail.com
MAIL_FROM_NAME="EatDrink"
```

### **Configuration alternative pour les tests :**

Si vous voulez tester sans configurer Gmail, utilisez le driver "log" :

```env
# Configuration Email pour tests (logs)
MAIL_MAILER=log
MAIL_LOG_CHANNEL=mail
```

Les emails seront alors enregistrés dans `storage/logs/laravel.log` au lieu d'être envoyés.

### **Vérification de la configuration :**

```bash
# Tester l'envoi d'email
php artisan tinker
Mail::raw('Test email', function($message) { $message->to('test@example.com')->subject('Test'); });
```

### **Problèmes courants :**

1. **Erreur 535** : Mauvais mot de passe d'application
2. **Erreur 530** : Authentification à 2 facteurs non activée
3. **Erreur de connexion** : Vérifiez MAIL_HOST et MAIL_PORT

### **Solutions alternatives :**

1. **Mailgun** (gratuit pour 5000 emails/mois)
2. **SendGrid** (gratuit pour 100 emails/jour)
3. **Postmark** (payant mais fiable)

### **Configuration Mailgun (recommandé) :**

```env
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=votre-domaine.mailgun.org
MAILGUN_SECRET=votre-clé-secrète
```

---

**Note :** Pour le développement, le driver "log" est recommandé car il évite les problèmes de configuration SMTP. 