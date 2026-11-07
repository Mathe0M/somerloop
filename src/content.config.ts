import { defineCollection, z } from 'astro:content';
import { glob } from 'astro/loaders';

const prestations = defineCollection({
  loader: glob({ pattern: '**/*.md', base: './src/content/prestations' }),
  schema: z.object({
    title: z.string(),          // titre affiché (H1)
    seoTitle: z.string(),       // balise <title>
    description: z.string(),    // meta description
    keyword: z.string(),        // requête principale visée
    order: z.number(),
    icon: z.string(),
    short: z.string(),          // accroche des cartes
    badge: z.string().optional(),
    price: z.string(),
    duration: z.string(),
    format: z.string(),
    forWho: z.array(z.string()),
    deliverables: z.array(z.string()),
    steps: z.array(z.object({ title: z.string(), text: z.string() })),
    faq: z.array(z.object({ q: z.string(), a: z.string() })),
  }),
});

export const collections = { prestations };
