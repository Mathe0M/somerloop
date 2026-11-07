/**
 * Paramètres du site, à un seul endroit.
 * Les valeurs marquées « À COMPLÉTER » doivent être renseignées avant la mise en ligne.
 */
export const SITE = {
  name: 'Somerloop',
  url: 'https://somerloop.fr',
  tagline: 'Des outils sur mesure pour les PME qui grandissent vite',
  description:
    "Somerloop conçoit des logiciels métier sur mesure, automatise et connecte les outils des PME en croissance. Agen, Toulouse et toute la France.",
  email: 'contact@somerloop.fr',
  phone: '', // ex. '06 00 00 00 00' — laisser vide pour ne pas l'afficher
  linkedin: '', // URL du profil LinkedIn

  // Porteur de projet
  founder: 'Mathéo', // À COMPLÉTER : prénom et nom tels qu'ils doivent apparaître
  founderPhoto: '', // ex. '/images/portrait.jpg' (déposer le fichier dans public/images/)

  // Mentions légales — À COMPLÉTER
  legal: {
    fullName: '[Prénom Nom]',
    status: 'Entrepreneur individuel (micro-entreprise)', // à confirmer
    siret: '[SIRET]',
    address: '[Adresse postale]',
    vat: 'TVA non applicable, article 293 B du CGI', // à supprimer si assujetti
    insurer: '[Assureur RC Pro — nom et zone couverte]',
  },

  host: {
    name: 'O2SWITCH',
    address: 'Chemin des Pardiaux, 63000 Clermont-Ferrand, France',
    phone: '04 44 44 60 40',
    url: 'https://www.o2switch.fr',
  },

  // Mesure d'audience Matomo sans cookie — laisser vide pour désactiver
  matomo: {
    url: '', // ex. 'https://stats.somerloop.fr/'
    siteId: '1',
  },

  areas: ['Agen', 'Toulouse', 'Lot-et-Garonne', 'Occitanie', 'France entière (à distance)'],
};

export const NAV = [
  { href: '/prestations/', label: 'Prestations' },
  { href: '/realisations/', label: 'Réalisations' },
  { href: '/parcours/', label: 'Parcours' },
  { href: '/faq/', label: 'Ressources' },
];
