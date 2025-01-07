# Switch

## 1 - Configuration PuTTY

- 9600 8 N 1
- Chercher le COM dans le gestionnaire de périphérique ( Prolific USB-to-Serial Comm Port )
- Lancer la machine avec PuTTY

## 2 - Configuration du switch CISCO

- ```Would you like to enter the initial configuration dialog? [yes/no]: no ``` 
- Tapez ``` enable ``` pour passer en mode priviligié
- Tapez ``` configure terminal ```  pour pouvoir configurer le switch

### Sauvergarder sa config-text
- ``` copy running-config startup-config ```
- ou ``` copy run start ```
- ou ``` wr ``` (plus rapide)

### Réinitialiser le switch

## 3 - Supprimer les fichiers de configuration
Supprimer le ``` vlan.dat ``` :
- Tapez ``` delete flash:vlan.dat ```
- 🛑 NE SURTOUT PAS TAPER ``` delete flash: ``` 🛑

Puis supprimer le ``` config.text ``` :
- Tapez ``` erase startup_config ```

Puis relancer le switch :
- Tapez ``` reload ```
- Ici ``` System configuration has been modified. Save? [yes/no] ``` tapez ``` no ```

## 4 - Réinitialiser le switch si inacessible

- Appuyer sur le bouton, en même temps le débrancher puis rebrancher
- Quand ``` The password-recovery mechanism is enabled. ``` est affiché, on peut relacher le bouton
- Quand ```switch: ``` est affiché, tapez (dans l'ordre) ``` flash_init ```
- Tapez ``` dir flash: ``` pour voir le contenu de la mémoire flash
- Et supprimer ``` vlan.dat ``` en tapant ``` del flash:vlan.dat ```
- Puis supprimer ``` config.text ``` en tapant ``` del flash:config.text ```
- Tapez ``` boot ``` pour initialiser le switch












