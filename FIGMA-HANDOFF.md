# Figma / Claude Handoff

## Project type

This is not a Tailwind project.

Use these files as the source of truth instead:

- `DESIGN-SYSTEM.md`
- `assets/css/custom.css`
- `style.css`
- homepage screenshots in `transport/pliki podgladow/`

Project stack:

- WordPress
- Kadence theme
- Kadence child theme
- custom CSS in `assets/css/custom.css`

## Workflow note

Figma is not the deployment source.

The deployment source is the GitHub repository.

That means:

- design decisions can start in Figma
- `DESIGN-SYSTEM.md` and `design-tokens.json` should be updated when the system changes
- WordPress changes only after code is committed and pushed
- `WP Pusher` should pull from GitHub, not from Figma directly

## Current design direction

We are rebuilding the homepage away from the original starter template and toward a more premium museum-editorial direction.

Keywords:

- bold typography
- editorial rhythm
- architectural imagery
- restrained white space
- confident orange accent

## Important homepage changes

### Hero

- keep only the staircase image
- remove the lower stacked image
- make the headline more dominant
- improve balance between copy and image

### Orange cards

- all cards should be fully clickable
- all cards should link to `https://deepbrand.ing/`
- hover should feel tactile
- use subtle press effect and shadow shift

### Middle sections

- tighten spacing rhythm
- reduce the "builder-template" feeling
- keep asymmetry, but make it feel composed

### Bottom of homepage

- stronger closing CTA
- better ending rhythm
- footer should feel intentional

## Design tokens

See `design-tokens.json` for exact values.

## Components to design in Figma

1. Header / top navigation
2. Homepage hero
3. Orange linked card row
4. Editorial image + text section
5. Address / facts mini section
6. Final CTA section
7. Footer

## Typography guidance

- Display font: `Bricolage Grotesque`
- Body font: `Inter`
- Headings should feel assertive and curated
- Body text should remain calm and readable
- Small labels should be understated and consistent

## What not to do

- do not design it like a SaaS landing page
- do not overuse rounded gradients or trendy startup effects
- do not make animations flashy
- do not rebuild the color palette from scratch

## Best prompt for Claude in Figma

Use the files `DESIGN-SYSTEM.md`, `design-tokens.json`, `assets/css/custom.css`, and the homepage screenshots as the source of truth.

Create a homepage redesign for a design heritage / architecture culture website.

Keep:

- the orange accent
- the current button family as a starting point
- the editorial minimal layout language
- the staircase image in the hero

Change:

- strengthen typography hierarchy
- redesign the hero layout
- redesign the orange cards as premium linked components
- improve spacing rhythm in the middle sections
- create a more intentional final CTA and footer ending

The output should feel museum-editorial, premium, and less like a WordPress starter template.
