# Procédure — Lien LDAP Active Directory sur GLPI
Serveur GLPI : 172.16.0.4 | AD : LABANNU1 172.16.0.105  
Date : Mai 2026

---

## Sommaire

1. [Prérequis](#1-prérequis)
2. [Créer le compte de service sur LABANNU1](#2-créer-le-compte-de-service-sur-labannu1)
3. [Configurer le lien LDAP dans GLPI](#3-configurer-le-lien-ldap-dans-glpi)
4. [Configurer l'import des utilisateurs](#4-configurer-limport-des-utilisateurs)
5. [Importer les utilisateurs depuis l'AD](#5-importer-les-utilisateurs-depuis-lad)
6. [Configurer l'authentification LDAP](#6-configurer-lauthentification-ldap)
7. [Tests de validation](#7-tests-de-validation)
8. [Tableau récapitulatif des paramètres LDAP](#8-tableau-récapitulatif-des-paramètres-ldap)

---

## 1. Prérequis

### 1.1 Vérifications avant de commencer

| Élément | Valeur | Statut |
|---|---|---|
| GLPI installé et accessible | `http://172.16.0.4` | Fait |
| LABANNU1 joignable depuis GLPI | `172.16.0.105:389` | À vérifier |
| PHP-LDAP installé sur le serveur GLPI | `php-ldap` | À vérifier |
| Compte de service AD | `svc-glpi@gsb.local` | À créer (section 2) |

### 1.2 Vérifier que php-ldap est installé sur le serveur GLPI

Sur le serveur GLPI (172.16.0.4) :

```bash
php -m | grep ldap
# → doit retourner "ldap"
```

Si absent :

```bash
apt install -y php-ldap
systemctl restart apache2
```

### 1.3 Vérifier la connectivité réseau vers LABANNU1

```bash
# Depuis le serveur GLPI
ping -c 3 172.16.0.105

# Tester le port LDAP 389
nc -zv 172.16.0.105 389
# → Connection to 172.16.0.105 389 port [tcp/ldap] succeeded!
```

---

## 2. Créer le compte de service sur LABANNU1

> À faire sur le serveur Windows AD LABANNU1.

### 2.1 Créer le compte `svc-glpi` dans l'AD

Sur LABANNU1, ouvrir **Utilisateurs et ordinateurs Active Directory** :

1. Clic droit sur l'OU souhaitée (ex: `Utilisateurs de service`) → **Nouveau** → **Utilisateur**
2. Remplir :
   - Prénom : `Service`
   - Nom : `GLPI`
   - Nom de connexion : `svc-glpi`
3. Mot de passe : définir un mot de passe complexe et noter le
4. Cocher **Le mot de passe n'expire jamais**
5. Décocher **L'utilisateur doit changer son mot de passe**

### 2.2 Droits du compte de service

Le compte `svc-glpi` doit avoir uniquement les droits en **lecture** sur l'annuaire :

- Il n'a **pas** besoin d'être administrateur du domaine
- Les droits par défaut d'un utilisateur du domaine suffisent pour lire l'annuaire
- Si des restrictions sont en place, ajouter `svc-glpi` au groupe **Lecture seule** de l'OU des utilisateurs GSB

### 2.3 Tester le compte depuis le serveur GLPI

```bash
# Depuis le serveur GLPI — tester le bind avec le compte de service
ldapsearch -x \
  -H ldap://172.16.0.105:389 \
  -D "svc-glpi@gsb.local" \
  -w "MotDePasseSvcGlpi" \
  -b "DC=gsb,DC=local" \
  -s sub \
  "(objectClass=user)" \
  sAMAccountName mail displayName | head -40
```

> Un résultat non vide confirme que le compte fonctionne.

---

## 3. Configurer le lien LDAP dans GLPI

Toute la configuration se fait depuis l'**interface web de GLPI**.

### 3.1 Accéder à la configuration LDAP

1. Se connecter à GLPI avec un compte **administrateur**
2. Menu **Configuration** → **Authentification**
3. Cliquer sur **Annuaires LDAP**
4. Cliquer sur **Ajouter**

### 3.2 Paramètres de connexion

Remplir le formulaire avec les valeurs suivantes :

| Champ | Valeur |
|---|---|
| **Nom** | `AD GSB - LABANNU1` |
| **Serveur par défaut** | Oui |
| **Actif** | Oui |
| **Serveur** | `172.16.0.105` |
| **Port** | `389` |
| **Utiliser TLS** | Non (réseau interne GSB) |
| **BaseDN** | `DC=gsb,DC=local` |
| **Filtre de connexion** | `(&(objectClass=user)(!(userAccountControl:1.2.840.113556.1.4.803:=2)))` |
| **Login** | `svc-glpi@gsb.local` |
| **Mot de passe** | `MotDePasseSvcGlpi` |
| **Identifiant** | `samaccountname` |
| **Mot de passe** | *(laisser vide — auth déléguée à l'AD)* |
| **Nom** | `sn` |
| **Prénom** | `givenname` |
| **Email** | `mail` |
| **Téléphone** | `telephonenumber` |
| **Champ de synchro** | `objectguid` |

> `objectguid` est l'identifiant unique stable dans l'AD Windows — même si le `sAMAccountName` change, l'utilisateur reste lié dans GLPI.

### 3.4 Tester la connexion

En bas du formulaire, cliquer sur **Tester** :

- Une icône verte confirmera que GLPI joint bien LABANNU1
- En cas d'erreur, vérifier l'IP, le port, et les credentials du compte de service

### 3.5 Sauvegarder

Cliquer sur **Ajouter** pour enregistrer la configuration.

---

### 5 Vérifier l'import

Après l'import :

1. Menu **Administration** → **Utilisateurs**
2. Les comptes AD doivent apparaître avec la source `LDAP`
3. Vérifier qu'un utilisateur a bien son nom, prénom et email renseignés

---

## 6. Configurer l'authentification LDAP

Une fois les utilisateurs importés, configurer GLPI pour qu'il délègue l'authentification à l'AD.

### 6.1 Vérifier le mode d'authentification

1. Menu **Configuration** → **Authentification**
2. Onglet **Configuration**
3. Vérifier que **Méthode d'authentification par défaut** est bien `LDAP`

### 6.2 Fonctionnement de l'authentification

Quand un utilisateur se connecte à GLPI :

1. GLPI recherche le compte dans l'AD via `svc-glpi@gsb.local` (bind de service)
2. GLPI effectue un **bind direct** avec le login/mot de passe saisi par l'utilisateur
3. Si l'AD valide → connexion autorisée
4. Si l'AD refuse → connexion refusée (compte désactivé, mauvais mot de passe…)

> Le mot de passe n'est jamais stocké dans GLPI — c'est l'AD Windows qui fait foi.

### 6.3 Conserver un compte local administrateur

> **Important :** conserver au moins un compte **local GLPI** (non LDAP) avec les droits super-administrateur, en cas d'indisponibilité de LABANNU1.

Vérifier que le compte `glpi` (ou équivalent) est bien un compte local :
- Menu **Administration** → **Utilisateurs** → chercher `glpi`
- Source d'authentification : doit être `Locale` et non `LDAP`

---

## 7. Tests de validation

### 7.1 Test de connexion avec un compte AD

1. Se déconnecter de GLPI
2. Se reconnecter avec un compte AD : login = `sAMAccountName` (ex: `f.lebatteur`), mot de passe AD
3. La connexion doit réussir
4. Vérifier que les informations du profil (nom, prénom, email) sont bien renseignées

### 7.2 Test de refus sur compte désactivé

1. Demander à Théo & Valentin de désactiver temporairement un compte test dans l'AD
2. Tenter de se connecter à GLPI avec ce compte
3. La connexion doit être **refusée**
4. Réactiver le compte ensuite

### 7.3 Test de synchronisation

1. Demander à Théo & Valentin de modifier le mail d'un utilisateur dans l'AD
2. Lancer une synchronisation manuelle : **Administration** → **Utilisateurs** → **Lien LDAP** → **Synchroniser les utilisateurs existants**
3. Vérifier que le nouveau mail est bien répercuté dans GLPI

### 7.4 Test de tolérance à la panne

1. Vérifier que le compte local administrateur fonctionne toujours en cas d'indisponibilité de LABANNU1
2. Ce compte doit permettre d'administrer GLPI sans dépendance à l'AD

---

## 8. Tableau récapitulatif des paramètres LDAP

| Paramètre | Valeur |
|---|---|
| Serveur LDAP | `172.16.0.105` |
| Port | `389` |
| BaseDN | `DC=gsb,DC=local` |
| Compte de service | `svc-glpi@gsb.local` |
| Attribut login | `samaccountname` |
| Attribut email | `mail` |
| Attribut nom | `sn` |
| Attribut prénom | `givenname` |
| Attribut synchro | `objectguid` |
| Filtre connexion | `(&(objectClass=user)(!(userAccountControl:...=2)))` |
| Filtre import | `(&(objectClass=user)(mail=*)(!(userAccountControl:...=2)))` |

---

## Annexe — Dépannage

```bash
# Tester manuellement le bind de service depuis le serveur GLPI
ldapsearch -x -H ldap://172.16.0.105:389 \
  -D "svc-glpi@gsb.local" -w "MotDePasse" \
  -b "DC=gsb,DC=local" "(sAMAccountName=f.lebatteur)" \
  sAMAccountName mail sn givenName

# Vérifier que php-ldap est bien chargé
php -r "echo ldap_connect('172.16.0.105') ? 'OK' : 'KO';"

# Logs Apache (erreurs GLPI)
tail -f /var/log/apache2/error.log
```

**Erreurs fréquentes :**

| Erreur | Cause probable | Solution |
|---|---|---|
| `Can't contact LDAP server` | LABANNU1 injoignable | Vérifier ping + port 389 |
| `Invalid credentials` | Mauvais mot de passe svc-glpi | Vérifier le mot de passe sur LABANNU1 |
| `No such object` | BaseDN incorrect | Vérifier `DC=gsb,DC=local` |
| Utilisateurs non importés | Filtre trop restrictif | Vérifier le filtre d'import |
| Auth refusée à la connexion | Compte désactivé dans l'AD | Vérifier dans l'AD avec Théo & Valentin |

---

*Document réalisé dans le cadre du projet GSB — BTS SIO option SISR*  
*GLPI : 172.16.0.4 | AD : LABANNU1 172.16.0.105*  
