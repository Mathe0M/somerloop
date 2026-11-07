# somerloop.fr

Site de la marque Somerloop, en Astro (pages statiques) avec un formulaire PHP pour o2switch.

## Démarrer

```bash
npm install
npm run dev      # http://localhost:4321
npm run build    # génère dist/
npm run preview  # prévisualise dist/ (le formulaire PHP ne fonctionne qu'en ligne)
```

## Où modifier quoi

| Besoin | Fichier |
| --- | --- |
| E-mail, nom, mentions légales, Matomo | `src/config.ts` |
| Couleurs, typographies, boutons | `src/styles/global.css` (variables en haut du fichier) |
| Logo | `src/components/Logo.astro` et `public/favicon.svg` |
| Textes des 5 prestations (prix, FAQ, étapes) | `src/content/prestations/*.md` |
| Menu | `NAV` dans `src/config.ts` |
| Autres pages | `src/pages/*.astro` |
| Formulaire (destinataire, anti-spam) | `public/contact.php` |
| Sécurité, HTTPS, cache | `public/.htaccess` |

Pour ajouter une prestation : dupliquer un fichier de `src/content/prestations/`, changer `order`, puis ajouter le lien dans `Footer.astro` et l'option dans `contact.astro` + `contact.php`.

## À compléter avant la mise en ligne

- [ ] `src/config.ts` : nom complet, statut, SIRET, adresse, assureur RC Pro, photo, LinkedIn
- [ ] Vérifier les coordonnées de l'hébergeur dans `src/config.ts`
- [ ] Faire relire les CGV (`src/pages/cgv.astro`) et retirer le bandeau « Brouillon »
- [ ] Créer l'adresse `contact@somerloop.fr` et l'alias `formulaire@somerloop.fr`
- [ ] Faire valider par la direction de Work&You les réalisations citées
- [ ] Déposer la photo dans `public/images/` et renseigner `founderPhoto`
- [ ] Remplacer `public/og-image.png` si besoin (image de partage 1200 × 630)
- [ ] Renseigner l'URL Matomo dans `src/config.ts` (et l'ajouter à la CSP du `.htaccess` si autre domaine)
- [ ] Choisir PHP 8.1 ou plus dans le cPanel o2switch

## Déploiement

Chaque push sur `main` construit le site et l'envoie en FTPS sur o2switch (`.github/workflows/deploy.yml`).
Créer les secrets `FTP_SERVER`, `FTP_USERNAME` et `FTP_PASSWORD` dans GitHub. Utiliser un compte FTP limité au dossier du site.

Après la mise en ligne : déclarer `https://somerloop.fr/sitemap-index.xml` dans Google Search Console.

## Charte

- Encre `#101828`, fond `#fbfaf7`, orange « boost » `#ff6a3d` (boutons, texte foncé dessus), orange lisible `#b93a0e` (liens), violet « boucle » `#5b3fd6` (pictos).
- Titres : Space Grotesk. Texte : Inter. Polices auto-hébergées (aucun appel à Google Fonts).
- Pictogrammes au trait (style Lucide) dans `src/components/Icon.astro`.
